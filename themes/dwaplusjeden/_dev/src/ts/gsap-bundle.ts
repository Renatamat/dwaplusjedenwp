import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";

gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

declare global {
  interface Window {
    gsap: typeof gsap;
    ScrollTrigger: typeof ScrollTrigger;
  }
}

window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

type AnimationKey =
  | "fade-up"
  | "bubble-pop"
  | "fade-in-up"
  | "scale-in"
  | "slide-left"
  | "slide-right"
  | "slide-up";

type AnimationOptions = {
  delay: number;
  duration: number;
  ease?: string;
  start: string;
};

type AnimationDefinition = {
  selector: string;
  defaults: AnimationOptions;
  from: gsap.TweenVars;
  to?: gsap.TweenVars;
  key?: AnimationKey;
};

const ANIMATIONS: Record<AnimationKey, AnimationDefinition> = {
  "fade-up": {
    key: "fade-up",
    selector: "[data-animate='fade-up'], .a-fade-up",
    defaults: {
      delay: 0,
      duration: 0.9,
      ease: "power3.out",
      start: "top 85%",
    },
    from: {
      autoAlpha: 0,
      y: 56,
    },
  },
  "bubble-pop": {
    key: "bubble-pop",
    selector: "[data-animate='bubble-pop'], .a-bubble-pop",
    defaults: {
      delay: 0,
      duration: 0.95,
      ease: "back.out(1.55)",
      start: "top 82%",
    },
    from: {
      autoAlpha: 0,
      y: 26,
      scale: 0.86,
      transformOrigin: "50% 80%",
    },
  },
  "fade-in-up": {
    key: "fade-in-up",
    selector: "[data-animate='fade-in-up'], .a-fade-in-up",
    defaults: {
      delay: 0,
      duration: 1,
      ease: "power3.out", 
      start: "top 85%",
    },
    from: {
      autoAlpha: 0,
      y: 80,
    },
    to: {
      autoAlpha: 1,
      y: 0,
    },
  },
  "scale-in": {
    key: "scale-in",
    selector: "[data-animate='scale-in']",
    defaults: {
      delay: 0,
      duration: 0.8,
      ease: "back.out(1.7)",
      start: "top 80%",
    },
    from: {
      autoAlpha: 0,
      scale: 0.5,
    },
  },
  "slide-left": {
    key: "slide-left",
    selector: "[data-animate='slide-left'], .a-slide-left",
    defaults: {
      delay: 0,
      duration: 0.78,
      ease: "power3.out",
      start: "top 86%",
    },
    from: {
      autoAlpha: 0,
      x: -96,
    },
    to: {
      x: 0,
      clearProps: "transform,opacity,visibility",
    },
  },
  "slide-right": {
    key: "slide-right",
    selector: "[data-animate='slide-right'], .a-slide-right",
    defaults: {
      delay: 0,
      duration: 0.78,
      ease: "power3.out",
      start: "top 86%",
    },
    from: {
      autoAlpha: 0,
      x: 96,
    },
    to: {
      x: 0,
      clearProps: "transform,opacity,visibility",
    },
  },
  "slide-up": {
    key: "slide-up",
    selector: "[data-animate='slide-up'], .a-slide-up",
    defaults: {
      delay: 0,
      duration: 0.78,
      ease: "power3.out",
      start: "top 86%",
    },
    from: {
      autoAlpha: 0,
      y: 96,
    },
    to: {
      y: 0,
      clearProps: "transform,opacity,visibility",
    },
  },
};

const parseNumber = (value: string | undefined, fallback: number): number => {
  if (!value) return fallback;

  const parsed = Number.parseFloat(value);
  return Number.isNaN(parsed) ? fallback : parsed;
};

