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
<frameset rows="65,*" frameborder="no" border="0" framespacing="0" rows="*">
	<frame name="left" scrolling="no" noresize src="top.php">
	<frameset cols="217,*" frameborder="no" border="0" framespacing="0" rows="*">
		<frame name="left" scrolling="auto" noresize src="left.php">
		<frame name="content" src="main.php" marginwidth="0" marginheight="0" scrolling="auto" frameborder="0" framespacing="0">
	</frameset>
<frameset>
<noframes>
<body bgcolor="#ffffff">
<p align=center>Not Found Document and FRAME not supporting....</p>
</body>
</noframes>
</html>