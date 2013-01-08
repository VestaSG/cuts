<script type="text/javascript">
var req;
var reqTimeout;

function loadXMLDoc(url, pst)
{ // �������� ������
	req = createRequestObject(); // �������� ajax-�������

	if (req)
	{
		url = encodeURI(url);

//		req.onreadystatechange = processReqChange; // ��� ������, ����� ��������� ������ ������
		req.open("POST", url, false);
//		req.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=utf-8");
		req.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=windows-1251");
		req.send(pst); // ���� post
//		req.send(null);
		reqTimeout = setTimeout("req.abort();", 5000);
		return processReqChange();
	}
	else
	{
		alert("������� �� ������������ AJAX");
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
			alert("�� ������� �������� ������:\n" + req.statusText);
		}
	}
}

function stat(n)
{
	switch (n)
	{
		case 0:
		return "�� ���������������";
		break;

		case 1:
		return "��������...";
		break;

		case 2:
		return "���������";
		break;

		case 3:
		return "� ��������...";
		break;

		case 4:
		return "������";
		break;

		default:
		return "����������� ���������";
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
