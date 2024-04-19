<?php get_header(); ?>
<?php
get_template_part('templates_part/hero');
?>
<!-- Création des filtres -->
<section id="filters">
    <div class="filter-group1">
        <!-- Sélecteur de catégories -->
        <select class="select2" name="categorie_photo" id="category-filter">
            <option value="" selected disabled hidden>CATÉGORIES</option>
            <?php
            // Récupère toutes les catégories de photos
            $categories = get_terms('categorie_photo');
            // Boucle à travers chaque catégorie
            foreach ($categories as $category) {
                // Affiche une option pour chaque catégorie
                echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
            }
            ?>
        </select>

        <!-- Sélecteur de formats -->
        <select class="select2" name="format" id="format-filter">
            <option value="" selected disabled hidden>FORMATS</option>
            <?php
            // Récupère tous les formats de photos
            $formats = get_terms('format');
            // Boucle à travers chaque format
            foreach ($formats as $format) {
                // Affiche une option pour chaque format
                echo '<option value="' . $format->term_id . '">' . $format->name . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="filter-group2">
        <!-- Sélecteur de tri -->
        <select class="select2" name="orderby" id="sort-filter">
            <option value="" selected disabled hidden>TRIER PAR</option>
            <option value="date_desc" <?php echo isset($_GET['orderby']) && $_GET['orderby'] == 'date_desc' ? 'selected' : ''; ?>>Ordre croissant</option>
            <option value="date_asc" <?php echo isset($_GET['orderby']) && $_GET['orderby'] == 'date_asc' ? 'selected' : ''; ?>>Ordre décroissant</option>
        </select>
    </div>
</section>

<!-- Section pour afficher les photos -->
<section class="page-container">
    <div class="index_img">
        <?php
        // Arguments de la requête WP_Query pour afficher les photos
        $args_photo_index = array(
            'post_type'      => 'photo',
            'posts_per_page' => 8,
        );

        // Exécute la requête pour récupérer les photos
        $related_query = new WP_Query($args_photo_index);

        if ($related_query->have_posts()) :
            echo '<div class="photo_block">';
            // Boucle à travers chaque photo
            while ($related_query->have_posts()) :
                $related_query->the_post();
                // Inclut le template pour afficher la photo
                get_template_part("templates_part/photo_block");
            endwhile;
            echo '</div>';
            // Réinitialise les données de la requête des posts
            wp_reset_postdata();
        else :
            // Affiche un message si aucune photo n'est trouvée
            echo '<p>Aucune photo trouvée.</p>';
        endif;
        ?>
    </div>
</section>

<!-- Bouton pour charger plus de photos via AJAX -->
<div id="load-more">
    <button id="load-more-button" class="load-more-text">Charger plus</button>
</div>


<?php get_footer(); ?>