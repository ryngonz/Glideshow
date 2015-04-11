<?php
    /*
    Plugin Name: Glideshow
    Plugin URI: http://www.ryandev.rocks
    Description: Grid image Slider
    Author: Ryan G. Gonzales
    Version: 1.0 beta
    Author URI: http://www.ryandev.rocks
    License: GNU GPL2
    */
    /*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    */

    /* REQUIRED FILES */    
    require_once("lib/events.php");

    /* ADD ACTIONS */
    add_action('admin_menu', 'boot_admin_glideshow');
    add_action('wp_enqueue_scripts', 'glideshow_script');
    add_action('wp_head','glideshow_script');

    /* ADD SHORTCODE */
    add_shortcode( 'glideshow', 'glideshow_sc_func' );

    function glideshow_sc_func( $atts ) {
        echo glideshowrBoot();
        echo glideshowrJsStarter();
    }

    function glideshow_script( $template_path ) {
        wp_enqueue_style( 'glideshow-reset-css', plugin_dir_url( __FILE__ ).'css/reset.css' );
        wp_enqueue_style( 'glideshow-slider-css', plugin_dir_url( __FILE__ ).'css/slider.css' );
        wp_enqueue_style( 'glideshow-main-css', plugin_dir_url( __FILE__ ).'css/slider.css' );
        wp_enqueue_script("jquery");
        wp_enqueue_script( 'glideshow-respond-js', plugin_dir_url( __FILE__ ).'js/respond.js', array() , '1.0.0', true );
        wp_enqueue_script( 'glideshow-caroufredsel-js', plugin_dir_url( __FILE__ ).'js/caroufredsel.js', array() , '1.0.0', true );
    }

    function boot_admin_glideshow(){
        add_menu_page( 'Glideshow', 'Glideshow', 'manage_options', 'glideshow', 'glideshow_admin_init');
    }

    function glideshow_admin_init(){
        $glideshow_id = get_option("glideshow_id");
        $glideshow_glides = json_decode(get_option("glides"));
        $glideshow_custom_css = get_option("glideshow_custom_css");
        $console = false;
        include("lib/mojo-admin-page.php");
    }

    function glideshowrBoot(){
        $glideshow_id = get_option("glideshow_id");
        $glideshow_glides = json_decode(get_option("glides"));
        $glideshow_custom_css = get_option("glideshow_custom_css");
        $glideshowContent = '<div id="glideshow_slider"><div class="caroufredsel_wrapper"><div id="'.$glideshow_id.'" class="sliderwrap clearfix">';
    
        if(is_array($glideshow_glides)){
            $countFieldsets = 0;
            foreach($glideshow_glides as $block){
                $glideshowContent .= '<div class="block-container" style="margin-right: 0px;">';
                if($block->blockName == "1x1-2x1-1x1"){
                    $tmp_content = array();
                    $tmp_count = 0;
                    foreach($block as $index => $val){
                        if($index != "blockName"){
                            $type = "";
                            if($val->type == "HTML"){
                                $type = "-text";
                                $content = $val->content;
                            }else{
                                switch($val->orientation){
                                    case "2x2":
                                        $dimension = "style='width:300px; height:300px;'";
                                        break;
                                    case "2x1":
                                        $dimension = "style='width:145px; height:300px;'";
                                        break;
                                    case "1x2":
                                        $dimension = "style='width:300px; height:145px;'";
                                        break;
                                    case "1x1":
                                        $dimension = "style='width:145px; height:145px;'";
                                        break;
                                }
                                $content = "<img src='".$val->content."' ".$dimension." />";
                            }
                            $tmp_content[$tmp_count] = '<div class="block-'.$val->orientation.$type.'" style="background-color:'.$val->color.';">';
                            $tmp_content[$tmp_count] .= '<div class="grid-content">'.$content.'</div>';
                            $tmp_content[$tmp_count] .= '</div>';
                        }
                        $tmp_count++;
                    }
                    $glideshowContent .= '<div class="block-contain">';
                    $glideshowContent .= $tmp_content[0];
                    $glideshowContent .= $tmp_content[2];
                    $glideshowContent .= '</div>';
                    $glideshowContent .= $tmp_content[1];
                }else{
                    foreach($block as $index => $val){
                        if($index != "blockName"){
                            $type = "";
                            if($val->type == "HTML"){
                                $type = "-text";
                                $content = $val->content;
                            }else{
                                switch($val->orientation){
                                    case "2x2":
                                        $dimension = "style='width:300px; height:300px;'";
                                        break;
                                    case "2x1":
                                        $dimension = "style='width:145px; height:300px;'";
                                        break;
                                    case "1x2":
                                        $dimension = "style='width:300px; height:145px;'";
                                        break;
                                    case "1x1":
                                        $dimension = "style='width:145px; height:145px;'";
                                        break;
                                }
                                $content = "<img src='".$val->content."' ".$dimension." />";
                            }

                            $glideshowContent .= '<div class="block-'.$val->orientation.$type.'" style="background-color:'.$val->color.';">';
                            $glideshowContent .= '<div class="grid-content">'.$content.'</div>';
                            $glideshowContent .= '</div>';
                        }
                    }
                }
                $glideshowContent .= '</div>';
                $countFieldsets++;
            }
        }
        $glideshowContent .= '</div></div></div>';
        return $glideshowContent;
    }

    function glideshowrJsStarter(){
        $glideshow_id = get_option("glideshow_id");
        $jscontent =  "<script> 
            jQuery(function() {
                jQuery('#".$glideshow_id."').carouFredSel({
                    width: '100%',
                    items: {
                        visible: 'odd+2'
                    },
                    scroll: {
                        pauseOnHover: 'immediate-resume',
                        onBefore: function() {
                            jQuery(this).children().removeClass( 'hover' );
                        }
                    },
                    auto: {
                        easing:'linear',
                        items: 1,
                        duration: 8000,
                        timeoutDuration: 0
                    },
                    swipe: {
                        onMouse:true,
                        onTouch:true
                    },
                });
            });
        </script>";

        return $jscontent;
    }

function wpb_load_widget() {
    register_widget( 'glideshow_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

class glideshow_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
        'glideshow_widget', 
        __('Glideshow Widget', 'glideshow_widget_domain'), 
        array( 'description' => __( 'Widget for Glideshow', 'glideshow_widget_domain' ), ) 
        );
    }

    public function widget( $args, $instance ) {
        echo glideshowrBoot();
        echo glideshowrJsStarter();
    }
}
?>