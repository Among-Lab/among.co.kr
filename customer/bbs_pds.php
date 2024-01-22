<? session_start();?>
<?
include "../lib/connect.php";
$dbCon = new dbConn();
include "bbs_pds_h.php";
if($allow_comment) include "../lib/fnote.php";
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

function make_where ($blank_is, $column_list, $word, $ban) {
	global $word_list;

	if($ban) {
		$like = "NOT LIKE";
		$join = "AND";
	}
	else {
		$like = "LIKE";
		$join = "OR";
	}

	$word = stripslashes($word);
	$temp = eregi_replace("(\")(.*)( +)(.*)(\")","\\2[###blank###]\\4",$word);
	$temp = eregi_replace("\(|\)| and | or "," ",$temp);
	//$temp = eregi_replace("\(|\)| and | or "," \\0 ",$temp);
	$temp = trim(eregi_replace(" {2,}"," ",$temp));
	$result[word] = eregi_replace("\(|\)| and | or "," ",$temp);

	$temp = explode(" ",$temp);
	$word_list = $temp;

	for($i=0; $i < sizeof($temp); $i++) {
		if($i) {
			if(eregi("^\)$",$temp[$i-1]) && !eregi("^or$|^and$",$temp[$i])) {
				$temp2[] = $blank_is;
			}

			if(!eregi("^(\(|\)|and|or)$",$temp[$i-1]) && eregi("^\($",$temp[$i])) {
				$temp2[] = $blank_is;
			}

			if(!eregi("^(\(|\)|and|or)$",$temp[$i-1]) && !eregi("^(\(|\)|and|or)$",$temp[$i])) {
				$temp2[] = $blank_is;
			}
		}

		$temp2[] = $temp[$i];
	}



	for($i=0; $i< sizeof($temp2); $i++) {
		if(eregi("^(\(|\)|and|or)$",$temp2[$i])) {
			continue;
		}

		unset($temp);
		$temp .= "(";
		$temp2[$i] = addslashes($temp2[$i]);
		$column_list_array =explode(",",$column_list);

		for($j=0; $j< sizeof($column_list_array); $j++) {
			if($j && $temp && $temp!="(") {
				$temp .= " $join";
			}
			$temp .= " $column_list_array[$j] $like '%$temp2[$i]%'";
		}

		$temp .= ")";
		$temp2[$i] = $temp;
	}

	$temp = implode(" ",$temp2);
	$result[where] = str_replace("[###blank###]"," ",$temp);

	return $result;
}

