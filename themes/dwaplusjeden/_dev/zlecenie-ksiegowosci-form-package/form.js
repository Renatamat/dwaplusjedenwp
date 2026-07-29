(function () {
  "use strict";

  var MAX_ITEMS = 4;
  var DISABLED_CLASS = "disabled";
  var SECTION_SELECTOR = ".zlecenie-ksiegowosci";
  var outsideClickInitialized = false;
  var resizeInitialized = false;

  var qsAll = function (root, selector) {
    return Array.prototype.slice.call(root.querySelectorAll(selector));
  };

  var findInputWrap = function (element) {
    return element.closest(".InputWrap");
  };

  var updateInputWrapState = function (inputWrap, state, add) {
    var className = "--" + state;
    inputWrap.classList.toggle(className, add);

    if (state === "focus") {
      var placeholder = inputWrap.querySelector(".InputPlaceholder");
      if (placeholder) {
        placeholder.classList.toggle("--focus", add);
      }
    }
  };

  var initInputHandlers = function (root) {
    var selector = [
      'input[type="text"]',
      'input[type="email"]',
      'input[type="tel"]',
      'input[type="password"]',
      'input[type="url"]',
      'input[type="number"]',
      'input[type="search"]'
    ].join(", ");

    qsAll(root, selector).forEach(function (input) {
      if (input.dataset.formInitialized === "true") return;

      var inputWrap = findInputWrap(input);
      if (!inputWrap) return;

      input.addEventListener("focus", function () {
        updateInputWrapState(inputWrap, "focus", true);
      });

      input.addEventListener("blur", function () {
        if (input.value.trim() === "") {
          updateInputWrapState(inputWrap, "focus", false);
        }
      });

      if (input.value.trim() !== "") {
        updateInputWrapState(inputWrap, "focus", true);
      }

      input.dataset.formInitialized = "true";
    });
  };

  var initTextareaHandlers = function (root) {
    qsAll(root, "textarea").forEach(function (textarea) {
      if (textarea.dataset.formInitialized === "true") return;

      var inputWrap = findInputWrap(textarea);
      if (!inputWrap) return;

      textarea.addEventListener("focus", function () {
        updateInputWrapState(inputWrap, "focus", true);
      });

      textarea.addEventListener("blur", function () {
        if (textarea.value.trim() === "") {
          updateInputWrapState(inputWrap, "focus", false);
        }
      });

      if (textarea.value.trim() !== "") {
        updateInputWrapState(inputWrap, "focus", true);
      }

      textarea.dataset.formInitialized = "true";
    });
  };

  var syncCustomSelectState = function (select, replacement, label) {
    var selectedOption = select.options[select.selectedIndex];
    label.textContent = selectedOption ? selectedOption.textContent : "";

    qsAll(replacement, ".select-option").forEach(function (optionElement, index) {
      optionElement.classList.toggle("--active", index === select.selectedIndex);
    });

    replacement.classList.toggle("--active", select.value !== "");
  };

  var closeCustomSelects = function (section, currentSelect) {
    qsAll(section, ".custom-select.--show").forEach(function (openSelect) {
      if (openSelect === currentSelect) return;
      openSelect.classList.remove("--show");
      var options = openSelect.querySelector(".select-options-container");
      if (options) {
        options.classList.remove("--show");
      }
    });
  };

  var initCustomSelects = function (root) {
    qsAll(root, "select").forEach(function (select) {
      if (select.dataset.customSelectInitialized === "true") return;
      if (select.style.display === "none" && select.previousElementSibling && select.previousElementSibling.classList.contains("custom-select")) {
        select.dataset.customSelectInitialized = "true";
        return;
      }

      var replacement = document.createElement("div");
      replacement.className = "custom-select";

      var selected = document.createElement("div");
      selected.className = "select-selected";

      var label = document.createElement("span");
      selected.appendChild(label);
      replacement.appendChild(selected);

      var optionsContainer = document.createElement("div");
      optionsContainer.className = "select-options-container";

      Array.prototype.slice.call(select.options).forEach(function (option, index) {
        var optionElement = document.createElement("div");
        optionElement.className = "select-option";
        optionElement.dataset.value = option.value;
        optionElement.textContent = option.textContent || "";

        if (option.disabled) {
          optionElement.classList.add("--disabled");
        }

        optionElement.addEventListener("click", function () {
          if (option.disabled) return;

          select.selectedIndex = index;
          select.dispatchEvent(new Event("change", { bubbles: true }));
          replacement.classList.remove("--show");
          optionsContainer.classList.remove("--show");
        });

        optionsContainer.appendChild(optionElement);
      });

      replacement.appendChild(optionsContainer);

      selected.addEventListener("click", function (event) {
        event.stopPropagation();
        var section = select.closest(SECTION_SELECTOR);
        if (section) {
          closeCustomSelects(section, replacement);
        }
        replacement.classList.toggle("--show");
        optionsContainer.classList.toggle("--show");
      });

      select.parentNode.insertBefore(replacement, select);
      select.style.display = "none";

      select.addEventListener("change", function () {
        syncCustomSelectState(select, replacement, label);
      });

      syncCustomSelectState(select, replacement, label);
      select.dataset.customSelectInitialized = "true";
    });
  };

  var initOutsideClickHandler = function () {
    if (outsideClickInitialized) return;

    document.addEventListener("click", function (event) {
      var target = event.target;
      qsAll(document, SECTION_SELECTOR + " .select-options-container.--show").forEach(function (container) {
        var customSelect = container.parentElement;
        if (customSelect && !customSelect.contains(target)) {
          customSelect.classList.remove("--show");
          container.classList.remove("--show");
        }
      });
    });

    outsideClickInitialized = true;
  };

  var initFormHandlers = function (root) {
    initInputHandlers(root);
    initTextareaHandlers(root);
    initCustomSelects(root);
    initOutsideClickHandler();

    qsAll(root, "form").forEach(function (form) {
      form.setAttribute("novalidate", "novalidate");
    });
  };

  var refreshFormWrapHeight = function (element) {
    var content = element.closest(".form-wrap-content");
    var wrap = element.closest(".form-wrap");
    if (!content || !wrap || !wrap.classList.contains("--open")) return;

    content.style.maxHeight = content.scrollHeight + "px";
  };

  var bindFormWrap = function (wrap) {
    if (wrap.dataset.formWrapInitialized === "true") return;

    var header = wrap.querySelector(".form-wrap-header");
    var content = wrap.querySelector(".form-wrap-content");
    if (!header || !content) return;

    wrap.classList.add("--open");
    header.setAttribute("aria-expanded", "true");
    content.style.maxHeight = content.scrollHeight + "px";

    header.addEventListener("click", function () {
      var isOpen = wrap.classList.toggle("--open");
      header.setAttribute("aria-expanded", String(isOpen));
      content.style.maxHeight = isOpen ? content.scrollHeight + "px" : "0px";
    });

    wrap.dataset.formWrapInitialized = "true";
  };

  var initFormWrapCollapse = function (root) {
    qsAll(root, ".form-wrap").forEach(bindFormWrap);

    if (resizeInitialized) return;
    window.addEventListener("resize", function () {
      qsAll(document, SECTION_SELECTOR + " .form-wrap.--open .form-wrap-content").forEach(function (content) {
        content.style.maxHeight = content.scrollHeight + "px";
      });
    });
    resizeInitialized = true;
  };

  var getButtonText = function (button) {
    return (button.textContent || "").replace(/\s+/g, " ").trim().toLowerCase();
  };

  var findButtonByText = function (root, text) {
    return qsAll(root, ".c-btn-text").find(function (button) {
      return getButtonText(button).indexOf(text.toLowerCase()) !== -1;
    }) || null;
  };

  var setButtonState = function (button, disabled) {
    button.classList.toggle(DISABLED_CLASS, disabled);
    button.setAttribute("aria-disabled", String(disabled));
    button.style.pointerEvents = disabled ? "none" : "";
    button.style.opacity = disabled ? "0.45" : "";
  };

  var field = function (label, name, options) {
    options = options || {};
    return '' +
      '<div class="' + (options.className || "InputWrap InputWrap-m --with-label") + '">' +
        '<span class="InputPlaceholder-label">' + label + '</span>' +
        '<div class="position-relative">' +
          '<div class="InputBox"><span class="InputPlaceholder"></span></div>' +
          '<span class="wpcf7"><input type="' + (options.type || "text") + '" name="' + name + '"></span>' +
        '</div>' +
      '</div>';
  };

  var selectField = function (label, name, options) {
    return '' +
      '<div class="InputWrap InputWrap-l --with-label">' +
        '<span class="InputPlaceholder-label">' + label + '</span>' +
        '<div class="position-relative">' +
          '<span class="wpcf7">' +
            '<select name="' + name + '">' +
              '<option value="" selected disabled>Wybierz</option>' +
              options.map(function (option) {
                return '<option value="' + option.value + '">' + option.label + '</option>';
              }).join("") +
            '</select>' +
          '</span>' +
        '</div>' +
      '</div>';
  };

  var headingRow = function (label) {
    return '<div class="form-wrap-content-row"><span class="p-m fw-bolder c-body">' + label + '</span></div>';
  };

  var checkboxRow = function (label, name) {
    return '' +
      '<div class="form-wrap-content-row">' +
        '<div class="CheckboxWrap">' +
          '<label class="label-s">' +
            '<input name="' + name + '" type="checkbox">' +
            '<span class="CheckboxName">' + label + '</span>' +
          '</label>' +
        '</div>' +
      '</div>';
  };

  var repeatHeaderRow = function (label) {
    return '' +
      '<div class="form-wrap-content-row zk-repeat-header">' +
        '<span class="p-m fw-bolder c-body" data-zk-repeat-heading>' + label + '</span>' +
        '<button class="c-btn c-btn-s c-btn-text zk-repeat-remove" type="button" data-zk-repeat-remove>' +
          '<span>Usuń</span>' +
        '</button>' +
      '</div>';
  };

  var addressFields = function (prefix) {
    return '' +
      '<div class="form-wrap-content-row">' +
        field("Kod pocztowy", prefix + "-postal-code", { className: "InputWrap InputWrap-m --with-label w-25" }) +
        field("Miasto", prefix + "-city") +
      '</div>' +
      '<div class="form-wrap-content-row">' +
        field("Ulica", prefix + "-street") +
      '</div>' +
      '<div class="form-wrap-content-row">' +
        field("Numer domu", prefix + "-house-number") +
        field("Numer lokalu", prefix + "-apartment-number") +
      '</div>';
  };

  var businessAddressBlock = function (index) {
    return '' +
      '<div data-zk-repeat-item="business-address" data-zk-repeat-index="' + index + '">' +
        repeatHeaderRow("Adres prowadzenia działalności " + index) +
        addressFields("business-address-" + index) +
      '</div>';
  };

  var representativeBlock = function (index) {
    return '' +
      '<div data-zk-repeat-item="representative" data-zk-repeat-index="' + index + '">' +
        repeatHeaderRow("Dane osobowe " + index) +
        '<div class="form-wrap-content-row">' +
          field("Nazwisko*", "representative-" + index + "-last-name") +
          field("Imię*", "representative-" + index + "-first-name") +
        '</div>' +
        '<div class="form-wrap-content-row">' +
          field("PESEL", "representative-" + index + "-pesel") +
          '<div class="CheckboxWrap">' +
            '<label class="label-s">' +
              '<input name="representative-' + index + '-no-pesel" type="checkbox">' +
              '<span class="CheckboxName text-nowrap">Brak PESEL</span>' +
            '</label>' +
          '</div>' +
        '</div>' +
        '<div class="form-wrap-content-row">' +
          selectField("Obywatelstwo*", "representative-" + index + "-citizenship", [
            { label: "Polskie", value: "polskie" },
            { label: "Ukraińskie", value: "ukrainskie" }
          ]) +
          field("Data urodzenia", "representative-" + index + "-birth-date", { type: "date" }) +
        '</div>' +
        '<div class="form-wrap-content-row">' +
          selectField("Rodzaj dokumentu*", "representative-" + index + "-document-type", [
            { label: "Dowód osobisty", value: "dowod-osobisty" },
            { label: "Paszport", value: "paszport" }
          ]) +
          field("Seria i numer dokumentu*", "representative-" + index + "-document-number") +
        '</div>' +
        headingRow("Adres zamieszkania " + index) +
        addressFields("representative-" + index + "-residence-address") +
        headingRow("Adres korespondencyjny " + index) +
        checkboxRow("Taki sam jak zamieszkania", "representative-" + index + "-same-correspondence-address") +
        addressFields("representative-" + index + "-correspondence-address") +
      '</div>';
  };

  var insertBlockBeforeButton = function (button, html) {
    var buttonRow = button.closest(".form-wrap-content-row");
    if (!buttonRow) return null;

    var template = document.createElement("template");
    template.innerHTML = html.trim();

    var element = template.content.firstElementChild;
    if (!element) return null;

    buttonRow.parentNode.insertBefore(element, buttonRow);
    initFormHandlers(element);
    refreshFormWrapHeight(buttonRow);

    return element;
  };

  var refreshAddButtonState = function (form, itemType, button) {
    var count = 1 + qsAll(form, '[data-zk-repeat-item="' + itemType + '"]').length;
    setButtonState(button, count >= MAX_ITEMS);
  };

  var renameControl = function (control, previousIndex, nextIndex) {
    var name = control.getAttribute("name");
    if (!name) return;
    control.setAttribute("name", name.replace(previousIndex, String(nextIndex)));
  };

  var reindexRepeatItems = function (form, itemType) {
    qsAll(form, '[data-zk-repeat-item="' + itemType + '"]').forEach(function (item, itemIndex) {
      var previousIndex = item.dataset.zkRepeatIndex;
      var nextIndex = itemIndex + 2;
      if (!previousIndex) return;

      item.dataset.zkRepeatIndex = String(nextIndex);
      qsAll(item, "input, select, textarea").forEach(function (control) {
        renameControl(control, previousIndex, nextIndex);
      });

      var heading = item.querySelector("[data-zk-repeat-heading]");
      if (heading) {
        heading.textContent = itemType === "business-address"
          ? "Adres prowadzenia działalności " + nextIndex
          : "Dane osobowe " + nextIndex;
      }

      qsAll(item, ".p-m.fw-bolder.c-body:not([data-zk-repeat-heading])").forEach(function (sectionHeading) {
        sectionHeading.textContent = (sectionHeading.textContent || "").replace(previousIndex, String(nextIndex));
      });
    });
  };

  var bindRemoveButton = function (form, element, itemType, addButton) {
    var removeButton = element.querySelector("[data-zk-repeat-remove]");
    if (!removeButton) return;

    removeButton.addEventListener("click", function () {
      var content = element.closest(".form-wrap-content");
      element.remove();
      reindexRepeatItems(form, itemType);
      refreshAddButtonState(form, itemType, addButton);

      if (content) {
        refreshFormWrapHeight(content);
      }
    });
  };

  var initBusinessAddressRepeater = function (form) {
    var button = findButtonByText(form, "Dodaj kolejny adres");
    if (!button || button.dataset.zkRepeaterInitialized === "true") return;

    refreshAddButtonState(form, "business-address", button);

    button.addEventListener("click", function () {
      var count = 1 + qsAll(form, '[data-zk-repeat-item="business-address"]').length;
      if (count >= MAX_ITEMS) return;

      var element = insertBlockBeforeButton(button, businessAddressBlock(count + 1));
      if (element) {
        bindRemoveButton(form, element, "business-address", button);
      }

      refreshAddButtonState(form, "business-address", button);
    });

    button.dataset.zkRepeaterInitialized = "true";
  };

  var initRepresentativeRepeater = function (form) {
    var button = findButtonByText(form, "Dodaj kolejnego reprezentanta");
    if (!button || button.dataset.zkRepeaterInitialized === "true") return;

    refreshAddButtonState(form, "representative", button);

    button.addEventListener("click", function () {
      var count = 1 + qsAll(form, '[data-zk-repeat-item="representative"]').length;
      if (count >= MAX_ITEMS) return;

      var element = insertBlockBeforeButton(button, representativeBlock(count + 1));
      if (element) {
        bindRemoveButton(form, element, "representative", button);
      }

      refreshAddButtonState(form, "representative", button);
    });

    button.dataset.zkRepeaterInitialized = "true";
  };

  var init = function () {
    qsAll(document, SECTION_SELECTOR).forEach(function (formSection) {
      initFormHandlers(formSection);
      initFormWrapCollapse(formSection);
      initBusinessAddressRepeater(formSection);
      initRepresentativeRepeater(formSection);
    });
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
