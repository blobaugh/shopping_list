<?php
/*
Plugin Name: Shopping List
Plugin URI: http://github.com/blobaugh/shopping_list
Description: Shopping List with a shortcode and js sorting
Version: 0.6
Author: Ben Lobaugh
Author URI: http://ben.lobaugh.net
*/

require_once( 'CMB2/init.php' );

class Shopping_List_CPT {

	/**
	 * Programattic name for post type
	 *
	 * @var string
	 **/
	private $post_type = 'shopping_list';

	/**
	 * Programmatic name for taxonomy
	 *
	 * @var string
	 **/
	private $post_taxonomy = 'shopping_list_tax';

	/**
	 * Taxonomy args
	 *
	 * @var array
	 **/
	private $tax_args = array(
				'name'			=> 'Category',
				'hierarchical'	=> true
	);

	/**
	 * Labels for the CP
	 *
	 * @var array
	 **/
	private $labels = array(
				'name'			=> 'Shopping List',
				'show_in_menu'	=> true,
				'menu_position'	=> '25'
	);

	/**
	 * Arguments for registering post type
	 *
	 * @var array
	 **/
	private $args = array(
				'public'		=> true,
				'supports'		=> array( 'title' ),

	);
	
	public function __construct() {
		$this->args['labels'] = $this->labels;
	}

	/**
	 * Registers the CPT and Taxonomy
	 **/
	public function register() {
		register_post_type( $this->post_type, $this->args );
		register_taxonomy( $this->post_taxonomy, $this->post_type, $this->tax_args );
	}

	/**
	 * Setup the metabox fields
	 **/
	public function cmb2_init() {
		
		/*
		 * Instantiate the metabox
		 */
		$cmb = new_cmb2_box( array(
			'id'			=> 'link',
			'title'			=> __( 'Details' ),
			'object_types'	=> array( $this->post_type ),
			'context'		=> 'normal',
			'priority'		=> 'high',
			'show_names'	=> true,
		));

		$cmb->add_field( array(
			'name'			=> __( 'URL' ),
			'desc'			=> __( 'URL to point the link to' ),
			'id'			=> 'link_url',
			'type'			=> 'text_url',
		) );

		$cmb->add_field( array(
			'name'			=> __( 'Credit' ),
			'desc'			=> __( 'Who purchased this' ),
			'id'			=> 'link_credit',
			'type'			=> 'text',
		) );
	}

	public function add_shortcode() {
		/*
		 * Enqueue the magical js sorting functionality
		 */
		wp_enqueue_script( 'mixitup', 'http://cdn.jsdelivr.net/jquery.mixitup/latest/jquery.mixitup.min.js?v=2.1.2', array( 'jquery' ) );
		
		/*
		 * Get all of the shopping list items.
		 * All statuses.
		 * Use this for now until there are so many that it slows
		 * the system down. Then we can switch to only non-purchased items
		 */
		$args = array(
			'post_type'			=> $this->post_type,
			'post_status'		=> array( 'pending', 'publish' ),
			'posts_per_page'	=> -1,
			// Performance optimization
			'no_found_rows'		=> true,
		);

		$query = new WP_Query( $args );

		if( $query->have_posts() ) {
			/*
			 * Get a listing of all of the taxonomy terms
			 */
			$terms = get_terms( $this->post_taxonomy, array( 'hide_empty' => 0 ) );

			require_once( 'views/controls.php' );
			require_once( 'views/items.php' );
		} else {
			echo '<p>No shopping list items found.</p>';
		}

		wp_reset_postdata();
	}
} // end class

$shopping_list = new Shopping_List_CPT();

add_action( 'init', function() {
	global $shopping_list;

	$shopping_list->register();
});

add_action( 'cmb2_init', function() {
	global $shopping_list;

	$shopping_list->cmb2_init();
});

add_action( 'init', function() {
	global $shopping_list;

	add_shortcode( 'shopping_list', array( $shopping_list, 'add_shortcode' ) );
});
