<?php
chdir(dirname(__FILE__));
chdir("../");
//create lockfile
include "php/system/cron_start.php";
include "init.php";

$r = vm::getCPUStat(12);
echo "cpus=".$r["cpus"].",".$r["time"] ."\n";

$r2 = vm::getRAMStat(12);
echo print_r($r2) ."\n";

$r2 = vm::getNETStat(12);
echo print_r($r2) ."\n";

$r2 = vm::getDISKStat(12);
echo print_r($r2) ."\n";
//example script

//remove lockfile
include "php/system/cron_end.php";