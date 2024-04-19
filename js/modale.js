///// Modale de contact du menu de la page d'accueil /////
jQuery(document).ready(function ($) {
  const modal = $("#myModal");
  const btn = $("#menu-item-8 a");

  // Gère le clic pour ouvrir la modale
  btn.on("click", function () {
    modal.css("display", "block");
  });

  // Gère le click pour fermer la modale
  $(window).on("click", function (event) {
    if (event.target == modal[0]) {
      modal.css("display", "none");
    }
  });

  ///// Modale de contact du bouton de la page d'infos d'une photo /////
  jQuery(document).ready(function ($) {
    const refphoto = $("#ref_photo");
    const ref_field = $("#ref-field");
    const contactButton = $(".btn_contact");

    // Récupére le champs ACF et remplit le champ référence du formulaire
    ref_field.val(refphoto.text());

    // Ajoute un écouteur d'événements au bouton
    contactButton.on("click", function () {
      modal.css("display", "block");
    });
  });
});

///// Modale de contact du menu burger /////
jQuery(document).ready(function ($) {
  const contactPopup = $(".burger-popup");
  const modal = $("#myModal");

  // Ajoute un écouteur d'événements au bouton
  contactPopup.on("click", function () {
    modal.css("display", "block");
  });
});
