<?php
	/**
		Plugin Name: MyTube PlayList
		Author: Raghu Goriya
		Version:1.0.1
		Description: Displays awesome YouTube Videos in your posts, pages, and widgets. YouTube Embed plugin is an convenient tool for adding video to your website.
		
	*/

/************ Initialization of Variable and Path ***************/

session_start();
error_reporting(0);
global $icon_url,$plugin_dir_name,$num_rec_per_page,$loader;
$icon_url = plugin_dir_url( __FILE__ ).'/assets/images/logo_thumb.png'; 
$plugin_dir_name = explode('/',plugin_basename(__FILE__));
$plugin_dir_name = $plugin_dir_name[0];

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
	add_option( 'mytube_apikey', '');
	add_option( 'mytube_open_type', 'popup' );
	add_option( 'mytube_column', '3');
	add_option( 'mytube_viewsCounter', 'yes' );
	add_option( 'mytube_videoDuration', 'yes' );
	add_option( 'mytube_maxResults','18' );
	add_option( 'mytube_pagination_type','numeric' );
	add_option( 'mytube_pagination_position', 'bottom' );
}	
function MyTube_pluginUninstall() {
	delete_option('mytube_apikey');
	delete_option('mytube_open_type');
	delete_option('mytube_column');
	delete_option('mytube_viewsCounter');
	delete_option('mytube_videoDuration');
	delete_option('mytube_maxResults');
	delete_option('mytube_pagination_type');
	delete_option('mytube_pagination_position');
}

/************ // Call this function when plugin activate ***************/

/************ Create Admin Menu ***************/

add_action('admin_menu', 'MyTube_admin_menu');

function MyTube_admin_menu() {
    
	$icon_url = plugin_dir_url( __FILE__ ).'/assets/images/menu-icon.png';
    global $wpdb;
 	add_menu_page( 'MyTube', 'MyTube','', __FILE__, '',$icon_url,15 );
	//add_options_page('MyTube List', $menu_title, $capability, $menu_slug, $function);
	add_submenu_page( __FILE__, 'Global Settings', 'Global Settings', 'manage_options','mytube_settings', 'MyTube_management_settings' );
	//add_options_page('MyTube Playlist', 'MyTube Playlist', 'manage_options',__FILE__.'_settings', 'MyTube_management_settings' );
	add_submenu_page( '', 'Save Category', 'Save Category', 'manage_options','mytube_savedata', 'MyTube_save_data' );
	
}

/************ // Create Admin Menu ***************/

/************ Calling of Function From Menu ***************/

function MyTube_management_settings(){
	global $wpdb,$current_user;
	wp_enqueue_style( 'backend_style', plugins_url( 'assets/css/backend_style.css' , __FILE__ ));
	include('include/page-settings.php');
	?>
	<script>
        jQuery(document).ready(function(){
			setInterval( function(){
            	jQuery("#setting-error-settings_updated").slideUp(1000)
			},5000);
        });
    </script>
    <?php
}
function MyTube_save_data(){
	global $wpdb,$current_user;
	include('include/savedata.php');
}

/************ // Calling of Function From Menu ***************/

/************ Short Code ***************/