const getElementOptions = (element: HTMLElement, defaults: AnimationOptions): AnimationOptions => ({
  delay: parseNumber(element.dataset.animateDelay, defaults.delay),
  duration: parseNumber(element.dataset.animateDuration, defaults.duration),
  ease: element.dataset.animateEase || defaults.ease,
  start: element.dataset.animateStart || defaults.start,
});

const runAnimation = (
  element: HTMLElement,
  definition: AnimationDefinition,
  options: AnimationOptions,
): void => {
  if (definition.key === "bubble-pop" && element.classList.contains("hp-hero-slider-message")) {
    const avatar = element.querySelector<HTMLElement>(".hero-slider-avatar");

    gsap.set(element, {
      autoAlpha: 0,
      y: 34,
      scale: 0.82,
      rotation: -1.5,
      transformOrigin: "50% 85%",
      force3D: true,
      willChange: "transform, opacity",
    });

    if (avatar) {
      gsap.set(avatar, {
        autoAlpha: 0,
        y: 14,
        scale: 0.55,
        rotation: -12,
        transformOrigin: "50% 50%",
        force3D: true,
        willChange: "transform, opacity",
      });
    }

    const timeline = gsap.timeline({
      delay: options.delay,
      scrollTrigger: {
        trigger: element,
        start: options.start,
        toggleActions: "play none none none",
      },
      onComplete: () => {
        gsap.set([element, avatar].filter(Boolean), {
          willChange: "auto",
        });
      },
    });

    timeline
      .to(element, {
        autoAlpha: 1,
        y: -10,
        scale: 1.04,
        rotation: 0.4,
        duration: options.duration * 0.58,
        ease: "power3.out",
        force3D: true,
      })
      .to(element, {
        y: 0,
        scale: 1,
        rotation: 0,
        duration: options.duration * 0.42,
        ease: "back.out(2.1)",
        force3D: true,
      });

    if (avatar) {
      timeline
        .to(
          avatar,
          {
            autoAlpha: 1,
            y: -6,
            scale: 1.12,
            rotation: 5,
            duration: 0.34,
            ease: "power3.out",
            force3D: true,
          },
          options.duration * 0.24,
        )
        .to(
          avatar,
          {
            y: 0,
            scale: 1,
            rotation: 0,
            duration: 0.42,
            ease: "back.out(2.4)",
            force3D: true,
          },
          options.duration * 0.58,
        );
    }

    return;
  }

  gsap.set(element, {
    force3D: true,
    willChange: "transform, opacity",
  });

  const toVars: gsap.TweenVars = {
    ...definition.to,
    autoAlpha: 1,
    duration: options.duration,
    delay: options.delay,
    ease: options.ease,
    force3D: true,
    scrollTrigger: {
      trigger: element,
      start: options.start,
      toggleActions: "play none none none",
    },
    onComplete: () => {
      gsap.set(element, {
        willChange: "auto",
      });
    },
  };

  gsap.fromTo(element, definition.from, toVars);
};

const initRegisteredAnimations = (): void => {
  Object.values(ANIMATIONS).forEach((definition) => {
    document.querySelectorAll<HTMLElement>(definition.selector).forEach((element) => {
      if (element.dataset.gsapInitialized === "true") return;

      const options = getElementOptions(element, definition.defaults);
      runAnimation(element, definition, options);
      element.dataset.gsapInitialized = "true";
    });
  });
};

const initAvatarHeaderAnimations = (): void => {
  document.querySelectorAll<HTMLElement>(".avatar-header").forEach((header) => {
    if (header.dataset.gsapInitialized === "true") return;
    if (header.closest("[data-hero-shrink]")) return;

    const avatars = Array.from(header.querySelectorAll<HTMLElement>(".avatar"));
    if (avatars.length === 0) return;

    gsap.set(avatars, {
      autoAlpha: 0,
      x: 16,
      force3D: true,
      willChange: "transform, opacity",
    });

    const delay = parseNumber(header.dataset.animateDelay, 0.28);
    const duration = parseNumber(header.dataset.animateDuration, 0.58);

    gsap.to(avatars, {
      autoAlpha: 1,
      x: 0,
      duration,
      delay,
      stagger: 0.1,
      ease: "power2.out",
      force3D: true,
      onComplete: () => {
        gsap.set(avatars, {
          willChange: "auto",
        });
      },
    });

    header.dataset.gsapInitialized = "true";
  });
};

