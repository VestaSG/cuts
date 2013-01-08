<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
	<title><?//= ?></title>

<style type="text/css">
.inpcl{ border: 1px solid #aaaaaa; background-color:#ffffff; }
.fieldtitle {padding-right:5px; text-align:right; width:195px; float:left; margin-top:0; margin-bottom:0;}
.errtxt{color:#aa0000; margin-left:200px;}

a:link {color: #0000CC;}
a:visited {color: #0000CC;}
a:hover {color: #0097FF;}
</style>

<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
<meta http-equiv="cache-control" content="no-cache" />
</head>
<body>

	<form name="<?=$logformname ?>" action="aut.do.php" method="post" onsubmit="return submiting();" onkeyup="thrueForm();" >

<p class="fieldtitle"><?=$title_log ?></p>
<input type="text" class="inpcl" name="<?=$logform_log ?>" value="<?=$logvalue_log ?>" />
<br clear="all" />

<p class="fieldtitle"><?=$title_pas ?></p>
<input type="password" class="inpcl" name="<?=$logform_pas ?>" value="<?=$logvalue_pas ?>" />
<br clear="all" />

<p class="fieldtitle"><?=$title_submit ?>&nbsp;</p>
<input type="submit" name="<?=$logform_submit ?>" value="<?=$logvalue_submit ?>" />
<br clear="all" />

	</form>
<p class="errtxt"><?=$errtext ?></p>
</body>
</html>

<!-- Проверка формы -->
<script type="text/javascript">
function thrueForm()
	{
if((trueLog()) && (truePass()))
		{
		document.<?=$logformname ?>.<?=$logform_submit ?>.disabled = false;
		return true;
		}
	else {document.<?=$logformname ?>.<?=$logform_submit ?>.disabled = true; return false;}
	}

function trueLog() //Проверка заполнения поля login
	{
var lenBodystr = document.<?=$logformname ?>.<?=$logform_log ?>.value.length; // Длина строки в поле
var trueSimbol = 0;
var thesimbol;

for(var thesimboln = 0; thesimboln < lenBodystr; ++thesimboln)
		{
	thesimbol = document.<?=$logformname ?>.<?=$logform_log ?>.value.charAt(thesimboln);
	if((thesimbol != ";")&&(thesimbol != ":")&&(thesimbol != ",")&&(thesimbol != ".")&&(thesimbol != '\n')&&(thesimbol != " "))
			{
		++trueSimbol;
			}
		}

if(trueSimbol < 1){return false;} // alert("Ошибка в этом поле"); 
else {return true;}
	}

function truePass() //Проверка заполнения поля password
	{
var lenBodystr = document.<?=$logformname ?>.<?=$logform_pas ?>.value.length; // Длина строки в поле
var trueSimbol = 0;
var thesimbol;

for(var thesimboln = 0; thesimboln < lenBodystr; ++thesimboln)
		{
	thesimbol = document.<?=$logformname ?>.<?=$logform_pas ?>.value.charAt(thesimboln);
	if((thesimbol != ";")&&(thesimbol != ":")&&(thesimbol != ",")&&(thesimbol != ".")&&(thesimbol != '\n')&&(thesimbol != " "))
			{
		++trueSimbol;
			}
		}

if(trueSimbol < 1){return false;}// alert("Ошибка в этом поле"); 
else {return true;}
	}
</script>
<!-- END: Проверка формы -->
