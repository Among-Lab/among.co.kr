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
<link href="../lib/admin.css" type="text/css" rel=stylesheet>
</head>
<body bgcolor=#ffffff>
<br>
<table border=0 cellpadding=0 cellspacing=0>
<tr><td>���� �����Դϴ�.<br>�޴��� �̿��Ͽ� �ֽñ� �ٶ��ϴ�.</td></tr>
</table>



</body>
</html>