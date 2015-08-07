<?php global $openType,$vID,$vTitle,$vDuration,$vThumbnail,$videoDuration,$viewsCounter,$vVideoViews; ?>
        <li>
			<a <?php if($openType=="popup"){ ?>class="mytube" <?php }else { echo 'target="_blank"'; } ?> href="https://player.vimeo.com/video/<?php echo $vID; ?>" title="<?php echo $vTitle; ?> [<?php echo $vDuration; ?>] <?php ?>">
				<img src="<?php echo $vThumbnail; ?>" width="320" height="180">
				<?php echo $vTitle; ?>
				<?php if($videoDuration=="yes"){ ?>[<?php echo $vDuration; ?>] <?php } ?>
			</a>
			<?php if($viewsCounter=="yes"){ ?> <span class="mytubeListView" title="<?php echo $vVideoViews; ?> Views"><?php echo $vVideoViews; ?></span> <?php } ?>
		</li>