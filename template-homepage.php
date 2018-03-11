<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storefront_homepage_content      - 10
			 * @hooked storefront_product_categories    - 20
			 * @hooked storefront_recent_products       - 30
			 * @hooked storefront_featured_products     - 40
			 * @hooked storefront_popular_products      - 50
			 * @hooked storefront_on_sale_products      - 60
			 * @hooked storefront_best_selling_products - 70
			 */
			do_action( 'homepage' ); ?>

			<section class="storefront-product-section content-features">
				<h2 class="content-features__title"> Почему стоит работать с нами </h2>
				<ul>
					<?php
					$args = array(
							'post_type' => 'features',
							'posts_per_page' => 3
					);

					$my_query = new WP_Query( $args );

					if ( $my_query->have_posts() ) {

							while ( $my_query->have_posts() ) {
									$my_query->the_post();
									$image = get_field('features_image');
									?>

									<li class="content-features__item">
										<?php if (isset($image[url])): ?>
											<img src="<?php echo $image[sizes][thumbnail]; ?>" alt="">
										<?php else: ?>
											<i class="content-features__icon"></i>
										<?php endif; ?>
											<h3 class="content-features__subtitle"><?php the_title(); ?></h3>
											<?php the_content(); ?>
									</li>

									<?php
							}
					}
					// Reset the `$post` data to the current post in main query.
					wp_reset_postdata();
					?>
				</ul>
			</section>

			<section class="storefront-product-section content-video-wrapper">
				<iframe width="100%" height="315" src="https://www.youtube.com/embed/kFknpoSITcI" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			</section>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