const initCardSequenceAnimations = (): void => {
  document
    .querySelectorAll<HTMLElement>(".a-card-sequence, [data-animate-sequence='cards']")
    .forEach((container) => {
      if (container.dataset.gsapInitialized === "true") return;

      const items = Array.from(
        container.querySelectorAll<HTMLElement>(".a-card-item, [data-animate-sequence-item]"),
      );

      if (items.length === 0) return;

      const delay = parseNumber(container.dataset.animateDelay, 0);
      const duration = parseNumber(container.dataset.animateDuration, 0.68);
      const stagger = parseNumber(container.dataset.animateStagger, 0.19);  
        const start = container.dataset.animateStart || "top 84%";
      const sequenceMode = container.dataset.animateSequenceMode || "batch";
      const batchMax = parseNumber(container.dataset.animateBatchMax, 3);
      const imageElements = items
        .map((item) => item.querySelector<HTMLElement>(".service-card-img"))
        .filter((element): element is HTMLElement => Boolean(element));

      gsap.set(items, {
        autoAlpha: 0,
        y: 28,
        force3D: true,
        willChange: "transform, opacity",
      });

      gsap.set(imageElements, {
        autoAlpha: 0,
        x: 12,
        y: 18,
        scale: 0.72,
        rotation: -12,
        transition: "none",
        transformOrigin: "50% 50%",
        force3D: true,
        willChange: "transform, opacity",
      });

      if (sequenceMode === "timeline") {
        gsap
          .timeline({
            delay,
            scrollTrigger: {
              trigger: container,
              start,
              toggleActions: "play none none none",
            },
            onComplete: () => {
              gsap.set([...items, ...imageElements], {
                willChange: "auto",
              });
            },
          })
          .to(items, {
            autoAlpha: 1,
            y: 0,
            duration,
            stagger,
            ease: "power2.out",
            force3D: true,
            clearProps: "transform,opacity,visibility",
          });

        container.dataset.gsapInitialized = "true";
        return;
      }

        ScrollTrigger.batch(items, {
          start,
          interval: 0.16,
          batchMax,
          once: true,
          onEnter: (batch) => {
            const batchItems = (batch as HTMLElement[]).sort((firstElement, secondElement) => {
              const firstRect = firstElement.getBoundingClientRect();
              const secondRect = secondElement.getBoundingClientRect();
              const rowTolerance = 8;

              if (Math.abs(firstRect.top - secondRect.top) > rowTolerance) {
                return firstRect.top - secondRect.top;
              }

              return firstRect.left - secondRect.left;
            });
            const batchImageElements = batchItems
              .map((item) => item.querySelector<HTMLElement>(".service-card-img"))
              .filter((element): element is HTMLElement => Boolean(element));

            gsap
              .timeline({
                delay,
                onComplete: () => {
                  gsap.set([...batchItems, ...batchImageElements], {
                    willChange: "auto",
                  });
                },
              })
              .to(batchItems, {
                autoAlpha: 1,
                y: 0,
                duration,
                stagger,
                ease: "power2.out",
                force3D: true,
                clearProps: "transform,opacity,visibility",
              })
              .to(
                batchImageElements,
                {
                  autoAlpha: 1,
                  x: -8,
                  y: -8,
                  scale: 1.16,
                  rotation: 12,
                  duration: 0.46,
                  stagger,
                  ease: "power2.out",
                  force3D: true,
                },
                0.08,
              )
              .to(
                batchImageElements,
                {
                  x: 0,
                  y: 0,
                  scale: 1,
                  rotation: 0,
                  duration: 0.52,
                  stagger,
                  ease: "back.out(2.2)",
                  force3D: true,
                  clearProps: "transform,opacity,visibility,transition",
                },
                0.4,
              );
          },
        });

      container.dataset.gsapInitialized = "true";
    });
};

