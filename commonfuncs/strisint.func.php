<?php
function str_is_int($int_str)
{
if(preg_match("/[^0-9]+/i", $int_str)) { return false; } // ���� �� �����
return true;
}
?>
