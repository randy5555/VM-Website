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
	$r = vm::getCPUStat($vid);
	$t = time();
	$timestamp = $t - (time() % 60);
	$cpus_now = $r["cpus"];
	$time_now = $r["time"];
	
	$sql = "select `cpu_current`,`time_current` from `vm_cpu_stats` where vm_id = ? order by `time_index` desc limit 1";
	$sth = $dbh->run($sql,array($vid));
	
	$cpu_prev = 0;
	$time_prev = 0;
	while($row = $dbh->fetch($sth)) {
		$cpu_prev = $row["cpu_current"];
		$time_prev = $row["time_current"];
	}
	
	$cpu_larger = $cpus_now;
	if($cpu_prev > $cpu_larger) {
		$cpu_larger = $cpu_prev;
	}
	
	$time_delta = $time_now - $time_prev;
	$time_delta = (float)$time_delta;
	if($time_delta > 0) {
		$time_delta = $time_delta / (float)60 / (float)$cpu_larger * (float)100;
	}
	if($time_delta >= 101) {
		$time_delta = 0;//fail
	}
	
	$sql = "INSERT INTO `vm_cpu_stats` (`vm_id`, `cpu_current`, `time_current`, `percentage_delta`, `time_index`) VALUES (?, ?, ?, ?, ?)";
	$sth = $dbh->run($sql,array($vid,(int)$cpus_now,(int)$time_now,$time_delta,$timestamp));
}

//example script

//remove lockfile
include "php/system/cron_end.php";