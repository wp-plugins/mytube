<?php global $openType,$video_ID,$videoJsonURL,$videoTime,$videoDuration,$viewsCounter,$videoViews; ?>
                <li>
                    <a <?php if($openType=="popup"){ ?>class="mytube" <?php }else { echo 'target="_blank"'; } ?> href="http://www.youtube.com/embed/<?php echo $video_ID; ?>?rel=0&amp;wmode=transparent" title="<?php echo $videoJsonURL->{'items'}[0]->{'snippet'}->{'title'}; ?> [<?php echo $videoTime; ?>] <?php ?>">
                        <img src="<?php echo $videoJsonURL->{'items'}[0]->{'snippet'}->{'thumbnails'}->{'medium'}->{'url'}; ?>">
                        <?php echo $videoJsonURL->{'items'}[0]->{'snippet'}->{'title'}; ?>
                        <?php if($videoDuration=="yes"){ ?>[<?php echo $videoTime; ?>] <?php } ?>
                    </a>
                    <?php if($viewsCounter=="yes"){ ?> <span class="mytubeListView" title="<?php echo $videoViews; ?> Views"><?php echo $videoViews; ?></span> <?php } ?>
                </li>