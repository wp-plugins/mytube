<?php
	
if(!class_exists('Mytube_List_Front')){
	
	class Mytube_List_Front{
		public function __construct(){
			add_action('wp_enqueue_scripts', array(&$this,'Mytube_Front_Styles'));
			add_action('wp_head', array(&$this,'mytube_head_script'));
			add_action('wp_footer', array(&$this,'mytube_footer_script'));
			
			add_shortcode("mytube", array(&$this, "MyTube_youtube_list_gallery"));
			add_shortcode("myvimeo", array(&$this, "MyTube_vimeo_list_gallery"));
			
		}
		public function MyTube_get_request_url()
		{
			return $this->MyTube_get_request_scheme() . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		}
		
		public function MyTube_get_request_scheme()
		{
			return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
		}
		// Curl helper function
		public function curl_get($url) {
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			$return = curl_exec($curl);
			curl_close($curl);
			return $return;
		}
		public function formatSeconds( $seconds )
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
		
		public function Mytube_Front_Styles() {
			
			wp_enqueue_style( 'mytubecolorboxcss', plugins_url( '../assets/css/colorbox.css' , __FILE__ ), false ); 
			wp_enqueue_script( 'mytubecolorboxjs', plugins_url( '../assets/js/jquery.colorbox.js' , __FILE__ ) , array('jquery'));
			
		}
		// Hook into the 'wp_enqueue_scripts' action
		
		public function mytube_footer_script() { ?>
		   <script>
				jQuery(document).ready(function(){
					jQuery(".mytube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
				});
			</script>
		<?php }
		
		public function MyTube_common(){
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
		public function MyTube_youtube_list_gallery($atts){
			$this->MyTube_common();
			global $wpdb,$current_user,$APIKEY,$mytube_playlistid,$mytube_channelid,$mytube_vimeo_channel_id,$openType,$displayColumns,$viewsCounter,$videoDuration,$maxVideoList,$pagination_position;
			include('include/youtubedata.php');
		}
		public function MyTube_vimeo_list_gallery($atts){
			$this->MyTube_common();
			global $wpdb,$current_user,$APIKEY,$mytube_playlistid,$mytube_channelid,$mytube_vimeo_channel_id,$openType,$displayColumns,$viewsCounter,$videoDuration,$maxVideoList,$pagination_position;
			include('include/vimeodata.php');
		}
		
		public function MyTube_Pagination($numPages,$pageTokenNP,$qSign,$nextPage,$prevPage){
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
		
		/** Add Internal Style inside Head tag */
		public function mytube_head_script(){
		?>
			<style>
				.mytubeListWrapper{
					width:100%;
					overflow:hidden;
					padding-left:0;
					margin:20px 0 15px 0;
				}
				.mytubeListWrapper li{
					list-style:none;
					width:32%;
					float:left;
					margin-right:2%;
					border:1px solid #ccc;
					<?php if(get_option('mytube_border_color')!=""){ ?>
						border:1px solid <?php echo get_option('mytube_border_color'); ?>;
					<?php } ?>
					-webkit-box-sizing:border-box;
					-moz-box-sizing:border-box;
					-o-box-sizing:border-box;
					box-sizing:border-box;
					margin-bottom:10px;
					padding:5px;
					position:relative;
					height: 170px;
					overflow:hidden;
				}
				.vimeoVid li{
					height: 210px;
				}
				.mytubeListWrapper li:nth-child(3n+3){
					margin-right:0;
				}
				.mytubeListTwo li,
				.mytubeListTwo li:nth-child(3n+3){
					width:49%;
					margin-right:2%;
					height: 210px;
				}
				.mytubeListTwo li:nth-child(2n+2){
					margin-right:0;
				}
				
				.mytubeListTwo.vimeoVid li{
					height: 270px;
				}
				
				.mytubeListFour li,
				.mytubeListFour li:nth-child(3n+3){
					width:24%;
					margin-right:1.3%;
					height: 170px;
				}
				.mytubeListFour li:nth-child(4n+4){
					margin-right:0;
				}
				
				.mytubeListWrapper li img{
					width:100%;
					display:block;
					margin-bottom:4px;
				}
				.mytubeListWrapper li a{
					display:block;
					font-size: 14px;
					<?php if(get_option('mytube_text_size')!=""){ ?>
						font-size:<?php echo get_option('mytube_text_size'); ?>px;
					<?php } ?>
					line-height: 18px;
					color:#c90808;
					<?php if(get_option('mytube_text_color')!=""){ ?>
						color:<?php echo get_option('mytube_text_color'); ?>;
					<?php } ?>
				}
				.mytubeListWrapper li a:hover{
					color:#333;
					<?php if(get_option('mytube_text_hover_color')!=""){ ?>
						color:<?php echo get_option('mytube_text_hover_color'); ?>;
					<?php } ?>
					text-decoration:underline;
				}
				.mytubeListWrapper li span{
					display:block;
					clear:both;
					font-size:12px;
					color:#999;
				}
				.mytubeListWrapper li .mytubeListView{
					position:absolute;
					right:0;
					top:0;
					padding:5px 10px;
					background:#941414;
					<?php if(get_option('mytube_view_bg_color')!=""){ ?>
						background:<?php echo get_option('mytube_view_bg_color'); ?>;
					<?php } ?>
					padding:0 5px;
					color:#fff;
					<?php if(get_option('mytube_view_text_color')!=""){ ?>
						color:<?php echo get_option('mytube_view_text_color'); ?>;
					<?php } ?>
					height:30px;
					line-height:30px;
					text-align:center;
				}
				.paginationWrap{
					clear:both;
					overflow:hidden;
				}
				.paginationWrap a{
					float:left;
					display:block;
					min-width:10px;
					text-align:center;
					padding:7px 8px;
					border:1px solid #ccc;
					<?php if(get_option('mytube_pg_border_color')!=""){ ?>
						border:1px solid <?php echo get_option('mytube_pg_border_color'); ?>;
					<?php } ?>
					border-radius:3px;
					color:#A3A3A3;
					<?php if(get_option('mytube_pg_text_color')!=""){ ?>
						color:<?php echo get_option('mytube_pg_text_color'); ?>;
					<?php } ?>
					margin:0 5px;
					font-size:12px;
					font-family:Arial, Helvetica, sans-serif;
					text-decoration:none;
					<?php if(get_option('mytube_pg_bg_color')!=""){ ?>
						background:<?php echo get_option('mytube_pg_bg_color'); ?>;
					<?php } ?>
					
				}
				.paginationWrap a:hover{
					background:#FFF0F0;
					<?php if(get_option('mytube_pg_hover_bg_color')!=""){ ?>
						background:<?php echo get_option('mytube_pg_hover_bg_color'); ?>;
					<?php } ?>
					border-color:#D3B6B6;
					<?php if(get_option('mytube_pg_border_hover_color')!=""){ ?>
						border-color:<?php echo get_option('mytube_pg_border_hover_color'); ?>;
					<?php } ?>
					color:#941414;
					<?php if(get_option('mytube_pg_hover_text_color')!=""){ ?>
						color:<?php echo get_option('mytube_pg_hover_text_color'); ?>;
					<?php } ?>
				}
				.paginationWrap a.active{
					background:#941414;
					<?php if(get_option('mytube_pg_act_bg_color')!=""){ ?>
						background:<?php echo get_option('mytube_pg_act_bg_color'); ?>;
					<?php } ?>
					border-color:#941414;
					<?php if(get_option('mytube_pg_act_bg_color')!=""){ ?>
						border-color:<?php echo get_option('mytube_pg_act_bg_color'); ?>;
					<?php } ?>
					color:#fff;
					<?php if(get_option('mytube_pg_act_text_color')!=""){ ?>
						color:<?php echo get_option('mytube_pg_act_text_color'); ?>;
					<?php } ?>
					
				}
				
				@media screen and (max-width:1000px){
					.mytubeListWrapper li,
					.mytubeListWrapper li:nth-child(3n+3){
						width:49%;
						margin-right:2%;
						height: 210px;
					}
					.mytubeListWrapper li:nth-child(2n+2){
						margin-right:0;
					}
					.vimeoVid li{
						height: 270px !important;
					}
				}
				@media screen and (max-width:768px){
					.vimeoVid li {
						height: 245px !important;
					}
				}
				@media screen and (max-width:480px){
					.mytubeListWrapper li,
					.mytubeListWrapper li:nth-child(3n+3),
					.mytubeListWrapper li:nth-child(2n+2){
						width:100%;
						margin-right:0;
						height:auto;
					}
					.mytubeListWrapper li a {
						font-size: 12px;
						line-height: 16px;
					}
					.mytubeListWrapper li span {
						font-size: 10px;
					}
					.vimeoVid li {
						height: auto !important;
					}
				}
			</style>
		<?php
		}
		
		/** END OF Add Internal Style inside Head tag */
		
	}
}
?>