<?php
require_once 'base/ajax.php';
require_once 'base/account_access.php';

class account_ajax extends account_access implements ajax {
	
	function __construct(&$current_user) {
		parent::__construct($current_user);
	}
	
	//Functions that should not be exposed should be prefexed with _
	function _isInvalidMethod() {
		return parent::_isInvalidMethod();
	}
	
	function executeMethod() {
		if(!$this->_isInvalidMethod()) {
			parent::executeMethod();
		} else {
			echo "Error: Invalid Method";
		}
	}
	//Entry point
	function run() {
		//May not return.
		$this->executeMethod();
	}
	//Private functions here
	
	//User accessable functions here
	function account_start_vm() {
		echo "Error: Not implemented.";
	}
	
	function account_stop_vm() {
		echo "Error: Not implemented.";
	}
	
	function account_shutdown_vm() {
		echo "Error: Not implemented.";
	}
	
	function account_destroy_vm() {
		echo "Error: Not implemented.";
	}
	
	function account_start_vm_console() {
		echo "Error: Not implemented.";
	}
	
	
}
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { 
	http_response_code(405); die();
}
$ajaxcall = new account_ajax($current_user);
$ajaxcall->run();
exit();

