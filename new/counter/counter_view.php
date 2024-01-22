<?
$tot_file = "counter_tot.db";
$counter_file = "counter.db";

if(file_exists($counter_file)) {
	$fp = fopen($counter_file, "r");
	$buffer = fread($fp, filesize($counter_file));
	fclose($fp);
	$count = intval($buffer);
}
else {
	$count = 0;
}
?>

<html><head><title>방문통계</title><meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="../lib/default.css" type=text/css rel=stylesheet>
</head>
<body bgcolor=#ffffff topmargin=0 leftmargin=0>
<center>
<table border=0 cellpadding=2 cellspacing=0 width=500>
<tr><td colspan=2 align=center><font size=4><b>방문통계</td></tr>
</table>
<br>

<table border=0 cellpadding=2 cellspacing=1 bgcolor='#bbbbbb' width=500>

<?
$st = "20030501";
$start_d = substr($st,0,4). "년". substr($st,4,2). "월". substr($st,6,2). "일";
echo "<tr bgcolor='#eeeeff'><td colspan=2 align=right>방문통계시작일자 : ${start_d} / 전체방문수: <font color=navy>". number_format($count). "명</font> &nbsp;&nbsp;</td></tr>";


if($fpt = fopen($tot_file, "r")) {
	while(!feof($fpt)) {
		$line = trim(fgets($fpt,20));
		$cbuff = explode(" ",$line);

		$_date = mktime(0,0,0,substr($cbuff[0],4,2),substr($cbuff[0],6,2),substr($cbuff[0],0,4));
		$w = $cbuff[1]/2;
		$sdate = date(w,$_date);
		$wdate = date("Y년m월d일",$_date);
		if($sdate != 0) {
			if($cbuff[0]) echo "<tr bgcolor='#ffffff'><td width=150><font color=#777777>${wdate}</td><td width=350><img src='bar_1.jpg' width='$w' height=12 align=absmiddle><font color=#777777> [${cbuff[1]}]</td></tr>";
		}
		else {
			if($cbuff[0]) echo "<tr bgcolor='#ffffff'><td width=96><font color=#ff777777>${wdate}</td><td><img src='bar_2.jpg' width='$w' height=12 align=absmiddle><font color=#ff7777> [${cbuff[1]}]</td></tr>";
		}
	}
	fclose($fpt);
}

echo "</table>";
echo "<center><font size=1><br></font><a href='javascript:window.close()'><img src='../images/close.gif' style='border:0px;' border=0></a>";
echo "</body></html>";
?>