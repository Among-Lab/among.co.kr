<? session_start();?>
<?
if(!trim($_SESSION[AGRD]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>top.location.replace('../login.php'); alert('�̿������ �����ϴ�.');</script>";
	exit;
}
?>
<html>
<head><title>��Ʈ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
</head>
<body leftmargin="0" topmargin="0" style="background:url(../images/top_bg.jpg) #ffffff top left repeat-x ">
<table border=0 cellpadding=10 cellspacing=0 height=100%>
<tr><td valign=top><img src="../images/top_logo.jpg"></td><td>&nbsp;</td></tr>
</table>
</body>
</html>