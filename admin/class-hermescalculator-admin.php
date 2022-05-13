<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wppb.me/
 * @since      1.0.0
 *
 * @package    Hermescalculator
 * @subpackage Hermescalculator/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Hermescalculator
 * @subpackage Hermescalculator/admin
 * @author     baljeet <baljeet.masih.755@gmail.com>
 */
class Hermescalculator_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		// add new hooks by TMB
		
		add_action( 'init', array($this,'create_formula_posttype'));
		/* Add meta boxes on the 'add_meta_boxes' hook. */
		add_action( 'add_meta_boxes', array($this,'tmb_add_post_meta_boxes'));

		/** save formula data */
		add_action( 'wp_ajax_save_formula', [$this,'tmb_save_formula']);
		add_action( 'wp_ajax_nopriv_save_formula', [$this,'tmb_save_formula']);

		/** save post data */
		add_action( 'save_post', [$this,'save_post_formula'],10,3);

	}
	
	function save_post_formula( $post_id ,$post, $update ) {

		if ( isset($_POST['post_type']) && 'formula' == $_POST['post_type'] ) :
			// Only set for post_type = post!
			if ( 'formula' !== $post->post_type ) {
				return;
			}
			
			$data = json_encode($_POST);
		    update_post_meta($post_id,'saved_formula',$data);
		endif;	
	}

	/**
	 * Creating formula custom post type 
	 */

	public function tmb_save_formula(){
		extract($_POST);
		// print_r($_POST);
		$urlData = ($draft != 'auto-draft') ? home_url().'/wp-admin/post.php?post='.$post_id.'&action=edit' : home_url().'/wp-admin/edit.php?post_type=formula';

		if(!$post_id) {
			// Create post object
			$postArgs = array(
				'post_title'    => wp_strip_all_tags( $post_title ),
				'post_content'  => $_POST['post_content'],
				'post_status'   => 'publish',
				'post_type'     => 'formula',
				'post_author'   => get_current_user_id(),
			);
			// Insert the post into the database
			$post_id = 	wp_insert_post( $postArgs );
			$update_post  = array(
				'ID' => $post_id,
				'post_status' => 'publish'
			);
			$dateTest = wp_update_post($update_post);
		} 

		wp_publish_post($post_id);
		$data = json_encode($data);

		update_post_meta($post_id,'saved_formula',$data);
		$return = array(
			'message'  => 'Saved',
			'ID'       => $post_id,
			'url'      => $urlData
		);
		wp_send_json($return);
		exit();
	}

	 /**
	  * create formula data
	  */
	public function create_formula_posttype(){
		include_once __DIR__.'/partials/custom-post-type.php';
	}

	/**
	* Add meta boxes under formula post type
	*/
	public function tmb_add_post_meta_boxes(){
		add_meta_box(
			'smashing-post-class',      // Unique ID
			esc_html__( 'HermesRaw Calculator', 'themadbrains' ),    // Title
			array($this,'smashing_post_class_meta_box'),   // Callback function
			'formula',         // Admin page (or post type)
			'normal',         // Context
			'high'         // Priority
		  );
	}

	/**
	*  Call to formula html interface   
	*/

	public function smashing_post_class_meta_box(){
		//  call to html file interface
		include_once __DIR__.'/partials/hermescalculator-admin-display.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hermescalculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hermescalculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/hermescalculator-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Hermescalculator_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Hermescalculator_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		
		wp_enqueue_script( $this->plugin_name.'-controller-js', plugin_dir_url( __FILE__ ) . 'js/main.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/hermescalculator-admin.js', array( 'jquery' ), $this->version, false );

		global $post;
		$data = [];
		if(get_post_meta($post->ID,'saved_formula') !=''){
			$saveData =  get_post_meta($post->ID,'saved_formula');
			$data = json_decode($saveData[0],true);
		}

		wp_localize_script($this->plugin_name.'-controller-js', 'formulaObj',
        array( 
            'ajaxurl'     => admin_url( 'admin-ajax.php' ),
            'post_data'   => $post,
            'savedFields' => $data
			
			)
		);
		
	}

}
