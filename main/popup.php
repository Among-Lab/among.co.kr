<?
include "../lib/connect.php";
$dbCon = new dbConn();
?>
<html>
<head><title>�˷��帳�ϴ�.</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<style>
BODY { FONT-SIZE: 9pt; COLOR: black; line-height:150%; FONT-FAMILY: ����,���� }
TD { FONT-SIZE: 9pt; COLOR: black; line-height:150%; FONT-FAMILY: ����,���� }
</style>
<SCRIPT language="JavaScript"> 
<!-- 

// ��Ű�� ����ϴ�. 
// �Ʒ� closeWin() �Լ����� ȣ��˴ϴ�
function setCookie( name, value, expiredays ) 
{ 
        var todayDate = new Date(); 
        todayDate.setDate( todayDate.getDate() + expiredays ); 
        document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";" 
        } 

// üũ�� �ݱ��ư�� �������� ��Ű�� ����� â�� �ݽ��ϴ�
function closeWin() 
{ 
        if ( document.pop.NoticePOP.checked ) 
        setCookie( "NoticePOP", "done",1);  // ������ ���ڴ� ��Ű�� ������ �Ⱓ�� �����մϴ�
        self.close(); 
} 
// --> 

</SCRIPT> 
</head> 
<!--body onLoad="self.focus();window.onblur=function(){ if(!opener.closed) window.focus()}" topmargin=0 leftmargin=0-->
<body topmargin=20 bgcolor=#ffffff>
<?

	$savedir = "../datas/pds/"; //file save directory
	$table_width = "100%";	//table width size
	$image_width = "450";//�̹��� view
	$file_download = 1;

	$str = $dbCon->dbSelect("Tboard","WHERE uid='$number' LIMIT 1");
	mysql_data_seek($str['result'],0);
	$Row=mysql_fetch_object($str['result']);


	if($Row->upfile) {
		$file_path = $savedir. $Row->upfile;
		$ref = strtolower(strrchr($Row->upfile, "."));
		if(!strcmp($ref,".gif") || !strcmp($ref,".jpg")) {
			if(file_exists($file_path)) {
				$img_size = getimagesize($file_path);
				if($img_size[0] > $image_width) $width = $image_width;
				else $width = $img_size[0];
			}
			$jpegchk = 1;
		} else $jpegchk = 0;
	} else $file_path = "";


	//---------------- visit count add
	$Row->viscnt++;
	$q_up = "UPDATE Tboard SET viscnt='$Row->viscnt' WHERE uid='$number' LIMIT 1";
	$dbCon->setResult($q_up);
?>
	<table width='<?=$table_width?>' border=0 cellpadding=5 cellspacing=1 bgcolor=#dfdfdf>
	<tr><td align=center bgcolor='#ffffff'><b><?=$Row->subject?></b></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=0 cellspacing=1>
	<tr><td height=10></td></tr>
	<tr><td align=right>�۾��� :&nbsp;
		<?if(!$Row->admchk) {?>
		<?=$Row->usernm?> &nbsp;
		<?
		if($Row->email) echo"<a href='mailto:$Row->email'><img src='../images/bbs_icon_mail.gif' border=0 align=absmiddle></a> ";
		if($Row->homepage) echo"<a href='http://$Row->homepage' target='_blank'><img src='../images/bbs_icon_hp.gif' border=0 align=absmiddle></a>";
		?>
		<?} else {?>
		<img src='../images/logo_txt.gif' align=absmiddle>
		<?}?>
		</td></tr>
	<tr><td align=right><font color=#126DA7 style='font-family:verdana; font-size:9px; letter-spacing:-1px;'>
		Lastupdate : <?= date("Y-m-d",$Row->moddate)?>, Regist : <?= date("Y-m-d",$Row->regdate)?>, Hit : <?= number_format($Row->viscnt)?></font></td></tr>
<?
	if($file_path && !$jpegchk) {
	if($file_download) {
		echo "<tr><td align=right>����÷�� : <a href='$file_path' onMouseOver=\"status='download';return true;\" onMouseOut=\"status=''\">$Row->upfile</a></td></tr>";
	} else {
		echo "<tr><td align=right>����÷�� : $Row->upfile</td></tr>";
	}
    }
?>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=10 style="table-layout:fixed;word-break:break-all;padding:0;">
	<tr><td height=10 bgcolor=#ffffff></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	<?if($jpegchk) {?>
	<tr><td align=center><a href="#" onClick="popup_image('../lib/view.php?imgsrc=<?=$file_path?>','zoom',500,500);return false"><img src="<?=$file_path?>" width="<?=$width?>" border=1 style='border-color:#cccccc;'></a></td></tr>
	<?}?>
	<tr><td class=ptxt2><?=$Row->comment?></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	</table>

	<br>

	<table width='<?=$table_width?>' border=0 cellpadding=5 cellspacing=1 bgcolor=#dfdfdf>
	<form name=pop>
	<tr><td align=center bgcolor='#ffffff'><input type=checkbox name="NoticePOP" value="">���� �Ϸ� ����â ����� ����&nbsp;&nbsp<a href="javascript:history.onclick=closeWin()">â�ݱ�</a></td></tr>
	</form>
	</table>

</body>
</html>