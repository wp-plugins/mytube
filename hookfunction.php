<?php
		add_action('mytube_youtube_playlist_before','start_wrapper',1);
		add_action('mytube_youtube_playlist_after','stop_wrapper',1);
		
		add_action('mytube_youtube_playlist_mylist','list_mylist_data',1);
		add_action('mytube_youtube_playlist_data','list_youtube_data',1);
		add_action('mytube_youtube_channel_data','list_youtube_channel_data',1);
		
		add_action('mytube_vimeo_playlist_before','start_vimeo_wrapper',1);
		add_action('mytube_vimeo_playlist_after','stop_vimeo_wrapper',1);
		
		add_action('mytube_vimeo_playlist_data','list_vimeo_data',1);
		
		
		function start_wrapper(){
			global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_override_folder_name,$mtpl_themepath,$classColumns;

			$templateOverride = $mtpl_themepath."/".$mtpl_override_folder_name."/";
			$template = $mtpl_pluginpath.$mtpl_override_folder_name.'/wrapper-start.php';
						
			if (file_exists($templateOverride)){
				if(file_exists($templateOverride.'/wrapper-start.php')){
					include($templateOverride.'/wrapper-start.php');
				}else{
					include($template);
				}
			}else{
				include($template);
			}
		}
		function stop_wrapper(){
			global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_override_folder_name,$mtpl_themepath,$classColumns;
	
			$templateOverride = $mtpl_themepath."/".$mtpl_override_folder_name."/";
			$template = $mtpl_pluginpath.$mtpl_override_folder_name.'/wrapper-end.php';
			if (file_exists($templateOverride)){
				if(file_exists($templateOverride.'/wrapper-end.php')){
					include($templateOverride.'/wrapper-end.php');
				}else{
					include($template);
				}
			}else{
				include($template);
			}
		}
		
		function list_mylist_data(){
			global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_override_folder_name,$mtpl_themepath,$mtpl_playlistid;
				
			$templateOverride = $mtpl_themepath."/".$mtpl_override_folder_name."/";
			$template = $mtpl_pluginpath.$mtpl_override_folder_name.'/list_mylist_data.php';
			if (file_exists($templateOverride)){
				if(file_exists($templateOverride.'/list_mylist_data.php')){
					include($templateOverride.'/list_mylist_data.php');
				}else{
					include($template);
				}
			}else{
				include($template);
			}
		}
		function list_youtube_data(){
			global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_override_folder_name,$mtpl_themepath,$mtpl_playlistid;
				
			$templateOverride = $mtpl_themepath."/".$mtpl_override_folder_name."/";
			$template = $mtpl_pluginpath.$mtpl_override_folder_name.'/list_youtube_data.php';
			if (file_exists($templateOverride)){
				if(file_exists($templateOverride.'/list_youtube_data.php')){
					include($templateOverride.'/list_youtube_data.php');
				}else{
					include($template);
				}
			}else{
				include($template);
			}
		}
		
		function list_youtube_channel_data(){
			global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_override_folder_name,$mtpl_themepath,$mtpl_playlistid;
				
			$templateOverride = $mtpl_themepath."/".$mtpl_override_folder_name."/";
			$template = $mtpl_pluginpath.$mtpl_override_folder_name.'/list_youtube_channel.php';
			if (file_exists($templateOverride)){
				if(file_exists($templateOverride.'/list_youtube_channel.php')){
					include($templateOverride.'/list_youtube_channel.php');
				}else{
					include($template);
				}
			}else{
				include($template);
			}
		}
		
		/** Vimeo Hook Function */
		function start_vimeo_wrapper(){
			global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_override_folder_name,$mtpl_themepath,$classColumns;

			$templateOverride = $mtpl_themepath."/".$mtpl_override_folder_name."/";
			$template = $mtpl_pluginpath.$mtpl_override_folder_name.'/vimeo/wrapper-start.php';
						
			if (file_exists($templateOverride)){
				if(file_exists($templateOverride.'/vimeo/wrapper-start.php')){
					include($templateOverride.'/vimeo/wrapper-start.php');
				}else{
					include($template);
				}
			}else{
				include($template);
			}
		}
		function stop_vimeo_wrapper(){
			global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_override_folder_name,$mtpl_themepath,$classColumns;
	
			$templateOverride = $mtpl_themepath."/".$mtpl_override_folder_name."/";
			$template = $mtpl_pluginpath.$mtpl_override_folder_name.'/vimeo/wrapper-end.php';
			if (file_exists($templateOverride)){
				if(file_exists($templateOverride.'/vimeo/wrapper-end.php')){
					include($templateOverride.'/vimeo/wrapper-end.php');
				}else{
					include($template);
				}
			}else{
				include($template);
			}
		}
		function list_vimeo_data(){
			global $mtpl_pluginurl,$mtpl_pluginpath,$mtpl_override_folder_name,$mtpl_themepath,$mtpl_playlistid;
				
			$templateOverride = $mtpl_themepath."/".$mtpl_override_folder_name."/";
			$template = $mtpl_pluginpath.$mtpl_override_folder_name.'/vimeo/vimeo_list.php';
			if (file_exists($templateOverride)){
				if(file_exists($templateOverride.'/vimeo/vimeo_list.php')){
					include($templateOverride.'/vimeo/vimeo_list.php');
				}else{
					include($template);
				}
			}else{
				include($template);
			}
		}
?>