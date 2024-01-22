<? session_start();?>
<?
include "../lib/connect.php";
$dbCon = new dbConn();
include "bbs_as_h.php";
?>

<?
function popup_msg($msg) {
   echo("<script language=\"javascript\">
   <!--
   alert('$msg');
   history.back();
   //-->
   </script>");
}

function PDS_Head() {
	global $PHP_SELF;
	global $title_doc;
	global $part;
	global $page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
?>
<html>
<head><title></title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link href="../lib/default.css" type="text/css" rel=stylesheet>
<script src="../lib/flash.js"></script>	
	<script language="JavaScript">
	<!--
<?
	echo "var v_pgm='". $PHP_SELF. "'\n";
	echo "var v_string='page=".$page. "&spt=".$spt. "&tpt=".$tpt. "&sa=".$sa. "&sb=".$sb. "&sc=".$sc. "&sd=".$sd. "&se=".$se. "&keyword=".$keyword. "'\n";
	echo "var v_string1='part=".$part. "&spt=".$spt. "&tpt=".$tpt. "'\n";
?>
	function strCheck(str, ch, msg) {
		var s = str.value;
		for(i=0; i<s.length; i++) {
			if(ch.indexOf(s.substring(i,i+1)) == -1) {
				alert(msg + '에 허용할 수 없는 문자가 입력되었습니다');
				str.focus();
				return true;
			}
		}
		return false;
	}
	function numCheck(num, ch, msg) {
		var n = num.value;
        for (i=0; i<n.length; i++) {
			if(ch.indexOf(n.substring(i,i+1)) == -1) {
				alert(msg + '에 허용할 수 없는 문자가 입력되었습니다');
				num.focus();
				return true
			}
		}
		return false
	}
	function both_trim(a) {//양쪽문자열제거
		var search = 0
		while ( a.charAt(search) == " ") {
			search = search + 1
		}
		a = a.substring(search, (a.length))
		search = a.length - 1
		while (a.charAt(search) ==" ") { 
			search = search - 1 
		}
		return a.substring(0, search + 1)         
	}
	function checkAll() {
		var chk = document.forms.checkform;
		if (document.checkform.checkboxAll.checked == true) {
			for (var i=0; i<chk.length;i++) {
				if (chk[i].type == "checkbox" && chk[i].checked == false) {
					chk[i].checked = true;
				}
			}
		}
		else {
			for (var i=0; i<chk.length;i++) {
				if (chk[i].type == "checkbox" && chk[i].checked == true) {
					chk[i].checked = false;
				}
			}
		}
	}
	function goModifyIt(form) {
		var ChkCnt=0;
		for(var i=1; i<form.elements.length ; i++){
			 if(form.elements[i].checked){
				 ChkCnt=ChkCnt + 1;
			 }
		}
		if(ChkCnt > 1 || ChkCnt==0){
			alert('하나만 선택 하셔야 합니다.');
			return;
		} else{
			form.method="POST";
			form.action="?mode=modifyform";
			form.submit();
		}					
	}
	function goDeleteIt(form) {
		var ChkCnt=0;
		for(var i=1; i<form.elements.length ; i++){
			 if(form.elements[i].checked){
				 ChkCnt=ChkCnt + 1;
			 }
		}
		if(ChkCnt==0){
			alert('하나 이상을 선택하셔야만 합니다!');
			return;
		} else{
			if(confirm('선택하신 메시지를 삭제하시겠습니까?')){
				form.method="POST";
				form.action="?mode=delete";
				form.submit();
			} else return;
		}					
	}
	function delAction(num)	{ if( confirm("정말 삭제 하시겠습니까") )
		window.location.href="?mode=delete&number="+num+"&"+v_string; }
	function goPost() { window.location.href="?mode=postform&"+v_string;	}
	function goRead(num) { window.location.href="?mode=read&number="+num+"&"+v_string;	}
	function goModify(num) { window.location.href="?mode=modifyform&number="+num+"&"+v_string;	}
	function goReply(num) { window.location.href="?mode=replyform&number="+num+"&"+v_string;	}
	function goDelete(num)	{ if( confirm("정말 삭제 하시겠습니까") ) window.location.href="?mode=delete&number="+num+"&"+v_string;	}
	function goList() { window.location.href="?"+v_string;	}
	function goRefresh() { window.location.href="?";	}
	function goRefreshs() { window.location.href="?"+v_string1;	}
	function goPostCheckIt(form) {
		var AlphaNum = '+_-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		var Num = '0123456789';
		var PostNum = '-0123456789';

		if(both_trim(form.usernm.value) == "") {
      		alert('필수항목을 입력하여 주십시오');
	      	form.usernm.focus();
    	  	return;
   		}
		if(both_trim(form.tel.value) == "") {
      		alert('필수항목을 입력하여 주십시오');
	      	form.tel.focus();
    	  	return;
   		}
		if(both_trim(form.subject.value) == "") {
      		alert('필수항목을 입력하여 주십시오');
	      	form.subject.focus();
    	  	return;
   		}
		if(both_trim(form.comment.value) == "") {
			alert('필수항목을 입력하여 주십시오');
			form.comment.focus();
			return;
   		}
		signform.method="POST";
		signform.action="?";
		signform.submit();
		return;
	}
	//-->
	</script>
</head>
<body leftmargin="0" topmargin="0">
<?
}

function PDS_Left_Body() {
}

function PDS_PostForm() {
    global $PHP_SELF;
	global $table_width;
	global $part;
	global $page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_cnt;

?>
	<table border=0 cellpadding=0 cellspacing=0 width='<?=$table_width?>'>
	<tr><td width=15 valign=top><img src="../images/bbs_icon_arrow.gif"></td><td><font color=7f7f7f>문의 및 요청 내용을 정확하고 자세히 기재해 주시면, 더욱 빠르고 신속한 답변을 받으실 수 있습니다.</td></tr>
	<tr><td colspan=2 height=10></td></tr>
	<tr><td colspan=2 height=2 bgcolor=#555555></td></tr>
	<tr><td colspan=2 height=6></td></tr>
	</table>
		
	<table border=0 cellpadding=1 cellspacing=0 width='<?=$table_width?>'>
	<form name=signform enctype="multipart/form-data" onsubmit='return false'>
	<input type=hidden name="mode" value="postsave">
	<input type=hidden name="part" value="<?=$part?>">
	<input type=hidden name="spt" value="<?=$spt?>">
	<input type=hidden name="tpt" value="<?=$tpt?>">
	<tr><td width=120>
		<table border="0" cellpadding="0" cellspacing="0" width=125>
		<tr><td height="24" bgcolor="#e2edf4" style="border-left:solid 1 #1e60a1;border-right:solid 1 #1e60a1;border-top:solid 1 #1e60a1;border-bottom:solid 1 #1e60a1;" colspan="3"  align="center"><font color=1e60a1>이&nbsp;&nbsp;&nbsp;름</td></tr>
		</table>
		</td>
		<td width=10></td>
		<td><input type=text name=usernm size=20 maxlength=10 class=forms> <span class=ptxt7>실명으로 기입</td></tr>
	<tr><td></td><td></td><td height=1 background="../images/dot_01.gif"></td></tr>
	<tr><td>
		<table border="0" cellpadding="0" cellspacing="0" width=125>
		<tr><td height="24" bgcolor="#e2edf4" style="border-left:solid 1 #1e60a1;border-right:solid 1 #1e60a1;border-top:solid 1 #1e60a1;border-bottom:solid 1 #1e60a1;" colspan="3"  align="center"><font color=1e60a1>이메일</td></tr>
		</table>
		</td>
		<td width=10></td>
		<td><input type=text name=email size=40 maxlength=50 class=forms></td></tr>
	<tr><td></td><td></td><td height=1 background="../images/dot_01.gif"></td></tr>
	<tr><td>
		<table border="0" cellpadding="0" cellspacing="0" width=125>
		<tr><td height="24" bgcolor="#e2edf4" style="border-left:solid 1 #1e60a1;border-right:solid 1 #1e60a1;border-top:solid 1 #1e60a1;border-bottom:solid 1 #1e60a1;" colspan="3"  align="center"><font color=1e60a1>전화번호</td></tr>
		</table>
		</td>
		<td width=10></td>
		<td><input type=text name=tel size=20 maxlength=20 class=forms> <span class=ptxt7>연락 가능한 유선전화를 기입하세요</td></tr>
	<tr><td></td><td></td><td height=1 background="../images/dot_01.gif"></td></tr>
	<tr><td>
		<table border="0" cellpadding="0" cellspacing="0" width=125>
		<tr><td height="24" bgcolor="#e2edf4" style="border-left:solid 1 #1e60a1;border-right:solid 1 #1e60a1;border-top:solid 1 #1e60a1;border-bottom:solid 1 #1e60a1;" colspan="3"  align="center"><font color=1e60a1>긴급연락처</td></tr>
		</table>
		</td>
		<td width=10></td>
		<td><input type=text name=phone size=20 maxlength=20 class=forms> <span class=ptxt7>연락 가능한 핸드폰 번호를 기입하세요</td></tr>

	<?if($upload_file_cnt) {?>
	<tr><td></td><td></td><td height=1 background="../images/dot_01.gif"></td></tr>
	<input type=hidden name="MAX_FILE_SIZE" value="<?=$max_filesize?>">
	<tr><td>
		<table border="0" cellpadding="0" cellspacing="0" width=125>
		<tr><td height="24" bgcolor="#e2edf4" style="border-left:solid 1 #C6DCC1;border-right:solid 1 #C6DCC1;border-top:solid 1 #C6DCC1;border-bottom:solid 1 #C6DCC1;" colspan="3"  align="center"><font color=1e60a1>파일첨부</td></tr>
		</table>
		</td>
		<td width=10></td>
		<td>첨부파일의 총 사이즈는 <?=number_format($max_filesize/1000000)?>M 입니다.<br>
		<?
			for($i=0; $i<$upload_file_cnt; $i++) {
			echo "<input type=file name='upfile[$i]' size=45 class=forms><br>";
			}
		?>
		</td></tr>
	<?}?>
	<tr><td></td><td></td><td height=1 background="../images/dot_01.gif"></td></tr>
	<tr><td>
		<table border="0" cellpadding="0" cellspacing="0" width=125>
		<tr><td height="24" bgcolor="#e2edf4" style="border-left:solid 1 #1e60a1;border-right:solid 1 #1e60a1;border-top:solid 1 #1e60a1;border-bottom:solid 1 #1e60a1;" colspan="3"  align="center"><font color=1e60a1>문의사항</td></tr>
		</table>
		</td>
		<td width=10></td>
		<td><input type=text name=subject size=60 maxlength=120 class=forms style="width:100%;"></td></tr>
	</table>

	<table border=0><tr><td></td></tr></table>
	<table border=0 cellpadding=0 cellspacing=0 width='<?=$table_width?>'>
	<tr><td><textarea name=comment cols=88 rows=15 class=forms style="width:100%;overflow:auto"></textarea></td></tr>
	</table>


	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td>&nbsp;</td>
		<td align=right><a href="javascript:goPostCheckIt(signform)"><img src='../images/btn_103.gif' border=0 align=absmiddle></a></td></tr>
	</form>
	</table>

<?
}

function PDS_Save_Check() {
}

function PDS_PostSave() {
    global $dbCon;
	global $PHP_SELF,$db_name;

	global $part;
	global $page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $upload_file_ext,$upload_file_tdy,$arr_file_not_ext,$arr_file_yes_ext,$savedir,$saveurl;

	global $usernm,$email,$tel,$phone,$subject,$comment;
	global $upfile,$upfile_name,$upfile_size;

	$str = $dbCon->dbSelect1($db_name,"","MAX(uid),MAX(fid)");
	$row = mysql_fetch_row($str);
	if($row[0]) $new_uid = $row[0] + 1;
	else $new_uid = 1;
	if($row[1]) $new_fid = $row[1] + 1;
	else $new_fid = 1;

	$today = time();
	$client = getenv('REMOTE_ADDR');

	//확장자 체크
	$i=0;
	if($upload_file_ext) //1:이미지
	while($upfile[$i]) {
		$j=0; $file_ext_chk = 0;
		$file_ext = strtolower(substr(strrchr($upfile_name[$i],"."),1));
		while($arr_file_yes_ext[$j]) {
			if(!strcmp($file_ext,$arr_file_yes_ext[$j])) {
				$file_ext_chk = 1;
	   			break;
			}
			$j++;
		}
		if(!$file_ext_chk) {
			popup_msg("올릴 수 없는 파일 형식입니다");
			break;
			exit;
		}
		$i++;
	}
	else //0:일반
	while($upfile[$i]) {
		$j=0; $file_ext_chk = 0;
		$file_ext = strtolower(substr(strrchr($upfile_name[$i],"."),1));
		while($arr_file_not_ext[$j]) {
			if(strcmp($file_ext,$arr_file_not_ext[$j])) {
				$file_ext_chk = 1;
	   			break;
			}
			$j++;
		}
		if(!$file_ext_chk) {
			popup_msg("올릴 수 없는 파일 형식입니다");
			break;
			exit;
		}
		$i++;
	}

	//파일업로드
	$i=0;
	$fsize="";
	while($upfile[$i]) {
		$file_ext = strtolower(substr(strrchr($upfile_name[$i],"."),1));
		if($upload_file_tdy) {
			$s_upfile[$i] = $today. $i. ".". $file_ext;
			$file_path = $savedir. $s_upfile[$i];
		} else {
			$s_upfile[$i] = strtolower($upfile_name[$i]);
			$file_path = $savedir. $s_upfile[$i];
			if(file_exists($file_path)) {
				$s_upfile[$i] = $new_uid. "_". $s_upfile[$i];
				$file_path = $savedir. $s_upfile[$i];
			}
		}
        copy($upfile[$i], $file_path) || die("file upload failed!");
		$fsize = $fsize. $upfile_size[$i]. "|";
		$i++;
	}

	$arr=array($new_uid,$new_fid,$part,$spt,$tpt,0,0,0,0,0,$_SESSION[UID],$_SESSION[UPW],$usernm,$_SESSION[UNI],"",$email,$_SESSION[HPG],$tel,$phone,"","",$subject,$comment,"","",$s_upfile[0],$s_upfile[1],$s_upfile[2],$s_upfile[3],$s_upfile[4],$s_upfile[5],"","",$fsize,"",0,0,0,0,0,"",$today,$today,"",0,"A",$client);

	$re = $dbCon->dbInsert($db_name,$arr);
	if($re) {
	echo("<script>location.replace('${PHP_SELF}?mode=complete&time=${today}');</script>");
	exit;
	} else {
	popup_msg("DB 입력 오류입니다.");
	exit;
	}
}

function PDS_Complete() {
	echo "<p><p><img src='../images/img_complete.gif'></p>";
}

function PDS_Right_Body() {
}

function PDS_End() {
	echo "</body></html>";
}

if(!strcmp($mode, "complete")) {
    PDS_Head();
	PDS_Left_Body();
	PDS_Complete();
	PDS_Right_Body();
	PDS_End();
}
elseif(!strcmp($mode, "postsave")) {
	PDS_Save_Check();
	PDS_PostSave();
}
else {
    PDS_Head();
	PDS_Left_Body();
	PDS_PostForm();
	PDS_Right_Body();
	PDS_End();
}
?>