<?php
define("NUMSTR_SEX_male", 1);
define("NUMSTR_SEX_female", 2);
define("NUMSTR_SEX_herm", 3);

define("NUMSTR_1_male", "����");
define("NUMSTR_1_female", "����");
define("NUMSTR_1_herm", "����");

define("NUMSTR_2_male", "���");
define("NUMSTR_2_female", "���");
define("NUMSTR_2_herm", "���");

define("NUMSTR_3_male", "���");
// ������
define("NUMSTR_3_female", "����");
define("NUMSTR_3_herm", "����");

define("NUMSTR_4_male", "����");
define("NUMSTR_4_female", "����");
define("NUMSTR_4_herm", "����");

define("NUMSTR_5_male", "����");
define("NUMSTR_5_female", "����");
define("NUMSTR_5_herm", "����");

define("NUMSTR_6_male", "����");
define("NUMSTR_6_female", "����");
define("NUMSTR_6_herm", "����");

define("NUMSTR_7_male", "����");
define("NUMSTR_7_female", "����");
define("NUMSTR_7_herm", "����");

define("NUMSTR_8_male", "����");
define("NUMSTR_8_female", "����");
define("NUMSTR_8_herm", "����");

define("NUMSTR_9_male", "����");
define("NUMSTR_9_female", "����");
define("NUMSTR_9_herm", "����");


function num_to_str($nm, $sex = NUMSTR_SEX_male)
{
	$lstr = strlen($s);
	if( 1 == $lstr )
	{
		return false;
	}

}

function triad_to_str($s)
{
	$lstr = strlen($s);
	if( 3 < $lstr )
	{
		return false;
	}
	if( 0 == $lstr )
	{
		return false;
	}
	if( 1 == $lstr )
	{
		return false;
	}
}

function nominative_coststr($cost)
{ // �� ����������
	$outstr = "";
//	settype($cost, "string");
	$coststr = strval($cost);
	if(10 < $cost)
	{
		
	}
}
?>
