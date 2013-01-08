<?php
$trasslog = array();
$qcuts = 0; // кол-во резов (штук)
$lcuts = 0; // ќбща€ длина резов
$costcuts = 0; // ќбща€ стоимость резов

$inDesk = array(); // $inDesk[i][x0,y0,x,y, stat]; stat:  1 - исходник, 2 - готова€ деталь, 3 - отход
$cuts = array(); // $cuts[i][x0,y0, x,y, fixd]; fixd - показатель того, что рез уже применен и после него пересмотрен состав исходных заготовок
$outDesk = array(); // $outDesk[i][x0,y0,x,y]
// «аполнение массивов
// $inDesk
$inDesk[0]["x0"] = 0;
$inDesk[0]["x"] = $cutorderObj->out(TAB_CUTORDER_w) - 1;
$inDesk[0]["y0"] = 0;
$inDesk[0]["y"] = $cutorderObj->out(TAB_CUTORDER_h) - 1;
$inDesk[0]["stat"] = 1;

// $outDesk
$DeskBorder = cut_weight/2;
for($i = 0; $i < $deskCount; ++$i)
{
	$tDesk = array();
	$tDesk["x0"] = $cutunitObj->out(TAB_CUTDESKS_l, $i);
	$tDesk["y0"] = $cutunitObj->out(TAB_CUTDESKS_t, $i);
	$tDesk["x"] = $tDesk["x0"] + $cutunitObj->out(TAB_CUTDESKS_w, $i) - 1;
	$tDesk["y"] = $tDesk["y0"] + $cutunitObj->out(TAB_CUTDESKS_h, $i) - 1;

	if($tDesk["x0"] > 0)
	{ $tDesk["x0"] = $tDesk["x0"] + $DeskBorder; $tDesk["x"] = $tDesk["x"] + $DeskBorder; }
	if($tDesk["y0"] > 0)
	{ $tDesk["y0"] = $tDesk["y0"] + $DeskBorder; $tDesk["y"] = $tDesk["y"] + $DeskBorder; }

	if($tDesk["x"] > $inDesk[0]["x"])
	{ $tDesk["x"] = $inDesk[0]["x"]; }
	if($tDesk["y"] > $inDesk[0]["y"])
	{ $tDesk["y"] = $inDesk[0]["y"]; }

	$outDesk[] = $tDesk;
}
// END: «аполнение массивов

