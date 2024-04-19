<!-- Overlay de la lightbox -->
<div class="lightbox-overlay">

    <!-- Bouton pour fermer la lightbox -->
    <span class="close-lightbox">X</span>

    <!-- Contenu de la lightbox -->
    <div class="lightbox-content">

        <!-- Informations de la photo -->
        <div class="infos">
            <!-- photo -->
            <img src="" alt="">

            <!-- Référence de la photo -->
            <p class="lightbox-ref"></p>

            <!-- Catégorie de la photo -->
            <p class="lightbox-category"></p>
        </div>
    </div>

    <!-- Bouton pour passer à la photo précédente -->
    <div class="prev-photo">
        <p class="prev-text">Précédente</p>
        <img class="prev-arrow" src="<?= wp_get_attachment_image_src(77)[0]; ?>" alt="flèche gauche">
    </div>

    <!-- Bouton pour passer à la photo suivante -->
    <div class="next-photo">
        <p class="next-text">Suivante</p>
        <img class="next-arrow" src="<?= wp_get_attachment_image_src(78)[0]; ?>" alt="flèche droite">
    </div>
</div>