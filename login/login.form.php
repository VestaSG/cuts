
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Corrrrect! - ���������</title>
	<!--link rel="SHORTCUT ICON" href="http://ital/favicon.ico"-->
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />

	<link rel="stylesheet" type="text/css" href="<?=$css_login ?>" />
	
	<script type="text/javascript" src="<?=$scr_login ?>"></script>
</head>
<body>

<form
	name="loginform"
	action="/login.do.php"
	method="POST"
	onKeyUp="thrueForm();"
>

	<div>�����</div>
<INPUT
TYPE="text"
NAME="log"
VALUE=""
onblur="thrueForm();"
> <br clear="all" />

	<div>������</div>
<INPUT
TYPE="password"
NAME="pass"
VALUE=""
onblur="thrueForm();"
> <br clear="all" />

	<div>&nbsp;</div>
<INPUT disabled
class="auto"
TYPE="SUBMIT"
name="adm_send"
VALUE="�����"
>
<?php
if($_GET['err'] == "err")
	{
?>
<span class="authError">������� ��������� ���� ������ �/��� ��������</span>
<?php
	}
?>

	</form>
<!-- �������� ����� -->
<script type="text/javascript">
function thrueForm()
	{
if((trueLog()) && (truePass()))
		{
		document.loginform.adm_send.disabled = false;
		return true;
		}
	else {document.loginform.adm_send.disabled = true; return false;}
	}

function trueLog() //�������� ���������� ���� login
	{
var lenBodystr = document.loginform.log.value.length; // ����� ������ � ����
var trueSimbol = 0;
var thesimbol;

for(var thesimboln = 0; thesimboln < lenBodystr; ++thesimboln)
		{
	thesimbol = document.loginform.log.value.charAt(thesimboln);
	if((thesimbol != ";")&&(thesimbol != ":")&&(thesimbol != ",")&&(thesimbol != ".")&&(thesimbol != '\n')&&(thesimbol != " "))
			{
		++trueSimbol;
			}
		}

if(trueSimbol < 1){return false;}// alert("������ � ���� ����"); 
else {return true;}
	}

function truePass() //�������� ���������� ���� password
	{
var lenBodystr = document.loginform.pass.value.length; // ����� ������ � ����
var trueSimbol = 0;
var thesimbol;

for(var thesimboln = 0; thesimboln < lenBodystr; ++thesimboln)
		{
	thesimbol = document.loginform.pass.value.charAt(thesimboln);
	if((thesimbol != ";")&&(thesimbol != ":")&&(thesimbol != ",")&&(thesimbol != ".")&&(thesimbol != '\n')&&(thesimbol != " "))
			{
		++trueSimbol;
			}
		}

if(trueSimbol < 1){return false;}// alert("������ � ���� ����"); 
else {return true;}
	}
</script>
<!-- END: �������� ����� -->

<p>&copy; 2008 &laquo;Corrrrect!&raquo;</p>

</body>
</html>
