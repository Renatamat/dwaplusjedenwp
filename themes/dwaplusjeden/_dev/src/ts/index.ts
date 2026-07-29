import "bootstrap/js/dist/collapse";
import { initLightGalleries } from "./lightgallery";
import { initSwipers } from "./swiper";
import { initFormHandlers } from "./forms"; 
import { initAccordion } from "./accordion";
import { initFloatSidebars } from "./float-sidebar";
import { initHeader } from "./header";
import { initPakiety } from "./pakiety";
import { initSpis } from "./spis";
import { initFormWrapCollapse } from "./form-wrap-collapse";
import { initZlecenieKsiegowosciRepeaters } from "./zlecenie-ksiegowosci-repeaters";
import { initInfoCardDescriptions } from "./info-card-descriptions";
import { initCtaAccordionImages } from "./cta-accordion-image";



const initAll = () => {
  initFloatSidebars();
  initLightGalleries();
  initSwipers();
  initPakiety();
  initSpis();
  initFormHandlers(); 
  initFormWrapCollapse();
  initZlecenieKsiegowosciRepeaters();
  initInfoCardDescriptions();
  initCtaAccordionImages();
  initAccordion();
  initHeader();
};

const setup = () => {
  if (typeof document === "undefined") return;

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initAll);
    return;
  }

  initAll();
};

setup();

export { initFloatSidebars };
export { initLightGalleries };
export { initSwipers };
export { initFormHandlers }; 
export { initPakiety };
export { initSpis };
export { initFormWrapCollapse };
export { initZlecenieKsiegowosciRepeaters };
export { initCtaAccordionImages };
export const isPatternlabWebpackReady = true;
