<?php
	
	global $wpdb,$current_user,$mtpl_plugin_dir_name,$mtpl_num_rec_per_page,$mtpl_loader,$mtpl_icon_url,$youtube_icon_url,$vimeo_icon_url,$css_icon_url;

	$mtpl_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/menu-icon.png';
	$youtube_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/youtube.gif';
	$vimeo_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/vimeo_icon.png'; 
	$css_icon_url = WP_PLUGIN_URL.'/'.$mtpl_plugin_dir_name.'/assets/images/css-24.ico'; 
	
	if (isset($_GET["ppage"])) { $ppage  = $_GET["ppage"]; } else { $ppage=1; }; 
	
	$start_from = ($ppage-1) * $mtpl_num_rec_per_page; 
	/*$sql = "SELECT * 
			FROM ".$wpdb->prefix."yl_videos LIMIT $start_from, $mtpl_num_rec_per_page"; 
	
	$getVideos = $wpdb->get_results($sql);
	*/

?>

<div class="wrapMyTube">

		<?php if($_GET['settings-updated']){ ?>
        	<div class="updated settings-error" id="setting-error-settings_updated"> 
				<p><strong>Settings saved.</strong></p>
	        </div>
        <?php } ?>
        <?php if($_GET['settings-restore']){ ?>
        	<div class="updated settings-error" id="setting-error-settings_updated"> 
				<p><strong>Settings Restored Successfully.</strong></p>
	        </div>
        <?php } ?>
        <?php if($_GET['settings-create']){ ?>
        	<div class="updated settings-error" id="setting-error-settings_updated"> 
				<p><strong>MyTube Pages Created Successfully.</strong></p>
	        </div>
        <?php } ?>
        
        
        <form action="?page=mytube_savedata" method="post" id="frmGlobalSettings">
        	<h2>
            	<img src="<?php echo $mtpl_icon_url; ?>" /> MyTube Global Settings
            	<span class="h2RightSpanSection">
                	<input type="submit" class="button button-primary" name="createNewPage" id="createNewPage" onclick="return check_before_install();" value="Create MyTube Pages" />
                </span>
            </h2>	

            <table class="form-table">
                <tr>
                    <th scope="row">Video open with</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">	<span>Video open with :</span>	</legend>
                            <label title="Open With Popup"> <input type="radio" id="mytube_open_type1" name="mytube_open_type" <?php if(get_option( 'mytube_open_type' )=="popup"){ echo "checked='checked'"; } ?> value="popup"/><span>Popup</span></label>
                            <br />
                            <label title="Open With Popup"> <input type="radio" id="mytube_open_type2" name="mytube_open_type" <?php if(get_option( 'mytube_open_type' )=="newtab"){ echo "checked='checked'"; } ?> value="newtab"/><span>New Tab</span></label>
                        </fieldset>
                    </td>
                    <th scope="row">Number of Column</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">	<span>Number of Column</span>	</legend>
                            <label title="Display Records in 2 Columns"><input type="radio" id="mytube_column2" name="mytube_column" <?php if(get_option( 'mytube_column' )==2){ echo "checked='checked'"; } ?> value="2"/><span>Two</span></label>
                            <br />
                            <label title="Display Records in 3 Columns"><input type="radio" id="mytube_column3" name="mytube_column" <?php if(get_option( 'mytube_column' )==3){ echo "checked='checked'"; } ?> value="3"/><span>Three</span></label>
                            <br />
                            <label title="Display Records in 4 Columns"><input type="radio" id="mytube_column4" name="mytube_column" <?php if(get_option( 'mytube_column' )==4){ echo "checked='checked'"; } ?> value="4"/><span>Four</span></label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Display Views Counter</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">	<span>Display Views Counter</span>	</legend>
                            <label title="Display Views Counter on Video Image"> <input type="radio" id="mytube_viewsCounter1" name="mytube_viewsCounter" <?php if(get_option( 'mytube_viewsCounter' )=="yes"){ echo "checked='checked'"; } ?> value="yes"/><span>Yes</span></label>
                            <br />
                            <label title="Hide Views Counter on Video Image"> <input type="radio" id="mytube_viewsCounter2" name="mytube_viewsCounter" <?php if(get_option( 'mytube_viewsCounter' )=="no"){ echo "checked='checked'"; } ?> value="no"/><span>No</span></label>
                        </fieldset>
                    </td>
                   <th scope="row">Display Video Duration</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">	<span>Display Video Duration</span>	</legend>
                            <label title="Display Video Duration with Video Name"> <input type="radio" id="mytube_videoDuration1" name="mytube_videoDuration" <?php if(get_option( 'mytube_videoDuration' )=="yes"){ echo "checked='checked'"; } ?> value="yes"/><span>Yes</span></label>
                            <br />
                            <label title="Hide Video Duration with Video Name"> <input type="radio" id="mytube_videoDuration2" name="mytube_videoDuration" <?php if(get_option( 'mytube_videoDuration' )=="no"){ echo "checked='checked'"; } ?> value="no"/><span>No</span></label>
                        </fieldset>
                    </td>
                </tr>
			</table>
                
            <h2><img src="<?php echo $youtube_icon_url; ?>" /> YouTube Global Settings</h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="mytube_apikey">Google Account Api Key</label></th>
                    <td><input type="text" name="mytube_apikey" id="mytube_apikey" size="50" value="<?php echo get_option( 'mytube_apikey' ); ?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mytube_playlistid">YouTube Play List ID</label></th>
                    <td><input type="text" name="mytube_playlistid" id="mytube_playlistid" size="50" value="<?php echo get_option( 'mytube_playlistid' ); ?>"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mytube_channelid">YouTube Channel ID</label></th>
                    <td><input type="text" name="mytube_channelid" id="mytube_channelid" size="50" value="<?php echo get_option( 'mytube_channelid' ); ?>"/></td>
                </tr>
            </table>
            <table class="form-table">
                <tr>
                    <th scope="row">Display Videos Per Page</th>
                    <td colspan="3">
                        <select name="mytube_maxResults" id="mytube_maxResults" style="padding:0 5px;">
                            <?php for($i=1;$i<=50;$i++){ ?>
                                    <option <?php if(get_option( 'mytube_maxResults' )==$i){echo "selected='selected'";} ?> value="<?php echo $i; ?>" style="padding:0 5px;"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                    </td>
               	</tr>
                <tr>
                    <th scope="row">Pagination Display like</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">	<span>Pagination Display like</span>	</legend>
                            <label title="Pagination With Next and Preview Button Only"> <input type="radio" id="mytube_pagination_type1" name="mytube_pagination_type" <?php if(get_option( 'mytube_pagination_type' )=="np"){ echo "checked='checked'"; } ?> value="np"/><span>Next and Previous</span></label>
                            <br />
                            <label title="Pagination With First,Last and Numeric Only"> <input type="radio" id="mytube_pagination_type2" name="mytube_pagination_type" <?php if(get_option( 'mytube_pagination_type' )=="numeric"){ echo "checked='checked'"; } ?> value="numeric"/><span>Numeric Pagination</span></label>
                        </fieldset>
                    </td>
                    <th scope="row">Pagination Position</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">	<span>Pagination Position</span>	</legend>
                            <label title="Set Pagination on Top Only"> <input type="radio" id="mytube_pagination_position2" name="mytube_pagination_position" <?php if(get_option( 'mytube_pagination_position' )=='top'){ echo "checked='checked'"; } ?> value="top"/><span>Top</span></label>
                            <br />
                            <label title="Set Pagination on Bottom Only"> <input type="radio" id="mytube_pagination_position3" name="mytube_pagination_position" <?php if(get_option( 'mytube_pagination_position' )=='bottom'){ echo "checked='checked'"; } ?> value="bottom"/><span>Bottom</span></label>
                            <br />
                            <label title="Set Pagination on Both Top and Bottom"> <input type="radio" id="mytube_pagination_position4" name="mytube_pagination_position" <?php if(get_option( 'mytube_pagination_position' )=='both'){ echo "checked='checked'"; } ?> value="both"/><span>Both (Top + Bottom)</span></label>
                        </fieldset>
                    </td>
                </tr>
           </table>
            
            <h2><img src="<?php echo $vimeo_icon_url; ?>" /> Vimeo Global Settings</h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="mytube_vimeo_channel_id">Vimeo Channel ID</label></th>
                    <td><input type="text" name="mytube_vimeo_channel_id" id="mytube_vimeo_channel_id" size="50" value="<?php echo get_option( 'mytube_vimeo_channel_id' ); ?>"/></td>
                </tr>
        	</table>
            
            <h2><img src="<?php echo $css_icon_url; ?>" /> CSS Settings</h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="mytube_text_size">Text Size</label></th>
                    <td><input type="text" name="mytube_text_size" id="mytube_text_size" size="7" value="<?php echo get_option( 'mytube_text_size' ); ?>" />px</td>
                    <th scope="row"><label for="mytube_border_color">Border Color</label></th>
                    <td><input type="text" name="mytube_border_color" id="mytube_border_color" value="<?php echo get_option( 'mytube_border_color' ); ?>" class="mytube_border_color"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mytube_text_color">Title Text Color</label></th>
                    <td><input type="text" name="mytube_text_color" id="mytube_text_color" value="<?php echo get_option( 'mytube_text_color' ); ?>" class="mytube-title-text-color"/></td>
                    <th scope="row"><label for="mytube_text_hover_color">Title Text Hover Color</label></th>
                    <td><input type="text" name="mytube_text_hover_color" id="mytube_text_hover_color" value="<?php echo get_option( 'mytube_text_hover_color' ); ?>" class="mytube-title-hover-color"/></td>
                </tr>
        	    <tr>
                    <th scope="row"><label for="mytube_view_text_color">View Count Text Color</label></th>
                    <td><input type="text" name="mytube_view_text_color" id="mytube_view_text_color" value="<?php echo get_option( 'mytube_view_text_color' ); ?>" class="mytube-view-text-color"/></td>
                    <th scope="row"><label for="mytube_view_bg_color">View Count Background Color</label></th>
                    <td><input type="text" name="mytube_view_bg_color" id="mytube_view_bg_color" value="<?php echo get_option( 'mytube_view_bg_color' ); ?>" class="mytube_view_bg_color"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mytube_pg_bg_color">Pagination Background Color</label></th>
                    <td><input type="text" name="mytube_pg_bg_color" id="mytube_pg_bg_color" value="<?php echo get_option( 'mytube_pg_bg_color' ); ?>" class="mytube_pg_bg_color"/></td>
                    <th scope="row"><label for="mytube_pg_text_color">Pagination Text Color</label></th>
                    <td><input type="text" name="mytube_pg_text_color" id="mytube_pg_text_color" value="<?php echo get_option( 'mytube_pg_text_color' ); ?>" class="mytube_pg_text_color" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mytube_pg_border_color">Pagination Border Color</label></th>
                    <td><input type="text" name="mytube_pg_border_color" id="mytube_pg_border_color" value="<?php echo get_option( 'mytube_pg_border_color' ); ?>" class="mytube_pg_border_color"/></td>
                    <th scope="row"><label for="mytube_pg_border_hover_color">Pagination Border Hover Color</label></th>
                    <td><input type="text" name="mytube_pg_border_hover_color" id="mytube_pg_border_hover_color" value="<?php echo get_option( 'mytube_pg_border_hover_color' ); ?>" class="mytube_pg_border_hover_color" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mytube_pg_hover_bg_color">Pagination Hover Background Color</label></th>
                    <td><input type="text" name="mytube_pg_hover_bg_color" id="mytube_pg_hover_bg_color" value="<?php echo get_option( 'mytube_pg_hover_bg_color' ); ?>" class="mytube_pg_hover_bg_color"/></td>
                    <th scope="row"><label for="mytube_pg_hover_text_color">Pagination Hover Text Color</label></th>
                    <td><input type="text" name="mytube_pg_hover_text_color" id="mytube_pg_hover_text_color" value="<?php echo get_option( 'mytube_pg_hover_text_color' ); ?>" class="mytube_pg_hover_text_color" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mytube_pg_act_bg_color">Pagination Active Background Color</label></th>
                    <td><input type="text" name="mytube_pg_act_bg_color" id="mytube_pg_act_bg_color" value="<?php echo get_option( 'mytube_pg_act_bg_color' ); ?>" class="mytube_pg_act_bg_color"/></td>
                    <th scope="row"><label for="mytube_pg_act_text_color">Pagination Active Text Color</label></th>
                    <td><input type="text" name="mytube_pg_act_text_color" id="mytube_pg_act_text_color" value="<?php echo get_option( 'mytube_pg_act_text_color' ); ?>" class="mytube_pg_act_text_color" /></td>
                </tr>                
            </table>
            <p class="footer">
            	<input type="submit" class="button button-primary" name="mtSaveSettings" id="mtSaveSettings" value="Save Changes" />
                <input type="submit" class="button button-primary" name="mtRestoreSettings" id="mtRestoreSettings" onclick="if(confirm('Are you sure to restore Global Settings exclude Google Api Key?')){ jQuery('#frmGlobalSettings').submit();}else{return false;}" value="Restore to Default" />
                <span class="h2RightSpanSection">Don't forget to rate <a class="rateLink" href="https://wordpress.org/plugins/mytube/">MyTube PlayList Plugin.</a></span>
            </p>
		</form>
</div>