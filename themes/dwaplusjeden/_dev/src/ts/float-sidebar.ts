import FloatSidebar from "./helpers/float-sidebar/src/float-sidebar";

const defaultTopSpacing = 20;
const defaultBottomSpacing = 20;
const defaultMinWidth = 992;

type FloatSidebarInstance = ReturnType<typeof FloatSidebar>;

type FloatSidebarState = {
  sidebar: HTMLElement;
  relative: HTMLElement;
  topSpacing: number;
  bottomSpacing: number;
  minWidth: number;
  instance: FloatSidebarInstance | null;
};

const floatSidebars: FloatSidebarState[] = [];
let resizeHandlerBound = false;

const parseSpacing = (value: string | undefined, fallback: number): number => {
  if (!value) return fallback;
  const parsed = Number.parseInt(value, 10);
  return Number.isNaN(parsed) ? fallback : parsed;
};

const clearSidebarStyles = (sidebar: HTMLElement): void => {
  const sidebarInner = sidebar.firstElementChild as HTMLElement | null;

  sidebar.style.height = "";
  sidebar.style.willChange = "";

  if (!sidebarInner) return;

  sidebarInner.style.width = "";
  sidebarInner.style.transform = "";
  sidebarInner.style.willChange = "";
};

const updateFloatSidebarState = (state: FloatSidebarState): void => {
  const shouldBeActive = window.innerWidth >= state.minWidth;

  if (shouldBeActive && !state.instance) {
    state.instance = FloatSidebar({
      sidebar: state.sidebar,
      relative: state.relative,
      topSpacing: state.topSpacing,
      bottomSpacing: state.bottomSpacing,
    });
    return;
  }

  if (!shouldBeActive && state.instance) {
    state.instance.destroy();
    state.instance = null;
    clearSidebarStyles(state.sidebar);
  }
};

export const initFloatSidebars = (): void => {
  const sidebars = document.querySelectorAll<HTMLElement>("[data-float-sidebar]");

  sidebars.forEach((sidebar) => {
    if (sidebar.dataset.floatSidebarInitialized === "true") return;

    const wrapper = sidebar.closest<HTMLElement>("[data-float-sidebar-wrapper]");
    const relative = wrapper?.querySelector<HTMLElement>("[data-float-sidebar-relative]") ?? null;

    if (!relative) return;

    const topSpacing = parseSpacing(wrapper?.dataset.floatSidebarTopSpacing, defaultTopSpacing);
    const bottomSpacing = parseSpacing(wrapper?.dataset.floatSidebarBottomSpacing, defaultBottomSpacing);
    const minWidth = parseSpacing(wrapper?.dataset.floatSidebarMinWidth, defaultMinWidth);

    const state: FloatSidebarState = {
      sidebar,
      relative,
      topSpacing,
      bottomSpacing,
      minWidth,
      instance: null,
    };

    floatSidebars.push(state);
    updateFloatSidebarState(state);
    sidebar.dataset.floatSidebarInitialized = "true";
  });

  if (resizeHandlerBound) return;

  window.addEventListener("resize", () => {
    floatSidebars.forEach(updateFloatSidebarState);
  });

  resizeHandlerBound = true;
};
