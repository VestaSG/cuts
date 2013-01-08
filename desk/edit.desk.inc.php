<?php
setlocale(LC_NUMERIC, 'C');
$cutorderObj->load($_GET[UNIKEY]);
$cutId = $cutorderObj->outid();
$masshtab = $cutorderObj->out(TAB_CUTORDER_scale); // на сколько умножать интерфейсные пиксели для получения реальных миллиметров
$minWH = $cutorderObj->out(TAB_CUTORDER_th) / $masshtab;

$deskCount = $cutunitObj->load_for_order( $cutId );
?>
<!DOCTYPE html>
<html style="background-color: #fff;">
<head>
	<meta charset="windows-1251">
	<title>Распиловка <?=$cutorderObj->out(TAB_CUTORDER_name); ?></title>
		<link rel="stylesheet" href="<?=SITE_INDEX ?>jquery/css/base.css" />
		<link rel="stylesheet" href="<?=SITE_INDEX ?>jquery/css/jquery-ui.css" />
	<script src="<?=SITE_INDEX ?>jquery/jquery-1.4.4.min.js"></script>

	<script src="<?=SITE_INDEX ?>jquery/ui/jquery.ui.core.js"></script>
	<script src="<?=SITE_INDEX ?>jquery/ui/jquery.ui.widget.js"></script>
	<script src="<?=SITE_INDEX ?>jquery/ui/jquery.ui.mouse.js"></script>
	<script src="<?=SITE_INDEX ?>jquery/ui/jquery.ui.draggable.js"></script>
	<script src="<?=SITE_INDEX ?>jquery/ui/jquery.ui.resizable.js"></script>
		<link rel="stylesheet" href="<?=SITE_INDEX ?>jquery/css/ui-darkness/jquery-ui-1.8.7.custom.css" />
<?php
$padin = (cut_weight/2)/$masshtab;
$mainh = $cutorderObj->out(TAB_CUTORDER_h); $mainh = $mainh/$masshtab;
$mainw = $cutorderObj->out(TAB_CUTORDER_w); $mainw = $mainw/$masshtab;
$snap = $padin + ($cutorderObj->out(TAB_CUTORDER_th)/$masshtab);

