<?php
/**
* Post Types.
*
* @package  arch-order
*/

// Register Custom Post Type
function department_post_type() {

	$labels = array(
		'name'                  => _x( 'Departments', 'Post Type General Name', 'meh' ),
		'singular_name'         => _x( 'Department', 'Post Type Singular Name', 'meh' ),
		'menu_name'             => __( 'Department', 'meh' ),
		'name_admin_bar'        => __( 'Department', 'meh' ),
		'archives'              => __( 'Item Archives', 'meh' ),
		'attributes'            => __( 'Item Attributes', 'meh' ),
		'parent_item_colon'     => __( 'Parent Department:', 'meh' ),
		'all_items'             => __( 'All Departments', 'meh' ),
		'add_new_item'          => __( 'Add New Department', 'meh' ),
		'add_new'               => __( 'Add New', 'meh' ),
		'new_item'              => __( 'New Item', 'meh' ),
		'edit_item'             => __( 'Edit Department', 'meh' ),
		'update_item'           => __( 'Update Department', 'meh' ),
		'view_item'             => __( 'View Department', 'meh' ),
		'view_items'            => __( 'View Items', 'meh' ),
		'search_items'          => __( 'Search Department', 'meh' ),
		'not_found'             => __( 'Not found', 'meh' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'meh' ),
		'featured_image'        => __( 'Featured Image', 'meh' ),
		'set_featured_image'    => __( 'Set featured image', 'meh' ),
		'remove_featured_image' => __( 'Remove featured image', 'meh' ),
		'use_featured_image'    => __( 'Use as featured image', 'meh' ),
		'insert_into_item'      => __( 'Insert into item', 'meh' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'meh' ),
		'items_list'            => __( 'Items list', 'meh' ),
		'items_list_navigation' => __( 'Items list navigation', 'meh' ),
		'filter_items_list'     => __( 'Filter items list', 'meh' ),
	);
	$args = array(
		'label'                 => __( 'Department', 'meh' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'page-attributes' ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-groups',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'department', $args );

}
add_action( 'init', 'department_post_type' );
