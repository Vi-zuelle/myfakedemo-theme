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
        $meta = get_post_meta( $post->ID, 'fields', true );
      ?>
      <!-- content of the post-->
      <div class="blog-post">
        <h2 class="blog_post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php the_excerpt(); ?>
        <?php endwhile; endif; wp_reset_postdata(); ?>
      </div> <!-- .blog-post -->
    </div> <!-- .col -->
  </div> <!-- .row -->


<?php get_footer(); ?>