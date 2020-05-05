<?php
chdir(dirname(__FILE__));
chdir("../");
//create lockfile
include "php/system/cron_start.php";
include "init.php";

$sql = "select `vm_id` from `vm` v where v.`vm_status` = 'on'";
$sth = $dbh->run($sql);
$vms = array();
while($row = $dbh->fetch($sth)) {
	$vms[] = $row;
}

foreach ($vms as $key => $value) {
	$vid = (int)$value["vm_id"];
	$r = vm::getNETStat($vid);
	$t = time();
	$timestamp = $t - (time() % 60);
	
	$sql = "select `rx_current`,`tx_current` from `vm_net_stats` where vm_id = ? order by `time_index` desc limit 1";
	$sth = $dbh->run($sql,array($vid));
	
	$rx_prev = -1;
	$tx_prev = -1;
	while($row = $dbh->fetch($sth)) {
		$rx_prev = (int)$row["rx_current"];
		$tx_prev = (int)$row["tx_current"];
	}
	
	$rx_now = (int)$r["rx"];
	$tx_now = (int)$r["tx"];
	
	$rx_delta = 0;
	$tx_delta = 0;
	
	if($rx_now < $rx_prev || $tx_now < $tx_prev || $rx_prev == -1 || $tx_prev == -1) {
		$rx_delta = 0;
		$tx_delta = 0;
	} else {
		$rx_delta = $rx_now - $rx_prev;
		$tx_delta = $tx_now - $tx_prev;
	}
	
	$sql = "INSERT INTO `vm_net_stats` (`vm_id`, `rx_current`, `tx_current`, `rx_delta`, `tx_delta`, `time_index`) VALUES (?, ?, ?,?, ?, ?)";
	$sth = $dbh->run($sql,array($vid,$rx_now,$tx_now,$rx_delta,$tx_delta,$timestamp));
}

//example script

//remove lockfile
include "php/system/cron_end.php";