<?php
	global $classColumns,$mtpl_playlistid;
	
	extract(shortcode_atts(array(
		'playlistid' => '',
		'channelid' => '',
		'pageid' => '',
		'maxrecord' => $maxVideoList,
		'columns' => $displayColumns,
		'latestvideos' => '',
	), $atts));

	//$playlistId = $atts['playlistid'];
 	$mtpl_playlistid = $playlistid;
	
	if($displayColumns==2){ $defaultColumns = "mytubeListTwo"; }
	else if($displayColumns==3){ $defaultColumns = "mytubeListThree"; }
	else if($displayColumns==4){ $defaultColumns = "mytubeListFour"; }
	
	if($columns==2){ $classColumns = "mytubeListTwo"; }
	else if($columns==3){ $classColumns = "mytubeListThree"; }
	else if($columns==4){ $classColumns = "mytubeListFour"; }
	else{ $classColumns = $defaultColumns; }
	
	if($mtpl_playlistid!='' || $_GET['playlistid']){
		include('youtube_playlist_wise.php');
	}else if($channelid!=''){
		include('youtube_channel_wise.php');
	}else if($mtpl_playlistid==''){
		include('youtube_playlist_wise.php');
	}else if($mytube_channelid!=''){
		include('youtube_channel_wise.php');
	}
	