<?php
function wp_ls_like_layout()
{
?>
    <div class="like-container">
        <div class='middle-wrapper'>
            <div class='like-wrapper'>
                <?php if(metadata_exists('user',get_current_user_id(),'_ls_like_post_ids')){
                    $post_id = get_user_meta(get_current_user_id(), '_ls_like_post_ids',true);
                }else{
                    $post_id = [];
                } ?>
                <a class='<?php echo in_array(get_the_ID(),$post_id) ? 'user-liked unlike-button' : 'like-button'?>' data-post-id="<?php echo get_the_ID() ?>" data-user-id="<?php echo get_current_user_id() ?>">
                    <span class="like-counter"><?php echo get_post_meta(get_the_ID(),'_ls_like_number', true) ? get_post_meta(get_the_ID(),'_ls_like_number', true) : '0' ?></span>
                    <span class='like-icon'>
                        <div class='heart-animation-1'></div>
                        <div class='heart-animation-2'></div>
                    </span>
                </a>
            </div>
        </div>
    </div>
<?php
}

add_shortcode('like-post', 'wp_ls_like_layout');
