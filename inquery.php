<?php
/*
Template Name: お問い合わせ
*/
?>

<?php get_header(); ?>

<div class="inquery-top"></div>

<section class="contact cmn-section -black">
    <?php if( !(is_home() || is_front_page() )): ?>
        <div class="breadcrumb-area">
            <?php
                if ( function_exists( 'bcn_display' ) ) {
                bcn_display();
                }
            ?>
        </div>
    <?php endif; ?>

    <?php while(have_posts()) {?>
        <h2 class="cmn-title">
            <span class="main"><?php the_title(); ?></span>
            <span class="sub">contact</span>
        </h2>
        <?php the_post(); ?>
        <?php the_content(); ?>
    <?php } ?>
</section>

<?php get_footer(); ?>