<?php

function hitwave_header_sidebar_print(){
	if (is_home() && is_active_sidebar('hitwave-header-sidebar')) { ?>
		<div class="hitwave-header-sidebar">
			<?php dynamic_sidebar('hitwave-header-sidebar'); ?>
		</div>
	<?php }
}
add_action('__before_content','hitwave_header_sidebar_print');


function hitwave_header_sidebar_register(){
	register_sidebar(array(
		'name' => '[custom] Main Page',
		'id' => 'hitwave-header-sidebar',
		'description' => 'Appears above the main page content',
		'before_widget' => '',
		'after_widget' => ''
	));
}
add_action('widgets_init', 'hitwave_header_sidebar_register');


function hitwave_topbar_sidebar_print(){ ?>
	<nav class="nav-container group hitwave-topbar-sidebar desktop-only">
		<?php dynamic_sidebar('hitwave-topbar-sidebar'); ?>
	</nav>
<?php }
add_action('__before_after_container_inner', 'hitwave_topbar_sidebar_print');


function hitwave_topbar_sidebar_register(){
	register_sidebar(array(
		'name' => '[custom] Topbar',
		'id' => 'hitwave-topbar-sidebar',
		'description' => 'Appears above the header on all pages',
		'before_widget' => '',
		'after_widget' => ''
	));
}
add_action('widgets_init', 'hitwave_topbar_sidebar_register');


add_shortcode('hitwave_social_links', 'hu_print_social_links');


function hitwave_add_post_image_to_content($content){
	ob_start(); ?>
		<figure class="post-image">
			<?php if (has_post_thumbnail()) the_post_thumbnail( 'medium' ); ?>
			<figcaption><?=get_post(get_post_thumbnail_id())->post_excerpt; ?></figcaption>
		</figure>
	<?php return ob_get_clean() . $content;
}
add_filter('the_content', 'hitwave_add_post_image_to_content');


function hitwave_remove_post_image_description_from_excerpt($content){
	if (has_post_thumbnail()){
		$content = str_replace(
			get_post(get_post_thumbnail_id())->post_excerpt,
			'',
			$content
		);
	}
	return $content;
}
add_filter('the_excerpt', 'hitwave_remove_post_image_description_from_excerpt');


function hitwave_include_shortcode($attributes){
  extract(shortcode_atts(array(
    'app' => '',
    'url' => ''
  ), $attributes));
  
  if ($app != ''){
    ob_start();
    include_once('/var/www/app.radiohitwave.com/'.$app.'/index.php');
    return ob_get_clean();
  } 
  else if ($url != ''){
    return file_get_contents($url);
  }
} 
add_shortcode('include', 'hitwave_include_shortcode');
