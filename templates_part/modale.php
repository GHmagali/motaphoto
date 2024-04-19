<!-- Création de la modale -->
<div id="myModal" class="modal slideInDown">

    <!-- Ajoute le contenu de la modale -->
    <div class="modal-content">
        <?php echo wp_get_attachment_image(60, 'full');  ?>
        <!-- Ajoute le shortcode du formulaire -->
        <?php echo do_shortcode('[contact-form-7 id="c4a2f04" title="contact"]'); ?>
    </div>

</div>