
add_shortcode( 'gallery', 'f4d_modified_gallery_shortcode' );
function f4d_modified_gallery_shortcode($attr) {
	$html = '<div class="owl-carousel f4d-carousel-lightbox">';
	$images = explode(',', $attr['ids']);
	foreach($images as $k => $v){
		// thumbnail, medium, large or full
		$full = wp_get_attachment_image_src( $v, 'full' );
		$medium = wp_get_attachment_image_src( $v, 'medium' );
	    $html .= '<a class="item" href="' . $full[0] . '" data-caption="">';
	        $html .= '<img src="' . $medium[0] . '" alt="">';
	    $html .= '</a>';
	}
	$html .= '</div>';
    static $js_loaded; // only create once
    if( empty ( $js_loaded )) {
        ob_start();
        ?> 
        <style>
			.f4d-carousel-lightbox {
				height:auto;
			}
			.f4d-carousel-lightbox .item{
				margin: 3px;
			}
			.f4d-carousel-lightbox .item img{
				display: block;
				width: 100%;
				height: auto;
			}
			.f4d-carousel-lightbox .owl-nav {
				position:absolute;
				left:0px;
				top:0px;
				width:100%;
				height:100%;
				z-index:-1;
			}
			.f4d-carousel-lightbox .owl-nav .owl-prev,
			.f4d-carousel-lightbox .owl-nav .owl-next { 
				width:40px;
				height:60px;
				position:absolute;
				left:-40px;
				top:50%;
				color:red;
				margin-top:-30px;
			}
			.f4d-carousel-lightbox .owl-nav .owl-next {
				left:initial!important;
				right:-40px;
			}
			.f4d-carousel-lightbox .owl-nav .owl-prev svg,
			.f4d-carousel-lightbox .owl-nav .owl-next svg {
				height:100%;
				width:100%;
			}
			.f4d-carousel-lightbox .owl-nav .owl-next svg {
				-moz-transform: scaleX(-1);
				-o-transform: scaleX(-1);
				-webkit-transform: scaleX(-1);
				transform: scaleX(-1);
				filter: FlipH;
				-ms-filter: "FlipH"; 
			}
			.f4d-carousel-lightbox .owl-nav .owl-prev polyline,
			.f4d-carousel-lightbox .owl-nav .owl-next polyline {
				stroke: red;
			}
        </style>
        <script defer src="<?php echo get_template_directory_uri(); ?>/assets/js/baguetteBox.min.js"></script>
        <script defer src="<?php echo get_template_directory_uri(); ?>/assets/js/owl.carousel.min.js"></script>
        <script>
            jQuery('head').append('<link defer id="baguetteBox-css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/baguetteBox.min.css" type="text/css" />');
            jQuery('head').append('<link defer id="owl-carousel-css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.carousel.min.css" type="text/css" />');
            jQuery('head').append('<link defer id="owl-theme-css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.theme.default.min.css" type="text/css" />');
            jQuery(document).ready(function () {
            	baguetteBox.run('.owl-carousel');
			    // SVG shapes used on the buttons
			    var leftArrow = '<svg width="40" height="60">' +
			            '<polyline points="30 10 10 30 30 50" stroke="rgba(255,255,255,0.5)" stroke-width="4"' +
			              'stroke-linecap="butt" fill="none" stroke-linejoin="round"/>' +
			            '</svg>',
			        rightArrow = leftArrow,
			        closeX = '<svg width="30" height="30">' +
			            '<g stroke="rgb(160,160,160)" stroke-width="4">' +
			            '<line x1="5" y1="5" x2="25" y2="25"/>' +
			            '<line x1="5" y1="25" x2="25" y2="5"/>' +
			            '</g></svg>';
                // pulling example from -- including CSS
                // http://owlgraphic.com/owlcarousel/demos/images.html
                // notice I replaced #id with .class for when you want to have more than one on a page
				jQuery(".owl-carousel").owlCarousel({
					items: 3,
					//loop: true,
					center: false,
					rewind: true,
					checkVisibility: true,
					mouseDrag: true,
					touchDrag: true,
					pullDrag: true,
					freeDrag: false,
					margin: 0,
					stagePadding: 0,
					merge: false,
					mergeFit: true,
					autoWidth: false,
					startPosition: 0,
					rtl: false,
					smartSpeed: 250,
					fluidSpeed: false,
					dragEndSpeed: false,

					responsiveClass:true,
					responsive: {},
					/*
					responsive : {
					    // breakpoint from 0 up
					    0 : {
					        option1 : value,
					        option2 : value,
					        ...
					    },
					    // breakpoint from 480 up
					    480 : {
					        option1 : value,
					        option2 : value,
					        ...
					    },
					    // breakpoint from 768 up
					    768 : {
					        option1 : value,
					        option2 : value,
					        ...
					    }
					}
					*/

					responsiveRefreshRate: 200,
					responsiveBaseElement: window,
					fallbackEasing: 'swing',
					slideTransition: '',
					info: false,
					nestedItemSelector: false,
					itemElement: 'div',
					stageElement: 'div',
					refreshClass: 'owl-refresh',
					loadedClass: 'owl-loaded',
					loadingClass: 'owl-loading',
					rtlClass: 'owl-rtl',
					responsiveClass: 'owl-responsive',
					dragClass: 'owl-drag',
					itemClass: 'owl-item',
					stageClass: 'owl-stage',
					stageOuterClass: 'owl-stage-outer',
					grabClass: 'owl-grab',

                	URLhashListener: false,
                	nav: true,
                	navText: [leftArrow,rightArrow],
                	navElement: 'div',
                	slideBy: 1,
                	dots: false,
                	dotsEach: false,
                	dotsData: false,
                	lazyLoad: false,
                	lazyLoadEager: 0,
                	autoplay: true,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: true,
                    fluidSpeed: false,
                    autoplaySpeed: false,
                    navSpeed: false,
                    dotsSpeed: false,
                    callbacks: true,
                    video: false,
                    videoHeight: false,
                    videoWidth: false,
                    animateOut: false,
                    animateIn: false,
                    navContainer: false,
                    dotsContainer: false,
                    checkVisible: true,
                    itemsDesktop: [1199, 1],
                    itemsDesktopSmall: [979, 1] // adaptive image count
                });
            });
        </script>
        <?php
        $js_loaded = ob_get_clean(); // store in static var
        $html .= $js_loaded;
    }
	return $html;
}
