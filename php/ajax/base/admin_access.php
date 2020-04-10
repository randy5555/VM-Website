<?php
require_once 'account_access.php';
//This class is used as a base class to specify that the child class is meant to be accessable only through an authenticated admin
//Typically used for ajax methods.
//
//Requires a current_user
//Implements a check for if the supplied current_user is authenticated and the role is admin.
class admin_access extends account_access{
	
	function __construct(&$current_user) {
		parent::__construct($current_user);
		if(!$this->_isAdmin() && !$this->_isSupport()) {
			echo "Error: Unauthorized.";
			exit();
		} 
	}
	
	function _isAdmin() {
		return ($this->current_user->role == "admin" ? true : false);
	}
	
	function _isSupport() {
		return ($this->current_user->role == "support" ? true: false);
	}
}
