<?php get_header(); ?>

	<div class="row">
		<div class="col-sm-12">

      <?php
        $args = array(
          'post_type' => 'custom-post',
          'ordery' => 'menu_order',
          'order' => 'ASC'
        );

        $custom_query = new WP_Query( $args );
        while ( $custom_query->have_posts() ) : $custom_query->the_post();
      ?>
      <!-- content -->
      <div class="blog-post">
        <h2 class="blog_post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php the_excerpt(); ?>
        <?php endwhile; ?>
      </div> <!-- .blog-post -->
    </div> <!-- .col -->
  </div> <!-- .row -->


<?php get_footer(); ?>