const animateCounterValue = (counter: HTMLElement, scrollTrigger?: ScrollTrigger.Vars): gsap.core.Tween => {
  const target = Number.parseInt(counter.dataset.target || "0", 10);
  const value = { current: 0 };

  counter.textContent = "0";

  return gsap.to(value, {
    current: target,
    duration: parseNumber(counter.dataset.animateDuration, 1.45),
    ease: counter.dataset.animateEase || "power1.out",
    scrollTrigger,
    onUpdate: () => {
      counter.textContent = Math.round(value.current).toString();
    },
  });
};

const isElementInInitialViewport = (element: HTMLElement): boolean => {
  const rect = element.getBoundingClientRect();

  return rect.top < window.innerHeight && rect.bottom > 0;
};

const initOdHeroSequenceAnimations = (): void => {
  document.querySelectorAll<HTMLElement>(".a-od-hero-sequence").forEach((container) => {
    if (container.dataset.gsapInitialized === "true") return;

    const cards = Array.from(container.querySelectorAll<HTMLElement>(".a-od-hero-card"));
    const counters = Array.from(container.querySelectorAll<HTMLElement>("[data-sequence-counter]"));

    if (cards.length === 0) return;

    const delay = parseNumber(container.dataset.animateDelay, 0);
    const duration = parseNumber(container.dataset.animateDuration, 0.68);
    const stagger = parseNumber(container.dataset.animateStagger, 0.19);
    const start = container.dataset.animateStart || "top 84%";

    gsap.set(cards, {
      autoAlpha: 0,
      y: 28,
      force3D: true,
      willChange: "transform, opacity",
    });

    counters.forEach((counter) => {
      counter.textContent = "0";
      counter.dataset.gsapInitialized = "true";
    });

    const timelineOptions: gsap.TimelineVars = {
      delay,
      onComplete: () => {
        gsap.set(cards, {
          willChange: "auto",
        });
      },
    };

    if (!isElementInInitialViewport(container)) {
      timelineOptions.scrollTrigger = {
          trigger: container,
          start,
          toggleActions: "play none none none",
      };
    }

    const timeline = gsap.timeline(timelineOptions);

    timeline.to(cards, {
      autoAlpha: 1,
      y: 0,
      duration,
      stagger,
      ease: "power2.out",
      force3D: true,
      clearProps: "transform,opacity,visibility",
    });

    counters.forEach((counter, index) => {
      timeline.add(() => {
        animateCounterValue(counter);
      }, 0.28 + index * stagger);
    });

    container.dataset.gsapInitialized = "true";
  });
};

const getHeroNaturalHeight = (hero: HTMLElement): number => {
  const content = hero.querySelector<HTMLElement>(".container");
  const styles = window.getComputedStyle(hero);
  const paddingTop = parseNumber(styles.paddingTop, 0);
  const paddingBottom = parseNumber(styles.paddingBottom, 0);

  return Math.ceil((content?.getBoundingClientRect().height || hero.scrollHeight) + paddingTop + paddingBottom);
};

const getHeroCssHeight = (hero: HTMLElement): number => {
  const currentInlineHeight = hero.style.height;

  hero.style.height = "";
  const cssHeight = hero.getBoundingClientRect().height;
  hero.style.height = currentInlineHeight;

  return Math.ceil(cssHeight);
};

