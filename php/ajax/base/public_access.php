<?php
//This class is used as a base class to specify that the child class is meant to be publicly accessable 
//Typically used for ajax methods.
//
//Requires a current_user (not required for access methods)
//Implements a check for a method, exits if there is no method.
//Implements helper functions to all child classes.

class public_access {
	var $ajax_method = null;
	var $current_user = null;
	
	function __construct(&$current_user) {
		if(isset($_REQUEST["method"]) == false || $_REQUEST["method"] == "") {
			echo "No Method. We have our eyes on you!";
			exit();
		}
		$this->ajax_method = $_REQUEST["method"];
		$this->current_user = &$current_user;
	}
	
	function _isAuthed() {
		if(!isset($this->current_user)) {
			return false;
		}
		return $this->current_user->authenticated;
	}
	
	function _isAdmin() {
		if(!isset($this->current_user)) {
			return false;
		}
		return ($this->current_user->role == "admin" ? true : false);
	}
	
	function _isSupport() {
		if(!isset($this->current_user)) {
			return false;
		}
		return ($this->current_user->role == "support" ? true : false);
	}
	//Returns a string with a dump of the method and current_user data.
	function _dumpClassVars() {
		return "ajax_method:" . $this->getAjaxMethod() . ", current_user: " . var_export($this->current_user, true);
	}
	
	//Returns the method being called to this class via ajax/ url/http get parameter method=.
	function getAjaxMethod() {
		return $this->ajax_method;
	}
	
	//Default executeMethod for all child classes. This will call defined methods via the name in getAjaxMethod.
	function executeMethod() {
		//test if it matches function naming scheme.
		if(preg_match('/^[A-Za-z][a-zA-Z0-9_]+$/', $this->getAjaxMethod()) && method_exists($this,$this->getAjaxMethod()) ) {
			$_call_class_method = $this->getAjaxMethod();
			$this->$_call_class_method();
		} else {
			echo "Errror: Invalid Method";
		}
	}
	
	//Default _isInvalidMethod for all child classes to prevent dynamic access to run/execute methods
	function _isInvalidMethod() {
		switch($this->getAjaxMethod()) {
			case "run":
				return true;
			case "executeMethod":
				return true;
		}
		return false;
	}
	
}
