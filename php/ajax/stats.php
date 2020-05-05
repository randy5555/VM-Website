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
		$sql = "select `percentage_delta`,`time_index` from `vm_cpu_stats` where vm_id=?";
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
		$sql = "select `percentage`,`time_index` from `vm_ram_stats` where vm_id=?";
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
	
	function netstats_get() {
		global $dbh;
		$vm_id = Request::get("vm_id",false,"get");
//		$type = Request::get("type",false,"get");
//		if($type != 'rx' && $type != "tx") {
//			return "[]";
//		}
		
		$sql = "select `tx_delta`,`rx_delta`,`time_index` from `vm_net_stats` where vm_id=?";
		$sth = $dbh->run($sql,array($vm_id));
		$data = array();
		$series1 = array();
		$series2 = array();
		$series1["name"] = "Recieve";
		$series2["name"] = "Transmit";
		$series1["color"] = '#F80000';
		$series2["color"] = '#0001F8';
		$sd1 = array();
		$sd2 = array();
		while($row = $dbh->fetch($sth)) {
			$s = array();
			$s[] = ($row["time_index"]-3600*5)*1000;
			$s[] = (float)$row["rx_delta"]/1024;
			
			$s2 = array();
			$s2[] = ($row["time_index"]-3600*5)*1000;
			$s2[] = (float)$row["tx_delta"]/1024;
			$sd1[] = $s;
			$sd2[] = $s2;
		}
		$series1["data"] = $sd1;
		$series2["data"] = $sd2;
		$data[] = $series1;
		$data[] = $series2;
		echo json_encode($data);
	}
	
	
	
}
if ($_SERVER['REQUEST_METHOD'] !== 'GET') { 
	http_response_code(405); die();
}
$ajaxcall = new stats_ajax($current_user);
$ajaxcall->run();
exit();

