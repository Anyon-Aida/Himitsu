function open_login()
{
	document.getElementById('id01').style.display='block';
}
function close_login()
{
	document.getElementById('id01').style.display='none';
}
function open_register()
{
	document.getElementById('id02').style.display='block';
}
function close_register()
{
	document.getElementById('id02').style.display='none';
}

function loginBtnClicked()
{
	open_login();
	close_register();
}

function registerBtnClicked()
{
	close_login();
	open_register();
}