import { initFormHandlers } from "./forms";

const MAX_ITEMS = 4;
const DISABLED_CLASS = "disabled";

const getButtonText = (button: HTMLElement): string => {
  return button.textContent?.replace(/\s+/g, " ").trim().toLowerCase() || "";
};

const findButtonByText = (root: ParentNode, text: string): HTMLElement | null => {
  return Array.from(root.querySelectorAll<HTMLElement>(".c-btn-text")).find((button) => {
    return getButtonText(button).includes(text.toLowerCase());
  }) || null;
};

const getButtonRow = (button: HTMLElement): HTMLElement | null => {
  return button.closest<HTMLElement>(".form-wrap-content-row");
};

const refreshFormWrapHeight = (element: HTMLElement): void => {
  const content = element.closest<HTMLElement>(".form-wrap-content");
  const wrap = element.closest<HTMLElement>(".form-wrap");

  if (!content || !wrap?.classList.contains("--open")) return;

  content.style.maxHeight = `${content.scrollHeight}px`;
};

const setButtonState = (button: HTMLElement, isDisabled: boolean): void => {
  button.classList.toggle(DISABLED_CLASS, isDisabled);
  button.setAttribute("aria-disabled", String(isDisabled));
  button.style.pointerEvents = isDisabled ? "none" : "";
  button.style.opacity = isDisabled ? "0.45" : "";
};

const field = (
  label: string,
  name: string,
  options: {
    type?: string;
    className?: string;
  } = {},
): string => {
  const type = options.type || "text";
  const className = options.className || "InputWrap InputWrap-m --with-label";

  return `
    <div class="${className}">
      <span class="InputPlaceholder-label">${label}</span>
      <div class="position-relative">
        <div class="InputBox">
          <span class="InputPlaceholder"></span>
        </div>
        <span class="wpcf7">
          <input type="${type}" name="${name}">
        </span>
      </div>
    </div>
  `;
};

const selectField = (
  label: string,
  name: string,
  options: Array<{ label: string; value: string }>,
): string => {
  return `
    <div class="InputWrap InputWrap-l --with-label">
      <span class="InputPlaceholder-label">${label}</span>
      <div class="position-relative">
        <span class="wpcf7">
          <select name="${name}" required>
            <option value="" selected disabled>Wybierz</option>
            ${options.map((option) => `<option value="${option.value}">${option.label}</option>`).join("")}
          </select>
        </span>
      </div>
    </div>
  `;
};

const headingRow = (label: string): string => {
  return `
    <div class="form-wrap-content-row">
      <span class="p-m fw-bolder c-body">${label}</span>
    </div>
  `;
};

const checkboxRow = (label: string, name: string): string => {
  return `
    <div class="form-wrap-content-row">
      <div class="CheckboxWrap">
        <label class="label-s">
          <input name="${name}" type="checkbox">
          <span class="CheckboxName">${label}</span>
        </label>
      </div>
    </div>
  `;
};

const repeatHeaderRow = (label: string): string => {
  return `
    <div class="form-wrap-content-row zk-repeat-header">
      <span class="p-m fw-bolder c-body" data-zk-repeat-heading>${label}</span>
      <button class="c-btn c-btn-s c-btn-text zk-repeat-remove" type="button" data-zk-repeat-remove>
        <span>Usuń</span>
      </button>
    </div>
  `;
};

const addressFields = (prefix: string): string => {
  return `
    <div class="form-wrap-content-row">
      ${field("Kod pocztowy", `${prefix}-postal-code`, { className: "InputWrap InputWrap-m --with-label w-25" })}
      ${field("Miasto", `${prefix}-city`)}
    </div>
    <div class="form-wrap-content-row">
      ${field("Ulica", `${prefix}-street`)}
    </div>
    <div class="form-wrap-content-row">
      ${field("Numer domu", `${prefix}-house-number`)}
      ${field("Numer lokalu", `${prefix}-apartment-number`)}
    </div>
  `;
};

const businessAddressBlock = (index: number): string => {
  return `
    <div data-zk-repeat-item="business-address" data-zk-repeat-index="${index}">
      ${repeatHeaderRow(`Adres prowadzenia działalności ${index}`)}
      ${addressFields(`business-address-${index}`)}
    </div>
  `;
};

const representativeBlock = (index: number): string => {
  return `
    <div data-zk-repeat-item="representative" data-zk-repeat-index="${index}">
      ${repeatHeaderRow(`Dane osobowe ${index}`)}
      <div class="form-wrap-content-row">
        ${field("Nazwisko*", `representative-${index}-last-name`)}
        ${field("Imię*", `representative-${index}-first-name`)}
      </div>
      <div class="form-wrap-content-row">
        ${field("PESEL", `representative-${index}-pesel`)}
        <div class="CheckboxWrap">
          <label class="label-s">
            <input name="representative-${index}-no-pesel" type="checkbox">
            <span class="CheckboxName text-nowrap">Brak PESEL</span>
          </label>
        </div>
      </div>
      <div class="form-wrap-content-row">
        ${selectField("Obywatelstwo*", `representative-${index}-citizenship`, [
          { label: "Polskie", value: "polskie" },
          { label: "Ukraińskie", value: "ukrainskie" },
        ])}
        ${field("Data urodzenia", `representative-${index}-birth-date`, { type: "date" })}
      </div>
      <div class="form-wrap-content-row">
        ${selectField("Rodzaj dokumentu*", `representative-${index}-document-type`, [
          { label: "Dowód osobisty", value: "dowod-osobisty" },
          { label: "Paszport", value: "paszport" },
        ])}
        ${field("Seria i numer dokumentu*", `representative-${index}-document-number`)}
      </div>
      ${headingRow(`Adres zamieszkania ${index}`)}
      ${addressFields(`representative-${index}-residence-address`)}
      ${headingRow(`Adres korespondencyjny ${index}`)}
      ${checkboxRow("Taki sam jak zamieszkania", `representative-${index}-same-correspondence-address`)}
      ${addressFields(`representative-${index}-correspondence-address`)}
    </div>
  `;
};

