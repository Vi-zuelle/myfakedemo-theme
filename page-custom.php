<?php get_header(); ?>

	<div class="row">
		<div class="col-sm-12">

      <?php
        $args = array(
          'post_type' => 'custom-post'
          // 'ordery' => 'menu_order',
          // 'order' => 'ASC'
        );

        $custom_query = new WP_Query( $args );

        if ( $custom_query->have_posts() ) : while ( $custom_query->have_posts() ) : $custom_query->the_post();
        $meta = get_post_meta( $post->ID, 'your_fields', true );
      ?>
      <!-- content of the post-->
      <div class="blog-post">
        <h2 class="blog_post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <?php the_excerpt(); ?>

        <h1>Text Input</h1>
        <?php echo $meta['text']; ?>

        <h1>Textarea</h1>
        <?php echo $meta['textarea']; ?>


        <h1>Checkbox</h1>
        <?php if ( $meta['checkbox'] === 'checkbox') { ?>
        Checkbox is checked.
        <?php } else { ?>
        Checkbox is not checked.
        <?php } ?>


        <h1>Select Menu</h1>
        <p>The actual value selected.</p>
        <?php echo $meta['select']; ?>

        <p>Switch statement for options.</p>
        <?php
          switch ( $meta['select'] ) {
            case 'option-one':
              echo 'Option One';
              break;
            case 'option-two':
              echo 'Option Two';
              break;
            default:
              echo 'No option selected';
              break;
          }
        ?>

        <h1>Image</h1>
        <img src="<?php echo $meta['image']; ?>">

        <?php endwhile; endif; wp_reset_postdata(); ?>
      </div> <!-- .blog-post -->
    </div> <!-- .col -->
  </div> <!-- .row -->


<?php get_footer(); ?>