<?php
/**
 * The template for displaying search forms in tafri-travel
 *
 * @package tafri-travel
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'label', 'tafri-travel' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( get_theme_mod('tafri_travel_change_search_placeholder', __('Search', 'tafri-travel')) ); ?>" value="<?php echo get_search_query() ?>" name="s">
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_html_x( 'Search', 'submit button', 'tafri-travel' ); ?>">
</form>