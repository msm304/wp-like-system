<?php
add_action('wp_ajax_wp_ls_like_post', 'wp_ls_like_post');
add_action('wp_ajax_nopriv_wp_ls_like_post', 'wp_ls_like_post');
function wp_ls_like_post()
{
    if (isset($_POST['_nonce']) && !wp_verify_nonce($_POST['_nonce'])) {
        die('access denied !!!');
    }
    if (!is_user_logged_in()) {
        wp_send_json([
            'error' => true,
            'message' => 'برای لایک این مطلب ابتدا باید در سایت لاگین نمایید.',
        ], 403);
    }
    if (!empty($_POST['post_id']) && !empty($_POST['user_id'])) {
        $post_id = intval($_POST['post_id']);
        $user_id = intval($_POST['user_id']);
        is_user_liked_post($user_id, $post_id);
        if (!metadata_exists('user', $user_id, '_ls_like_post_ids')) {
            $meta_value[] = $post_id;
            add_user_meta($user_id, '_ls_like_post_ids', $meta_value);
        } else {
            $current_meta_value = get_user_meta($user_id, '_ls_like_post_ids', true);
            $current_meta_value[] = $post_id;
            update_user_meta($user_id, '_ls_like_post_ids', $current_meta_value);
            // echo '<pre>';var_dump($current_meta_value);echo '</pre>';exit;
        }
        add_to_like_counter($post_id);
        wp_send_json([
            'success' => true,
            'message' => 'با تشکر لایک شما ثبت شد.',
            'like_number' => get_post_meta($post_id, '_ls_like_number', true),
        ], 200);
    } else {
        wp_send_json([
            'error' => true,
            'message' => 'خطایی رخ داده است.',
        ], 403);
    }
}

function is_user_liked_post($user_id, $post_id)
{
    $user_liked_post_ids = get_user_meta($user_id, '_ls_like_post_ids', true);
    foreach ($user_liked_post_ids as $value) {
        if ($value == $post_id) {
            wp_send_json([
                'error' => true,
                'message' => 'شما قبلا این مطلب را لایک کرده اید.',
            ], 403);
        }
    }
}

function add_to_like_counter($post_id)
{
    if (!metadata_exists('post', $post_id, '_ls_like_number')) {
        add_post_meta($post_id, '_ls_like_number', '1');
    } else {
        $like_number = get_post_meta($post_id, '_ls_like_number', true);
        $like_number++;
        update_post_meta($post_id, '_ls_like_number', $like_number);
    }
}
