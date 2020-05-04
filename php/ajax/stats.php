<?php
require_once 'base/ajax.php';
require_once 'base/account_access.php';

class stats_ajax extends account_access implements ajax {
	
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
	function cpustats_get() {
		global $dbh;
		$vm_id = Request::get("vm_id",false,"get");
		$sql = "select `percentage_delta`,`time_index` from `vm_cpu_stats`";
		$sth = $dbh->run($sql,array($vm_id));
		$data = array();
		
		while($row = $dbh->fetch($sth)) {
			$series = array();
			$series[] = ($row["time_index"]-3600*5)*1000;
			$series[] = (float)$row["percentage_delta"];
			$data[] = $series;
		}
		
		echo json_encode($data);
	}
	
	function ramstats_get() {
		global $dbh;
		$vm_id = Request::get("vm_id",false,"get");
		$sql = "select `percentage`,`time_index` from `vm_ram_stats`";
		$sth = $dbh->run($sql,array($vm_id));
		$data = array();
		
		while($row = $dbh->fetch($sth)) {
			$series = array();
			$series[] = ($row["time_index"]-3600*5)*1000;
			$series[] = (float)$row["percentage"];
			$data[] = $series;
		}
		
		echo json_encode($data);
	}
	
	
	
}
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { 
	http_response_code(405); die();
}
$ajaxcall = new stats_ajax($current_user);
$ajaxcall->run();
exit();

