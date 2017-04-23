<?php?>
<?php get_header(); ?>

<!-- main home content -->
  <div class="container">
    <div class="row  mar-top-20">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="text-center">Hire me! :)</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
          <p class="text-center"><a href="http://github.com/michalwisniewski1" class="btn btn-primary btn-lg" role="button">My GitHub</a></p>
        </div>
      </div>
    </div>
    <div class="row">
<!--New posts-->
      <div class="col-md-12">
        <div class="panel panel-default">
         <div class="panel-heading text-center">
		         <span class="fa-stack fa-5x">
                <i class="fa fa-circle fa-stack-2x text-success"></i>
                <i class="fa fa-wordpress fa-stack-1x fa-inverse"></i>
              </span>
           <h3 class="panel-title">Newsest posts</h3>
         </div>
         <div class="panel-body">
         <?php
         $args = array( 'numberposts' => 4, 'order'=> 'DESC', 'orderby' => 'date', 'category_name' => 'news' );
         $postslist = get_posts( $args );
         foreach ($postslist as $post) :  setup_postdata($post); ?>
           <div class="media">
             <a class="pull-left" href="<?php the_permalink(); ?>">
               <?php
                 if ( has_post_thumbnail() ) {
                   the_post_thumbnail('thumbnail');
                 }
               ?>
             </a>
             <div class="media-body">
               <a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?> </strong></a>
               <?php the_excerpt(); ?>
               <a href="<?php the_permalink(); ?>" class="btn btn-info">Read more</a>
             </div>
           </div>
           <hr>
           <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php get_footer(); ?>