const splitHeroText = (element: HTMLElement): HTMLElement[] => {
  if (element.dataset.heroSplitInitialized === "true") {
    return Array.from(element.querySelectorAll<HTMLElement>(".hero-split-char"));
  }

  const text = element.textContent?.replace(/\s+/g, " ").trim() || "";
  const chars: HTMLElement[] = [];

  element.textContent = "";
  element.style.opacity = "1";

  text.split(" ").forEach((word, wordIndex, words) => {
    const wordElement = document.createElement("span");
    wordElement.className = "hero-split-word";

    Array.from(word).forEach((char) => {
      const charElement = document.createElement("span");
      charElement.className = "hero-split-char";
      charElement.textContent = char;
      wordElement.appendChild(charElement);
      chars.push(charElement);
    });

    element.appendChild(wordElement);

    if (wordIndex < words.length - 1) {
      element.appendChild(document.createTextNode(" "));
    }
  });

  element.dataset.heroSplitInitialized = "true";

  return chars;
};

const initAboutHeaderAnimations = (): void => {
  document.querySelectorAll<HTMLElement>(".about-header").forEach((header) => {
    if (header.dataset.gsapInitialized === "true") return;

    const title = header.querySelector<HTMLElement>(".a-about-header-title");
    const copy = header.querySelector<HTMLElement>(".a-about-header-copy");
    const cards = Array.from(header.querySelectorAll<HTMLElement>(".a-about-header-card"));

    if (!title || !copy || cards.length === 0) return;

    const splitChars = splitHeroText(title);
    const counters = Array.from(header.querySelectorAll<HTMLElement>(".a-about-counter"));

    gsap.set(title, {
      autoAlpha: 1,
    });

    gsap.set(splitChars, {
      autoAlpha: 0,
      y: 36,
      rotationX: -70,
      transformOrigin: "50% 80%",
      force3D: true,
      willChange: "transform, opacity",
    });

    gsap.set(copy, {
      autoAlpha: 0,
      y: 122,
      force3D: true,
      willChange: "transform, opacity",
    });

    gsap.set(cards, {
      y: 122,
      force3D: true,
      willChange: "transform",
    });

    gsap.set(cards, {
      visibility: "hidden",
    });

    counters.forEach((counter) => {
      counter.textContent = "0";
      counter.dataset.gsapInitialized = "true";
    });

    const timelineOptions: gsap.TimelineVars = {
      delay: parseNumber(header.dataset.animateDelay, 0.12),
      onComplete: () => {
        gsap.set([splitChars, copy, cards].flat(), {
          willChange: "auto",
        });
      },
    };

    if (!isElementInInitialViewport(header)) {
      timelineOptions.scrollTrigger = {
        trigger: header,
        start: header.dataset.animateStart || "top 78%",
        toggleActions: "play none none none",
      };
    }

    const timeline = gsap.timeline(timelineOptions);

    timeline
      .to(splitChars, {
        autoAlpha: 1,
        y: 0,
        rotationX: 0,
        duration: 0.56,
        stagger: 0.014,
        ease: "power3.out",
        force3D: true,
        clearProps: "transform,opacity,visibility",
      })
      .to(
        copy,
        {
          autoAlpha: 1,
          y: 0,
          duration: 0.52,
          ease: "power2.out",
          force3D: true,
          clearProps: "transform,opacity,visibility",
        },
        "-=0.14",
      );

    const cardsStartPosition = timeline.duration() - 0.06;

    cards.forEach((card, index) => {
      const position = cardsStartPosition + index * 0.16;

      timeline
        .set(card, {
          visibility: "visible",
        }, position)
        .to(card, {
          y: 0,
          duration: 0.68,
          ease: "power2.out",
          force3D: true,
        }, position);
    });

    counters.forEach((counter, index) => {
      timeline.add(() => {
        animateCounterValue(counter);
      }, 1.02 + index * 0.16);
    });

    header.dataset.gsapInitialized = "true";
  });
};

