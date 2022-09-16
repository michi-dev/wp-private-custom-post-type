<?php

function cptui_register_my_cpts() {

	/**
	 * Post Type: Private Areas.
	 */

	$labels = [
		"name" => __( "Private Areas", "custom-post-type-ui" ),
		"singular_name" => __( "Private Area", "custom-post-type-ui" ),
		"menu_name" => __( "Private Areas", "custom-post-type-ui" ),
	];


	/*
	you can use all args from 
	https://developer.wordpress.org/reference/classes/wp_post_type/

	with the function https://developer.wordpress.org/reference/functions/register_post_type/

	this is more than the plugin CPT UI, for example you can add custom specified capabilities (dont have to do it with a role-plugini)

	*/

	$args = [
		"label" => __( "Private Areas", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => false, /*important*/
		"publicly_queryable" => false,  /*important*/
		"show_ui" => true,
		"show_in_rest" => false, /*important*/
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "private-area", "with_front" => false ],
		"query_var" => false,
		"menu_position" => -5,
		"menu_icon" => "dashicons-admin-network",
		"supports" => [ "title", "editor" ],
		"taxonomies" => [ "private_status" ],
		"show_in_graphql" => false,
	];

	register_post_type( "private-area", $args );
}

function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Statuses.
	 */

	$labels = [
		"name" => __( "Status", "custom-post-type-ui" ),
		"singular_name" => __( "Status", "custom-post-type-ui" ),
	];

	
	$args = [
		"label" => __( "Status", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => false,
		"publicly_queryable" => false,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => false,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'private_status', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "private_status",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "private_status", [ "post" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );
add_action( 'init', 'cptui_register_my_cpts' );


?>