define(TRASS_CUT_LOG, 0);
define(TRASS_CUT_IMG, 1);
function setcuts(&$InDesk, &$Cuts, &$OutDesk, $isvertic = 1, &$trasslog = array())
{
//	writelog("function " . __FUNCTION__);
	if(TRASS_CUT_LOG)
	{
		$trasslog[] = "";
		$trasslog[] = "function " . __FUNCTION__ . ". \$isvertic = $isvertic";
	}
	$new_cuts = 0;
	$in2del = array(); // исходники к удалению
	$tempInDesk = array();
	foreach ($InDesk as $KInDesk => $ValInDesk)
	{
//		echo($KInDesk.": " . $ValInDesk["x0"] . ", " . $ValInDesk["y0"] . ", " . $ValInDesk["x"] . ", " . $ValInDesk["y"] . "<br />");
		// вертикальные резы
		if($isvertic)
		{
// echo("¬ертикальный рез <br />");
			foreach ($OutDesk as $KOutDesk => $ValOutDesk)
			{
				if( !($ValInDesk["x0"] > $ValOutDesk["x0"]) && !($ValInDesk["y0"] > $ValOutDesk["y0"]) && !($ValInDesk["y"] < $ValOutDesk["y"]) && !($ValInDesk["x"] < $ValOutDesk["x"]) )
				{
					$newcut = array();
					$newcut["x0"] = $ValOutDesk["x"] + 1;
					$newcut["x"] = $ValOutDesk["x"] + cut_weight;
					$newcut["y0"] = $ValInDesk["y0"];
					$newcut["y"] = $ValInDesk["y"];
					$newcut["fixd"] = false;

					if(TRASS_CUT_LOG)
					{
						$trasslog[] = "newcut on $KInDesk(" . $ValInDesk["x0"] . ", " . $ValInDesk["y0"] . ", " . $ValInDesk["x"] . ", " . $ValInDesk["y"].") " . $newcut["x0"] .", ". $newcut["y0"] .", ". $newcut["x"] .", ". $newcut["y"] ;
					}
					$badway = 0;
					if( ($newcut["x0"]+cut_weight) > $ValInDesk["x"] )
					{
						if(TRASS_CUT_LOG)
						{
							$trasslog[] = "bad: cut < " . cut_weight;
						}
						++$badway;
					}

					$cc = count($Cuts);
//					for($i = ($cc - $new_cuts); $i < $cc; ++$i)
					for($i = 0; $i < $cc; ++$i)
					{
						if($badway)
						{
							break;
						}
						if( !($Cuts[$i]["y0"] > $newcut["y0"]) && !($Cuts[$i]["y"] < $newcut["y"]) && ($Cuts[$i]["x0"] == $newcut["x0"]) )
						{
							if(TRASS_CUT_LOG)
							{
								$trasslog[] = "bad: cut terminated by cut: " . $Cuts[$i]["x0"] .", ". $Cuts[$i]["y0"] .", ". $Cuts[$i]["x"] .", ". $Cuts[$i]["y"];
							}
							++$badway;
							break;
						}
					}

					for($i = $ValInDesk["y0"]; $i < $ValInDesk["y"]+1; ++$i)
					{
						foreach ($OutDesk as $KOutDesk2 => $ValOutDesk2)
						{
							if($badway)
							{
								break;
								break;
							}
							if( !($ValInDesk["x0"] > $ValOutDesk2["x0"]) && !($ValInDesk["y0"] > $ValOutDesk2["y0"]) && !($ValInDesk["y"] < $ValOutDesk2["y"]) && !($ValInDesk["x"] < $ValOutDesk2["x"]) )
							{
								if( ($i > $ValOutDesk2["y0"]) && ($i < $ValOutDesk2["y"]) && ($newcut["x"] > $ValOutDesk2["x0"])  && ($newcut["x"] < $ValOutDesk2["x"]) )
								{
									if(TRASS_CUT_LOG)
									{
										$trasslog[] = "bad: cut terminated by desk";
									}
									++$badway;
									break;
									break;
								}
							}
						}
					}

					if($badway)
					{
						unset($newcut);
					}
					else
					{
						$Cuts[] = $newcut;
						++$new_cuts;
						if(TRASS_CUT_LOG)
						{
							$trasslog[] = "approved";
						}
					}
				}
			}
	// ѕересмотр исходников
			if($new_cuts)
			{
				$tempXCut = array();
				$cc = count($Cuts);
				for($i = ($cc - $new_cuts); $i < $cc; ++$i)
				{
					if(!$Cuts[$i]["fixd"])
					{
						$tempXCut[] = $Cuts[$i]["x0"];
						$Cuts[$i]["fixd"] = true;
					}
				}
				sort($tempXCut);

				$tempInDesk_2 = array();
				$tempInDesk_2["y0"] = $ValInDesk["y0"];
				$tempInDesk_2["x0"] = $ValInDesk["x0"];
				$tempInDesk_2["y"] = $ValInDesk["y"];
				$tempInDesk_2["x"] = $ValInDesk["x"];
				$tempInDesk_2["stat"] = 1;


				$cc = count($tempXCut);
				for($i = 0; $i < $cc; ++$i)
				{
						$tempInDesk_1 = array();
						$tempInDesk_1["y0"] = $tempInDesk_2["y0"];
						$tempInDesk_1["x0"] = $tempInDesk_2["x0"];
						$tempInDesk_1["x"] = $tempXCut[$i] - 1;
						$tempInDesk_1["y"] = $tempInDesk_2["y"];
						$tempInDesk_1["stat"] = 1;

						$tempInDesk_2["x0"] = $tempXCut[$i] + cut_weight;

						$tempInDesk[] = $tempInDesk_1;
				}
				$tempInDesk[] = $tempInDesk_2;
				$in2del[] = $KInDesk;
			}
		}
		// горизонтальные резы
		else
		{
			foreach ($OutDesk as $KOutDesk => $ValOutDesk)
			{
				if( !($ValInDesk["y0"] > $ValOutDesk["y0"]) && !($ValInDesk["x0"] > $ValOutDesk["x0"]) && !($ValInDesk["x"] < $ValOutDesk["x"]) && !($ValInDesk["y"] < $ValOutDesk["y"]) )
				{
					$newcut = array();
					$newcut["y0"] = $ValOutDesk["y"] + 1;
					$newcut["y"] = $ValOutDesk["y"] + cut_weight;
					$newcut["x0"] = $ValInDesk["x0"];
					$newcut["x"] = $ValInDesk["x"];
					$newcut["fixd"] = false;

					if(TRASS_CUT_LOG)
					{
						$trasslog[] = "newcut on $KInDesk(" . $ValInDesk["x0"] . ", " . $ValInDesk["y0"] . ", " . $ValInDesk["x"] . ", " . $ValInDesk["y"].") " . $newcut["x0"] .", ". $newcut["y0"] .", ". $newcut["x"] .", ". $newcut["y"] ;
					}

					$badway = 0;
					if( ($newcut["y0"]+4) > $ValInDesk["y"] )
					{
						$trasslog[] = "bad: cut < " . cut_weight;
						++$badway;
					}

					$cc = count($Cuts);
//					for($i = ($cc - $new_cuts); $i < $cc; ++$i)
					for($i = 0; $i < $cc; ++$i)
					{
						if($badway)
						{
							break;
						}
						if( !($Cuts[$i]["x0"] > $newcut["x0"]) && !($Cuts[$i]["x"] < $newcut["x"]) && ($Cuts[$i]["y0"] == $newcut["y0"]) )
						{
							if(TRASS_CUT_LOG)
							{
								$trasslog[] = "bad: cut terminated by cut: " . $Cuts[$i]["x0"] .", ". $Cuts[$i]["y0"] .", ". $Cuts[$i]["x"] .", ". $Cuts[$i]["y"];
							}
							++$badway;
							break; // т. к. может не быть след. итерации
						}
					}

					for($i = $ValInDesk["x0"]; $i < $ValInDesk["x"]+1; ++$i)
					{
						foreach ($OutDesk as $KOutDesk2 => $ValOutDesk2)
						{
							if($badway)
							{
								break;
								break;
							}
							if( !($ValInDesk["y0"] > $ValOutDesk2["y0"]) && !($ValInDesk["x0"] > $ValOutDesk2["x0"]) && !($ValInDesk["x"] < $ValOutDesk2["x"]) && !($ValInDesk["y"] < $ValOutDesk2["y"]) )
							{
								if( !($i < $ValOutDesk2["x0"]) && !($i > $ValOutDesk2["x"]) && !($newcut["y"] < $ValOutDesk2["y0"])  && !($newcut["y"] > $ValOutDesk2["y"]) )
								{
									++$badway;
									if(TRASS_CUT_LOG)
									{
										$trasslog[] = "bad: cut terminated by desk";
									}
								}
							}
						}
					}
					if($badway)
					{
						unset($newcut);
					}
					else
					{
						$Cuts[] = $newcut;
						++$new_cuts;
						if(TRASS_CUT_LOG)
						{
							$trasslog[] = "approved";
						}
					}
				}
			}
	// ѕересмотр исходников
			if($new_cuts)
			{
				$tempXCut = array();
				$cc = count($Cuts);
				for($i = ($cc - $new_cuts); $i < $cc; ++$i)
				{
					if(!$Cuts[$i]["fixd"])
					{
						$tempXCut[] = $Cuts[$i]["y0"];
						$Cuts[$i]["fixd"] = true;
					}
				}
				sort($tempXCut);

				$tempInDesk_2 = array();
				$tempInDesk_2["y0"] = $ValInDesk["y0"];
				$tempInDesk_2["x0"] = $ValInDesk["x0"];
				$tempInDesk_2["y"] = $ValInDesk["y"];
				$tempInDesk_2["x"] = $ValInDesk["x"];
				$tempInDesk_2["stat"] = 1;


				$cc = count($tempXCut);
				for($i = 0; $i < $cc; ++$i)
				{
						$tempInDesk_1 = array();
						$tempInDesk_1["y0"] = $tempInDesk_2["y0"];
						$tempInDesk_1["x0"] = $tempInDesk_2["x0"];
						$tempInDesk_1["y"] = $tempXCut[$i] - 1;
						$tempInDesk_1["x"] = $tempInDesk_2["x"];
						$tempInDesk_1["stat"] = 1;

						$tempInDesk_2["y0"] = $tempXCut[$i] + cut_weight;

						$tempInDesk[] = $tempInDesk_1;
				}
				$tempInDesk[] = $tempInDesk_2;
				$in2del[] = $KInDesk;
			}
		}
	}
	// todel and add news
	foreach ($in2del as $k2del => $val2del)
	{
		if(TRASS_CUT_LOG)
		{
			$trasslog[] = "kill indesk " . $InDesk[$val2del]["x0"] . ", " . $InDesk[$val2del]["y0"] . ", " . $InDesk[$val2del]["x"] . ", " . $InDesk[$val2del]["y"] ;
		}
		unset($InDesk[$val2del]);
	}
	foreach($tempInDesk as $vtempInDesk)
	{
		if(TRASS_CUT_LOG)
		{
			$trasslog[] = "add indesk " . $vtempInDesk["x0"] . ", " . $vtempInDesk["y0"] . ", " . $vtempInDesk["x"] . ", " . $vtempInDesk["y"] ;
		}
		$InDesk[] = $vtempInDesk;
	}
	// END: todel and add news

	if($new_cuts)
	{
		if($isvertic){ $isvertic = 0; }
		else{ $isvertic = 1; }
		$new_cuts = $new_cuts + setcuts($InDesk, $Cuts, $OutDesk, $isvertic, $trasslog);
	}
	return $new_cuts;
}

