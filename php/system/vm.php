<?php
class vm {
	public function __construct() {
	}
	
	public static function create($name,$ram,$cpu,$disk,$server,$account_id) {
		global $dbh;
		$sql = "INSERT INTO `vm` (`account_id`, `vm_cpus`, `vm_ram`, `server_id`, `vm_name`) VALUES (?, ?, ?, ?, ?)";
		$sth = $dbh->run($sql,array($account_id,$cpu,$ram,$server, $name));
		
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
		$params[] = (int)$ram*1024;
		$params[] = (int)$cpu;
		$params[] = 19;//Temp OS selection
		$params[] = (int)($vid*2)+10000;
		$params[] = (int)$disk;
		$obj["params"] = $params;
		
		$msg = json_encode($obj);
		//talk to java app
		$r = common::sendraw($server_address, 9992, $msg);
		$j = json_decode($r);
		if($j["Response"] == "Success") {
			return true;
		}
		
		return false;
	}
	
	public static function delete() {
		//todo
		return false;
	}
	
	public static function shutdown() {
		//todo
		return false;
	}
	
	public static function stop() {
		//todo
		return false;
	}
	
	public static function start() {
		//todo
		return false;
	}
}
