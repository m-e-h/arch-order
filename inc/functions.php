<?php


function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
    } else {
    $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

function prepare_rest( $data, $post, $request ) {
	$_data = $data->data;
	$thumbnail_id = get_post_thumbnail_id( $post->ID );
	$thumb_med = wp_get_attachment_image_src( $thumbnail_id, 'medium' );

	//Categories
    $cats = get_the_category($post->ID);

	$_data['thumb_med'] = $thumb_med[0];
	$_data['cats'] = $cats;

	$data->data = $_data;
	return $data;
}
add_filter( 'rest_prepare_post', 'prepare_rest', 10, 3 );
