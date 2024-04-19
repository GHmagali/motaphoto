<?php
// Arguments pour récupérer une photo de manière aléatoire
$args = array(
    'post_type' => 'photo',
    'posts_per_page' => 1,
    'orderby' => 'rand' // Ordonne les résultats de manière aléatoire
);
// Exécute la requête
$random_post = new WP_Query($args);

// Vérifie s'il y a des custom posts
if ($random_post->have_posts()) {
    // Boucle à travers les posts récupérés
    while ($random_post->have_posts()) {
        $random_post->the_post();
        // Récupère l'URL de l'image du post actuel
        $image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0];
    }
}
// Réinitialise les données de la requête
wp_reset_postdata();
?>
<section id="hero">
    <div class="hero_photo" style="background-image: url('<?php echo $image_url; ?>');">
        <!-- Titre du héros -->
        <h1>PHOTOGRAPHE EVENT</h1>
    </div>
</section>