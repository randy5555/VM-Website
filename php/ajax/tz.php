<?php
if (Request::issetPost('timezone')) {
	$_SESSION['tz'] = Request::get("timezone",false,"post");
	exit();
}