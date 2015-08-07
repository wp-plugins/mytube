<?php

	global $openType,$vID,$vTitle,$vDuration,$vThumbnail,$videoDuration,$viewsCounter,$vVideoViews;
	
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
	
	$videos = simplexml_load_string($this->curl_get($api_endpoint.'channel/' . $channelid . '/videos.xml'));
	//$info = simplexml_load_string(curl_get($api_endpoint . 'channel/' . $channel_id . '/info.xml'));
	
	/** @Hook Refer function start_vimeo_wrapper */
	do_action('mytube_vimeo_playlist_before');

		foreach ($videos->video as $video){
			$vID = $video->id;
			$vTitle = $video->title;
			$vDuration = $this->formatSeconds($video->duration);
			$vVideoViews = $video->stats_number_of_plays;
			if($vVideoViews==""){$vVideoViews=0;}
			$vThumbnail = $video->thumbnail_medium;
	
			/** @Hook Refer function list_vimeo_data */
			do_action('mytube_vimeo_playlist_data');
		 } 
		 
	/** @Hook Refer function stop_wrapper */
	do_action('mytube_youtube_playlist_after');	
	
/***** //Vimeo API *****/	