function PDS_Head() {
	global $PHP_SELF;
	global $title_doc;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
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
	function popup_image(page,nam,wid,hit){ //스크롤이 있는경우
		var  windo=eval('window.open("'+page+'","'+nam+'","status=no,toolbar=no,resizable=no,scrollbars=yes, menubar=no,width='+wid+',height='+hit+',top=10,left=10")'); 
	}
	function popup_image0(page,nam,wid,hit){ //스크롤이 없는경우
		var  windo=eval('window.open("'+page+'","'+nam+'","status=no,toolbar=no,resizable=no,scrollbars=no, menubar=no,width='+wid+',height='+hit+',top=10,left=10")'); 
	}
	function file_download(path,filename) { window.location.href="../lib/download.php?path="+path+"&filename="+filename; }
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
	function goModifyCheckIt(form) {
		var AlphaNum = '+_-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		var Num = '0123456789';
		var PostNum = '-0123456789';

		if(both_trim(form.usernm.value) == "") {
      		alert('필수항목을 입력하여 주십시오');
	      	form.usernm.focus();
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
<body leftmargin="0" topmargin="0" style="background-color:transparent">
<?
}

function PDS_Left_Body() {
}

function PDS_PostForm() {
    global $PHP_SELF;
	global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_cnt;

?>
	<script language="JavaScript" type="text/javascript" src="/alditor/alditor.js"></script>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#cccccc></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>글등록</td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=4 cellspacing=0>
	<form name=signform enctype="multipart/form-data" onsubmit='return false'>
	<input type=hidden name="mode" value="postsave">
	<input type=hidden name="part" value="<?=$part?>">
	<input type=hidden name="spt" value="<?=$spt?>">
	<input type=hidden name="tpt" value="<?=$tpt?>">
	<input type=hidden name="usernm" value="<?=$_SESSION[UNM]?>">
	<tr><td width='100'><b>제목</td>
		<td><input type=text name=subject size=60 maxlength=120 class=forms style="width:450;"></td></tr>
	<?if($upload_file_cnt) {?>
	<tr><td colspan=2 bgcolor=#e7e7e7 height=1></td></tr>
	<tr><td><b>파일첨부</td>
		<td>첨부파일의 총 사이즈는 <?=sprintf("%.1f", $max_filesize/1000000)?>M 입니다.<br>
		<?for($i=0; $i<$upload_file_cnt; $i++) echo "<input type=file name='upfile[$i]' size=45 class=forms><br>";?>
		</td></tr>
	<!--tr bgcolor=#f7f7f7><td align=right>파일정렬</td><td bgcolor=#ffffff><input type=radio name=falign value='left'>왼쪽<input type=radio name=falign value='center' checked>가운데<input type=radio name=falign value='right'>오른쪽</td></tr>
	<tr bgcolor=#f7f7f7><td align=right>파일설명</td><td bgcolor=#ffffff><input type=text name=fdesc size=60 maxlength=100 class=forms></td></tr-->
	<?}?>
	</table>

	<table border=0 cellpadding=0 cellspacing=0 width='<?=$table_width?>'>
	<tr><td><textarea name=comment cols=88 rows=18 class=forms style="width:<?=$table_width?>;overflow:auto"></textarea></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td>&nbsp;</td>
		<td align=right><a href="javascript:goPostCheckIt(signform)"><img src='../images/btn_103.gif' border=0 align=absmiddle></a> <a href="javascript:goList()"><img src='../images/btn_102.gif' border=0 align=absmiddle></a></td></tr>
	</form>
	</table>

<?
}

function PDS_Save_Check() {
}

function PDS_PostSave() {
    global $dbCon;
	global $PHP_SELF,$db_name;

	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_ext,$upload_file_tdy,$arr_file_not_ext,$arr_file_yes_ext,$savedir,$saveurl;

	global $usernm,$subject,$comment;
	global $mchk,$nchk;
	global $upfile,$upfile_name,$upfile_size;

	$str = $dbCon->dbSelect1($db_name,"","MAX(uid),MAX(fid)");
	$row = mysql_fetch_row($str);
	if($row[0]) $new_uid = $row[0] + 1;
	else $new_uid = 1;
	if($row[1]) $new_fid = $row[1] + 1;
	else $new_fid = 1;

	$today = time();
	$client = getenv('REMOTE_ADDR');
	if(!$mchk) $mchk = 0;
	if(!$nchk) $nchk = 0;

	//이미지업로드 및 지원하는 형식 확장자 체크
	$file_count = 0; $file_ext_chk = 0;
	for($i = 0; count($upfile) > $i; $i++)
	if($upfile[$i]) {
		$file_count++;
		$file_ext = strtolower(substr(strrchr($upfile_name[$i],"."), 1));
		if($upload_file_ext) { if(!array_search($file_ext, $arr_file_yes_ext)) { $file_ext_chk = 1; break; }}
		else { if(array_search($file_ext, $arr_file_not_ext)) { $file_ext_chk = 1; break; }}
	}

	//사이즈체크
	$filesize = 0;
	for($i=0; count($upfile)>$i; $i++) $filesize +=  $upfile_size[$i];
	if((($file_count > 0) && ($filesize == 0)) || ($filesize > $max_filesize)) $file_siz_chk = 1;

	if($file_ext_chk) { popup_msg("올릴 수 없는 파일 형식입니다."); exit;
	} elseif($file_siz_chk) { popup_msg("파일 사이즈가 큽니다."); exit;
	} else {

		$j=0;
		$fsize = "";
		for($i=0; count($upfile)>$i; $i++)
		if($upfile[$i]) {
			$upfile_name[$i] = str_replace(" ", "_", $upfile_name[$i]);
			$file_ext = strtolower(substr(strrchr($upfile_name[$i], "."), 1));
			if($upload_file_tdy) $s_upfile[$j] = $today. "_".$i. ".". $file_ext;
			else {
				$s_upfile[$j] = strtolower($upfile_name[$i]);
				if(file_exists($savedir. $s_upfile[$j])) $s_upfile[$j] = $new_uid. "_". $s_upfile[$j];
			}
			copy($upfile[$i], $savedir. $s_upfile[$j]) || die("file upload failed!");
			$fsize = $fsize. $upfile_size[$i]. "|";
			$j++;
		}

		$arr=array($new_uid,$new_fid,$part,$spt,$tpt,$mchk,$nchk,0,0,0,$_SESSION[UID],$_SESSION[UPW],$usernm,$_SESSION[UNI],"",$_SESSION[EML],$_SESSION[HPG],"","","","",$subject,$comment,"","",$s_upfile[0],$s_upfile[1],$s_upfile[2],$s_upfile[3],$s_upfile[4],$s_upfile[5],"","",$fsize,"",0,0,0,0,1,"",$today,$today,"",0,"A",$client);

		$re = $dbCon->dbInsert($db_name,$arr);
		if($re) {
		echo("<script>location.replace('${PHP_SELF}?page=1&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}&time=${today}');</script>");
		exit;
		} else {
			popup_msg("DB 입력 오류입니다."); exit;
		}
	}
}

function PDS_ModifyForm() {
	global $dbCon;
	global $PHP_SELF,$db_name;

	global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;

	global $number;
	global $max_filesize,$upload_file_cnt;

	$result = $dbCon->dbSelect1($db_name,"WHERE uid='$number'","userid");
	$real_userid = mysql_result($result,0,0);
	if( !(trim($_SESSION[UID]) && !strcmp($real_userid,$_SESSION[UID]))) {//글 등록 아이디와 현재 수정 아이디가 같은지..
		popup_msg("수정하실 수 없습니다.");
		exit;
	}

	$str = $dbCon->dbSelect1($db_name,"WHERE uid='$number' LIMIT 1");
	$data = mysql_fetch_array($str);
	$subject = ereg_replace("\"","&quot;",$data[subject]);
?>
	<script language="JavaScript" type="text/javascript" src="/alditor/alditor.js"></script>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#cccccc></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>글수정</td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=4 cellspacing=0>
	<form name=signform enctype="multipart/form-data" onsubmit='return false'>
	<input type=hidden name="mode" value="modifysave">
	<input type=hidden name="number" value="<?=$number?>">
	<input type=hidden name="page" value="<?=$page?>">
	<input type=hidden name="part" value="<?=$part?>">
	<input type=hidden name="spt" value="<?=$spt?>">
	<input type=hidden name="tpt" value="<?=$tpt?>">
	<input type=hidden name="sa" value="<?=$sa?>">
	<input type=hidden name="sb" value="<?=$sb?>">
	<input type=hidden name="sc" value="<?=$sc?>">
	<input type=hidden name="sd" value="<?=$sd?>">
	<input type=hidden name="se" value="<?=$se?>">
	<input type=hidden name="keyword" value="<?=$keyword?>">
	<input type=hidden name="usernm" value="<?=$data[usernm]?>">
	<tr><td width='100'><b>제목</td>
		<td><input type=text name=subject size=60 maxlength=120 class=forms value="<?=$subject?>" style="width:450;"></td></tr>
	<?if($upload_file_cnt) {
		$upfile = array($data[upfile],$data[upfile1],$data[upfile2],$data[upfile3],$data[upfile4],$data[upfile5]);
		$fsize = explode('|', $data[fsize]);
	?>
	<tr><td colspan=2 bgcolor=#e7e7e7 height=1></td></tr>
	<tr><td><b>파일첨부</td>
		<td>첨부파일의 총 사이즈는 <?=sprintf("%.1f", $max_filesize/1000000)?>M 입니다.<br>
		<?
		$j= 0;
		for($i=0; count($upfile)>$i; $i++)
		if($upfile[$i]) {
			$j++;
			echo "<input type=hidden name='upfile_tmp[$i]' value='$upfile[$i]'>";
			echo "<input type=hidden name='upfile_size_tmp[$i]' value='$fsize[$i]'>";
			echo "<input type=file name='upfile[$i]' size=45 class=forms> <input type=checkbox name=upfile_del[$i] value=1>삭제시체크<br>";
		}
		for($k=$j; $upload_file_cnt>$k; $k++) echo "<input type=file name='upfile[$k]' size=45 class=forms><br>";
		?>
	</td></tr>
	<!--tr bgcolor=#f7f7f7><td align=right>파일정렬</td><td bgcolor=#ffffff><input type=radio name=falign value='left' <?if(!strcmp($Row->falign,"left")) echo"checked";?>>왼쪽<input type=radio name=falign value='center' <?if(!strcmp($Row->falign,"center")) echo"checked";?>>가운데<input type=radio name=falign value='right' <?if(!strcmp($Row->falign,"right")) echo"checked";?>>오른쪽</td></tr>
	<tr bgcolor=#f7f7f7><td align=right>파일설명</td><td bgcolor=#ffffff><input type=text name=fdesc size=60 maxlength=100 class=forms value="<?=$Row->fdesc?>"></td></tr-->
	<?}?>
	</table>

	<table border=0 cellpadding=0 cellspacing=0 width='<?=$table_width?>'>
	<tr><td><textarea name=comment cols=88 rows=18 class=forms style="width:<?=$table_width?>;overflow:auto"><?=nl2br($data[comment])?></textarea></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td>&nbsp;</td>
		<td align=right><a href="javascript:goModifyCheckIt(signform)"><img src='../images/btn_107.gif' border=0 align=absmiddle></a> <a href="javascript:goList()"><img src='../images/btn_102.gif' border=0 align=absmiddle></a></td></tr>
	</form>
	</table>
<?
}

function PDS_ModifySave() {
    global $dbCon;
	global $PHP_SELF,$db_name;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_ext,$upload_file_tdy,$upload_file_cnt,$arr_file_not_ext,$arr_file_yes_ext,$savedir,$saveurl;

	global $number;
    global $usernm,$subject,$comment;
	global $mchk,$nchk;
	global $upfile,$upfile_name,$upfile_size,$upfile_tmp,$upfile_size_tmp,$upfile_del;

	$today = time();
	$client = getenv('REMOTE_ADDR');
	if(!$mchk) $mchk = 0;
	if(!$nchk) $nchk = 0;

	//이미지업로드 및 지원하는 형식 확장자 체크
	$file_count = 0; $file_ext_chk = 0;
	for($i = 0; count($upfile) > $i; $i++)
	if($upfile[$i]) {
		$file_count++;
		$file_ext = strtolower(substr(strrchr($upfile_name[$i],"."), 1));
		if($upload_file_ext) { if(!array_search($file_ext, $arr_file_yes_ext)) { $file_ext_chk = 1; break; }}
		else { if(array_search($file_ext, $arr_file_not_ext)) { $file_ext_chk = 1; break; }}
	}

	//사이즈체크
	$filesize = 0;	$j = 0; $fsize = "";
	for($i=0; count($upfile_tmp)>$i; $i++)
	if($upfile_del[$i]) {
		if(file_exists($savedir . $upfile_tmp[$i])) unlink($savedir . $upfile_tmp[$i]);
	} else {
		$s_upfile[$j] = $upfile_tmp[$i];
		$filesize += $upfile_size_tmp[$i];
		$fsize = $fsize. $upfile_size_tmp[$i]. "|";
		$j++;
	}

	for($i=0; count($upfile)>$i; $i++) $filesize += $upfile_size[$i];
	if((($file_count > 0) && ($filesize == 0)) || ($filesize > $max_filesize)) $file_siz_chk = 1;

	if($file_ext_chk) { popup_msg("올릴 수 없는 파일 형식입니다."); exit;
	} elseif($file_siz_chk) { popup_msg("파일 사이즈가 큽니다."); exit;
	} else {

		//$fsize = "";
		for($i=count($upfile_tmp); count($upfile)>$i; $i++)
		if($upfile[$i]) {
			$upfile_name[$i] = str_replace(" ", "_", $upfile_name[$i]);
			$file_ext = strtolower(substr(strrchr($upfile_name[$i], "."), 1));
			if($upload_file_tdy) $s_upfile[$j] = $today. "_".$i. ".". $file_ext;
			else {
				$s_upfile[$j] = strtolower($upfile_name[$i]);
				if(file_exists($savedir. $s_upfile[$j])) $s_upfile[$j] = $number. "_". $s_upfile[$j];
			}
			copy($upfile[$i], $savedir. $s_upfile[$j]) || die("file upload failed!");
			$fsize = $fsize. $upfile_size[$i]. "|";
			$j++;
		}

		$arr=array("mchk"=>$mchk,"nchk"=>$nchk,"subject"=>$subject,"comment"=>$comment,"upfile"=>$s_upfile[0],"upfile1"=>$s_upfile[1],"upfile2"=>$s_upfile[2],"upfile3"=>$s_upfile[3],"upfile4"=>$s_upfile[4],"upfile5"=>$s_upfile[5],"fsize"=>$fsize,"moduser"=>$_SESSION[UID],"moddate"=>$today,"remoteip"=>$client);

		$dbCon->dbUpdate($db_name,$arr,"WHERE uid='$number' LIMIT 1");
		echo("<script>location.replace('${PHP_SELF}?page=${page}&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}&time=${today}');</script>");
	}
}

function PDS_ReplyForm() {
	global $dbCon;
	global $PHP_SELF,$db_name;
	global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_cnt;

	global $number;

	$str = $dbCon->dbSelect1($db_name,"WHERE uid='$number' LIMIT 1","fid,usernm,subject,thread");
	$data = mysql_fetch_array($str);
	$subject = ereg_replace("\"","&quot;",$data[subject]);
	$comment = $data[usernm]. "님의 글에 대한 답변입니다.";
?>
	<script language="JavaScript" type="text/javascript" src="/alditor/alditor.js"></script>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#cccccc></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>답변글 등록</td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=4 cellspacing=0>
	<form name=signform enctype="multipart/form-data" onsubmit='return false'>
	<input type=hidden name="mode" value="replysave">
	<input type=hidden name="number" value="<?=$number?>">
	<input type=hidden name="fid" value="<?=$data[fid]?>">
	<input type=hidden name="thread" value="<?=$data[thread]?>">
	<input type=hidden name="page" value="<?=$page?>">
	<input type=hidden name="part" value="<?=$part?>">
	<input type=hidden name="spt" value="<?=$spt?>">
	<input type=hidden name="tpt" value="<?=$tpt?>">
	<input type=hidden name="sa" value="<?=$sa?>">
	<input type=hidden name="sb" value="<?=$sb?>">
	<input type=hidden name="sc" value="<?=$sc?>">
	<input type=hidden name="sd" value="<?=$sd?>">
	<input type=hidden name="se" value="<?=$se?>">
	<input type=hidden name="keyword" value="<?=$keyword?>">
	<input type=hidden name="usernm" value="<?=$_SESSION[UNM]?>">
	<tr><td width='100'><b>제목</td>
		<td><input type=text name=subject size=60 maxlength=120 class=forms value="<?=$subject?>" style="width:450;"></td></tr>
	<?if($upload_file_cnt) {?>
	<tr><td colspan=2 bgcolor=#e7e7e7 height=1></td></tr>
	<tr><td><b>파일첨부</td>
		<td>첨부파일의 총 사이즈는 <?=sprintf("%.1f", $max_filesize/1000000)?>M 입니다.<br>
		<?for($i=0; $i<$upload_file_cnt; $i++) echo "<input type=file name='upfile[$i]' size=45 class=forms><br>";?>
		</td></tr>
	<!--tr bgcolor=#f7f7f7><td align=right>파일정렬</td><td bgcolor=#ffffff><input type=radio name=falign value='left'>왼쪽<input type=radio name=falign value='center' checked>가운데<input type=radio name=falign value='right'>오른쪽</td></tr>
	<tr bgcolor=#f7f7f7><td align=right>파일설명</td><td bgcolor=#ffffff><input type=text name=fdesc size=60 maxlength=100 class=forms></td></tr-->
	<?}?>
	</table>

	<table border=0 cellpadding=0 cellspacing=0 width='<?=$table_width?>'>
	<tr><td><textarea name=comment cols=88 rows=18 class=forms style="width:<?=$table_width?>;overflow:auto"><?=$comment?></textarea></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td>&nbsp;</td>
		<td align=right><a href="javascript:goPostCheckIt(signform)"><img src='../images/btn_103.gif' border=0 align=absmiddle></a> <a href="javascript:goList()"><img src='../images/btn_102.gif' border=0 align=absmiddle></a></td></tr>
	</form>
	</table>
<?
}

function PDS_ReplySave() {
    global $dbCon;
	global $PHP_SELF,$db_name;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_ext,$upload_file_tdy,$arr_file_not_ext,$arr_file_yes_ext,$savedir,$saveurl;

	global $number;
	global $fid,$thread;
	global $usernm,$subject,$comment;
	global $upfile,$upfile_name,$upfile_size;

	//-------------------- 원글의 입력값으로부터 답변글에 입력할 정보(정렬 및 indent에 필요한 thread필드값)를 뽑아낸다.
	$result = $dbCon->dbSelect1($db_name,"WHERE part='$part' AND fid='$fid' AND length(thread) = length('$thread')+1 AND locate('$thread',thread) = 1 ORDER BY thread DESC LIMIT 1","thread,right(thread,1)");
	$rows = mysql_num_rows($result);
	if($rows) {
   		$row = mysql_fetch_row($result);
   		$thread_head = substr($row[0],0,-1);
   		$thread_foot = ++$row[1];
   		$new_thread = $thread_head . $thread_foot;
	} else {
   		$new_thread = $thread . "A";
	}

	$today = time();
	$client = getenv('REMOTE_ADDR');

	//이미지업로드 및 지원하는 형식 확장자 체크
	$file_count = 0; $file_ext_chk = 0;
	for($i = 0; count($upfile) > $i; $i++)
	if($upfile[$i]) {
		$file_count++;
		$file_ext = strtolower(substr(strrchr($upfile_name[$i],"."), 1));
		if($upload_file_ext) { if(!array_search($file_ext, $arr_file_yes_ext)) { $file_ext_chk = 1; break; }}
		else { if(array_search($file_ext, $arr_file_not_ext)) { $file_ext_chk = 1; break; }}
	}

	//사이즈체크
	$filesize = 0;
	for($i=0; count($upfile)>$i; $i++) $filesize +=  $upfile_size[$i];
	if((($file_count > 0) && ($filesize == 0)) || ($filesize > $max_filesize)) $file_siz_chk = 1;

	if($file_ext_chk) { popup_msg("올릴 수 없는 파일 형식입니다."); exit;
	} elseif($file_siz_chk) { popup_msg("파일 사이즈가 큽니다."); exit;
	} else {

		$j=0;
		$fsize = "";
		for($i=0; count($upfile)>$i; $i++)
		if($upfile[$i]) {
			$upfile_name[$i] = str_replace(" ", "_", $upfile_name[$i]);
			$file_ext = strtolower(substr(strrchr($upfile_name[$i], "."), 1));
			if($upload_file_tdy) $s_upfile[$j] = $today. "_".$i. ".". $file_ext;
			else {
				$s_upfile[$j] = strtolower($upfile_name[$i]);
				if(file_exists($savedir. $s_upfile[$j])) $s_upfile[$j] = $new_uid. "_". $s_upfile[$j];
			}
			copy($upfile[$i], $savedir. $s_upfile[$j]) || die("file upload failed!");
			$fsize = $fsize. $upfile_size[$i]. "|";
			$j++;
		}

		$arr=array("",$fid,$part,$spt,$tpt,0,0,0,0,0,$_SESSION[UID],$_SESSION[UPW],$usernm,$_SESSION[UNI],"",$_SESSION[EML],$_SESSION[HPG],"","","","",$subject,$comment,"","",$s_upfile[0],$s_upfile[1],$s_upfile[2],$s_upfile[3],$s_upfile[4],$s_upfile[5],"","",$fsize,"",0,0,0,0,1,"",$today,$today,"",0,$new_thread,$client);

		$re = $dbCon->dbInsert($db_name,$arr);
		if($re) {	echo("<script>location.replace('${PHP_SELF}?page=${page}&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}&time=${today}');</script>");
		} else {
			popup_msg("DB 입력 오류입니다."); exit;
		}
	}
}

function PDS_Delete() {
	global $dbCon;
	global $PHP_SELF,$db_name;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $upload_file_cnt,$savedir,$saveurl;
	global $allow_delete_thread,$complete_delete;

	global $number;

	$today = time();
	$str = $dbCon->dbSelect1($db_name,"WHERE uid='$number'","upfile,upfile1,upfile2,upfile3,upfile4,upfile5,userid,userpw,fid,thread");
	$row = mysql_fetch_row($str);
	$userid = $row[6];
	$userpw = $row[7];
	$fid = $row[8];
	$thread = $row[9];

	if(strcmp($userid, $_SESSION[UID]) || !isset($_SESSION[UID])) {
		popup_msg("삭제할 수 없습니다"); exit;
	} else {

		if(!$allow_delete_thread) {
			$result = $dbCon->dbSelect1($db_name,"WHERE deldate<1 AND fid = $fid AND length(thread) = length('$thread')+1 AND locate('$thread',thread) = 1 ORDER BY thread DESC LIMIT 1","thread");
			$rows1 = mysql_num_rows($result);
			if($rows1) {
				popup_msg("답변글을 먼저 삭세하십시오"); exit;
			}
		}

		for($j=0; $j<$upload_file_cnt; $j++)
	    if($row[$j]) {
			$del_file = $savedir. $row[$j];
			if(file_exists($del_file)) unlink($del_file);
		}

		if($complete_delete) $str = $dbCon->dbDelete($db_name, "WHERE uid='$number' LIMIT 1");//완전삭제
		else {
			$arr = array("comment"=>"","deluser"=>$_SESSION[UID], "deldate"=>$today);//내용만 삭제
			$dbCon->dbUpdate($db_name,$arr, "WHERE uid='$number' LIMIT 1");
		}

		echo("<script>location.replace('${PHP_SELF}?page=${page}&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}&time=${today}');</script>");
	}
}

function PDS_Read() {
	global $dbCon;
	global $PHP_SELF,$db_name;
	global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;

    global $reply_yesno_act,$file_download,$image_width;
	global $savedir,$saveurl;
	global $memo_enable;

	global $number;

	$str = $dbCon->dbSelect($db_name,"WHERE uid='$number' LIMIT 1");
	mysql_data_seek($str['result'],0);
	$Row=mysql_fetch_object($str['result']);

	$upfile = array($Row->upfile,$Row->upfile1,$Row->upfile2,$Row->upfile3,$Row->upfile4,$Row->upfile5);
	$i=0;
	while($upfile[$i]) {
		$file_url[$i] = $saveurl. $upfile[$i];
		$file_path[$i] = $savedir. $upfile[$i];
		$ref = strrchr($upfile[$i], ".");
		if(!strcmp($ref,".gif") || !strcmp($ref,".jpg")) {
			if(file_exists($file_path[$i])) {
				$img_size = getimagesize($file_path[$i]);
				if($img_size[0] > $image_width) $width[$i] = $image_width;
				else $width[$i] = $img_size[0];
			}
			$jpegchk[$i] = 1;
		} else $jpegchk[$i] = 0;
		$i++;
	}

	$Row->viscnt++;
	$q_up = "UPDATE $db_name SET viscnt='$Row->viscnt' WHERE uid='$number' LIMIT 1";
	$dbCon->setResult($q_up);
?>
	<table width='<?=$table_width?>' border=0 cellpadding=5 cellspacing=1 bgcolor=#dfdfdf>
	<tr><td align=center bgcolor='#ffffff' style="word-break:break-all;"><b><?=$Row->subject?></b></td></tr>
	</table>

	<table border=0><tr><td></td></tr></table>
	<table width="<?=$table_width?>" cellpadding="0" cellspacing="0" border="0">
	<tr><td style="padding-left:5px">글쓴이 :&nbsp;
		<?
		if($Row->admchk) echo "<img src='../images/logo_txt.gif' align=absmiddle>";
		else {
			if($memo_enable && isset($_SESSION[UID])) {
				include "../lib/memopop.inc";
				echo "<a href=\"javascript:MemoPopUp('$Row->userid', '$Row->usernm');\">$Row->usernm</a>";
			} else echo $Row->usernm;
			if($Row->email) echo" <a href='mailto:$Row->email'><img src='../images/bbs_icon_mail.gif' border=0 align=absmiddle></a>";
			if($Row->homepage) echo" <a href='http://$Row->homepage' target='_blank'><img src='../images/bbs_icon_hp.gif' border=0 align=absmiddle></a>";
		}
		?>
		</td>
		<td align=right style="padding-right:5px"><font color=#999999 style='font-family:verdana; font-size:9px; letter-spacing:-1px;'>
		Lastupdate : <?= date("Y-m-d H:i",$Row->moddate)?>, Regist : <?= date("Y-m-d",$Row->regdate)?>, Hit : <?=$Row->viscnt?></font></td></tr>
<?
	$i=0;
	while($upfile[$i]) {
		if(!$jpegchk[$i]) echo "<tr><td colspan=2 align=right style='padding:2 5 0 0;'><img src='../images/bbs_icon_disk.gif'> <span style='color=#555555;font-size:12px;letter-spacing:-1px;cursor:hand;' onClick=\"javascript:file_download('$savedir','$upfile[$i]');\">$upfile[$i]</span></td></tr>";
		$i++;
	}
?>
	</table>

	<table width="<?=$table_width?>" cellpadding="0" cellspacing="0" border="0">
	<tr><td height=10></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf style="overflow:hidden; padding:0px"></td></tr>
	<tr><td height=10></td></tr>
	</table>


	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0 style="table-layout:fixed;word-break:break-all;padding:0;">
	<tr><td style="font-size:9pt;color:#333333;line-height:170%;padding-left:5px;">

<?
	$i=0;
	while($upfile[$i]) {
		if($jpegchk[$i]) echo "<img src=\"$file_url[$i]\" width=\"$width[$i]\" border=0 vspace=5 style='cursor:hand;' onClick=\"popup_image('../lib/view.php?imgsrc=$file_url[$i]','zoom',500,500);return false\"><br><br>";
		$i++;
	}
?>
		<?=$Row->comment?>
		</td></tr>
	</table>

	<table width="<?=$table_width?>" cellpadding="0" cellspacing="0" border="0">
	<tr><td height=10></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf style="overflow:hidden; padding:0px"></td></tr>
	<tr><td height=10></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td><a href="javascript:goList()"><img src='../images/btn_102.gif' border=0 align=absmiddle></a></td>
		<td align=right>
		<?
		if($reply_yesno_act && !$Row->mchk && !$Row->nchk) echo " <a href=\"javascript:goReply($Row->uid)\"><img src='../images/btn_105.gif' border=0 align=absmiddle></a>";//게시판공지글일경우 답변버튼삭제
		if(trim($_SESSION[UID]) && !strcmp($_SESSION[UID],$Row->userid)) {
			echo " <a href=\"javascript:goModify($Row->uid)\"><img src='../images/btn_104.gif' border=0 align=absmiddle></a>";
			echo " <a href=\"javascript:delAction($Row->uid)\"><img src='../images/btn_106.gif' border=0 align=absmiddle></a>";
		}
		?>
		</td></tr>
	</table>
	<br>
<?
}

function PDS_ListView() {
    global $dbCon;
	global $PHP_SELF,$db_name,$db_name_comment,$allow_comment;
    global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $color_table_list;//array

	global $number;
	global $num_per_page,$page_per_block,$notify_new_article,$reply_indent,$notify_admin,$regit_yesno_act;

	if(!$page) $page = 1;
	if(trim($keyword)) {
		$sh_keyfield = "";
		if($sa) $sh_keyfield = $sh_keyfield. ",". $sa;
		if($sb) $sh_keyfield = $sh_keyfield. ",". $sb;
		if($sc) $sh_keyfield = $sh_keyfield. ",". $sc;
		if($sd) $sh_keyfield = $sh_keyfield. ",". $sd;
		if($se) $sh_keyfield = $sh_keyfield. ",". $se;
		if(!$sh_keyfield) {
			$sb = "subject";
			$sh_keyfield = ",subject";
		}
		$sh_keyfield = substr($sh_keyfield,1);
		$sh_query = make_where("AND", $sh_keyfield, $keyword, 0);//검색처리함수 호출
		$sh_query = "AND ". $sh_query[where];
	}

	$sql_part = "";
	if(trim($spt)) $sql_part = $sql_part. " AND sprt='$spt'";
	if(trim($tpt)) $sql_part = $sql_part. " AND tprt='$tpt'";

	if(!eregi("[^[:space:]]+",$keyword)) {
		$str = $dbCon->dbSelect1($db_name, "WHERE part='$part' $sql_part AND deldate<1","COUNT(uid)");
	} else {
		$encoded_key = urlencode($keyword);
   		$str = $dbCon->dbSelect1($db_name, "WHERE part='$part' $sql_part AND  deldate<1 $sh_query","COUNT(uid)");
	}
	$total_record = mysql_result($str,0,0);

	//------------------ print scorp definition
	if(!$total_record) {
   		$first = 1;	$last = 0;
	} else {
   		$first = $num_per_page*($page-1);
   		$last = $num_per_page*$page;
   		$IsNext = $total_record - $last;
   		if($IsNext > 0) $last -= 1;
		else $last = $total_record - 1;
	}
	$total_page = ceil($total_record/$num_per_page);
	$time_limit = 60*60*24*$notify_new_article;
	$article_num = $total_record - $num_per_page*($page-1);

?>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=2>
	<tr><td height=26 align=right class="text_gray">
	<?
		if(!eregi("[^[:space:]]+",$keyword)) echo "총 $total_record 개";
		else echo "검색 $total_record 개";
	?>
		, 쪽번호 <?=$page?>/<?=$total_page?> page</font>
		</td></tr>
	</table>

	<table width="<?=$table_width?>" cellpadding="2" cellspacing="0" border="0">
	<tr><td height="2" colspan="11" bgcolor='<?=$color_table_list["top"]?>' style="overflow:hidden; padding:0px"></td></tr>
	<tr align="center" height="23" bgcolor='<?=$color_table_list["tit"]?>'>
		<td width=42 nowrap style='color:<?=$color_table_list["txt"]?>'><b>번호</b></td>
		<td nowrap style='padding:0px;color:<?=$color_table_list["bar"]?>'>|</td>
		<td></td>
		<td width="100%" style='color:<?=$color_table_list["txt"]?>'><b>제목</b></td>
		<td nowrap style='padding:0px;color:<?=$color_table_list["bar"]?>'>|</td>
		<td width="60" nowrap style='color:<?=$color_table_list["txt"]?>'><b>글쓴이</b></td>
		<td nowrap style='padding:0px;color:<?=$color_table_list["bar"]?>'>|</td>
		<td width="50" nowrap style='color:<?=$color_table_list["txt"]?>'><b>등록일</b></td>
		<td nowrap style='padding:0px;color:<?=$color_table_list["bar"]?>'>|</td>
		<td width=42 nowrap style='color:<?=$color_table_list["txt"]?>'><b>조회</b></td>
	</tr>
	<tr><td height="1" colspan="11" bgcolor='<?=$color_table_list["mid"]?>' style="overflow:hidden; padding:0px"></td></tr>

<?
	if(!eregi("[^[:space:]]+",$keyword)) $str = $dbCon->dbSelect($db_name, "WHERE part='$part' $sql_part AND deldate<1 ORDER BY mchk DESC, nchk DESC, fid DESC, thread ASC LIMIT $first,$num_per_page");
	else $str = $dbCon->dbSelect($db_name, "WHERE part='$part' $sql_part AND  deldate<1 $sh_query ORDER BY mchk DESC, nchk DESC, fid DESC, thread ASC LIMIT $first,$num_per_page");


	for($i=0; $i<$str['cnt']; $i++) {
		mysql_data_seek($str['result'],$i);
		$Row=mysql_fetch_object($str['result']);


 		//comment print
		if($allow_comment) {
		$str_cmt = $dbCon->dbSelect1($db_name_comment,"WHERE dbm='$db_name' AND cod='$Row->uid'","count(num)");
		$row_cmt = mysql_fetch_row($str_cmt);
		}

		echo "<tr height=26 align=center>";
		if($number == $Row->uid) echo "<td><img src='../images/bbs_icon_arrow.gif' border=0></td>";
		else {
			if($Row->mchk || $Row->nchk) echo "<td><img src='../images/bbs_icon_noti.gif' border=0></td>";
			else echo "<td class='text_gray'>${article_num}</td>";
		}
		echo "<td></td>";
		if(trim($Row->upfile)) echo "<td nowrap style='padding-right:5px'><img src='../images/bbs_icon_clib.gif' width=9 height=14 border=0></td>";
		else echo "<td nowrap style='padding-right:5px'></td>";
		echo "<td align=left style='word-break:break-all;'>";
		if($Row->mchk || $Row->nchk) echo "<b>";// 공지글 진하게..
		$spacer = strlen($Row->thread)-1;
	   	if($spacer > $reply_indent) $spacer = $reply_indent;
   		for($j = 0; $j < $spacer; $j++) echo("&nbsp; ");
		if($spacer) echo "<img src='../images/bbs_icon_reply.gif' border=0 align='abstop'>";
		else echo "";
		//if(trim($keyword)) if(trim($sb)) $Row->subject = eregi_replace("($keyword)", "<font color=#ff0000>\\1</font>", $Row->subject);
		echo "<a href='javascript:goRead($Row->uid)' onMouseOver=\"status='read';return true;\" onMouseOut=\"status=''\">";
		echo $Row->subject;
		echo "</a>";
		if($allow_comment) {
			$str_cmt = $dbCon->dbSelect1($db_name_comment,"WHERE dbm='$db_name' AND cod='$Row->uid'","count(num)");
			$row_cmt = mysql_fetch_row($str_cmt);
			if($row_cmt[0])//comment print
			echo " <img src='../images/cmt_mark.gif' border=0><font color='#FF9900' style='font-family:verdana; font-size:9px; letter-spacing:-1px;'> ". $row_cmt[0]. "</font>";
		}
		$date_diff = time() -  $Row->regdate;
		if($date_diff < $time_limit) echo " <img src='../images/bbs_icon_new.gif' border=0>";
		echo "</td>";
		echo "<td></td>";

		if(!$Row->admchk) echo "<td align=left nowrap style='word-break:break-all;'>". $Row->usernm. "</td>";
		else echo "<td align=left style='word-break:break-all;'><img src='../images/logo_txt.gif'></td>";
		echo "<td></td>";

	   	echo "<td class='text_gray'>". date("y.m.d",$Row->regdate). "</td>";
		echo "<td></td>";
		echo "<td class='text_gray'>". number_format($Row->viscnt). "</td>";
		echo "</tr>";

		echo "<tr><td height='1' colspan='11' bgcolor='".$color_table_list["dot"]."' style='overflow:hidden; padding:0px'></td></tr>";
	   	$article_num--;
	}
?>
	<tr><td height="1" colspan="11" bgcolor='<?=$color_table_list["mid"]?>' style="overflow:hidden; padding:0px"></td></tr>
	</table>

    <table border=0><tr><td height=7></td></tr></table>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td><a href="javascript:goRefresh()"><img src='../images/btn_101.gif' border=0 align=absmiddle></a>
		<?if($regit_yesno_act) echo"<a href=\"javascript:goPost()\"><img src='../images/btn_103.gif' border=0 align=absmiddle>";?>
		</td>
	<td align=right>
<?

	//----------- 게시물 목록 하단의 각 페이지로 직접 이동할 수 있는 페이지링크에 대한 설정을 한다. ##########
	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);

	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;

	if($total_block <= $block) {
   		$last_page = $total_page;
	}

	//------------- 이전페이지블록에 대한 페이지 링크 ##########
	if($block > 1) {
   		$my_page = $first_page;
		echo "<a href='$PHP_SELF?spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_1130.gif' border=0 align=absmiddle></a><a href='$PHP_SELF?page=$my_page&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_113.gif' border=0 align=absmiddle></a> ";
	}

	//-------------- 현재의 페이지 블럭범위내에서 각 페이지로 바로 이동할 수 있는 하이퍼링크를 출력한다. ##########
	for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
	   	if($page == $direct_page) {
    		echo "<b>[$direct_page]</b>";
	   	} else {
    		echo "<a href='$PHP_SELF?page=$direct_page&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='direct $direct_page';return true;\" onMouseOut=\"status=''\">[$direct_page]</a>";
	   	}
	}

	//------------- 다음페이지블록에 대한 페이지 링크 ##########
	if($block < $total_block) {
   		$my_page = $last_page+1;
   		echo " <a href='$PHP_SELF?page=$my_page&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='next $page_per_block page';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_114.gif' border=0 align=absmiddle></a><a href='$PHP_SELF?page=$total_page&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='next $page_per_block page';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_1140.gif' border=0 align=absmiddle></a>";
	}
?>
   		</td></tr>
	</table>

	<br>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<form name="searchword" method="get" action="<?=$PHP_SELF?>">
	<input type=hidden name=part value="<?=$part?>">
	<input type=hidden name=spt value="<?=$spt?>">
	<input type=hidden name=tpt value="<?=$tpt?>">
	<tr><td align='right'>
		<input type=checkbox name="sa" value="usernm" <?if($sa) echo"checked";?>>글쓴이
		<input type=checkbox name="sb" value="subject" <?if($sb) echo"checked";?>>제목
		<input type=checkbox name="sc" value="comment" <?if($sc) echo"checked";?>>내용
		<input size="20" maxlength="30" name="keyword" value="<?=$keyword?>" class=forms>
		<input type=image src="../images/btn_110.gif" align=absmiddle>
		</td></tr>
	</form>
	</table>

<?
}

