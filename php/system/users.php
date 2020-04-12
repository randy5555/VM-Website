<?php

class Users {
	var $id;
	var $username;
	var $authenticated;
	var $data;
	var $role = "user";
	var $errorMessage = "";
	var $systemErrorMessage = "";
	
	
	function Users($username="") {
		global $dbh;
		if($username != "") {
			$sql = "select * from `accounts` where `username`=?";
			$row = $dbh->getSingle($sql,array($username));
			if($row !== false) {
				$this->data = $row;
				$this->username = $row["username"];
				$this->id = $row["id"];
				if($this->data["is_admin"] >= 1) {
					$this->role = "admin";
				}
			}
			$this->authenticated = false;
		}
	}
	
	function setLastError($sysErrorMsg) {
		$this->systemErrorMessage = $sysErrorMsg;
	}
	
	function getLastError() {
		return $this->systemErrorMessage;
	}
	
	function isCookieEnabled() {
		$settings = $this->getAccountSettings();
		if(isset($settings["cookie"]) && $settings["cookie"] != "") {
			return true;
		}
		return false;
	}
	
	function clearCookieKey(){
		global $dbh;
		$sql = "update `accounts` SET `cookie`='', `cookie_expire`=NULL WHERE `id`=?";
		$dbh->run($sql,array($this->id));
	}
	
	function checkCookieKey($key) {
		$sql = "update `accounts` SET `cookie`='', `cookie_expire`=NULL WHERE `id`=? AND `cookie_expire`<=NOW()";
		$dbh->run($sql,array($this->id));
		$settings = $this->getAccountSettings();
		if($settings !== false && isset($settings["cookie"]) && $settings["cookie"] == $key) {
			return true;
		}
		return false;
	}
	
	function createCookieKey() {
		global $dbh;
		$key = $this->getHash(date("YmdHis").$this->username.$this->data["pass"]);
		$this->createAccountSettings($this->id);
		$sql = "update `accounts` SET `cookie`=?, `cookie_expire`=DATE_ADD(NOW(), INTERVAL 12 HOUR) WHERE `id`=?";
		$dbh->run($sql,array($key,$this->id));
		return $key;
	}
	
	
	
	function addLoginHistory() {
		global $dbh;
		$ip = $_SERVER['REMOTE_ADDR'];
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
                $sessionId = session_id();
		$sql = "insert into `login_history` SET `account_id`=?, `ip_address`=?, `session_id`=?, `user_agent` =?, `session_state` = \"Active\";";
		$dbh->run($sql,array($this->id,$ip,$sessionId,$user_agent));
		$sql = "update `accounts` SET `loggedIp`=? WHERE `id`=?";
		$dbh->run($sql,array($ip,$this->id));
	}

        function updateLoginSessionState($sessionId, $session_state) {
                global $dbh;
                if($session_state != "Unknown" && $session_state != "Active" && $session_state != "TimedOut" && $session_state != "LoggedOut") {
                        return;
                }
                $sql = "UPDATE `login_history` SET `session_state`=?, `session_timestamp` = now() WHERE `account_id`=? AND `session_id`=?";
                $dbh->run($sql,array($session_state, $this->id, $sessionId));
        }

	function updateLoginSessionTimestamp($sessionId) {
                global $dbh;
                $sql = "UPDATE `login_history` SET `session_timestamp` = now() WHERE `account_id`=? AND `session_id`=?";
                $dbh->run($sql,array($this->id, $sessionId));
        }
	
	function getCurrentLoginSessionState() {
		if (session_status() == PHP_SESSION_NONE) {
			return false;
		}
		$sessionId = session_id();
		global $dbh;
		$sql = "SELECT `session_state`,`ip_address`,`user_agent` FROM `login_history` WHERE `account_id`=? and `session_id`=?";
		$sth = $dbh->run($sql,array($this->id,$sessionId));
		while($row=$dbh->fetch($sth)) {
			return $row;
		}
		return false;
	}

