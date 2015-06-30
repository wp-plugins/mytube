<?php
	if($channelid==""){
		$channelid = $mytube_channelid;
	}
	if($APIKEY==""){
		return "You not set your Google Account API KEY in MyTube List Setting Page. Please Enter Google Account API KEY First. If you have not Google Account API KEY then <a href='https://developers.google.com/api-client-library/python/guide/aaa_apikeys' target='_blank'>Click Here</a>";
	}
	$pageTokenNP = $_GET['paget'];
	if(!isset($pageTokenNP)){
		$jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&maxResults={$maxrecord}&channelId={$channelid}&key={$APIKEY}");
	}else{
		$jsonURL = file_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&maxResults={$maxrecord}&channelId={$channelid}&key={$APIKEY}&pageToken={$pageTokenNP}");
	}
	
	$json = json_decode($jsonURL);
		
	$items = $json->{'items'};
	$i=1;
	if(!isset($pageTokenNP)){
		
		$_SESSION["NEXTPAGECHANNEL"] = $json->{'nextPageToken'};
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
		unset($_SESSION['jsonNumSessionChannel']);
	}
	$_SESSION['oldPageCount'] = $maxrecord;
	
	$numOfPagination = ceil($json->{'pageInfo'}->{'totalResults'}/$json->{'pageInfo'}->{'resultsPerPage'});
	
	if($numOfPagination>1){
		$numPages = array();
		$nextNumPage = $_SESSION["NEXTPAGECHANNEL"];
		
		if(!isset($_SESSION['jsonNumSessionChannel'])){
			for($i=2;$i<=$numOfPagination;$i++){
				array_push($numPages,$nextNumPage);	
				$jsonURLNum = file_get_contents("https://www.googleapis.com/youtube/v3/playlists?part=snippet,contentDetails&pageToken={$nextNumPage}&maxResults={$maxrecord}&channelId={$channelid}&key={$APIKEY}");
				$jsonNum = json_decode($jsonURLNum);
				
				$nextNumPage = $jsonNum->{'nextPageToken'};
				if($i==2){
					$_SESSION["PREVPAGE"] = $jsonNum->{'prevPageToken'};
				}
			}
			$_SESSION['jsonNumSessionChannel'] = $numPages;
		}
		else{
			$numPages = $_SESSION['jsonNumSessionChannel'];
		}
	}
	if($pagination_position=="both" || $pagination_position=="top"){
		MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage);
	}
	
?>
	<ul class="mytubeListWrapper <?php echo $classColumns; ?>" >
<?php
	$permalink = get_permalink( $pageid );
	foreach($items as $itm){
		$playList_ID = $itm->{'id'};
		
		$toalVideos = $itm->{'contentDetails'}->{'itemCount'};
		if($toalVideos==""){$toalVideos=0;}
	?>
		<li>
    		<a href="<?php echo $permalink.'&playlistid='.$playList_ID; ?>" target="_new" title="<?php echo $itm->{'snippet'}->{'title'}.' [Videos : '.$toalVideos.']'; ?> ">
    			<img src="<?php echo $itm->{'snippet'}->{'thumbnails'}->{'medium'}->{'url'}; ?>">
				<?php echo $itm->{'snippet'}->{'title'}; ?>
                [<?php echo $toalVideos; ?>]
            </a>
		</li>
    <?php
	}
?>
	</ul>
<?php
	if($pagination_position=="both" || $pagination_position=="bottom"){
		MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage);
	}
?>