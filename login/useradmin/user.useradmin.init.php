<?php
if($_POST[user_id])
{
	$in_user = $_POST[user_id];
}
if($_GET[user_id])
{
	$in_user = $_GET[user_id];
}

$new = false;
if($in_user == "new")
{
	$new = true;
}
if(0 < $in_user)
{
	$uadm->init_by_user($in_user);
	$toptext = $uadm->out_nic() . " (" . $uadm->out_log() . ")";

	$logform_nic_val = $uadm->out_nic();
	$logform_stat_val = $uadm->out_stat();
}
?>
