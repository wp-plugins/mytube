<?php
	/***** Add new Groups *****/
	if(isset($_REQUEST['mtSaveSettings'])){
		global $plugin_dir_name,$wpdb;
		$mytube_apikey = $_POST['mytube_apikey'];
		$mytube_playlistid = $_POST['mytube_playlistid'];
		$mytube_open_type = $_POST['mytube_open_type'];
		$mytube_column = $_POST['mytube_column'];
		$mytube_viewsCounter = $_POST['mytube_viewsCounter'];
		$mytube_videoDuration = $_POST['mytube_videoDuration'];
		$mytube_maxResults = $_POST['mytube_maxResults'];
		$mytube_pagination_type = $_POST['mytube_pagination_type'];
		$mytube_pagination_position = $_POST['mytube_pagination_position'];
		
		update_option( 'mytube_apikey', $mytube_apikey );
		update_option( 'mytube_playlistid', $mytube_playlistid );
		update_option( 'mytube_open_type', $mytube_open_type );
		update_option( 'mytube_column', $mytube_column );
		update_option( 'mytube_viewsCounter', $mytube_viewsCounter );
		update_option( 'mytube_videoDuration', $mytube_videoDuration );
		update_option( 'mytube_maxResults', $mytube_maxResults );
		update_option( 'mytube_pagination_type', $mytube_pagination_type );
		update_option( 'mytube_pagination_position', $mytube_pagination_position );
		
		echo '<meta http-equiv="refresh" content="0; url=?page='.$plugin_dir_name.'/mytube_list.php_settings&settings-updated=true">';
		exit;
	}
	if(isset($_REQUEST['mtRestoreSettings'])){
		global $plugin_dir_name,$wpdb;
		update_option( 'mytube_playlistid', '' );
		update_option( 'mytube_open_type', 'popup' );
		update_option( 'mytube_column', '3' );
		update_option( 'mytube_viewsCounter', 'yes' );
		update_option( 'mytube_videoDuration', 'yes' );
		update_option( 'mytube_maxResults', '18' );
		update_option( 'mytube_pagination_type', 'numeric' );
		update_option( 'mytube_pagination_position', 'bottom' );
		
		echo '<meta http-equiv="refresh" content="0; url=?page='.$plugin_dir_name.'/mytube_list.php_settings&settings-restore=true">';
		exit;
	}
?>