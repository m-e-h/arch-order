<?php


// function prepare_rest( $data, $post, $request ) {
// 	$_data = $data->data;
// 	$thumbnail_id = get_post_thumbnail_id( $post->ID );
// 	$thumb_med = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
//
// 	//Categories
// 	$cats = get_the_category( $post->ID );
// 	$author_name = get_the_author();
//
// 	$_data['thumb_med'] = $thumb_med[0];
// 	$_data['cats'] = $cats;
// 	$_data['author_name'] = $author_name;
//
// 	$data->data = $_data;
// 	return $data;
// }
// add_filter( 'rest_prepare_post', 'prepare_rest', 10, 3 );


// add_action( 'rest_api_init', 'ao_register_author_name' );
// function ao_register_author_name() {
// 	register_rest_field( 'post',
// 		'author_name',
// 		array(
// 			'get_callback'    => 'ao_get_author_name',
// 			'update_callback' => null,
// 			'schema'          => null,
// 		)
// 	);
// }
//
// function ao_get_author_name() {
// 	return get_the_author_meta( 'display_name' );
// }

add_action( 'rest_api_init', 'ao_register_posted_on' );
function ao_register_posted_on() {
	register_rest_field( 'post',
		'posted_on',
		array(
			'get_callback'    => 'ao_get_posted_on',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	register_rest_field( 'post',
		'author_name',
		array(
			'get_callback'    => 'ao_get_author_name',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	register_rest_field( 'post',
		'cats',
		array(
			'get_callback'    => 'ao_get_cats',
			'update_callback' => null,
			'schema'          => null,
		)
	);

	register_rest_field( 'post',
		'thumb_url',
		array(
			'get_callback'    => 'ao_get_thumb_url',
			'update_callback' => null,
			'schema'          => null,
		)
	);
}

function ao_get_posted_on() {
	return get_the_date();
}

function ao_get_author_name() {
	return get_the_author();
}

function ao_get_cats() {
	return get_the_category();
}

function ao_get_thumb_url() {
	return get_the_post_thumbnail_url( get_the_ID(), 'medium' );
}
