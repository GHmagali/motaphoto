// Gestion des filtres
jQuery(document).ready(function ($) {
  // Initialise Select2 pour chaque liste déroulante
  $("#category-filter, #format-filter, #sort-filter").select2();

  // Lorsque la sélection change, déclenche la fonction de filtrage
  $("#category-filter, #format-filter, #sort-filter").change(function () {
    // Récupère les taxonomies et dates
    var category = $("#category-filter").val();
    var format = $("#format-filter").val();
    var orderby = $("#sort-filter").val();

    // Effectue une requête AJAX pour filtrer les photos en fonction des options sélectionnées
    $.ajax({
      url: ajaxurl.ajaxurl, // URL vers le fichier AJAX de WordPress
      type: "POST",
      // Données à envoyer avec la requête
      data: {
        action: "filter_photos", // Action à exécuter
        category: category,
        format: format,
        orderby: orderby,
      },
      success: function (response) {
        // Renvoie les photos à afficher
        $(".index_img").html(response);

        // Cache le bouton "chargez plus"
        const loadMoreButton = document.querySelector("#load-more-button");
        loadMoreButton.style.display = "none";
      },
    });
  });
});

///// Gestion du bouton "chargez plus" /////
jQuery(document).ready(function ($) {
  // Ajoute un gestionnaire d'événements au clic sur le bouton "chargez plus"
  $("#load-more-button").on("click", function () {
    // Données à envoyer avec la requête
    var data = {
      action: "load_more_photos", // Action à exécuter
      offset: $(".hover-image").length, // Offset pour obtenir les photos suivantes
      posts_per_page: 8,
    };

    // Effectue une requête AJAX pour charger plus de photos
    $.ajax({
      url: ajaxurl.ajaxurl, // URL vers le fichier AJAX de WordPress
      type: "POST",
      data: data, // Données à envoyer avec la requête
      success: function (response) {
        // Ajoute les nouvelles photos
        $(".index_img").append(response);
      },
    });
  });
});
