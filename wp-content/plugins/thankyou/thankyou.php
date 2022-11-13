<?php
/*
Plugin Name: Hello world
Plugin URI: https://contactform7.com/
Description: Tap viet plugin.
Author: Ngoc Anh
Author URI: https://ideasilo.wordpress.com/
Text Domain: contact-form-7
Domain Path: /languages/
Version: 1.0.0
*/

function greet($content){
    $content = $content.'<div> Cảm ơn bạn đã đọc bài </div>';
    return  $content;
}

add_filter( 'the_content' , 'greet');
// add_filter( 'the_title' , 'greet');