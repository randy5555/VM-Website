<?php
chdir(dirname(__FILE__));
chdir("../");
//create lockfile
include "php/system/cron_start.php";
include "init.php";


//example script

//remove lockfile
include "php/system/cron_end.php";