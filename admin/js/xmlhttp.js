var xmlhttp = false;

try
{
	xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
}
catch (e)
{
	try
	{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	catch (e)
	{
		xmlhttp = false;
	}
}

if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
{
	xmlhttp = new XMLHttpRequest();
}

function request(url, onSuccess, onFailure)
{
	xmlhttp.open('GET', url);
	xmlhttp.onreadystatechange = function ()
	{
		if (4 == xmlhttp.readyState)
		{
			if (200 == xmlhttp.status)
			{
				onSuccess();
			}
			else
			{
				onFailure();
			}
		}
	};
	xmlhttp.send(null);
}
