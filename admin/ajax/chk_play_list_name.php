<?php
	require_once("../../../../../wp-blog-header.php");
	require_once("../../../../../wp-config.php");
	session_start();
	error_reporting(0);
	
	global $wpdb;
	
	$name = $_POST['playListName'];
	
	$sql = $wpdb->prepare("SELECT `playlistid` FROM `".$wpdb->prefix . "mytube_playlist` WHERE `name`='".$name."'"); 
	$getVideos = $wpdb->get_row($sql);

	if($getVideos->playlistid!=""){
		echo $getVideos->playlistid;
	}

?>