document.addEventListener("DOMContentLoaded", function () {
  // Utilisation d'un délégué d'événement pour gérer les clics sur les images
  document.addEventListener("click", function (event) {
    const image = event.target.closest(".hover-image");
    if (!image) return; // Quitte la fonction si l'élément cliqué n'est pas une image

    const fullscreen = image.querySelector(".icon-fullscreen");
    if (!fullscreen) return; // Quitte la fonction si l'icône de plein écran n'est pas présente

    // Empêche le comportement par défaut du lien
    fullscreen.addEventListener("click", function (event) {
      event.preventDefault();

      // Récupère les informations de l'image cliquée
      const imageSrc = image.querySelector("img").getAttribute("src");
      const imageAlt = image.querySelector("img").getAttribute("alt");
      const imageCategory = image.querySelector(".cat_hover").textContent;
      const imageRef = image.querySelector(".ref_hover").textContent;

      // Crée un tableau d'objets image avec toutes les images
      const images = Array.from(document.querySelectorAll(".hover-image")).map(
        (hoverImage) => {
          const img = hoverImage.querySelector("img");
          return {
            src: img.getAttribute("src"),
            alt: img.getAttribute("alt"),
            category: hoverImage.querySelector(".cat_hover").textContent,
            reference: hoverImage.querySelector(".ref_hover").textContent,
          };
        }
      );

      // Trouve l'index de l'image cliquée dans le tableau d'images
      const currentIndex = images.findIndex(
        (img) =>
          img.src === imageSrc &&
          img.alt === imageAlt &&
          img.category === imageCategory &&
          img.reference === imageRef
      );

      // Affiche la lightbox avec l'image correspondante
      showLightbox(images, currentIndex);
    });
  });
});

// Fonction pour afficher la lightbox avec l'image correspondante
function showLightbox(images, index) {
  const image = images[index];

  // Récupère les éléments de la lightbox
  const lightboxOverlay = document.querySelector(".lightbox-overlay");
  const lightboxImg = lightboxOverlay.querySelector("img");
  const lightboxCat = lightboxOverlay.querySelector(".lightbox-category");
  const lightboxRef = lightboxOverlay.querySelector(".lightbox-ref");

  // Ajoute les informations de l'image à la lightbox
  lightboxImg.src = image.src;
  lightboxImg.alt = image.alt;
  lightboxCat.textContent = image.category;
  lightboxRef.textContent = image.reference;

  // Affiche la lightbox
  lightboxOverlay.style.display = "block";

  // Gère le clic sur la croix pour fermer la lightbox
  lightboxOverlay
    .querySelector(".close-lightbox")
    .addEventListener("click", function () {
      lightboxOverlay.style.display = "none";
    });

  // Gère le clic sur le bouton "Précédent"
  lightboxOverlay
    .querySelector(".prev-photo")
    .addEventListener("click", function () {
      updateLightbox(images, index - 1);
    });

  // Gère le clic sur le bouton "Suivant"
  lightboxOverlay
    .querySelector(".next-photo")
    .addEventListener("click", function () {
      updateLightbox(images, index + 1);
    });
}

// Fonction pour mettre à jour les informations de la lightbox avec une nouvelle image
function updateLightbox(images, index) {
  // Assure que l'index reste dans les limites du tableau d'images
  index = (index + images.length) % images.length;
  showLightbox(images, index);
}
