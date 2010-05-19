<?php
/*
Template Name: Home
Description: The custom template for the homepage
*/
?>

<?PHP get_header(); ?>

<div class="leftCol">
	<?php dynamic_sidebar('Homepage-Left'); ?>
</div>
<div class="rightCol">
	<?php dynamic_sidebar('Homepage-Right'); ?>
</div>

<?PHP get_footer(); ?>