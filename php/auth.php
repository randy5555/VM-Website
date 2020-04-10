<?php 
global $site_URL;
$auth_cookie_expiration_length = 3600*24*14;
session_set_cookie_params($auth_cookie_expiration_length,'/',"",isset($_SERVER["HTTPS"]), true);
session_start();
$is_authenticated = false;


if(Request::issetRequest("auth")) {
	$req_username = Request::get("username");
	$current_user = new Users($req_username);
	
	if(filter_var($req_username, FILTER_VALIDATE_EMAIL)) {
		$_SESSION["auth_failed"] = "Invalid Username or Password.";
		
		header('Location: '.$site_URL."login");
		exit();
	}
		if($current_user->authenticate($current_user->getHash($_REQUEST["password"])) === true) {
			$_SESSION["username"] = $req_username;
			$_SESSION["password"] = $current_user->getHash($_REQUEST["password"]);
			$is_authenticated = true;
			
			session_set_cookie_params($auth_cookie_expiration_length,'/',"",isset($_SERVER["HTTPS"]), true);
                     session_regenerate_id(true);
			$current_user->addLoginHistory();
			if(Request::issetRequest("Location") && $_REQUEST["Location"] != "") {
				$loc = ltrim(parse_url(urldecode($_REQUEST["Location"]), PHP_URL_PATH),'/');
				header('Location: '. $site_URL . $loc);
			}  else {
				header('Location: '.$site_URL);
			}
			
			exit("Redirect after successful auth");
		} else { 
			//failed authenticate_login
			 
			$current_user->authenticated=false;
			$is_authenticated = false;
			
			$_SESSION["auth_failed"] = "Invalid Username or Password.";
			header('Location: '.$site_URL."login");
			exit();
		}
	
}elseif(Request::issetRequest("logout")) {
	if(isset($_SESSION["username"])) {
		$current_user = new Users($_SESSION["username"]);
		$current_user->clearCookieKey();
               
              $sessionId = session_id();
              $current_user->updateLoginSessionState($sessionId,"LoggedOut");
		unset($current_user);
	}
	unset($_SESSION["username"]);
	session_destroy();
	setcookie("username","", time()+($auth_cookie_expiration_length),'/',"", isset($_SERVER["HTTPS"]), true);
	setcookie("cookiekey","", time()+($auth_cookie_expiration_length),'/',"", isset($_SERVER["HTTPS"]), true);
	unset($_COOKIE);
	if(isset($current_user)) {
		$current_user->authenticated = false;
	}
	$is_authenticated = false;
	header('Location: '.$site_URL);
	exit();
} else { //may already be logged in
	if(!$is_authenticated && isset($_SESSION["username"]) && isset($_SESSION["password"])) {
		$current_user = new Users($_SESSION["username"]);
		if($current_user->authenticate($_SESSION["password"])) {
			$is_authenticated = true;
		} else {
			$is_authenticated = false;
			$current_user->authenticated = false;
			$_SESSION["auth_failed"] = "Invalid Username or Password.";
		}
	}
	if(!$is_authenticated && isset($_COOKIE["username"]) && $_COOKIE["username"] != "" && isset($_COOKIE["cookiekey"]) && $_COOKIE["cookiekey"] != "") {
		$current_user = new Users($_COOKIE["username"]);
		if($current_user->checkCookieKey($_COOKIE["cookiekey"])) {
			$is_authenticated = true;
			$current_user->authenticated = true;
		} else {
			$is_authenticated = false;
			$current_user->authenticated=false;
			setcookie("username","", time()+($auth_cookie_expiration_length),'/',"", isset($_SERVER["HTTPS"]), true);
			setcookie("cookiekey","", time()+($auth_cookie_expiration_length),'/',"", isset($_SERVER["HTTPS"]), true);
			unset($_COOKIE["username"]);
			unset($_COOKIE["cookiekey"]);
			session_destroy();
		}
	}
	if(!$is_authenticated) {
		$current_user = new Users();
		$current_user->role = "guest";
	} else { //currently the session is authenticated
		//check login_history for a non Active login state (if the session was logged out)
		$current_session_state = $current_user->getCurrentLoginSessionState();
		
		if((isset($_SESSION['SESSION_CLOSE_STATE']) && $_SESSION['SESSION_CLOSE_STATE'] == 1) || (isset($_SESSION['SESS_ACTIVITY_TIME']) && (time() - $_SESSION['SESS_ACTIVITY_TIME']) > 86400)) { //Check if we are in a timed out session, logout.
			$_SESSION['SESS_ACTIVITY_TIME'] = time();
                        $sessionId = session_id();
			
                        if($current_session_state == "Active") { //already not in Active state, don't update
				if($_SESSION['SESSION_CLOSE_STATE'] == 1) {
					$current_user->updateLoginSessionState($sessionId,"LoggedOut");
					$_SESSION['SESSION_CLOSE_STATE'] = 0;
				} else {
					
					$current_user->updateLoginSessionState($sessionId,"TimedOut");
				}
			}
			
			$current_user->clearCookieKey();
			$current_user->authenticated=false;
			setcookie("username","", time()+($auth_cookie_expiration_length),'/',"", isset($_SERVER["HTTPS"]), true);
			setcookie("cookiekey","", time()+($auth_cookie_expiration_length),'/',"", isset($_SERVER["HTTPS"]), true);
			unset($_COOKIE["username"]);
			unset($_COOKIE["cookiekey"]);
			session_destroy();
			$is_authenticated = false;
			unset($current_user);
			header('Location: '.$site_URL);
			exit();
		} else if($current_session_state["session_state"] != "Active") { //not in Active state, destroy this session
			$current_user->clearCookieKey();
			$current_user->authenticated=false;
			setcookie("username","", time()+($auth_cookie_expiration_length),'/',"", isset($_SERVER["HTTPS"]), true);
			setcookie("cookiekey","", time()+($auth_cookie_expiration_length),'/',"", isset($_SERVER["HTTPS"]), true);
			unset($_COOKIE["username"]);
			unset($_COOKIE["cookiekey"]);
			
			session_destroy();
			$is_authenticated = false;
			unset($current_user);
			header('Location: '.$site_URL);
			exit();
		} else {        //Used to update the activity time.
			if(!isset ($_SESSION['SESS_ACTIVITY_TIME']) || time() - $_SESSION['SESS_ACTIVITY_TIME'] > 30) {
				$_SESSION['SESS_ACTIVITY_TIME'] = time();
				$sessionId = session_id();
				$current_user->updateLoginSessionTimestamp($sessionId);
			}
		}
	}
}
