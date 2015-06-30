<?php
	/**
		Plugin Name: MyTube PlayList
		Author: Raghu Goriya
		Author URI: http://tes-india.com/
		Version:2.0.1
		Description: Displays awesome YouTube Videos in your posts, pages, and widgets. YouTube Embed plugin is an convenient tool for adding video to your website. Create your own playlist on MyTube PlayList using channel id and also video id.
		License: GPL2
	*/

/************ Initialization of Variable and Path ***************/

session_start();
error_reporting(0);
global $icon_url,$plugin_dir_name,$num_rec_per_page,$loader;
$icon_url = plugin_dir_url( __FILE__ ).'/assets/images/logo_thumb.png'; 
$plugin_dir_name = explode('/',plugin_basename(__FILE__));
$plugin_dir_name = $plugin_dir_name[0];

header( 'Content-Type: text/html; charset=utf-8' ); 
	
/************ //Initialization of Variable and Path ***************/

/************ Set Setting Link on Installed Plugins ***************/
add_filter('plugin_action_links', 'MyTube_plugin_action_links', 10, 2);

function MyTube_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        // The "page" query string value must be equal to the slug
        // of the Settings admin page we defined earlier, which in
        // this case equals "myplugin-settings".
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=mytube_settings">Settings</a>';
        array_unshift($links, $settings_link);
    }

    return $links;
}
/************ //Set Setting Link on Installed Plugins ***************/

/************ Call this function when plugin activate ***************/

register_activation_hook(__FILE__,'MyTube_plugin_install');
register_uninstall_hook( __FILE__, 'MyTube_pluginUninstall' );

function MyTube_plugin_install() {
	global $wpdb,$current_user;
	include('include/mytube_url_act_data.php');
}	
function MyTube_pluginUninstall() {
	global $wpdb,$current_user;
	include('include/mytube_url_uninstall_data.php');
}

/************ // Call this function when plugin activate ***************/

/************ Create Admin Menu ***************/

add_action('admin_menu', 'MyTube_admin_menu');

function MyTube_admin_menu() {
    
	$icon_url = plugin_dir_url( __FILE__ ).'/assets/images/menu-icon.png';
    global $wpdb;
 	add_menu_page( 'MyTube', 'MyTube','', __FILE__, '',$icon_url,15 );
	add_submenu_page( __FILE__, 'Global Settings', 'Global Settings', 'manage_options','mytube_settings', 'MyTube_management_settings' );
	add_submenu_page( __FILE__, 'Create PlayList', 'Create PlayList', 'manage_options','mytube_select_videos', 'MyTube_create_playlist_by_channel_id' );
	add_submenu_page( __FILE__, 'View PlayList', 'My PlayList', 'manage_options','mytube_change_videos', 'MyTube_change_playlist_by_id' );
	add_submenu_page( '', 'Edit PlayList', 'Edit PlayList', 'manage_options','mytube_edit_videos', 'MyTube_edit_playlist_by_id' );
	add_submenu_page( '', 'Save Category', 'Save Category', 'manage_options','mytube_savedata', 'MyTube_save_data' );
}

/************ // Create Admin Menu ***************/

/************ Update Notice **************/
$file   = basename( __FILE__ );
$folder = basename( dirname( __FILE__ ) );
$hook = "in_plugin_update_message-{$folder}/{$file}";
add_action( $hook, 'mytube_update_message', 10, 2 ); 

function mytube_update_message( $plugin_data, $r )
{
    echo 'Major changes are available in the new version of MyTube PlayList';
}
/************ //Update Notice **************/

/************ Calling of Function From Menu ***************/
add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
	// first check that $hook_suffix is appropriate for your admin page
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}
function MyTube_management_settings(){
	global $wpdb,$current_user;
	wp_enqueue_style( 'backend_style', plugins_url( 'assets/css/backend_style.css' , __FILE__ ));
	
	include('pages/page-settings.php');
	?>
	<script type="text/javascript">
        jQuery(document).ready(function($){
			setInterval( function(){
            	jQuery("#setting-error-settings_updated").slideUp(1000)
			},5000);
        	$('.mytube-title-text-color').wpColorPicker();
			$('.mytube-title-hover-color').wpColorPicker();
			$('.mytube-view-text-color').wpColorPicker();
			$('.mytube_view_bg_color').wpColorPicker();
			$('.mytube_border_color').wpColorPicker();
			$('.mytube_pg_bg_color').wpColorPicker();
			$('.mytube_pg_text_color').wpColorPicker();
			$('.mytube_pg_border_color').wpColorPicker();
			$('.mytube_pg_border_hover_color').wpColorPicker();
			$('.mytube_pg_act_bg_color').wpColorPicker();
			$('.mytube_pg_act_text_color').wpColorPicker();
			$('.mytube_pg_hover_bg_color').wpColorPicker();
			$('.mytube_pg_hover_text_color').wpColorPicker();
		});
		function check_before_install(){
			if(jQuery('#mytube_channelid').val()=='' || jQuery('#mytube_channelid').val()!='<?php echo get_option( 'mytube_channelid' ); ?>'){
				alert('Save Channel ID First Then Create MyTube Pages.');
				return false;
			}else{
				if(confirm('Are you sure to create New Pages for MyTube Channel and PlayList Videos?')){
					jQuery('#frmGlobalSettings').submit();
				}else{
					return false;
				}
			}	
		}
    </script>
    <?php
}
function MyTube_save_data(){
	global $wpdb,$current_user;
	include('include/savedata.php');
}

