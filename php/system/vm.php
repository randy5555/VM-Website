<?php
class vm {
	public function __construct() {
	}
	
	public static function create($name,$ram,$cpu,$disk,$server,$account_id, $os) {
		if(empty($os) || empty($name) || empty($ram) || empty($cpu) || empty($disk) || empty($server)) {
			return false;
		}
		global $dbh;
		
		$sql = "INSERT INTO `vm` (`account_id`, `vm_cpus`, `vm_ram`, `server_id`, `vm_name`,`vm_os`) VALUES (?, ?, ?, ?, ?, ?)";
		$sth = $dbh->run($sql,array($account_id,$cpu,$ram,$server, $name, $os));
		
		$vid = $dbh->lastInsertId();
		$sql = "INSERT INTO `disk` (`vm_id`, `disk_space`, `disk_device_name`, `server_id`) VALUES (?, ?, ?, ?)";
		$sth = $dbh->run($sql,array($vid,$disk,"/dev/vda",$server));
		
		$sql = "select `server_address` from server where `server_id` = ?";
		$sth = $dbh->run($sql,array($server));
		$server_address = "::1";
		while($row = $dbh->fetch($sth)) {
			$server_address = $row["server_address"];
		}
			
		//construct object, serialise to json
		$obj = array();
		$obj["command"] = "defineVM";
		$params = array();
		$params[] = "vm_".$vid;
		$params[] = (string)$ram*1024;
		$params[] = (string)$cpu;
		$params[] = (string)$os;
		$params[] = (string)($vid*2)+10000;
		$params[] = (string)$disk;
		$obj["params"] = $params;
		
		$msg = json_encode($obj);
		//talk to java app
		$r = common::sendraw($server_address, 9992, $msg);
		$j = json_decode($r, true);
		if($j["Response"] == "Success") {
			return true;
		}
		
		return false;
	}
	
	private static function getServerAddress($vm_id) {
		global $dbh;
		
		$sql = "select `server_address` from server s right join vm v on v.server_id = s.server_id where v.vm_id = ?";
		$sth = $dbh->run($sql,array($vm_id));
		$server_address = "::1";
		while($row = $dbh->fetch($sth)) {
			$server_address = $row["server_address"];
		}
		return $server_address;
	}
	
	public static function delete($vm_id) {
		$server_address = vm::getServerAddress($vm_id);
		
		$obj = array();
		$obj["command"] = "undefineVM";
		$params = array();
		$params[] = "vm_".$vm_id;
		$obj["params"] = $params;
		$msg = json_encode($obj);
		//talk to java app
		$r = common::sendraw($server_address, 9992, $msg);
		$j = json_decode($r, true);
		if($j["Response"] == "Success") {
			return true;
		}
		return false;
	}
	
	public static function shutdown($vm_id) {
		$server_address = vm::getServerAddress($vm_id);
		
		$obj = array();
		$obj["command"] = "shutdownVM";
		$params = array();
		$params[] = "vm_".$vm_id;
		$obj["params"] = $params;
		$msg = json_encode($obj);
		//talk to java app
		$r = common::sendraw($server_address, 9992, $msg);
		$j = json_decode($r, true);
		if($j["Response"] == "Success") {
			return true;
		}
		return false;
	}
	
	public static function stop($vm_id) {
		$server_address = vm::getServerAddress($vm_id);
		
		$obj = array();
		$obj["command"] = "destroyVM";
		$params = array();
		$params[] = "vm_".$vm_id;
		$obj["params"] = $params;
		$msg = json_encode($obj);
		//talk to java app
		$r = common::sendraw($server_address, 9992, $msg);
		$j = json_decode($r, true);
		if($j["Response"] == "Success") {
			return true;
		}
		return false;
	}
	
	public static function start($vm_id) {
		$server_address = vm::getServerAddress($vm_id);
		
		$obj = array();
		$obj["command"] = "startVM";
		$params = array();
		$params[] = "vm_".$vm_id;
		$obj["params"] = $params;
		$msg = json_encode($obj);
		
		//talk to java app
		$r = common::sendraw($server_address, 9992, $msg);
		$j = json_decode($r, true);
		if($j["Response"] == "Success") {
			return true;
		}
		return false;
	}
	
	public static function getCPUStat($vm_id) {
		$server_address = vm::getServerAddress($vm_id);
		
		$obj = array();
		$obj["command"] = "getCPUStats";
		$params = array();
		$params[] = "vm_".$vm_id;
		$obj["params"] = $params;
		$msg = json_encode($obj);
		
		//talk to java app
		$r = common::sendraw($server_address, 9992, $msg);
		$j = json_decode($r, true);
		if($j["Response"] == "Success") {
			return array("cpus"=>$j["cpus"],"time"=>((double)$j["time"] / (double)1000000000));
		}
		return array("cpus"=>0,"time"=>0);
	}
	
	public static function startconsole($vm_id) {
		$server_address = vm::getServerAddress($vm_id);
		//todo
		return false;
	}
}
