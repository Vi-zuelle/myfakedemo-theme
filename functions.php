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
      'hierarchical' => true,
      'has_archive' => true,
      'supports' => array(
        'title', // call with <?php the_title(); ?-->
        'editor',  // call with <?php the_content(); ?-->
        'excerpt',  // call with <?php the_excerpt(); ?-->
        'thumbnail',  // call with <?php the_post_thumbnail(); ?-->
        'custom-fields'
    ),
    'taxonomies' => array(
      'post_tag',
      'category',
    )
  ));
  register_taxonomy_for_object_type( 'category', 'custom-post' );
	register_taxonomy_for_object_type( 'post_tag', 'custom-post' );
}
add_action( 'init', 'create_custom_post' );
// =============== .Custom Post Type


// =============== Meta box
function add_your_fields_meta_box() {
	add_meta_box(
		'your_fields_meta_box', // $id
		'Additional Fields', // $title
		'show_your_fields_meta_box', // $callback
		'custom-post', // $screen
		'normal', // $context
		'high' // $priority
	);
}
add_action( 'add_meta_boxes', 'add_your_fields_meta_box' );

function show_your_fields_meta_box() {
    global $post;

		$meta = get_post_meta( $post->ID, 'your_fields', true ); ?>

  <input type="hidden" name="your_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

  <p>
    <label for="your_fields[text]">Input Text</label>
    <br>
    <input type="text" name="your_fields[text]" id="your_fields[text]" class="regular-text" value="<?php if (is_array($meta) && isset($meta['text'])) {	echo $meta['text']; } ?>">
  </p>
  <p>
    <label for="your_fields[textarea]">Textarea</label>
    <br>
    <textarea name="your_fields[textarea]" id="your_fields[textarea]" rows="5" cols="30" style="width:500px;"><?php echo $meta['textarea']; ?></textarea>
  </p>
  <p>
    <label for="your_fields[checkbox]">Checkbox
			<input type="checkbox" name="your_fields[checkbox]" value="checkbox" <?php if ( $meta['checkbox'] === 'checkbox' ) echo 'checked'; ?>>
		</label>
  </p>
  <p>
    <label for="your_fields[select]">Select Menu</label>
    <br>
    <select name="your_fields[select]" id="your_fields[select]">
				<option value="option-one" <?php selected( $meta['select'], 'option-one' ); ?>>Option One</option>
				<option value="option-two" <?php selected( $meta['select'], 'option-two' ); ?>>Option Two</option>
		</select>
  </p>
  <p>
    <label for="your_fields[image]">Image Upload</label><br>
    <input type="text" name="your_fields[image]" id="your_fields[image]" class="meta-image regular-text" value="<?php echo $meta['image']; ?>">
    <input type="button" class="button image-upload" value="Browse">
  </p>
  <div class="image-preview"><img src="<?php echo $meta['image']; ?>" style="max-width: 250px;"></div>


  <script>
    jQuery(document).ready(function ($) {
      // Instantiates the variable that holds the media library frame.
      var meta_image_frame;
      // Runs when the image button is clicked.
      $('.image-upload').click(function (e) {
        // Get preview pane
        var meta_image_preview = $(this).parent().parent().children('.image-preview');
        // Prevents the default action from occuring.
        e.preventDefault();
        var meta_image = $(this).parent().children('.meta-image');
        // If the frame already exists, re-open it.
        if (meta_image_frame) {
          meta_image_frame.open();
          return;
        }
        // Sets up the media library frame
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
          title: meta_image.title,
          button: {
            text: meta_image.button
          }
        });
        // Runs when an image is selected.
        meta_image_frame.on('select', function () {
          // Grabs the attachment selection and creates a JSON representation of the model.
          var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
          // Sends the attachment URL to our custom image input field.
          meta_image.val(media_attachment.url);
          meta_image_preview.children('img').attr('src', media_attachment.url);
        });
        // Opens the media library frame.
        meta_image_frame.open();
      });
    });
  </script>

  <?php }
function save_your_fields_meta( $post_id ) {
	// verify nonce
	if ( isset($_POST['your_meta_box_nonce'])
			&& !wp_verify_nonce( $_POST['your_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id;
		}
	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	// check permissions
	if (isset($_POST['post_type'])) { //Fix 2
        if ( 'page' === $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }
    }

	$old = get_post_meta( $post_id, 'your_fields', true );
		if (isset($_POST['your_fields'])) { //Fix 3
			$new = $_POST['your_fields'];
			if ( $new && $new !== $old ) {
				update_post_meta( $post_id, 'your_fields', $new );
			} elseif ( '' === $new && $old ) {
				delete_post_meta( $post_id, 'your_fields', $old );
			}
		}
}

add_action( 'save_post', 'save_your_fields_meta' );


// =============== Next function

// =============== .Next function