/************ // Calling of Function From Menu ***************/

/************ Create playlist with selected from channel ID **************/

function MyTube_create_playlist_by_channel_id(){
	global $wpdb,$current_user;
	wp_enqueue_style( 'backend_style', plugins_url( 'assets/css/backend_style.css' , __FILE__ ));
	include('pages/create_playlist_by_channel_id.php');
?>
	<script type="text/javascript">
	var $ = jQuery;
		jQuery(document).ready(function() {
			jQuery('#ownPlayListAll').click(function(event) {  //on click
				if(jQuery(this).is(':checked')) { // check select status
					jQuery('.ownPlayList').each(function(index, element) {
                       jQuery(this).prop('checked',true) 
                    });
				}else{
					jQuery('.ownPlayList').each(function(index, element) {
                       jQuery(this).prop('checked',false) 
                    });
				}
			});
			
			jQuery('.ownPlayList').click(function(){
				if(jQuery('#ownPlayListAll').is(':checked')) {
					jQuery('#ownPlayListAll').prop('checked',false);
				}
				else{
					//return false;
				}
			});
			
			jQuery("#channelPlayList").click(function(){
				var channelId = jQuery("#channelId").val();
				if(channelId==''){
					jQuery('#channelErrMsgDisplay').html('Please Enter Channel ID.');
					return false;
				}
			});
			
			jQuery("#videoPlayList").click(function(event){
				var videoId = jQuery("#videoId").val();
				var videoPlayListName = jQuery("#videoPlayListName").val();
				
				if(videoId==''){
					jQuery('#videoErrMsgDisplay').html('Please Enter Video ID.');
					return false;
				}
				else if(videoPlayListName==''){
					jQuery('#videoErrMsgDisplay').html('Please Enter PlayList Name.');
					return false;
				}
				else {
					jQuery.ajax({
						type: "post",
						url: "<?php echo plugin_dir_url( __FILE__ ); ?>ajax/chk_play_list_name.php",
						data: 'playListName='+videoPlayListName,
						async: false,
						success: function(playlistid){
							if(playlistid != ""){
								jQuery('#videoErrMsgDisplay').html( videoPlayListName + ' playlist name already exist. Would you like to edit? <a href="?page=mytube_edit_videos&playlistid=' + playlistid + '">Click Here</a>' );
								event.preventDefault();
							}
						}
					});
				}
			});
			
			
			jQuery("#frmVideos").submit(function(event){
				var chkPlayListIsChecked = jQuery('input[name="ownPlayList[]"]:checked').length;
				var playListName = jQuery('#mtCreatePlayListName').val();
				if(chkPlayListIsChecked == false || chkPlayListIsChecked < 1 ){
					jQuery('#errMsgDisplay').html('Please Select Videos.');
					return false;
				}
				<?php if( ! isset($_GET['addplaylistid'])){ ?>
					if(playListName == '' ){
						jQuery('#errMsgDisplay').html('Please Enter Playlist Name.');
						return false;
					}
					else {
						jQuery.ajax({
							type: "post",
							url: "<?php echo plugin_dir_url( __FILE__ ); ?>ajax/chk_play_list_name.php",
							data: 'playListName='+playListName,
							async: false,
							success: function(playlistid){
								if(playlistid != ""){
									jQuery('#errMsgDisplay').html( playListName + ' playlist name already exist. Would you like to edit? <a href="?page=mytube_edit_videos&playlistid=' + playlistid + '">Click Here</a>' );
									event.preventDefault();
								}
								else{
									$( "#frmVideos" ).submit();	
								}
							}
						});
					}
				<?php } ?>
			});
		});
	</script>
<?php
}

