<?php
// В .htaccess эту строчКУ: AddDefaultCharset utf-8
function echoout($outstr)
{
	return iconv("windows-1251", "UTF-8", $outstr);
}
?>
