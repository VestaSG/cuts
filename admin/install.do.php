<?php
$menu4install = new menu($dbobject);
if(!$menu4install->load())
{
	$menu4install->set(parttab_isface, 1);
	$menu4install->set(parttab_folder, ADMIN_MODUL);
	$menu4install->set(parttab_name, "Редактор");
	$newpart = $menu4install->save();
	$menu4install->load($newpart);
	$menu4install->SetAllRights(1); // наделение первого пользователя всеми правами
}
?>
