<?php
//--------------------------------
//------ TABLE OF CONTENTS -------
//--------------------------------
//  1. Hero/Intro
//  2. Real Impact
//  3. Quote Banner
//  4. Hotel Crescent Court
//  5. Event Schedule
//  6. Register Banner
//  7. Expectations
//  8. Register Banner
//  9. Rooftop Pool Party
//  10. Courtyard Lunch
//  11. Cocktail Party
//  12. Atrium Lunch
//--------------------------------

// You can change a sections anchor id below
$id_1 = 'the-conference';
$id_2 = 'about-the-conference';
$id_3 = '';
$id_4 = 'conference-venue';
$id_5 = 'conference-schedule';
$id_6 = '';
$id_7 = 'content';
$id_8 = '';
$id_9 = 'parties';
$id_10 = '';
$id_11 = '';
$id_12 = '';
$id_13 = '';
$id_14 = '';

get_header();
  while( have_posts() ): the_post();
    // 1. Main Hero/Intro Section
    include( locate_template( 'views/sections/hero.php', false, false ) );
    // 2. REAL IMPACT section
    include( locate_template( 'views/sections/real-impact.php', false, false ) );
    // 3. Full Width Quote Banner
    include( locate_template( 'views/sections/full-width-banner-1.php', false, false ) );
    // 4. Hotel Crescent Court
    include( locate_template( 'views/sections/hotel-crescent-court.php', false, false ) );
    // 5. Event Schedule
    include( locate_template( 'views/sections/event-schedule.php', false, false ) );
    // 6. Full Width Banner Register
    include( locate_template( 'views/sections/full-width-banner-2.php', false, false ) );
    // 7. Expectations
    include( locate_template( 'views/sections/expectations.php', false, false ) );
    // 8. Full Width Banner Register
    include( locate_template( 'views/sections/full-width-banner-3.php', false, false ) );
    // 9. Rooftop Pool Party
    include( locate_template( 'views/sections/rooftop-pool-party.php', false, false ) );
    // 10. Courtyard Lunch
    include( locate_template( 'views/sections/courtyard-lunch.php', false, false ) );
    // 11. Cocktail Party
    include( locate_template( 'views/sections/cocktail-party.php', false, false ) );
    // 12. Atrium Lunch
    include( locate_template( 'views/sections/atrium-lunch.php', false, false ) );
    // 13. Liketoknow.it Party
    include( locate_template( 'views/sections/liketoknow.php', false, false ) );
    // 14. The Brands
    include( locate_template( 'views/sections/brands.php', false, false ) );
  endwhile;
get_footer();
