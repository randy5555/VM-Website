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
	
	function _cando($vm_id) {
		global $dbh;
		$sql = "select `vm_id` from `vm` where vm_id = ? AND account_id =?";
		$sth = $dbh->run($sql,array($vm_id, $this->current_user->id));
		$owns_vm = false;
		while($row = $dbh->fetch($sth)) {
			if($row["vm_id"] == $vm_id) {
				$owns_vm = true;
			}
		}
		return $owns_vm;
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
		$vm_id = Request::get("vm_id",false,"get");
		if($this->_cando($vm_id)) {
			$r = vm::start($vm_id);
			if($r == true) {
				echo "success";
			} else {
				echo "Error: This action failed.";
			}
		} else {
			echo "Error: You cannot perform this action.";
		}
		
	}
	
	function account_stop_vm() {
		$vm_id = Request::get("vm_id",false,"get");
		if($this->_cando($vm_id)) {
			$r = vm::stop($vm_id);
			if($r == true) {
				echo "success";
			} else {
				echo "Error: This action failed.";
			}
		} else {
			echo "Error: You cannot perform this action.";
		}
	}
	
	function account_shutdown_vm() {
		$vm_id = Request::get("vm_id",false,"get");
		if($this->_cando($vm_id)) {
			$r = vm::shutdown($vm_id);
			if($r == true) {
				echo "success";
			} else {
				echo "Error: This action failed.";
			}
		} else {
			echo "Error: You cannot perform this action.";
		}
	}
	
	function account_destroy_vm() {
		global $dbh;
		$vm_id = Request::get("vm_id",false,"get");
		if($this->_cando($vm_id)) {
			$r = vm::delete($vm_id);
			if($r == true) {
				$sql = "from `vm` where vm_id = ? AND account_id =?";
				$sth = $dbh->run($sql,array($vm_id, $this->current_user->id));
				echo "success";
			} else {
				echo "Error: This action failed.";
			}
		} else {
			echo "Error: You cannot perform this action.";
		}
	}
	
	function account_start_vm_console() {
		$vm_id = Request::get("vm_id",false,"get");
		if($this->_cando($vm_id)) {
			$r = vm::startconsole($vm_id);
			if($r == true) {
				echo "success";
			} else {
				echo "Error: This action failed.";
			}
		} else {
			echo "Error: You cannot perform this action.";
		}
	}
	
	
}
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { 
	http_response_code(405); die();
}
$ajaxcall = new account_ajax($current_user);
$ajaxcall->run();
exit();

