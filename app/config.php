<?php   
    session_start();

    if(!isset($_SESSION['global_token'])){
        $_SESSION['global_token'] = md5( uniqid(mt_rand(),true) );
    }
    
	$user_agent = getenv("HTTP_USER_AGENT");
	if (!defined('BASE_PATH')) {
		define('BASE_PATH','https://examenu4eq3.000webhostapp.com/');
	}

?>