const initHeroShrinkAnimations = (): void => {
  document.querySelectorAll<HTMLElement>("[data-hero-shrink]").forEach((hero) => {
    if (hero.dataset.gsapInitialized === "true") return;

    const getFullHeight = (): number => Math.max(getHeroNaturalHeight(hero), getHeroCssHeight(hero));
    const splitTargets = Array.from(hero.querySelectorAll<HTMLElement>("[data-hero-split]"));
    const splitChars = splitTargets.flatMap(splitHeroText);
    const avatarHeader = hero.querySelector<HTMLElement>(".avatar-header");
    const avatars = avatarHeader ? Array.from(avatarHeader.querySelectorAll<HTMLElement>(".avatar")) : [];

    gsap.set(hero, {
      height: getFullHeight(),
      overflow: "visible",
      willChange: "height",
    });

    gsap.set(splitTargets, {
      autoAlpha: 1,
    });

    gsap.set(splitChars, {
      autoAlpha: 0,
      y: 36,
      rotationX: -70,
      transformOrigin: "50% 80%",
      force3D: true,
      willChange: "transform, opacity",
    });

    gsap.set(avatars, {
      autoAlpha: 0,
      x: 16,
      force3D: true,
      willChange: "transform, opacity",
    });

    gsap
      .timeline({
        delay: parseNumber(hero.dataset.heroIntroDelay, 0.1),
        onComplete: () => {
          gsap.set([...splitChars, ...avatars, hero], {
            willChange: "auto",
          });
          ScrollTrigger.refresh();
        },
      })
      .to(splitChars, {
        autoAlpha: 1,
        y: 0,
        rotationX: 0,
        duration: 0.56,
        stagger: 0.014,
        ease: "power3.out",
        force3D: true,
        clearProps: "transform,opacity,visibility",
      })
      .to(
        avatars,
        {
            autoAlpha: 1,
            x: 0,
            duration: 0.44,
            stagger: 0.08,
          ease: "power2.out",
          force3D: true,
          clearProps: "transform",
        },
        "-=0.24",
      )
      .to(hero, {
        height: getHeroNaturalHeight(hero),
        duration: parseNumber(hero.dataset.heroShrinkDuration, 0.68),
        ease: hero.dataset.heroShrinkEase || "power3.inOut",
      }, "+=0.04");

    window.addEventListener("resize", () => {
      gsap.set(hero, {
        height: getHeroNaturalHeight(hero),
      });
      ScrollTrigger.refresh();
    });

    hero.dataset.gsapInitialized = "true";
  });
};

const initStaggeredAnimations = (): void => {
  document.querySelectorAll<HTMLElement>("[data-animate-stagger]").forEach((container) => {
    if (container.dataset.gsapInitialized === "true") return;

    const items = container.querySelectorAll<HTMLElement>("[data-stagger-item]");
    if (items.length === 0) return;

    const duration = parseNumber(container.dataset.animateDuration, 0.6);
    const stagger = parseNumber(container.dataset.animateStagger, 0.15);
    const start = container.dataset.animateStart || "top 75%";

    gsap.from(items, {
      autoAlpha: 0,
      y: 50,
      duration,
      stagger,
      ease: container.dataset.animateEase || "power2.out",
      scrollTrigger: {
        trigger: container,
        start,
        toggleActions: "play none none none",
      },
    });

    container.dataset.gsapInitialized = "true";
  });
};

