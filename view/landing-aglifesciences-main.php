<?php

if ( get_field( 'coals_program_units' ) ) {
  get_template_part( 'home', 'programs' );
}
?> 

<div class="home-widgets">
  <div class="home-widget-left">
    <?php dynamic_sidebar( 'Home Page Bottom Left' ); ?>
  </div>

  <div class="home-widget-right">
    <?php dynamic_sidebar( 'Home Page Bottom Right' ); ?>
  </div>
</div>