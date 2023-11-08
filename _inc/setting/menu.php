<?php
function wp_ls_register_menu()
{
    add_menu_page(
        'تنظیمات پلاگین مطالب مرتبط',
        'مطالب مرتبط',
        'manage_options',
        'related-post-setting',
        'wp_ls_like_post_admin_layout',

    );
}

include_once LS_PLUGIN_DIR . '_inc/setting/setting.php';
add_action('admin_menu', 'wp_ls_register_menu');