<?
if($imgfile_name) {
	$full_imgname = explode(".",$imgfile_name);
	$ext = strtolower($full_imgname[sizeof($full_imgname)-1]);
	if($ext != "jpg" && $ext != "gif" && $ext != "swf") {
		echo "<script>alert('������ �ʴ� ���� �����Դϴ�.');self.close();</script>";
		exit;
	} else {		
		$image_size_info=@getimagesize($imgfile);
		if($image_size_info) {
			$img_w=$image_size_info[0];
			$img_h=$image_size_info[1];
			if($img_w > 640) $img_w = 640;
			if($img_h > 430) $img_h = 430;
		} else {
			echo "<script>alert('���ϻ���� ���ϴµ� �����Ͽ����ϴ�.');self.close();</script>";
			exit;
		}
	}
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="../../lib/default.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="../../lib/loadFlash.js" type="text/javascript"></script>
<SCRIPT language="JavaScript">
<!-- 
function closeWin() 
{ 
	imgWidth =<?=$img_w?>;
	imgHeight =<?=$img_h?>;
	
	opener.signform.pwidth.value = imgWidth;
	opener.signform.pheight.value = imgHeight;
	self.close();
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="EFEFEF">
<form>
	<tr>
		<td align="center"  valign="middle" bgcolor="EFEFEF">
			<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="EFEFEF">	
				<tr>
					<td valign="middle" align="center">
						���ϻ����� : ���� <?=$image_size_info[0]?> X ���� <?=$image_size_info[1]?><br><br>
						<?if($image_size_info[0] > 640 || $image_size_info[1] > 430) {
							echo "�ִ�ũ�⸦ �ʰ��Ͽ� �ִ�ũ��� ��ȯ�˴ϴ�.<br>";
							echo" ( ���ϻ����� : ���� $img_w X ���� $img_h)";
						}?>
					</td>
				</tr>				
			</table>
		</td>
	</tr>	
	<tr>
		<td height="50" valign="middle" bgcolor="EFEFEF">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>					
					<td align="center"><input type="button" value="âũ�⿡ ����" onClick="closeWin()">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</form>
</table>
</body>
</html>