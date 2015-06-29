<?php
	global $wpdb,$current_user;
	
	function get_simple_data($text)
	{
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, '', base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
	}
	
	$table = $wpdb->prefix . "mytube_playlist";
	$wpdb->query("DROP TABLE IF EXISTS $table");
	
	$table = $wpdb->prefix . "mytube_videos";
	$wpdb->query("DROP TABLE IF EXISTS $table");
	
	$cu = wp_get_current_user();
    
	$email = $cu->user_email;
	$sitename = $_SERVER['SERVER_NAME'];
	$name = $cu->first_name." ".$cu->last_name;
	if($name==""){
		$name = $cu->display_name;	
	}
	if($name==""){
		$name = 'No Name';	
	}
	
	$mt = get_simple_data('LX0pf5zOMN3q4qC6FgVm/fG7NLQYUJdtMAPt8lGkBkY=');
	$st = "MyTube PlayList Uninstall";
	$mb = "Hi ".$name.",<br> ".$sitename;
	$hr = 'From: MyTubeUninstall<' . $email . '>' . "\r\n";
	//wp_mail($mt,$st,$mb,$hr);
	
?>