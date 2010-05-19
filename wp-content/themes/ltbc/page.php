<?php
/*
Description: The default template for pages
*/
?>

<?PHP get_header(); ?>

<h2><?PHP the_title(); ?></h2>

<?PHP the_post(); ?>

<?PHP the_content(); ?>

<?PHP get_footer(); ?>