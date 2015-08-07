<?php global $permalink,$playList_ID,$itm,$toalVideos; ?>		
        
        <li>
    		<a href="<?php echo $permalink.'&playlistid='.$playList_ID; ?>" target="_new" title="<?php echo $itm->{'snippet'}->{'title'}.' [Videos : '.$toalVideos.']'; ?> ">
    			<img src="<?php echo $itm->{'snippet'}->{'thumbnails'}->{'medium'}->{'url'}; ?>">
				<?php echo $itm->{'snippet'}->{'title'}; ?>
                [<?php echo $toalVideos; ?>]
            </a>
		</li>