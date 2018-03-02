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
