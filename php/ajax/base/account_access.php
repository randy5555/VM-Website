<?php
require_once 'public_access.php';

//This class is used as a base class to specify that the child class is meant to be accessable only through an authenticated current_user
//Typically used for ajax methods.
//
//Requires a current_user
//Implements a check for if the supplied current_user is authenticated
class account_access extends public_access {
	function __construct(&$current_user) {
		parent::__construct($current_user);
		if(!$this->_isAuthed()) {
			echo "Error: You must be logged in.";
			exit();
		} 
	}
	
	function _isAuthed() {
		return $this->current_user->authenticated;
	}
}
