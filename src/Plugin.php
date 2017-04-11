<?php

namespace UpfrontMama\Loves;

class Plugin {
	protected $post_type_key = "upfrontmamaloves";
	
	function __construct() {
		
		add_action( 'init', array($this, 'custom_post_type'), 0 );
		add_filter( 'rwmb_meta_boxes', array($this, 'meta_boxes') );
		add_action( 'add_meta_boxes', array($this, 'yoast_is_toast'), 99 );
		add_action( 'init', array($this,'taxonomy'), 0 );
		add_action( 'widgets_init', array($this, 'loadWidget'));
		$this->check_for_update();
	}

	function check_for_update() {
		$myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
			'https://github.com/fredbradley/upfrontmama-loves/',
			__FILE__,
			'upfrontmama-loves'
		);
	}
	
	function loadWidget() {
		return register_widget(new Widget());
	}

	function yoast_is_toast(){
	   //capability of 'manage_plugins' equals admin, therefore if NOT administrator
	   //hide the meta box from all other roles on the following 'post_type' 
	   //such as post, page, custom_post_type, etc
	   // if (!current_user_can('activate_plugins')) {
	        remove_meta_box('wpseo_meta', $this->post_type_key, 'normal');
	   // }
	}

	// Register Custom Taxonomy
	function taxonomy() {
	
		$labels = array(
			'name'                       => _x( 'Love Categories', 'Taxonomy General Name', 'upfront-mama' ),
			'singular_name'              => _x( 'Love Category', 'Taxonomy Singular Name', 'upfront-mama' ),
			'menu_name'                  => __( 'Shop Categories', 'upfront-mama' ),
			'all_items'                  => __( 'All Items', 'upfront-mama' ),
			'parent_item'                => __( 'Parent Item', 'upfront-mama' ),
			'parent_item_colon'          => __( 'Parent Item:', 'upfront-mama' ),
			'new_item_name'              => __( 'New Item Name', 'upfront-mama' ),
			'add_new_item'               => __( 'Add New Item', 'upfront-mama' ),
			'edit_item'                  => __( 'Edit Item', 'upfront-mama' ),
			'update_item'                => __( 'Update Item', 'upfront-mama' ),
			'view_item'                  => __( 'View Item', 'upfront-mama' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'upfront-mama' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'upfront-mama' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'upfront-mama' ),
			'popular_items'              => __( 'Popular Items', 'upfront-mama' ),
			'search_items'               => __( 'Search Items', 'upfront-mama' ),
			'not_found'                  => __( 'Not Found', 'upfront-mama' ),
			'no_terms'                   => __( 'No items', 'upfront-mama' ),
			'items_list'                 => __( 'Items list', 'upfront-mama' ),
			'items_list_navigation'      => __( 'Items list navigation', 'upfront-mama' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		register_taxonomy( 'love-categories', array( 'upfrontmamaloves' ), $args );
	
	}
	// Register Custom Must Have Item
	function custom_post_type() {
	
		$labels = array(
			'name'                  => _x( 'Upfront Mama Loves', 'Must Have Item General Name', 'upfrontmama' ),
			'singular_name'         => _x( 'Must Have Item', 'Must Have Item Singular Name', 'upfrontmama' ),
			'menu_name'             => __( 'Upfront Mama Loves', 'upfrontmama' ),
			'name_admin_bar'        => __( 'Must Have Item', 'upfrontmama' ),
			'archives'              => __( 'Item Archives', 'upfrontmama' ),
			'attributes'            => __( 'Item Attributes', 'upfrontmama' ),
			'parent_item_colon'     => __( 'Parent Item:', 'upfrontmama' ),
			'all_items'             => __( 'All Items', 'upfrontmama' ),
			'add_new_item'          => __( 'Add New Item', 'upfrontmama' ),
			'add_new'               => __( 'Add New', 'upfrontmama' ),
			'new_item'              => __( 'New Item', 'upfrontmama' ),
			'edit_item'             => __( 'Edit Item', 'upfrontmama' ),
			'update_item'           => __( 'Update Item', 'upfrontmama' ),
			'view_item'             => __( 'View Item', 'upfrontmama' ),
			'view_items'            => __( 'View Items', 'upfrontmama' ),
			'search_items'          => __( 'Search Item', 'upfrontmama' ),
			'not_found'             => __( 'Not found', 'upfrontmama' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'upfrontmama' ),
			'featured_image'        => __( 'Featured Image', 'upfrontmama' ),
			'set_featured_image'    => __( 'Set featured image', 'upfrontmama' ),
			'remove_featured_image' => __( 'Remove featured image', 'upfrontmama' ),
			'use_featured_image'    => __( 'Use as featured image', 'upfrontmama' ),
			'insert_into_item'      => __( 'Insert into item', 'upfrontmama' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'upfrontmama' ),
			'items_list'            => __( 'Items list', 'upfrontmama' ),
			'items_list_navigation' => __( 'Items list navigation', 'upfrontmama' ),
			'filter_items_list'     => __( 'Filter items list', 'upfrontmama' ),
		);
		$args = array(
			'label'                 => __( 'Must Have Item', 'upfrontmama' ),
			'description'           => __( 'Must Have Item Description', 'upfrontmama' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'excerpt', 'thumbnail', 'page-attributes', ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'				=> 'dashicons-heart',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
			'show_in_rest'          => true,
		);
		
		register_post_type( $this->post_type_key, $args );
	
	}
	/**
	 * meta_boxes function.
	 * Uses the 'rwmb_meta_boxes' filter to add custom meta boxes to our custom post type.
	 * Requires the plugin "meta-box"
	 *
	 * @access public
	 * @param array $meta_boxes
	 * @return void
	 */
	function meta_boxes($meta_boxes) {
		$prefix = "ufm_loves_";
		$meta_boxes[] = array(
			"id" => "must_have_meta",
			"title" => "Meta",
			"post_types" => array($this->post_type_key),
			"context" => "normal",
			"priority" => "high",
			"autosave" => true,
			"fields" => array(
				array(
					"name" => __("URL", "upfront-mama"),
					"id" => "{$prefix}url",
					"type" => "url",
				)
			),
			
		);
		return $meta_boxes;
	}
	
}
new Plugin();