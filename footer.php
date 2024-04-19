<?php
get_template_part('templates_part/modale');
get_template_part('templates_part/lightbox');
wp_footer();

wp_nav_menu(array(
    'theme_location' => 'footer_menu',
    'menu_class' => 'menu-footer',
));
?>

</body>

</html>