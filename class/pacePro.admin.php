<?php

/**
 * @desc The admin panel class.
 * @author Ahmed Hussein me@ahmedgeek.com
 */

require_once("pacePro.core.php");

class paceProAdmin extends paceProCore{


	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct(){
		paceProCore::loadOptions();
		paceProCore::defineStyles();
	}


	/**
	 * menus function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function menus(){
		add_submenu_page("themes.php", "PACE Pro", "PACE Pro", 8, basename(__file__), array(__CLASS__, 'menuPageLayout'));
	}


	/**
	 * menuPageLayout function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function menuPageLayout(){
		include(sprintf("misc/pacePro.admin.layout.php", dirname(__FILE__)));
	}


	/**
	 * adminHeadFiles function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function adminHeadFiles(){

		if(is_admin()){
			wp_enqueue_style( 'pace_color_picker', plugin_dir_url(__FILE__).'misc/css/colorpicker.css');
			wp_enqueue_script('pace_admin_scripts', plugin_dir_url(__FILE__).'misc/js/colorpicker.js', array('jquery'));
			//wp_enqueue_script('pace_admin_scripts', plugin_dir_url(__FILE__).'misc/js/pace.min.js', array('jquery'));
			wp_enqueue_script('pace_admin_live_preview', plugin_dir_url(__FILE__).'misc/js/live.preview.js', array('jquery'));
		}
	}

	
	/**
	 * pagePostMetaBox function.
	 * 
	 * @access public
	 * @return void
	 */
	public function pagePostMetaBox() {

		$screens = array( 'post', 'page' );

		foreach ( $screens as $screen ) {

			add_meta_box(
				'pace_pro_custom_settings',
				__( 'PACE Pro Settings', 'pace_pro' ),
				array(__CLASS__, "metaBoxContent"),
				$screen, "side"
			);
		}
	}
	
	
	/**
	 * metaBoxContent function.
	 * 
	 * @access public
	 * @return void
	 */
	public function metaBoxContent(){
		?>
		
		<div class="misc-publishing-actions">
			<div class="misc-pub-section">
				<label>Current Color: #<?php echo paceProCore::$pace_pro_options[0]->pace_pro_global_color; ?></label>
			</div>
								
			<div class="misc-pub-section">
				<label>Current Style: <?php echo paceProCore::getStyleName(paceProCore::$pace_pro_options[0]->pace_pro_global_style); ?></label>
			</div>
		</div>

		<?php
	}

}

?>