<?php
/**
* Blogberg breadcrumb.
*
* @since Blogberg 1.0.0
* @uses breadcrumb_trail()
*/
require get_parent_theme_file_path( '/modules/breadcrumbs/breadcrumbs.php' );
if ( ! function_exists( 'blogberg_breadcrumb' ) ) :

	function blogberg_breadcrumb() {

		$breadcrumb_args = apply_filters( 'blogberg_breadcrumb_args', array(
			'show_browse' => false,
		) );

		breadcrumb_trail( $breadcrumb_args );
	}

endif;

function blogberg_modify_breadcrumb( $crumb ){

	$i = count( $crumb ) - 1;
	$title = $crumb[ $i ];

	$crumb[ $i ] = $title;

	return $crumb;
}
add_filter( 'breadcrumb_trail_items', 'blogberg_modify_breadcrumb' );