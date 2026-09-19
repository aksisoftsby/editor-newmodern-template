<?php

/**
 * Template Name: Index Pages
 *
 * A WordPress template to list page titles by first letter.
 *
 * You should modify the CSS to suit your theme and place it in its proper file.
 * Be sure to set the $posts_per_row and $posts_per_page variables.
 *
 * @package Wpberita
 */

/* Exit if accessed directly */
if (!defined('ABSPATH')) {
	exit;
}

get_header();

global $paged;
$pg = (get_query_var('paged')) ? get_query_var('paged') : 1;

?>
<div class="col-md-12">
	<header class="page-header page-index">
		<?php the_title('<h1 class="page-title">', '</h1>'); ?>
	</header><!-- .entry-header -->
</div>
<aside id="secondary" class="widget-area col-md-3 pos-sticky" role="complementary">
	<div class="sidebar-indexpage">
		<?php
		echo '<ul class="index-page-numbers">';
		$arg = array(
			'post_type' => array('post'),
		);

		$categories = get_categories($arg);
		echo '<li><a href="' . esc_url(get_permalink()) . '" class="heading-text" title="' . esc_html__('All News', 'wpberita') . '">' . esc_html__('All News', 'wpberita') . ' <span class="pull-right"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="18" height="18" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.293 3.293a1 1 0 0 1 1.414 0l6 6a1 1 0 0 1 0 1.414l-6 6a1 1 0 0 1-1.414-1.414L14.586 11H3a1 1 0 1 1 0-2h11.586l-4.293-4.293a1 1 0 0 1 0-1.414z" fill="currentColor"/></g><rect x="0" y="0" width="20" height="20" fill="rgba(0, 0, 0, 0)" /></svg></span></a></li>';
		foreach ($categories as $cats) {
			$catid     = absint($cats->term_id);
			$permalink = esc_url(get_permalink());
			echo '<li><a href="' . esc_url(add_query_arg('id', $catid, $permalink)) . '" class="heading-text" title="' . esc_html($cats->name) . '">' . esc_html($cats->name) . ' <span class="pull-right"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="18" height="18" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><g fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.293 3.293a1 1 0 0 1 1.414 0l6 6a1 1 0 0 1 0 1.414l-6 6a1 1 0 0 1-1.414-1.414L14.586 11H3a1 1 0 1 1 0-2h11.586l-4.293-4.293a1 1 0 0 1 0-1.414z" fill="currentColor"/></g><rect x="0" y="0" width="20" height="20" fill="rgba(0, 0, 0, 0)" /></svg></span></a></li>';
		}
		echo '</ul>';
		$default_posts_per_page = get_option('posts_per_page');
		if (isset($_GET['id']) && !empty($_GET['id'])) { /* phpcs:ignore */
			$cat = absint($_GET['id']); /* phpcs:ignore */
		} else {
			$cat = 0; /* phpcs:ignore */
		}
		$query_args = array(
			'post_type'      => 'post',
			'posts_per_page' => absint($default_posts_per_page),
			'cat'            => absint($cat),
			'post_status'    => 'publish',
			'paged'          => absint($paged),
			'orderby'        => 'date',
		);
		/* Get date query */
		if (isset($_GET['dy']) && !empty($_GET['dy']) && isset($_GET['mt']) && !empty($_GET['mt']) && isset($_GET['yr']) && !empty($_GET['yr'])) { /* phpcs:ignore */
			if (isset($_GET['dy']) && !empty($_GET['dy'])) { /* phpcs:ignore */
				$qday = absint($_GET['dy']); /* phpcs:ignore */
			} else {
				$qday = absint(date_i18n('d'));
			}
			if (isset($_GET['mt']) && !empty($_GET['mt'])) { /* phpcs:ignore */
				$qmonth = absint($_GET['mt']); /* phpcs:ignore */
			} else {
				$qmonth = absint(date_i18n('n'));
			}
			if (isset($_GET['yr']) && !empty($_GET['yr'])) { /* phpcs:ignore */
				$qyear = absint($_GET['yr']); /* phpcs:ignore */
			} else {
				$qyear = absint(date_i18n('Y'));
			}
			$query_args['date_query'] = array(
				array(
					'day'   => absint($qday),
					'month' => absint($qmonth),
					'year'  => absint($qyear),
				),
			);
		}
		$rp = new WP_Query(apply_filters('pageindex_posts_args', $query_args));
		?>
	</div>
