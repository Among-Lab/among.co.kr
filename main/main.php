<?
setCookie("UserIPCount","yes");
?>
<?
include "../lib/connect.php";
$dbCon = new dbConn();
?>
<?
function StrCut($string,$cut) {
	$cut_string = strip_tags($string);
	if(strlen($cut_string) > $cut AND $cut != "0") {
		for($i=0; $i<$cut-1; $i++) {
			if(ord(substr($cut_string, $i, 1))>127) $i++;
		}
		$cut_string = sprintf("%s", substr($cut_string, 0, $i)."...");
	}
	return $cut_string;
}
function Board_List($TBName,$Part,$Url,$Cnt,$Cut){
	global $dbCon;

	$str = $dbCon->dbSelect($TBName, "WHERE part='$Part' AND deldate<1 ORDER BY regdate DESC LIMIT $Cnt", "uid,part,subject,regdate");

	echo "<table border=0 cellpadding=0 cellspacing=0 width='100%'>";
	for($i=0;$i<$str['cnt'];$i++){
		mysql_data_seek($str['result'],$i);
		$Row=mysql_fetch_object($str['result']);

		$uid = $Row->uid;
		$part = $Row->part;
		$subject = $Row->subject;
		$regdate = date("y.m.d",$Row->regdate);

		$subject = StrCut($Row->subject,$Cut);
		$sUrl = $Url. "?mode=read&part=".$part."&number=".$uid;

		echo "<tr><td height='18'><img src='../images/bul_001.gif' align=absmiddle><a href='$sUrl'>".$subject."</a></td></tr>";
	}
	echo "</table>";
}
?>
<?include "../lib/head.php"?>
<script language="JavaScript">
function getCookiePOP( name ){
        var nameOfCookie = name + "=";
        var x = 0;
        while ( x <= document.cookie.length )
        {
                var y = (x+nameOfCookie.length);
                if ( document.cookie.substring( x, y ) == nameOfCookie ) {
                        if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
                                endOfCookie = document.cookie.length;
                        return unescape( document.cookie.substring( y, endOfCookie ) );
                }
                x = document.cookie.indexOf( " ", x ) + 1;
                if ( x == 0 )
                        break;
        }
        return "";
}
</script>
</head>
<body leftmargin="0" topmargin="0" style="background:url(../images/bg_mainback.jpg) #ffffff top left repeat-X">


<?include "../lib/top.php"?>

<table border="0" cellpadding="0" cellspacing="0" width="900">
<tr><td height="352" valign="top">
	<DIV style="POSITION: absolute;">
	<DIV id=main style="POSITION: absolute; TOP:-100px;">	
	<script>var objf=fflash("../images/main.swf",1000,452,"main","transparent");documentwrite(objf);</script>	
	</DIV></DIV>

	<DIV style="POSITION: absolute;">
	<DIV id=maintxt style="left:557px; POSITION: absolute; TOP:30px;">	
	<script>var objf=fflash("../images/main_txt.swf",350,115,"maintxt","transparent");documentwrite(objf);</script>	
	</DIV></DIV>


</td></tr>
</table>



