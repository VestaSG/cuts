<?php
for($menui = 2; $menui < $mleng; ++$menui)
{
// �������� ������� � ����������� �� ������ ���������/��������������
// ������ ����, ��� ��� ������� ������������ � ��������� ����� ������ ���� �����
	$partarr[$menui]["link"] = SITE_INDEX . "?pid=" . $partarr[$menui]["id"];
}
/*
++$i;
$allparts[$i]["dir"] = SITE_INDEX . "wincalc/";
$allparts[$i]["name"] = "������� �����������";
*/
$l = count($partarr);
?>
