<?php

/**
 * @desc The core integration with WordPress.
 * @author Ahmed Hussein me@ahmedgeek.com
 */

class paceProCore{

	public static $pace_pro_options, $pace_pro_styles;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct(){
		self::loadOptions();
		return $this;
	}


	/**
	 * install function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	static function install() {
		add_option("pace_pro_global_options");
	}
	
	
	/**
	 * hex2rgb function.
	 * 
	 * @access public
	 * @param mixed $hex
	 * @return void
	 */
	public function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		$rgb = array($r, $g, $b);

		return implode(",", $rgb); // returns the rgb values separated by commas
	}

	/**
	 * loadOptions function.
	 *
	 * @access public
	 * @return object
	 */
	public static function loadOptions(){
		self::$pace_pro_options = (array) json_decode(get_option("pace_pro_global_options", true));
		return $this;
	}


	/**
	 * defineStyles function.
	 *
	 * @access public
	 * @return object
	 */
	public static function defineStyles(){

		self::$pace_pro_styles = array(

			"barber_shop"      => "Barber Shop",
			"big_counter"      => "Big Counter",
			"bounce"           => "Bounce",
			"center_circle"    => "Center Circle",
			"center_radar"     => "Center Radar",
			"corner_indicator" => "Corner Indicator",
			"fill_left"        => "Fill Left",
			"flash"            => "Flash",
			"flat_top"         => "Flat Top",
			"loading_bar"      => "Loading Bar",
			"minimal"          => "Minimal"

		);;

		return $this;
	}


	/**
	 * updateOptions function.
	 *
	 * @access public
	 * @static
	 * @param mixed $options
	 * @return void
	 */
	public static function updateOptions($options){
		//Unset unwanted options
		unset($options[0]["_wpnonce"]);
		unset($options[0]["pace_pro_save"]);


		//form the options object or load it
		self::$pace_pro_options = (empty(self::$pace_pro_options) === TRUE ? array() : self::$pace_pro_options);

		//update the options and add new ones
		foreach($options as $key => $opt){
			self::$pace_pro_options[$key] = $opt;
		}

		update_option("pace_pro_global_options", json_encode(self::$pace_pro_options));
		return $this;
	}


	/**
	 * getStyleName function.
	 *
	 * @access public
	 * @static
	 * @param mixed $style
	 * @return void
	 */
	public static function getStyleName($style){
		self::defineStyles();
		return self::$pace_pro_styles[$style];
	}


	/**
	 * siteWideHead function.
	 *
	 * @access public
	 * @return void
	 * @description adds the PACE to your site if the site wide option is activated
	 */
	public function siteWideHead(){
		if(self::$pace_pro_options[0]->pace_pro_global_active == "on"){
			
			//Load css file for the selected style and replace the color place holders
			$cssFile = file_get_contents(plugin_dir_url(__FILE__).'misc/css/'.self::$pace_pro_options[0]->pace_pro_global_style.'.css');
			$cssFile = str_replace("%backgroundColor%", self::hex2rgb(self::$pace_pro_options[0]->pace_pro_global_color), $cssFile);
			
			//add margin for the logged in user.
			if ( is_user_logged_in() && is_admin_bar_showing() && self::$pace_pro_options[0]->pace_pro_global_style != "center_radar" && self::$pace_pro_options[0]->pace_pro_global_style != "corner_indicator") { $loggedin = '.pace .pace-progress {margin-top: 28px}'; }else{ $loggedin = ''; }
			
			echo "<style>";
			echo $loggedin;
			echo $cssFile;
			echo "</style>";
			
			wp_enqueue_script('pace_site_scripts', plugin_dir_url(__FILE__).'misc/js/pace.min.js');
		}
	}

}

?>