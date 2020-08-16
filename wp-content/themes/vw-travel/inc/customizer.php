<?php
/**
 * VW Travel Theme Customizer
 *
 * @package VW Travel
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function vw_travel_custom_controls() {
    load_template( trailingslashit( get_template_directory() ) . '/inc/custom-controls.php' );
}
add_action( 'customize_register', 'vw_travel_custom_controls' );

function vw_travel_customize_register( $wp_customize ) {

	load_template( trailingslashit( get_template_directory() ) . 'inc/customize-homepage/class-customize-homepage.php' );

	load_template( trailingslashit( get_template_directory() ) . '/inc/icon-picker.php' );

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage'; 
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'blogname', array( 
		'selector' => '.logo .site-title a', 
	 	'render_callback' => 'vw_travel_customize_partial_blogname', 
	)); 

	$wp_customize->selective_refresh->add_partial( 'blogdescription', array( 
		'selector' => 'p.site-description', 
		'render_callback' => 'vw_travel_customize_partial_blogdescription', 
	));

	//add home page setting pannel
	$VWTravelParentPanel = new VW_Travel_WP_Customize_Panel( $wp_customize, 'vw_travel_panel_id', array(
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => 'VW Settings',
		'priority' => 10,
	));

	// Layout
	$wp_customize->add_section( 'vw_travel_left_right', array(
    	'title'      => __( 'General Settings', 'vw-travel' ),
		'panel' => 'vw_travel_panel_id'
	) );

	$wp_customize->add_setting('vw_travel_width_option',array(
        'default' => __('Full Width','vw-travel'),
        'sanitize_callback' => 'vw_travel_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Travel_Image_Radio_Control($wp_customize, 'vw_travel_width_option', array(
        'type' => 'select',
        'label' => __('Width Layouts','vw-travel'),
        'description' => __('Here you can change the width layout of Website.','vw-travel'),
        'section' => 'vw_travel_left_right',
        'choices' => array(
            'Full Width' => get_template_directory_uri().'/assets/images/full-width.png',
            'Wide Width' => get_template_directory_uri().'/assets/images/wide-width.png',
            'Boxed' => get_template_directory_uri().'/assets/images/boxed-width.png',
        ))));

	$wp_customize->add_setting('vw_travel_theme_options',array(
        'default' => __('Right Sidebar','vw-travel'),
        'sanitize_callback' => 'vw_travel_sanitize_choices'
	));
	$wp_customize->add_control('vw_travel_theme_options',array(
        'type' => 'select',
        'label' => __('Post Sidebar Layout','vw-travel'),
        'description' => __('Here you can change the sidebar layout for posts. ','vw-travel'),
        'section' => 'vw_travel_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-travel'),
            'Right Sidebar' => __('Right Sidebar','vw-travel'),
            'One Column' => __('One Column','vw-travel'),
            'Three Columns' => __('Three Columns','vw-travel'),
            'Four Columns' => __('Four Columns','vw-travel'),
            'Grid Layout' => __('Grid Layout','vw-travel')
        ),
	) );

	$wp_customize->add_setting('vw_travel_page_layout',array(
        'default' => __('One Column','vw-travel'),
        'sanitize_callback' => 'vw_travel_sanitize_choices'
	));
	$wp_customize->add_control('vw_travel_page_layout',array(
        'type' => 'select',
        'label' => __('Page Sidebar Layout','vw-travel'),
        'description' => __('Here you can change the sidebar layout for pages. ','vw-travel'),
        'section' => 'vw_travel_left_right',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','vw-travel'),
            'Right Sidebar' => __('Right Sidebar','vw-travel'),
            'One Column' => __('One Column','vw-travel')
        ),
	) );

	//Woocommerce Shop Page Sidebar
	$wp_customize->add_setting( 'vw_travel_woocommerce_shop_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_travel_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_woocommerce_shop_page_sidebar',array(
		'label' => esc_html__( 'Shop Page Sidebar','vw-travel' ),
		'section' => 'vw_travel_left_right'
    )));

    //Woocommerce Single Product page Sidebar
	$wp_customize->add_setting( 'vw_travel_woocommerce_single_product_page_sidebar',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_travel_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_woocommerce_single_product_page_sidebar',array(
		'label' => esc_html__( 'Single Product Sidebar','vw-travel' ),
		'section' => 'vw_travel_left_right'
    )));

	//Pre-Loader
	$wp_customize->add_setting( 'vw_travel_loader_enable',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_travel_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_loader_enable',array(
        'label' => esc_html__( 'Pre-Loader','vw-travel' ),
        'section' => 'vw_travel_left_right'
    )));

	$wp_customize->add_setting('vw_travel_loader_icon',array(
        'default' => __('Two Way','vw-travel'),
        'sanitize_callback' => 'vw_travel_sanitize_choices'
	));
	$wp_customize->add_control('vw_travel_loader_icon',array(
        'type' => 'select',
        'label' => __('Pre-Loader Type','vw-travel'),
        'section' => 'vw_travel_left_right',
        'choices' => array(
            'Two Way' => __('Two Way','vw-travel'),
            'Dots' => __('Dots','vw-travel'),
            'Rotate' => __('Rotate','vw-travel')
        ),
	) );

	//Topbar
	$wp_customize->add_section( 'vw_travel_topbar', array(
    	'title'      => __( 'Topbar Settings', 'vw-travel' ),
		'panel' => 'vw_travel_panel_id'
	) );

	$wp_customize->add_setting( 'vw_travel_topbar_hide_show',
       array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_topbar_hide_show',
       array(
      'label' => esc_html__( 'Show / Hide Topbar','vw-travel' ),
      'section' => 'vw_travel_topbar'
    )));

    $wp_customize->add_setting('vw_travel_topbar_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_topbar_padding_top_bottom',array(
		'label'	=> __('Topbar Padding Top Bottom','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_topbar',
		'type'=> 'text'
	));

    //Sticky Header
	$wp_customize->add_setting( 'vw_travel_sticky_header',array(
        'default' => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_travel_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_sticky_header',array(
        'label' => esc_html__( 'Sticky Header','vw-travel' ),
        'section' => 'vw_travel_topbar'
    )));

    $wp_customize->add_setting('vw_travel_sticky_header_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_sticky_header_padding',array(
		'label'	=> __('Sticky Header Padding','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_travel_header_search',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_header_search',
       array(
		'label' => esc_html__( 'Show / Hide Search','vw-travel' ),
		'section' => 'vw_travel_topbar'
    )));

    $wp_customize->add_setting('vw_travel_search_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_search_font_size',array(
		'label'	=> __('Search Font Size','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_search_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_search_padding_top_bottom',array(
		'label'	=> __('Search Padding Top Bottom','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_search_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_search_padding_left_right',array(
		'label'	=> __('Search Padding Left Right','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_travel_search_border_radius', array(
		'default'              => "",
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_travel_search_border_radius', array(
		'label'       => esc_html__( 'Search Border Radius','vw-travel' ),
		'section'     => 'vw_travel_topbar',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_travel_location', array( 
		'selector' => 'p.email-id', 
		'render_callback' => 'vw_travel_customize_partial_vw_travel_location', 
	));

    $wp_customize->add_setting('vw_travel_location_icon',array(
		'default'	=> 'fas fa-location-arrow',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Travel_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_travel_location_icon',array(
		'label'	=> __('Add Location Icon','vw-travel'),
		'transport' => 'refresh',
		'section'	=> 'vw_travel_topbar',
		'setting'	=> 'vw_travel_location_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_travel_location',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_location',array(
		'label'	=> __('Add Location','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '828 N. Iqyreesrs Street Liocnss Park', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_phone_number',array(
		'default'=> '',
		'sanitize_callback'	=> 'vw_travel_sanitize_phone_number'
	));
	$wp_customize->add_control('vw_travel_phone_number',array(
		'label'	=> __('Add Phone Number','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '+00 987 654 1230', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_topbar',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_email_addres_icon',array(
		'default'	=> 'far fa-envelope',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Travel_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_travel_email_addres_icon',array(
		'label'	=> __('Add Email Icon','vw-travel'),
		'transport' => 'refresh',
		'section'	=> 'vw_travel_topbar',
		'setting'	=> 'vw_travel_email_addres_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_travel_email_address',array(
		'default'=> '',
		'sanitize_callback'	=> 'vw_travel_sanitize_email'
	));
	$wp_customize->add_control('vw_travel_email_address',array(
		'label'	=> __('Add Email Address','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( 'example@gmail.com', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_topbar',
		'type'=> 'text'
	));
    
	//Slider
	$wp_customize->add_section( 'vw_travel_slidersettings' , array(
    	'title'      => __( 'Slider Settings', 'vw-travel' ),
		'panel' => 'vw_travel_panel_id'
	) );

	$wp_customize->add_setting( 'vw_travel_slider_arrows',
       array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_slider_arrows',
       array(
      'label' => esc_html__( 'Show / Hide Slider','vw-travel' ),
      'section' => 'vw_travel_slidersettings'
    )));

    //Selective Refresh
    $wp_customize->selective_refresh->add_partial('vw_travel_slider_arrows',array(
		'selector'        => '#slider .inner_carousel h1',
		'render_callback' => 'vw_travel_customize_partial_vw_travel_slider_arrows',
	));

	for ( $count = 1; $count <= 4; $count++ ) {
		$wp_customize->add_setting( 'vw_travel_slider_page' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'vw_travel_sanitize_dropdown_pages'
		) );
		$wp_customize->add_control( 'vw_travel_slider_page' . $count, array(
			'label'    => __( 'Select Slider Page', 'vw-travel' ),
			'description' => __('Slider image size (1500 x 765)','vw-travel'),
			'section'  => 'vw_travel_slidersettings',
			'type'     => 'dropdown-pages'
		) );
	}

	$wp_customize->add_setting('vw_travel_slider_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_slider_button_text',array(
		'label'	=> __('Add Slider Button Text','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( 'View Tours', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_slidersettings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_slider_button_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Travel_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_travel_slider_button_icon',array(
		'label'	=> __('Add Slider Button Icon','vw-travel'),
		'transport' => 'refresh',
		'section'	=> 'vw_travel_slidersettings',
		'setting'	=> 'vw_travel_slider_button_icon',
		'type'		=> 'icon'
	)));

	//content layout
	$wp_customize->add_setting('vw_travel_slider_content_option',array(
        'default' => __('Center','vw-travel'),
        'sanitize_callback' => 'vw_travel_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Travel_Image_Radio_Control($wp_customize, 'vw_travel_slider_content_option', array(
        'type' => 'select',
        'label' => __('Slider Content Layouts','vw-travel'),
        'section' => 'vw_travel_slidersettings',
        'choices' => array(
            'Left' => get_template_directory_uri().'/assets/images/slider-content1.png',
            'Center' => get_template_directory_uri().'/assets/images/slider-content2.png',
            'Right' => get_template_directory_uri().'/assets/images/slider-content3.png',
    ))));


	//Slider excerpt
	$wp_customize->add_setting( 'vw_travel_slider_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_travel_slider_excerpt_number', array(
		'label'       => esc_html__( 'Slider Excerpt length','vw-travel' ),
		'section'     => 'vw_travel_slidersettings',
		'type'        => 'range',
		'settings'    => 'vw_travel_slider_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 15,
			'max'              => 50,
		),
	) );

	//Opacity
	$wp_customize->add_setting('vw_travel_slider_opacity_color',array(
      'default'              => 0.5,
      'sanitize_callback' => 'vw_travel_sanitize_choices'
	));

	$wp_customize->add_control( 'vw_travel_slider_opacity_color', array(
	'label'       => esc_html__( 'Slider Image Opacity','vw-travel' ),
	'section'     => 'vw_travel_slidersettings',
	'type'        => 'select',
	'settings'    => 'vw_travel_slider_opacity_color',
	'choices' => array(
      '0' =>  esc_attr('0','vw-travel'),
      '0.1' =>  esc_attr('0.1','vw-travel'),
      '0.2' =>  esc_attr('0.2','vw-travel'),
      '0.3' =>  esc_attr('0.3','vw-travel'),
      '0.4' =>  esc_attr('0.4','vw-travel'),
      '0.5' =>  esc_attr('0.5','vw-travel'),
      '0.6' =>  esc_attr('0.6','vw-travel'),
      '0.7' =>  esc_attr('0.7','vw-travel'),
      '0.8' =>  esc_attr('0.8','vw-travel'),
      '0.9' =>  esc_attr('0.9','vw-travel')
	),
	));

	//Slider height
	$wp_customize->add_setting('vw_travel_slider_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_slider_height',array(
		'label'	=> __('Slider Height','vw-travel'),
		'description'	=> __('Specify the slider height (px).','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '500px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_slidersettings',
		'type'=> 'text'
	));
    
	//Top Destination section
	$wp_customize->add_section( 'vw_travel_top_destination_section' , array(
    	'title'      => __( 'Top Destination Settings', 'vw-travel' ),
		'priority'   => null,
		'panel' => 'vw_travel_panel_id'
	) );

	$wp_customize->add_setting( 'vw_travel_post_hide_show',
       array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_post_hide_show',
       array(
      'label' => esc_html__( 'Show / Hide Top Destination','vw-travel' ),
      'section' => 'vw_travel_top_destination_section'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial( 'vw_travel_section_title', array( 
		'selector' => '#top-destination h2', 
		'render_callback' => 'vw_travel_customize_partial_vw_travel_section_title',
	));

	$wp_customize->add_setting('vw_travel_section_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_section_title',array(
		'label'	=> __('Add Section Title','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( 'Explore Top Destination', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_top_destination_section',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_top_destination_number',array(
		'default'	=> 0,
		'sanitize_callback'	=> 'sanitize_text_field',
	));
	$wp_customize->add_control('vw_travel_top_destination_number',array(
		'label'	=> __('Number of Top Destination to show','vw-travel'),
		'description' => __('Images Size (370 x 360)','vw-travel'),
		'section'	=> 'vw_travel_top_destination_section',
		'type'		=> 'number'
	));

	//Blog Post
	$wp_customize->add_panel( $VWTravelParentPanel );

	$BlogPostParentPanel = new VW_Travel_WP_Customize_Panel( $wp_customize, 'blog_post_parent_panel', array(
		'title' => __( 'Blog Post Settings', 'vw-travel' ),
		'panel' => 'vw_travel_panel_id',
	));

	$wp_customize->add_panel( $BlogPostParentPanel );

	// Add example section and controls to the middle (second) panel
	$wp_customize->add_section( 'vw_travel_post_settings', array(
		'title' => __( 'Post Settings', 'vw-travel' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_travel_toggle_postdate', array( 
		'selector' => '.post-main-box h2 a', 
		'render_callback' => 'vw_travel_customize_partial_vw_travel_toggle_postdate', 
	));

	$wp_customize->add_setting( 'vw_travel_toggle_postdate',array(
        'default' => 1,
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_travel_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_toggle_postdate',array(
        'label' => esc_html__( 'Post Date','vw-travel' ),
        'section' => 'vw_travel_post_settings'
    )));

    $wp_customize->add_setting( 'vw_travel_toggle_author',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_travel_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_toggle_author',array(
		'label' => esc_html__( 'Author','vw-travel' ),
		'section' => 'vw_travel_post_settings'
    )));

    $wp_customize->add_setting( 'vw_travel_toggle_comments',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_travel_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_toggle_comments',array(
		'label' => esc_html__( 'Comments','vw-travel' ),
		'section' => 'vw_travel_post_settings'
    )));

    $wp_customize->add_setting( 'vw_travel_toggle_tags',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_travel_switch_sanitization'
	));
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_toggle_tags', array(
		'label' => esc_html__( 'Tags','vw-travel' ),
		'section' => 'vw_travel_post_settings'
    )));

    $wp_customize->add_setting( 'vw_travel_excerpt_number', array(
		'default'              => 30,
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_travel_excerpt_number', array(
		'label'       => esc_html__( 'Excerpt length','vw-travel' ),
		'section'     => 'vw_travel_post_settings',
		'type'        => 'range',
		'settings'    => 'vw_travel_excerpt_number',
		'input_attrs' => array(
			'step'             => 5,
			'min'              => 0,
			'max'              => 50,
		),
	) );

	//Blog layout
    $wp_customize->add_setting('vw_travel_blog_layout_option',array(
        'default' => __('Default','vw-travel'),
        'sanitize_callback' => 'vw_travel_sanitize_choices'
    ));
    $wp_customize->add_control(new VW_Travel_Image_Radio_Control($wp_customize, 'vw_travel_blog_layout_option', array(
        'type' => 'select',
        'label' => __('Blog Layouts','vw-travel'),
        'section' => 'vw_travel_post_settings',
        'choices' => array(
            'Default' => get_template_directory_uri().'/assets/images/blog-layout1.png',
            'Center' => get_template_directory_uri().'/assets/images/blog-layout2.png',
            'Left' => get_template_directory_uri().'/assets/images/blog-layout3.png',
    ))));

    $wp_customize->add_setting('vw_travel_excerpt_settings',array(
        'default' => __('Excerpt','vw-travel'),
        'transport' => 'refresh',
        'sanitize_callback' => 'vw_travel_sanitize_choices'
	));
	$wp_customize->add_control('vw_travel_excerpt_settings',array(
        'type' => 'select',
        'label' => __('Post Content','vw-travel'),
        'section' => 'vw_travel_post_settings',
        'choices' => array(
        	'Content' => __('Content','vw-travel'),
            'Excerpt' => __('Excerpt','vw-travel'),
            'No Content' => __('No Content','vw-travel')
        ),
	) );

	$wp_customize->add_setting('vw_travel_excerpt_suffix',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_excerpt_suffix',array(
		'label'	=> __('Add Excerpt Suffix','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '[...]', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_post_settings',
		'type'=> 'text'
	));

    // Button Settings
	$wp_customize->add_section( 'vw_travel_button_settings', array(
		'title' => __( 'Button Settings', 'vw-travel' ),
		'panel' => 'blog_post_parent_panel',
	));

	$wp_customize->add_setting('vw_travel_button_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_button_padding_top_bottom',array(
		'label'	=> __('Padding Top Bottom','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_button_padding_left_right',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_button_padding_left_right',array(
		'label'	=> __('Padding Left Right','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_travel_button_border_radius', array(
		'default'              => '',
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_travel_button_border_radius', array(
		'label'       => esc_html__( 'Button Border Radius','vw-travel' ),
		'section'     => 'vw_travel_button_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_travel_button_text', array( 
		'selector' => '.post-main-box .more-btn a', 
		'render_callback' => 'vw_travel_customize_partial_vw_travel_button_text', 
	));

	$wp_customize->add_setting('vw_travel_button_text',array(
		'default'=> 'READ MORE',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_button_text',array(
		'label'	=> __('Add Button Text','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( 'READ MORE', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_button_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_blog_button_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Travel_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_travel_blog_button_icon',array(
		'label'	=> __('Add Button Icon','vw-travel'),
		'transport' => 'refresh',
		'section'	=> 'vw_travel_button_settings',
		'setting'	=> 'vw_travel_blog_button_icon',
		'type'		=> 'icon'
	)));

	// Related Post Settings
	$wp_customize->add_section( 'vw_travel_related_posts_settings', array(
		'title' => __( 'Related Posts Settings', 'vw-travel' ),
		'panel' => 'blog_post_parent_panel',
	));

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_travel_related_post_title', array( 
		'selector' => '.related-post h3', 
		'render_callback' => 'vw_travel_customize_partial_vw_travel_related_post_title', 
	));

    $wp_customize->add_setting( 'vw_travel_related_post',array(
		'default' => 1,
		'transport' => 'refresh',
		'sanitize_callback' => 'vw_travel_switch_sanitization'
    ) );
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_related_post',array(
		'label' => esc_html__( 'Related Post','vw-travel' ),
		'section' => 'vw_travel_related_posts_settings'
    )));

    $wp_customize->add_setting('vw_travel_related_post_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_related_post_title',array(
		'label'	=> __('Add Related Post Title','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( 'Related Post', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_related_posts_settings',
		'type'=> 'text'
	));

   	$wp_customize->add_setting('vw_travel_related_posts_count',array(
		'default'=> '3',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_related_posts_count',array(
		'label'	=> __('Add Related Post Count','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '3', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_related_posts_settings',
		'type'=> 'number'
	));

    //404 Page Setting
	$wp_customize->add_section('vw_travel_404_page',array(
		'title'	=> __('404 Page Settings','vw-travel'),
		'panel' => 'vw_travel_panel_id',
	));	

	$wp_customize->add_setting('vw_travel_404_page_title',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_travel_404_page_title',array(
		'label'	=> __('Add Title','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '404 Not Found', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_404_page_content',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));

	$wp_customize->add_control('vw_travel_404_page_content',array(
		'label'	=> __('Add Text','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( 'Looks like you have taken a wrong turn, Dont worry, it happens to the best of us.', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_404_page_button_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_404_page_button_text',array(
		'label'	=> __('Add Button Text','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( 'Go Back', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_404_page',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_404_page_button_icon',array(
		'default'	=> 'fas fa-long-arrow-alt-right',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Travel_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_travel_404_page_button_icon',array(
		'label'	=> __('Add Button Icon','vw-travel'),
		'transport' => 'refresh',
		'section'	=> 'vw_travel_404_page',
		'setting'	=> 'vw_travel_404_page_button_icon',
		'type'		=> 'icon'
	)));

	//Social Icon Setting
	$wp_customize->add_section('vw_travel_social_icon_settings',array(
		'title'	=> __('Social Icons Settings','vw-travel'),
		'panel' => 'vw_travel_panel_id',
	));	

	$wp_customize->add_setting('vw_travel_social_icon_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_social_icon_font_size',array(
		'label'	=> __('Icon Font Size','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_social_icon_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_social_icon_padding',array(
		'label'	=> __('Icon Padding','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_social_icon_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_social_icon_width',array(
		'label'	=> __('Icon Width','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_social_icon_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_social_icon_height',array(
		'label'	=> __('Icon Height','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_social_icon_settings',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_travel_social_icon_border_radius', array(
		'default'              => '',
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_travel_social_icon_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-travel' ),
		'section'     => 'vw_travel_social_icon_settings',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	//Responsive Media Settings
	$wp_customize->add_section('vw_travel_responsive_media',array(
		'title'	=> __('Responsive Media','vw-travel'),
		'panel' => 'vw_travel_panel_id',
	));

	$wp_customize->add_setting( 'vw_travel_resp_topbar_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_resp_topbar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Topbar','vw-travel' ),
      'section' => 'vw_travel_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_travel_stickyheader_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_stickyheader_hide_show',array(
      'label' => esc_html__( 'Sticky Header','vw-travel' ),
      'section' => 'vw_travel_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_travel_resp_slider_hide_show',array(
      'default' => 0,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_resp_slider_hide_show',array(
      'label' => esc_html__( 'Show / Hide Slider','vw-travel' ),
      'section' => 'vw_travel_responsive_media'
    )));

	$wp_customize->add_setting( 'vw_travel_metabox_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_metabox_hide_show',array(
      'label' => esc_html__( 'Show / Hide Metabox','vw-travel' ),
      'section' => 'vw_travel_responsive_media'
    )));

    $wp_customize->add_setting( 'vw_travel_sidebar_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_sidebar_hide_show',array(
      'label' => esc_html__( 'Show / Hide Sidebar','vw-travel' ),
      'section' => 'vw_travel_responsive_media'
    )));

     $wp_customize->add_setting( 'vw_travel_resp_scroll_top_hide_show',array(
      'default' => 1,
      'transport' => 'refresh',
      'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_resp_scroll_top_hide_show',array(
      'label' => esc_html__( 'Show / Hide Scroll To Top','vw-travel' ),
      'section' => 'vw_travel_responsive_media'
    )));

    $wp_customize->add_setting('vw_travel_res_open_menu_icon',array(
		'default'	=> 'fas fa-bars',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Travel_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_travel_res_open_menu_icon',array(
		'label'	=> __('Add Open Menu Icon','vw-travel'),
		'transport' => 'refresh',
		'section'	=> 'vw_travel_responsive_media',
		'setting'	=> 'vw_travel_res_open_menu_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_travel_res_close_menus_icon',array(
		'default'	=> 'fas fa-times',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Travel_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_travel_res_close_menus_icon',array(
		'label'	=> __('Add Close Menu Icon','vw-travel'),
		'transport' => 'refresh',
		'section'	=> 'vw_travel_responsive_media',
		'setting'	=> 'vw_travel_res_close_menus_icon',
		'type'		=> 'icon'
	)));

	//Content Creation
	$wp_customize->add_section( 'vw_travel_content_section' , array(
    	'title' => __( 'Customize Home Page Settings', 'vw-travel' ),
		'priority' => null,
		'panel' => 'vw_travel_panel_id'
	) );

	$wp_customize->add_setting('vw_travel_content_creation_main_control', array(
		'sanitize_callback' => 'esc_html',
	) );

	$homepage= get_option( 'page_on_front' );

	$wp_customize->add_control(	new VW_Travel_Content_Creation( $wp_customize, 'vw_travel_content_creation_main_control', array(
		'options' => array(
			esc_html__( 'First select static page in homepage setting for front page.Below given edit button is to customize Home Page. Just click on the edit option, add whatever elements you want to include in the homepage, save the changes and you are good to go.','vw-travel' ),
		),
		'section' => 'vw_travel_content_section',
		'button_url'  => admin_url( 'post.php?post='.$homepage.'&action=edit'),
		'button_text' => esc_html__( 'Edit', 'vw-travel' ),
	) ) );

	//Footer Text
	$wp_customize->add_section('vw_travel_footer',array(
		'title'	=> __('Footer Settings','vw-travel'),
		'panel' => 'vw_travel_panel_id',
	));	

	//Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_travel_footer_text', array( 
		'selector' => '#footer-2 .copyright p', 
		'render_callback' => 'vw_travel_customize_partial_vw_travel_footer_text', 
	));
	
	$wp_customize->add_setting('vw_travel_footer_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('vw_travel_footer_text',array(
		'label'	=> __('Copyright Text','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( 'Copyright 2019, .....', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_footer',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('vw_travel_copyright_alingment',array(
        'default' => __('center','vw-travel'),
        'sanitize_callback' => 'vw_travel_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Travel_Image_Radio_Control($wp_customize, 'vw_travel_copyright_alingment', array(
        'type' => 'select',
        'label' => __('Copyright Alignment','vw-travel'),
        'section' => 'vw_travel_footer',
        'settings' => 'vw_travel_copyright_alingment',
        'choices' => array(
            'left' => get_template_directory_uri().'/assets/images/copyright1.png',
            'center' => get_template_directory_uri().'/assets/images/copyright2.png',
            'right' => get_template_directory_uri().'/assets/images/copyright3.png'
    ))));

    $wp_customize->add_setting('vw_travel_copyright_padding_top_bottom',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_copyright_padding_top_bottom',array(
		'label'	=> __('Copyright Padding Top Bottom','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_travel_hide_show_scroll',array(
    	'default' => 1,
      	'transport' => 'refresh',
      	'sanitize_callback' => 'vw_travel_switch_sanitization'
    ));  
    $wp_customize->add_control( new VW_Travel_Toggle_Switch_Custom_Control( $wp_customize, 'vw_travel_hide_show_scroll',array(
      	'label' => esc_html__( 'Show / Hide Scroll To Top','vw-travel' ),
      	'section' => 'vw_travel_footer'
    )));

    //Selective Refresh
	$wp_customize->selective_refresh->add_partial('vw_travel_scroll_to_top_icon', array( 
		'selector' => '.scrollup i', 
		'render_callback' => 'vw_travel_customize_partial_vw_travel_scroll_to_top_icon', 
	));

    $wp_customize->add_setting('vw_travel_scroll_to_top_icon',array(
		'default'	=> 'fas fa-angle-up',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control(new VW_Travel_Fontawesome_Icon_Chooser(
        $wp_customize,'vw_travel_scroll_to_top_icon',array(
		'label'	=> __('Add Scroll to Top Icon','vw-travel'),
		'transport' => 'refresh',
		'section'	=> 'vw_travel_footer',
		'setting'	=> 'vw_travel_scroll_to_top_icon',
		'type'		=> 'icon'
	)));

	$wp_customize->add_setting('vw_travel_scroll_to_top_font_size',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_scroll_to_top_font_size',array(
		'label'	=> __('Icon Font Size','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_scroll_to_top_padding',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_scroll_to_top_padding',array(
		'label'	=> __('Icon Top Bottom Padding','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_scroll_to_top_width',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_scroll_to_top_width',array(
		'label'	=> __('Icon Width','vw-travel'),
		'description'	=> __('Enter a value in pixels Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting('vw_travel_scroll_to_top_height',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('vw_travel_scroll_to_top_height',array(
		'label'	=> __('Icon Height','vw-travel'),
		'description'	=> __('Enter a value in pixels. Example:20px','vw-travel'),
		'input_attrs' => array(
            'placeholder' => __( '10px', 'vw-travel' ),
        ),
		'section'=> 'vw_travel_footer',
		'type'=> 'text'
	));

	$wp_customize->add_setting( 'vw_travel_scroll_to_top_border_radius', array(
		'default'              => '',
		'type'                 => 'theme_mod',
		'transport' 		   => 'refresh',
		'sanitize_callback'    => 'absint',
		'sanitize_js_callback' => 'absint',
	) );
	$wp_customize->add_control( 'vw_travel_scroll_to_top_border_radius', array(
		'label'       => esc_html__( 'Icon Border Radius','vw-travel' ),
		'section'     => 'vw_travel_footer',
		'type'        => 'range',
		'input_attrs' => array(
			'step'             => 1,
			'min'              => 1,
			'max'              => 50,
		),
	) );

	$wp_customize->add_setting('vw_travel_scroll_top_alignment',array(
        'default' => __('Right','vw-travel'),
        'sanitize_callback' => 'vw_travel_sanitize_choices'
	));
	$wp_customize->add_control(new VW_Travel_Image_Radio_Control($wp_customize, 'vw_travel_scroll_top_alignment', array(
        'type' => 'select',
        'label' => __('Scroll To Top','vw-travel'),
        'section' => 'vw_travel_footer',
        'settings' => 'vw_travel_scroll_top_alignment',
        'choices' => array(
            'Left' => get_template_directory_uri().'/assets/images/layout1.png',
            'Center' => get_template_directory_uri().'/assets/images/layout2.png',
            'Right' => get_template_directory_uri().'/assets/images/layout3.png'
    ))));

    // Has to be at the top
	$wp_customize->register_panel_type( 'VW_Travel_WP_Customize_Panel' );
	$wp_customize->register_section_type( 'VW_Travel_WP_Customize_Section' );

}

add_action( 'customize_register', 'vw_travel_customize_register' );

load_template( trailingslashit( get_template_directory() ) . '/inc/logo/logo-resizer.php' );

if ( class_exists( 'WP_Customize_Panel' ) ) {
  	class VW_Travel_WP_Customize_Panel extends WP_Customize_Panel {
	    public $panel;
	    public $type = 'vw_travel_panel';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;
	      return $array;
    	}
  	}
}

if ( class_exists( 'WP_Customize_Section' ) ) {
  	class VW_Travel_WP_Customize_Section extends WP_Customize_Section {
	    public $section;
	    public $type = 'vw_travel_section';
	    public function json() {

	      $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
	      $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
	      $array['content'] = $this->get_content();
	      $array['active'] = $this->active();
	      $array['instanceNumber'] = $this->instance_number;

	      if ( $this->panel ) {
	        $array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
	      } else {
	        $array['customizeAction'] = 'Customizing';
	      }
	      return $array;
    	}
  	}
}

// Enqueue our scripts and styles
function vw_travel_customize_controls_scripts() {
	wp_enqueue_script( 'customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.js' ), array(), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'vw_travel_customize_controls_scripts' );

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class VW_Travel_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	*/
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'VW_Travel_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(new VW_Travel_Customize_Section_Pro($manager,'example_1',	array(
			'priority'   => 1,
			'title'    => esc_html__( 'VW TRAVEL PRO', 'vw-travel' ),
			'pro_text' => esc_html__( 'UPGRADE PRO', 'vw-travel' ),
			'pro_url'  => esc_url('https://www.vwthemes.com/themes/wordpress-travel-theme/'),
		)));

		// Register sections.
		$manager->add_section(new VW_Travel_Customize_Section_Pro($manager,'example_2',array(
			'priority'   => 1,
			'title'    => esc_html__( 'DOCUMENATATION', 'vw-travel' ),
			'pro_text' => esc_html__( 'DOCS', 'vw-travel' ),
			'pro_url'  => admin_url('themes.php?page=vw_travel_guide'),
		)));
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'vw-travel-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'vw-travel-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
VW_Travel_Customize::get_instance();