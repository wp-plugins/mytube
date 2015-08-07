<?php
	global $wpdb,$current_user,$mtpl_plugin_dir_name,$mtpl_num_rec_per_page,$mtpl_loader,$mtpl_icon_url,$youtube_icon_url,$vimeo_icon_url,$css_icon_url,$mtpl_folder;
	
	$mtpl_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/menu-icon.png';
	$youtube_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/youtube.gif';
	$vimeo_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/vimeo_icon.png'; 
	$css_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/css-24.ico'; 
	
	$playlistid = $_GET['playlistid'];
?>
<div class="wrapMyTube">

	<?php 
		if($_GET['playlist-updated']){ ?>
            <div class="updated settings-error" id="setting-error-settings_updated"> 
                <p><strong>PlayList Updated Successfully.</strong></p>
            </div>
    <?php } ?>
    <?php 
		if($_GET['video-already']){ ?>
            <div class="error settings-error" id="setting-error-settings_updated"> 
                <p><strong>This video already in playlist.</strong></p>
            </div>
    <?php } ?>
    
	<form method="post" action="?page=mytube_savedata" name="frmVideos" id="frmVideos">
    	<h2>
        	<img src="<?php echo $mtpl_icon_url; ?>" /> Update PlayList 
		</h2>
    	<?php
			$sqlplaylistid = $wpdb->prepare("SELECT `id`,`name` FROM `".$wpdb->prefix . "mytube_playlist` WHERE `playlistid`='".$playlistid."'"); 
			$getPlatList = $wpdb->get_row($sqlplaylistid);
			$listId = $getPlatList->id;
			$playlistname = $getPlatList->name;
		?>
        <table class="form-table">
        	<tr>
            	<td>
                	<select>
                    	<option>Select Actions</option>
                        <option>Delete Selected</option>
                    </select>
                    <input type="text" value="<?php echo $playlistname; ?>" id="playListName" name="playListName" size="30" />
                    <input type="hidden" value="<?php echo $playlistid; ?>" id="playListId" name="playListId" size="30" />
                	<input type="submit" class="button button-primary" value="Update" id="updatePlayList" name="updatePlayList">
                 	<span class="h2RightSpanSection">
                        <a href="?page=mytube_select_videos&addplaylistid=<?php echo $playlistid; ?>" class="button" >Add More Videos</a>
                    </span><br />
                    <span class="errMsg" id="errMsgDisplay"></span>
                </td>
 
            </tr>
        </table>
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
				$sql = "SELECT * FROM `".$wpdb->prefix . "mytube_videos` WHERE `pid`='".$listId."'"; 
				$getVideos = $wpdb->get_results($sql);

				
				foreach($getVideos as $getVideo){
					$video_ID = $getVideo->videoid;
					$videoTitle = $getVideo->title;
					$videoDescription = $getVideo->description;
					$videoThumb = $getVideo->thumb;
					
					$date = new DateTime('1970-01-01');
					$date->add(new DateInterval($getVideo->duration));
					$videoTime 	=  $date->format('H:i:s');
					$videoViews = number_format($getVideo->viewCount,0,'.',',');
		?>
						<tr>
							<td><input type="checkbox" class="ownPlayList" name="ownPlayList[]" value="<?php echo $video_ID; ?>" /></td>
							<td><img src="<?php echo $videoThumb; ?>" width="100"/></td>
							<td><?php echo $video_ID; ?></td>
							<td><?php echo $videoTitle; ?></td>
							<td><?php echo $videoDescription; ?></td>
							<td><?php echo $videoTime; ?></td>
							<td><?php echo $videoViews; ?></td>
						</tr>
			<?php
            	}
            ?>
        </table>
	</form>
    <p class="footer"><span class="h2RightSpanSection">Don't forget to rate <a class="rateLink" href="https://wordpress.org/plugins/mytube/">MyTube PlayList Plugin.</a></span></p>
</div>