<?PHP

register_sidebar(array(
	'name' => 'Homepage',
	'before_widget' => '<div class="box col">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

dynamic_sidebar();