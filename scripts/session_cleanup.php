<?php
chdir(dirname(__FILE__));
chdir("../");
//create lockfile
include "php/system/cron_start.php";
include "init.php";

//This script will Set any login sessions that are > 24*3600 and mark them as timed-out.
//It will also call the session garbage collector
//session_start();
//
//// Executes GC immediately
//session_gc();
//
//// Clean up session ID created by session_gc()
//session_destroy();

$sql = "UPDATE `login_history` SET `session_state` = 'TimedOut', `session_timestamp` = NOW() WHERE `session_state` = 'Active' AND TIMESTAMPDIFF(SECOND,`session_timestamp`,NOW()) > 86400";
$sth = $dbh->run($sql);
/* 
*/2 *   * * *   root    php -f /var/www/scripts/session_cleanup.php 1>/dev/null 2>&1 
*/

//remove lockfile
include "php/system/cron_end.php";