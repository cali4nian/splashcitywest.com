import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

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
