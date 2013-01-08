<?php
if( $cutunitObj->del($_POST["cutid"]) )
{
	echo("1");
}
else
{
	echo("0");
}
?>
