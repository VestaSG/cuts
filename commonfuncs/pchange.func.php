<?php
// Функция заменяет в тексте "\n" указанным текстом
function pchange($text1, $smalltext)
{
return str_replace("\n", "$smalltext", $text1);
}
?>
