<?php

add_action( 'wp_ajax_nopriv_post_curator_ajax', 'post_curator_ajax' );
add_action( 'wp_ajax_post_curator_ajax', 'post_curator_ajax' );

function post_curator_ajax() {

	$args = array(
		'posts_per_page'   => 1,
		'offset'           => 0,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'post',
		'post_status'      => 'publish',
		'suppress_filters' => true 
		);

	$posts_array = get_posts( $args );

	$p = array();

	foreach ($posts_array as $key => $value) {
		$p[$key]['id'] = $value->ID;
		$p[$key]['pc_category'] = get_option('post_curator_settings');
		$p[$key]['name'] = get_the_title($value->ID);
		$p[$key]['content'] = substr(wp_strip_all_tags($value->post_content), 0, 250);
		$p[$key]['permalink'] = get_the_permalink($value->ID);
		$p[$key]['siteurl'] = site_url($value->ID);
		$p[$key]['category'] = get_the_category($value->ID);
		$p[$key]['tag'] = get_the_tags($value->ID);
		
		$post_thumbnail_id = get_post_thumbnail_id( $value->ID );
		$temp_image = wp_get_attachment_image_src($post_thumbnail_id, 'large');
		$p[$key]['image'] = $temp_image[0];
	}

	$response['posts'] = $p;
	$response = json_encode($response);
	echo $response;
	exit();
}