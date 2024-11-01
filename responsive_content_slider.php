<?php
/*
 * Plugin Name: Dc Responsive Content slider
 * Plugin URL: 
 * Text Domain: responsive-content-slider
 * Domain Path: /languages/
 * Description: A simple Responsive content slider.
 * Version: 1.0.0
 * Author: Deepak Chattha 
 * Author URI:  
*/
if( !defined( 'SP_DCRCS_VERSION' ) ) {
	define( 'SP_DCRCS_VERSION', '1.0.3' ); // Version of plugin
}
if( !defined( 'SP_DCRCS_DIR' ) ) {
	define( 'SP_DCRCS_DIR', dirname( __FILE__ ) );	// Plugin dir
}

add_action('plugins_loaded', 'responsive_content_slider_load_textdomain');
function responsive_content_slider_load_textdomain() {
	load_plugin_textdomain( 'responsive-content-slider', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

/**
 * Function to unique number value
 * 
 * @package Dc Responsive Content Slider
 * @since 1.0.0
 */
function responsive_content_slider_get_unique() {
	static $unique = 0;
	$unique++;

	return $unique;
}

function responsive_content_slider_setup_post_types() {

	$responsiveslider_labels =  apply_filters( 'sp_dcrs_slider_labels', array(
		'name'                => 'Dc Responsive content slider',
		'singular_name'       => 'Dc Responsive content slider',
		'add_new'             => __('Add New', 'responsive-content-slider'),
		'add_new_item'        => __('Add New Image', 'responsive-content-slider'),
		'edit_item'           => __('Edit Image', 'responsive-content-slider'),
		'new_item'            => __('New Image', 'responsive-content-slider'),
		'all_items'           => __('All Image', 'responsive-content-slider'),
		'view_item'           => __('View Image', 'responsive-content-slider'),
		'search_items'        => __('Search Image', 'responsive-content-slider'),
		'not_found'           => __('No Image found', 'responsive-content-slider'),
		'not_found_in_trash'  => __('No Image found in Trash', 'responsive-content-slider'),
		'parent_item_colon'   => '',
		'menu_name'           => __('Dc Responsive content slider'),
		'exclude_from_search' => true
	) );


	$responsiveslider_args = array(
		'labels' 			=> $responsiveslider_labels,
		'public' 			=> true,
		'publicly_queryable'		=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'query_var' 		=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> true,
		'hierarchical' 		=> false,
		'menu_icon'   => 'dashicons-format-gallery',
		'supports' => array('title','editor','thumbnail')
		
	);
	register_post_type( 'sp_dcrs_slider', apply_filters( 'sp_faq_post_type_args', $responsiveslider_args ) );

}
add_action('init', 'responsive_content_slider_setup_post_types');

/*function responsive_content_slider_setup_post_types() {

	$responsiveslider_labels =  apply_filters( 'responsive_content_slider_labels', array(
		'name'                => 'Dc Responsive content slider',
		'singular_name'       => 'Dc Responsive content slider',
		'add_new'             => __('Add New', 'responsive-content-slider'),
		'add_new_item'        => __('Add New Image', 'responsive-content-slider'),
		'edit_item'           => __('Edit Image', 'responsive-content-slider'),
		'new_item'            => __('New Image', 'responsive-content-slider'),
		'all_items'           => __('All Image', 'responsive-content-slider'),
		'view_item'           => __('View Image', 'responsive-content-slider'),
		'search_items'        => __('Search Image', 'responsive-content-slider'),
		'not_found'           => __('No Image found', 'responsive-content-slider'),
		'not_found_in_trash'  => __('No Image found in Trash', 'responsive-content-slider'),
		'parent_item_colon'   => '',
		'menu_name'           => __('Dc Responsive content slider'),
		'exclude_from_search' => true
	) );


	$responsiveslider_args = array(
		'labels' 			=> $responsiveslider_labels,
		'public' 			=> true,
		'publicly_queryable'		=> true,
		'show_ui' 			=> true,
		'show_in_menu' 		=> true,
		'query_var' 		=> true,
		'capability_type' 	=> 'post',
		'has_archive' 		=> true,
		'hierarchical' 		=> false,
		'menu_icon'   => 'dashicons-format-gallery',
		'supports' => array('title','editor','thumbnail')
		
	);
	register_post_type( 'responsive_content_slider', apply_filters( 'sp_faq_post_type_args', $responsiveslider_args ) );

}
add_action('init', 'responsive_content_slider_setup_post_types');*/

/* Include style and script */
add_action( 'wp_enqueue_scripts','style_rsris_css_script' );
function style_rsris_css_script() {
    wp_enqueue_style( 'dcrscss',  plugin_dir_url( __FILE__ ). 'css/dcrs.css', array(), SP_DCRCS_VERSION );
    wp_enqueue_script( 'dcrsjs', plugin_dir_url( __FILE__ ) . 'js/jquery.slides.min.js', array('jquery'), SP_DCRCS_VERSION );
}

function responsive_content_slider_rewrite_flush() {  
		responsive_content_slider_setup_post_types();
    flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'responsive_content_slider_rewrite_flush' );

function rsris_save_meta_box_data( $post_id ) {
	if ( ! isset( $_POST['rsris_meta_box_nonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( $_POST['rsris_meta_box_nonce'], 'rsris_save_meta_box_data' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( isset( $_POST['post_type'] ) && 'responsive_content_slider' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	if ( ! isset( $_POST['rsris_slide_link'] ) ) {
		return;
	}
	$link_data = sanitize_text_field( $_POST['rsris_slide_link'] );
	update_post_meta( $post_id, 'rsris_slide_link', $link_data );
}
add_action( 'save_post', 'rsris_save_meta_box_data' );
/*
 * Add [responsive_content_slider] shortcode
 *
 */
function responsive_content_slider_shortcode( $atts, $content = null ) {
	
	extract(shortcode_atts(array(
		"limit"  => '',
		"cat_id" => '',
		"design" => '',
		"effect" => '',
		"pagination" => '',
		"navigation" => '',
		"speed" => '',
		"autoplay" => '',
		"autoplay_interval" => '',
		"height" => '',
		"width" => '',
		"first_slide" => '',
	), $atts));
	
	if( $limit ) { 
		$posts_per_page = $limit; 
	} else {
		$posts_per_page = '-1';
	}
	
	$slidercdesign = 'design-2';
	$effectslider = 'slide';
	$widthslider = '1024';
	$heightslider = '350';
	$paginationslider = 'true';
	$navigationslider = 'true';
	$speedslider = '3000';
	$autoplayslider = 'true';
	$autoplay_intervalslider = '3000';
	$first_slideslider = '1';

	ob_start();

	// get defaults
	$unique = responsive_content_slider_get_unique();

	// Create the Query
	$post_type 		= 'sp_dcrs_slider';
	$orderby 		= 'post_date';
	$order 			= 'DESC';
				
	 $args = array ( 
            'post_type'      => $post_type, 
            'orderby'        => $orderby, 
            'order'          => $order,
            'posts_per_page' => $posts_per_page,  
           
            );
	       
    $query = new WP_Query($args);
	$post_count = $query->post_count;
	$i = 1;
	if( $post_count > 0) :
	?>
	  <div id="slides" class="<?php echo $slidercdesign; ?> responsive-content-slider-<?php echo $unique; ?>">
	<?php	
		// Loop 
		while ($query->have_posts()) : $query->the_post();
		?>
		
			<div class="slide-image">
	
				<?php the_post_thumbnail('url'); ?>	
				<div class="slider-content">
					<h1 class="slide-title"><?php the_title(); ?></h1>
					
						<div class="slider-short-content">
							<?php the_content(); ?>			
						</div>
					<?php  
					
					$sliderurl = get_post_meta( get_the_ID(),'rsris_slide_link', true );
						if($sliderurl != '') { ?>
					<div class="readmore"><a href="<?php echo $sliderurl; ?>" class="slider-readmore"><?php esc_html_e( 'Read More', 'responsive-content-slider' ); ?></a></div>
						<?php } ?>
					</div>
	

			</div>
		<?php
		
		
		$i++;
		endwhile; ?>
		</div>
		
<?php	else : ?>
 <div id="slides" class="design-1 responsive-content-slider-<?php echo $unique; ?>">
	 	<img src="<?php echo  plugin_dir_url( __FILE__ ); ?>/img/1.jpg"  alt="">
</div>
	<?php
	endif;
	// Reset query to prevent conflicts
	wp_reset_query();
	?>
	<script type="text/javascript">
	
	 jQuery(function() {
	
      jQuery('.responsive-content-slider-<?php echo $unique; ?>').slidesjs({
		width: <?php echo $widthslider; ?>,
        height: <?php echo $heightslider; ?>,
		start: <?php echo $first_slideslider; ?>,	
        play: {
          active: <?php echo $autoplayslider; ?>,
          auto: <?php if($autoplayslider == "false") { echo 'false';} else { echo 'true'; } ?>,
          interval: <?php echo $autoplay_intervalslider; ?>,
          swap: true,
		  effect: "<?php echo $effectslider; ?>"
        },
     
	 effect: {
      slide: {        
        speed: <?php echo $speedslider; ?>           
      },
      fade: {
        speed: <?php echo $speedslider; ?>,         
        crossfade: true          
      }
    },
	navigation: {
     active: <?php echo $navigationslider; ?>,
	  effect: "<?php echo $effectslider; ?>"
	  },
        
	pagination: {
      active: <?php echo $paginationslider; ?>,
	   effect: "<?php echo $effectslider; ?>"
	  
    }

      });
	  
	
    });
	

	</script>
	
	<?php
	return ob_get_clean();
}
add_shortcode("dc_responsive_content_slider", "responsive_content_slider_shortcode");

// Load admin side files
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {   
    // Designs file
    include_once( SP_DCRCS_DIR . '/dc-how-it-work.php' );
}