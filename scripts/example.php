<?php
chdir(dirname(__FILE__));
chdir("../");
//create lockfile
include "php/system/cron_start.php";
include "init.php";

$r = vm::getCPUStat(12);
echo "cpus=".$r["cpus"].",".$r["time"];
//example script

//remove lockfile
include "php/system/cron_end.php";