<?php
function days_in_the_month($month, $y=0)
{
	$isvis = false; // ��� �������� ����������
	// �����������:
	if(0 == $y)
	{ $y = date("Y"); }
	// �������� ���������� �� ���
	if(2 == $month)
	{
	while(400 < $y)
	{ $y = $y - 400; }
	if(400 == $y)
	{
		$isvis = true;
	}
	else
	{
		while(100 < $y)
		{ $y = $y - 100; }
		if(100 != $y)
		{
			while(4 < $y)
			{ $y = $y - 4; }
			if(4 == $y)
			{$isvis = true;}
		}
	}
	if($isvis){return 29;}
	}
		if($month == 1) {return 31;}
		if($month == 2) {return 28;}
		if($month == 3) {return 31;}
		if($month == 4) {return 30;}
		if($month == 5) {return 31;}
		if($month == 6) {return 30;}
		if($month == 7) {return 31;}
		if($month == 8) {return 31;}
		if($month == 9) {return 30;}
		if($month == 10) {return 31;}
		if($month == 11) {return 30;}
		if($month == 12) {return 31;}
	return false;
}
// inserting date format is 2007-08-03 14:23:30
function date_str($dt) // v0.1
	{
	$yer = substr($dt, 0, 4);
	$day = substr($dt, 8, 2); settype($day, integer);
	$chas = substr($dt, 11, 2);
	$minut = substr($dt, 14, 2);
	$secund = substr($dt, 17, 2);
	$mesats = substr($dt, 5, 2); $mesatsa; // ����� � ������
/*		if($mesats == 1) {$mesatsa = "������";}
		if($mesats == 2) {$mesatsa = "�������";}
		if($mesats == 3) {$mesatsa = "�����";}
		if($mesats == 4) {$mesatsa = "������";}
		if($mesats == 5) {$mesatsa = "���";}
		if($mesats == 6) {$mesatsa = "����";}
		if($mesats == 7) {$mesatsa = "����";}
		if($mesats == 8) {$mesatsa = "�������";}
		if($mesats == 9) {$mesatsa = "��������";}
		if($mesats == 10) {$mesatsa = "�������";}
		if($mesats == 11) {$mesatsa = "������";}
		if($mesats == 12) {$mesatsa = "�������";}
*/
//	$outdt = "$chas:$minut, $day $mesatsa $yer";
//	$outdt = "$day $mesatsa";
if($day < 10){$day = "0" . $day;}
$outdt = "$day" .".". "$mesats" .".". "$yer"; // ��������: 15.12.2008
return $outdt;
	}

function date_str_mnm($dt) // v0.1
	{
	$yer = substr($dt, 0, 4);
	$day = substr($dt, 8, 2); settype($day, integer);
	$chas = substr($dt, 11, 2);
	$minut = substr($dt, 14, 2);
	$secund = substr($dt, 17, 2);
	$mesats = substr($dt, 5, 2); $mesatsa; // ����� � ������
		if($mesats == 1) {$mesatsa = "������";}
		if($mesats == 2) {$mesatsa = "�������";}
		if($mesats == 3) {$mesatsa = "�����";}
		if($mesats == 4) {$mesatsa = "������";}
		if($mesats == 5) {$mesatsa = "���";}
		if($mesats == 6) {$mesatsa = "����";}
		if($mesats == 7) {$mesatsa = "����";}
		if($mesats == 8) {$mesatsa = "�������";}
		if($mesats == 9) {$mesatsa = "��������";}
		if($mesats == 10) {$mesatsa = "�������";}
		if($mesats == 11) {$mesatsa = "������";}
		if($mesats == 12) {$mesatsa = "�������";}

//	$outdt = "$chas:$minut, $day $mesatsa $yer";
//	$outdt = "$day $mesatsa";
if($day < 10){$day = "0" . $day;}
$outdt = "$day" ."&nbsp;". "$mesatsa" ."&nbsp;". "$yer"; // ��������: 15 ������� 2008
return $outdt;
	}

function month_name($mesats)
{
		if($mesats == 1) {return "������";}
		if($mesats == 2) {return "�������";}
		if($mesats == 3) {return "����";}
		if($mesats == 4) {return "������";}
		if($mesats == 5) {return "���";}
		if($mesats == 6) {return "����";}
		if($mesats == 7) {return "����";}
		if($mesats == 8) {return "������";}
		if($mesats == 9) {return "��������";}
		if($mesats == 10) {return "�������";}
		if($mesats == 11) {return "������";}
		if($mesats == 12) {return "�������";}
}

function datetime_str($dt) // v0.1
	{
	$yer = substr($dt, 0, 4);
	$day = substr($dt, 8, 2);// settype($day, integer);
	$chas = substr($dt, 11, 2);
	$minut = substr($dt, 14, 2);
	$secund = substr($dt, 17, 2);
	$mesats = substr($dt, 5, 2);
	$outdt = "$day" .".". "$mesats" .".". "$yer" . " $chas" .":". "$minut"; // ��������: 15.12.2008 10:50
return $outdt;
	}

function time_str($dt) // v0.1
	{
	$chas = substr($dt, 11, 2);
	$minut = substr($dt, 14, 2);
	$secund = substr($dt, 17, 2);
	$outdt = "$chas" .":". "$minut"; // ��������: 14:50
return $outdt;
	}

function out_sec($dt)
{
	return substr($dt, 17, 2);
}

function out_min($dt)
{
	return substr($dt, 14, 2);
}

function out_hour($dt)
{
	return substr($dt, 11, 2);
}

function out_day($dt)
{
	return substr($dt, 8, 2);
}

function out_month($dt)
{
	return substr($dt, 5, 2);
}

function out_year($dt)
{
	return substr($dt, 0, 4);
}

function ddelt($big, $smal) // ������� �� ������� ����� ����� ������
{
	return mktime(out_hour($big), out_min($big), out_sec($big), out_month($big), out_day($big), out_year($big)) - mktime(out_hour($smal), out_min($smal), out_sec($smal), out_month($smal), out_day($smal), out_year($smal));
}
?>