include_once(DESK_MODUL . "/ajax.js.form.php");
?>
	<style>
	.foot{ width: 100%; padding-top:10px; font-size:8pt; color:#777777; border-top: 1px solid #777777; margin-top:10px; font-family:verdana;}
	.foot p{padding:0; padding-left:40px; padding-top:5px; margin:0;}

	.ui-widget-content { position:absolute; width: 150px; height: 250px; padding: <?=$padin ?>px; border-width: 0; top:0; left:0; }
	.fld { margin:0; background-color:#999999; }
	.fldb { width:40px; }
	.fldsub { width:40px; }
	.dtitle { font-weight:bold; background-color:#555555; }
	.demo{z-index:1; padding:0; background-color: #ddeeff/*f4f0ad*/;}
	.demo-description{width:600px; border-radius:10px; border: 1px solid #0000ff; background-color:#ddeeff; z-index:10; margin-top:15px; padding-top:0px; margin-left:20px; padding-left:20px; margin-bottom:0px; font-size:12px; color:#0000ff; }
	br{line-height:0;}
	</style>
</head>
<body style="/* padding:25px; */">

<div class="demo" id="dem" style="width: <?=$mainw ?>px; height: <?=$mainh ?>px;">
	<script type="text/javascript">
var deskCount = 0; // <?=$deskCount ?>;

function drrr(i)
{
var jqId = "#" + i;
// $( "#ajaxr" ).attr( "value", ( <?=$padin ?> + parseInt($(jqId).css( "height" ).split("px").join("")) + parseInt($(jqId).css( "top" ).split("px").join("")) + parseInt($(jqId).css( "padding-bottom" ).split("px").join("")) + parseInt($(jqId).css( "padding-top" ).split("px").join("")) /* */ ));

		// Когда элемент приблизился к нижнему краю поля
		if ( <?=$mainh ?> < ( 1+ <?=$padin ?> + parseInt($(jqId).css( "height" ).split("px").join("")) + parseInt($(jqId).css( "top" ).split("px").join("")) + /* parseInt($(jqId).css( "padding-bottom" ).split("px").join("")) + */ parseInt($(jqId).css( "padding-top" ).split("px").join(""))) )
		{ $(jqId).css( "padding-bottom", "0px" ); }
		else{ $(jqId).css( "padding-bottom", "<?=$padin ?>px" ); }

		// Когда элемент приблизился к правому краю поля
		if ( <?=$mainw ?> < ( 1+ <?=$padin ?> + parseInt($(jqId).css( "width" ).split("px").join("")) + parseInt($(jqId).css( "left" ).split("px").join("")) + /* parseInt($(jqId).css( "padding-bottom" ).split("px").join("")) + */ parseInt($(jqId).css( "padding-left" ).split("px").join(""))) )
		{ $(jqId).css( "padding-right", "0px" ); }
		else{ $(jqId).css( "padding-right", "<?=$padin ?>px" ); }

		if ( "0px" == $(jqId).css( "top" ) )
		{
			$(jqId).css( "padding-top", "0px" );
//			$(jqId).css( "padding-bottom", "<?= 2 * $padin ?>px" );
		}
		else
		{
			$(jqId).css( "padding-top", "<?=$padin ?>px" );
//			$(jqId).css( "padding-bottom", "<?=$padin ?>px" );
		}

		if ( "0px" == $(jqId).css( "left" ) )
		{
			$(jqId).css( "padding-left", "0px" );
//			$(jqId).css( "padding-right", "<?= 2 * $padin ?>px" );
		}
		else
		{
			$(jqId).css( "padding-left", "<?=$padin ?>px" );
//			$(jqId).css( "padding-right", "<?=$padin ?>px" );
		}

	document.getElementById(i + "-w").value = <?=$masshtab ?> * $(jqId).css("width").split("px").join("");
	document.getElementById(i + "-h").value = <?=$masshtab ?> * $(jqId).css("height").split("px").join("");
	document.getElementById(i + "-l").value = <?=$masshtab ?> * $(jqId).css("left").split("px").join("");
	document.getElementById(i + "-t").value = <?=$masshtab ?> * $(jqId).css("top").split("px").join("");
}

function newdesk()
{
	addesk(100, 200, 0, 100, 0);
}

function addesk(w, h, l, t, id)
{
	// Вставляем доску
<?php
/*	JS
//	$(".artf").remove(); // Удаление элемента
//	$("#tag").empty(); // Очиска содержимого элемента
//	$("#tag").append("<div></div>"); // Вставка элемента

	var fld5 = document.createElement('div');
	var fldDiv = document.getElementById("dem");
	fld5.id = "draggable"  + deskCount;
	fldDiv.appendChild(fld5); // вставка в див
*/
?>
	var newdeskid = "draggable" + deskCount;
	$("#dem").append("<div id=\"" + newdeskid + "\"></div>");

	$("#"+newdeskid).attr( "class", "ui-widget-content" );
	$("#"+newdeskid).css("position", "absolute");
	$("#"+newdeskid).css("top", t + "px");
	$("#"+newdeskid).css("left", l + "px");
	$("#"+newdeskid).css("width", w + "px");
	$("#"+newdeskid).css("height", h + "px");
	// END: Вставляем доску

	// Вставляем в доску поля значений
<?php
/*	JS
	fld5 = document.createElement('p');
	fld5.innerHTML = "Desk " + deskCount;
	fld5.className = "dtitle";
	fldDiv = document.getElementById("draggable"  + deskCount);
	fldDiv.appendChild(fld5); // вставка в див

	fld5 = document.createElement('p');
	fld5.innerHTML = "длина";
	fld5.className = "fld";
	fldDiv = document.getElementById("draggable"  + deskCount);
	fldDiv.appendChild(fld5); // вставка в див
	fld5 = document.createElement('input');
	fld5.className = "fldb";
	fld5.id = "draggable" + deskCount + "-w";
	fldDiv = document.getElementById("draggable"  + deskCount);
	fldDiv.appendChild(fld5); // вставка в див

	итд...
*/
?>
	$("#"+newdeskid).append("<p class=\"dtitle\">Desk " + deskCount + "</p>");
	$("#"+newdeskid).append("<p class=\"fld\">Ширина</p>");
	$("#"+newdeskid).append("<input class=\"fldb\" id=\"" + newdeskid + "-w\" />");
	$("#"+newdeskid).append("<p class=\"fld\">Высота</p>");
	$("#"+newdeskid).append("<input class=\"fldb\" id=\"" + newdeskid + "-h\" />");
	$("#"+newdeskid).append("<p class=\"fld\">Сверху</p>");
	$("#"+newdeskid).append("<input class=\"fldb\" id=\"" + newdeskid + "-t\" />");
	$("#"+newdeskid).append("<p class=\"fld\">Слева</p>");
	$("#"+newdeskid).append("<input class=\"fldb\" id=\"" + newdeskid + "-l\" />");
	$("#"+newdeskid).append("<input type=\"hidden\" id=\"" + newdeskid + "-id\" value=\""+id+"\" />");
	$("#"+newdeskid).append("<br /><input class=\"fldb\" type=\"button\" id=\"" + newdeskid + "-del\" value=\"del\" onclick=\"return deldesk("+deskCount+");\" />");
	// END: Вставляем в доску поля значений

	$( "#"+newdeskid ).draggable();
	$( "#"+newdeskid ).draggable({ containment: 'parent' });
	$( "#"+newdeskid ).draggable({ snap: true });
	$( "#"+newdeskid ).draggable({ snapMode: 'outer' });
	$( "#"+newdeskid ).draggable({ snapTolerance: <?=$snap ?> });
	$( "#"+newdeskid ).resizable();
	$( "#"+newdeskid ).resizable({ containment: 'parent' });
	$( "#"+newdeskid ).resizable({ minWidth: <?=$minWH ?> });
	$( "#"+newdeskid ).resizable({ minHeight: <?=$minWH ?> });

	$( "#"+newdeskid ).bind( "resize", function(event, ui) { drrr( $(this).attr( "id" ) ); } );
	$( "#"+newdeskid ).bind( "drag", function(event, ui) { drrr( $(this).attr( "id" ) ); } );
	$( "#"+newdeskid ).bind( "resizestart", function(event, ui) {
		$( ".ui-widget-content" ).css("z-index", "1");
		$( this ).css("z-index", "2");
	});
	$( "#"+newdeskid ).bind( "dragstart", function(event, ui) {
		$( ".ui-widget-content" ).css("z-index", "1");
		$( this ).css("z-index", "2");
	});

	drrr( newdeskid ); // пересчет значений в полях

	++deskCount;

	$("#"+newdeskid).children(".fldb").blur(function()
	{
		// получить id
		var dragid = $( this ).attr("id").match(/draggable\d+/i);
		dragid = dragid[0];
		// draggable5-l или draggable5392-l
		// проверить значение
		// присвоить новое положение элементу
		$("#"+dragid).css("top", ($( "#"+dragid+"-t" ).attr("value")/<?=$masshtab ?>) + "px");
		$("#"+dragid).css("left", ($( "#"+dragid+"-l" ).attr("value")/<?=$masshtab ?>) + "px");
		$("#"+dragid).css("width", ($( "#"+dragid+"-w" ).attr("value")/<?=$masshtab ?>) + "px");
		$("#"+dragid).css("height", ($( "#"+dragid+"-h" ).attr("value")/<?=$masshtab ?>) + "px");
	});
}

function deldesk(i)
{
	var rezult = 1;
	if($("#draggable" + i + "-id").attr("value"))
	{
		 rezult = loadXMLDoc("<?=cut_http_jdel ?>", "cutid=" + $("#draggable" + i + "-id").attr("value"));
	}
	if(rezult)
	{
		$("#draggable" + i).remove();
	}
	return false;
}
var vals = Array();
<?php
for($i = 0; $i < $deskCount; ++$i)
{
	$unit_id = $cutunitObj->outid($i);
	$uh = $cutunitObj->out(TAB_CUTDESKS_h, $i)/$masshtab;
	$uw = $cutunitObj->out(TAB_CUTDESKS_w, $i)/$masshtab;
	$ut = $cutunitObj->out(TAB_CUTDESKS_t, $i)/$masshtab;
	$ul = $cutunitObj->out(TAB_CUTDESKS_l, $i)/$masshtab;
?>
vals[<?=$i ?>] = Array();
vals[<?=$i ?>]["w"] = <?=$uw ?>;
vals[<?=$i ?>]["h"] = <?=$uh ?>;
vals[<?=$i ?>]["l"] = <?=$ul ?>;
vals[<?=$i ?>]["t"] = <?=$ut ?>;
vals[<?=$i ?>]["id"] = <?=$unit_id ?>;
<?php
}
?>
for(i=0; i < <?=$deskCount ?>; ++i)
{
	addesk(vals[i]["w"], vals[i]["h"], vals[i]["l"], vals[i]["t"], vals[i]["id"]);
}
</script>
</div>
	<script type="text/javascript">
function getXMLDocument(url, postr)
{
	loadXMLDoc(url, postr);
	if(window.XMLHttpRequest)
	{
		return req.responseXML;
	}
	else
	{
		if(window.ActiveXObject)
		{
			return req;
		}
		else
		{
			alert("Загрузка XML не поддерживается браузером");
			return null;
		}
	}
}

var i = 1;
var hidedvals = false;
var saveiter = 0;
$(function()
{
	$( "#newd" ).click(function()
	{
		var masht = <?=$masshtab ?>;
		var madeW = document.getElementById("start-w").value/masht;
		var madeH = document.getElementById("start-h").value/masht;
		var madeT = document.getElementById("start-t").value/masht;
		var madeL = document.getElementById("start-l").value/masht;
		var madeQ = document.getElementById("start-q").value;

		if( (!madeQ) && ("" == madeL) )
		{
			var qiters = 0;
			madeL = 0;
			while( ((1+qiters)*madeW ) < <?=$mainw ?>)
			{
				addesk(madeW, madeH, madeL, madeT, 0);
				++qiters;
				madeL = qiters * (madeW + <?=$padin * 2 ?>);
			}
		}

		if(madeQ)
		{
			for(i=0; i < madeQ; ++i)
			{
				addesk(madeW, madeH, madeL, madeT, 0);
			}
		}
	});

	$( "#sv" ).click(function()
	{
		$( "#sv" ).attr("disabled", "disabled"); // Кнопка недоступна до завершения сохранения
		var poststr = "";
		for( i=0; i < deskCount; ++i )
		{
			if(null != document.getElementById("draggable" + i))
			{
				drrr("draggable" + i); // можно только после осуществления двухсторонней связи положение-значение поля
				poststr = poststr + "draggable" + i + "-w=" + document.getElementById("draggable" + i + "-w").value + "&";
				poststr = poststr + "draggable" + i + "-h=" + document.getElementById("draggable" + i + "-h").value + "&";
				poststr = poststr + "draggable" + i + "-l=" + document.getElementById("draggable" + i + "-l").value + "&";
				poststr = poststr + "draggable" + i + "-t=" + document.getElementById("draggable" + i + "-t").value + "&";
				poststr = poststr + "draggable" + i + "-id=" + document.getElementById("draggable" + i + "-id").value + "&";
			}
		}
		poststr = poststr + "quanty=" + deskCount + "&";
		poststr = poststr + "cutid=<?=$cutId ?>";
		$( "#saved" ).css("color", "red");

		// Проверка наложений!
		$(".ui-widget-content").css("background-color", "#000000");
		var iscross = 0;
		for( i=0; i < deskCount; ++i )
		{
			if(null != document.getElementById("draggable" + i))
			{
				for( i2=(i+1); i2 < deskCount; ++i2 )
				{
					if( (null != document.getElementById("draggable" + i2)) && (i2 != i) )
					{
						if
						(
							!( (parseInt($("#draggable" + i).css("left").match(/\d+/i)[0]) + parseInt($("#draggable" + i).css("width").match(/\d+/i)[0])) < parseInt($("#draggable" + i2).css("left").match(/\d+/i)[0]) ) &&
							!( (parseInt($("#draggable" + i).css("top").match(/\d+/i)[0]) + parseInt($("#draggable" + i).css("height").match(/\d+/i)[0])) < parseInt($("#draggable" + i2).css("top").match(/\d+/i)[0]) ) &&
							!( (parseInt($("#draggable" + i2).css("left").match(/\d+/i)[0]) + parseInt($("#draggable" + i2).css("width").match(/\d+/i)[0])) < parseInt($("#draggable" + i).css("left").match(/\d+/i)[0]) ) &&
							!( (parseInt($("#draggable" + i2).css("top").match(/\d+/i)[0]) + parseInt($("#draggable" + i2).css("height").match(/\d+/i)[0])) < parseInt($("#draggable" + i).css("top").match(/\d+/i)[0]) )
						)
						{
							++iscross;
							$("#draggable" + i).css("background-image", "none");
							$("#draggable" + i).css("background-color", "#cc0000");
							$("#draggable" + i2).css("background-image", "none");
							$("#draggable" + i2).css("background-color", "#cc0000");

//							alert("Перекрытие между draggable" + i + " и draggable" + i2);
						}
						else
						{
//							alert("Нет перекрытия между draggable" + i + " и draggable" + i2);
						}
					}
				}
			}
		}
		// END: Проверка наложений!

		if(iscross)
		{
			alert("Имеются перекрытия");
		}
		else
		{
	//		var saveresp = loadXMLDoc("<?=cut_http_jdo ?>", poststr);
			var saveresp = getXMLDocument("<?=cut_http_jdo ?>", poststr);
			if(req.responseText)
			{
				// Обработка xml-документа
				var list = saveresp.getElementsByTagName("dsk");
				var llist = list.length;
				if(llist)
				{
					for(i = 0; i < llist; ++i)
					{
						$("#draggable" + list[i].getAttribute("id") + "-id").attr("value", list[i].getAttribute("dbid"));
					}
				}
			}

			$( "#saved" ).css("color", "green");
			++saveiter;
			var savtime = new Date();
			saveiter = "Сохранено в " + savtime.toTimeString();
			$( "#saved" ).html(saveiter);
		}
		$( "#sv" ).attr("disabled", ""); // Кнопка снова доступна
	});

	// Скрытие/показ значений элементов
	$( "#hid_vals" ).click(function()
	{
		var disp = "none";
		if(hidedvals)
		{
			disp = "block";
			hidedvals = false;
			$( "#hid_vals" ).attr("value", "Скрыть значения");
		}
		else
		{
			hidedvals = true;
			$( "#hid_vals" ).attr("value", "Показать значения");
		}
		$( ".fld" ).css("display", disp);
		$( ".fldb" ).css("display", disp);
	});

	$( "#newfull" ).click(function()
	{
		var masht = <?=$masshtab ?>;
		var madeW = document.getElementById("start-w").value/masht;
		var madeH = document.getElementById("start-h").value/masht;
		var madeT = 0;
		var madeL = 0;
//		var madeQ = document.getElementById("start-q").value;

		var qitersH = 0;
		while( ( ((1+qitersH)*madeH) + (qitersH*<?=$padin ?>*2) ) < (1+<?=$mainh ?>) )
		{
			var qitersW = 0;
			madeL = 0;
			while( ( ((1+qitersW)*madeW) + (qitersW*<?=$padin ?>*2) ) < (1+<?=$mainw ?>) )
			{
				addesk(madeW, madeH, madeL, madeT, 0);
				++qitersW;
				madeL = (qitersW * (madeW + (<?=$padin ?> * 2) )) - <?=$padin ?>;
			}
			++qitersH;
			madeT = (qitersH * (madeH + (<?=$padin ?> * 2) )) - <?=$padin ?>;
		}
	});
});
	</script>

<div class="demo-description">
	<p>Используйте эту форму, чтобы создать схему распила пластмассовой заготовки</p>
	<input class="fldsub" id="start-h" value="400" />&nbsp;&nbsp;&nbsp;Высота [мм],<br />
	<input class="fldsub" id="start-w" value="200" />&nbsp;&nbsp;&nbsp;Ширина [мм],<br />
	<input class="fldsub" id="start-l" value="0" />&nbsp;&nbsp;&nbsp;Положение слева [мм],<br />
	<input class="fldsub" id="start-t" value="0" />&nbsp;&nbsp;&nbsp;Положение сверху [мм],<br />
	<input class="fldsub" id="start-q" value="1" />&nbsp;&nbsp;&nbsp;Количество [штук]
	<p><input id="newd" type="button" value="Создать еще" /></p>
	<p><input id="newfull" type="button" value="Заполнить всё" /></p>
	<p><input id="hid_vals" type="button" value="Скрыть значения" /></p>
	<p><input id="sv" type="button" value="Сохранить" />&nbsp;&nbsp;&nbsp;<span id="saved"></span></p>
</div>
	<br clear="all" />
<?php
include(DESK_MODUL . "/foot.desk.form.php");
?>

</body>
</html>
