<?php
function wp_ls_like_post_admin_layout()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    if (isset($_GET['settings-update'])) {
        add_settings_error('setting', 'setting-message', 'تنظیمات ذخیره گردید', 'update');
    }
    settings_errors('setting-message');
?>
    <div class="wrap rp-wrapper">
        <form action="options.php" method="post" class="related-posts">
            <h1><?php echo esc_html(get_admin_page_title()) ?></h1>
            <?php
            settings_fields('related-post');
            do_settings_sections('related-post-html');
            submit_button()
            ?>
        </form>
    </div>
<?php
}

function wp_ls_setting_init()
{
    $args = [
        'type' => 'string',
        'sanitize_callback' => '_sanitize_text_fields',
        'defult' => null
    ];
    // register_setting('related-post', '_rp_title', $args);
    // register_setting('related-post', '_rp_number', $args);
    // register_setting('related-post', '_rp_according_to', $args);
    // register_setting('related-post', '_rp_order_by', $args);
    // register_setting('related-post', '_rp_show_type', $args);

    $settings_array = [
        '_rp_title',
        '_rp_number',
        '_rp_according_to',
        '_rp_order_by',
        '_rp_show_type',
    ];

    foreach ($settings_array as $setting_array) {
        register_setting('related-post', $setting_array, $args);
    }

    add_settings_section('rp_settings_section', '', '', 'related-post-html');
    add_settings_field('rp_settings_field', '', 'rp_render_html', 'related-post-html', 'rp_settings_section');
}

add_action('admin_init', 'wp_ls_setting_init');

function ls_render_html()
{
    $rp_title = get_option('_rp_title');
    $rp_number = get_option('_rp_number');
    $rp_according_to = get_option('_rp_according_to');
    $rp_order_by = get_option('_rp_order_by');
    $rp_show_type = get_option('_rp_show_type');
?>
    <div class="element-wrapper">

        <label for="title">عنوان بخش مطالب مرتبط در قالب</label>
        <input id="title" type="text" name="_rp_title" value="<?php echo isset($rp_title) ? esc_attr($rp_title) : '' ?>">

        <label for="number">تعداد مطالب جهت نمایش</label>
        <input id="number" type="text" name="_rp_number" value="<?php echo isset($rp_number) ? esc_attr($rp_number) : '' ?>">

        <label for="according_to">نمایش مطالب بر اساس</label>
        <select id="according_to" name="_rp_according_to">
            <option value="category" <?php echo selected($rp_according_to, 'category') ?>>دسته بندی مطالب</option>
            <option value="tags" <?php echo selected($rp_according_to, 'tags') ?>>برچسب های مطالب</option>
        </select>

        <label for="order_by">نوع نمایش مطالب</label>
        <select id="order_by" name="_rp_order_by">
            <option value="asc" <?php echo selected($rp_order_by, 'asc') ?>>صعودی</option>
            <option value="desc" <?php echo selected($rp_order_by, 'desc') ?>>نزولی</option>
            <option value="rand" <?php echo selected($rp_order_by, 'rand') ?>>تصادفی</option>
        </select>

        <label for="title">حالت نمایش</label>
        <div class="display-type">
            <label>
                <input type="radio" name="_rp_show_type" value="block" <?php echo checked($rp_show_type, 'block') ?>>
                <img src="<?php echo RP_PLUGIN_URL . 'assets/img/thumb.jpg' ?>" alt="">
            </label>
            <label>
                <input type="radio" name="_rp_show_type" value="list" <?php echo checked($rp_show_type, 'list') ?>>
                <img src="<?php echo RP_PLUGIN_URL . 'assets/img/list.jpg' ?>" alt="">
            </label>
        </div>
    </div>
<?php
}
