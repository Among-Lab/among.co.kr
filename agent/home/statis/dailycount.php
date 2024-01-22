<?
$tot_file = "../../../counter/counter_tot.db";
$counter_file = "../../../counter/counter.db";
$today_file = "../../../counter/today.db";

$icnt = 10;
?>

<html><head><title>ICLC COUNTER</title><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="../../lib/admin.css" type=text/css rel=stylesheet>
</head>
<body bgcolor=#ffffff leftmargin=10 topmargin=20>
<h4>일자별접속통계</h4>

<?
if(!$stm) {
	$stm = time() - (86400 * 30);
	$stm = date("Ymd",$stm);
}

if(file_exists($counter_file)) {
	$fp = fopen($counter_file, "r");
	$buffer = fread($fp, filesize($counter_file));
	fclose($fp);
	$tot_count = intval($buffer);
}
else {
	$tot_count = 0;
}
if(file_exists($today_file)) {
	$fp1 = fopen($today_file, "r");
	$buffer1 = fread($fp1, filesize($today_file));
	fclose($fp1);
	$today_count = intval($buffer1);
}
else {
	$today_count = 0;
}
?>

<table border=0 cellpadding=4 cellspacing=0 width=720>
<form name=dailysearch method=get action="<?=$PHP_SELF?>">
<tr valign=bottom><td>통계시작일자: <input type=text name=stm size=10 maxlength=8 value="<?=$stm?>" class=inputbox> <input type=submit value=" 확인 " class=inputbox></td>
	<td align=right>오늘방문수: <font color=navy><b><?=$today_count?> 명</b></font> &nbsp;&nbsp;&nbsp; 전체방문수: <font color=navy><b><?= number_format($tot_count)?> 명</b></font></tr>
<tr><td colspan=2 height=1 bgcolor=#bcbcbc></td></tr>
</form>
</table>


<?
if(file_exists($tot_file)) {
	$myFile = file($tot_file);
}
else {
	echo "해당 자료를 읽어 들일 수 없습니다.";
	exit;
}
?>

<br>
<table border=0 width=720>

<?
for($i=0; $i<count($myFile); $i++) {
	$str = explode(" ",$myFile[$i]);

	if($stm <= $str[0]) {
		$cnt = intval($str[1]);
		$width_ = $cnt  * $icnt;
		$_date = mktime(0,0,0,substr($str[0],4,2),substr($str[0],6,2),substr($str[0],0,4));
		$sdate = date(w,$_date);
		$wdate = date("Y년m월d일",$_date);
		if($sdate != 0) {
			if($str[0]) echo "<tr bgcolor='#ffffff'><td width=96><font color=#777777>${wdate}</td><td><img src='bar_1.jpg' width='$width_' height=12 align=absmiddle><font color=#777777> [$cnt]</td></tr>";
		}
		else {
			if($str[0]) echo "<tr bgcolor='#ffffff'><td width=96><font color=#ff777777>${wdate}</td><td><img src='bar_2.jpg' width='$width_' height=12 align=absmiddle><font color=#ff7777> [$cnt]</td></tr>";
		}
	}
}
$to = time();
$width_ = intval($today_count) * $icnt;
$sdate = date(w,$to);
$wdate = date("Y년m월d일",$to);
if($sdate != 0) {
	if($str[0]) echo "<tr bgcolor='#ffffff'><td width=96><font color=#777777>${wdate}</td><td><img src='bar_1.jpg' width='$width_' height=12 align=absmiddle><font color=#777777> [$today_count]</td></tr>";
}
else {
	if($str[0]) echo "<tr bgcolor='#ffffff'><td width=96><font color=#ff777777>${wdate}</td><td><img src='bar_2.jpg' width='$width_' height=12 align=absmiddle><font color=#ff7777> [$today_count]</td></tr>";
}
?>
</table>
</body>
</html>