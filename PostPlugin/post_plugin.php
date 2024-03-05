<?php
/**
 * Plugin Name: Post Announcement Plugin
 * Description: Adds announcement from defined list in posts.
 * Version: 1.0.2
 */
function pap_admin_actions_register_menu(){
    add_options_page("Post Announcement Plugin", "Post Announcement Plugin", 'manage_options',
        "pap", "pap_admin_page");
}

add_action('admin_menu', 'pap_admin_actions_register_menu');
function pap_admin_page(){
// get _POST variable from globals
    global $_POST;
// process changes from form
    if(isset($_POST['pap_do_change'])){
        if($_POST['pap_do_change'] == 'Y'){
            $posts = get_option('pap_posts');
            if($posts == null)$posts = array();
            array_push($posts,$_POST['pap_post']);
            echo '<div class="notice notice-success isdismissible"><p>Settings saved.</p></div>';
            update_option('pap_posts', $posts);
        }
    }
?>
<div class="wrap">
    <h1>Post Announcement Plugin</h1>
    <form name="pap_form" method="post">
        <input type="hidden" name="pap_do_change" value="Y">
        <p><label for="pap_post">Add new announcement here:</label></p>
        <p><textarea  name="pap_post" id="pap_post" rows="4" cols="50"></textarea></p>
        <p class="submit"><input type="submit" value="Submit"></p>
    </form>
</div>
    <?php
}
function pap_add_random_announcement_to_post( $content ) {
    $posts = get_option('pap_posts');
    $announcement = $posts[rand(0,sizeof($posts)-1)];
    return "<div class=\"pap_announcement\">".$announcement."</div>".$content;
}

add_filter( 'the_content', 'pap_add_random_announcement_to_post' );

function pap_register_styles(){
    //register style
    wp_register_style('pap_styles', plugins_url('/style.css', __FILE__));
    //enable style (load in meta of html)
    wp_enqueue_style('pap_styles');
}
add_action('init', 'pap_register_styles');
?>