<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package Dc Responsive content slider
 * @since 1.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Action to add menu
add_action('admin_menu', 'responsive_content_slider_register_design_page');

/**
 * Register plugin design page in admin menu
 * 
 * @package Dc Responsive content slider
 * @since 1.1
 */
function responsive_content_slider_register_design_page() {
	add_submenu_page( 'edit.php?post_type=sp_dcrs_slider', __('How it works - Dc Responsive content slider', 'responsive-content-slider'), __('How It Works', 'responsive-content-slider'), 'manage_options', 'dc-how-it-works', 'responsive_content_slider_designs_page' );
}

/**
 * Function to display plugin design HTML
 * 
 * @package Dc Responsive content slider
 * @since 1.1
 */
function responsive_content_slider_designs_page() {

	//$wpos_feed_tabs = dcrs_help_tabs();
	$active_tab 	= isset($_GET['tab']) ? $_GET['tab'] : 'how-it-work';
?>
		
	<div class="wrap spfaq-wrap">

		<div class="spfaq-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'how-it-work' ) {
				responsive_content_slider_howitwork_page();
			}
		?>
		</div>

	</div>

<?php
}

/**
 * Function to get 'How It Works' HTML
 *
 * @package Dc Responsive content slider
 * @since 1.1
 */
function responsive_content_slider_howitwork_page() { ?>
	
	<style type="text/css">
		.wpos-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.wpos-pro-box .postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.postbox-container .wpos-list li:before{font-family: dashicons; content: "\f139"; font-size:20px; color: #0073aa; vertical-align: middle;}
		.spfaq-wrap .wpos-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.spfaq-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
	</style>

	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
			
				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="metabox-holder">
						<div class="meta-box-sortables ui-sortable">
							<div class="postbox">
								
								<h3 class="hndle">
									<span><?php _e( 'How It Works - Display and shortcode', 'responsive-content-slider' ); ?></span>
								</h3>
								
								<div class="inside">
									<table class="form-table">
										<tbody>
											<tr>
												<th>
													<label><?php _e('Getting Started with Dc Responsive Content Slider', 'responsive-content-slider'); ?>:</label>
												</th>
												<td>
													<ul>														
														<li><?php _e('Step-1. Go to "Dc Responsive Content Slider --> Add New".', 'responsive-content-slider'); ?></li>
														<li><?php _e('Step-2. Add Title, Description, and featured image', 'responsive-content-slider'); ?></li>														
													</ul>
												</td>
											</tr>

											<tr>
												<th>
													<label><?php _e('How Shortcode Works', 'responsive-content-slider'); ?>:</label>
												</th>
												<td>
													<ul>														
														<li><?php _e('Step-1. Create a page to use Slider and add the shortcode.', 'responsive-content-slider'); ?></li>
														<li><?php _e('Step-2. Put below shortcode as per your need.', 'responsive-content-slider'); ?></li>
													</ul>
												</td>
											</tr>

											<tr>
												<th>
													<label><?php _e('Slider Shortcode', 'responsive-content-slider'); ?>:</label>
												</th>
												<td>
													<span class="spfaq-shortcode-preview">[dc_responsive_content_slider]</span> – <?php _e('Display slideshow in Page', 'responsive-content-slider'); ?>
												</td>
											</tr>

											
										</tbody>
									</table>
								</div><!-- .inside -->
							</div><!-- #general -->
						</div><!-- .meta-box-sortables ui-sortable -->
					</div><!-- .metabox-holder -->
				</div><!-- #post-body-content -->

			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div><!-- #post-box-container -->
<?php }