</aside><!-- #secondary -->

<main id="primary" class="site-main col-md-9 page-index">

	<div class="gmr-filter-index clearfix">
		<?php echo '<div class="text-filter heading-text">' . esc_html__('View By Date', 'wpberita') . '</div>'; ?>
		<form method="get" class="gmr-filterindex" action="<?php the_permalink(); ?>">
			<select id="dy" name="dy" required>
				<?php
				foreach (range(1, 31) as $number) {
					echo '<option value="' . absint($number) . '">' . absint($number) . '</option>';
				}
				?>
			</select>
			<select id="mt" name="mt" required>
				<?php
				$months = array(
					1  => esc_html__('Jan.', 'wpberita'),
					2  => esc_html__('Feb.', 'wpberita'),
					3  => esc_html__('Mar.', 'wpberita'),
					4  => esc_html__('Apr.', 'wpberita'),
					5  => esc_html__('May', 'wpberita'),
					6  => esc_html__('Jun.', 'wpberita'),
					7  => esc_html__('Jul.', 'wpberita'),
					8  => esc_html__('Aug.', 'wpberita'),
					9  => esc_html__('Sep.', 'wpberita'),
					10 => esc_html__('Oct.', 'wpberita'),
					11 => esc_html__('Nov.', 'wpberita'),
					12 => esc_html__('Dec.', 'wpberita'),
				);
				foreach ($months as $num => $name) {
					printf('<option value="%u">%s</option>', absint($num), esc_html($name));
				}
				?>
			</select>
			<input type="number" id="yr" name="yr" min="1000" max="9999" placeholder="<?php echo absint(date_i18n('Y')); ?>" required />
			<input type="submit" value="<?php echo esc_attr__('Filter', 'wpberita'); ?>" />
		</form>
	</div>
	<?php
	global $wp_query;
	// Put default query object in a temp variable.
	$tmp_query = $wp_query;
	// Now wipe it out completely.
	$wp_query = null; /* phpcs:ignore */
	// Re-populate the global with our custom query.
	$wp_query = $rp; /* phpcs:ignore */
	if ($rp->have_posts()) {
		/* Start the Loop */
		echo '<div id="infinite-container">';
		while ($rp->have_posts()) :
			$rp->the_post();

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			get_template_part('template-parts/content', get_post_format());

		endwhile;
		echo '</div>';

		$loadmore = get_theme_mod('gmr_blog_pagination', 'gmr-more');
		if (('gmr-infinite' === $loadmore || 'gmr-more' === $loadmore) && !wpberita_is_amp()) {
			$class = 'inf-pagination';
		} else {
			$class = 'pagination';
		}

		the_posts_pagination(
			array(
				'class'     => esc_html($class),
				'mid_size'  => 1,
				'prev_text' => '&laquo; ' . esc_html__('Back', 'wpberita'),
				'next_text' => esc_html__('Next', 'wpberita') . ' &raquo;',
			)
		);

		if (('gmr-infinite' === $loadmore || 'gmr-more' === $loadmore) && !wpberita_is_amp()) {
			echo '
			<div class="text-center">
				<div class="page-load-status">
					<div class="loader-ellips infinite-scroll-request gmr-ajax-load-wrapper gmr-loader">
						<div class="gmr-ajax-wrap">
							<div class="gmr-ajax-loader">
								<div></div>
								<div></div>
							</div>
						</div>
					</div>
					<p class="infinite-scroll-last">' . esc_attr__('No More Posts Available.', 'wpberita') . '</p>
					<p class="infinite-scroll-error">' . esc_attr__('No more pages to load.', 'wpberita') . '</p>
				</div>';
			if ('gmr-more' === $loadmore) {
				echo '<p><button class="view-more-button heading-text">' . esc_attr__('View More', 'wpberita') . '</button></p>';
			}
			echo '</div>
			';
		}

		wp_reset_postdata();
	} else {
	?>
		<section class="no-results not-found">
			<header class="page-header">
				<h1 class="page-title"><?php esc_attr_e('Nothing Found', 'wpberita'); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php esc_attr_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'wpberita'); ?></p>
			</div><!-- .page-content -->
		</section><!-- .no-results -->
	<?php
	}
	// Restore original query object.
	$wp_query = null; /* phpcs:ignore */
	$wp_query = $tmp_query; /* phpcs:ignore */
	?>
</main><!-- #main -->
<?php
get_footer();