// ini_set("memory_limit", "2000M");
$inDesk1 = $inDesk;
$cuts1 = array();
$outDesk1 = $outDesk;
$lcuts1 = 0;
$qcuts1 = 0;

setcuts($inDesk, $cuts, $outDesk, 1, $trasslog);
setcuts($inDesk1, $cuts1, $outDesk1, 0, $trasslog);

$qcuts = count($cuts);
for($i = 0; $i < $qcuts; ++$i)
{
	$lcuts = $lcuts + sqrt( (($cuts[$i]["x"] - $cuts[$i]["x0"] + 1) * ($cuts[$i]["x"] - $cuts[$i]["x0"] + 1)) + (($cuts[$i]["y"] - $cuts[$i]["y0"] + 1) * ($cuts[$i]["y"] - $cuts[$i]["y0"] + 1)) );
}

$qcuts1 = count($cuts1);
for($i = 0; $i < $qcuts1; ++$i)
{
	$lcuts1 = $lcuts1 + sqrt( (($cuts1[$i]["x"] - $cuts1[$i]["x0"] + 1) * ($cuts1[$i]["x"] - $cuts1[$i]["x0"] + 1)) + (($cuts1[$i]["y"] - $cuts1[$i]["y0"] + 1) * ($cuts1[$i]["y"] - $cuts1[$i]["y0"] + 1)) );
}
if( ($lcuts > $lcuts1) && ($lcuts1) )
{
	$lcuts = $lcuts1;
	$qcuts = $qcuts1;
	$cuts = $cuts1;
}
else
{
	if(!$lcuts)
	{
		$lcuts = $lcuts1;
		$qcuts = $qcuts1;
		$cuts = $cuts1;
	}
}

$lcuts = $cutorderObj->out(TAB_CUTORDER_quanty) * ($lcuts/1000);
$qcuts = $qcuts * $cutorderObj->out(TAB_CUTORDER_quanty);
// ¬ычисление цены
$costcuts = $cutorderObj->out(TAB_CUTORDER_price) * $lcuts;

$lcuts = number_format(($lcuts), 3, ",", "'"); // ќбща€ длина резов
$costcuts = number_format(($costcuts), 2, ",", "'"); // ќбща€ стоимость резов
?>
