<?php
	
if(!class_exists('Mytube_Admin_Data')){
	
	class Mytube_Admin_Data{
		
		public function __construct(){
			add_action('mtp_management_settings', array(&$this,'MyTube_management_settings'));
		
		}
		
		public function MyTube_management_settings(){
			global $wpdb,$current_user;
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
		
			wp_enqueue_style( 'backend_style', plugins_url( '../assets/css/backend_style.css' , __FILE__ ));
			
			include('include/page-settings.php');
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					setInterval( function(){
						jQuery("#setting-error-settings_updated").slideUp(1000)
					},5000);
					$('.mytube-title-text-color').wpColorPicker();
					$('.mytube-title-hover-color').wpColorPicker();
					$('.mytube-view-text-color').wpColorPicker();
					$('.mytube_view_bg_color').wpColorPicker();
					$('.mytube_border_color').wpColorPicker();
					$('.mytube_pg_bg_color').wpColorPicker();
					$('.mytube_pg_text_color').wpColorPicker();
					$('.mytube_pg_border_color').wpColorPicker();
					$('.mytube_pg_border_hover_color').wpColorPicker();
					$('.mytube_pg_act_bg_color').wpColorPicker();
					$('.mytube_pg_act_text_color').wpColorPicker();
					$('.mytube_pg_hover_bg_color').wpColorPicker();
					$('.mytube_pg_hover_text_color').wpColorPicker();
				});
				function check_before_install(){
					if(jQuery('#mytube_channelid').val()=='' || jQuery('#mytube_channelid').val()!='<?php echo get_option( 'mytube_channelid' ); ?>'){
						alert('Save Channel ID First Then Create MyTube Pages.');
						return false;
					}else{
						if(confirm('Are you sure to create New Pages for MyTube Channel and PlayList Videos?')){
							jQuery('#frmGlobalSettings').submit();
						}else{
							return false;
						}
					}	
				}
			</script>
			<?php
		}
		
		public function MyTube_save_data(){
			global $wpdb,$current_user;
			include('include/savedata.php');
		}
		
		public function MyTube_create_playlist_by_channel_id(){
			global $wpdb,$current_user;
			wp_enqueue_style( 'backend_style', plugins_url( '../assets/css/backend_style.css' , __FILE__ ));
			
			include('include/create_playlist_by_channel_id.php');
		?>
			<script type="text/javascript">
			var $ = jQuery;
				jQuery(document).ready(function() {
					jQuery('#ownPlayListAll').click(function(event) {  //on click
						if(jQuery(this).is(':checked')) { // check select status
							jQuery('.ownPlayList').each(function(index, element) {
							   jQuery(this).prop('checked',true) 
							});
						}else{
							jQuery('.ownPlayList').each(function(index, element) {
							   jQuery(this).prop('checked',false) 
							});
						}
					});
					
					jQuery('.ownPlayList').click(function(){
						if(jQuery('#ownPlayListAll').is(':checked')) {
							jQuery('#ownPlayListAll').prop('checked',false);
						}
						else{
							//return false;
						}
					});
					
					jQuery("#channelPlayList").click(function(){
						var channelId = jQuery("#channelId").val();
						if(channelId==''){
							jQuery('#channelErrMsgDisplay').html('Please Enter Channel ID.');
							return false;
						}
					});
					
					jQuery("#videoPlayList").click(function(event){
						var videoId = jQuery("#videoId").val();
						var videoPlayListName = jQuery("#videoPlayListName").val();
						
						if(videoId==''){
							jQuery('#videoErrMsgDisplay').html('Please Enter Video ID.');
							return false;
						}
						else if(videoPlayListName==''){
							jQuery('#videoErrMsgDisplay').html('Please Enter PlayList Name.');
							return false;
						}
						else {
							jQuery.ajax({
								type: "post",
								url: "<?php echo plugin_dir_url( __FILE__ ); ?>ajax/chk_play_list_name.php",
								data: 'playListName='+videoPlayListName,
								async: false,
								success: function(playlistid){
									if(playlistid != ""){
										jQuery('#videoErrMsgDisplay').html( videoPlayListName + ' playlist name already exist. Would you like to edit? <a href="?page=mytube_edit_videos&playlistid=' + playlistid + '">Click Here</a>' );
										event.preventDefault();
									}
								}
							});
						}
					});
					
					
					jQuery("#frmVideos").submit(function(event){
						var chkPlayListIsChecked = jQuery('input[name="ownPlayList[]"]:checked').length;
						var playListName = jQuery('#mtCreatePlayListName').val();
						if(chkPlayListIsChecked == false || chkPlayListIsChecked < 1 ){
							jQuery('#errMsgDisplay').html('Please Select Videos.');
							return false;
						}
						<?php if( ! isset($_GET['addplaylistid'])){ ?>
							if(playListName == '' ){
								jQuery('#errMsgDisplay').html('Please Enter Playlist Name.');
								return false;
							}
							else {
								jQuery.ajax({
									type: "post",
									url: "<?php echo plugin_dir_url( __FILE__ ); ?>ajax/chk_play_list_name.php",
									data: 'playListName='+playListName,
									async: false,
									success: function(playlistid){
										//alert(playlistid);
										if(playlistid != ""){
											jQuery('#errMsgDisplay').html( playListName + ' playlist name already exist. Would you like to edit? <a href="?page=mytube_edit_videos&playlistid=' + playlistid + '">Click Here</a>' );
											event.preventDefault();
										}/*
										else{
											$( "#frmVideos" ).submit();	
										}*/
									}
								});
							}
						<?php } ?>
					});
				});
			</script>
		<?php
		}
		
		public function MyTube_change_playlist_by_id(){
			global $wpdb,$current_user;
			wp_enqueue_style( 'backend_style', plugins_url( '../assets/css/backend_style.css' , __FILE__ ));
			include('include/change_playlist_by_id.php');	
		}
		
		public function MyTube_edit_playlist_by_id(){
			global $wpdb,$current_user;
			wp_enqueue_style( 'backend_style', plugins_url( '../assets/css/backend_style.css' , __FILE__ ));
			include('include/edit_playlist.php');
		?>
			<script type="text/javascript">
			var $ = jQuery;
				jQuery(document).ready(function() {
					jQuery('#ownPlayListAll').click(function(event) {  //on click
						if(jQuery(this).is(':checked')) { // check select status
							jQuery('.ownPlayList').each(function(index, element) {
							   jQuery(this).prop('checked',true) 
							});
						}else{
							jQuery('.ownPlayList').each(function(index, element) {
							   jQuery(this).prop('checked',false) 
							});
						}
					});
					
					jQuery('.ownPlayList').click(function(){
						if(jQuery('#ownPlayListAll').is(':checked')) {
							jQuery('#ownPlayListAll').prop('checked',false);
						}
						else{
							//return false;
						}
					});
					jQuery("#frmVideos").submit(function(event){
						var playListName = jQuery('#playListName').val();
						if(playListName == '' ){
							jQuery('#errMsgDisplay').html('Please Enter Playlist Name.');
							event.preventDefault();
						}
					});				
				});
			</script>
<?php
}
	}	
}
?>