<?php
	extract(shortcode_atts(array(
		'channelid' => '',
		'columns' => $displayColumns,
	), $atts));

	//$playlistId = $atts['playlistid'];
 	
	if($displayColumns==2){ $defaultColumns = "mytubeListTwo"; }
	else if($displayColumns==3){ $defaultColumns = "mytubeListThree"; }
	else if($displayColumns==4){ $defaultColumns = "mytubeListFour"; }
	
	if($columns==2){ $classColumns = "mytubeListTwo"; }
	else if($columns==3){ $classColumns = "mytubeListThree"; }
	else if($columns==4){ $classColumns = "mytubeListFour"; }
	else{ $classColumns = $defaultColumns; }
	
	/***** Vimeo API *****/
	if($channelid==""){
		$channelid = $mytube_vimeo_channel_id;	
	}
	// The Simple API URL
	$api_endpoint = 'http://vimeo.com/api/v2/';
	
	// Load the user's videos
	
	$videos = simplexml_load_string(curl_get($api_endpoint.'channel/' . $channelid . '/videos.xml'));
	//$info = simplexml_load_string(curl_get($api_endpoint . 'channel/' . $channel_id . '/info.xml'));
	
?>	
	<ul class="mytubeListWrapper <?php echo $classColumns; ?> vimeoVid" >
	<?php foreach ($videos->video as $video){
			$vID = $video->id;
			$vTitle = $video->title;
			$vDuration = formatSeconds($video->duration);
			$vVideoViews = $video->stats_number_of_plays;
			if($vVideoViews==""){$vVideoViews=0;}
			$vThumbnail = $video->thumbnail_medium;
	?>
		<li>
			<a <?php if($openType=="popup"){ ?>class="mytube" <?php }else { echo 'target="_blank"'; } ?> href="https://player.vimeo.com/video/<?php echo $vID; ?>" title="<?php echo $vTitle; ?> [<?php echo $vDuration; ?>] <?php ?>">
				<img src="<?php echo $vThumbnail; ?>" width="320" height="180">
				<?php echo $vTitle; ?>
				<?php if($videoDuration=="yes"){ ?>[<?php echo $vDuration; ?>] <?php } ?>
			</a>
			<?php if($viewsCounter=="yes"){ ?> <span class="mytubeListView" title="<?php echo $vVideoViews; ?> Views"><?php echo $vVideoViews; ?></span> <?php } ?>
		</li>
	<?php } ?>
	</ul>	
<?php
/***** //Vimeo API *****/	