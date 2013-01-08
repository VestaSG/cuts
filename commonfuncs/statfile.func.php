<?php
function write_stat_file($adr_file, $str)
{
	$Saved_File = fopen($adr_file, 'wt');
	flock($Saved_File, LOCK_EX);
	fwrite($Saved_File, $str);
	flock($Saved_File, LOCK_UN);
	fclose($Saved_File);
}

function read_stat_file($adr_file)
{
	$Saved_File = false;
	$iters = 0;
	while(!$Saved_File)
	{
		++$iters;
		$Saved_File = fopen($adr_file, 'a+t');
		if(50 < $iters){return false;}
	}
	$outs = fread( $Saved_File, 100 );
	fclose($Saved_File);
	return $outs;
}
?>
