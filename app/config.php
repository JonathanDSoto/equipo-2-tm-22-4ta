<?php   
    session_start();

    if(!isset($_SESSION['global_token'])){
        $_SESSION['global_token'] = md5( uniqid(mt_rand(),true) );
    }
    
	$user_agent = getenv("HTTP_USER_AGENT");
	if (!defined('BASE_PATH')) {
		if(strpos($user_agent, "Win") !== FALSE){
			define('BASE_PATH','http://localhost/equipo-2-tm-22-4ta/');
		}else if(strpos($user_agent, "Mac") !== FALSE){
			define('BASE_PATH','http://localhost:8888/equipo-2-tm-22-4ta/');
		}
		
	}

?>