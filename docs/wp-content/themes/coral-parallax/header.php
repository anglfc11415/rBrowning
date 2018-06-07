<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package coral-parallax
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'coral-parallax' ); ?></a>

<?php 	
	$htitle = get_theme_mod( 'coral_parallax_header_title', get_option( 'blogname' ) );
	$htext = get_theme_mod( 'coral_parallax_header_text', get_option( 'blogdescription' ) );
	$hbuttontext = get_theme_mod( 'button_text', '' );
	$hbuttonlink = get_theme_mod( 'header_button_link', '#' );
	$widget = get_theme_mod( 'header_content_setting', '0' );	
	$header_front_page = get_theme_mod('header_front_page_setting','1');
	$header_allpages = get_theme_mod('header_allpages','');
	$header_posts_page = get_theme_mod('header_posts_page_setting','');
	$header_ids = get_theme_mod('header_post_id_setting','-999999');
	$header_arrids = explode(',', $header_ids);
	foreach($header_arrids as $key => $val) {
		$header_arrids[$key] = intval($val);
	}	
	if (("1" == $header_front_page && is_front_page()) || ("1" == $header_posts_page && is_home()) || "1" == $header_allpages || is_single($header_arrids) || is_page($header_arrids)) {
		$isheader = 1;
	} else {
		$isheader = 0;
	}	
?>	

<?php if ( 1 == $isheader ) : ?>
  <div id="headerwrap">
<?php else : ?>  
  <div id="navwrap">
<?php endif; ?>
	<div id="navcontainer" class="grid-container">
		<nav id="site-navigation" class="main-navigation grid-parent egrid grid-100 tablet-grid-100 mobile-grid-100" role="navigation">
		<div class="site-branding egrid <?php coral_parallax_logo_class(); ?>">
			<?php if (get_theme_mod('custom_logo')) : ?>
				<?php coral_parallax_the_custom_logo(); ?>
			<?php else: ?>
				<?php if (is_front_page()) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span><?php bloginfo( 'name' ); ?></span></a></h1>
					<h2 class="site-description"><span><?php bloginfo( 'description' ); ?></span></h2> 			
				<?php else: ?>
					<h3 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><span><?php bloginfo( 'name' ); ?></span></a></h3>
					<h4 class="site-description"><span><?php bloginfo( 'description' ); ?></span></h4>
				<?php endif; ?>	
			<?php endif; ?>	
		</div><!-- .site-branding -->
			<div id="button-container" class="<?php coral_parallax_menu_button_class(); ?>">
				<a id="menu-button" class="fa fa-bars alignright collapsed" href="#sidr"></a>
			</div>
			<?php 
			$navclass = 'egrid' . coral_parallax_nav_class();
			if (!is_rtl()) {
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array( 'theme_location' => 'primary', 'container_id' => 'sidr' , 'container_class' => $navclass , 'menu_id' => 'main-menu', 'menu_class' => 'sm sm-clean collapsed' ) );
				} else {
					wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb'  => 'coral_parallax_wp_page_menu_mine', 'menu_class' => $navclass ) ); 
				}
			} else {
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu( array( 'theme_location' => 'primary', 'container_id' => 'sidr' , 'container_class' => $navclass , 'menu_id' => 'main-menu', 'menu_class' => 'sm sm-rtl sm-clean collapsed' ) );
				} else {
					wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb'  => 'coral_parallax_wp_page_menu_mine', 'menu_class' => $navclass ) );
				}	
			}
			?>
			
		</nav><!-- #site-navigation -->
	</div><!-- #navcontainer -->

<?php if ( 1 == $isheader ) : ?>  	
	<header id="masthead" class="site-header" role="banner">
		<?php if ( '1' != $widget ) : ?>
			<h2 class="fullpageheader"><?php echo esc_html($htitle); ?></h2>
			<h3 class="fullpageheader"><?php echo esc_html($htext); ?></h3>
			<?php if ( $hbuttontext ) : ?>
				<a href="<?php echo esc_url($hbuttonlink); ?>" class="button fullpageheader"><?php echo esc_html($hbuttontext); ?></a>
			<?php endif; ?>
		<?php else : ?>
			<?php if ( is_active_sidebar( 'header-1' ) ) : ?>
				<div class="<?php coral_parallax_header_widget_class(); ?>" id="header-widget-1">
					<?php dynamic_sidebar( 'header-1' ); ?>
				</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'header-2' ) ) : ?>
				<div class="<?php coral_parallax_header_widget_class(); ?>" id="header-widget-2">
					<?php dynamic_sidebar( 'header-2' ); ?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	</header><!-- #masthead -->
<?php endif; ?>
  </div><!-- #headerwrap or #navwrap -->
  <div id="navsep">
  </div>
  <div id="upperwrap">
	<div id="upper" class="grid-container">
	<?php if ( is_active_sidebar( 'upper-1' ) || is_active_sidebar( 'upper-2' ) || is_active_sidebar( 'upper-3' ) || is_active_sidebar( 'upper-4' ) ) : ?>	

		<div id="upper-widgets" class="grid-parent grid-100 tablet-grid-100 mobile-grid-100">
			<?php if ( is_active_sidebar( 'upper-1' ) ) : ?>
			<div class="<?php coral_parallax_upper_widget_class(); ?>" id="upper-widget-1">
				<?php dynamic_sidebar( 'upper-1' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'upper-2' ) ) : ?>
			<div class="<?php coral_parallax_upper_widget_class(); ?>" id="upper-widget-2">
				<?php dynamic_sidebar( 'upper-2' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'upper-3' ) ) : ?>
			<div class="<?php coral_parallax_upper_widget_class(); ?>" id="upper-widget-3">
				<?php dynamic_sidebar( 'upper-3' ); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'upper-4' ) ) : ?>
			<div class="<?php coral_parallax_upper_widget_class(); ?>" id="upper-widget-4">
				<?php dynamic_sidebar( 'upper-4' ); ?>
			</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	</div><!-- #upper -->
  </div><!-- #upperwrap -->
  
  <div id="contentwrap">	
	<div id="content" class="site-content grid-container">
<!-- breadcrumbs from Yoast or NavXT plugins -->
		<?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
		<div class="breadcrumbs grid-100 tablet-grid-100 mobile-grid-100">
			<?php yoast_breadcrumb(); ?>
		</div>
		<?php elseif (function_exists('bcn_display')) : ?>
		<div class="breadcrumbs grid-100 tablet-grid-100 mobile-grid-100" xmlns:v="http://rdf.data-vocabulary.org/#">
			<?php bcn_display(); ?>
		</div>
		<?php endif; ?>
