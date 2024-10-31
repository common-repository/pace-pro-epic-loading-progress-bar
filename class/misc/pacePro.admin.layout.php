<?php

	if(isset($_POST["pace_pro_save"])){	
	
		if(wp_verify_nonce( $_POST["_wpnonce"],  "pace_pro_save_settings")){
			$options = array($_POST);
			paceProCore::updateOptions($options);
		}
	}
	
	$styles = paceProCore::$pace_pro_styles;
	paceProCore::loadOptions();

	
?>


<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ); ?>js/colorpicker.js"></script>
<script type="text/javascript" src="<?php echo plugin_dir_url( __FILE__ ); ?>js/live.preview.js"></script>
<style>
	
.browser {
	background: #e0e0e0;
	border: 4px solid #e0e0e0;
	width: 100%;
	height: 100%;
	padding-top: 20px;
	margin: 0 0 10px;
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
.browser iframe {
	border: 0;
	background: #fff;
	height: 100%;
	width: 100%;
}
	
</style>

<?php

	$nonce = wp_create_nonce( 'pace_pro_save_settings' );

?>

<div class="wrap">
	<div id='icon-tools' class="icon32"></div><h2><?php _e('PACE Pro Settings', 'pacePro') ?></h2>
	<form action="" method='post'>
	<input type="hidden" name="_wpnonce" value="<?php echo $nonce; ?>" />
		<div id="poststuff">
		    <!-- #post-body .metabox-holder goes here -->
		    <div id="post-body" class="metabox-holder columns-<?php echo 1 == get_current_screen()->get_columns() ? '1' : '2'; ?>">
			    <!-- meta box containers here -->
			    <div id="post-body-content">
				    <div class="postbox">
						<h3 class="hndle"><span>PACE Options</span></h3>
						<div class="inside">
							<table>
								<tr>
									<td><label for="style">Progress Bar Style:</label> </td>
									<td>
										<select id="pace_pro_global_style" name="pace_pro_global_style">
										<?php
										foreach($styles as $key => $style){
											echo "<option data-theme='".plugin_dir_url(__FILE__).'/css/' . $key . ".css" ."' value='".$key."' ".(paceProCore::$pace_pro_options[0]->pace_pro_global_style == $key ? 'selected' : '') ." >".$style."</option>";
										}
									?>
									   </select>
									</td>
								</tr>
								<tr>
									<td><label for="style">Progress Bar Color:</label></td>
									<td><input class="my-color-field" name="pace_pro_global_color" style="text-shadow: 1px 1px 0px #FFF;" type="text" id="colorpickerField" value="<?php echo paceProCore::$pace_pro_options[0]->pace_pro_global_color; ?>" /></td>
								</tr>
								<tr>
									<td><label for="active">Activate Site Wide:</label></td>
									<td><input type="checkbox" name="pace_pro_global_active" <?php echo (paceProCore::$pace_pro_options[0]->pace_pro_global_active == "" ? "" : "checked"); ?>/></td>
								</tr>
							</table>
						</div>
				    </div>
				</div>

				
				<div id="postbox-container-1" class="postbox-container">
				    <div class="postbox">
						<h3 class="hndle"><span>Save Settings</span></h3>
						<div class="inside">
							<div class="misc-publishing-actions">
								<div class="misc-pub-section">
									<label>Current Color: #<?php echo paceProCore::$pace_pro_options[0]->pace_pro_global_color; ?></label>
								</div>
								
								<div class="misc-pub-section">
									<label>Current Style: <?php echo paceProCore::getStyleName(paceProCore::$pace_pro_options[0]->pace_pro_global_style); ?></label>
								</div>
							</div>
							<div id="major-publishing-actions">

								<div id="publishing-action">
								<span class="spinner"></span>
										<input type="submit" name="pace_pro_save" id="pace_pro_save" class="button button-primary button-large" value="Save Settings" accesskey="s"></div>
								<div class="clear"></div>
								</div>
						</div>
				    </div>
				</div>
				
				<div id="postbox-container-3" class="postbox-container">
				    <div class="postbox">
						<h3 class="hndle"><span>Live Preview</span></h3>
						<div class="inside" style="min-height: 173px;">
							<div class="browser">
								<iframe data-theme="minimal"></iframe>
							</div>
						</div>
				</div>
				
			</div>
		</div>
	</form>
</div>