const insertBlockBeforeButton = (button: HTMLElement, html: string): HTMLElement | null => {
  const buttonRow = getButtonRow(button);
  if (!buttonRow) return null;

  const template = document.createElement("template");
  template.innerHTML = html.trim();

  const element = template.content.firstElementChild;
  if (!(element instanceof HTMLElement)) return null;

  buttonRow.before(element);
  initFormHandlers(element);
  refreshFormWrapHeight(buttonRow);

  return element;
};

const refreshAddButtonState = (form: HTMLElement, itemType: string, button: HTMLElement): void => {
  const count = 1 + form.querySelectorAll(`[data-zk-repeat-item='${itemType}']`).length;
  setButtonState(button, count >= MAX_ITEMS);
};

const renameControl = (
  control: HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement,
  previousIndex: string,
  nextIndex: number,
): void => {
  const name = control.getAttribute("name");
  if (!name) return;

  control.setAttribute("name", name.replace(previousIndex, String(nextIndex)));
};

const reindexRepeatItems = (form: HTMLElement, itemType: "business-address" | "representative"): void => {
  const items = Array.from(form.querySelectorAll<HTMLElement>(`[data-zk-repeat-item='${itemType}']`));

  items.forEach((item, itemIndex) => {
    const previousIndex = item.dataset.zkRepeatIndex;
    const nextIndex = itemIndex + 2;
    if (!previousIndex) return;

    item.dataset.zkRepeatIndex = String(nextIndex);
    item.querySelectorAll<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>("input, select, textarea").forEach((control) => {
      renameControl(control, previousIndex, nextIndex);
    });

    const heading = item.querySelector<HTMLElement>("[data-zk-repeat-heading]");
    if (heading) {
      heading.textContent = itemType === "business-address"
        ? `Adres prowadzenia działalności ${nextIndex}`
        : `Dane osobowe ${nextIndex}`;
    }

    item.querySelectorAll<HTMLElement>(".p-m.fw-bolder.c-body:not([data-zk-repeat-heading])").forEach((sectionHeading) => {
      sectionHeading.textContent = sectionHeading.textContent?.replace(previousIndex, String(nextIndex)) || "";
    });
  });
};

const bindRemoveButton = (
  form: HTMLElement,
  element: HTMLElement,
  itemType: "business-address" | "representative",
  addButton: HTMLElement,
): void => {
  const removeButton = element.querySelector<HTMLButtonElement>("[data-zk-repeat-remove]");
  if (!removeButton) return;

  removeButton.addEventListener("click", () => {
    const content = element.closest<HTMLElement>(".form-wrap-content");

    element.remove();
    reindexRepeatItems(form, itemType);
    refreshAddButtonState(form, itemType, addButton);

    if (content) {
      refreshFormWrapHeight(content);
    }
  });
};

const initBusinessAddressRepeater = (form: HTMLElement): void => {
  const button = findButtonByText(form, "Dodaj kolejny adres");
  if (!button || button.dataset.zkRepeaterInitialized === "true") return;

  refreshAddButtonState(form, "business-address", button);

  button.addEventListener("click", () => {
    const count = 1 + form.querySelectorAll("[data-zk-repeat-item='business-address']").length;
    if (count >= MAX_ITEMS) return;

    const element = insertBlockBeforeButton(button, businessAddressBlock(count + 1));
    if (element) {
      bindRemoveButton(form, element, "business-address", button);
    }

    refreshAddButtonState(form, "business-address", button);
  });

  button.dataset.zkRepeaterInitialized = "true";
};

const initRepresentativeRepeater = (form: HTMLElement): void => {
  const button = findButtonByText(form, "Dodaj kolejnego reprezentanta");
  if (!button || button.dataset.zkRepeaterInitialized === "true") return;

  refreshAddButtonState(form, "representative", button);

  button.addEventListener("click", () => {
    const count = 1 + form.querySelectorAll("[data-zk-repeat-item='representative']").length;
    if (count >= MAX_ITEMS) return;

    const element = insertBlockBeforeButton(button, representativeBlock(count + 1));
    if (element) {
      bindRemoveButton(form, element, "representative", button);
    }

    refreshAddButtonState(form, "representative", button);
  });

  button.dataset.zkRepeaterInitialized = "true";
};

export const initZlecenieKsiegowosciRepeaters = (root: ParentNode = document): void => {
  root.querySelectorAll<HTMLElement>(".zlecenie-ksiegowosci").forEach((formSection) => {
    initBusinessAddressRepeater(formSection);
    initRepresentativeRepeater(formSection);
  });
};