	function getEmail($email) {
		global $dbh;
		$sql = "select `email` from `accounts` where `email`=?";
		$sth = $dbh->run($sql,array($email));
		while($row=$dbh->fetch($sth)) {
			return $row["email"];
		}
		return false;
	}
	
	function getEmailId($email) {
		global $dbh;
		$sql = "select `id` from `accounts` where `email`=?";
		$sth = $dbh->run($sql,array($email));
		while($row=$dbh->fetch($sth)) {
			return $row["id"];
		}
		return false;
	}

	function authenticate($password) {
		if($password == $this->data["pass"]) { 
			$valid = true;
			if($valid) {
				$this->authenticated = true;
				return true;
			}
		}
		return false;
	}
        
        //Gets a new hash for the string
	function getHash($string) {
		global $common;
		return $common->getHash($string);
	}
        
        //Sets an error message for the current account. May be used to display on webpage.
	function setErrorMessage($message) {
		$this->errorMessage = $message;
	}
	
	//Appends an error message for the current account. May be used to display on webpage.
	function addErrorMessage($message) {
		$this->errorMessage .= (" " .$message);
	}
	
	//Clears the error message for the current account.
	function clearErrorMessage() {
		$this->errorMessage = "";
	}
        
	
	function valid_pass($candidate) {
		/*$r1='/[A-Z]/';  //Uppercase
		$r2='/[a-z]/';  //lowercase
		$r3='/[!@#$%^&*()\-_=+{};:,<.>]/';  // whatever you mean by 'special char'
		$r4='/[0-9]/';  //numbers

		if(preg_match_all($r1,$candidate, $o) < 1) {
			$this->setErrorMessage('Password policy failure, at least one uppercase letter.');
			return FALSE;
		}

		if(preg_match_all($r2,$candidate, $o) < 1) {
			$this->setErrorMessage('Password policy failure, at least one lowercase letter.');
			return FALSE;
		}

		if(preg_match_all($r3,$candidate, $o) < 1) {
			$this->setErrorMessage('Password policy failure, at least one of [!@#$%^&*()\-_=+{};:,<.>]');
			return FALSE;
		}

		if(preg_match_all($r4,$candidate, $o) < 1) {
			$this->setErrorMessage('Password policy failure, at least one number.');
			return FALSE;
		}*/

		if(strlen($candidate) < 8) {
			$this->setErrorMessage('Password policy failure, must be at least 8 characters in length.');
			return FALSE;
		}

		return TRUE;
	     }
        
