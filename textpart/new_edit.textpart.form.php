<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Cache-Control" content="no-cache" />
	<meta http-equiv="content-type" content="text/html; charset=windows-1251" />
	<title><?=$thettl ?></title>
	<style type="text/css">
body{padding:0; margin:0;}
.main{padding-left:20px; padding-bottom:10px; padding-top:0;}
p{font-family:verdana;}

.inpcl
{
	margin-top:2px;
	border: 1px solid #aaaaaa;
	background-color:#ffffff;
}
.submbutton
{
	width:504px;
	height:70px;
	font-size:18pt;
	font-weight:600;
	margin-top:8px;
}
.fieldtitle
{
	padding-right:5px;
	text-align:right;
	width:195px;
	float:left;
	margin-top:0;
	margin-bottom:0;
}
.main .fieldtitle
{
	color:darkgray;
	text-align:left;
	font-weight: bold;
}
input
{
	width:500px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
select
{
	width:304px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
textarea
{
	margin-top:2px;
	width:500px;
	height:400px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
.partform {padding-left:20px; padding-bottom:0; padding-top:10px; display:none;}
.partform .inpcl
{
	margin-top:2px;
	border: 1px solid #aaaaaa;
	background-color:#ffffff;
}
.partform .submbutton
{
	width:304px;
	height:50px;
	font-size:18pt;
	font-weight:600;
	margin-top:8px;
}
.partform .fieldtitle
{
	font-size:10pt;
	padding-right:5px;
	text-align:right;
	width:195px;
	float:left;
	margin-top:0;
	margin-bottom:0;
}
.partform input
{
	width:300px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
.partform select
{
	width:304px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
.partform textarea
{
	margin-top:2px;
	width:300px;
	height:200px;
	font-family:verdana;
	/*color:#0099AA;*/
	font-size:9pt;
}
img{/* border-width: 0; */ border-color: black; border-width:1px; border-style: solid;}

		div.content {padding:20px 15px 0 15px;}
		div.content div {float:left; height:100%;}
		div.content div.jpart { float:none; }
		div.content div.jpart div { float:none; }
		div.content div.c0 {width:4%; min-width:30px;}
		div.content div.c0 br {line-height:1px;}
		div.content div.c1 {width:67%;}
		div.content div.c2 {width:45%; padding-left:8px;}
		div.content div.c3 {/* background-color: #aaccff; */ padding-top: 30px; width:28%; float:right;  text-align: center;}
		div.content div.c3 div.im {float: none; display: inline-block; margin-bottom: 8px; }
		div.content div.c3 div.im a {color:green;}
		div.content div.c3 div.fdel {font-family: arial; color: red; font-weight: bold; float: right;}
		div.content div.c3 div.fdel a {color: red; text-decoration:overline;}
		div.content div.c4 {width:62%; float:left; padding-left:7px;}
		div.content div.c5 {width:72%; float:left;}
		div.content div.indent {height:30px;}

		br{line-height: 1px;}
/**/
.jpart a.jact
{
	margin-left:220px;
	margin-bottom:20px;
	text-decoration:none;
	border-bottom:1px dashed;
}
.jpart a.jact:link {color:#0000CC;}
.jpart a.jact:visited {color: #0000CC;}
.jpart a.jact:hover {color: #0097FF;}

<?php
include(TEXT_MODUL . "/css.top.form.php");
?>
	</style>
</head>
<body>
	<?php include(TEXT_MODUL . "/top.form.php"); ?>
	<div class="content">
		<!-- left column -->
		<div class="c1">
	<div class="jpart">
		<script type="text/javascript">
function hsm()
{
	pf = document.getElementById("partform");
	if("block" == pf.style.display)
	{
		pf.style.display = "none";
	}
	else
	{
		pf.style.display = "block";
	}
}
		</script>
		<a class="jact" href="#" onclick="hsm()">Раздел</a>
		<div class="partform" id="partform">
			<?php include(MENU_MODUL . "/light.edit.menu.inc.php"); ?>
		</div>
		<br clear="all" />
		<hr />
	</div>
	<div class="main">
		<?php $textpart->showf(); ?>
	</div>
		</div>
		<!-- END: left column -->
		<div class="c0"><br /></div>
		<!-- right column -->
		<div class="c3">
<?php
for($i=0; $i < $latt; ++$i)
{
?>
			<div class="im">
				<a href="#" onclick="adim(<?=$attar[$i]["jsfunc"] ?>)"><img src="<?=$attar[$i]["src"] ?>" height="150" /></a>
				<div class="fdel"><a href="<?=$attar[$i]["delhref"] ?>">del</a></div>
			</div>
			<br clear="all" />
<?php
}
?>
			<div class="im"><a href="<?=pub_tex_addfile ?>">Добавить файл</a></div>
		</div>
		<!-- END: right column -->
		<br clear="all" />
	</div>
	<br clear="all" />
	<!-- footer -->
	<!-- / footer -->
</body>
<script type="text/javascript">
function adim(id)
{
	getTextAreaSelection("tpbody").setSelectedText("%img"+id+"%", "");
}
	// Массив экземпляров объекта
var textAreaSelectionObjects = [];
// Получаем экземпляр объекта
function getTextAreaSelection(id)
{
    if (typeof(textAreaSelectionObjects[id]) == "undefined")
	{
        textAreaSelectionObjects[id] = new textAreaSelectionHelper(id);
    }
    return textAreaSelectionObjects[id];
}
// Конструктор, принимает в качестве аргумента ID текстарии
function textAreaSelectionHelper(id) {
    var obj = document.getElementById(id);
    this.target = obj;
    // Создаем свойства carretHandler для доступа к объекту в контексте узла
    // из обработчиков событий
    this.target.carretHandler = this;
    // Добавляем обработчик событий
    this.target.onchange = _textareaSaver;
    this.target.onclick = _textareaSaver;
    this.target.onkeyup = _textareaSaver;
    this.target.onfocus = _textareaSaver;
    if(document.attachEvent) this.target.onselect = _textareaSaver;
    // Свойства для запоминания позиции выделения
    this.start=-1;
    this.end=-1;
    this.scroll=-1;
    this.iesel=null;
}
// В прототип записываем методы
textAreaSelectionHelper.prototype = {
    // Получим выделение
    getSelectedText : function() {
        return this.iesel? this.iesel.text: (this.start>=0&&this.end>this.start)? this.target.value.substring(this.start,this.end): "";
    },
    // Установим текстовые фрагменты до выделения - text
    // и после него, если нужно - secondtag
    setSelectedText : function(text, secondtag) {
        if (this.iesel) {
            if (typeof(secondtag) == "string") {
                var l = this.iesel.text.length;
                this.iesel.text = text + this.iesel.text + secondtag;
                this.iesel.moveEnd("character", -secondtag.length);
                this.iesel.moveStart("character", -l);
            } else {
                this.iesel.text = text;
            }
            this.iesel.select();
        } else if (this.start >= 0 && this.end >= this.start) {
            var left = this.target.value.substring(0, this.start);
            var right = this.target.value.substr(this.end);
            var scont = this.target.value.substring(this.start, this.end);
            if (typeof(secondtag) == "string") {
                this.target.value = left + text + scont + secondtag + right;
                this.end = this.target.selectionEnd=this.start+text.length+scont.length;
                this.start = this.target.selectionStart = this.start + text.length;
            } else {
                this.target.value = left + text + right;
                this.end = this.target.selectionEnd = this.start + text.length;
                this.start = this.target.selectionStart = this.start + text.length;
            }
            this.target.scrollTop = this.scroll;
            this.target.focus();
        } else {
            this.target.value += text + ((typeof(secondtag) == "string") ? secondtag: "");
            if (this.scroll >= 0) this.target.scrollTop = this.scroll;
        }
    },
}
// Обработчик событий. Занимается сохранением информации о выделении и позиции скролла
function _textareaSaver() {
    if(document.selection) {
        this.carretHandler.iesel = document.selection.createRange().duplicate();
    } else if(typeof(this.selectionStart) != "undefined") {
        this.carretHandler.start = this.selectionStart;
        this.carretHandler.end = this.selectionEnd;
        this.carretHandler.scroll = this.scrollTop;
    } else {
        this.carretHandler.start = this.carretHandler.end = -1;
    }
}

getTextAreaSelection("tpbody");
</script>
</html>
