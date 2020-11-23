<?php

// Scripts and stylesheets
function myfakedemo_scripts() {
  // wp_enqueue_style( 'boostrap', get_template_directory_uri().'/css/bootstrap.min.css', array(), '4.4.1' );
  wp_enqueue_style( 'blog', get_template_directory_uri().'/css/blog.css' );

  // wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'), '4.4.1', true );
}
add_action( 'wp_enqueue_scripts', 'myfakedemo_scripts' );

// Google fonts
function myfakedemo_google_fonts() {
  wp_register_style( 'Raleway', 'https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' );
  wp_enqueue_style( 'Raleway', sans-serif );
}
add_action( 'wp_print_styles', 'myfakedemo_google_fonts' );

// Wordpress titles
add_theme_support( 'title_tag' );