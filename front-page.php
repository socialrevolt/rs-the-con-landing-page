<?php
//--------------------------------
//------ TABLE OF CONTENTS -------
//--------------------------------
//  1. Hero/Intro
//  2. Real Impact
//  3. Quote Banner
//--------------------------------

$id_1 = 'the-conference';
$id_2 = 'about-the-conference';
$id_3 = '';
$id_4 = 'conference-venue';
$id_5 = 'conference-schedule';
$id_6 = '';
$id_7 = '';

get_header();
  while( have_posts() ): the_post();
  // 1. Main Hero/Intro Section
  include( locate_template( 'views/sections/hero.php', false, false ) );
  // 2. REAL IMPACT section
  include( locate_template( 'views/sections/real-impact.php', false, false ) );
  // 3. Full Width Quote Banner
  include( locate_template( 'views/sections/full-width-banner-1.php', false, false ) );
  endwhile;
get_footer();
