const slugify = (value: string): string =>
  value
    .toLowerCase()
    .trim()
    .normalize("NFD")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(/[^a-z0-9]+/g, "-")
    .replace(/^-+|-+$/g, "");

const getHeadingId = (heading: HTMLElement, index: number): string => {
  if (heading.id) return heading.id;

  const baseId = slugify(heading.textContent ?? "") || "heading";
  const id = `${baseId}-${index + 1}`;
  heading.id = id;

  return id;
};

export const initSpis = (root: ParentNode = document): void => {
  root.querySelectorAll<HTMLElement>(".blog-single-content").forEach((section) => {
    const spisContainer = section.querySelector<HTMLElement>(".blog-single-contents");
    const postContent = section.querySelector<HTMLElement>(".blog-content");

    if (!spisContainer || !postContent) return;
    if (spisContainer.dataset.spisInitialized === "true") return;

    const headings = postContent.querySelectorAll<HTMLElement>("h2");

    if (headings.length === 0) {
      spisContainer.remove();
      return;
    }

    const ol = document.createElement("ol");
    headings.forEach((heading, index) => {
      const id = getHeadingId(heading, index);
      const li = document.createElement("li");
      const a = document.createElement("a");

      li.className = "p-s";
      a.textContent = heading.textContent ?? "";
      a.href = `#${id}`;

      a.addEventListener("click", (event) => {
        event.preventDefault();

        const target = document.getElementById(id);
        if (!target) return;

        target.scrollIntoView({ behavior: "smooth", block: "start" });
      });

      li.appendChild(a);
      ol.appendChild(li);
    });

    spisContainer.querySelector("ol")?.remove();
    spisContainer.appendChild(ol);
    spisContainer.dataset.spisInitialized = "true";
  });
};
