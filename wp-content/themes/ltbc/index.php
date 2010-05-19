<?php
/*
Template Name: Default
Description: The custom template for the homepage
*/
?>

<?PHP get_header(); ?>

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>
		
		<?PHP the_content(); ?>
		
	<?php endwhile; ?>
<?php else : ?>

	<h2 class="center">Not Found</h2>
	<p class="center">Sorry, but you are looking for something that isn't here.</p>

<?php endif; ?>
	
<?PHP get_footer(); ?>