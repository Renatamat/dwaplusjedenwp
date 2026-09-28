export const initFooterFixedbox = (): void => {
  document.querySelectorAll<HTMLElement>(".footer-fixedbox").forEach((banner) => {
    const closeButton = banner.querySelector<HTMLButtonElement>(".footer-fixedbox-close");

    if (!closeButton || closeButton.dataset.initialized === "true") return;

    closeButton.dataset.initialized = "true";
    closeButton.addEventListener("click", () => {
      banner.hidden = true;
    });
  });
};
