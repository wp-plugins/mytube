<?php
	
	global $wpdb,$current_user,$mtpl_plugin_dir_name,$mtpl_num_rec_per_page,$mtpl_loader,$mtpl_icon_url,$youtube_icon_url,$vimeo_icon_url,$css_icon_url,$mtpl_folder;
	
	$mtpl_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/menu-icon.png';
	$youtube_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/youtube.gif';
	$vimeo_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/vimeo_icon.png'; 
	$css_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/css-24.ico'; 
	
	if(isset($_GET['deleteplaylistid'])){
		$sql = $wpdb->prepare("SELECT `id` FROM `".$wpdb->prefix . "mytube_playlist` WHERE `playlistid`='".$_GET['deleteplaylistid']."'"); 
		$getPlayList = $wpdb->get_row($sql);
		$listId = $getPlayList->id;
		
		$wpdb->delete( $wpdb->prefix . 'mytube_playlist', array( 'id' => $listId ) );
		$wpdb->delete( $wpdb->prefix . 'mytube_videos', array( 'pid' => $listId ) );
		echo '<meta http-equiv="refresh" content="0; url=?page=mytube_change_videos&playlist-deleted=true">';
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
<?php if($_GET['playlist-deleted']){ ?>
        	<div class="updated settings-error" id="setting-error-settings_updated"> 
	            <p>
                    <strong style="float:right;"><img src="<?php echo $closeicon; ?>" width="16px;" style="cursor:pointer;" title="Close"/></strong>
                	<strong>PlayList Deleted Successfully.</strong><br>
                </p>
	        </div>
            <div class="top-bottom"></div>
<?php } ?>

    <h2> <img src="<?php echo $mtpl_icon_url; ?>" /> My PlayList </h2>
    
    <form method="post" action="?page=mytube_savedata" name="frmVideos" id="frmVideos">
    	
        <table class="form-table">
            <tr style="border-bottom:1px solid #ccc;">
				<th style="width:7%;">Sr. No.</th>
                <th>PlayList Name</th>
                <th style="width:50%;">ShortCode</th>
                <th style="width:7%; text-align:center;">Videos</th>
                <th>Action</th>
            </tr>
            <?php
				$srno = 1;
				
				$sql = "SELECT * FROM `".$wpdb->prefix . "mytube_playlist`"; 
				$getPlayLists = $wpdb->get_results($sql);

				foreach($getPlayLists as $getPlayList){
					$id = $getPlayList->id;
					$playListName = $getPlayList->name;
					$playListId = $getPlayList->playlistid;
					$countVideos = $wpdb->get_var( "SELECT COUNT(*) FROM `" . $wpdb->prefix . "mytube_videos` WHERE `pid`='".$id."'" );
			?>
                    <tr>
                        <td><?php echo $srno++; ?></td>
                        <td><?php echo $playListName; ?></td>
                        <td><?php echo '[mytube playlistid="'.$playListId.'"]'; ?></td>
                        <td style="text-align:center;"><?php echo $countVideos; ?></td>
                        <td><a href="?page=mytube_edit_videos&playlistid=<?php echo $playListId; ?>" class="button">Edit</a> &nbsp;
                        <a href="?page=mytube_change_videos&deleteplaylistid=<?php echo $playListId; ?>" onclick="if(!confirm('Are you sure delete this playlist?\n<?php echo $countVideos; ?> video(s) will be deleted.')){ return false; }" class="button mytybe-button-danger">Delete</a> </td>
                    </tr>
			<?php
               }
            ?>
        </table>
	</form>
    
    <p class="footer"><span class="h2RightSpanSection">Don't forget to rate <a class="rateLink" href="https://wordpress.org/plugins/mytube/">MyTube PlayList Plugin.</a></span></p>
</div>