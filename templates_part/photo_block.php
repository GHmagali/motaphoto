<?php
// Récupére l'ID de l'image mise en avant du post
$related_thumbnail_id = get_post_thumbnail_id();
$related_thumbnail_url = wp_get_attachment_image_src($related_thumbnail_id, 'full');

// Affiche l'image mise en avant du post
echo '<div class="hover-image">';
echo '<img src="' . esc_url($related_thumbnail_url[0]) . '" alt="' . esc_attr(get_the_title()) . '" />';

// Ajoute une image à afficher au survol
echo '<a href="' . esc_url(get_permalink()) . '"><img class="icon-eye" src="' . esc_url(wp_get_attachment_image_src(67)[0]) . '" alt="icone oeil info photo"></a>';
echo '<img class="btnopen icon-fullscreen" src="' . esc_url(wp_get_attachment_image_src(68)[0]) . '" alt="icone affichage fullscreen"/>';
echo '<h4>';
echo '<span class="cat_hover">';

// Récupére les termes de la taxonomie "catégorie"
$categories = get_the_terms(get_the_ID(), 'categorie_photo');
if ($categories) {
    foreach ($categories as $categorie) {
        echo esc_html($categorie->name) . ' ';
    }
}
echo '</span>';
echo '<span class="ref_hover">';

// Affiche le titre du post
echo the_field('reference');;
echo '</span>';
echo '</h4>';
echo '</div>';
