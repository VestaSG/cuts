<?php
define("NUMSTR_SEX_male", 1);
define("NUMSTR_SEX_female", 2);
define("NUMSTR_SEX_herm", 3);

define("NUMSTR_1_male", "один");
define("NUMSTR_1_female", "одна");
define("NUMSTR_1_herm", "одно");

define("NUMSTR_2_male", "два");
define("NUMSTR_2_female", "две");
define("NUMSTR_2_herm", "два");

define("NUMSTR_3_male", "три");
// дальше
define("NUMSTR_3_female", "одна");
define("NUMSTR_3_herm", "одно");

define("NUMSTR_4_male", "один");
define("NUMSTR_4_female", "одна");
define("NUMSTR_4_herm", "одно");

define("NUMSTR_5_male", "один");
define("NUMSTR_5_female", "одна");
define("NUMSTR_5_herm", "одно");

define("NUMSTR_6_male", "один");
define("NUMSTR_6_female", "одна");
define("NUMSTR_6_herm", "одно");

define("NUMSTR_7_male", "один");
define("NUMSTR_7_female", "одна");
define("NUMSTR_7_herm", "одно");

define("NUMSTR_8_male", "один");
define("NUMSTR_8_female", "одна");
define("NUMSTR_8_herm", "одно");

define("NUMSTR_9_male", "один");
define("NUMSTR_9_female", "одна");
define("NUMSTR_9_herm", "одно");


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
{ // до миллиардов
	$outstr = "";
//	settype($cost, "string");
	$coststr = strval($cost);
	if(10 < $cost)
	{
		
	}
}
?>
