const OPEN_CLASS = "--open";
const OVERFLOW_VISIBLE_CLASS = "--overflow-visible";

type FormWrapState = {
  wrap: HTMLElement;
  header: HTMLElement;
  content: HTMLElement;
};

const states: FormWrapState[] = [];
let resizeHandlerBound = false;

const setContentHeight = (content: HTMLElement, isOpen: boolean): void => {
  content.style.maxHeight = isOpen ? `${content.scrollHeight}px` : "0px";
};

const setFormWrapState = ({ wrap, header, content }: FormWrapState, isOpen: boolean): void => {
  wrap.classList.remove(OVERFLOW_VISIBLE_CLASS);
  wrap.classList.toggle(OPEN_CLASS, isOpen);
  header.setAttribute("aria-expanded", String(isOpen));
  setContentHeight(content, isOpen);

  if (!isOpen) return;

  window.setTimeout(() => {
    if (!wrap.classList.contains(OPEN_CLASS)) return;
    wrap.classList.add(OVERFLOW_VISIBLE_CLASS);
  }, 300);
};

const bindFormWrap = (wrap: HTMLElement): void => {
  if (wrap.dataset.formWrapCollapseInitialized === "true") return;

  const header = wrap.querySelector<HTMLElement>(".form-wrap-header");
  const content = wrap.querySelector<HTMLElement>(".form-wrap-content");

  if (!header || !content) return;

  const state: FormWrapState = { wrap, header, content };

  header.setAttribute("role", "button");
  header.setAttribute("tabindex", "0");

  header.addEventListener("click", () => {
    setFormWrapState(state, !wrap.classList.contains(OPEN_CLASS));
  });

  header.addEventListener("keydown", (event) => {
    if (event.key !== "Enter" && event.key !== " ") return;

    event.preventDefault();
    header.click();
  });

  states.push(state);
  setFormWrapState(state, true);
  wrap.dataset.formWrapCollapseInitialized = "true";
};

export const initFormWrapCollapse = (root: ParentNode = document): void => {
  root.querySelectorAll<HTMLElement>(".form-wrap").forEach(bindFormWrap);

  if (resizeHandlerBound) return;

  window.addEventListener("resize", () => {
    states.forEach((state) => {
      if (!state.wrap.classList.contains(OPEN_CLASS)) return;
      setContentHeight(state.content, true);
    });
  });

  resizeHandlerBound = true;
};
