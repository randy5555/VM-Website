<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:		modifier.usertime.php
 * Type:		modifier
 * Name:		usertime
 * Purpose:	Formats time in UserTimezone
 * -------------------------------------------------------------
 */
function smarty_modifier_usertime($timein) {
	if($timein == "") { return ""; }
	$time = strtotime($timein);
	$dt = new DateTime();
	$dt->setTimeStamp($time);
	if(isset($_SESSION["tz"])) {
		$_SESSION["tz"] = _sm_fixDateTimeZone($_SESSION["tz"]);
		try {
			$tz = new DateTimeZone($_SESSION["tz"]);
		} catch(Exception $e) {
			$tz = new DateTimeZone("America/New_York");
		}
		$dt->setTimezone($tz);
	}
//	if($dt->format("Y") == date("Y")) {
//		$timeout = $dt->format("m/d h:i a");
//	} else {
//		$timeout = $dt->format("m/d/Y h:i a");
//	}
	$timeout = $dt->format("m/d/Y h:i a");
	return $timeout;
}

function _sm_fixDateTimeZone($tz) {
	if($tz == "Etc/GMT 12") {
		return "Etc/GMT+12";
	}
	return $tz;
}