function PDS_Right_Body() {
}

function PDS_End() {
	echo "</body></html>";
}

if(!strcmp($mode, "postform")) {
    PDS_Head();
	PDS_Left_Body();
	PDS_PostForm();
	PDS_Right_Body();
	PDS_End();
}
elseif(!strcmp($mode, "postsave")) {
	PDS_Save_Check();
	PDS_PostSave();
}
elseif(!strcmp($mode, "modifyform")) {
	PDS_Head();
	PDS_Left_Body();
	PDS_ModifyForm();
	PDS_Right_Body();
	PDS_End();
}
elseif(!strcmp($mode, "modifysave")) {
	PDS_Save_Check();
	PDS_ModifySave();
}
elseif(!strcmp($mode, "delete")) {
	PDS_Delete();
}
elseif(!strcmp($mode, "replyform")) {
	PDS_Head();
	PDS_Left_Body();
	PDS_ReplyForm();
	PDS_Right_Body();
	PDS_End();
}
elseif(!strcmp($mode, "replysave")) {
	PDS_Save_Check();
	PDS_ReplySave();
}
elseif(!strcmp($mode, "read")) {
	PDS_Head();
	PDS_Left_Body();
	PDS_Read();
	if($allow_comment) Comment_View();
	PDS_ListView();
	PDS_Right_Body();
	PDS_End();
}
else {
	PDS_Head();
	PDS_Left_Body();
	PDS_ListView();
	PDS_Right_Body();
	PDS_End();
}
?>