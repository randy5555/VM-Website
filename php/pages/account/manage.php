<?php
if(!$is_authenticated) {
	die();
}
$smarty->assign("account_email",$current_user->data["email"]);
$smarty->assign("account_instance_limit",$current_user->data["account_VMinstanceLimit"]);
$smarty->assign("account_username",$current_user->data["username"]);
	
if(!empty($record) && is_numeric($record)) {
	$sql = "select v.vm_id as `vm_id`,vm_cpus,vm_ram,v.server_id as `server_id`,s.server_name,vm_name,disk_space,vm_status from `vm` v left join `server` s on s.server_id = v.server_id left join `disk` d on d.vm_id = v.vm_id where v.account_id=? and v.vm_id=?";
	$sth = $dbh->run($sql,array($current_user->id, (int)$record));
	$vm = null;
	while($row = $dbh->fetch($sth)) {
		$vm = $row;
	}
	$smarty->assign("vm",$vm);
	
	$smarty->display("account/manage_detail.tpl");
} else {
	$sql = "select v.vm_id,vm_cpus,vm_ram,v.server_id,s.server_name,vm_name,disk_space,vm_status from `vm` v left join `server` s on s.server_id = v.server_id left join `disk` d on d.vm_id = v.vm_id where v.account_id=? and v.vm_status != 'destroyed'";
	$sth = $dbh->run($sql,array($current_user->id));
	$vms = array();
	while($row = $dbh->fetch($sth)) {
		$vms[] = $row;
	}
	$smarty->assign("vms",$vms);
	$smarty->display("account/manage.tpl");
}
