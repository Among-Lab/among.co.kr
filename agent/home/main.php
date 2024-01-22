<? session_start();?>
<?
if(!trim($_SESSION[AGRD]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>top.location.replace('../login.php'); alert('이용권한이 없습니다.');</script>";
	exit;
}
?>

<html>
<head><title>인트라넷</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="../lib/admin.css" type="text/css" rel=stylesheet>
</head>
<body bgcolor=#ffffff>
<br>
<table border=0 cellpadding=0 cellspacing=0>
<tr><td>내부 관리입니다.<br>메뉴를 이용하여 주시기 바랍니다.</td></tr>
</table>



</body>
</html>