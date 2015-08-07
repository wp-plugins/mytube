<?php
	/**
		Plugin Name: MyTube PlayList
		Author: Raghu Goriya
		Author URI: http://tes-india.com/
		Version: 2.0.3
		Description: Displays awesome YouTube Videos in your posts, pages, and widgets. YouTube Embed plugin is an convenient tool for adding video to your website. Create your own playlist on MyTube PlayList using channel id and also video id. And also we provide you to override functionality.
		License: GPL2
	*/

/************ Set Setting Link on Installed Plugins ***************/
if(!class_exists('Mytube_Playlist')){
	
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}
	
	error_reporting(0);
	
	/************ Initialization of Variable and Path ***************/
	
	global $wpdb,$mtpl_plugin_dir_name,$mtpl_icon_url,$mtpl_num_rec_per_page,$mtpl_loader,$mtpl_file,$mtpl_folder,$hook;
	global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_themepath,$mtpl_override_folder_name;
	global $classColumns; 
	
	$hook = "";
	$mtpl_pluginurl = ""; $mtpl_pluginpath = ""; $mtpl_themepath = ""; $mtpl_override_folder_name = ""; $classColumns = "";
	
	$mtpl_icon_url = plugin_dir_url( __FILE__ ).'/assets/images/logo_thumb.png'; 
	$mtpl_plugin_dir_name = explode('/',plugin_basename(__FILE__));
	$mtpl_plugin_dir_name = $mtpl_plugin_dir_name[0];
	
	$mtpl_file   = basename( __FILE__ );
	$mtpl_folder = basename( dirname( __FILE__ ) );
	$hook = "in_plugin_update_message-{$mtpl_folder}/{$mtpl_file}";

	$mtpl_pluginurl = plugin_dir_url( __FILE__ );
	$mtpl_pluginpath = plugin_dir_path( __FILE__ );
	$mtpl_override_folder_name = "mytube_override";
	$mtpl_themepath = get_template_directory();
	

	header( 'Content-Type: text/html; charset=utf-8' ); 
	
	/************ //Initialization of Variable and Path ***************/

	class Mytube_Playlist{
		
		public function __construct(){
			add_action('admin_menu',array(&$this,'mtp_admin_menu'));
			add_filter('plugin_action_links', array(&$this,'MyTube_plugin_action_links'), 10, 2);
			add_action( $hook, array(&$this,'mytube_update_message'), 9, 2 ); 
			register_activation_hook(__FILE__, array(&$this,'MyTube_plugin_install'));
			register_uninstall_hook( __FILE__, array(&$this,'MyTube_pluginUninstall'));
			
			
			//require(sprintf('%s/admin/act-deact.php',dirname(__FILE__)));
			//$Register_Activation_Deactivation = new Register_Activation_Deactivation();
		
			require(sprintf('%s/template/mytube_list_front.php',dirname(__FILE__)));
			$Mytube_List_Front = new Mytube_List_Front();
			
			//$this->init();
			include('hookfunction.php');
			
		}
		public function init() {
			add_filter( 'template_redirect', 'mytube_to_orid', 10, 3 );
		}
		public function mtp_admin_menu(){
			
			$mtpl_icon_url = plugin_dir_url( __FILE__ ).'/assets/images/menu-icon.png';
			
			add_menu_page( 'MyTube', 'MyTube','', __FILE__, '',$mtpl_icon_url,15 );
			add_submenu_page( __FILE__, 'Global Settings', 'Global Settings', 'manage_options','mytube_settings', array(&$this,'MyTube_management_settings') );
			add_submenu_page( __FILE__, 'Create PlayList', 'Create PlayList', 'manage_options','mytube_select_videos', array(&$this,'MyTube_create_playlist_by_channel_id') );
			add_submenu_page( __FILE__, 'View PlayList', 'My PlayList', 'manage_options','mytube_change_videos', array(&$this,'MyTube_change_playlist_by_id') );
			add_submenu_page( '', 'Edit PlayList', 'Edit PlayList', 'manage_options','mytube_edit_videos', array(&$this,'MyTube_edit_playlist_by_id') );
			add_submenu_page( '', 'Save Category', 'Save Category', 'manage_options','mytube_savedata', array(&$this,'MyTube_save_data') );
		}
		
		public function mytube_update_message( $plugin_data, $r ){
			echo 'There is a new version of MyTube PlayList with override functionality';
		}
		
		public function MyTube_plugin_install() {
			global $wpdb,$current_user;
			require(sprintf('%s/admin/include/mytube_url_act_data.php',dirname(__FILE__)));
		}	
		public function MyTube_pluginUninstall() {
			global $wpdb,$current_user;
			require(sprintf('%s/admin/include/mytube_url_uninstall_data.php',dirname(__FILE__)));
		}
		
		public function MyTube_management_settings(){
			require(sprintf('%s/admin/mytube_admin_data.php',dirname(__FILE__)));
			Mytube_Admin_Data::MyTube_management_settings();	
		}
		
		public function MyTube_save_data(){
			require(sprintf('%s/admin/mytube_admin_data.php',dirname(__FILE__)));
			Mytube_Admin_Data::MyTube_save_data();
		}
		
		public function MyTube_create_playlist_by_channel_id(){
			require(sprintf('%s/admin/mytube_admin_data.php',dirname(__FILE__)));
			Mytube_Admin_Data::MyTube_create_playlist_by_channel_id();
		}

		public function MyTube_change_playlist_by_id(){
			require(sprintf('%s/admin/mytube_admin_data.php',dirname(__FILE__)));
			Mytube_Admin_Data::MyTube_change_playlist_by_id();
		}
		
		public function MyTube_edit_playlist_by_id(){
			require(sprintf('%s/admin/mytube_admin_data.php',dirname(__FILE__)));
			Mytube_Admin_Data::MyTube_edit_playlist_by_id();
		}
		
		public function MyTube_plugin_action_links($links, $mtpl_file) {
			static $this_plugin;
		
			if (!$this_plugin) {
				$this_plugin = plugin_basename(__FILE__);
			}
		
			if ($mtpl_file == $this_plugin) {
				// The "page" query string value must be equal to the slug
				// of the Settings admin page we defined earlier, which in
				// this case equals "myplugin-settings".
				$settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=mytube_settings">Settings</a>';
				array_unshift($links, $settings_link);
			}
		
			return $links;
		}
	}
}

$Mytube_Playlist = new Mytube_Playlist();
?>