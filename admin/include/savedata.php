<?php
	if( ! isset($_REQUEST['mtSaveSettings']) && ! isset($_REQUEST['mtRestoreSettings']) && ! isset($_REQUEST['createNewPage']) && ! isset($_POST['mtCreatePlayList']) && ! isset($_POST['mtUpdatePlayList']) && ! isset($_POST['updatePlayList'])){
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_settings">';
		exit;
	}
/**** Create Slug ****/
	function createSlug($string){
		$slug = preg_replace('/[^a-zA-Z0-9.]/', '-', $string);
		$slug = preg_replace('/-{2,}/','-',$slug);
		return $slug;
	}
/**** // Create Slug ****/

	/***** Add new Groups *****/
	if(isset($_REQUEST['mtSaveSettings'])){
		global $mtpl_plugin_dir_name,$wpdb;
		
		update_option( 'mytube_apikey', 				$_POST['mytube_apikey'] );
		update_option( 'mytube_playlistid', 			$_POST['mytube_playlistid'] );
		update_option( 'mytube_channelid', 				$_POST['mytube_channelid'] );
		update_option( 'mytube_vimeo_channel_id', 		$_POST['mytube_vimeo_channel_id'] );
		update_option( 'mytube_open_type', 				$_POST['mytube_open_type'] );
		update_option( 'mytube_column', 				$_POST['mytube_column'] );
		update_option( 'mytube_viewsCounter', 			$_POST['mytube_viewsCounter'] );
		update_option( 'mytube_videoDuration', 			$_POST['mytube_videoDuration'] );
		update_option( 'mytube_maxResults', 			$_POST['mytube_maxResults'] );
		//update_option( 'mytube_latest_videos_num', 		$_POST['mytube_latest_videos_num'] );
		update_option( 'mytube_pagination_type', 		$_POST['mytube_pagination_type'] );
		update_option( 'mytube_pagination_position', 	$_POST['mytube_pagination_position'] );
		
		update_option( 'mytube_text_color', 			$_POST['mytube_text_color'] );
		update_option( 'mytube_text_hover_color', 		$_POST['mytube_text_hover_color'] );
		update_option( 'mytube_text_size', 				$_POST['mytube_text_size'] );
		update_option( 'mytube_view_text_color', 		$_POST['mytube_view_text_color'] );
		update_option( 'mytube_view_bg_color', 			$_POST['mytube_view_bg_color'] );
		update_option( 'mytube_border_color', 			$_POST['mytube_border_color'] );
		
		update_option( 'mytube_pg_bg_color', 			$_POST['mytube_pg_bg_color'] );
		update_option( 'mytube_pg_text_color', 			$_POST['mytube_pg_text_color'] );
		update_option( 'mytube_pg_border_color', 		$_POST['mytube_pg_border_color'] );
		update_option( 'mytube_pg_border_hover_color', 	$_POST['mytube_pg_border_hover_color'] );
		update_option( 'mytube_pg_act_bg_color', 		$_POST['mytube_pg_act_bg_color'] );
		update_option( 'mytube_pg_act_text_color', 		$_POST['mytube_pg_act_text_color'] );
		update_option( 'mytube_pg_hover_bg_color', 		$_POST['mytube_pg_hover_bg_color'] );
		update_option( 'mytube_pg_hover_text_color', 	$_POST['mytube_pg_hover_text_color'] );
	
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_settings&settings-updated=true">';
		exit;
	}
	if(isset($_REQUEST['mtRestoreSettings'])){
		global $mtpl_plugin_dir_name,$wpdb;
		update_option( 'mytube_playlistid', '' );
		update_option( 'mytube_channelid', '' );
		update_option( 'mytube_vimeo_channel_id', '' );
		update_option( 'mytube_open_type', 'popup' );
		update_option( 'mytube_column', '3' );
		update_option( 'mytube_viewsCounter', 'yes' );
		update_option( 'mytube_videoDuration', 'yes' );
		update_option( 'mytube_maxResults', '18' );
		//update_option( 'mytube_latest_videos_num', '3' );
		update_option( 'mytube_pagination_type', 'numeric' );
		update_option( 'mytube_pagination_position', 'bottom' );
		
		update_option( 'mytube_text_color', '#c90808' );
		update_option( 'mytube_text_hover_color', '#333' );
		update_option( 'mytube_text_size', '14' );
		update_option( 'mytube_view_text_color', '#ffffff' );
		update_option( 'mytube_view_bg_color', '#941414' );
		update_option( 'mytube_border_color', '#ccc' );
		
		update_option( 'mytube_pg_bg_color', '' );
		update_option( 'mytube_pg_text_color', '#a3a3a3' );
		update_option( 'mytube_pg_border_color', '#ccc' );
		update_option( 'mytube_pg_border_hover_color', '#D3B6B6' );
		update_option( 'mytube_pg_act_bg_color', '#941414 ' );
		update_option( 'mytube_pg_act_text_color', '#ffffff' );
		update_option( 'mytube_pg_hover_bg_color', '#D3B6B6' );
		update_option( 'mytube_pg_hover_text_color', '#941414' );
	
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_settings&settings-restore=true">';
		exit;
	}
	
	if(isset($_REQUEST['createNewPage'])){
		global $wpdb;

	/************ Page for PlayList's Videos *************/

		$first_the_page_title = 'MyTube Videos';
		$first_the_page_name = 'mytube-videos';
	
		// the menu entry...
		delete_option("my_plugin_page_title");
		add_option("my_plugin_page_title", $first_the_page_title, '', 'yes');
		// the slug...
		delete_option("my_plugin_page_name");
		add_option("my_plugin_page_name", $first_the_page_name, '', 'yes');
		// the id...
		delete_option("my_plugin_page_id");
		add_option("my_plugin_page_id", '0', '', 'yes');
	
		$first_the_page = get_page_by_title( $first_the_page_title );
		
		$channelid = get_option( 'mytube_channelid' );
		$APIKEY = get_option( 'mytube_apikey' );
		$jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&channelId={$channelid}&key={$APIKEY}");
		$json = json_decode($jsonURL);
		$playListID = $json->{'items'}[0]->{'id'};
		
		if ( ! $first_the_page ) {
	
			// Create post object
			$first_p = array();
			$first_p['post_title'] = $first_the_page_title;
			$first_p['post_content'] = '<p>[mytube playlistid="'.$playListID.'"]</p>';
			$first_p['post_status'] = 'publish';
			$first_p['post_type'] = 'page';
			$first_p['comment_status'] = 'closed';
			$first_p['ping_status'] = 'closed';
			$first_p['post_category'] = array(1); // the default 'Uncatrgorised'
	
			// Insert the post into the database
			$first_the_page_id = wp_insert_post( $first_p );
	
		}
		else {
			// the plugin may have been previously active and the page may just be trashed...
	
			$first_the_page_id = $first_the_page->ID;
	
			//make sure the page is not trashed...
			$first_the_page->post_status = 'publish';
			$first_the_page_id = wp_update_post( $first_the_page );
	
		}
	
		delete_option( 'my_plugin_page_id' );
		add_option( 'my_plugin_page_id', $first_the_page_id );
		
	/************ //Page for PlayList's Videos *************/

	/************ Page for Channel's PlayList *************/

		$second_the_page_title = 'MyTube PlayList';
		$second_the_page_name = 'mytube-playlist';
	
		// the menu entry...
		delete_option("my_plugin_page_title");
		add_option("my_plugin_page_title", $second_the_page_title, '', 'yes');
		// the slug...
		delete_option("my_plugin_page_name");
		add_option("my_plugin_page_name", $second_the_page_name, '', 'yes');
		// the id...
		delete_option("my_plugin_page_id");
		add_option("my_plugin_page_id", '0', '', 'yes');
	
		$second_the_page = get_page_by_title( $second_the_page_title );
	
		if ( ! $second_the_page ) {
	
			// Create post object
			$second_p = array();
			$second_p['post_title'] = $second_the_page_title;
			$second_p['post_content'] = '<p>[mytube channelid="'.get_option( 'mytube_channelid' ).'" pageid="'.$first_the_page_id.'"]</p>';
			$second_p['post_status'] = 'publish';
			$second_p['post_type'] = 'page';
			$second_p['comment_status'] = 'closed';
			$second_p['ping_status'] = 'closed';
			$second_p['post_category'] = array(1); // the default 'Uncatrgorised'
	
			// Insert the post into the database
			$second_the_page_id = wp_insert_post( $second_p );
	
		}
		else {
			// the plugin may have been previously active and the page may just be trashed...
	
			$second_the_page_id = $second_the_page->ID;
	
			//make sure the page is not trashed...
			$second_the_page->post_status = 'publish';
			$second_the_page_id = wp_update_post( $second_the_page );
	
		}
	
		delete_option( 'my_plugin_page_id' );
		add_option( 'my_plugin_page_id', $second_the_page_id );
		
	/************ //Page for Channel's PlayList *************/

		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_settings&settings-create=true">';
		exit;	
	}
	
	if(isset($_POST['mtCreatePlayList'])){
		$APIKEY	= get_option( 'mytube_apikey' );
		$videos = $_POST['ownPlayList'];
		$playListName = $_POST['mtCreatePlayListName'];
		$playListId = md5($playListName);
		if( $playListName == "" ){
			$playListId = md5(date('Y-m-d H:i:s'));
		}
		
		$wpdb->insert( 
			$wpdb->prefix . 'mytube_playlist', 
			array( 
				'name' => $playListName, 
				'slug' => createSlug($playListName),
				'playlistid' => $playListId 
			), 
			array( 
				'%s', 
				'%s',
				'%s'
			) 
		);
		
		$lastPlayListID = $wpdb->insert_id;
		
		foreach($videos as $video){
			$videoJsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video}&part=statistics,snippet,contentDetails&key={$APIKEY}");
			$videoJson = json_decode($videoJsonURL);
			
			$videoTitle = $videoJson->{'items'}[0]->{'snippet'}->{'title'};
			$videoDescription = $videoJson->{'items'}[0]->{'snippet'}->{'description'};
			$videoDuration = $videoJson->{'items'}[0]->{'contentDetails'}->{'duration'};
			$videoCount = $videoJson->{'items'}[0]->{'statistics'}->{'viewCount'};
			$videoThumb	= $videoJson->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'medium'}->{'url'};
			
			$wpdb->insert( 
				$wpdb->prefix . 'mytube_videos', 
				array( 
					'pid' 			=> $lastPlayListID, 
					'videoid' 		=> $video,
					'title' 		=> $videoTitle,
					'slug'			=> createSlug($videoTitle),
					'description'	=> $videoDescription,
					'duration'		=> $videoDuration,
					'viewCount'		=> $videoCount,
					'thumb'			=> $videoThumb
				), 
				array( 
					'%s', 
					'%s',
					'%s',
					'%s', 
					'%s',
					'%s',
					'%s', 
					'%s'
				) 
			);
			
		}
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_select_videos&playlist='.$playListId.'&success-create=true">';
		exit;	
	
	}
	
	if(isset($_POST['mtUpdatePlayList'])){
		$APIKEY	= get_option( 'mytube_apikey' );
		$videosArray1 = $_POST['ownPlayList'];
		$addplaylistid = $_POST['addplaylistid'];
		
		$sqlplaylistid = $wpdb->prepare("SELECT `id` FROM `".$wpdb->prefix . "mytube_playlist` WHERE `playlistid`='".$addplaylistid."'"); 
		$getPlatList = $wpdb->get_row($sqlplaylistid);
		$listId = $getPlatList->id;
		
		$sqlplaylistid = "SELECT `videoid` FROM `".$wpdb->prefix . "mytube_videos` WHERE `pid`='".$listId."'";
		$getPlatLists = $wpdb->get_results($sqlplaylistid);

		$videosArray2 = array();
		foreach($getPlatLists as $getPlatList){
			$videosArray2[] = $getPlatList->videoid;
		}
		
		$videos = array_diff($videosArray1, $videosArray2);
		
		foreach($videos as $video){
			$videoJsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video}&part=statistics,snippet,contentDetails&key={$APIKEY}");
			$videoJson = json_decode($videoJsonURL);
			
			$videoTitle = $videoJson->{'items'}[0]->{'snippet'}->{'title'};
			$videoDescription = $videoJson->{'items'}[0]->{'snippet'}->{'description'};
			$videoDuration = $videoJson->{'items'}[0]->{'contentDetails'}->{'duration'};
			$videoCount = $videoJson->{'items'}[0]->{'statistics'}->{'viewCount'};
			$videoThumb	= $videoJson->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'medium'}->{'url'};
			
			$wpdb->insert( 
				$wpdb->prefix . 'mytube_videos', 
				array( 
					'pid' 			=> $listId, 
					'videoid' 		=> $video,
					'title' 		=> $videoTitle,
					'slug'			=> createSlug($videoTitle),
					'description'	=> $videoDescription,
					'duration'		=> $videoDuration,
					'viewCount'		=> $videoCount,
					'thumb'			=> $videoThumb
				),
				array( 
					'%s', 
					'%s',
					'%s',
					'%s', 
					'%s',
					'%s',
					'%s', 
					'%s'
				)
			);
		}
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_edit_videos&playlistid='.$addplaylistid.'&playlist-updated=true">';
		exit;
	}
	
	if(isset($_POST['updatePlayList'])){
		$videos = $_POST['ownPlayList'];
		$playListName = $_POST['playListName'];
		$playListId = $_POST['playListId'];
		$slug = createSlug($playListName);
		
		$wpdb->update( 
			$wpdb->prefix . 'mytube_playlist', 
			array( 
				'name' => $playListName,
				'slug' => $slug
			), 
			array( 'playlistid' => $playListId ), 
			array( 
				'%s',
				'%s'
			), 
			array( '%s' ) 
		);
		
		foreach($videos as $video){
			$wpdb->delete( $wpdb->prefix . 'mytube_videos', array( 'videoid' => $video ) );
		}
		
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_edit_videos&playlistid='.$playListId.'&playlist-updated=true">';
		exit;
	}
?>