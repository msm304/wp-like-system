<?php

/*
Plugin Name: لایک مطالب
Plugin URI: https://owebra.com/plugins/wp-like-system
Description: پلاگین لایک مطالب
Author: Amirhosein Soltani
Version: 1.0.0
Licence: GPLv2 or Later
Author URI: https://owebra.com/resume
*/

defined('ABSPATH') || exit;

define('LS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LS_PLUGIN_URL', plugin_dir_url(__FILE__));

function wp_ls_register_assets()
{
    // css
    wp_register_style('ls-style', LS_PLUGIN_URL . '/assets/css/front/front-style.css', '', '1.0.0');
    wp_enqueue_style('ls-style');

    // script
    wp_enqueue_script('ls-ajax-js', LS_PLUGIN_URL . '/assets/js/front/ajax.js', ['jquery'], '1.0.0', true);

    wp_register_script('toast-js', LS_PLUGIN_URL . '/assets/js/front/jquery.toast.js', ['jquery'], '1.0.0', true);
    wp_enqueue_script('toast-js');

    wp_register_script('ls-main-js', LS_PLUGIN_URL . '/assets/js/front/main.js', ['jquery'], '1.0.0', true);
    wp_enqueue_script('ls-main-js');

    wp_localize_script('ls-ajax-js', 'ls_ajax', [
        'ls_ajaxurl' => admin_url('admin-ajax.php'),
        '_ls_nonce' => wp_create_nonce(),
        '_ls_user_id' => get_current_user_id(),
    ]);
}

function wp_ls_register_assets_admin()
{
    // css
    wp_register_style('ls-admin-style', LS_PLUGIN_URL . '/assets/css/admin/admin-style.css', '', '1.0.0');
    wp_enqueue_style('ls-admin-style');

    // js
    wp_register_script('ls-admin-js', LS_PLUGIN_URL . '/assets/js/admin/admin-js.js', ['jquery'], '1.0.0', true);
    wp_enqueue_script('ls-admin-js');
};

add_action('wp_enqueue_scripts', 'wp_ls_register_assets');
add_action('admin_enqueue_scripts', 'wp_ls_register_assets_admin');

// Inc files
include_once LS_PLUGIN_DIR . '/view/front/like.php';
include_once LS_PLUGIN_DIR . '_inc/like/like-post.php';
include_once LS_PLUGIN_DIR . '_inc/like/unlike-post.php';
include_once LS_PLUGIN_DIR . '_inc/setting/menu.php';

register_activation_hook(__FILE__, 'wp_ls_set_setting');
register_deactivation_hook(__FILE__, 'wp_ls_delete_setting');
