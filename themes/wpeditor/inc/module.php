<?php

/**
 * Custom homepage category content.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Wpberita
 */

/* Exit if accessed directly */
if (!defined('ABSPATH')) {
	exit;
}

if (!function_exists('wpberita_display_modulehome')) :
	/**
	 * This function for display module in homepage
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function wpberita_display_modulehome()
	{
		global $post;
		$cat = get_theme_mod('gmr_category-module-home', 0);

		$args = array(
			'post_type'              => 'post',
			'cat'                    => $cat,
			'orderby'                => 'date',
			'order'                  => 'desc',
			'showposts'              => 8,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			/**
			 * Make it fast withour update term cache and cache results
			 * https://thomasgriffin.io/optimize-wordpress-queries/
			 */
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);
		if (isset($GLOBALS["post_haram"]))
			$args["exclude"] = $GLOBALS["post_haram"];

		$recent = get_posts($args);
		if ($recent) {
			echo '<div class="modulehome-wrap">';
			echo '<div id="moduleslide" class="wpberita-list-slider wpberita-moduleslide clearfix">';
			$count = 0;
			foreach ($recent as $post) :
				setup_postdata($post);
				if (isset($GLOBALS["post_haram"]))
					if (count($GLOBALS["post_haram"]) <= 3)
						$GLOBALS["post_haram"][] = get_the_ID();
?>
				<div class="gmr-slider-content">
					<div class="list-slider module-home">
						<?php
						if (has_post_thumbnail()) {
						?>
							<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
								<?php
								the_post_thumbnail(
									'medium-new',
									array(
										'alt' => the_title_attribute(
											array(
												'echo' => false,
											)
										),
									)
								);
								if (has_post_format('video')) {
									echo '<span class="gmr-format gmr-format-video">';
									echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg>';
									$h = get_post_meta($post->ID, '_durh', true);
									$m = get_post_meta($post->ID, '_durm', true);
									$s = get_post_meta($post->ID, '_durs', true);
									if (!empty($h) || !empty($m) || !empty($s)) {
										echo '<span class="duration">';
										if (!empty($h) && 0 !== $h) {
											echo esc_html(str_pad(absint($h), 2, '0', STR_PAD_LEFT) . ':');
										}
										if (!empty($m)) {
											echo esc_html(str_pad(absint($m), 2, '0', STR_PAD_LEFT) . ':');
										} else {
											echo '00';
										}
										if (!empty($s)) {
											echo esc_html(str_pad(absint($s), 2, '0', STR_PAD_LEFT));
										} else {
											echo '00';
										}
										echo '</span>';
									}
									echo '</span>';
								} elseif (has_post_format('gallery')) {
									echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
								}
								?>
							</a>
						<?php
						}
						?>
						<div class="list-gallery-title">
							<?php the_title('<a class="recent-title heading-text" href="' . esc_url(get_permalink()) . '" title="' . the_title_attribute(array('echo' => false)) . '" rel="bookmark">', '</a>'); ?>
						</div>
					</div>
				</div>
				<?php
			endforeach;
			wp_reset_postdata();
			echo '</div>';
			echo '</div>';
		}
	}
endif; /* endif wpberita_display_modulehome */
add_action('wpberita_display_modulehome', 'wpberita_display_modulehome', 50);

