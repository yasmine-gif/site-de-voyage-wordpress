<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Blogberg 1.0.0
 */
get_header();

if( get_theme_mod( 'disable_page_title' ) == 'disable_all_pages' ){
	// this condition will disable page title from all pages
}elseif( is_front_page() && get_theme_mod( 'disable_page_title' ) == 'disable_front_page' ){
	// this condition will disable page title from front page only
}else {
	blogberg_inner_banner();
}
?>
<section class="wrap-detail-page">
	<div class="container">
		<?php $feature_image_class = 'col-lg-12'; ?>
		<div class="row">
			<div class="<?php echo esc_attr( $feature_image_class ); ?>">
				<?php if( has_post_thumbnail() && !blogberg_get_option( 'disable_page_feature_image' ) ): ?>
				    <div class="post-thumbnail">
				        <?php the_post_thumbnail( 'blogberg-1200-710' ); ?>
				    </div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<?php if( blogberg_get_option( 'page_layout' ) == 'left' ): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			<?php $class = ''; ?>
			<?php
				if( blogberg_get_option( 'page_layout' ) == 'none' ) {
					$class = 'col-lg-12';
				}else {
					$class = 'col-lg-8';
				}
			?>
				<div class="<?php echo esc_attr( $class ); ?>">
					<?php
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/page/content', '' );
					endwhile; # End of the loop.
					?>
				</div>
			<?php if( blogberg_get_option( 'page_layout' ) == 'right' ): ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php
get_footer();