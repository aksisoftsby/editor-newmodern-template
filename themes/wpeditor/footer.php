<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
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
</div>
</div>
</div>
<?php do_action('wpberita_footerbanner'); ?>
</div><!-- .gmr-content -->

<footer id="colophon" class="site-footer">
	<?php
	$mod = get_theme_mod('gmr_footer_column', '3col');
	if ('4col' === $mod) {
		$class = 'col-md-3';
	} elseif ('1col' === $mod) {
		$class = 'col-md-12';
	} elseif ('2col' === $mod) {
		$class = 'col-md-6';
	} elseif ('6col' === $mod) {
		$class = 'col-md-2';
	} else {
		$class = 'col-md-4';
	}

	if ((is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3') || is_active_sidebar('footer-4') || is_active_sidebar('footer-5') || is_active_sidebar('footer-6')) && !wpberita_is_amp()) :
	?>
		<div id="footer-sidebar" class="widget-footer" role="complementary">
			<div class="container">
				<div class="row">
					<?php if (is_active_sidebar('footer-1')) : ?>
						<div class="footer-column <?php echo esc_html($class); ?>">
							<?php dynamic_sidebar('footer-1'); ?>
						</div>
					<?php endif; ?>
					<?php if (is_active_sidebar('footer-2')) : ?>
						<div class="footer-column <?php echo esc_html($class); ?>">
							<?php dynamic_sidebar('footer-2'); ?>
						</div>
					<?php endif; ?>
					<?php if (is_active_sidebar('footer-3')) : ?>
						<div class="footer-column <?php echo esc_html($class); ?>">
							<?php dynamic_sidebar('footer-3'); ?>
						</div>
					<?php endif; ?>
					<?php if (is_active_sidebar('footer-4')) : ?>
						<div class="footer-column <?php echo esc_html($class); ?>">
							<?php dynamic_sidebar('footer-4'); ?>
						</div>
					<?php endif; ?>
					<?php if (is_active_sidebar('footer-5')) : ?>
						<div class="footer-column <?php echo esc_html($class); ?>">
							<?php dynamic_sidebar('footer-5'); ?>
						</div>
					<?php endif; ?>
					<?php if (is_active_sidebar('footer-6')) : ?>
						<div class="footer-column <?php echo esc_html($class); ?>">
							<?php dynamic_sidebar('footer-6'); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	<div class="container">
		<div class="site-info">
			<div class="gmr-footer-logo">
				<?php
				// if get value from customizer gmr_logoimage.
				$setting = 'gmr_footer_logo';
				$mod     = get_theme_mod($setting, customizer_library_get_default($setting));
				if ($mod) {
					// get url image from value gmr_logoimage.
					$image = esc_url_raw($mod);
					echo '<a href="' . esc_url(get_home_url()) . '" class="custom-footerlogo-link" title="' . esc_html(get_bloginfo('name')) . '">';
					echo '<img src="' . $image . '" alt="' . esc_html(get_bloginfo('name')) . '" title="' . esc_html(get_bloginfo('name')) . '" loading="lazy" />';
					echo '</a>';
				}
				?>
			</div>

			<?php

			echo '<div class="gmr-social-icons">';
			echo '<ul class="social-icon">';
			do_action('social_icon');
			echo '</ul>';
			echo '</div>';
			echo '</div><!-- .site-info -->';

			echo '<div class="heading-text text-center">';
			if (has_nav_menu('menu-5')) {
				wp_nav_menu(
					array(
						'theme_location'  => 'menu-5',
						'container'       => 'div',
						'container_class' => 'footer-menu',
						'depth'           => 1,
					)
				);
			}

			$copyright = get_theme_mod('gmr_copyright');
			if ($copyright) :
				// sanitize html output than convert it again using htmlspecialchars_decode.
				echo wp_kses_post($copyright);
			else :
			?>
				<a href="<?php echo esc_url(__('https://wordpress.org/', 'wpberita')); ?>"><?php printf(esc_html__('Powered by WordPress', 'wpberita')); ?></a>
				<span class="sep"> - </span>
				<?php
				# printf(esc_html__('Theme: wpberita.', 'wpberita')); 
				printf(esc_html__('Editor.id', 'wpberita'));
				?>
			<?php endif; ?>


			<?php
			if (wpberita_is_amp()) :
				/* Add Non AMP Version using div id="site-version-switcher" and id="version-switch-link" */
				$nonamp_link = amp_remove_endpoint(amp_get_current_url());
				echo '<div id="site-version-switcher" class="text-center"><a id="version-switch-link" href="' . esc_url($nonamp_link) . '" class="amp-wp-canonical-link" title="' . esc_html__('Non AMP Version', 'wpberita') . '" rel="noamphtml">' . esc_attr__('Non AMP Version', 'wpberita') . '</a></div>';
			endif;
			?>
		</div>
	</div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php do_action('wpberita_woocommerce_demo_store'); ?>

<?php

if (wpberita_is_amp()) {
	echo '<nav id="navigationamp" [class]="\'site-header-menu\' + ( navMenuExpanded ? \' toggled-on\' : \'\' )" aria-expanded="false" [aria-expanded]="navMenuExpanded ? \'true\' : \'false\'">';
?>
	<div id="gmr-logoamp">
		<?php
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
		echo '<button class="close-topnavmenu-amp menu-toggle" on="tap:AMP.setState( { navMenuExpanded: ! navMenuExpanded } )" [class]="\'close-topnavmenu-amp menu-toggle\' + ( navMenuExpanded ? \' toggled-on\' : \'\' )" aria-expanded="false" [aria-expanded]="navMenuExpanded ? \'true\' : \'false\'"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path fill="currentColor" d="M24 9.4L22.6 8L16 14.6L9.4 8L8 9.4l6.6 6.6L8 22.6L9.4 24l6.6-6.6l6.6 6.6l1.4-1.4l-6.6-6.6L24 9.4z"/></svg></button>';

		?>
	</div>
<?php
} else {
	echo '<nav id="side-nav" class="gmr-sidemenu">';
}

wp_nav_menu(
	array(
		'theme_location' => 'menu-3',
		'container'      => 'ul',
		'menu_id'        => 'primary-menu',
	)
);
echo '</nav>';

do_action('wpberita_floating_banner_footer');
if (!wpberita_is_amp()) {
?>
	<div class="gmr-ontop gmr-hide"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
			<g fill="none">
				<path d="M14.829 11.948l1.414-1.414L12 6.29l-4.243 4.243l1.415 1.414L11 10.12v7.537h2V10.12l1.829 1.828z" fill="currentColor" />
				<path fill-rule="evenodd" clip-rule="evenodd" d="M19.778 4.222c-4.296-4.296-11.26-4.296-15.556 0c-4.296 4.296-4.296 11.26 0 15.556c4.296 4.296 11.26 4.296 15.556 0c4.296-4.296 4.296-11.26 0-15.556zm-1.414 1.414A9 9 0 1 0 5.636 18.364A9 9 0 0 0 18.364 5.636z" fill="currentColor" />
			</g>
		</svg></div>
<?php
}

wp_footer();
?>

</body>

</html>