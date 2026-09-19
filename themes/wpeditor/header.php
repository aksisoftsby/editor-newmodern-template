<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if (!defined('ABSPATH')) {
	exit;
}

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'wpberita'); ?></a>
	<div id="topnavwrap" class="gmr-topnavwrap clearfix">
		<?php
		$mod   = get_theme_mod('gmr_notif_marquee', 'recentpost');
		$notif = get_theme_mod('gmr_textnotif');

		# if ('disable' !== $mod) {
		if (false) {
			echo '<div class="gmr-topnotification">';
			echo '<div class="container">';
			echo '<div class="list-flex">';
			echo '<div class="row-flex">';
			$textmarquee = get_theme_mod('gmr_textmarquee');
			echo '<div class="text-marquee">';
			if ($textmarquee) :
				/* sanitize html output */
				echo esc_html($textmarquee);
			else :
				echo esc_html__('Breaking News', 'wpberita');
			endif;
			echo '</div>';
			echo '</div>';

			echo '<div class="row-flex wrap-marquee">';
			echo '<div class="marquee">';
			if ('recentpost' === $mod) {
				do_action('wpberita_recentpost_marquee');
			} else {
				if (isset($notif) && !empty($notif)) {
					echo do_shortcode($notif);
				}
			}
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
			echo '</div>';
		}
		?>

		<div class="container">
			<div class="list-flex">
				<div class="row-flex gmr-navleft">
					<?php
					if (!wpberita_is_amp()) {
						echo '<a id="gmr-responsive-menu" title="' . esc_html__('Menus', 'wpberita') . '" href="#menus" rel="nofollow"><div class="ktz-i-wrap"><span class="ktz-i"></span><span class="ktz-i"></span><span class="ktz-i"></span></div></a>';
					} else {
						echo '<amp-state id="navMenuExpanded">';
						echo '<script type="application/json">false</script>';
						echo '</amp-state>';
						echo '<button id="gmr-responsive-menu" class="menu-toggle" on="tap:AMP.setState( { navMenuExpanded: ! navMenuExpanded } )" [class]="\'menu-toggle\' + ( navMenuExpanded ? \' toggled-on\' : \'\' )" aria-expanded="false" [aria-expanded]="navMenuExpanded ? \'true\' : \'false\'"><div class="ktz-i-wrap"><span class="ktz-i"></span><span class="ktz-i"></span><span class="ktz-i"></span></div></button>';
					}
					echo '<div class="gmr-logo-mobile">';
					if (function_exists('the_custom_logo') && has_custom_logo()) {
						$custom_logo_id = get_theme_mod('custom_logo');
						$logo           = wp_get_attachment_image_src($custom_logo_id, 'full');
						$desc           = get_bloginfo('name', 'display');
						echo '<a class="custom-logo-link" href="' . esc_url(get_home_url()) . '" title="' . esc_html($desc) . '" rel="home">';
						echo '<img class="custom-logo" src="' . esc_url($logo[0]) . '" width="' . (int) $logo[1] . '" height="' . (int) $logo[2] . '" alt="' . esc_html($desc) . '" loading="lazy" />';
						echo '</a>';
					} else {
					?>
						<div class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" rel="home"><?php bloginfo('name'); ?></a></div>
						<?php
						$wpberita_description = get_bloginfo('description', 'display');
						if ($wpberita_description || is_customize_preview()) :
						?>
							<span class="site-description screen-reader-text"><?php echo esc_html($wpberita_description); ?></span>
						<?php endif; ?>
					<?php
					}
					echo '</div>';
					if (has_nav_menu('menu-6')) {
						$m = wp_nav_menu(
							array(
								'echo' => false,
								'theme_location' => 'menu-6',
								'fallback_cb'    => false,
								'container'      => '',
								'menu_id'        => 'mobile-menu',
								'depth'          => 0,
								'link_before'    => '<span itemprop="name">',
								'link_after'     => '</span>',
								'link_class' => 'topnav-button second-topnav-btn nomobile heading-text'
							)
						);
						echo
						str_replace('<a href', '<a class="topnav-button second-topnav-btn nomobile heading-text" href', strip_tags(preg_replace(array(
							'#^<ul[^>]*>#',
							'#</ul>$#'
						), '', $m), '<a>'));
					}
					/*
					// Option remove search button.
					$f_text = get_theme_mod('gmr_first_topnavbtn_text');
					$f_url  = get_theme_mod('gmr_first_topnavbtn_url');
					$s_text = get_theme_mod('gmr_second_topnavbtn_text');
					$s_url  = get_theme_mod('gmr_second_topnavbtn_url');
					if ($f_text && $f_url) :
						echo '<a href="' . esc_url($f_url) . '" class="topnav-button second-topnav-btn nomobile heading-text" title="' . esc_html($f_text) . '">' . esc_html($f_text) . '</a>';
					endif;
					if ($s_text && $s_url) :
						echo '<a href="' . esc_url($s_url) . '" class="topnav-button nomobile heading-text" title="' . esc_html($s_text) . '">' . esc_html($s_text) . '</a>';
					endif;
					*/
					?>


				</div>

				<div class="row-flex gmr-navright">
					<?php
					// Option remove search button.
					$setting    = 'gmr_active-searchbutton';
					$mod_search = get_theme_mod($setting, customizer_library_get_default($setting));
					if (0 === $mod_search) :
					?>

						<div class="gmr-table-search">
							<form method="get" class="gmr-searchform searchform" action="<?php echo esc_url(home_url('/')); ?>">
								<input type="text" name="s" id="s" placeholder="<?php echo esc_attr__('Search', 'wpberita'); ?>" />
								<input type="hidden" name="post_type" value="post" />
                                                                    <!-- Cloudflare Turnstile -->
								<div class="cf-turnstile" data-sitekey="0x4AAAAAABA03gExyIJSTk8n"></div>
								<button type="submit" class="gmr-search-submit gmr-search-icon">
									<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
										<path fill="currentColor" d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396l1.414-1.414l-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8s3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6s-6-2.691-6-6s2.691-6 6-6z" />
										<path fill="currentColor" d="M11.412 8.586c.379.38.588.882.588 1.414h2a3.977 3.977 0 0 0-1.174-2.828c-1.514-1.512-4.139-1.512-5.652 0l1.412 1.416c.76-.758 2.07-.756 2.826-.002z" />
									</svg>
								</button>
							</form>
