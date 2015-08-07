<?php 
	
	global $wpdb,$current_user,$mtpl_plugin_dir_name,$mtpl_num_rec_per_page,$mtpl_loader,$mtpl_icon_url,$youtube_icon_url,$vimeo_icon_url,$css_icon_url,$mtpl_folder;
	
	$mtpl_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/menu-icon.png';
	$youtube_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/youtube.gif';
	$vimeo_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/vimeo_icon.png'; 
	$css_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/css-24.ico'; 
	
	/**** Create Slug ****/
	function createSlug($string){
		$slug = preg_replace('/[^a-zA-Z0-9.]/', '-', $string);
		$slug = preg_replace('/-{2,}/','-',$slug);
		return $slug;
	}
	/**** // Create Slug ****/

	
	$maxrecord 	= 5;
	$channelid 	= $_REQUEST['channelId'];
	$APIKEY		= get_option( 'mytube_apikey' );
	$jsonChannelURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&maxResults={$maxrecord}&channelId={$channelid}&key={$APIKEY}");
	$jsonChannel = json_decode($jsonChannelURL);
	$channelItems = $jsonChannel->{'items'};
	if($_POST['videoPlayList']){
		$video_ID = $_POST['videoId'];
		$videoURL1 = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video_ID}&part=snippet,statistics,contentDetails&key={$APIKEY}");
		$videoURL = json_decode($videoURL1);
		$views = $videoURL->{'items'}[0]->{'statistics'}->{'viewCount'};
		$time1 = $videoURL->{'items'}[0]->{'contentDetails'}->{'duration'};
		
		$videoTime 	=  $time1;
		$videoViews = number_format($views,0,'.',',');
		$videoThumb = $videoURL->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'default'}->{'url'};
		$videoTitle = $videoURL->{'items'}[0]->{'snippet'}->{'title'};
		$videoDescription = $videoURL->{'items'}[0]->{'snippet'}->{'description'};
		
		$videoID = $_POST['videoId'];
		$playListName = $_POST['videoPlayListName'];
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
		
		$wpdb->insert( 
			$wpdb->prefix . 'mytube_videos', 
			array( 
				'pid' 			=> $lastPlayListID, 
				'videoid' 		=> $videoID,
				'title' 		=> $videoTitle,
				'slug'			=> createSlug($videoTitle),
				'description'	=> $videoDescription,
				'duration'		=> $videoTime,
				'viewCount'		=> $videoViews,
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
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_select_videos&playlist='.$playListId.'&success-create=true">';
		exit;
	}else if($_POST['addVideoPlayList']){
		$playListId = $_GET['addplaylistid'];
		$video_ID = $_POST['videoId'];
		
		$videoURL1 = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video_ID}&part=snippet,statistics,contentDetails&key={$APIKEY}");
		$videoURL = json_decode($videoURL1);
		$views = $videoURL->{'items'}[0]->{'statistics'}->{'viewCount'};
		$time1 = $videoURL->{'items'}[0]->{'contentDetails'}->{'duration'};
		
		$videoTime 	=  $time1;
		$videoViews = number_format($views,0,'.',',');
		$videoThumb = $videoURL->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'default'}->{'url'};
		$videoTitle = $videoURL->{'items'}[0]->{'snippet'}->{'title'};
		$videoDescription = $videoURL->{'items'}[0]->{'snippet'}->{'description'};
				
		$sqlplaylistid = $wpdb->prepare("SELECT `id` FROM `".$wpdb->prefix . "mytube_playlist` WHERE `playlistid`='".$playListId."'"); 
		$getPlatList = $wpdb->get_row($sqlplaylistid);
		$listId = $getPlatList->id;
		
		$countVideos = $wpdb->get_var( "SELECT COUNT(*) FROM `" . $wpdb->prefix . "mytube_videos` WHERE `videoid`='".$video_ID."' AND `pid`='".$listId."'" );
		if($countVideos>0){
			echo '<meta http-equiv="refresh" content="0; url=?page=mytube_edit_videos&playlistid='.$playListId.'&video-already=true">';
			exit;
		}
		
		$wpdb->insert( 
			$wpdb->prefix . 'mytube_videos', 
			array( 
				'pid' 			=> $listId, 
				'videoid' 		=> $video_ID,
				'title' 		=> $videoTitle,
				'slug'			=> createSlug($videoTitle),
				'description'	=> $videoDescription,
				'duration'		=> $videoTime,
				'viewCount'		=> $videoViews,
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
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_edit_videos&playlistid='.$playListId.'&playlist-updated=true">';
		exit;
	}
?>
<div class="wrapMyTube">

	<?php if($_GET['success-create']){ ?>
        	<div class="updated settings-error" id="setting-error-settings_updated"> 
	            <p>
                    <strong style="float:right;"><img src="<?php echo $closeicon; ?>" width="16px;" style="cursor:pointer;" title="Close"/></strong>
                	<strong>PlayList Created Successfully.</strong><br>
                	<strong>Your Shortcode is : </strong>[mytube playlistid="<?php echo $_GET['playlist']; ?>"]
                </p>
	        </div>
            <div class="top-bottom"></div>

	<?php } ?>
    
	<form method="post" name="frmPrePlayList" id="frmPrePlayList">
        <h2>
            <img src="<?php echo $mtpl_icon_url; ?>" /> Videos from Channel ID
            <span class="h2RightSpanSection">
            </span>
        </h2>
		<div class="mytube-col-2">
            <input type="text" size="30" name="channelId" id="channelId" placeholder="Enter YouTube Channel ID" value="<?php echo $channelid; ?>">
            <input type="submit" class="button" value="Load Videos" id="channelPlayList" name="channelPlayList"><br />
        	<span class="errMsg" id="channelErrMsgDisplay"></span>
        </div>
        <div class="mytube-col-10">OR</div>
        <div class="mytube-col-2">
	        <input type="text" size="30" name="videoId" id="videoId" placeholder="Enter YouTube Video ID" value="<?php echo $videoid; ?>"><br />
    	    <?php if( ! isset($_GET['addplaylistid']) ) { ?>
                <input type="text" size="30" name="videoPlayListName" id="videoPlayListName" placeholder="Enter PlayList Name" value="<?php echo $videoid; ?>"><br />
                <input type="submit" class="button" value="Create PlayList" id="videoPlayList" name="videoPlayList"><br />
            <?php }else { ?>
            	<input type="submit" class="button" value="Add to PlayList" id="videoPlayList" name="addVideoPlayList"><br />
            <?php } ?>
        	<span class="errMsg" id="videoErrMsgDisplay"></span>
        </div>
        <div class="mytube-clear"></div>
        
	</form>
    <?php if( isset( $channelid ) && $channelid != ""){ ?>
   	<form method="post" action="?page=mytube_savedata" name="frmVideos" id="frmVideos">
    	<table class="form-table">
            <tr style="border-bottom:1px solid #ccc;">
				<th><input type="checkbox" id="ownPlayListAll"/></th>
                <th>Image</th>
                <th>Video Id</th>
                <th>Title</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Views</th>
            </tr>
            <?php
				$videoarray = array();
				foreach($channelItems as $chnlitm){
					$playlistid = $chnlitm->{'id'};
					$maxrecord = 50;
					$jsonPlayListURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,status,contentDetails&maxResults={$maxrecord}&playlistId={$playlistid}&key={$APIKEY}&order=date");
					$jsonPlayList = json_decode($jsonPlayListURL);
					$playListItems = $jsonPlayList->{'items'};
				
					foreach($playListItems as $pllstitm){
						$video_ID = $pllstitm->{'snippet'}->{'resourceId'}->{'videoId'};
						$videoarray[] = $video_ID;
						$videoJsonURL1 = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video_ID}&part=statistics,contentDetails&key={$APIKEY}");
						$videoJsonURL = json_decode($videoJsonURL1);
						
						$views = $videoJsonURL->{'items'}[0]->{'statistics'}->{'viewCount'};
						$time1 = $videoJsonURL->{'items'}[0]->{'contentDetails'}->{'duration'};
						
						$date = new DateTime('1970-01-01');
						$date->add(new DateInterval($time1));
						$videoTime 	=  $date->format('H:i:s');
						$videoViews = number_format($views,0,'.',',');
			?>
							<tr>
								<td><input type="checkbox" class="ownPlayList" name="ownPlayList[]" value="<?php echo $video_ID; ?>" /></td>
								<td><img src="<?php echo $pllstitm->{'snippet'}->{'thumbnails'}->{'default'}->{'url'}; ?>" /></td>
								<td><?php echo $video_ID; ?></td>
								<td><?php echo $pllstitm->{'snippet'}->{'title'}; ?></td>
								<td><?php echo substr($pllstitm->{'snippet'}->{'description'},0,255); ?></td>
								<td><?php echo $videoTime; ?></td>
								<td><?php echo $videoViews; ?></td>
							</tr>
			<?php
                	}
            
            	}
            ?>
        </table>
        <p class="footer">
            <?php if( ! isset($_GET['addplaylistid'])){ ?>
                <input type="text" placeholder="Enter Playlist Name" name="mtCreatePlayListName" id="mtCreatePlayListName" size="30">
                <input type="submit" class="button button-primary" name="mtCreatePlayList" id="mtCreatePlayList" value="Create Playlist" title="Add Videos to PlayList" />
            <?php } else { ?>
            	<input type="hidden" name="addplaylistid" id="addplaylistid" value="<?php echo $_GET['addplaylistid']; ?>" />
                <input type="submit" class="button button-primary" name="mtUpdatePlayList" id="mtUpdatePlayList" value="Add to Playlist" title="Update Videos to PlayList" />
            <?php } ?>
            <span class="h2RightSpanSection">Don't forget to rate <a class="rateLink" href="https://wordpress.org/plugins/mytube/">MyTube PlayList Plugin.</a></span>
            <br />
            <span class="errMsg" id="errMsgDisplay"></span>
        </p>
	</form>
    <?php } else { ?>
		<p>Channel ID not found. Please enter YouTube channel id in above text box.</p>
        <p class="footer"><span class="h2RightSpanSection">Don't forget to rate <a class="rateLink" href="https://wordpress.org/plugins/mytube/">MyTube PlayList Plugin.</a></span></p>
	<?php } ?>
    
</div>