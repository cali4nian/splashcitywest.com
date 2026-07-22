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
