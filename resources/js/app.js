import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

const eventModal = document.querySelector("[data-event-modal]");

if (eventModal) {
    const openButtons = document.querySelectorAll("[data-event-open]");
    const closeButtons = eventModal.querySelectorAll(
        "[data-event-modal-close]",
    );
    const titleEl = eventModal.querySelector("[data-event-modal-title]");
    const dateEl = eventModal.querySelector("[data-event-modal-date]");
    const detailsEl = eventModal.querySelector("[data-event-modal-details]");
    const imageEl = eventModal.querySelector("[data-event-modal-image]");

    const closeModal = () => {
        eventModal.classList.add("hidden", "pointer-events-none");
        eventModal.classList.remove("flex");
    };

    const openModal = (button) => {
        if (titleEl) {
            titleEl.textContent = button.dataset.eventTitle || "";
        }

        if (dateEl) {
            dateEl.textContent = button.dataset.eventDate || "";
        }

        if (detailsEl) {
            detailsEl.textContent = button.dataset.eventDetails || "";
        }

        if (imageEl) {
            imageEl.setAttribute("src", button.dataset.eventImage || "");
            imageEl.setAttribute(
                "alt",
                `${button.dataset.eventTitle || "Event"} image`,
            );
        }

        eventModal.classList.remove("hidden", "pointer-events-none");
        eventModal.classList.add("flex");
    };

    openButtons.forEach((button) => {
        button.addEventListener("click", () => openModal(button));
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    eventModal.addEventListener("click", (event) => {
        if (event.target === eventModal) {
            closeModal();
        }
    });

    window.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeModal();
        }
    });
}

const imageLightbox = document.querySelector("[data-image-lightbox]");

if (imageLightbox) {
    const lightboxImage = imageLightbox.querySelector(
        "[data-image-lightbox-image]",
    );
    const closeButtons = imageLightbox.querySelectorAll(
        "[data-image-lightbox-close]",
    );
    const expandableImages = Array.from(
        document.querySelectorAll("main img"),
    ).filter((image) => !image.closest("[data-image-lightbox]"));

    const closeLightbox = () => {
        imageLightbox.classList.add("hidden", "pointer-events-none");
        imageLightbox.classList.remove("flex");
        document.body.classList.remove("overflow-hidden");
    };

    const openLightbox = (image) => {
        const source = image.getAttribute("src") || "";

        if (!source || !lightboxImage) {
            return;
        }

        lightboxImage.setAttribute("src", source);
        lightboxImage.setAttribute(
            "alt",
            image.getAttribute("alt") || "Expanded image",
        );

        imageLightbox.classList.remove("hidden", "pointer-events-none");
        imageLightbox.classList.add("flex");
        document.body.classList.add("overflow-hidden");
    };

    expandableImages.forEach((image) => {
        image.classList.add("cursor-zoom-in");
        image.setAttribute("tabindex", "0");
        image.setAttribute("role", "button");

        image.addEventListener("click", () => openLightbox(image));
        image.addEventListener("keydown", (event) => {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                openLightbox(image);
            }
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeLightbox);
    });

    imageLightbox.addEventListener("click", (event) => {
        if (event.target === imageLightbox) {
            closeLightbox();
        }
    });

    window.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeLightbox();
        }
    });
}

const successCarousel = document.querySelector("[data-success-carousel]");

if (successCarousel) {
    const slides = Array.from(
        successCarousel.querySelectorAll("[data-success-slide]"),
    );
    const dots = Array.from(
        successCarousel.querySelectorAll("[data-success-dot]"),
    );
    const prevButton = successCarousel.querySelector("[data-success-prev]");
    const nextButton = successCarousel.querySelector("[data-success-next]");

    let currentIndex = 0;

    const renderSlide = (index) => {
        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle("hidden", slideIndex !== index);
        });

        dots.forEach((dot, dotIndex) => {
            dot.classList.toggle("bg-[#f26a0a]", dotIndex === index);
            dot.classList.toggle("bg-[#cbd5e1]", dotIndex !== index);
        });
    };

    const goToSlide = (index) => {
        if (slides.length === 0) {
            return;
        }

        currentIndex = (index + slides.length) % slides.length;
        renderSlide(currentIndex);
    };

    prevButton?.addEventListener("click", () => {
        goToSlide(currentIndex - 1);
    });

    nextButton?.addEventListener("click", () => {
        goToSlide(currentIndex + 1);
    });

    dots.forEach((dot) => {
        dot.addEventListener("click", () => {
            const index = Number.parseInt(dot.dataset.successIndex || "0", 10);
            goToSlide(Number.isNaN(index) ? 0 : index);
        });
    });

    renderSlide(currentIndex);
}