<!-- Tambahkan script Cloudflare -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

						</div>
					<?php
					endif;
					do_action('wpberita_topnav_icon');
					?>
				</div>
			</div>
		</div>
		<?php
		if (wp_is_mobile()) {
			if (has_nav_menu('menu-4')) {
				echo '<div class="gmr-mobilemenuwrap">';
				echo '<div class="container">';
				echo '<div class="gmr-mobilemenu clearfix">';
				wp_nav_menu(
					array(
						'theme_location' => 'menu-4',
						'fallback_cb'    => false,
						'container'      => 'ul',
						'menu_id'        => 'mobile-menu',
						'depth'          => 1,
						'link_before'    => '<span itemprop="name">',
						'link_after'     => '</span>',
					)
				);
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
		}
		?>
	</div>

	<div id="page" class="site">
		<div class="row-container-blb">

			<?php do_action('wpberita_floating_banner_left'); ?>
			<?php do_action('wpberita_floating_banner_right'); ?>
			<?php if (!wpberita_is_amp()) { ?>
				<header id="masthead" class="site-header">
					<?php do_action('wpberita_topbanner_verytop'); ?>
					<div class="container">
						<div class="site-branding">
							<?php
							echo '<div class="gmr-logo">';
							echo '<div class="gmr-logo-wrap">';
							if (function_exists('the_custom_logo') && has_custom_logo()) {
								$custom_logo_id = get_theme_mod('custom_logo');
								$logo           = wp_get_attachment_image_src($custom_logo_id, 'full');
								$desc           = get_bloginfo('name', 'display');
								echo '<a class="custom-logo-link logolink" href="' . esc_url(get_home_url()) . '" title="' . esc_html($desc) . '" rel="home">';
								echo '<img class="custom-logo" src="' . esc_url($logo[0]) . '" width="' . (int) $logo[1] . '" height="' . (int) $logo[2] . '" alt="' . esc_html($desc) . '" loading="lazy" />';
								echo '</a>';
							} else {
							?>
								<div class="site-title logolink"><a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" rel="home"><?php bloginfo('name'); ?></a></div>
								<?php
								$wpberita_description = get_bloginfo('description', 'display');
								if ($wpberita_description || is_customize_preview()) :
								?>
									<span class="site-description screen-reader-text"><?php echo esc_html($wpberita_description); ?></span>
								<?php endif; ?>
							<?php
							}
							echo '<div class="close-topnavmenu-wrap"><a id="close-topnavmenu-button" rel="nofollow" href="#"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path fill="currentColor" d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z"/></svg></a></div>';
							echo '</div>';
							echo '</div>';
							wpberita_topbanner_logo();
							?>
						</div><!-- .site-branding -->
					</div>
				</header><!-- #masthead -->
			<?php } ?>
			<?php
			if (!wpberita_is_amp()) {
			?>
				<div id="main-nav-wrap" class="gmr-mainmenu-wrap">
					<div class="container">
						<nav id="main-nav" class="main-navigation gmr-mainmenu">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'menu-1',
									'container'      => 'ul',
									'menu_id'        => 'primary-menu',
								)
							);
							wp_nav_menu(
								array(
									'theme_location' => 'menu-2',
									'container'      => 'ul',
									'menu_id'        => 'secondary-menu',
								)
							);
							?>
						</nav><!-- #main-nav -->
					</div>
				</div>
			<?php
			}
			?>

			<?php do_action('wpberita_topbanner_aftermenu'); ?>

			<div id="content" class="gmr-content">

				<div class="container">
					<div class="row">