<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background:url(../images/bg_con.gif) #ffffff top left repeat-X">
<tr><td>
	
	<table border="0" cellpadding="0" cellspacing="0" width="900">
	<tr><td height="33"><img src="../images/space.gif" width="1" height="33"></td></tr>
	</table>
	<table border="0" cellpadding="0" cellspacing="0" width="900">
	<tr><td width="30"><img src="../images/space.gif" width="30" height="1"></td>
		<td width="310" valign="top">
		
		<!--------------공지사항----------------->
		<table border="0" cellpadding="0" cellspacing="0" width="310">
		<tr><td><img src="img/tit_notice.gif" border="0" usemap="#notice"></td></tr>
		<tr><td height="8"></td></tr>
		</table>

		<table border="0" cellpadding="0" cellspacing="0" width="310">	
		<tr><td valign=top><? Board_List("Tboard",1,"../customer/notice.php",4,46); ?></td></tr>
		</table>

		<map name="notice">		
		  <area shape="rect" coords="261,4,307,18" href="../customer/notice.php">		
		</map>	
		<!--------------//공지사항 end----------------->
		
		
		</td>
		<td width="29"><img src="../images/space.gif" width="29" height="1"></td>
		<td width="123" valign="top">

		<table border="0" cellpadding="0" cellspacing="0"><tr><td height="2"></td></tr></table>
		<!--------------홍보동영상----------------->	
		<?include "vod.php"?>		
		<!--------------//홍보동영상 end----------------->

		</td>
		<td width="23"><img src="../images/space.gif" width="23" height="1"></td>
		<td width="385" valign="top">
		
		<table border="0" cellpadding="0" cellspacing="0" width="385">
		<tr><td width="200" valign="top"><a href="#"><img src="img/ban_dvr.gif" border="0" usemap="#dvr"></a></td>
			<td width="15"><img src="../images/space.gif" width="15" height="1"></td>
			<td width="170" valign="top">
			<table border="0" cellpadding="0" cellspacing="0" width="170">
			<tr><td height="96" valign="top" background="img/img_quick.gif" style="padding:28 0 0 80">
			
				<table border="0" cellpadding="0" cellspacing="0" width="90">
				<tr><td><a onmouseover="MM_swapImage('cate_001','','img/quick_01_on.gif',1)" onmouseout=MM_swapImgRestore() 
				href="../biz/image.php"><img src="img/quick_01.gif" border=0 name=cate_001></a></td></tr>	<!--영상인식솔루션--> 		
				<tr><td><a onmouseover="MM_swapImage('cate_002','','img/quick_02_on.gif',1)" onmouseout=MM_swapImgRestore() 
				href="../biz/repair.php"><img src="img/quick_02.gif" border=0 name=cate_002></a></td></tr>		<!--유지보수--> 	
				<tr><td><a onmouseover="MM_swapImage('cate_003','','img/quick_03_on.gif',1)" onmouseout=MM_swapImgRestore() 
				href="../customer/as.php"><img src="img/quick_03.gif" border=0 name=cate_003></a></td></tr>		<!--a/s 및 견적요청--> 	
				</table>		
			
			</td></tr>
			</table>
			</td></tr>
		</table>


		<map name="dvr">		
		  <area shape="rect" coords="89,62,156,81" href="../product/dvr.php">		
		</map>


		<table border="0" cellpadding="0" cellspacing="0" width="385">
		<tr><td><img src="img/img_callcenter.gif"></td></tr>
		</table>
		
		
		</td></tr>
	</table>

</td></tr>
</table>


<br style="line-height:15px">
<?include "../lib/trail.php"?>

<?include "../counter/counter.php"?>
<?//Auto Popup Program start.
$str = $dbCon->dbSelect1("Tboard", "WHERE part='1' AND mchk='1' ORDER BY regdate DESC LIMIT 1", "uid");
$row = mysql_fetch_row($str);
$popid = $row[0];
if($popid) {
?>
<script language="JavaScript">
if ( getCookiePOP( "NoticePOP" ) != "done" ) {
        noticeWindow  =  window.open('./popup.php?number=<?=$popid?>','NoticePOP','resizable=yes,scrollbars=yes,left=10, top=10, width=500,height=550');
        noticeWindow.opener = self;
}
</script>
<?
}//Auto Popup End.
?>

<script language="JavaScript">
function getCookie( name ){
        var nameOfCookie = name + "=";
        var x = 0;
        while ( x <= document.cookie.length )
        {
                var y = (x+nameOfCookie.length);
                if ( document.cookie.substring( x, y ) == nameOfCookie ) {
                        if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
                                endOfCookie = document.cookie.length;
                        return unescape( document.cookie.substring( y, endOfCookie ) );
                }
                x = document.cookie.indexOf( " ", x ) + 1;
                if ( x == 0 )
                        break;
        }
        return "";
}
/*
if ( getCookie( "Notice" ) != "done" ) {
        noticeWindow  =  window.open('../popup/20090201.htm','notice','left=10, top=10, width=348,height=388');
        noticeWindow.opener = self;
}*/
</script>