        //This will register a new account for the designated username.
	function register($username, $password1, $password2, $email1='', $email2='') {
		global $dbh, $common;
			
		if (strlen($username) > 25) {
			$this->setErrorMessage('Username exceeding character limit of 25.');
			return false;
		}
		if (strlen($username) < 2) {
			$this->setErrorMessage('Username must be at least 2 characters.');
			return false;
		}
		if(is_numeric(substr($username, 0, 1))) {
			$this->setErrorMessage('Username must start with a character not a number.');
			return false;
		}
		if (preg_match('/[^a-z_\-0-9]/i', $username)) {
			$this->setErrorMessage('Username may only contain alphanumeric characters.');
			return false;
		}
		if ($this->getEmail($email1)!== false) {
			$this->setErrorMessage( 'The email address '.$this->getEmail($email1).' is already registered to an account, please choose a unique email address. ' );
			return false;
		}
		if(!isset($password1) || !isset($password2)) {
			$this->setErrorMessage( 'Invalid password.' );
			return false;
		}
		$tmp = explode("@",$email1);
		if(!isset($tmp) || !isset($tmp[1])) {
			$this->setErrorMessage( 'Invalid e-mail address.' );
			return false;
		}
		
		if (!$this->valid_pass($password1)) { 
			//error set in the function.
			return false;
		}
		if ($password1 !== $password2) {
			$this->setErrorMessage( 'Password does not match.' );
			return false;
		}
		if (empty($email1) || !filter_var($email1, FILTER_VALIDATE_EMAIL)) {
			$this->setErrorMessage( 'Invalid e-mail address.' );
			return false;
		}
		if ($email1 !== $email2) {
			$this->setErrorMessage( 'Email addresses do not match.' );
			return false;
		}
		
		// Create hashed strings using original string and salt
		$password_hash = $this->getHash($password1);
		$username_clean = strip_tags($username);
		
		$sql = "SELECT `email`,`username` FROM `accounts` WHERE `username` = ? OR `email` = ?";
		$sth = $dbh->run($sql,array($username_clean,$email1));
		while($row = $dbh->fetch($sth)) {
			if(strtolower($row["email"]) == strtolower($email1)) {
				$this->setErrorMessage( 'Unable to register, (Your email address is already used in an existing account.)' );
				return false;
			} else if(strtolower($row["username"]) == strtolower($username_clean)) {
				$this->setErrorMessage( 'Unable to register, ( Your user/account name is already used in an existing account, please try a new unique username).' );
				return false;
			}
		}
		//run the query to create the user.
		
		$sql = "INSERT INTO `accounts` (`username`, `pass`, `email`, `createdtime`) VALUES (?, ?, ?, NOW())";
		$dbh->run($sql,array($username_clean,$password_hash,$email1));
		//grab their email
		if ($this->getEmail($email1)=== false) { //failed to select their email from the db
			$this->setErrorMessage( 'Unable to register (email address issue), please try again .' );
			return false;
		}
		$sql = "select `id` from `accounts` where `username`=? AND `pass`=?";
		//get their account id from the db
		$sth = $dbh->run($sql,array($username_clean,$password_hash));
		while($row = $dbh->fetch($sth)) {
			$account_id = $row["id"];
		}
		if(!isset($account_id)) { //some sort of issue.
			$this->setErrorMessage( 'There was an issue registering (account not created), please try again.' );
			return false;
		}
		
		$sql = "select * from `accounts` where `username`=? and `id`=?";
		$row = $dbh->getSingle($sql,array($username_clean,$account_id));
		if($row !== false) {
			$this->data = $row;
		} else {
			$this->setErrorMessage( 'There was an issue registering (unable to verify account after creation), please try again. ' );
			return false;
		}
		$this->username = $username_clean;
		$this->id = $account_id;
		
		return true;
	}
	
        
        //This will accept account setting params and update them into the database if changed.
	function update($password1="", $password2="") {
		global $dbh,$common;
		$fields = "";
		$valstring = "";
		$values = array();

		
		if($password1 != "") {
			if (!$this->valid_pass($password1)) { 
				//error set in funct.
				return false;
			}
			if ($password1 !== $password2) {
				$this->setErrorMessage( 'Password does not match' );
				return false;
			}
			$fields = "`pass`=?,";
			$values[] = $this->getHash($password1);

		}
	
		
		$values[] = $this->id;
		$sql = "update `accounts` SET $fields WHERE `id`=?";
		$dbh->run($sql,$values);
		
		return true;
	}
        
                
	function invalidateAllSessions() {
		global $dbh;
                if(empty($this->id)) {
                        return;
                }
		$sql = "update `login_history` set `session_state` = 'LoggedOut' where `account_id` = ? and `session_state` = 'Active';";
		$dbh->run($sql,array($this->id));
	}
        
        
	function getCurrentLoginId() {
		if (session_status() == PHP_SESSION_NONE) {
			return false;
		}
		$sessionId = session_id();
		global $dbh;
		$sql = "SELECT * FROM `login_history` WHERE session_id=? AND session_state='Active' and `account_id`=?";
		$sth = $dbh->run($sql,array($sessionId,$this->id));
		while($row=$dbh->fetch($sth)) {
			return $row["id"];
		}
	}

	//--------
}
