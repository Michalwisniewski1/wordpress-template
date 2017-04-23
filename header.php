<?php?>


<!DOCTYPE html>
<html>
  <head>
    <title>Zadanie rekturacyjne kerris.pl</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();?>
  </head>
  <body>
      <header>
        <div class="container">
          <div class="row">
            <div class="col-md-12">
		      <nav class="navbar navbar-default no-corners navbar-clear" role="navigation">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                      <span class="sr-only">Nawigacja strony</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php bloginfo('url'); ?>">logo</a>
                  </div>
                  <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <?php
                      wp_nav_menu( array(
                        'menu'            => 'main-nav',
                        'menu_class'      => 'nav navbar-nav navbar-right',
                        'depth' => 2,
                        'walker'   => new BootstrapNavMenuWalker()
                      ));
                    ?>
                  </div>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </header>
      <div class="container-fluid header-img-wrapper">
        <div class="row">
          <img src="<?php bloginfo('stylesheet_directory'); ?>/img/head.jpg" alt="header img" class="img-responsive center-block" width="1200" height="300">
        </div>
      </div>
