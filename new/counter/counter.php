<?
$tot_file = "../counter/counter_tot.db";
$counter_file = "../counter/counter.db";
$today_file = "../counter/today.db";

$fp = fopen($tot_file, "r");
fseek($fp,-15,SEEK_END);
$buffer = fread($fp, 14);
fclose($fp);

$res = split(" ",$buffer,2);

$yeday = time() - 86400;
$yeday = date("Ymd",$yeday);
if($res[0] < $yeday) {

	$fp4 = fopen($today_file, "r");
	$buffer4 = fread($fp4, filesize($today_file));
	fclose($fp4);

	$yeday_count = sprintf("%05d",$buffer4);
	$yeday_count = $yeday. " ". $yeday_count. "\n";
	$fp5 = fopen($tot_file, "a");
	flock( $fp5, LOCK_EX); 
	fwrite($fp5, $yeday_count);
	flock( $fp5, LOCK_UN); 
	fclose($fp5);

/*
	if(file_exists($today_file)) {
		$fp1 = fopen($today_file, "r");
		$buffer1 = fread($fp1, filesize($today_file));
		fclose($fp1);
		$count = intval($buffer1);
	}
	else {
		$count = 0;
	}
	if(strcmp($UserIPCount, "yes")) $count = $count + 1;
*/
	$count = 1;

	$fp3 = fopen($today_file, "w");
	flock( $fp3, LOCK_EX); 
	fwrite($fp3, $count);
	flock( $fp3, LOCK_UN);
	fclose($fp3);
}
else {
	if(file_exists($today_file)) {
		$fp1 = fopen($today_file, "r");
		$buffer1 = fread($fp1, filesize($today_file));
		fclose($fp1);
		$count = intval($buffer1);
	}
	else {
		$count = 0;
	}
	if(strcmp($UserIPCount, "yes")) $count = $count + 1;


	$fp3 = fopen($today_file, "w");
	flock( $fp3, LOCK_EX); 
	fwrite($fp3, $count);
	flock( $fp3, LOCK_UN); 
	fclose($fp3);
}


if(file_exists($counter_file)) {
	$fp7 = fopen($counter_file, "r");
	$buffer7 = fread($fp7, filesize($counter_file));
	fclose($fp7);
	$count7 = intval($buffer7);
}
else {
	$count7 = 0;
}
if(strcmp($UserIPCount, "yes")) $count7 = $count7 + 1;
$fp8 = fopen($counter_file, "w");
flock( $fp8, LOCK_EX); 
fwrite($fp8, $count7);
flock( $fp8, LOCK_UN); 
fclose($fp8);


//echo "-------[".$UserIPCount."]---------------";
/*
echo "<table border='0' cellpadding='4' cellspacing='0' width='200'>";
echo"<tr><td align=right>오늘: ". number_format($today_count);
//$today_count = sprintf("%04d",$today_count);
//printf("%d%d%d%d",substr($today_count,0,1),substr($today_count,1,1),substr($today_count,2,1),substr($today_count,3,1),substr($today_count,4,1));
echo " &nbsp; <a href=\"javascript:popup_win('../counter/counter_view.php','',520,400);\">전체: ". number_format($count);
//$count = sprintf("%06d",$count);
//printf("%d%d%d%d%d%d",substr($count,0,1),substr($count,1,1),substr($count,2,1),substr($count,3,1),substr($count,4,1),substr($count,5,1));
echo "명</a>&nbsp;&nbsp;</td></tr>";
echo "</table>";
*/

?>