function MyTube_get_request_url()
{
    return MyTube_get_request_scheme() . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function MyTube_get_request_scheme()
{
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
}

function MyTube_list_gallery($atts){
	wp_enqueue_style( 'colorboxcss', plugins_url( 'assets/css/colorbox.css' , __FILE__ ));
	wp_enqueue_style( 'mytube_list', plugins_url( 'assets/css/mytube_list.css' , __FILE__ ));
	wp_enqueue_script( 'colorboxjs', plugins_url( 'assets/js/jquery.colorbox.js' , __FILE__ ) , array('jquery'));
	
	?>
	<script>
        jQuery(document).ready(function(){
            jQuery(".mytube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
        });
    </script>
    <?php
	
	$APIKEY = get_option( 'mytube_apikey' );
	$mytube_playlistid = get_option( 'mytube_playlistid' );
	$openType = get_option( 'mytube_open_type' );
	$displayColumns = get_option( 'mytube_column' );
	$viewsCounter = get_option( 'mytube_viewsCounter' );
	$videoDuration = get_option( 'mytube_videoDuration' );
	$maxVideoList = get_option( 'mytube_maxResults' );
	
	$pagination_position = get_option( 'mytube_pagination_position' );
		
	extract(shortcode_atts(array(
								'playlistid' => $mytube_playlistid,
								'maxrecord' => $maxVideoList,
								'columns' => $displayColumns,
						   ), $atts));

	//$playlistId = $atts['playlistid'];
 	
	
	if($APIKEY==""){
		return "You not set your Google Account API KEY in MyTube List Setting Page. Please Enter Google Account API KEY First. If you have not Google Account API KEY then <a href='https://developers.google.com/api-client-library/python/guide/aaa_apikeys' target='_blank'>Click Here</a>";
	}
	$pageTokenNP = $_GET['paget'];
	if(!isset($pageTokenNP)){
		$jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,status,contentDetails&maxResults={$maxrecord}&playlistId={$playlistid}&key={$APIKEY}&order=date");
	}else{
		$jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,status,contentDetails&pageToken={$pageTokenNP}&maxResults={$maxrecord}&playlistId={$playlistid}&key={$APIKEY}&order=date");
	}
	$json = json_decode($jsonURL);
	$items = $json->{'items'};
	$i=1;
	if(!isset($pageTokenNP)){
	
		$_SESSION["NEXTPAGE"] = $json->{'nextPageToken'};
	}
	$nextPage = $json->{'nextPageToken'};
	$prevPage = $json->{'prevPageToken'};
	
	if(count($_GET)<1){
		$qSign = MyTube_get_request_url().'?';
	}
	else{
		$qSign1 = MyTube_get_request_url();
		if(isset($pageTokenNP)){
			$qSign = strstr($qSign1,"paget",true);
		}else{
			$qSign = MyTube_get_request_url().'&';
		}
	}
	if($maxrecord!=$_SESSION['oldPageCount']){
		unset($_SESSION['jsonNumSession']);
	}
	$_SESSION['oldPageCount'] = $maxrecord;
	
	$numOfPagination = ceil($json->{'pageInfo'}->{'totalResults'}/$json->{'pageInfo'}->{'resultsPerPage'});
	
	if($numOfPagination>1){
		$numPages = array();
		$nextNumPage = $_SESSION["NEXTPAGE"];
		
			if(!isset($_SESSION['jsonNumSession'])){
				for($i=2;$i<=$numOfPagination;$i++){
					array_push($numPages,$nextNumPage);	
					$jsonURLNum = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&pageToken={$nextNumPage}&maxResults={$maxrecord}&playlistId={$playlistid}&key={$APIKEY}&order=date");
					$jsonNum = json_decode($jsonURLNum);
					
					$nextNumPage = $jsonNum->{'nextPageToken'};
					if($i==2){
						$_SESSION["PREVPAGE"] = $jsonNum->{'prevPageToken'};
					}
				}
				$_SESSION['jsonNumSession'] = $numPages;
			}
			else{
				$numPages = $_SESSION['jsonNumSession'];
			}
	}
	
	if($pagination_position=="both" || $pagination_position=="top"){
		MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage);
	}
	if($displayColumns==2){ $defaultColumns = "mytubeListTwo"; }
	else if($displayColumns==3){ $defaultColumns = "mytubeListThree"; }
	else if($displayColumns==4){ $defaultColumns = "mytubeListFour"; }
	
	if($columns==2){ $classColumns = "mytubeListTwo"; }
	else if($columns==3){ $classColumns = "mytubeListThree"; }
	else if($columns==4){ $classColumns = "mytubeListFour"; }
	else{ $classColumns = $defaultColumns; }
	?>
	<ul class="mytubeListWrapper <?php echo $classColumns; ?>" >
    <?php
	foreach($items as $itm){
		$video_ID = $itm->{'snippet'}->{'resourceId'}->{'videoId'};
		$videoJsonURL1 = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video_ID}&part=statistics,contentDetails&key={$APIKEY}");
		$videoJsonURL = json_decode($videoJsonURL1);
		
		$views = $videoJsonURL->{'items'}[0]->{'statistics'}->{'viewCount'};
		$time1 = $videoJsonURL->{'items'}[0]->{'contentDetails'}->{'duration'};
		
		$date = new DateTime('1970-01-01');
		$date->add(new DateInterval($time1));
		$videoTime 	=  $date->format('H:i:s');
		
		$videoViews = number_format($views,0,'.',',');
?>		
		<li>
			<a <?php if($openType=="popup"){ ?>class="mytube" <?php }else { echo 'target="_blank"'; } ?> href="http://www.youtube.com/embed/<?php echo $video_ID; ?>?rel=0&amp;wmode=transparent" title="<?php echo $itm->{'snippet'}->{'title'}; ?> [<?php echo $videoTime; ?>] <?php ?>">
            	<img src="<?php echo $itm->{'snippet'}->{'thumbnails'}->{'medium'}->{'url'}; ?>">
				<?php echo $itm->{'snippet'}->{'title'}; ?>
				<?php if($videoDuration=="yes"){ ?>[<?php echo $videoTime; ?>] <?php } ?>
            </a>
			<?php if($viewsCounter=="yes"){ ?> <span class="mytubeListView" title="<?php echo $videoViews; ?> Views"><?php echo $videoViews; ?></span> <?php } ?>
		</li>
<?php  } ?>
	</ul>
<?php
	if($pagination_position=="both" || $pagination_position=="bottom"){
		MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage);
	}
}

function MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage){
	echo '<div class="paginationWrap">';
	$arrayValue = $numPages;
	$countTotalPage = count($numPages);
	$pagination_type = get_option( 'mytube_pagination_type' );
	
	if($countTotalPage>1){
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
							for($j=$key+1;$j>=($key-7);$j--){
								if(($key-$j)+2==1){
									echo '<a href="'.$qSign.'">'.$i++.'</a>';
								}else{
									if($arrayValue[$key-$j]==$pageTokenNP){$class = 'class="active"';}else{$class='';};
									echo '<a '.$class.' href="'.$qSign.'paget='.$arrayValue[$key-$j].'">'.(($key-$j)+2).'</a>';
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
add_shortcode("mytube", "MyTube_list_gallery");

/*************** // Short Code ****************/
?>