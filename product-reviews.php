add_shortcode( 'product_reviews', 'f4d_product_reviews_shortcode' );
function f4d_product_reviews_shortcode( $atts ) {
	$comments = get_comments( 'number=15' );
	if ( ! $comments ) return '';
	ob_start();
	?>
	<div class="woocommerce">
		<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--reviews panel entry-content wc-tab" id="tab-reviews" role="tabpanel" aria-labelledby="tab-title-reviews" style="display: block;">
			<div id="reviews" class="woocommerce-Reviews">
				<div id="comments">
					<!-- <h2 class="woocommerce-Reviews-title">
						Meest recente reviews:
					</h2> -->
					<ol class="commentlist">
						<?php
						foreach ( $comments as $comment ) {  
							$productID = $comment->comment_post_ID;
							$productTitle = get_the_title($productID);
							$productPermalink = get_permalink($productID);
							echo '<a style="margin-left:77px;" href="' . $productPermalink . '" title="' . $productTitle . '">' . $productTitle . '</a>';
							woocommerce_comments( $comment, '', 0 );
						}
						?>
					</ol>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<?php
	$html = ob_get_clean();
	return $html;
}
