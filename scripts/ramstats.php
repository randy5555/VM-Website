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
	$r = vm::getRAMStat($vid);
	$t = time();
	$timestamp = $t - (time() % 60);

	$sql = "INSERT INTO `vm_ram_stats` (`vm_id`, `total`, `used`, `percentage`, `time_index`) VALUES (?, ?, ?, ?, ?)";
	$sth = $dbh->run($sql,array($vid,(int)$r["total"],(int)$r["used"],(float)$r["percentage"],$timestamp));
}

//example script

//remove lockfile
include "php/system/cron_end.php";