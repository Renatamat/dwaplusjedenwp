const MOBILE_HEADER_BREAKPOINT = 1200;
const SUBMENU_OPEN_CLASS = "open";
const NAVIGATION_OPEN_CLASS = "open";

const isMobileHeader = (): boolean => {
  return typeof window !== "undefined" && window.innerWidth < MOBILE_HEADER_BREAKPOINT;
};

const closestElement = <T extends Element>(target: EventTarget | null, selector: string): T | null => {
  if (!(target instanceof Element)) return null;
  return target.closest<T>(selector);
};

const closeOpenSubmenus = (root: ParentNode = document): void => {
  root.querySelectorAll<HTMLElement>(`.sub-menu.${SUBMENU_OPEN_CLASS}`).forEach((submenu) => {
    submenu.classList.remove(SUBMENU_OPEN_CLASS);
  });
};

export const initHeader = (): void => {
  if (typeof document === "undefined") return;

  document.addEventListener("click", (event) => {
    if (!isMobileHeader()) return;

    const hamburger = closestElement<HTMLElement>(event.target, ".menu-hamburger");
    if (hamburger) {
      const header = hamburger.closest<HTMLElement>(".site-header");
      const navigation = header?.querySelector<HTMLElement>(".main-navigation");
      navigation?.classList.add(NAVIGATION_OPEN_CLASS);
      return;
    }

    const closeButton = closestElement<HTMLElement>(event.target, ".mobile-header-close");
    if (closeButton) {
      const navigation = closeButton.closest<HTMLElement>(".main-navigation");
      navigation?.classList.remove(NAVIGATION_OPEN_CLASS);
      if (navigation) {
        closeOpenSubmenus(navigation);
      }
      return;
    }

    const backButton = closestElement<HTMLElement>(event.target, ".mobile-back");
    if (backButton) {
      event.preventDefault();
      event.stopPropagation();

      const submenu = backButton.closest<HTMLElement>(".sub-menu");
      submenu?.classList.remove(SUBMENU_OPEN_CLASS);
      return;
    }

    const submenuButton = closestElement<HTMLElement>(event.target, ".mobile-button-submenu");
    if (submenuButton) {
      const menuItem = submenuButton.closest<HTMLElement>(".menu-item-has-children");
      if (!menuItem) return;

      const submenu = menuItem.querySelector<HTMLElement>(":scope > .sub-menu");
      if (!submenu) return;

      closeOpenSubmenus(menuItem.closest(".main-navigation") ?? document);
      submenu.classList.add(SUBMENU_OPEN_CLASS);
      return;
    }
  });

  window.addEventListener("resize", () => {
    if (isMobileHeader()) return;
    document.querySelectorAll<HTMLElement>(`.main-navigation.${NAVIGATION_OPEN_CLASS}`).forEach((navigation) => {
      navigation.classList.remove(NAVIGATION_OPEN_CLASS);
    });
    closeOpenSubmenus();
  });
};
