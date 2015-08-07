<?php
	global $mtpl_playlistid;
	global $openType,$video_ID,$itm,$videoJsonURL,$videoTime,$videoDuration,$viewsCounter,$videoViews;
	
	if(isset($_GET['playlistid'])){
		$playlistid = $_GET['playlistid'];
	}else if($playlistid==''){
		$playlistid = $mytube_playlistid;
	}
	
	$mtpl_playlistid = $playlistid;
	
	if($latestvideos!='')
	{
		if($latestvideos<1){
			$latestvideos = 3;
		}else if($latestvideos>50){
			$latestvideos = 50;
		}
	}
	
	$sqlplaylistid = $wpdb->prepare("SELECT `id` FROM `".$wpdb->prefix . "mytube_playlist` WHERE `playlistid`='".$mtpl_playlistid."'"); 
	$getPlatList = $wpdb->get_row($sqlplaylistid);
	$listId = $getPlatList->id;
	if(isset($listId) && $listId!=""){
		$getVideoSql = "SELECT `videoid` FROM `".$wpdb->prefix . "mytube_videos` WHERE `pid`='".$listId."'";
		$getVideos = $wpdb->get_results($getVideoSql);
		
		/** @Hook Refer function start_wrapper */
		do_action('mytube_youtube_playlist_before');

			$lv = $latestvideos;
            foreach($getVideos as $getVideo){
				if($latestvideos!=""){
					if($lv==0){
						break;
					}
					$lv--;
				}
                		
                		//if($itm->{'status'}->{'privacyStatus'}=="public"){
					$video_ID = $getVideo->videoid;
			                $videoJsonURL1 = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video_ID}&part=statistics,snippet,contentDetails&key={$APIKEY}");
			                $videoJsonURL = json_decode($videoJsonURL1);
			                
			                $views = $videoJsonURL->{'items'}[0]->{'statistics'}->{'viewCount'};
			                $time1 = $videoJsonURL->{'items'}[0]->{'contentDetails'}->{'duration'};
			                
			                $date = new DateTime('1970-01-01');
			                $date->add(new DateInterval($time1));
			                $videoTime 	=  $date->format('H:i:s');
			                
			                $videoViews = number_format($views,0,'.',',');
			        		
							/** @Hook Refer function list_mylist_data */
			                do_action('mytube_youtube_playlist_mylist');
				//}
    	  	}
			
		/** @Hook Refer function stop_wrapper */
		do_action('mytube_youtube_playlist_after');	

	}else {
		if($APIKEY==""){
			return "You not set your Google Account API KEY in MyTube List Setting Page. Please Enter Google Account API KEY First. If you have not Google Account API KEY then <a href='https://developers.google.com/api-client-library/python/guide/aaa_apikeys' target='_blank'>Click Here</a>";
		}
		$pageTokenNP = $_GET['paget'];
		if($latestvideos!=''){
			$maxrecord = $latestvideos;
		}
		if(!isset($pageTokenNP)){
			 $jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,status,contentDetails&maxResults={$maxrecord}&playlistId={$mtpl_playlistid}&key={$APIKEY}&order=date"); 
		}else{
			 $jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,status,contentDetails&pageToken={$pageTokenNP}&maxResults={$maxrecord}&playlistId={$mtpl_playlistid}&key={$APIKEY}&order=date");
		}
		$json = json_decode($jsonURL);
		//print_r($json);
		$items = $json->{'items'};
		$i=1;
		if(!isset($pageTokenNP)){
		
			$_SESSION["NEXTPAGE"] = $json->{'nextPageToken'};
		}
		$nextPage = $json->{'nextPageToken'};
		$prevPage = $json->{'prevPageToken'};
		
		if(count($_GET)<1){
			$qSign = $this->MyTube_get_request_url().'?';
		}
		else{
			$qSign1 = $this->MyTube_get_request_url();
			if(isset($pageTokenNP)){
				$qSign = strstr($qSign1,"paget",true);
			}else{
				$qSign = $this->MyTube_get_request_url().'&';
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
					$jsonURLNum = file_get_contents("https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&pageToken={$nextNumPage}&maxResults={$maxrecord}&playlistId={$mtpl_playlistid}&key={$APIKEY}&order=date");
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
		
		if($latestvideos==''){
			if($pagination_position=="both" || $pagination_position=="top"){
				$this->MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage);
			}
		}
		

		/** @Hook Refer function start_wrapper */
		do_action('mytube_youtube_playlist_before');
		
		$lv = $latestvideos;
		foreach($items as $itm){
			if($latestvideos!=""){
				if($lv==0){
					break;
				}
				$lv--;
			}
			
			if($itm->{'status'}->{'privacyStatus'}=="public"){
				$video_ID = $itm->{'snippet'}->{'resourceId'}->{'videoId'};
				$videoJsonURL1 = file_get_contents("https://www.googleapis.com/youtube/v3/videos?id={$video_ID}&part=statistics,contentDetails&key={$APIKEY}");
				$videoJsonURL = json_decode($videoJsonURL1);
				
				$views = $videoJsonURL->{'items'}[0]->{'statistics'}->{'viewCount'};
				$time1 = $videoJsonURL->{'items'}[0]->{'contentDetails'}->{'duration'};
				
				$date = new DateTime('1970-01-01');
				$date->add(new DateInterval($time1));
				$videoTime 	=  $date->format('H:i:s');
				
				$videoViews = number_format($views,0,'.',',');
				
				/** @Hook Refer function list_youtube_data */
				do_action('mytube_youtube_playlist_data');
			}
		} 
		
		/** @Hook Refer function stop_wrapper */
		do_action('mytube_youtube_playlist_after');	

		if($latestvideos==''){
			if($pagination_position=="both" || $pagination_position=="bottom"){
				$this->MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage);
			}
		}
	}
?>