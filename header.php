<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>motaphoto</title>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <div id="header">
        <!-- vérifie si le thème a un logo personnalisé et l'affiche -->
        <?php if (has_custom_logo()) : ?>
            <div class="site-logo"><?php the_custom_logo(); ?></div>
        <?php endif; ?>
        <nav id="header-menu">
            <!-- Récupére et affiche le menu principal -->
            <?php
            wp_nav_menu(array(
                'theme_location' => 'main_menu',
                'container'      => 'ul',
                'menu_class'     => 'menu-header',
            ));
            ?>
        </nav>
        <!-- Crée le bouton du menu hamburger sur mobile et tablette -->
        <div id="icon" class="burger__btn">
            <span class="line1"></span>
            <span class="line2"></span>
            <span class="line3"></span>
        </div>
    </div>
</body>