<?php
/*
Template Name: Messages
Description: The custom template for the homepage
*/
?>

<?PHP get_header(); ?>

<?PHP
$sb = new Messages_List_Widget();
$sb->widget(array(), array('full'=>true));
?>

<?PHP get_footer(); ?>