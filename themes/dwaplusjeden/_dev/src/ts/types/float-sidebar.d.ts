type FloatSidebarOptions = {
  sidebar: HTMLElement;
  relative: HTMLElement;
  viewport?: HTMLElement | Window;
  sidebarInner?: HTMLElement;
  topSpacing?: number;
  bottomSpacing?: number;
};

type FloatSidebarInstance = {
  forceUpdate: () => void;
  destroy: () => void;
};

declare module "float-sidebar" {
  export default function FloatSidebar(
    options: FloatSidebarOptions,
  ): FloatSidebarInstance;
}

declare module "./helpers/float-sidebar/src/float-sidebar" {
  export default function FloatSidebar(
    options: FloatSidebarOptions,
  ): FloatSidebarInstance;
}

declare module "*/helpers/float-sidebar/src/float-sidebar" {
  export default function FloatSidebar(
    options: FloatSidebarOptions,
  ): FloatSidebarInstance;
}
