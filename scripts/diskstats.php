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
	$r = vm::getDISKStat($vid);
	$t = time();
	$timestamp = $t - (time() % 60);
	
	$sql = "select `reads_current`,`writes_current`,`readbytes_current`,`writebytes_current`,`time_index` from `vm_disk_stats` where vm_id = ? order by `time_index` desc limit 1";
	$sth = $dbh->run($sql,array($vid));
	
	$reads_prev = -1;
	$writes_prev = -1;
	$writebytes_prev = -1;
	$readbytes_prev = -1;
	$time_index = 0;
	while($row = $dbh->fetch($sth)) {
		$reads_prev = (int)$row["reads_current"];
		$writes_prev = (int)$row["writes_current"];
		$writebytes_prev = (int)$row["writebytes_current"];
		$readbytes_prev = (int)$row["readbytes_current"];
		$time_index = (int)$row["time_index"];
	}
	
	$reads_now = (int)$r["reads"];
	$writes_now = (int)$r["writes"];
	$readbytes_now = (int)$r["readbytes"];
	$writebytes_now = (int)$r["writebytes"];
	
	$reads_delta = 0;
	$writes_delta = 0;
	$writebytes_delta = 0;
	$readbytes_delta = 0;
	
	if($reads_now < $reads_prev || $writes_now < $writes_prev || $readbytes_now < $readbytes_prev || $writebytes_now < $writebytes_prev || $reads_prev == -1 || $writes_prev == -1 || $writebytes_prev == -1 || $readbytes_prev == -1 || $time_index == 0 || $time_index - $timestamp > 60) {
		$reads_delta = 0;
		$writes_delta = 0;
		$writebytes_delta = 0;
		$readbytes_delta = 0;
	} else {
		$reads_delta = $reads_now - $reads_prev;
		$writes_delta = $writes_now - $writes_prev;
		$writebytes_delta = $writebytes_now - $writebytes_prev;
		$readbytes_delta = $readbytes_now - $readbytes_prev;
	}
	
	$sql = "INSERT INTO `vm_disk_stats` (`vm_id`, `reads_current`, `writes_current`, `readbytes_current`, `writebytes_current`,`reads_delta`, `writes_delta`, `readbytes_delta`, `writebytes_delta`, `time_index`) VALUES (?, ?, ?,?,?,?,?,?,?,?)";
	$sth = $dbh->run($sql,array($vid,$reads_now,$writes_now,$readbytes_now,$writebytes_now,$reads_delta,$writes_delta,$readbytes_delta,$writebytes_delta,$timestamp));
}

//example script

//remove lockfile
include "php/system/cron_end.php";