const initProcessSequenceAnimations = (): void => {
  document.querySelectorAll<HTMLElement>(".a-process-sequence").forEach((container) => {
    if (container.dataset.gsapInitialized === "true") return;

    const items = Array.from(container.querySelectorAll<HTMLElement>(".a-process-item"));
    if (items.length === 0) return;

    const numbers = items
      .map((item) => item.querySelector<HTMLElement>(".a-process-number"))
      .filter((element): element is HTMLElement => Boolean(element));
    const copies = items
      .map((item) => item.querySelector<HTMLElement>(".a-process-copy"))
      .filter((element): element is HTMLElement => Boolean(element));

    gsap.set(numbers, {
      autoAlpha: 0,
      scale: 0.76,
      transformOrigin: "50% 50%",
      force3D: true,
      willChange: "transform, opacity",
    });

    gsap.set(copies, {
      autoAlpha: 0,
      y: 22,
      force3D: true,
      willChange: "transform, opacity",
    });

    const timeline = gsap.timeline({
      scrollTrigger: {
        trigger: container,
        start: container.dataset.animateStart || "top 78%",
        toggleActions: "play none none none",
      },
      onComplete: () => {
        gsap.set([...numbers, ...copies], {
          willChange: "auto",
        });
      },
    });

    items.forEach((item, index) => {
      const number = item.querySelector<HTMLElement>(".a-process-number");
      const copy = item.querySelector<HTMLElement>(".a-process-copy");
      const position = index * 0.22;

      if (number) {
        timeline.to(
          number,
          {
            autoAlpha: 1,
            scale: 1,
            duration: 0.48,
            ease: "back.out(1.7)",
            force3D: true,
            clearProps: "transform,opacity,visibility",
          },
          position,
        );
      }

      if (copy) {
        timeline.to(
          copy,
          {
            autoAlpha: 1,
            y: 0,
            duration: 0.46,
            ease: "power2.out",
            force3D: true,
            clearProps: "transform,opacity,visibility",
          },
          position + 0.1,
        );
      }
    });

    container.dataset.gsapInitialized = "true";
  });
};

const initObOfferSequenceAnimations = (): void => {
  document.querySelectorAll<HTMLElement>(".a-ob-offer-sequence").forEach((container) => {
    if (container.dataset.gsapInitialized === "true") return;

    const leftItem = container.querySelector<HTMLElement>(".a-ob-offer-left");
    const rightItem = container.querySelector<HTMLElement>(".a-ob-offer-right");
    const plus = container.querySelector<HTMLElement>(".a-ob-offer-plus");

    if (!leftItem || !rightItem || !plus) return;

    gsap.set(leftItem, {
      autoAlpha: 0,
      x: -96,
      force3D: true,
      willChange: "transform, opacity",
    });

    gsap.set(rightItem, {
      autoAlpha: 0,
      x: 96,
      force3D: true,
      willChange: "transform, opacity",
    });

    gsap.set(plus, {
      autoAlpha: 0,
      scale: 0.42,
      transformOrigin: "50% 50%",
      force3D: true,
      willChange: "transform, opacity",
    });

    gsap
      .timeline({
        scrollTrigger: {
          trigger: container,
          start: container.dataset.animateStart || "top 76%",
          toggleActions: "play none none none",
        },
        onComplete: () => {
          gsap.set([leftItem, rightItem, plus], {
            willChange: "auto",
          });
        },
      })
      .to(leftItem, {
        autoAlpha: 1,
        x: 0,
        duration: 0.72,
        ease: "power3.out",
        force3D: true,
        clearProps: "transform,opacity,visibility",
      })
      .to(
        rightItem,
        {
          autoAlpha: 1,
          x: 0,
          duration: 0.72,
          ease: "power3.out",
          force3D: true,
          clearProps: "transform,opacity,visibility",
        },
        "-=0.42",
      )
      .to(
        plus,
        {
          autoAlpha: 1,
          scale: 1,
          duration: 0.5,
          ease: "back.out(1.85)",
          force3D: true,
        },
        "-=0.14",
      );

    container.dataset.gsapInitialized = "true";
  });
};

