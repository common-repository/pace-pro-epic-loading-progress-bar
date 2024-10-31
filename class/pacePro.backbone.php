<?php
	
/** 
  * @desc The project backbone.
  * @author Ahmed Hussein me@ahmedgeek.com
*/

require_once("pacePro.admin.php");

class pacePro extends paceProAdmin{
	
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct(){
		
		self::loadOptions();
		self::defineStyles();
		
		add_action('admin_init', array(&$this, 'loadOptions'));
		add_action('admin_menu', array(__CLASS__, "menus"));
		if(is_admin()){
			add_filter('admin_enqueue_scripts', array(__CLASS__, "adminHeadFiles"));
		}else{
			add_filter('wp_enqueue_scripts', array(__CLASS__, "siteWideHead"));
		}
		register_activation_hook( __FILE__, array("paceProCore", 'install'));
	}
	
	
	
}
	
?>