<?php
function wrtxt($adr_file, $str)
{
	$Saved_File = fopen($adr_file, 'a+t'); // a+ - дописываем. t необходимо, иначе редактируем в битовом режиме
	fwrite($Saved_File, $str);
	fclose($Saved_File);
}

function writelog($strlog) // функция ведения логов
{
/*	$dt = date("Y-m-d H:i:s");
	$micro = " " . substr(microtime(), 2, 3) . "";
	$log = $dt . $micro . "; " . $strlog . " <br />\n";
	echo($log);
//	wrtxt(LOGS_DIR . "/logiclogs.txt", $log);
*/}
?>