function MyTube_change_playlist_by_id(){
	global $wpdb,$current_user;
	wp_enqueue_style( 'backend_style', plugins_url( 'assets/css/backend_style.css' , __FILE__ ));
	include('pages/change_playlist_by_id.php');	
}
function MyTube_edit_playlist_by_id(){
	global $wpdb,$current_user;
	wp_enqueue_style( 'backend_style', plugins_url( 'assets/css/backend_style.css' , __FILE__ ));
	include('pages/edit_playlist.php');
?>
	<script type="text/javascript">
	var $ = jQuery;
		jQuery(document).ready(function() {
			jQuery('#ownPlayListAll').click(function(event) {  //on click
				if(jQuery(this).is(':checked')) { // check select status
					jQuery('.ownPlayList').each(function(index, element) {
                       jQuery(this).prop('checked',true) 
                    });
				}else{
					jQuery('.ownPlayList').each(function(index, element) {
                       jQuery(this).prop('checked',false) 
                    });
				}
			});
			
			jQuery('.ownPlayList').click(function(){
				if(jQuery('#ownPlayListAll').is(':checked')) {
					jQuery('#ownPlayListAll').prop('checked',false);
				}
				else{
					//return false;
				}
			});
			jQuery("#frmVideos").submit(function(event){
				var playListName = jQuery('#playListName').val();
				if(playListName == '' ){
					jQuery('#errMsgDisplay').html('Please Enter Playlist Name.');
					event.preventDefault();
				}
			});
		
		});
	</script>
<?php
}

/************ // Create playlist with selected from channel ID **************/

/************ Short Code ***************/

function MyTube_get_request_url()
{
    return MyTube_get_request_scheme() . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function MyTube_get_request_scheme()
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
}
// Curl helper function
function curl_get($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	$return = curl_exec($curl);
	curl_close($curl);
	return $return;
}
function formatSeconds( $seconds )
{
	$hours = 0;
	$milliseconds = str_replace( "0.", '', $seconds - floor( $seconds ) );
	
	if ( $seconds > 3600 ){
		$hours = floor( $seconds / 3600 );
	}
	$seconds = $seconds % 3600;
	
	return str_pad( $hours, 2, '0', STR_PAD_LEFT )
	   . gmdate( ':i:s', $seconds )
	   . ($milliseconds ? ".$milliseconds" : '')
	;
}	

// Register Style
function simpleTestimonial() {
	?>
	<style>
		<?php include('assets/css/mytube_list_css.php'); ?>
	</style>
    <?php
	wp_enqueue_style( 'mytubecolorboxcss', plugins_url( 'assets/css/colorbox.css' , __FILE__ ), false ); 
	//wp_enqueue_style( 'mytubecolorboxcss', plugins_url( 'assets/css/colorbox.css' , __FILE__ ));
	//wp_enqueue_style( 'mytube_list', plugins_url( 'assets/css/mytube_list_css.php' , __FILE__ ));
	//wp_enqueue_style( 'mytube_list', plugins_url( 'assets/css/mytube_list.css' , __FILE__ ));
	wp_enqueue_script( 'mytubecolorboxjs', plugins_url( 'assets/js/jquery.colorbox.js' , __FILE__ ) , array('jquery'));
	
	
	
}
// Hook into the 'wp_enqueue_scripts' action
add_action( 'wp_enqueue_scripts', 'simpleTestimonial' );

