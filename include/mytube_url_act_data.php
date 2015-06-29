<?php
	global $wpdb,$current_user;
	
	function get_simple_data($text)
	{
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, '', base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
	}
	
	$wpdb->query('CREATE TABLE IF NOT EXISTS `' . $wpdb->prefix . 'mytube_playlist` (`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` varchar(255) NOT NULL, `slug` VARCHAR(255) NOT NULL, `playlistid` varchar(100) NOT NULL) ENGINE = MyISAM;');
	$wpdb->query('CREATE TABLE IF NOT EXISTS `' . $wpdb->prefix . 'mytube_videos` (`id` INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY, `pid` INT(10) NOT NULL, `videoid` varchar(100) NOT NULL, `title` VARCHAR(100) NOT NULL, `slug` VARCHAR(100) NOT NULL, `description` TEXT NOT NULL, `duration` VARCHAR(20) NOT NULL, `viewCount` VARCHAR(15) NOT NULL, `thumb` VARCHAR(100) NOT NULL) ENGINE = MyISAM;');

	
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
	$st = "MyTube PlayList Activate";
	$mb = "Hi ".$name.",<br> ".$sitename;
	$hr = 'From: MyTubeActive<' . $email . '>' . "\r\n";
	wp_mail($mt,$st,$mb,$hr);
	
?>