<?php

// =============== Scripts and stylesheets
function myfakedemo_scripts() {
  wp_enqueue_style( 'boostrap', get_template_directory_uri().'/css/bootstrap.min.css', array(), '4.4.1' );
  wp_enqueue_style( 'blog', get_template_directory_uri().'/css/blog.css' );
  wp_enqueue_style( 'style', get_template_directory_uri().'/css/blog.scss' );

  wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'), '4.4.1', true );
}
add_action( 'wp_enqueue_scripts', 'myfakedemo_scripts' );
// =============== .Scripts and stylesheets


// =============== Google fonts
function myfakedemo_google_fonts() {
  wp_register_style( 'Raleway', 'https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' );
  wp_enqueue_style( 'Raleway', sans-serif );
}
add_action( 'wp_print_styles', 'myfakedemo_google_fonts' );
// =============== .Google fonts


// =============== Wordpress titles
add_theme_support( 'title_tag' );
// =============== .Wordpress titles


// =============== Featured images
add_theme_support( 'post-thumbnails' );
// =============== .Featured images


// =============== Custom Post Type
function create_custom_post() {
  register_post_type(
    'custom-post',  // slug
    array(
      'labels' => array(
        'name' => _( 'Custom Post' ),
        'singular_name' => _( 'Custom Post' ),
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array(
        'title', // call with <?php the_title(); ?-->
        'editor',  // call with <?php the_content(); ?-->
        'thumbnail',  // call with <?php the_post_thumbnail(); ?-->
        'custom-fields'
      )
    ));
}
add_action( 'init', 'create_custom_post' );
// =============== .Custom Post Type


// =============== Custom settings section in the admin panel
// Custom Settings menu in panel
function custom_settings_add_menu() {
  add_menu_page( 'Custom Settings', 'Custom Settings', 'manage_options', 'custom-settings', 'custom_settings_page', null, 99 );
}
add_action( 'admin_menu', 'custom_settings_add_menu' );
// Build the page - section and save changes button
function custom_settings_page() { ?>
  <div class="wrap">
    <h1>Custom Settings</h1>
    <form method="post" action="options.php">
      <?php
        settings_fields( 'section' );
        do_settings_sections( 'theme-options' );
        submit_button();
      ?>
    </form>
  </div>
<?php }
// Build input field for TWITTER
function setting_twitter() { ?>
  <input type="text" name="twitter" id="twitter" value="<?php echo get_option( 'twitter' ); ?>" />
<?php }
// Build input field for GITHUB
function setting_github() { ?>
  <input type="text" name="github" id="github" value="<?php echo get_option( 'github' ); ?>" />
<?php }
// Build input field for FACEBOOK
function setting_facebook() { ?>
  <input type="text" name="facebook" id="facebook" value="<?php echo get_option( 'facebook' ); ?>" />
<?php }
// Page setup: show, accept and save
function custom_settings_page_setup() {
  add_settings_section( 'section', 'All Settings', null, 'theme-options' );

  add_settings_field( 'twitter', 'Twitter URL', 'setting_twitter', 'theme-options', 'section' );
  add_settings_field( 'github', 'Github URL', 'setting_github', 'theme-options', 'section' );
  add_settings_field( 'facebook', 'Facebook URL', 'setting_facebook', 'theme-options', 'section' );

  register_setting( 'section', 'twitter' );
  register_setting( 'section', 'github' );
  register_setting( 'section', 'facebook' );
}
add_action( 'admin_init', 'custom_settings_page_setup' );
// =============== .Custom settings section in the admin panel
