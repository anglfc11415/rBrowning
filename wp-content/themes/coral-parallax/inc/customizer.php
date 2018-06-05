<?php
/**
 * coral-parallax Theme Customizer
 *
 * @package coral-parallax
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

 //--------- Sanitize
function coral_parallax_sanitize_yesno($setting){ if ( 0==$setting || 1==$setting ) return $setting; return 1;}
function coral_parallax_sanitize_voffset($setting){ if (is_numeric($setting) && $setting>=0) return $setting; return 25;}
function coral_parallax_sanitize_voffset2($setting){ if (is_numeric($setting)) return $setting; return 0;}
function coral_parallax_sanitize_size($setting){ if (is_numeric($setting) && $setting>=0) return $setting; return 0;}
function coral_parallax_sanitize_logoheight($setting){ if (is_numeric($setting) && $setting>=40 && $setting<=300) return $setting; return 65;}
function coral_parallax_sanitize_typography($setting){
    $valid = array(
							"Lato, sans-serif" => "Lato (google font)",
							"'Open Sans', sans-serif" => "Open Sans (google font)",
							"'Roboto Condensed', sans-serif" => "Roboto Condensed (google font)",
							"'Russo One', sans-serif" => "Russo One (google font)",
							"Arial, Helvetica, sans-serif" => "Arial, Helvetica, sans-serif",
							"'Arial Black', Gadget, sans-serif" => "'Arial Black', Gadget, sans-serif",
							"'Helvetica Neue', Helvetica, Arial, sans-serif" => "'Helvetica Neue', Helvetica, Arial, sans-serif",
							"'Comic Sans MS', cursive, sans-serif" => "'Comic Sans MS', cursive, sans-serif",
							"Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
							"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
							"Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
							"'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
							"Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif",
							"Georgia, serif" => "Georgia, serif",
							"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
							"'Times New Roman', Times, serif" => "'Times New Roman', Times, serif",
							"'Courier New', Courier, monospace" => "'Courier New', Courier, monospace",
							"'Lucida Console', Monaco, monospace" => "'Lucida Console', Monaco, monospace"
    );
 
    if ( array_key_exists( $setting, $valid ) ) {
        return $setting;
    } else {
        return '';
    }
}
function coral_parallax_sanitize_pausetime($setting){ if (is_numeric($setting) && $setting>=0) return $setting; return 5000;}
function coral_parallax_sanitize_animspeed($setting){ if (is_numeric($setting) && $setting>=0) return $setting; return 500;}
function coral_parallax_sanitize_checkbox( $input ) {
		if ( $input == '1' ) {
			return '1';
		} else {
			return '';
		}
}
function coral_parallax_sanitize_radio( $input ) {
    $valid = array(
        '1' => __( 'Yes', 'coral-parallax' ),
		'0' => __( 'No, I want to display my own images', 'coral-parallax' ),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
function coral_parallax_sanitize_color_radio( $input ) {
    $valid = array(
        '1' => __( 'Black', 'coral-parallax' ),
		'0' => __( 'White', 'coral-parallax' ),
    );
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
function coral_parallax_sanitize_content_radio( $input ) {
    $valid = array(
		'1' => __( 'Maximum two widgets side by side', 'coral-parallax' ),
		'0' => __( 'Content you set below', 'coral-parallax' ),
	);
 
    if ( array_key_exists( $input, $valid ) ) {
        return $input;
    } else {
        return '';
    }
}
//---------- Controls
if ( class_exists( 'WP_Customize_Control' ) ) {

    class Coral_Parallax_Text_Description_Control extends WP_Customize_Control {
        public $description;

	    public function render_content() {
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<p class="description more-top"><?php echo ( $this->description ); ?></p>
                <input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
            </label>
 			<?php
        }
    }
}
function coral_parallax_customize_controls_print_styles() {
// 	wp_enqueue_style( 'coral_parallax_customizer_css', get_template_directory_uri() . '/css/customizer.css' );
	?>
	<style type="text/css">
	.customize-control-header .current .container {height: auto !important;}
	</style>
	<?php
}
add_action( 'customize_controls_print_styles', 'coral_parallax_customize_controls_print_styles' );

function coral_parallax_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'coral_parallax_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'coral_parallax_customize_partial_blogdescription',
	) );

// Site title section panel ------------------------------------------------------
		$wp_customize->add_section( 'title_tagline', array(
			'title' => __( 'Logo, Site Title, Tagline, Icon', 'coral-parallax' ),
			'description' => __( 'You can have either an image logo, or site title and tagline', 'coral-parallax' ),
			'priority' => 20,
		) );
	
		$wp_customize->add_setting( 'coral_parallax_logoheight_setting' , array(
			'default'           => 65,
            'sanitize_callback' => 'absint',
			'transport'         => 'refresh',
		));
		$wp_customize->add_control( 'coral_parallax_logoheight_control', array(
			'label' 			=> __( 'Max. height of the logo in px', 'coral-parallax' ),
			'section' 			=> 'title_tagline',
			'settings' 			=> 'coral_parallax_logoheight_setting',
			'priority' 			=> 9,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 40,
				'max' => 300,
				'step' => 1,
			),
		) );	
		$wp_customize->add_setting( 'blogname', array(
			'default'    => get_option( 'blogname' ),
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'blogname', array(
			'label'      => __( 'Site Title', 'coral-parallax' ),
			'section'    => 'title_tagline',
			'priority' => 10,
		) );

		$wp_customize->add_setting( 'blogdescription', array(
			'default'    => get_option( 'blogdescription' ),
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'blogdescription', array(
			'label'      => __( 'Tagline', 'coral-parallax' ),
			'section'    => 'title_tagline',
			'priority' => 20,
		) );
	
		$wp_customize->add_setting( 'coral_parallax_titleoffset_setting' , array(
			'default'           => 15,
            'sanitize_callback' => 'coral_parallax_sanitize_voffset2',
			'transport'         => 'refresh',
		));
		$wp_customize->add_control( 'coral_parallax_titleoffset__control', array(
			'label' 			=> __( 'Vertical position (margin-top) of the site title in px', 'coral-parallax' ),
			'section' 			=> 'title_tagline',
			'settings' 			=> 'coral_parallax_titleoffset_setting',
			'priority' 			=> 58,
			'type' => 'number',
			'input_attrs' => array(
				'min' => -100,
				'max' => 100,
				'step' => 1,
			),
		) );	
		$wp_customize->add_setting( 'coral_parallax_taglineoffset_setting' , array(
			'default'           => 0,
            'sanitize_callback' => 'coral_parallax_sanitize_voffset2',
			'transport'         => 'refresh',
		));
		$wp_customize->add_control( 'coral_parallax_taglineoffset__control', array(
			'label' 			=> __( 'Vertical position (margin-top) of the tagline in px', 'coral-parallax' ),
			'section' 			=> 'title_tagline',
			'settings' 			=> 'coral_parallax_taglineoffset_setting',
			'priority' 			=> 59,
			'type' => 'number',
			'input_attrs' => array(
				'min' => -100,
				'max' => 100,
				'step' => 1,
			),
		) );	
// Header section panel ------------------------------------------------------
		$wp_customize->add_section( 'header_image', array(
			'title' => __( 'Header settings', 'coral-parallax' ),
			'priority' => 23,
			'description' => __( 'Here you can set, on which pages the full page header with your header background image will be displayed', 'coral-parallax' ),
		) );
		$wp_customize->add_setting( 'header_front_page_setting', array(
            'default'        	=> '1',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'header_front_page_control', array(
            'label'   			=> __( 'Display header on frontpage', 'coral-parallax' ),
            'section' 			=> 'header_image',
			'settings' 			=> 'header_front_page_setting',
            'type'    			=> 'checkbox',
            'priority' 			=> 3
        ) );
		$wp_customize->add_setting( 'header_posts_page_setting', array(
            'default'        	=> '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'header_posts_page_control', array(
            'label'   			=> __( 'Display header on blog page', 'coral-parallax'),
            'section' 			=> 'header_image',
			'settings' 			=> 'header_posts_page_setting',
            'type'    			=> 'checkbox',
            'priority' 			=> 4
        ) );
		$wp_customize->add_setting( 'header_allpages', array(
            'default'        	=> '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'header_allpages_control', array(
            'label'   			=> __( 'Always display the header', 'coral-parallax'),
            'section' 			=> 'header_image',
			'settings' 			=> 'header_allpages',
            'type'    			=> 'checkbox',
            'priority' 			=> 5
        ) );
		$wp_customize->add_setting( 'header_post_id_setting' , array(
			'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		));
		$wp_customize->add_control( new Coral_Parallax_Text_Description_Control( $wp_customize, 'header_post_id_control', array(
			'label' 			=> __( 'Comma separated IDs of posts/pages for which you need the header (e.g. 1, 23, 54).', 'coral-parallax' ),
			'section' 			=> 'header_image',
			'settings' 			=> 'header_post_id_setting',
			'priority' 			=> 6,
		) ) );	
		$wp_customize->add_setting( 'header_bg_scroll_setting', array(
            'default'        	=> '1',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'header_bg_scroll_control', array(
            'label'   			=> __( 'Scroll background with page', 'coral-parallax' ),
            'section' 			=> 'header_image',
			'settings' 			=> 'header_bg_scroll_setting',
            'type'    			=> 'checkbox',
            'priority' 			=> 16
        ) );
		$wp_customize->add_setting( 'header_content_setting', array(
            'default'        	=> '0',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_content_radio',
        ) );
        $wp_customize->add_control( 'header_content_control', array(
            'label'   			=> __( 'Content of the fullpage header:', 'coral-parallax' ),
            'section' 			=> 'header_image',
			'settings' 			=> 'header_content_setting',
            'type'    			=> 'radio',
            'priority' 			=> 17,
			'choices' 			=> array(
									'1' => __( 'Maximum two widget areas side by side', 'coral-parallax' ),
									'0' => __( 'Content you set below', 'coral-parallax' ),
									),
        ) );
		$wp_customize->add_setting( 'coral_parallax_header_title' , array(
			'default'           => get_option( 'blogname' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		));
		$wp_customize->add_control( new Coral_Parallax_Text_Description_Control( $wp_customize, 'header_title_control', array(
			'label' 			=> __( 'Header title', 'coral-parallax' ),
			'section' 			=> 'header_image',
			'settings' 			=> 'coral_parallax_header_title',
			'priority' 			=> 18,
		) ) );	
		$wp_customize->add_setting( 'coral_parallax_header_text' , array(
			'default'           => get_option( 'blogdescription' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		));
		$wp_customize->add_control( new Coral_Parallax_Text_Description_Control( $wp_customize, 'coral_parallax_header_text_control', array(
			'label' 			=> __( 'Header text', 'coral-parallax' ),
			'section' 			=> 'header_image',
			'settings' 			=> 'coral_parallax_header_text',
			'priority' 			=> 19,
		) ) );	
		$wp_customize->add_setting( 'button_text' , array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		));
		$wp_customize->add_control( new Coral_Parallax_Text_Description_Control( $wp_customize, 'button_text_control', array(
			'label' 			=> __( 'Button text', 'coral-parallax' ),
			'section' 			=> 'header_image',
			'settings' 			=> 'button_text',
			'priority' 			=> 20,
		) ) );			
		$wp_customize->add_setting( 'header_button_link' , array(
			'default'           => '#',
			'transport'         => 'refresh',
			'sanitize_callback' => 'esc_url_raw',
		));
		$wp_customize->add_control( new Coral_Parallax_Text_Description_Control( $wp_customize, 'header_button_link_control', array(
			'label' 			=> __( 'Header button link (start with http://)', 'coral-parallax' ),
			'section' 			=> 'header_image',
			'settings' 			=> 'header_button_link',
			'priority' 			=> 21,
		) ) );	
		$wp_customize->add_setting( 'header_color_setting', array(
            'default'        	=> '0',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_color_radio',
        ) );
        $wp_customize->add_control( 'header_color_control', array(
            'label'   			=> __( 'Color sheme on the full page header', 'coral-parallax' ),
            'section' 			=> 'header_image',
			'settings' 			=> 'header_color_setting',
            'type'    			=> 'radio',
            'priority' 			=> 25,
			'choices' 			=> array(
									'1' => __( 'Black', 'coral-parallax' ),
									'0' => __( 'White', 'coral-parallax' ),
									),
        ) );
// Upper widgets section panel ------------------------------------------------------
		$wp_customize->add_section( 'coral_parallax_upperwidgets_section', array(
			'title' => __( 'Upper widgets', 'coral-parallax' ),
			'priority' => 25,
			'description' => __( 'Here you can set, on which pages the upper widgets will be displayed, and their background', 'coral-parallax' ),
		) );
		$wp_customize->add_setting( 'upperwidgets_front_page_setting', array(
            'default'        	=> '1',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'upperwidgets_front_page_control', array(
            'label'   			=> __( 'Display upper widgets on frontpage', 'coral-parallax' ),
            'section' 			=> 'coral_parallax_upperwidgets_section',
			'settings' 			=> 'upperwidgets_front_page_setting',
            'type'    			=> 'checkbox',
            'priority' 			=> 3
        ) );
		$wp_customize->add_setting( 'upperwidgets_posts_page_setting', array(
            'default'        	=> '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'upperwidgets_posts_page_control', array(
            'label'   			=> __( 'Display upper widgets on blog page', 'coral-parallax'),
            'section' 			=> 'coral_parallax_upperwidgets_section',
			'settings' 			=> 'upperwidgets_posts_page_setting',
            'type'    			=> 'checkbox',
            'priority' 			=> 4
        ) );
		$wp_customize->add_setting( 'upperwidgets_allpages', array(
            'default'        	=> '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'upperwidgets_allpages_control', array(
            'label'   			=> __( 'Always display the upper widgets', 'coral-parallax'),
            'section' 			=> 'coral_parallax_upperwidgets_section',
			'settings' 			=> 'upperwidgets_allpages',
            'type'    			=> 'checkbox',
            'priority' 			=> 5
        ) );
		$wp_customize->add_setting( 'upperwidgets_post_id_setting' , array(
			'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		));
		$wp_customize->add_control( new Coral_Parallax_Text_Description_Control( $wp_customize, 'upperwidgets_post_id_control', array(
			'label' 			=> __( 'Display the upper widgets on these pages/posts:', 'coral-parallax' ),
			'description' 		=> __( 'Comma separated IDs of posts/pages, e.g. 1, 23, 54', 'coral-parallax' ),
			'section' 			=> 'coral_parallax_upperwidgets_section',
			'settings' 			=> 'upperwidgets_post_id_setting',
			'priority' 			=> 6,
		) ) );	
		$wp_customize->add_setting( 'upperwidgets_exclude_post_id_setting' , array(
			'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		));
		$wp_customize->add_control( new Coral_Parallax_Text_Description_Control( $wp_customize, 'upperwidgets_exclude_post_id_control', array(
			'label' 			=> __( 'Do NOT display the upper widgets on these pages/posts:', 'coral-parallax' ),
			'description' 		=> __( 'Comma separated IDs of posts/pages, e.g. 1, 23, 54', 'coral-parallax' ),
			'section' 			=> 'coral_parallax_upperwidgets_section',
			'settings' 			=> 'upperwidgets_exclude_post_id_setting',
			'priority' 			=> 7,
		) ) );	
		
		$wp_customize->add_setting( 'upperwidgets_background_image_setting', array(
			'transport'         => 'refresh',
			'capability' 		=> 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'upperwidgets_background_image_control', array(
			'label'        		=> __( 'Background image', 'coral-parallax' ),
			'section' 			=> 'coral_parallax_upperwidgets_section',
			'settings' 			=> 'upperwidgets_background_image_setting',
			'priority' 			=> 8,
		) ) );
		
		$wp_customize->add_setting( 'upperwidgets_bg_scroll_setting', array(
            'default'        	=> '1',
			'transport'         => 'refresh',
			'sanitize_callback' => 'coral_parallax_sanitize_checkbox',
        ) );
        $wp_customize->add_control( 'upperwidgets_bg_scroll_control', array(
            'label'   			=> __( 'Scroll background with page', 'coral-parallax' ),
            'section' 			=> 'coral_parallax_upperwidgets_section',
			'settings' 			=> 'upperwidgets_bg_scroll_setting',
            'type'    			=> 'checkbox',
            'priority' 			=> 9,
        ) );
		
		$wp_customize->add_setting( 'upperwidget_background_color_setting', array(
			'default'        => '161616',
			'capability' => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'upperwidget_background_color_control', array(
			'label'   => __( 'Background Color', 'coral-parallax' ),
			'section' => 'coral_parallax_upperwidgets_section',
			'settings' => 'upperwidget_background_color_setting',
			'priority' => 10,
		) ) );

		$wp_customize->add_setting( 'upperwidgets_text_color_setting', array(
			'default'        => 'bcbcbc',
			'capability' => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'upperwidgets_text_color_control', array(
			'label'   => __( 'Text color', 'coral-parallax' ),
			'section' => 'coral_parallax_upperwidgets_section',
			'settings' => 'upperwidgets_text_color_setting',
			'priority' => 11,
		) ) );
		$wp_customize->add_setting( 'upperwidgets_link_color_setting', array(
			'default'        => 'f29b37',
			'capability' => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'upperwidgets_link_color_control', array(
			'label'   => __( 'Link color', 'coral-parallax' ),
			'section' => 'coral_parallax_upperwidgets_section',
			'settings' => 'upperwidgets_link_color_setting',
			'priority' => 12,
		) ) );
		$wp_customize->add_setting( 'upperwidgets_heading_color_setting', array(
			'default'        => 'ffffff',
			'capability' => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'upperwidgets_heading_color_control', array(
			'label'   => __( 'Heading color', 'coral-parallax' ),
			'section' => 'coral_parallax_upperwidgets_section',
			'settings' => 'upperwidgets_heading_color_setting',
			'priority' => 13,
		) ) );
// Layout section panel ------------------------------------------------------
		$wp_customize->add_section( 'coral_parallax_layout_section', array(
			'title' => __( 'Layout', 'coral-parallax' ),
			'priority' => 27,
			'description' => __( 'The default layout is a two-column layout with left sidebar. For your pages you can also set a full width layout in the page editor by choosing the Full width page template', 'coral-parallax' ),
		) );
		$choices =  array(
			'10' => '10%',
			'15' => '15%',
			'20' => '20%',
			'25' => '25%',
			'30' => '30%',
			'33' => '33%',
			'35' => '35%',
			'40' => '40%',
			'45' => '45%',
			'50' => '50%',
			'55' => '55%',
			'60' => '60%',
			'65' => '65%',
			'66' => '66%',
			'70' => '70%',
			'75' => '75%',
			'80' => '80%',
		);

		$wp_customize->add_setting( 'coral_parallax_sidebarwidth_setting', array(
			'default' => '30',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'coral_parallax_sidebarwidth_control', array(
			'label' => __( 'Sidebar width:', 'coral-parallax' ),
			'section' => 'coral_parallax_layout_section',
			'settings' => 'coral_parallax_sidebarwidth_setting',
			'priority' => 46,
			'type' => 'select',
			'choices' => $choices,
		) );		

// Typography
		$typoarr = array( 	"Lato, sans-serif" => "Lato (google font)",
							"'Open Sans', sans-serif" => "Open Sans (google font)",
							"'Roboto Condensed', sans-serif" => "Roboto Condensed (google font)",
							"'Russo One', sans-serif" => "Russo One (google font)",
							"Arial, Helvetica, sans-serif" => "Arial, Helvetica, sans-serif",
							"'Arial Black', Gadget, sans-serif" => "'Arial Black', Gadget, sans-serif",
							"'Helvetica Neue', Helvetica, Arial, sans-serif" => "'Helvetica Neue', Helvetica, Arial, sans-serif",
							"'Comic Sans MS', cursive, sans-serif" => "'Comic Sans MS', cursive, sans-serif",
							"Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
							"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
							"Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
							"'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
							"Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif",
							"Georgia, serif" => "Georgia, serif",
							"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
							"'Times New Roman', Times, serif" => "'Times New Roman', Times, serif",
							"'Courier New', Courier, monospace" => "'Courier New', Courier, monospace",
							"'Lucida Console', Monaco, monospace" => "'Lucida Console', Monaco, monospace"
		);
		$wp_customize->add_section( 'coral_parallax_typography_section', array(
			'title' 			=> __( 'Typography', 'coral-parallax' ),
			'priority'			=> 32,
			'description' => __( 'Here you can set up the typography with basic web safe or 3 google fonts', 'coral-parallax' ),
		) );
		$wp_customize->add_setting( 'title_font_setting', array(
			'default'        => "'Open Sans', sans-serif",
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'coral_parallax_sanitize_typography',
		) );
		$wp_customize->add_control( 'title_font_control', array(
			'label'   			=> __('Site title font','coral-parallax'),
			'section' 			=> 'coral_parallax_typography_section',
			'settings' 			=> 'title_font_setting',
			'type'    			=> 'select',
			'priority'        	=> 5,
			'choices'    		=> $typoarr,
		) );

		$wp_customize->add_setting( 'coral_parallax_titlesize_setting', array(
			'default' => '20',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'coral_parallax_titlesize_control', array(
			'label' => __( 'Site title fontsize in px:', 'coral-parallax' ),
			'section' => 'coral_parallax_typography_section',
			'settings' => 'coral_parallax_titlesize_setting',
			'priority' => 10,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 8,
				'max' => 100,
				'step' => 1,
			),
		) );	
	
		$wp_customize->add_setting( 'tagline_font_setting', array(
			'default'        => "'Open Sans', sans-serif",
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'coral_parallax_sanitize_typography',
		) );
		$wp_customize->add_control( 'tagline_font_control', array(
			'label'   			=> __('Tagline font','coral-parallax'),
			'section' 			=> 'coral_parallax_typography_section',
			'settings' 			=> 'tagline_font_setting',
			'type'    			=> 'select',
			'priority'        	=> 15,
			'choices'    		=> $typoarr,
		) );
		$wp_customize->add_setting( 'coral_parallax_taglinesize_setting', array(
			'default' => '15',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'coral_parallax_taglinesize_control', array(
			'label' => __( 'Tagline fontsize in px:', 'coral-parallax' ),
			'section' => 'coral_parallax_typography_section',
			'settings' => 'coral_parallax_taglinesize_setting',
			'priority' => 20,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 8,
				'max' => 100,
				'step' => 1,
			),
		) );
		$wp_customize->add_setting( 'body_font_setting', array(
			'default'        => "'Open Sans', sans-serif",
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'coral_parallax_sanitize_typography',
		) );
		$wp_customize->add_control( 'body_font_control', array(
			'label'   			=> __('Body font','coral-parallax'),
			'section' 			=> 'coral_parallax_typography_section',
			'settings' 			=> 'body_font_setting',
			'type'    			=> 'select',
			'priority'        	=> 25,
			'choices'    		=> $typoarr,
		) );

		$wp_customize->add_setting( 'body_fontsize_setting', array(
			'default' => '15',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'body_fontsize_control', array(
			'label' => __( 'Body fontsize in px:', 'coral-parallax' ),
			'section' => 'coral_parallax_typography_section',
			'settings' => 'body_fontsize_setting',
			'priority' => 30,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 8,
				'max' => 30,
				'step' => 1,
			),
		) );
		$wp_customize->add_setting( 'heading_font_setting', array(
			'default'        => "'Open Sans', sans-serif",
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'coral_parallax_sanitize_typography',
		) );
		$wp_customize->add_control( 'heading_font_control', array(
			'label'   			=> __('Heading font','coral-parallax'),
			'description' => __( 'The h1, h2, ... sizes are calculated from the body font size', 'coral-parallax' ),
			'section' 			=> 'coral_parallax_typography_section',
			'settings' 			=> 'heading_font_setting',
			'type'    			=> 'select',
			'priority'        	=> 35,
			'choices'    		=> $typoarr,
		) );
		$wp_customize->add_setting( 'header_title_font_setting', array(
			'default'        => "Lato, sans-serif",
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'coral_parallax_sanitize_typography',
		) );
		$wp_customize->add_control( 'header_title_font_control', array(
			'label'   			=> __('Header title font','coral-parallax'),
			'description' 		=> __( 'Header title for the full page header.', 'coral-parallax' ),
			'section' 			=> 'coral_parallax_typography_section',
			'settings' 			=> 'header_title_font_setting',
			'type'    			=> 'select',
			'priority'        	=> 40,
			'choices'    		=> $typoarr,
		) );
		$wp_customize->add_setting( 'coral_parallax_header_title_size_setting', array(
			'default' => '50',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'coral_parallax_header_title_size_control', array(
			'label' => __( 'Header title fontsize in px:', 'coral-parallax' ),
			'section' => 'coral_parallax_typography_section',
			'settings' => 'coral_parallax_header_title_size_setting',
			'priority' => 41,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 8,
				'max' => 100,
				'step' => 1,
			),
		) );

		$wp_customize->add_setting( 'coral_parallax_header_title_letterspacing_setting', array(
			'default' => '4',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'coral_parallax_header_title_letterspacing_control', array(
			'label' => __( 'Header title letter spacing in px:', 'coral-parallax' ),
			'section' => 'coral_parallax_typography_section',
			'settings' => 'coral_parallax_header_title_letterspacing_setting',
			'priority' => 42,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 0,
				'max' => 30,
				'step' => 1,
			),
		) );
		$wp_customize->add_setting( 'header_text_font_setting', array(
			'default'        => "Lato, sans-serif",
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'coral_parallax_sanitize_typography',
		) );
		$wp_customize->add_control( 'header_text_font_control', array(
			'label'   			=> __('Header text font','coral-parallax'),
			'description' 		=> __( 'Header text for the full page header.', 'coral-parallax' ),
			'section' 			=> 'coral_parallax_typography_section',
			'settings' 			=> 'header_text_font_setting',
			'type'    			=> 'select',
			'priority'        	=> 45,
			'choices'    		=> $typoarr,
		) );
		$wp_customize->add_setting( 'coral_parallax_header_text_size_setting', array(
			'default' => '20',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'coral_parallax_header_text_size_control', array(
			'label' => __( 'Header text fontsize in px:', 'coral-parallax' ),
			'section' => 'coral_parallax_typography_section',
			'settings' => 'coral_parallax_header_text_size_setting',
			'priority' => 46,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 8,
				'max' => 100,
				'step' => 1,
			),
		) );
		$wp_customize->add_setting( 'coral_parallax_header_text_letterspacing_setting', array(
			'default' => '8',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( 'coral_parallax_header_text_letterspacing_control', array(
			'label' => __( 'Header text letter spacing in px:', 'coral-parallax' ),
			'section' => 'coral_parallax_typography_section',
			'settings' => 'coral_parallax_header_text_letterspacing_setting',
			'priority' => 47,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 0,
				'max' => 30,
				'step' => 1,
			),
		) );
		$wp_customize->add_setting( 'menu_font_setting', array(
			'default'        => "'Open Sans', sans-serif",
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'coral_parallax_sanitize_typography',
		) );
		$wp_customize->add_control( 'menu_font_control', array(
			'label'   			=> __('Top menu font','coral-parallax'),
			'section' 			=> 'coral_parallax_typography_section',
			'settings' 			=> 'menu_font_setting',
			'type'    			=> 'select',
			'priority'        	=> 50,
			'choices'    		=> $typoarr,
		) );

// Color section panel
		$wp_customize->add_section( 'colors', array(
			'title'          => __( 'Colors', 'coral-parallax' ),
			'priority'       => 40,
		) );		
		$wp_customize->add_setting( 'background_color', array(
			'default'        => 'ffffff',
			'capability' => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
			'label'   => __( 'Background Color', 'coral-parallax' ),
			'section' => 'colors',
			'settings' => 'background_color',
			'priority' => 8,
		) ) );
		$wp_customize->add_setting( 'title_color_setting', array(
			'default'        => '000000',
			'capability' => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'title_color_control', array(
			'label'   => __( 'Site title color', 'coral-parallax' ),
			'section' => 'colors',
			'settings' => 'title_color_setting',
			'priority' => 54,
		) ) );
		$wp_customize->add_setting( 'tagline_color_setting', array(
			'default'        => '000000',
			'capability' => 'edit_theme_options',
			'sanitize_callback'    => 'sanitize_hex_color_no_hash',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'tagline_color_control', array(
			'label'   => __( 'Tagline Color', 'coral-parallax' ),
			'section' => 'colors',
			'settings' => 'tagline_color_setting',
			'priority' => 56,
		) ) );
		$wp_customize->add_setting( 'coral_parallax_keep_color_setting', array(
			'default' => '0',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'coral_parallax_sanitize_yesno',
		) );

		$wp_customize->add_control( 'coral_parallax_keep_color_control', array(
			'label' => __( 'Keep these site title and tagline colors on the full page header?', 'coral-parallax' ),
			'section' => 'colors',
			'settings' => 'coral_parallax_keep_color_setting',
			'priority' => 58,
			'type' => 'select',
			'choices' => array(
				'1' => __( 'Yes', 'coral-parallax' ),
				'0' => __( 'No', 'coral-parallax' ),
			),
		) );
//  Parallax		
		$wp_customize->add_section( 'coral_parallax_parallax_section', array(
			'title' 			=> __( 'Parallax setting', 'coral-parallax' ),
			'priority'			=> 42,
			'description' => __( 'If you need a scroll effect on an element, add the scrollflow css class and at least one of the following CSS classes to the desired object: -slide-top, -slide-left, -slide-right, -slide-bottom, -pop, -opacity. For background images there are options in other sections of the customizer to scroll or not scroll with the page', 'coral-parallax' ),
		) );

		$wp_customize->add_setting( 'coral_parallax_duration_setting', array(
			'default' => '500',
			'capability' => 'edit_theme_options',
            'sanitize_callback' => 'absint',
		) );

		$wp_customize->add_control( 'coral_parallax_duration_control', array(
			'label' => __( 'Easing duration on scroll in ms:', 'coral-parallax' ),
			'section' => 'coral_parallax_parallax_section',
			'settings' => 'coral_parallax_duration_setting',
			'priority' => 10,
			'type' => 'number',
			'input_attrs' => array(
				'min' => 50,
				'max' => 1000,
				'step' => 50,
			),
		) );
}
add_action( 'customize_register', 'coral_parallax_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function coral_parallax_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function coral_parallax_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function coral_parallax_customize_preview_js() {
	wp_enqueue_script( 'coral_parallax_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'coral_parallax_customize_preview_js' );
