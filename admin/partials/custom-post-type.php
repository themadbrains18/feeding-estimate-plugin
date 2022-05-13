<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wppb.me/
 * @since      1.0.0
 *
 * @package    Hermescalculator
 * @subpackage Hermescalculator/admin/partials
 */


  

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Formula', 'Quiz Formula', 'themadbrains' ),
        'singular_name'       => _x( 'Formula', 'Quiz Formula', 'themadbrains' ),
        'menu_name'           => __( 'Quiz Formula', 'themadbrains' ),
        'parent_item_colon'   => __( 'Parent Formula', 'themadbrains' ),
        'all_items'           => __( 'All Formula', 'themadbrains' ),
        'view_item'           => __( 'View Formula', 'themadbrains' ),
        'add_new_item'        => __( 'Add New Formula', 'themadbrains' ),
        'add_new'             => __( 'Add New', 'themadbrains' ),
        'edit_item'           => __( 'Edit Formula', 'themadbrains' ),
        'update_item'         => __( 'Update Formula', 'themadbrains' ),
        'search_items'        => __( 'Search Formula', 'themadbrains' ),
        'not_found'           => __( 'Not Found', 'themadbrains' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'themadbrains' ),
    );
        
    // Set other options for Custom Post Type
        
    $args = array(
        'label'               => __( 'Formula', 'themadbrains' ),
        'description'         => __( 'Formula news and reviews', 'themadbrains' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
    
    );
        
    // Registering your Custom Post Type
    register_post_type( 'formula', $args );
      
      

    
   
?>
