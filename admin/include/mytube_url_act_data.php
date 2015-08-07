<?php
	global $wpdb,$current_user;
	
	add_option( 'mytube_apikey', '');
	add_option( 'mytube_playlistid', '');
	add_option( 'mytube_channelid', '');
	add_option( 'mytube_vimeo_channel_id', '');
	add_option( 'mytube_open_type', 'popup' );
	add_option( 'mytube_column', '3');
	add_option( 'mytube_viewsCounter', 'yes' );
	add_option( 'mytube_videoDuration', 'yes' );
	add_option( 'mytube_maxResults','18' );
	//add_option( 'mytube_latest_videos_num', '3' );
	add_option( 'mytube_pagination_type','numeric' );
	add_option( 'mytube_pagination_position', 'bottom' );
	add_option( 'mytube_text_color', '#c90808' );
	add_option( 'mytube_text_hover_color', '#333' );
	add_option( 'mytube_text_size', '14' );
	add_option( 'mytube_view_text_color', '#ffffff' );
	add_option( 'mytube_view_bg_color', '#941414' );
	add_option( 'mytube_border_color', '#ccc' );
	add_option( 'mytube_pg_bg_color', '' );
	add_option( 'mytube_pg_text_color', '#a3a3a3' );
	add_option( 'mytube_pg_border_color', '#ccc' );
	add_option( 'mytube_pg_border_hover_color', '#D3B6B6' );
	add_option( 'mytube_pg_act_bg_color', '#941414 ' );
	add_option( 'mytube_pg_act_text_color', '#ffffff' );
	add_option( 'mytube_pg_hover_bg_color', '#D3B6B6' );
	add_option( 'mytube_pg_hover_text_color', '#941414' );
	
	
	$wpdb->query('CREATE TABLE IF NOT EXISTS `' . $wpdb->prefix . 'mytube_playlist` (`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` varchar(255) NOT NULL, `slug` VARCHAR(255) NOT NULL, `playlistid` varchar(100) NOT NULL) ENGINE = MyISAM;');
	$wpdb->query('CREATE TABLE IF NOT EXISTS `' . $wpdb->prefix . 'mytube_videos` (`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, `pid` INT(10) NOT NULL, `videoid` varchar(100) NOT NULL, `title` VARCHAR(100) NOT NULL, `slug` VARCHAR(100) NOT NULL, `description` TEXT NOT NULL, `duration` VARCHAR(20) NOT NULL, `viewCount` VARCHAR(15) NOT NULL, `thumb` VARCHAR(100) NOT NULL) ENGINE = MyISAM;');
	
?>