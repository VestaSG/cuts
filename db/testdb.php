<?php
$the_host = 'localhost'; // Host name
$mysqluser = "serzh28"; // ��� ������� � MySQL-�������
$the_pass = '101183'; // ������ ������� � MySQL-�������
$base_name = "serzh28"; // ��� ��


include_once("trash.class.php");
//	db dbstory
$testdb = new trashManager($mysqluser, $the_pass, $the_host, $base_name);
$sel = "SELECT * FROM plases ORDER BY id ;";
//	$testdb->setdelfield("users");
//	$testdb->setdelfield("plases");

$testdb->setquery($sel);
echo("<hr>");
echo($testdb->out(2, "seeksys"));
echo("<br>");
echo($testdb->out(2, "plase"));
echo("<br>");

$testdb->disconnect();
echo("<hr>");

$testdb->serverconnect();
$testdb->dbconnect();
$testdb->setquery("SELECT * FROM users ORDER BY status ;");
echo("<hr>");
echo($testdb->out(0, "log"));
echo("<br>");
echo($testdb->out(0, "nic") . "<hr>");
echo("<br>");
echo($_SERVER["REMOTE_ADDR"]."<br>");

$testdb->setquery("insert into users values (NULL, '��', '��', '��') ;");

// ���������� � ����� � �������
$resp = mysql_query(" SHOW FIELDS FROM marks; ");
$num = mysql_num_rows($resp); // ���������� ����� (����� � �������)
echo($num . "<br>");
for($it = 0; $it < $num; ++$it)
	{
$therow = mysql_fetch_array($resp);
echo($therow[0] . "; "); // ��� ����
echo($therow[1] . "; "); // ��� ����
echo($therow[2] . "; "); // ���� ����
echo($therow[3] . "<br>"); // ����
	}

/*
preg_match_all("/DELETE[^;]+FROM ([^ ]+)(;|$|[ ]+)(WHERE)*([^;]*)(;|$)/Usi", "DELETE * FROM tab ;", $regmas);
	
	$siz = sizeof($regmas[1]);
$upd = "";
	for ($i = 0; $i < $siz; $i++)
		{
		$upd.= "UPDATE " . $regmas[1][$i] . " SET del='del' " . $regmas[3][$i] . $regmas[4][$i] . "; ";
		}
		echo("<br>" . $upd);
*/
?>