<?php

///// Enregistre le menu /////
function register_menu()
{
    // Active le support des menus
    add_theme_support('menus');
    // Enregistre les emplacements des menus
    register_nav_menus(array(
        'main_menu' => 'Menu du Header',
        'footer_menu' => 'Menu du Footer',
    ));
}
add_action('after_setup_theme', 'register_menu');

///// Ajout du support pour le logo du site /////
function logo_setup()
{
    add_theme_support('custom-logo', array());
}
add_action('after_setup_theme', 'logo_setup');

///// Ajout du support pour la balise de titre /////
function theme_slug_setup()
{
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_slug_setup');

///// Déclare le CSS /////
function theme_enqueue_styles()
{
    wp_enqueue_style('motaphoto', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

///// Déclare le JS /////
function enqueue_custom_scripts()
{
    // Annule l'enregistrement du JQuery par défaut de Wordpress
    wp_deregister_script('jquery');

    //  Enregistre jQuery depuis le CDN
    wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', false);
    wp_enqueue_script('jquery');

    // Ajoute les scripts personnalisés JQuery
    wp_enqueue_script('modalescript', get_template_directory_uri() . '/js/modale.js', array('jquery'), '1.0', true);
    wp_enqueue_script('lightboxscript', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), '1.0', true);
    wp_enqueue_script('burgerscript', get_template_directory_uri() . '/js/burger-menu.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


///// Enregistre le script JavaScript de Select2 /////
function include_select2_script()
{
    wp_register_script('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), '4.1.0-rc.0', true);
    wp_enqueue_script('select2');
}
add_action('wp_enqueue_scripts', 'include_select2_script');

// Enregistre la feuille de style CSS de Select2
function include_select2_styles()
{
    wp_register_style('select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css', array(), '4.1.0-rc.0', 'all');
    wp_enqueue_style('select2');
}
add_action('wp_enqueue_scripts', 'include_select2_styles');


///// Ajoute l'URL AJAX /////
function add_ajaxurl_to_scripts()
{
    wp_enqueue_script('custom-ajax', get_template_directory_uri() . '/js/custom-ajax.js', array('jquery'), '1.0', true);

    // Définit les données AJAX à passer au script
    $ajax_data = array(
        'ajaxurl' => admin_url('admin-ajax.php')
    );
    // Ajoute les données AJAX en ligne au script custom-ajax.js
    wp_add_inline_script('custom-ajax', 'var ajaxurl = ' . json_encode($ajax_data) . ';');
}
add_action('wp_enqueue_scripts', 'add_ajaxurl_to_scripts');

///// Fonction pour filtrer les photos via AJAX /////
// Hook pour la fonction AJAX
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');

function filter_photos()
{
    // Récupére les valeurs des filtres depuis la requête AJAX
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $format = isset($_POST['format']) ? $_POST['format'] : '';
    $orderby = isset($_POST['orderby']) ? $_POST['orderby'] : '';

    // Arguments de la requête WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
    );

    // Ajout des taxonomies
    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie_photo',
            'field'    => 'id',
            'terms'    => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field'    => 'id',
            'terms'    => $format,
        );
    }

    // Ajout de l'ordre de tri
    if (!empty($orderby)) {
        if ($orderby == 'date_desc') {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ($orderby == 'date_asc') {
            $args['orderby'] = 'date';
            $args['order'] = 'ASC';
        }
    }

    // Exécute la requête WP_Query
    $photos_query = new WP_Query($args);

    ob_start(); // Commence à mettre en mémoire tampon la sortie

    if ($photos_query->have_posts()) {
        echo '<div class="photo_block">'; // Début du bloc de photos
        while ($photos_query->have_posts()) {
            $photos_query->the_post();
            get_template_part("templates_part/photo_block");
        }
        echo '</div>'; // Fin du bloc de photos
        wp_reset_postdata();
    } else {
        echo '<p class="photo_search">- Aucune photo trouvée -</p>'; // Affiche un message si aucune photo n'est trouvée
    }

    $output = ob_get_clean(); // Récupère le contenu du tampon de sortie et nettoie le tampon

    echo $output; // Renvoie le contenu HTML des photos filtrées

    wp_die();
}

///// Fonction pour charger plus de photos via AJAX /////
// Hook pour la fonction AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

function load_more_photos()
{
    // Récupére l'offset et le nombre de posts par page
    $offset = $_POST['offset'];
    $posts_per_page = $_POST['posts_per_page'];

    // Arguments pour la requête WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
    );

    // Exécute la requête WP_Query
    $photos_query = new WP_Query($args);
    ob_start(); // Commence à mettre en mémoire tampon la sortie

    if ($photos_query->have_posts()) {
        echo '<div class="photo_block">'; // Début du bloc de photos
        while ($photos_query->have_posts()) {
            $photos_query->the_post();
            get_template_part("templates_part/photo_block");
        }
        echo '</div>'; // Fin du bloc de photos
        wp_reset_postdata();
    } else {
        echo '<p class="photo_search">- Aucune photo trouvée -</p>'; // Affiche un message si aucune photo n'est trouvée
    }

    $output = ob_get_clean();

    // Renvoie le contenu HTML des photos
    echo $output;

    wp_die();
}
