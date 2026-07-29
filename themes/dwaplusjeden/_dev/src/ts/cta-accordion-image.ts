const DESKTOP_QUERY = "(min-width: 992px)";

const getOpenAccordionHeight = (section: HTMLElement): number =>
  Array.from(
    section.querySelectorAll<HTMLElement>(
      ".od-cta-accordion .accordion-collapse.show, " +
        ".od-cta-accordion .accordion-collapse.collapsing",
    ),
  ).reduce((height, panel) => height + panel.getBoundingClientRect().height, 0);

const initCtaAccordionImage = (wrapper: HTMLElement): void => {
  if (wrapper.dataset.ctaAccordionImageInitialized === "true") return;

  const section = wrapper.closest<HTMLElement>(".od-cta");
  const column = wrapper.parentElement;
  if (!section || !column) return;

  const desktop = window.matchMedia(DESKTOP_QUERY);
  let observedWidth = column.getBoundingClientRect().width;
  let initialHeightRatio: number | null = null;
  let measureFrame = 0;

  const measure = (refreshInitialRatio = false): void => {
    window.cancelAnimationFrame(measureFrame);

    if (!desktop.matches) {
      wrapper.style.height = "";
      return;
    }

    const columnWidth = column.getBoundingClientRect().width;
    const canRefreshInitialRatio =
      refreshInitialRatio && getOpenAccordionHeight(section) === 0;

    if (canRefreshInitialRatio) {
      initialHeightRatio = null;
    }

    if (initialHeightRatio !== null && columnWidth > 0) {
      wrapper.style.height =
        String(Math.round(columnWidth * initialHeightRatio)) + "px";
      return;
    }

    wrapper.style.height = "";

    measureFrame = window.requestAnimationFrame(() => {
      const stretchedHeight = wrapper.getBoundingClientRect().height;
      const openAccordionHeight = getOpenAccordionHeight(section);
      const initialHeight = Math.max(1, stretchedHeight - openAccordionHeight);
      const measuredWidth = column.getBoundingClientRect().width;

      if (measuredWidth > 0) {
        initialHeightRatio = initialHeight / measuredWidth;
      }

      wrapper.style.height = String(Math.round(initialHeight)) + "px";
    });
  };

  const resizeObserver = new ResizeObserver((entries) => {
    const nextWidth = entries[0]?.contentRect.width ?? observedWidth;
    if (Math.abs(nextWidth - observedWidth) < 0.5) return;

    observedWidth = nextWidth;
    measure();
  });

  resizeObserver.observe(column);
  desktop.addEventListener("change", () => measure(true));
  window.addEventListener("load", () => measure(true), { once: true });

  if (document.fonts?.ready) {
    document.fonts.ready.then(() => measure(true));
  }

  wrapper.dataset.ctaAccordionImageInitialized = "true";
  measure();
};

export const initCtaAccordionImages = (root: ParentNode = document): void => {
  root
    .querySelectorAll<HTMLElement>(".od-cta .ob-cta")
    .forEach(initCtaAccordionImage);
};