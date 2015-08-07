<?php
if(!class_exists('Register_Activation_Deactivation')){
	class Register_Activation_Deactivation extends Mytube_Playlist{
		
		public function __construct(){
			register_activation_hook(__FILE__,'MyTube_plugin_install');
			register_uninstall_hook( __FILE__, 'MyTube_pluginUninstall' );
		}
		
		public function MyTube_plugin_install() {
			global $wpdb,$current_user;
			include('include/mytube_url_act_data.php');
		}	
		public function MyTube_pluginUninstall() {
			global $wpdb,$current_user;
			include('include/mytube_url_uninstall_data.php');
		}
	}
	return new Register_Activation_Deactivation();
}
?>