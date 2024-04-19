<?php

/**
 * The template for displaying the custom post type "photo"
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 
 */

get_header();


// Récupére les photos et les informations associées
while (have_posts()) :
	the_post();
?>
	<article class="single_photo page-container" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<section class="single_content">
			<div class="single_title">
				<!-- Affiche le titre de la publication -->
				<h2><?php the_title(); ?></h2>
			</div>
			<div class="single_info">
				<ul>
					<li>
						<p>RÉFÉRENCE :
							<span id="ref_photo"><?php
													// Affiche le champ personnalisé ACF "référence"
													the_field('reference'); ?></span>
						</p>
					</li>

					<li>
						<p>CATÉGORIE :
							<?php
							// Récupére les termes de la taxonomie "catégorie"
							$categories = get_the_terms(get_the_ID(), 'categorie_photo');
							if ($categories) {
								foreach ($categories as $categorie) {
									echo esc_html($categorie->name) . '';
								}
							}
							?>
						</p>
					</li>

					<li>
						<p>FORMAT :
							<?php
							// Récupére les termes de la taxonomie "format"
							$formats = get_the_terms(get_the_ID(), 'format');
							if ($formats) {
								foreach ($formats as $format) {
									echo '' . esc_html($format->name) . '';
								}
							}
							?>
						</p>
					</li>

					<li>
						<p>TYPE :
							<?php
							// Affiche le champ personnalisé ACF "type"
							the_field('type');
							$reference = get_field('type'); ?>
						</p>
					</li>
					<li>
						<p>ANNÉE :
							<?php
							// Récupère l'année de publication 
							$year = get_the_date('Y');
							echo $year;
							?>
						</p>
					</li>
				</ul>
			</div>
		</section>
		<section class="single_img"> <?php
										// Récupére la photo mise en avant
										$thumbnail = get_the_post_thumbnail(null, 'full');

										// Affiche la photo
										if ($thumbnail) {
											echo $thumbnail;
										}
										?>
		</section>
	</article>

	<!-- Création de la section contact -->
	<section class="page-container">
		<div class="single_contact">
			<p>Cette photo vous intéresse ?</p>
			<button class="btn_contact">Contact</button>

			<!-- Création du slider -->
			<div class="slider">
				<?php
				// Récupére les IDs des posts précédent et suivant
				$next = get_adjacent_post(false, "", false);
				$prev = get_adjacent_post(false, "", true);

				// Si $next est vide (dernier post), récupére le premier post
				if (empty($next)) {
					$args = array(
						'post_type' => 'photo',
						'posts_per_page' => 1,
						'order' => 'ASC',
					);
					$first_posts = get_posts($args);
					$next = $first_posts[0];
				}

				// Si $prev est vide (premier post), récupére le dernier post
				if (empty($prev)) {
					$args = array(
						'post_type' => 'photo',
						'posts_per_page' => 1,
						'order' => 'DESC',
					);
					$last_posts = get_posts($args);
					$prev = $last_posts[0];
				}
				?>

				<div class="nav_slide">
					<!-- Récupère l'URL et l'image de la publication suivante -->
					<a href="<?php echo get_permalink($next->ID) ?>">
						<img class="arrow_slide" src=" <?= wp_get_attachment_image_src(62)[0]; ?>" alt="flèche droite">
						<img class="thumb_slide_prev" src="<?php echo get_the_post_thumbnail_url($next->ID) ?>" />
					</a>
					<!-- Récupère l'URL et l'image de la publication précédente -->
					<a href="<?php echo get_permalink($prev->ID) ?>">
						<img class="arrow_slide" src="<?= wp_get_attachment_image_src(63)[0]; ?>" alt="flèche gauche">
						<img class="thumb_slide_next" src="<?php echo get_the_post_thumbnail_url($prev->ID) ?>" />
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Création de la section des photos associées -->
	<section class="page-container">
		<h3 class="related_text">VOUS AIMEREZ AUSSI</h3>
		<div class="photo_related photo_block">
			<?php
			// Récupére les publications de la même catégorie 
			$args_photo_block = array(
				'post_type'      => 'photo',
				'posts_per_page' => 2,
				'post__not_in'   => array(get_the_ID()),
				'tax_query'      => array(
					array(
						'taxonomy' => 'categorie_photo',
						'field'    => 'id',
						'terms'    => wp_get_post_terms(get_the_ID(), 'categorie_photo', array('fields' => 'ids')),
					),
				),
			);
			// Exécute la requête pour récupérer les publications
			$related_query = new WP_Query($args_photo_block);

			if ($related_query->have_posts()) :
				while ($related_query->have_posts()) :
					$related_query->the_post();
					// Inclut le modèle pour afficher les publications
					get_template_part("templates_part/photo_block");
				endwhile;
				// Réinitialise les données de la requête des posts
				wp_reset_postdata();
			else :
				echo '<p class="photo_search">- Aucune photo trouvée -</p>';
			endif;
			?>
		</div>
	</section>
<?php endwhile;

get_footer();
