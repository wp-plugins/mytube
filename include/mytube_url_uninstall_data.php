<?php
	global $wpdb,$current_user;
	
	delete_option('mytube_apikey');
	delete_option('mytube_playlistid');
	delete_option('mytube_channelid');
	delete_option('mytube_vimeo_channel_id');
	delete_option('mytube_open_type');
	delete_option('mytube_column');
	delete_option('mytube_viewsCounter');
	delete_option('mytube_videoDuration');
	delete_option('mytube_maxResults');
	//delete_option('mytube_latest_videos_num');
	delete_option('mytube_pagination_type');
	delete_option('mytube_pagination_position');
	delete_option('mytube_text_color');
	delete_option('mytube_text_hover_color');
	delete_option('mytube_text_size');
	delete_option('mytube_view_text_color');
	delete_option('mytube_view_bg_color');
	delete_option('mytube_border_color');
	delete_option('mytube_pg_bg_color');
	delete_option('mytube_pg_text_color');
	delete_option('mytube_pg_border_color');
	delete_option('mytube_pg_border_hover_color');
	delete_option('mytube_pg_act_bg_color');
	delete_option('mytube_pg_act_text_color');
	delete_option('mytube_pg_hover_bg_color');
	delete_option('mytube_pg_hover_text_color');
	
	
	$table = $wpdb->prefix . "mytube_playlist";
	$wpdb->query("DROP TABLE IF EXISTS $table");
	
	$table = $wpdb->prefix . "mytube_videos";
	$wpdb->query("DROP TABLE IF EXISTS $table");
		
?>