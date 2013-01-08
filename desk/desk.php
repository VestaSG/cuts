<?php
header("Content-type: image/gif");
header("cache-control: no-cache");

$coef = 4;
$iw = $_GET["w"] / $coef;
$ih = $_GET["h"] / $coef;
$vertstep = ($_GET["stw"] + 4) / $coef; // шаг по вертикали
$horstep = ($_GET["sth"] + 4) / $coef;

$img = imageCreate($iw, $ih);
$back_color = imageColorAllocate($img, 200, 255, 200);
$line_color = imageColorAllocate($img, 200, 0, 0);
if($_GET["stw"])
{
	for($i0 = $vertstep; $i0 < $ih; $i0 = $i0 + $vertstep)
	{ // горизонтальные линии
			imageLine($img, 0, $i0, $iw, $i0, $line_color);
	}
}
if($_GET["sth"])
{
	for($i0 = $horstep; $i0 < $iw; $i0 = $i0 + $horstep)
	{ // горизонтальные линии
			imageLine($img, $i0, 0, $i0, $ih, $line_color);
	}
}
imagegif($img);
?>