const initPricingPackageAnimations = (): void => {
  document.querySelectorAll<HTMLElement>(".pakiety").forEach((section) => {
    if (section.dataset.gsapPricingInitialized === "true") return;

    const activeContent = Array.from(
      section.querySelectorAll<HTMLElement>(".pakiety-content[data-option]"),
    ).find((content) => !content.hidden);

    if (!activeContent) return;

    const items = Array.from(activeContent.querySelectorAll<HTMLElement>(".pakiety-content-item"));
    if (items.length === 0) return;

    gsap.set(items, {
      autoAlpha: 0,
      y: 28,
      force3D: true,
      willChange: "transform, opacity",
    });

    ScrollTrigger.batch(items, {
      start: section.dataset.animateStart || "top 78%",
      interval: 0.16,
      batchMax: parseNumber(section.dataset.animateBatchMax, 4),
      once: true,
      onEnter: (batch) => {
        const batchItems = (batch as HTMLElement[]).sort((firstElement, secondElement) => {
          const firstRect = firstElement.getBoundingClientRect();
          const secondRect = secondElement.getBoundingClientRect();
          const rowTolerance = 8;

          if (Math.abs(firstRect.top - secondRect.top) > rowTolerance) {
            return firstRect.top - secondRect.top;
          }

          return firstRect.left - secondRect.left;
        });

        gsap.to(batchItems, {
          autoAlpha: 1,
          y: 0,
          duration: 0.68,
          stagger: 0.14,
          ease: "power2.out",
          force3D: true,
          clearProps: "transform,opacity,visibility",
          onComplete: () => {
            gsap.set(batchItems, {
              willChange: "auto",
            });
          },
        });
      },
    });

    section.dataset.gsapPricingInitialized = "true";
  });
};

const initBlogAllNewsChipAnimations = (): void => {
  document.querySelectorAll<HTMLElement>(".blog-allnews-row-items").forEach((container) => {
    if (container.dataset.gsapInitialized === "true") return;

    const chips = Array.from(container.querySelectorAll<HTMLElement>(".chip"));
    if (chips.length === 0) return;

    gsap.set(chips, {
      autoAlpha: 0,
      y: 14,
      //force3D: true,
      willChange: "transform, opacity",
    });

    gsap.to(chips, {
      autoAlpha: 1,
      y: 0,
      duration: 0.08,
      stagger: 0.068,
      ease: "power2.out",
      //force3D: true,
      scrollTrigger: {
        trigger: container,
        start: container.dataset.animateStart || "top 82%",
        toggleActions: "play none none none",
      },
      clearProps: "transform,opacity,visibility",
      onComplete: () => {
        gsap.set(chips, {
          willChange: "auto",
        });
      },
    });

    container.dataset.gsapInitialized = "true";
  });
};

const initParallax = (): void => {
  document.querySelectorAll<HTMLElement>("[data-animate='parallax']").forEach((element) => {
    if (element.dataset.gsapInitialized === "true") return;

    gsap.to(element, {
      y: parseNumber(element.dataset.animateY, 200),
      ease: "none",
      scrollTrigger: {
        trigger: element,
        start: "top bottom",
        end: "bottom top",
        scrub: true,
      },
    });

    element.dataset.gsapInitialized = "true";
  });
};

const initCounters = (): void => {
  document.querySelectorAll<HTMLElement>("[data-animate='counter']").forEach((counter) => {
    if (counter.dataset.gsapInitialized === "true") return;

    animateCounterValue(counter, {
        trigger: counter,
        start: counter.dataset.animateStart || "top 80%",
        toggleActions: "play none none none",
    });

    counter.dataset.gsapInitialized = "true";
  });
};

export const initGsapAnimations = (): void => {
  initAvatarHeaderAnimations();
  initAboutHeaderAnimations();
  initHeroShrinkAnimations();
  initOdHeroSequenceAnimations();
  initCardSequenceAnimations();
  initRegisteredAnimations();
  initStaggeredAnimations();
  initProcessSequenceAnimations();
  initObOfferSequenceAnimations();
  initPricingPackageAnimations();
  initBlogAllNewsChipAnimations();
  initParallax();
  initCounters();
};

const setup = (): void => {
  if (typeof document === "undefined") return;

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initGsapAnimations);
    return;
  }

  initGsapAnimations();
};

setup();

export const isGsapBundleReady = true;
