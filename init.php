<?php
chdir(dirname(__FILE__));
$root_directory = dirname(__FILE__);

include "php/config.php";
global $config;

require_once "php/lib/class_dbpdo.php";
require_once "php/system/request.php";

if(isset($dbh)) { unset($dbh); }
$dbh = new dbpdo($config);

if(substr($root_directory,-1) != "/") { $root_directory.="/"; }
if(substr($site_URL,-1) != "/") { $site_URL.="/"; }
$dir_theme = "templates";
$path_theme = $site_URL."templates";


/*system classes*/
require_once "php/system/common.php";
require_once "php/system/users.php";


/*smarty and cache objects*/
require_once "php/lib/class_smarty.php";
require_once "php/lib/class_dhrest.php";
require_once "php/lib/class_dhes.php";
$smarty = new crmSmarty();
$common = new common();