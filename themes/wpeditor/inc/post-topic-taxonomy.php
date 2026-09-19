<?php

if (!function_exists('wpberita_core_create_post_tax')) {
    /**
     * Add new taxonomy in post
     *
     * @since 1.0.0
     * @return void
     */
    function wpberita_core_create_post_tax()
    {
        /* Add new taxonomy, NOT hierarchical (like tags) */
        $labels = array(
            'name'                       => _x('Topics', 'taxonomy general name', 'wpberita-core'),
            'singular_name'              => _x('Topic', 'taxonomy singular name', 'wpberita-core'),
            'search_items'               => __('Search Topics', 'wpberita-core'),
            'popular_items'              => __('Popular Topics', 'wpberita-core'),
            'all_items'                  => __('All Topics', 'wpberita-core'),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'edit_item'                  => __('Edit Topic', 'wpberita-core'),
            'update_item'                => __('Update Topic', 'wpberita-core'),
            'add_new_item'               => __('Add New Topic', 'wpberita-core'),
            'new_item_name'              => __('New Topic Name', 'wpberita-core'),
            'separate_items_with_commas' => __('Separate topics with commas', 'wpberita-core'),
            'add_or_remove_items'        => __('Add or remove topics', 'wpberita-core'),
            'choose_from_most_used'      => __('Choose from the most used topics', 'wpberita-core'),
            'not_found'                  => __('No topics found.', 'wpberita-core'),
            'menu_name'                  => __('Topics', 'wpberita-core'),
        );

        $args = array(
            'hierarchical'          => false,
            'labels'                => $labels,
            'show_ui'               => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'show_in_rest'          => true,
            'rewrite'               => array('slug' => 'topic'),
        );
        register_taxonomy('newstopic', array('post'), $args);
        unset($args);
        unset($labels);
    }
}
add_action('init', 'wpberita_core_create_post_tax', 0);