if (!function_exists('wpberita_display_headline')) :
	/**
	 * This function for display module in homepage
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function wpberita_display_headline()
	{
		global $post;
		$cat = get_theme_mod('gmr_category-headline', 0);

		$args = array(
			'post_type'              => 'post',
			'cat'                    => $cat,
			'orderby'                => 'date',
			'order'                  => 'desc',
			'showposts'              => 3,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			/**
			 * Make it fast withour update term cache and cache results
			 * https://thomasgriffin.io/optimize-wordpress-queries/
			 */
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);
		if (isset($GLOBALS["post_haram"]))
			$args["exclude"] = $GLOBALS["post_haram"];

		$recent = get_posts($args);
		if ($recent) {
			echo '<div class="gmr-bigheadline clearfix">';
			$count = 0;
			foreach ($recent as $post) :
				setup_postdata($post);

				if (isset($GLOBALS["post_haram"]))
					if (count($GLOBALS["post_haram"]) <= 3)
						$GLOBALS["post_haram"][] = get_the_ID();

				$count++;
				if ($count <= 1) {
				?>
					<div class="gmr-big-headline">
						<?php
						if (has_post_thumbnail()) {
						?>
							<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
								<?php
								the_post_thumbnail('large');
								if (has_post_format('video')) {
									echo '<span class="gmr-format gmr-format-video">';
									echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg>';
									$h = get_post_meta($post->ID, '_durh', true);
									$m = get_post_meta($post->ID, '_durm', true);
									$s = get_post_meta($post->ID, '_durs', true);
									if (!empty($h) || !empty($m) || !empty($s)) {
										echo '<span class="duration">';
										if (!empty($h) && 0 !== $h) {
											echo esc_html(str_pad(absint($h), 2, '0', STR_PAD_LEFT) . ':');
										}
										if (!empty($m)) {
											echo esc_html(str_pad(absint($m), 2, '0', STR_PAD_LEFT) . ':');
										} else {
											echo '00';
										}
										if (!empty($s)) {
											echo esc_html(str_pad(absint($s), 2, '0', STR_PAD_LEFT));
										} else {
											echo '00';
										}
										echo '</span>';
									}
									echo '</span>';
								} elseif (has_post_format('gallery')) {
									echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
								}
								?>
							</a>
						<?php
						}
						?>

						<div class="gmr-bigheadline-content">
							<?php
							echo '<div class="gmr-meta-topic">';
							wpberita_category();
							echo '<span class="meta-content">';
							wpberita_posted_on();
							echo '</span>';
							echo '</div>';
							?>
							<h3 class="gmr-rp-biglink">
								<a href="<?php the_permalink(); ?>" class="gmr-slide-titlelink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h3>
							<?php
							if (!is_wp_error(get_the_term_list($post->ID, 'newstopic'))) {
								$termlist = get_the_term_list($post->ID, 'newstopic');
								if (!empty($termlist)) {
									echo '<div class="clearfix meta-content">';
									echo get_the_term_list($post->ID, 'newstopic', '', ', ', '');
									echo '</div>';
								}
							}
							?>
							<div class="entry-content entry-content-archive">
								<?php the_excerpt(); ?>
							</div>
						</div>
					</div>
					<div class="gmr-bigheadline-right">
						<?php
					} else {
						echo '<div class="wrap-headline-right">';
						if (has_post_thumbnail()) {
						?>
							<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
								<?php
								the_post_thumbnail(
									'large',
									array(
										'alt' => the_title_attribute(
											array(
												'echo' => false,
											)
										),
									)
								);
								if (has_post_format('video')) {
									echo '<span class="gmr-format gmr-format-video">';
									echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg>';
									$h = get_post_meta($post->ID, '_durh', true);
									$m = get_post_meta($post->ID, '_durm', true);
									$s = get_post_meta($post->ID, '_durs', true);
									if (!empty($h) || !empty($m) || !empty($s)) {
										echo '<span class="duration">';
										if (!empty($h) && 0 !== $h) {
											echo esc_html(str_pad(absint($h), 2, '0', STR_PAD_LEFT) . ':');
										}
										if (!empty($m)) {
											echo esc_html(str_pad(absint($m), 2, '0', STR_PAD_LEFT) . ':');
										} else {
											echo '00';
										}
										if (!empty($s)) {
											echo esc_html(str_pad(absint($s), 2, '0', STR_PAD_LEFT));
										} else {
											echo '00';
										}
										echo '</span>';
									}
									echo '</span>';
								} elseif (has_post_format('gallery')) {
									echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
								}
								?>
							</a>
					<?php
						}
						if (has_post_thumbnail()) {
							$class = ' has-thumbnail';
						} else {
							$class = ' no-thumbnail';
						}
						the_title('<div class="recent-title-wrap' . esc_html($class) . '"><a class="recent-title heading-text" href="' . esc_url(get_permalink()) . '" title="' . the_title_attribute(array('echo' => false)) . '" rel="bookmark">', '</a></div>');
						echo '</div>';
					}
					?>
					<?php
				endforeach;
				wp_reset_postdata();
				echo '</div>';
				echo '</div>';
			}
		}
	endif; /* endif wpberita_display_headline */
	add_action('wpberita_display_headline', 'wpberita_display_headline', 50);

	if (!function_exists('wpberita_display_headline_archive')) :
		/**
		 * This function for display module in homepage
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function wpberita_display_headline_archive()
		{
			global $post;

			$args = array(
				'post_type'              => 'post',
				'orderby'                => 'date',
				'order'                  => 'desc',
				'showposts'              => 3,
				'post_status'            => 'publish',
				'ignore_sticky_posts'    => 1,
				/**
				 * Make it fast withour update term cache and cache results
				 * https://thomasgriffin.io/optimize-wordpress-queries/
				 */
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'no_found_rows'          => true,
			);

			/* Get Current Tax ID */
			$tax    = get_queried_object();
			$tax_id = $tax->term_id;

			if (is_category()) {
				$args['cat'] = absint($tax_id);
			} elseif (is_tag()) {
				$args['tag_id'] = absint($tax_id);
			} elseif (is_tax('newstopic')) {
				/* Get posts last week */
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'newstopic',
						'field'    => 'term_id',
						'terms'    => absint($tax_id),
					),
				);
			}

			$recent = get_posts($args);
			if ($recent) {
				echo '<div class="gmr-bigheadline clearfix">';
				$count = 0;
				foreach ($recent as $post) :
					setup_postdata($post);
					$count++;
					if ($count <= 1) {
					?>
						<div class="gmr-big-headline">
							<?php
							if (has_post_thumbnail()) {
							?>
								<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
									<?php
									the_post_thumbnail('large');
									if (has_post_format('video')) {
										echo '<span class="gmr-format gmr-format-video">';
										echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg>';
										$h = get_post_meta($post->ID, '_durh', true);
										$m = get_post_meta($post->ID, '_durm', true);
										$s = get_post_meta($post->ID, '_durs', true);
										if (!empty($h) || !empty($m) || !empty($s)) {
											echo '<span class="duration">';
											if (!empty($h) && 0 !== $h) {
												echo esc_html(str_pad(absint($h), 2, '0', STR_PAD_LEFT) . ':');
											}
											if (!empty($m)) {
												echo esc_html(str_pad(absint($m), 2, '0', STR_PAD_LEFT) . ':');
											} else {
												echo '00';
											}
											if (!empty($s)) {
												echo esc_html(str_pad(absint($s), 2, '0', STR_PAD_LEFT));
											} else {
												echo '00';
											}
											echo '</span>';
										}
										echo '</span>';
									} elseif (has_post_format('gallery')) {
										echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
									}
									?>
								</a>
							<?php
							}
							?>

							<div class="gmr-bigheadline-content">
								<?php
								echo '<div class="gmr-meta-topic">';
								wpberita_category();
								echo '<span class="meta-content">';
								wpberita_posted_on();
								echo '</span>';
								echo '</div>';
								?>
								<h3 class="gmr-rp-biglink">
									<a href="<?php the_permalink(); ?>" class="gmr-slide-titlelink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h3>
								<?php
								if (!is_wp_error(get_the_term_list($post->ID, 'newstopic'))) {
									$termlist = get_the_term_list($post->ID, 'newstopic');
									if (!empty($termlist)) {
										echo '<div class="clearfix meta-content">';
										echo get_the_term_list($post->ID, 'newstopic', '', ', ', '');
										echo '</div>';
									}
								}
								?>
								<div class="entry-content entry-content-archive">
									<?php the_excerpt(); ?>
								</div>
							</div>
						</div>
						<div class="gmr-bigheadline-right">
							<?php
						} else {
							echo '<div class="wrap-headline-right">';
							if (has_post_thumbnail()) {
							?>
								<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
									<?php
									the_post_thumbnail(
										'large',
										array(
											'alt' => the_title_attribute(
												array(
													'echo' => false,
												)
											),
										)
									);
									if (has_post_format('video')) {
										echo '<span class="gmr-format gmr-format-video">';
										echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg>';
										$h = get_post_meta($post->ID, '_durh', true);
										$m = get_post_meta($post->ID, '_durm', true);
										$s = get_post_meta($post->ID, '_durs', true);
										if (!empty($h) || !empty($m) || !empty($s)) {
											echo '<span class="duration">';
											if (!empty($h) && 0 !== $h) {
												echo esc_html(str_pad(absint($h), 2, '0', STR_PAD_LEFT) . ':');
											}
											if (!empty($m)) {
												echo esc_html(str_pad(absint($m), 2, '0', STR_PAD_LEFT) . ':');
											} else {
												echo '00';
											}
											if (!empty($s)) {
												echo esc_html(str_pad(absint($s), 2, '0', STR_PAD_LEFT));
											} else {
												echo '00';
											}
											echo '</span>';
										}
										echo '</span>';
									} elseif (has_post_format('gallery')) {
										echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
									}
									?>
								</a>
						<?php
							}
							if (has_post_thumbnail()) {
								$class = ' has-thumbnail';
							} else {
								$class = ' no-thumbnail';
							}
							the_title('<div class="recent-title-wrap' . esc_html($class) . '"><a class="recent-title heading-text" href="' . esc_url(get_permalink()) . '" title="' . the_title_attribute(array('echo' => false)) . '" rel="bookmark">', '</a></div>');

							echo '</div>';
						}
						?>
					<?php
				endforeach;
				wp_reset_postdata();
				echo '</div>';
				echo '</div>';
			}
		}
	endif; /* endif wpberita_display_headline_archive */
	add_action('wpberita_display_headline_archive', 'wpberita_display_headline_archive', 50);

	if (!function_exists('wpberita_get_attachment_gallery')) :
		/**
		 * Display Gallery base attachment post
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function wpberita_get_attachment_gallery()
		{
			global $post, $attachment;

			if (is_attachment()) {
				$args = array(
					'post_type'      => 'attachment',
					'post_status'    => 'inherit',
					'post_parent'    => intval($post->post_parent),
					'post_mime_type' => 'image',
					'posts_per_page' => -1,
				);
			} else {
				$args = array(
					'post_type'      => 'attachment',
					'post_status'    => 'inherit',
					'post_parent'    => intval($post->ID),
					'posts_per_page' => -1,
					'post_mime_type' => 'image',
					'exclude'        => get_post_thumbnail_id($post->ID),
				);
			}
			$images = get_posts($args);

			if ($images) {
				if (wpberita_is_amp()) {
					$class = 'wpberita-list-amp';
				} else {
					$class = 'wpberita-list-slider gmr-singlegallery';
				}
				echo '<div class="' . esc_html($class) . ' clearfix">';

				foreach ($images as $attach) {
					$attachment_id  = $attach->ID;
					$img_url        = wp_get_attachment_image_src($attachment_id, 'medium-new');
					$desc_img       = get_the_title($attachment_id);
					$attachment_url = get_attachment_link($attachment_id);

					if ($img_url) {
						echo '<div class="gmr-slider-content">';
						echo '<div class="list-slider">';
						echo '<a class="post-thumbnail" href="' . esc_url($attachment_url) . '" title="' . esc_html($desc_img) . '"><img src="' . esc_url($img_url[0]) . '" width="' . absint($img_url[1]) . '" height="' . absint($img_url[2]) . '" alt="' . esc_html($desc_img) . '" title="' . esc_html($desc_img) . '" /></a>';
						echo '</div>';
						echo '</div>';
					}
				}
				echo '</div>';
			}
		}
	endif; // endif wpberita_get_attachment_gallery.
	add_action('wpberita_get_attachment_gallery', 'wpberita_get_attachment_gallery', 20);

	if (!function_exists('wpberita_recentpost_marquee')) :
		/**
		 * This function for display slider in homepage
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		function wpberita_recentpost_marquee()
		{
			global $post;
			$cat = get_theme_mod('gmr_category-marque', 0);

			$args = array(
				'post_type'              => 'post',
				'cat'                    => $cat,
				'orderby'                => 'date',
				'order'                  => 'desc',
				'showposts'              => 5,
				'post_status'            => 'publish',
				'ignore_sticky_posts'    => 1,
				/**
				 * Make it fast withour update term cache and cache results
				 * https://thomasgriffin.io/optimize-wordpress-queries/
				 */
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false,
				'no_found_rows'          => true,
			);

			$recent = get_posts($args);
			foreach ($recent as $post) :
				setup_postdata($post);
					?>
					<a href="<?php the_permalink(); ?>" class="gmr-recent-marquee" title="<?php the_title(); ?>"><?php the_title(); ?></a>
		<?php
			endforeach;
			wp_reset_postdata();
		}
	endif; /* endif wpberita_recentpost_marquee */
	add_action('wpberita_recentpost_marquee', 'wpberita_recentpost_marquee', 50);