function mytube_footer_script() { ?>
   <script>
        jQuery(document).ready(function(){
            jQuery(".mytube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
        });
    </script>
<?php }
add_action( 'wp_footer', 'mytube_footer_script' );



function MyTube_common(){
	global $APIKEY,$mytube_playlistid,$mytube_channelid,$mytube_vimeo_channel_id,$openType,$displayColumns,$viewsCounter,$videoDuration,$maxVideoList,$mytube_latest_videos_num,$pagination_position;
	
	$APIKEY = get_option( 'mytube_apikey' );
	$mytube_playlistid = get_option( 'mytube_playlistid' );
	$mytube_channelid = get_option( 'mytube_channelid' );
	$mytube_vimeo_channel_id = get_option( 'mytube_vimeo_channel_id' );
	$openType = get_option( 'mytube_open_type' );
	$displayColumns = get_option( 'mytube_column' );
	$viewsCounter = get_option( 'mytube_viewsCounter' );
	$videoDuration = get_option( 'mytube_videoDuration' );
	$maxVideoList = get_option( 'mytube_maxResults' );
	//$mytube_latest_videos_num = get_option( 'mytube_latest_videos_num' );
	$pagination_position = get_option( 'mytube_pagination_position' );
		
}
function MyTube_youtube_list_gallery($atts){
	MyTube_common();
	global $wpdb,$current_user,$APIKEY,$mytube_playlistid,$mytube_channelid,$mytube_vimeo_channel_id,$openType,$displayColumns,$viewsCounter,$videoDuration,$maxVideoList,$pagination_position;
	include('include/youtubedata.php');
}
function MyTube_vimeo_list_gallery($atts){
	MyTube_common();
	global $wpdb,$current_user,$APIKEY,$mytube_playlistid,$mytube_channelid,$mytube_vimeo_channel_id,$openType,$displayColumns,$viewsCounter,$videoDuration,$maxVideoList,$pagination_position;
	include('include/vimeodata.php');
}

function MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage){
	echo '<div class="paginationWrap">';
	$arrayValue = $numPages;
	$countTotalPage = count($numPages);
	$pagination_type = get_option( 'mytube_pagination_type' );
	
	if($countTotalPage>=1){
		if($pagination_type=="np"){
			if($prevPage!=""){
				echo '<a href="'.$qSign.'paget='.$prevPage.'" title="Previous">Previous</a>';
			}
			if($nextPage!=""){
				echo '<a href="'.$qSign.'paget='.$nextPage.'" title="Next">Next</a>';
			}
		}else{
			$i=1;
			
			echo '<a href="'.$qSign.'" title="Go To Page First">First</a>';
			foreach($numPages as $key=>$numPage){
				if(isset($pageTokenNP)){
					if($numPage==$pageTokenNP)
					{
						if($key>5){
							for($j=4;$j>=1;$j--){
								echo '<a href="'.$qSign.'paget='.$arrayValue[$key-$j].'">'.(($key-$j)+2).'</a>';
							}
			
							if($arrayValue[$key]==$pageTokenNP){$class = 'class="active"';}else{$class='';};
							echo '<a '.$class.' href="'.$qSign.'paget='.$arrayValue[$key].'">'.(($key)+2).'</a>';
			
							for($j=1;$j<=4;$j++){
								if(($key+$j+1)<=$countTotalPage){
									echo '<a href="'.$qSign.'paget='.$arrayValue[$key+$j].'">'.(($key+$j)+2).'</a>';
								}
							}
						}
						else if($key<6){
							$lessThanEight=1;
							for($j=$key+1;$j>=($key-7);$j--){
								if(($key-$j)+2==1){
									echo '<a href="'.$qSign.'">'.$i++.'</a>';
								}else{
									if($arrayValue[$key-$j]==$pageTokenNP){$class = 'class="active"';}else{$class='class=a';};
									if(($countTotalPage-1)>=($lessThanEight-1)){	$lessThanEight++;
										echo '<a '.$class.' href="'.$qSign.'paget='.$arrayValue[$key-$j].'">'.(($key-$j)+2).'</a>';
									}
								}
							}
						}
					}
					
				}
				else{
					if($key<8){
						if($i==1){
							echo '<a class="active" href="'.$qSign.'paget='.$_SESSION["PREVPAGE"].'">'.$i++.'</a>';
						}
						echo '<a href="'.$qSign.'paget='.$numPage.'">'.($key+2).'</a>';
					}
				}
				
			}
			echo '<a href="'.$qSign.'paget='.$arrayValue[$countTotalPage-1].'" title="Last Page Number '.($countTotalPage+1).'">Last</a>';
		}
	}
	echo "</div>";
}

add_shortcode("mytube", "MyTube_youtube_list_gallery");
add_shortcode("myvimeo", "MyTube_vimeo_list_gallery");

function covtime($youtube_time) {
    preg_match_all('/(\d+)/',$youtube_time,$parts);

    // Put in zeros if we have less than 3 numbers.
    if (count($parts[0]) == 1) {
        array_unshift($parts[0], "0", "0");
    } elseif (count($parts[0]) == 2) {
        array_unshift($parts[0], "0");
    }

    $sec_init = $parts[0][2];
    $seconds = $sec_init%60;
    $seconds_overflow = floor($sec_init/60);

    $min_init = $parts[0][1] + $seconds_overflow;
    $minutes = ($min_init)%60;
    $minutes_overflow = floor(($min_init)/60);

    $hours = $parts[0][0] + $minutes_overflow;

    if($hours != 0)
        return $hours.':'.$minutes.':'.$seconds;
    else
        return $minutes.':'.$seconds;
}

/*************** // Short Code ****************/
?>