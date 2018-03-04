<?php
// Block none logged in users from visiting WC pages such as shop/categories/products etc. except My Account page
// For a full list of conditional tags that you can use with WooCommerce visit:
// https://docs.woocommerce.com/document/conditional-tags/
function f4d_redirect_none_logged_in_users() {
	if( ( (!is_user_logged_in()) && (is_woocommerce()) ) && (!is_account_page()) ) {
		wp_redirect( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
		exit;
	}
}
add_action( 'template_redirect', 'f4d_redirect_none_logged_in_users' );


// Filter to disable need for woocommerce payment
add_filter( 'woocommerce_cart_needs_payment', '__return_false' );


// Filter to alter payment gateways
add_filter( 'woocommerce_available_payment_gateways', 'f4d_unset_specific_payment_gateways' );


// Function to either disable all payment gateways for woocommerce or to unset a specific one
add_action('wp', 'f4d_alter_woocommerce_payment_gateways');
function f4d_alter_woocommerce_payment_gateways(){
	$post_id = get_the_ID();
	if($post_id==49){
		// Remove all methods except "Phone manual on hold" method
		add_filter( 'woocommerce_available_payment_gateways', 'f4d_unset_specific_payment_gateways' );
	}else{
		if( f4d_is_request('ajax') ) {

			// Because woocommerce does a ajax request to generates prices and payment methods
			// on the fly when items and address is changed, the $post_id is always 1 or 0.
			// So in order to still know on what page the request was made, we can retrieve the _wp_http_referer
			// parameter from the post_data parameter in the 'update_order_review' Ajax request made by WC
			
			// Note that you could also save the $post_id in a session each time the page was loaded
			// This way you can retrieve this session value during the Ajax request to still
			// determine on what page the Ajax request was made 
			parse_str($_POST['post_data'], $output);
			if( basename( $output['_wp_http_referer'] ) == 'orderbevestiging' ){
				// Remove all methods except "Phone manual on hold" method
				add_filter( 'woocommerce_available_payment_gateways', 'f4d_unset_specific_payment_gateways' );
			}else{
				// Disable need for payment
				add_filter( 'woocommerce_cart_needs_payment', '__return_false' );
			}
		}else{
			// Disable need for payment
			add_filter( 'woocommerce_cart_needs_payment', '__return_false' );
		}
	}
}
function f4d_unset_specific_payment_gateways( $available_gateways ) {
	foreach($available_gateways as $k => $v){
		if($k!='phone_manual_on_hold'){
			unset($available_gateways[$k]);
		}
	}
	return $available_gateways;
}

// Function to check what the current request type was
// admin, ajax, cron or frontend
function f4d_is_request($type){
	switch ($type){
		case 'admin' :
			return is_admin();
		case 'ajax' :
			return defined( 'DOING_AJAX' );
		case 'cron' :
			return defined( 'DOING_CRON' );
		case 'frontend' :
			return (!is_admin() || defined('DOING_AJAX')) && ! defined('DOING_CRON');
	}
}
