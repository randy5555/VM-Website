<?php
$instance_limit = $current_user->data["account_VMinstanceLimit"];
$smarty->assign("account_email",$current_user->data["email"]);
$smarty->assign("account_instance_limit",$instance_limit);
$smarty->assign("account_username",$current_user->data["username"]);
$smarty->assign("csrf_token", common::getCSRF());

$sql = "select * from `server` where `server_enabled` = 1";
$sth = $dbh->run($sql);
$enabled_servers = array();
while($row = $dbh->fetch($sth)) {
	$enabled_servers[$row["server_id"]] = $row;
}
$smarty->assign("enabled_servers", $enabled_servers);

if($is_authenticated && Request::issetPost("create_vm")) {
	if($instance_limit > 0) {
		$create_name = Request::get("create_name",false,"post");
		$create_ram = Request::get("create_ram",false,"post");
		$create_cpu = Request::get("create_cpu",false,"post");
		$create_disk = Request::get("create_disk",false,"post");
		$create_server = Request::get("create_server",false,"post");
		$create_os = Request::get("create_os",false,"post");
		$csrf = $_POST["csrf"];

		$new_user = new Users();
		if(!common::validateCSRF($csrf)) {
			$error_message = "CSRF Token Failure.";
			$smarty->assign("error_message",$error_message);
		} else {
			$sql = "select count(*) as `cnt` from `vm` where `account_id` = ?";
			$sth = $dbh->run($sql,array($current_user->id));
			$vmcnt = 0;
			while($row = $dbh->fetch($sth)) {
				$vmcnt = $row["cnt"];
			}
			//todo: check that our space allocation or cpu limit for the server is not exceeded
			if($vmcnt < $instance_limit) {
				$r = vm::create($create_name, $create_ram, $create_cpu, $create_disk, $create_server, $current_user->id, $create_os);
				if($r) {
					header("Location: {$site_URL}account/manage");
				} else {
					$error_message = "Error creating Virtual Machine.";
					$smarty->assign("error_message",$error_message);
				}
			} else {
				$error_message = "Your account does not have enough available Virtual Machine slots.";
				$smarty->assign("error_message",$error_message);
			}
		}
	} else{
		$error_message = "Your account does not have enough available Virtual Machine slots.";
		$smarty->assign("error_message",$error_message);
	}
	
	//
}

$smarty->display("account/create.tpl");
