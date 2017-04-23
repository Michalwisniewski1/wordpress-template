<?php?>

<?php get_header(); ?>
<div class="container">
  <div class="row">
    <div class="col-md-8">

      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

          <div class="media">
            <a class="pull-left" href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail( $size = 'thumbnail'); ?>
            </a>
            <div class="media-body">
              <a href="<?php the_permalink(); ?>"><h4 class="media-heading"><?php the_title(); ?></h4></a>
              <?php the_excerpt(); ?>
              <a href="<?php the_permalink(); ?>" class="btn btn-default">Czytaj więcej</a>
            </div>
          </div>
          <hr>

      <?php endwhile; ?>
      <?php else: ?>
      <?php endif; ?>

    </div>


    <div class="col-md-4">
      <?php get_sidebar(); ?>
    </div>
  </div>
</div>
<?php get_footer(); ?>
