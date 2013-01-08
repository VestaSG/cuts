<?php
$inctype = 1; // Ѕез определенных переменных
$lim = 0; // длина листа
$listarray = array();
$freearr;
$toptext;

$err = 0;
if($_GET[err]) {$err = $_GET[err];}
if(($_GET[user_id]) && ($_GET[user_id] != "new") )
{
	if(!$uadm->is_uid($_GET[user_id])) {$err = user_err;}
}
if($_GET[part_id])
{
//	if(!$uadm->is_part($_GET[part_id])) {$err = part_err;}
}

if($_GET[user_id] == "new")
{
	$toptext = "Ќовый пользователь";
	$inctype = 5;
}

if(!$err && ($_GET[user_id] != "new")) // ѕри "new" проверка наличи€ пользовател€ не происходит
{
	if(!$_GET[user_id] && !$_GET[part_id])
	{
		$toptext = "¬ыберите пользовател€ или <a href=\"./useradmin.inc.php?" . user_id . "=new\">создайте нового</a>";
		$uadm->load();
		$lim = $uadm->outleng();
		for($i = 0; $i < $lim; ++$i)
		{
			$listarray[$i]["name"] = $uadm->out_nic($i);
			$listarray[$i]["log"] = $uadm->out_log($i);
			if(!$listarray[$i]["name"])
			{
				$listarray[$i]["name"] = $listarray[$i]["log"];
			}
			$listarray[$i]["href"] = "./useradmin.inc.php?" . user_id . "=" . $uadm->outid($i);
		}
	}

	if(!$_GET[part_id] && $_GET[user_id])
	{
		$listarray = $mobj->treeBuilding(1);
		$lim = count($listarray);
		for($i = 0; $i < $lim; ++$i)
		{
			$listarray[$i]["href"] = "./useradmin.inc.php?" . user_id . "=" . $_GET[user_id] . "&" . part_id . "=" . $listarray[$i]["id"];
		}
		$inctype = 2;
	}

	if($_GET[part_id] && !$_GET[user_id])
	{
		$uadm->load();
		$lim = $uadm->outleng();
		for($i = 0; $i < $lim; ++$i)
		{
			$listarray[$i]["name"] = $uadm->out_nic($i);
			$listarray[$i]["log"] = $uadm->out_log($i);
			if(!$listarray[$i]["name"])
			{
				$listarray[$i]["name"] = $listarray[$i]["log"];
			}
			$listarray[$i]["href"] = "./useradmin.inc.php?" . part_id . "=" . $_GET[part_id] . "&" . user_id . "=" . $uadm->outid($i);
		}
		$inctype = 3;
	}

	if($_GET[user_id] && $_GET[part_id])
	{
		$in_part = $_GET[part_id];
		$in_user = $_GET[user_id];

		$uadm->init_frees($_GET[user_id], $_GET[part_id]);
		$toptext = "ќпределите права пользовател€ \"" . $uadm->out_nic() . "\"";

		$freearr = $uadm->outfreearray();
		$l = count($freearr);
		for($i = 0; $i < $l; ++$i)
		{
			if($uadm->is_free($freearr[$i]["val"])) {$freearr[$i]["is"] = "checked";}
		}
		$inctype = 4;
	}
}

?>
