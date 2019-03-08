<?php
/*
Plugin Name: Post pagination system
Description: Extension made to split posts and create pagination 
Version: 1.0
Author:  Alessandro Santandrea
License: GPL2
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;


function page_pagination( $content ) {
    if ((is_single()) && ('post' === get_post_type())) {

    global $page, $numpages, $multipage, $more;
    
    $backgroundColor = get_option('background_color');
    $textColor = get_option('text_color');

    $inlineStyle = '';
    $ampClass = '';    
    if( $multipage ) { //probably you should add && $more to this condition.
        $isAmp = is_amp_endpoint();
        if ((!$isAmp) && ($backgrounColor || $textColor)) {
            $inlineStyle = 'style="background:'.$backgroundColor.'; color:'.$textColor.';"';
            
        } else {
            $ampClass= 'ampButtonCss';
        }
        
        $next_text = '<button class="next-button '.$ampClass.'" '.$inlineStyle.'>SUCCESSIVO</button>';
        $prev_text = '<button class="prev-button '.$ampClass.'" '.$inlineStyle.'>PRECEDENTE</button>';

        if( $page < $numpages ) {
            $next = _wp_link_page( $i = $page + 1, '');
            $next_link = $next . $next_text . "</a>";
        }

        if( $i = ( $page - 1 ) ) {
            $prev = _wp_link_page( $i, '' );
            $prev_link = $prev . $prev_text . "</a>";
        }

        $output = 
        "<div class=\"prev-next-page-pps\">"
        . $prev_link 
        . " "
        . $next_link
        . "</div>";

    }

    return $content.$output;
    }
    return $content;
}


add_action('wp_enqueue_scripts', 'include_post_pagination_system_css');

function include_post_pagination_system_css() {
    wp_register_style( 'post_pagination_system_css', plugins_url('/css/style.css', __FILE__));
    wp_enqueue_style( 'post_pagination_system_css' );
}

add_action('admin_enqueue_scripts', 'include_post_pagination_system_file');


function include_post_pagination_system_file() {
    wp_enqueue_script( 'color_picker_ppa_js', plugins_url('/js/color-picker.js', __FILE__), array('jquery'), NULL, true);
    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');
    wp_enqueue_script( 'color_picker_ppa_js');

}
    

add_filter('the_content', 'page_pagination', 1);

 
/**
 * Add Next Page/Page Break Button
 * in WordPress Visual Editor
 */
function my_add_next_page_button( $buttons, $id ){
 
    /* only add this for content editor */
    if ( 'content' != $id )
        return $buttons;
 
    /* add next page after more tag button */
    array_splice( $buttons, 13, 0, 'wp_page' );
 
    return $buttons;
}

 /* Add Next Page Button in First Row */
add_filter( 'mce_buttons', 'my_add_next_page_button', 1, 2 ); // 1st row

//Inserimento css versione amp
function ampforwp_post_pagination_system() { 
    $backgroundColor = get_option('background_color');
    $textColor = get_option('text_color');

?>
   .ampButtonCss {
    <?php
        echo 'background:'.$backgroundColor.';';
        echo 'color:'.$textColor.';';    
    
    ?>
    }
   
    .prev-next-page-pps {
        margin-bottom:10px;
    }

    .prev-next-page-pps .next-button {
        float:right;
    }

    .prev-next-page-pps .next-button, .prev-next-page-pps .prev-button {
        
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#f9f9f9', endColorstr='#e9e9e9',GradientType=0);
         <?php
        if(!$backgroundColor) {
            echo 'background-color:#f9f9f9';
            echo 'background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #f9f9f9), color-stop(1, #e9e9e9));';
            echo 'background:-moz-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);';
            echo 'background:-webkit-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);';
            echo 'background:-o-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);';
            echo 'background:-ms-linear-gradient(top, #f9f9f9 5%, #e9e9e9 100%);';
            echo 'background:linear-gradient(to bottom, #f9f9f9 5%, #e9e9e9 100%);';
        }
        if(!$textColor) 
            echo 'color:#666666;';
        ?>
        -moz-border-radius:8px;
        -webkit-border-radius:8px;
        border-radius:8px;
        border:2px solid #dcdcdc;
        display:inline-block;
        cursor:pointer;
        font-family:Arial;
        font-size:18px;
        font-weight:bold;
        padding:15px 36px;
        text-decoration:none;
    }
    .prev-next-page-pps .next-button:hover, .prev-next-page-pps .prev-button:hover  {
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #e9e9e9), color-stop(1, #f9f9f9));
        background:-moz-linear-gradient(top, #e9e9e9 5%, #f9f9f9 100%);
        background:-webkit-linear-gradient(top, #e9e9e9 5%, #f9f9f9 100%);
        background:-o-linear-gradient(top, #e9e9e9 5%, #f9f9f9 100%);
        background:-ms-linear-gradient(top, #e9e9e9 5%, #f9f9f9 100%);
        background:linear-gradient(to bottom, #e9e9e9 5%, #f9f9f9 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#e9e9e9', endColorstr='#f9f9f9',GradientType=0);
        background-color:#e9e9e9;
    }
    .prev-next-page-pps .next-button:active,.prev-next-page-pps .prev-button:active {
        position:relative;
        top:1px;
    }

    .page-nav-post{
        display:none;
    }
    

    @media only screen and (max-width: 600px) {
        .prev-next-page-pps .next-button, .prev-next-page-pps .prev-button {
            font-size:14px;
        }
        .page-nav-post {
            display:none!important;
        }
    }


	<?php 
}

add_action('amp_post_template_css','ampforwp_post_pagination_system');

// Inserimento settaggi nella dashboard dei plugin

function pps_settings_link($links) {
    $mylinks = array(
         '<a href="' . admin_url( 'admin.php?page=post_pagination_system' ) . '">Settings</a>',
         );
    return array_merge($links, $mylinks);
}

add_filter('plugin_action_links_' .plugin_basename( __FILE__ ),  'pps_settings_link' );

// Inserimento pagina di impostazioni del plugin
function pps_add_settings_page() {
    add_menu_page('Post Pagination System', 'PPS', 'manage_options', 'post_pagination_system', 'pps_admin_index', 'dashicons-image-flip-vertical');
}

function pps_admin_index() {
    require_once plugin_dir_path( __FILE__ ).'templates/admin.php';
}

add_action('admin_menu', 'pps_add_settings_page');

// Aggiunta file js per Amp


?>