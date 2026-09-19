<?php

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Iklan_List_Table extends WP_List_Table
{
    /**
     * Setiap kolom di data table iklan
     *
     * @return array
     */
    public function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'textdomain'),
            'category' => __('Category', 'textdomain'),
            'tanggal' => __('Date', 'textdomain')
        );
        return $columns;
    }

    /**
     * Setiap kolom di data table dapat diurutkan
     *
     * @return array
     */
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'title' => array('title', false),
            'category' => array('category', false),
            'date' => array('date', true)
        );
        return $sortable_columns;
    }

    /**
     * Ambil data iklan dari database
     *
     * @param int $per_page
     * @param int $page_number
     * @return array
     */
    public function get_data($per_page = 10, $page_number = 1)
    {
        global $wpdb;
        $iklan_table = $wpdb->prefix . "iklan"; // Nama tabel iklan di dalam database WordPress

        // Ambil data iklan dari database
        $query = "SELECT * FROM $iklan_table";

        // Set filter untuk pencarian iklan
        if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {
            $search_term = esc_sql($_REQUEST['s']);
            $query .= " WHERE title LIKE '%$search_term%'";
        }

        // Set filter untuk kategori iklan
        if (isset($_REQUEST['category']) && !empty($_REQUEST['category'])) {
            $category = esc_sql($_REQUEST['category']);
            $query .= " WHERE category = '$category'";
        }

        // Set order untuk daftar iklan
        $orderby = isset($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'date';
        $order = isset($_REQUEST['order']) ? $_REQUEST['order'] : 'desc';
        $query .= " ORDER BY $orderby $order";

        // Hitung total data iklan
        $total_items = $wpdb->query($query);

        // Set pagination
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $offset = $paged * $per_page;
        $query .= " LIMIT $offset, $per_page";

        // Ambil data iklan
        $iklan = $wpdb->get_results($query);

        // Return data iklan
        return array(
            'data' => $iklan,
            'total_items' => $total_items,
            'per_page' => $per_page,
            'page_number' => $page_number,
        );
    }

    /**
     * Tampilkan data iklan di dalam data table
     *
     * @return void
     */
    public function prepare_items()
    {
        $per_page = 10;
        $current_page = $this->get_pagenum();
        $data = $this->get_data($per_page, $current_page);
        $this->set_pagination_args(array(
            'total_items' => $data['total_items'],
            'per_page' => $per_page,
        ));
        $this->_column_headers = $this->get_column_info();
        $this->items = $data['data'];
    }

    /**
     * Tampilkan kolom checkbox
     *
     * @param object $item
     * @return string
     */
    public function column_cb($item)
    {
        return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item->id);
    }

    /**
     * Tampilkan kolom title iklan
     *
     * @param object $item
     * @return string
     */
    public function column_title($item)
    {
        $actions = array(
            'edit' => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>', $_REQUEST['page'], 'edit', $item->id),
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>', $_REQUEST['page'], 'delete', $item->id),
        );

        return sprintf('%1$s %2$s', $item->title, $this->row_actions($actions));
    }

    /**
     * Tampilkan kolom category iklan
     *
     * @param object $item
     * @return string
     */
    public function column_category($item)
    {
        return $item->category;
    }

    /**
     * Tampilkan kolom date iklan
     *
     * @param object $item
     * @return string
     */
    public function column_date($item)
    {
        return date('M j, Y', strtotime($item->date));
    }
}

function my_admin_menu_callback()
{
    add_menu_page(
        'Data Iklan', // Judul halaman
        'Data Iklan', // Nama menu di sidebar
        'manage_options', // Capability
        'data-iklan', // Slug halaman
        'iklan_listable_my_admin_page', // Callback function untuk menampilkan halaman
        'dashicons-clipboard', // Icon
        20 // Urutan tampilan di sidebar
    );
}

function iklan_listable_my_admin_page()
{
    $table = new Iklan_List_Table();
    $table->prepare_items();
?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Daftar Iklan</h1>
        <a href="<?= admin_url('admin.php?page=tambah-iklan') ?>" class="page-title-action">Tambah Iklan</a>
        <hr class="wp-header-end" />
        <form method="post">
            <input type="hidden" name="page" value="tutsplus_list_table">
            <?php $table->search_box('Search', 'search_id'); ?>
            <?php $table->display(); ?>
        </form>
    </div>
<?php
}

// Menambahkan tombol "Tambah Iklan" di halaman daftar iklan
function my_admin_iklan_list_table_actions()
{
    $screen = get_current_screen();

    if ($screen->id !== 'toplevel_page_data-iklan') {
        return;
    }

    echo '<a href="' . admin_url('admin.php?page=tambah-iklan') . '" class="page-title-action">Tambah Iklan</a>';
}

# add_action('admin_notices', 'my_admin_iklan_list_table_actions');
add_action('admin_menu', 'my_admin_menu_callback');


// Menambahkan submenu "Tambah Iklan" di menu "Daftar Iklan"
function iklan_listtable_admin_submenu_callback()
{
    add_submenu_page(
        'data-iklan',
        'Tambah Iklan',
        'Tambah Iklan',
        'manage_options',
        'tambah-iklan',
        'iklan_listable_admin_page_add'
    );
}
add_action('admin_menu', 'iklan_listtable_admin_submenu_callback');

// Callback untuk menampilkan halaman "Tambah Iklan"
function iklan_listable_admin_page_add()
{
    if (isset($_POST['submit'])) {
        // Proses data iklan yang di-submit
        $title = $_POST['title'];
        $content = $_POST['content'];
        $kategori = $_POST['kategori'];
        // Lakukan validasi data iklan di sini

        // Masukkan data iklan ke dalam database
        /*
        $post_id = wp_insert_post(array(
            'post_title' => $title,
            'post_content' => $content,
            'post_type' => 'iklan',
            'post_status' => 'publish',
            'tax_input' => array(
                'kategori' => $kategori
            )
        ));
        */

        // Tampilkan pesan sukses
        echo '<div class="notice notice-success is-dismissible"><p>Iklan berhasil ditambahkan.</p></div>';
    }
?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Tambah Iklan</h1>

        <form method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th><label for="title">Judul</label></th>
                        <td><input type="text" name="title" id="title" class="regular-text" required></td>
                    </tr>
                    <tr>
                        <th><label for="content">Deskripsi</label></th>
                        <td><?php wp_editor('', 'content', array('textarea_name' => 'content')); ?></td>
                    </tr>
                    <tr>
                        <th><label for="kategori">Kategori</label></th>
                        <td>
                            <select name="kategori" id="kategori">
                                <?php
                                $terms = get_terms(array(
                                    'taxonomy' => 'kategori',
                                    'hide_empty' => false
                                ));

                                foreach ($terms as $term) {
                                    echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php submit_button('Tambah Iklan', 'primary', 'submit'); ?>
        </form>
    </div>
<?php
}
