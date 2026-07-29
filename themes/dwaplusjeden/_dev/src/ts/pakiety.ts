const ACTIVE_CLASS = "--active";

type GsapLike = {
  fromTo: (
    targets: Element[],
    fromVars: Record<string, unknown>,
    toVars: Record<string, unknown>,
  ) => unknown;
  killTweensOf: (targets: Element[]) => void;
};

type ScrollTriggerLike = {
  refresh: () => void;
};

const getGsap = (): GsapLike | undefined => {
  if (typeof window === "undefined") return undefined;

  return (window as unknown as { gsap?: GsapLike }).gsap;
};

const refreshScrollTriggers = (): void => {
  if (typeof window === "undefined") return;

  const scrollTrigger = (window as unknown as { ScrollTrigger?: ScrollTriggerLike }).ScrollTrigger;
  if (!scrollTrigger) return;

  window.requestAnimationFrame(() => {
    scrollTrigger.refresh();
  });
};

const updatePricingCardPrice = (card: HTMLElement): void => {
  const priceTarget = card.querySelector<HTMLElement>("[data-pricing-price]");
  const select = card.querySelector<HTMLSelectElement>("select[data-pricing-price-select]");

  if (!priceTarget || !select) return;

  const selectedOption = select.options[select.selectedIndex];
  const selectedPrice = selectedOption?.dataset.price || "";
  const fallbackPrice = card.dataset.pricingBasePrice || "";

  priceTarget.textContent = selectedPrice || fallbackPrice;
};

const bindPricingPriceSelects = (root: HTMLElement): void => {
  root.querySelectorAll<HTMLElement>("[data-pricing-card]").forEach((card) => {
    if (card.dataset.pricingPriceInitialized === "true") return;

    const select = card.querySelector<HTMLSelectElement>("select[data-pricing-price-select]");
    if (!select) return;

    select.addEventListener("change", () => {
      updatePricingCardPrice(card);
    });

    updatePricingCardPrice(card);
    card.dataset.pricingPriceInitialized = "true";
  });
};

const getAvailableOption = (root: HTMLElement, option: string | undefined): string | null => {
  if (option && root.querySelector<HTMLElement>(`.pakiety-content[data-option="${option}"]`)) {
    return option;
  }

  return root.querySelector<HTMLElement>(".pakiety-content[data-option]")?.dataset.option ?? null;
};

const animatePackageItems = (content: HTMLElement): void => {
  const gsap = getGsap();
  if (!gsap) return;

  const items = Array.from(content.querySelectorAll<HTMLElement>(".pakiety-content-item"));
  if (items.length === 0) return;

  gsap.killTweensOf(items);
  gsap.fromTo(
    items,
    {
      autoAlpha: 0,
      y: 28,
      force3D: true,
    },
    {
      autoAlpha: 1,
      y: 0,
      duration: 0.58,
      stagger: 0.12,
      ease: "power2.out",
      force3D: true,
      clearProps: "transform,opacity,visibility",
      onComplete: refreshScrollTriggers,
    },
  );
};

const setActivePackage = (root: HTMLElement, option: string, animate = false): void => {
  root.querySelectorAll<HTMLElement>(".pakiety-bar-item[data-option]").forEach((item) => {
    const isActive = item.dataset.option === option;
    item.classList.toggle(ACTIVE_CLASS, isActive);
    item.setAttribute("aria-selected", String(isActive));
  });

  root.querySelectorAll<HTMLElement>(".pakiety-content[data-option]").forEach((content) => {
    content.hidden = content.dataset.option !== option;
  });

  const activeContent = root.querySelector<HTMLElement>(`.pakiety-content[data-option="${option}"]`);
  if (animate && activeContent) {
    animatePackageItems(activeContent);
  }

  refreshScrollTriggers();
};

const bindPackageTabs = (root: HTMLElement): void => {
  if (root.dataset.pakietyInitialized === "true") return;

  bindPricingPriceSelects(root);

  root.querySelectorAll<HTMLElement>(".pakiety-bar-item[data-option]").forEach((item) => {
    item.setAttribute("role", "tab");
    item.setAttribute("tabindex", "0");

    item.addEventListener("click", () => {
      const option = getAvailableOption(root, item.dataset.option);
      if (!option) return;

      setActivePackage(root, option, true);
    });

    item.addEventListener("keydown", (event) => {
      if (event.key !== "Enter" && event.key !== " ") return;

      event.preventDefault();
      item.click();
    });
  });

  const activeItem = root.querySelector<HTMLElement>(`.pakiety-bar-item.${ACTIVE_CLASS}[data-option]`);
  const initialOption = getAvailableOption(root, activeItem?.dataset.option);
  if (initialOption) {
    setActivePackage(root, initialOption);
  }

  root.dataset.pakietyInitialized = "true";
};

export const initPakiety = (root: ParentNode = document): void => {
  root.querySelectorAll<HTMLElement>(".pakiety").forEach(bindPackageTabs);
};
