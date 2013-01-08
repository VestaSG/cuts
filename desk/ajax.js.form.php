<script type="text/javascript">
var req;
var reqTimeout;

function loadXMLDoc(url, pst)
{ // Загрузка ответа
	req = createRequestObject(); // создание ajax-объекта

	if (req)
	{
		url = encodeURI(url);

//		req.onreadystatechange = processReqChange; // Что делать, когда обновился статус запрса
		req.open("POST", url, false);
//		req.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
		req.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=windows-1251");
		req.send(pst); // если post
//		req.send(null);
		reqTimeout = setTimeout("req.abort();", 5000);
		return processReqChange();
	}
	else
	{
		alert("Браузер не поддерживает AJAX");
	}
}

function processReqChange()
{
//	document.form1.state.value = stat(req.readyState);

	if (req.readyState == 4)
	{
		clearTimeout(reqTimeout);

//		document.form1.statusnum.value = req.status;
//		document.form1.status.value = req.statusText;

		// only if "OK"
		if (req.status == 200)
		{
			return req.responseText;
		} else
		{
			alert("Не удалось получить данные:\n" + req.statusText);
		}
	}
}

function stat(n)
{
	switch (n)
	{
		case 0:
		return "не инициализирован";
		break;

		case 1:
		return "загрузка...";
		break;

		case 2:
		return "загружено";
		break;

		case 3:
		return "в процессе...";
		break;

		case 4:
		return "готово";
		break;

		default:
		return "неизвестное состояние";
	}
}

//------------------------------------------------------------------
function createRequestObject()
{
	if (window.XMLHttpRequest)
	{
	try
		{
		return new XMLHttpRequest();
		} catch (e){}

	}
	else
	{
	if (window.ActiveXObject)
		{
		try
			{
			return new ActiveXObject('Msxml2.XMLHTTP');
			} catch (e){}
		try
			{
				return new ActiveXObject('Microsoft.XMLHTTP');
			} catch (e){}
		}
	}
	return null;
}
</script>
