<?php
/**
 * GeneratePress child theme functions and definitions.
 *
 * Add your custom PHP in this file.
 * Only edit this file if you have direct access to it on your server (to fix errors if they happen).
 */
include 'ctp-configurations.php';

 // Hide default page title
 add_filter( 'generate_show_entry_header', function( $show ) {
     if ( is_page() ) {
         $show = false;
     }
     return $show;
 } );

 function site_files(){
      wp_enqueue_script( 'jquery' );
      wp_enqueue_script( 'customJS', get_stylesheet_directory_uri() . '/js-child/custom-js.js', array(), '1.0.0', true );
    }
    add_action('wp_enqueue_scripts', 'site_files' );

 /***************CUSTOM BULK ACTION*********************************/
/*https://www.shibashake.com/wp/how-to-get-the-wordpress-screen-id-of-a-page
  https://make.wordpress.org/core/2016/10/04/custom-bulk-actions/
*/
/**
 * 
 *  REGISTER THE ACTIONS
 * 
 */
add_filter( 'bulk_actions-edit-private-area', 'register_my_bulk_actions' );
 
function register_my_bulk_actions($bulk_actions) {
  $bulk_actions['status_to_done'] = __( 'Status auf done setzen', 'status_to_done');
  return $bulk_actions;
}



/**
 * 
 *  HANDLE THE ACTIONS
 * 
 */
add_filter( 'handle_bulk_actions-edit-private-area', 'my_bulk_action_handler', 10, 3 );
 
function my_bulk_action_handler( $redirect_to, $doaction, $post_ids ) {
  if ( $doaction !== 'status_to_done' ) {
    return $redirect_to;
  }
  foreach ( $post_ids as $post_id ) {
    $post = get_post( $post_id ); 
    $terms = get_the_terms($post_id,'private_status');

    
    wp_set_object_terms( $post_id, 'done', 'private_status' ); 

  }
  $redirect_to = add_query_arg( 'bulk_status_done', count( $post_ids ), $redirect_to ); 
  /* wp_set_post_terms -> NATIVE POST TYPES*/

  return $redirect_to;
}


/**
 * 
 *  BRING UP NOTICE
 * 
 */
add_action( 'admin_notices', 'my_bulk_action_admin_notice' );
 
function my_bulk_action_admin_notice() {
  if ( ! empty( $_REQUEST['bulk_status_done'] ) ) {
    $emailed_count = intval( $_REQUEST['bulk_status_done'] );
    printf( '<div id="message" class="updated fade">' .
      _n( '%s Beiträge wurden auf Done gesetzt',
        '%s Beiträge wurden auf Done gesetzt',
        $emailed_count,
        'status_to_done'
      ) . '</div>', $emailed_count );
  }
}