import gsap from "gsap";

const COLLAPSED_LINES = 4;
const TOGGLE_THRESHOLD_LINES = 6;
const EXPANDED_CLASS = "--expanded";
const COLLAPSIBLE_CLASS = "--collapsible";

const reducedMotion = (): boolean =>
  window.matchMedia("(prefers-reduced-motion: reduce)").matches;

const getLinesHeight = (content: HTMLElement, lines: number): number => {
  const styles = window.getComputedStyle(content);
  const lineHeight = Number.parseFloat(styles.lineHeight);
  if (Number.isFinite(lineHeight)) return lineHeight * lines;
  const fontSize = Number.parseFloat(styles.fontSize) || 16;
  return fontSize * 1.5 * lines;
};

const equalizeFrames = new WeakMap<HTMLElement, number>();

const equalizeCollapsedCards = (section: HTMLElement): void => {
  const columns = Array.from(section.querySelectorAll<HTMLElement>(".a-card-item"));
  const rows = new Map<number, HTMLElement[]>();

  columns.forEach((column) => {
    const card = column.querySelector<HTMLElement>(".od-info-card");
    if (!card) return;

    card.style.minHeight = "";
    const isExpanded = card.querySelector<HTMLElement>(
      "[data-info-card-description].--expanded",
    );
    if (isExpanded) return;

    const rowTop = Math.round(column.offsetTop);
    const row = rows.get(rowTop) || [];
    row.push(card);
    rows.set(rowTop, row);
  });

  rows.forEach((cards) => {
    const rowHeight = Math.max(...cards.map((card) => card.getBoundingClientRect().height));
    cards.forEach((card) => {
      card.style.minHeight = String(rowHeight) + "px";
    });
  });
};

const scheduleEqualize = (root: HTMLElement): void => {
  const section = root.closest<HTMLElement>(".od-info");
  if (!section) return;

  const pendingFrame = equalizeFrames.get(section);
  if (pendingFrame) window.cancelAnimationFrame(pendingFrame);

  const nextFrame = window.requestAnimationFrame(() => {
    equalizeCollapsedCards(section);
    equalizeFrames.delete(section);
  });
  equalizeFrames.set(section, nextFrame);
};

const initDescription = (root: HTMLElement): void => {
  if (root.dataset.infoCardDescriptionInitialized === "true") return;

  const content = root.querySelector<HTMLElement>("[data-info-card-description-content]");
  const button = root.querySelector<HTMLButtonElement>("[data-info-card-description-toggle]");
  const icon = button?.querySelector<SVGElement>("svg");
  const card = root.closest<HTMLElement>(".od-info-card");
  if (!content || !button || !icon || !card) return;

  let expanded = false;

  const setAccessibleState = (): void => {
    button.setAttribute("aria-expanded", String(expanded));
    const title =
      card.querySelector("h3")?.textContent?.trim() ||
      "kafelka";
    button.setAttribute("aria-label", (expanded ? "Zwiń" : "Rozwiń") + " opis: " + title);
  };

  const measure = (): void => {
    gsap.killTweensOf([content, icon]);
    gsap.set(content, { height: "auto" });

    const collapsedHeight = getLinesHeight(content, COLLAPSED_LINES);
    const toggleThresholdHeight = getLinesHeight(content, TOGGLE_THRESHOLD_LINES);
    const isLong = content.scrollHeight > toggleThresholdHeight + 1;
    root.classList.toggle(COLLAPSIBLE_CLASS, isLong);
    button.hidden = !isLong;

    if (!isLong) {
      expanded = false;
      root.classList.remove(EXPANDED_CLASS);
      card.classList.remove("--description-expanded");
      gsap.set(icon, { rotation: 0 });
      setAccessibleState();
      return;
    }

    gsap.set(content, { height: expanded ? "auto" : collapsedHeight });
    gsap.set(icon, { rotation: expanded ? 180 : 0 });
  };

  button.addEventListener("click", () => {
    const collapsedHeight = getLinesHeight(content, COLLAPSED_LINES);
    const currentHeight = content.getBoundingClientRect().height;
    expanded = !expanded;
    root.classList.toggle(EXPANDED_CLASS, expanded);
    card.classList.toggle("--description-expanded", expanded);
    setAccessibleState();

    gsap.killTweensOf([content, icon]);
    gsap.set(content, { height: currentHeight });
    gsap.to(content, {
      height: expanded ? content.scrollHeight : collapsedHeight,
      duration: reducedMotion() ? 0 : 0.45,
      ease: "power2.inOut",
      onComplete: () => {
        if (expanded) {
          gsap.set(content, { height: "auto" });
        } else {
          scheduleEqualize(root);
        }
      },
    });
    gsap.to(icon, {
      rotation: expanded ? 180 : 0,
      duration: reducedMotion() ? 0 : 0.35,
      ease: "power2.inOut",
    });
  });

  let observedWidth = root.getBoundingClientRect().width;
  const observer = new ResizeObserver((entries) => {
    const nextWidth = entries[0]?.contentRect.width ?? observedWidth;
    if (Math.abs(nextWidth - observedWidth) < 0.5) return;

    observedWidth = nextWidth;
    window.requestAnimationFrame(() => {
      measure();
      scheduleEqualize(root);
    });
  });
  observer.observe(root);
  window.addEventListener(
    "load",
    () => {
      measure();
      scheduleEqualize(root);
    },
    { once: true },
  );

  root.dataset.infoCardDescriptionInitialized = "true";
  setAccessibleState();
  measure();
  scheduleEqualize(root);
};

export const initInfoCardDescriptions = (root: ParentNode = document): void => {
  root.querySelectorAll<HTMLElement>("[data-info-card-description]").forEach(initDescription);
};