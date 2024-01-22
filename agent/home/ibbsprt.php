<?session_start();?>
<?
include "../lib/connect.php";
$dbCon = new dbConn();
include "ibbsprt_h.php";
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
	global $part;
	global $page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
?>
	<html>
	<head><title><?=$tit_doc?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<link href="../lib/admin.css" type="text/css" rel=stylesheet>
	<script language="JavaScript">
	<!--
<?
	echo "var v_pgm='". $PHP_SELF. "'\n";
	echo "var v_string='page=".$page. "&part=".$part. "&spt=".$spt. "&tpt=".$tpt. "&sa=".$sa. "&sb=".$sb. "&sc=".$sc. "&sd=".$sd. "&se=".$se. "&keyword=".$keyword. "'\n";
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
			if(confirm('선택하신 정보를 삭제하시겠습니까?')){
				form.method="POST";
				form.action="?mode=seldelete";
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
	function delAction(num)	{ if( confirm("정말 삭제 하시겠습니까") ) window.location.href="?mode=delete&number="+num+"&"+v_string; }
	function goPost() { window.location.href="?mode=postform&"+v_string; }
	function goRead(num) { window.location.href="?mode=read&number="+num+"&"+v_string; }
	function goModify(num) { window.location.href="?mode=modifyform&number="+num+"&"+v_string; }
	function goReply(num) { window.location.href="?mode=replyform&number="+num+"&"+v_string; }
	function goList() { window.location.href="?"+v_string; }
	function goRefresh() { window.location.href="?"; }
	function goRefreshs() { window.location.href="?"+v_string1; }
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
   		}/*
		if(both_trim(form.comment.value) == "") {
			alert('필수항목을 입력하여 주십시오');
			form.comment.focus();
			return;
   		}*/
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
   		}/*
		if(both_trim(form.comment.value) == "") {
			alert('필수항목을 입력하여 주십시오');
			form.comment.focus();
			return;
   		}*/
		signform.method="POST";
		signform.action="?";
		signform.submit();
		return;
	}
	//-->
	</script>
	</head>
	<body bgcolor=#ffffff>
<?
}

function PDS_Left_Body() {
	global $table_width,$tit_doc;
	global $spt,$tpt;
	global $tit_sprt;
?>
	<br>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td><font size=3><b>[<?=$tit_doc?>]</b></font></td></tr>
	</table>
	<br>
<?
}

function PDS_PostForm() {
    global $PHP_SELF;
	global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_cnt;
	global $popup_gonji;
?>
	<script language="JavaScript" type="text/javascript" src="/alditor/alditor.js"></script>


	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#777777></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>글등록</td></tr>
	<tr><td height=1 background="../images/bbs_line.gif"></td></tr>
	<tr><td height=1></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<form name=signform enctype="multipart/form-data" onsubmit='return false'>
	<input type=hidden name="mode" value="postsave">
	<input type=hidden name="part" value="<?=$part?>">
	<input type=hidden name="spt" value="<?=$spt?>">
	<input type=hidden name="tpt" value="<?=$tpt?>">
	<tr bgcolor=#f7f7f7><td align=right width=100>작성자</td>
		<td bgcolor=#ffffff><input type=text name=usernm size=14 maxlength=10 class=forms value="<?=$_SESSION[AUNM]?>"></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>제목</td>
		<td bgcolor=#ffffff><input type=text name=subject size=74 maxlength=120 class=forms style="width:100%;"></td></tr>
	<?if($upload_file_cnt) {?>
	<tr bgcolor=#f7f7f7><td align=right>파일첨부</td>
		<td bgcolor=#ffffff>첨부파일의 총 사이즈는 <?=sprintf("%.1f", $max_filesize/1000000)?>M 입니다.<br>
		<?for($i=0; $i<$upload_file_cnt; $i++) echo "<input type=file name='upfile[$i]' size=45 class=forms><br>";?>
		</td></tr>
	<?}?>
	</table>

	<table border=0><tr><td></td></tr></table>
	<table border=0 cellpadding=0 cellspacing=0 width='<?=$table_width?>'>
	<tr><td><textarea name=comment cols=88 rows=20 class=forms style="width:100%;overflow:auto"></textarea></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td><?if($popup_gonji) echo"<input type=checkbox name=mchk value=1>팝업공지";?> <input type=checkbox name=nchk value="1">게시판공지&nbsp;</td>
		<td align=right><a href="javascript:goPostCheckIt(signform)"><img src='../images/btn_303.gif' border=0 align=absmiddle></a> <a href="javascript:goList()"><img src='../images/btn_302.gif' border=0 align=absmiddle></a></td></tr>
	<input type=hidden name=trail_form_stop value="">
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
	global $max_filesize,$upload_file_ext,$upload_file_tdy,$arr_file_not_ext,$arr_file_yes_ext,$upload_file_nme,$savedir,$saveurl;

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
			if($upload_file_tdy) $s_upfile[$j] = $upload_file_nme. $today. "_".$i. ".". $file_ext;
			else {
				$s_upfile[$j] = strtolower($upfile_name[$i]);
				if(file_exists($savedir. $s_upfile[$j])) $s_upfile[$j] = $new_uid. "_". $s_upfile[$j];
			}
			copy($upfile[$i], $savedir. $s_upfile[$j]) || die("file upload failed!");
			$fsize = $fsize. $upfile_size[$i]. "|";
			$j++;
		}

		$arr=array($new_uid,$new_fid,$part,$spt,$tpt,$mchk,$nchk,0,0,0,$_SESSION[AUID],$_SESSION[AUPW],$usernm,$_SESSION[AUNI],"",$_SESSION[AEML],$_SESSION[AHPG],"","","","",$subject,$comment,"","",$s_upfile[0],$s_upfile[1],$s_upfile[2],$s_upfile[3],$s_upfile[4],$s_upfile[5],"","",$fsize,"",0,1,0,0,1,"",$today,$today,"",0,"A",$client);

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
	global $part;
	global $page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;

	global $number;
	global $max_filesize,$upload_file_cnt;
	global $popup_gonji;

	$str = $dbCon->dbSelect1($db_name,"WHERE uid='$number' LIMIT 1");
	$data = mysql_fetch_array($str);
	$subject = ereg_replace("\"","&quot;",$data[subject]);
?>
	<script language="JavaScript" type="text/javascript" src="/alditor/alditor.js"></script>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#777777></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>글수정</td></tr>
	<tr><td height=1 background="../images/bbs_line.gif"></td></tr>
	<tr><td height=1></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
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
	<tr bgcolor=#f7f7f7><td align=right width=100>작성자</td>
		<td bgcolor=#ffffff><input type=text name=usernm size=14 maxlength=10 class=forms value="<?=$data[usernm]?>"></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>제목</td>
		<td bgcolor=#ffffff><input type=text name=subject size=74 maxlength=120 class=forms value="<?=$subject?>" style="width:100%;"></td></tr>
	<?if($upload_file_cnt) {
		$upfile = array($data[upfile],$data[upfile1],$data[upfile2],$data[upfile3],$data[upfile4],$data[upfile5]);
		$fsize = explode('|', $data[fsize]);
	?>
	<tr bgcolor=#f7f7f7><td align=right>파일첨부</td>
		<td bgcolor=#ffffff>첨부파일의 총 사이즈는 <?=sprintf("%.1f", $max_filesize/1000000)?>M 입니다.<br>
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
	<?}?>
	</table>

	<table border=0><tr><td></td></tr></table>
	<table border=0 cellpadding=0 cellspacing=0 width='<?=$table_width?>'>
	<tr><td><textarea name=comment cols=88 rows=20 class=forms style="width:100%;overflow:auto"><?=$data[comment]?></textarea></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td><?if($popup_gonji) {?><input type=checkbox name=mchk value=1 <?if($data[mchk]) echo"checked";?>>팝업공지<?}?> <input type=checkbox name=nchk value="1" <?if($data[nchk]) echo"checked";?>>게시판공지&nbsp;</td>
		<td align=right><a href="javascript:goModifyCheckIt(signform)"><img src='../images/btn_307.gif' border=0 align=absmiddle></a> <a href="javascript:goList()"><img src='../images/btn_302.gif' border=0 align=absmiddle></a></td></tr>
	<input type=hidden name=trail_form_stop value="">
	</form>
	</table>
<?
}

function PDS_ModifySave() {
    global $dbCon;
	global $PHP_SELF,$db_name;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_ext,$upload_file_tdy,$upload_file_cnt,$arr_file_not_ext,$arr_file_yes_ext,$upload_file_nme,$savedir,$saveurl;

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
			if($upload_file_tdy) $s_upfile[$j] = $upload_file_nme. $today. "_".$i. ".". $file_ext;
			else {
				$s_upfile[$j] = strtolower($upfile_name[$i]);
				if(file_exists($savedir. $s_upfile[$j])) $s_upfile[$j] = $number. "_". $s_upfile[$j];
			}
			copy($upfile[$i], $savedir. $s_upfile[$j]) || die("file upload failed!");
			$fsize = $fsize. $upfile_size[$i]. "|";
			$j++;
		}
		$arr=array("mchk"=>$mchk,"nchk"=>$nchk,"usernm"=>$usernm,"subject"=>$subject,"comment"=>$comment,"upfile"=>$s_upfile[0],"upfile1"=>$s_upfile[1],"upfile2"=>$s_upfile[2],"upfile3"=>$s_upfile[3],"upfile4"=>$s_upfile[4],"upfile5"=>$s_upfile[5],"fsize"=>$fsize,"moduser"=>$_SESSION[AUID],"moddate"=>$today,"remoteip"=>$client);

		$dbCon->dbUpdate($db_name,$arr,"WHERE uid='$number' LIMIT 1");
		echo("<script>location.replace('${PHP_SELF}?page=${page}&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}&time=${today}');</script>");
	}
}

function PDS_ReplyForm() {
	global $dbCon;
	global $PHP_SELF,$db_name;
	global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $lock_enable;
	global $max_filesize,$upload_file_cnt;

	global $number;

	$str = $dbCon->dbSelect1($db_name,"WHERE uid='$number' LIMIT 1","fid,usernm,subject,thread,qchk,userpw");
	$data = mysql_fetch_array($str);
	$subject = ereg_replace("\"","&quot;",$data[subject]);
	$comment = $data[usernm]. "님의 글에 대한 답변입니다.";
?>
	<script language="JavaScript" type="text/javascript" src="/alditor/alditor.js"></script>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#777777></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>답변글등록</td></tr>
	<tr><td height=1 background="../images/bbs_line.gif"></td></tr>
	<tr><td height=1></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<form name=signform enctype="multipart/form-data" onsubmit='return false'>
	<input type=hidden name="mode" value="replysave">
	<input type=hidden name="number" value="<?=$number?>">
	<input type=hidden name="fid" value="<?=$data[fid]?>">
	<input type=hidden name="thread" value="<?=$data[thread]?>">
	<?if($lock_enable) {?>
	<input type=hidden name="qchk" value="<?=$data[qchk]?>">
	<input type=hidden name="userpw" value="<?=$data[userpw]?>">
	<?}?>
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
	<tr bgcolor=#f7f7f7><td align=right width=100>작성자</td>
		<td bgcolor=#ffffff><input type=text name=usernm size=14 maxlength=10 class=forms value="<?=$_SESSION[AUNM]?>"></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>제목</td>
		<td bgcolor=#ffffff><input type=text name=subject size=74 maxlength=120 class=forms value="<?=$subject?>" style="width:100%;"></td></tr>
	<?if($upload_file_cnt) {?>
	<tr bgcolor=#f7f7f7><td align=right>파일첨부</td>
		<td bgcolor=#ffffff>첨부파일의 총 사이즈는 <?=sprintf("%.1f", $max_filesize/1000000)?>M 입니다.<br>
		<?for($i=0; $i<$upload_file_cnt; $i++) echo "<input type=file name='upfile[$i]' size=45 class=forms><br>";?>
		</td></tr>
	<?}?>
	</table>

	<table border=0><tr><td></td></tr></table>
	<table border=0 cellpadding=0 cellspacing=0 width='<?=$table_width?>'>
	<tr><td><textarea name=comment cols=88 rows=20 class=forms style="width:100%;overflow:auto"><?=$comment?></textarea></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td>&nbsp;</td>
		<td align=right><a href="javascript:goPostCheckIt(signform)"><img src='../images/btn_303.gif' border=0 align=absmiddle></a> <a href="javascript:goList()"><img src='../images/btn_302.gif' border=0 align=absmiddle></a></td></tr>
	<input type=hidden name=trail_form_stop value="">
	</form>
	</table>
<?
}

function PDS_ReplySave() {
    global $dbCon;
	global $PHP_SELF,$db_name;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $max_filesize,$upload_file_ext,$upload_file_tdy,$arr_file_not_ext,$arr_file_yes_ext,$upload_file_nme,$savedir,$saveurl;
	global $lock_enable;

	global $number;
	global $fid,$thread;
    global $usernm,$subject,$comment;
	global $upfile,$upfile_name,$upfile_size;
	global $qchk,$userpw;

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
	if(!$lock_enable) {
		$qchk = 0;
		$userpw = $_SESSION[AUPW];
	}

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
			if($upload_file_tdy) $s_upfile[$j] = $upload_file_nme. $today. "_".$i. ".". $file_ext;
			else {
				$s_upfile[$j] = strtolower($upfile_name[$i]);
				if(file_exists($savedir. $s_upfile[$j])) $s_upfile[$j] = $new_uid. "_". $s_upfile[$j];
			}
			copy($upfile[$i], $savedir. $s_upfile[$j]) || die("file upload failed!");
			$fsize = $fsize. $upfile_size[$i]. "|";
			$j++;
		}
		$arr=array("",$fid,$part,$spt,$tpt,0,0,0,0,$qchk,$_SESSION[AUID],$userpw,$usernm,$_SESSION[AUNI],"",$_SESSION[AEML],$_SESSION[AHPG],"","","","",$subject,$comment,"","",$s_upfile[0],$s_upfile[1],$s_upfile[2],$s_upfile[3],$s_upfile[4],$s_upfile[5],"","",$fsize,"",0,1,0,0,1,"",$today,$today,"",0,$new_thread,$client);

		$re = $dbCon->dbInsert($db_name,$arr);
		if($re) {
		echo("<script>location.replace('${PHP_SELF}?page=${page}&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}&time=${today}');</script>");
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
	$str = $dbCon->dbSelect1($db_name,"WHERE uid='$number'","upfile,upfile1,upfile2,upfile3,upfile4,upfile5,userid,fid,thread");
	$row = mysql_fetch_row($str);
	$userid = $row[6];
	$fid = $row[7];
	$thread = $row[8];

	//------------ 삭제하고자 하는 글이 답변글을 하나라도 달고 있으면 삭제할 수 없도록 한다. ##########
	if(!$allow_delete_thread) {
		$result = $dbCon->dbSelect1($db_name,"WHERE deldate<1 AND fid = $fid AND length(thread) = length('$thread')+1 AND locate('$thread',thread) = 1 ORDER BY thread DESC LIMIT 1","thread");
   		$rows1 = mysql_num_rows($result);
   		if($rows1) {
      		popup_msg("답변글을 먼저 삭세하십시오");
      		exit;
   		}
	}
	//if(!strcmp($_SESSION[AUID],$userid) || trim($_SESSION[AADM])) {
	if(trim($_SESSION[AGRD])) {
		for($j=0; $j<$upload_file_cnt; $j++)
	    if($row[$j]) {
			$del_file = $savedir. $row[$j];
			if(file_exists($del_file)) unlink($del_file);
		}

		if($complete_delete) $str = $dbCon->dbDelete($db_name, "WHERE uid='$number' LIMIT 1");//완전삭제
		else {
			$arr = array("comment"=>"","deluser"=>$_SESSION[AUID], "deldate"=>$today);//내용만 삭제
			$dbCon->dbUpdate($db_name,$arr, "WHERE uid='$number' LIMIT 1");
		}

		echo("<script>location.replace('${PHP_SELF}?page=${page}&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}&time=${today}');</script>");
	} else {
   		popup_msg("DB delete error!"); exit;
	}
}

function PDS_SelDelete() {
	global $dbCon;
	global $PHP_SELF,$db_name;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $upload_file_cnt,$savedir,$saveurl;
	global $allow_delete_thread,$complete_delete;
	global $chkid;

	$today = time();
	$i=0;
	while($chkid[$i]) {
		$str = $dbCon->dbSelect1($db_name,"WHERE uid='$chkid[$i]'","upfile,upfile1,upfile2,upfile3,upfile4,upfile5,userid,fid,thread");
		$row = mysql_fetch_row($str);
		$userid = $row[6];
		$fid = $row[7];
		$thread = $row[8];

		//------------ 삭제하고자 하는 글이 답변글을 하나라도 달고 있으면 삭제할 수 없도록 한다. ##########
		if(!$allow_delete_thread) {
			$result = $dbCon->dbSelect1($db_name,"WHERE deldate<1 AND fid = $fid AND length(thread) = length('$thread')+1 AND locate('$thread',thread) = 1 ORDER BY thread DESC LIMIT 1","thread");
   			$rows1 = mysql_num_rows($result);
	   		if($rows1) {
		  		popup_msg("답변글을 먼저 삭세하십시오");
      			exit;
	   		}
		}

		for($j=0; $j<$upload_file_cnt; $j++)
		if($row[$j]) {
			$del_file = $savedir. $row[$j];
			if(file_exists($del_file)) unlink($del_file);
		}
		if($complete_delete) $str_ = $dbCon->dbDelete($db_name, "WHERE uid='$chkid[$i]' LIMIT 1");//완전삭제
		else {
			$arr = array("comment"=>"","deluser"=>$_SESSION[AUID], "deldate"=>$today);//내용만 삭제
			$dbCon->dbUpdate($db_name,$arr, "WHERE uid='$chkid[$i]' LIMIT 1");
		}
		$i++;
	}

	echo("<script>location.replace('${PHP_SELF}?page=${page}&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}&time=${today}');</script>");

}

function PDS_Read() {
	global $dbCon;
	global $PHP_SELF,$db_name;
	global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;

    global $reply_yesno_act,$file_download,$image_width,$regist_yesno_act;
	global $savedir,$saveurl;
	global $popup_gonji;

	global $number;

	$str = $dbCon->dbSelect($db_name,"WHERE uid='$number' LIMIT 1");
	mysql_data_seek($str[result],0);
	$Row=mysql_fetch_object($str[result]);

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

	//---------------- visit count add
	$Row->viscnt++;
	$q_up = "UPDATE $db_name SET viscnt='$Row->viscnt' WHERE uid='$number' LIMIT 1";
	$dbCon->setResult($q_up);
?>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#aaaaaa></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b><?=$Row->subject?></b></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	</table>


	<table border=0><tr><td></td></tr></table>
	<table width='<?=$table_width?>' cellpadding="0" cellspacing="0" border="0">
	<tr><td style="padding-left:10px">글쓴이 : <?=$Row->usernm?>
		<?
		if($Row->email) echo"<a href='mailto:$Row->email'><img src='../images/bbs_icon_mail.gif' border=0 align=absmiddle></a> ";
		if($Row->homepage) echo"<a href='http://$Row->homepage' target='_blank'><img src='../images/bbs_icon_hp.gif' border=0 align=absmiddle></a>";
		if($Row->phone) echo "<b>".$Row->phone."</b>";
		?>
		</td>
		<td align=right style="padding-right:10px"><font color=#999999 style='font-family:verdana; font-size:9px; letter-spacing:-1px;'>
		Lastupdate : <?= date("Y-m-d H:i",$Row->moddate)?>, Regist : <?= date("Y-m-d",$Row->regdate)?>, Hit : <?=$Row->viscnt?></font></td></tr>
	<tr><td colspan=2 align=right style="padding-right:10px"><span style='color=#555555;font-size:12px;letter-spacing:-1px;'>
		<?if($popup_gonji) {?>
		<input type=checkbox name=mchk value=1 disabled <?if($Row->mchk) echo"checked";?>>팝업공지
		<?}?>
		<input type=checkbox name=nchk value="1" disabled <?if($Row->nchk) echo"checked";?>>게시판공지</span></td></tr>
<?
	$i=0;
	while($upfile[$i]) {
		if(!$jpegchk[$i]) echo "<tr><td colspan=2 align=right style='padding:2 5 0 0;'><img src='../images/bbs_icon_disk.gif'> <span style='color=#555555;font-size:12px;letter-spacing:-1px;cursor:hand;' onClick=\"javascript:file_download('$savedir','$upfile[$i]');\">$upfile[$i]</span></td></tr>";
		$i++;
	}
?>
	</table>

	<table border=0><tr><td></td></tr></table>
	<table width='<?=$table_width?>' border=0><tr><td height=1 bgcolor=#dfdfdf></td></tr></table>
	<table border=0><tr><td></td></tr></table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0 style="table-layout:fixed;word-break:break-all;padding:0;">
	<tr><td style="font-size:9pt;color:#333333;line-height:170%;padding-left:10px;">

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

	<table border=0><tr><td></td></tr></table>
	<table width='<?=$table_width?>' border=0><tr><td height=1 bgcolor=#dfdfdf></td></tr></table>
	<table border=0><tr><td></td></tr></table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td><a href="javascript:goList()"><img src='../images/btn_302.gif' border=0 align=absmiddle></a></td>
		<td align=right>
		<?
		if($reply_yesno_act && (!strcmp($_SESSION[AUID],$Row->userid) || trim($_SESSION[AGRD]))) {
			echo " <a href=\"javascript:goReply($Row->uid)\"><img src='../images/btn_305.gif' border=0 align=absmiddle></a>";
		}
		if($regist_yesno_act && (!strcmp($_SESSION[AUID],$Row->userid) || trim($_SESSION[AGRD]))) {
			echo " <a href=\"javascript:goModify($Row->uid)\"><img src='../images/btn_304.gif' border=0 align=absmiddle></a>";
			echo " <a href=\"javascript:delAction($Row->uid)\"><img src='../images/btn_306.gif' border=0 align=absmiddle></a>";
		}
		?>
		</td></tr>
	</table>

	<br>
<?
}

function PDS_ListView() {
    global $dbCon;
	global $PHP_SELF,$db_name,$db_name_comment;
    global $table_width;
	global $part,$page,$spt,$tpt,$sa,$sb,$sc,$sd,$se,$keyword;
	global $num_per_page,$page_per_block,$notify_new_article,$reply_indent,$notify_admin;
	global $regist_yesno_act;

	global $number;

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
		$str = $dbCon->dbSelect1($db_name, "WHERE part='$part' $sql_part AND deldate<1 $sh_query", "COUNT(uid)");
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
	<tr><td height=26 align=right>
	<?
		if(!eregi("[^[:space:]]+",$keyword)) echo "총 $total_record 개";
		else echo "검색 $total_record 개";
	?>
		, 쪽번호 <?=$page?>/<?=$total_page?> page</font>
		</td></tr>
	</table>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=2>
	<form name=checkform>
	<tr><td colspan=7 height=1 bgcolor=#777777></td></tr>
	<tr height=26 bgcolor=#777777 align=center>
		<td style='color:ffffff' width=40><input type="checkbox" name="checkboxAll" value="checkbox" onclick="checkAll()"></td>
		<td style='color:ffffff'><nobr><b>번호</b></td>
		<td style='color:ffffff' width=26><b>&nbsp;</b></td>
		<td style='color:ffffff'><b>제목</b></td>
		<td style='color:ffffff'><b>이름</b></td>
		<td style='color:ffffff'><nobr><b>등록일</b></td>
		<td style='color:ffffff'><nobr><b>조회</b></td></tr>
	<tr><td colspan=7 height=1 bgcolor=#DDDDDD></td></tr>

<?
	if(!eregi("[^[:space:]]+",$keyword)) {
		$str = $dbCon->dbSelect($db_name, "WHERE part='$part' $sql_part AND deldate<1 ORDER BY mchk DESC, nchk DESC, fid DESC, thread ASC LIMIT $first,$num_per_page");
	} else {
   		$str = $dbCon->dbSelect($db_name, "WHERE part='$part' $sql_part AND deldate<1 $sh_query ORDER BY mchk DESC, nchk DESC, fid DESC, thread ASC LIMIT $first,$num_per_page");
	}
	for($i=0; $i<$str[cnt]; $i++) {
		mysql_data_seek($str[result],$i);
		$Row=mysql_fetch_object($str[result]);

		//comment print
		//$str_cmt = $dbCon->dbSelect1($db_name_comment,"WHERE cod='$uid'","count(num)");
		//$row_cmt = mysql_fetch_row($str_cmt);

		echo "<tr height=26 align=center bgcolor=#ffffff onMouseOver=this.style.backgroundColor='#f7f7f7' onMouseOut=this.style.backgroundColor='' style='cursor: hand;'>";
		echo "<a href=\"javascript:goRead($Row->uid)\" onMouseOver=\"status='read';return true;\" onMouseOut=\"status=''\">";
		echo "<td><input type=checkbox name=chkid[] value='$Row->uid'></td>";
		if($number == $Row->uid) echo "<td align='center'><img src='../images/bbs_icon_arrow.gif' border=0></td>";
		else {
			if($Row->mchk || $Row->nchk) echo "<td><img src='../images/bbs_icon_noti.gif' border=0></td>";
			else echo "<td>${article_num}</td>";
		}
		if($Row->upfile) echo "<td><img src='../images/bbs_icon_clib.gif' width=9 height=14 border=0></td>";
		else echo "<td nowrap></td>";

	   	echo "<td align=left>";
		if($Row->mchk || $Row->nchk) echo "<b>";// 공지글 진하게..
	   	$spacer = strlen($Row->thread)-1;
	   	if($spacer > $reply_indent) $spacer = $reply_indent;
   		for($j = 1; $j < $spacer; $j++) echo("&nbsp;");
		if($spacer) echo "<img src='../images/bbs_icon_reply.gif' border=0 align='abstop'>";
		else echo "";
   		if(trim($keyword)) {
			if(trim($sb)) $Row->subject = eregi_replace("($keyword)", "<font color=#ff0000>\\1</font>", $Row->subject);
		}
		echo "$Row->subject";
		//if($row_cmt[0])//comment print
		//echo " <font color='#FF9900' style='font-family:verdana; font-size:9px; letter-spacing:-1px;'>(". $row_cmt[0]. ")</font>";

		$date_diff = time() -  $Row->regdate;
		if($date_diff < $time_limit) echo " <img src='../images/bbs_icon_new.gif' border=0>";
		echo "</td>";
		echo "<td><nobr>$Row->usernm</td>";
	   	echo "<td><nobr>". date("Y.m.d",$Row->regdate). "</td>";
		echo "<td><nobr>". number_format($Row->viscnt). "</td>";
   		echo "</a></tr>";

		echo "<tr><td colspan=7 height=1 bgcolor=#DDDDDD></td></tr>";

	   	$article_num--;
	}
?>
	<tr><td colspan=7 height=1 bgcolor=#777777></td></tr>
	<input type=hidden name=part value="<?=$part?>">
	<input type=hidden name=spt value="<?=$spt?>">
	<input type=hidden name=tpt value="<?=$tpt?>">
	<input type=hidden name=sa value="<?=$sa?>">
	<input type=hidden name=sb value="<?=$sb?>">
	<input type=hidden name=sc value="<?=$sc?>">
	<input type=hidden name=sd value="<?=$sd?>">
	<input type=hidden name=se value="<?=$se?>">
	<input type=hidden name=keyword value="<?=$keyword?>">
	</form>
	</table>

    <font size=1><br></font>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td><a href="javascript:goRefreshs()"><img src='../images/btn_301.gif' border=0 align=absmiddle></a> 
		<?
		if($regist_yesno_act) echo " <a href=\"javascript:goPost()\"><img src='../images/btn_303.gif' border=0 align=absmiddle></a>";
		echo " <a href=\"javascript:goDeleteIt(checkform)\"><img src='../images/btn_330.gif' border=0 align=absmiddle></a>";
		?>
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
		echo "<a href='$PHP_SELF?part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_3130.gif' border=0 align=absmiddle></a><a href='$PHP_SELF?page=$my_page&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_313.gif' border=0 align=absmiddle></a> ";
	}

	//-------------- 현재의 페이지 블럭범위내에서 각 페이지로 바로 이동할 수 있는 하이퍼링크를 출력한다. ##########
	for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
	   	if($page == $direct_page) {
    		echo "<b>[$direct_page]</b>";
	   	} else {
    		echo "<a href='$PHP_SELF?page=$direct_page&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='direct $direct_page';return true;\" onMouseOut=\"status=''\">[$direct_page]</a>";
	   	}
	}

	//------------- 다음페이지블록에 대한 페이지 링크 ##########
	if($block < $total_block) {
   		$my_page = $last_page+1;
   		echo " <a href='$PHP_SELF?page=$my_page&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='next $page_per_block page';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_314.gif' border=0 align=absmiddle></a><a href='$PHP_SELF?page=$total_page&part=${part}&spt=${spt}&tpt=${tpt}&sa=${sa}&sb=${sb}&sc=${sc}&sd=${sd}&se=${se}&keyword=${keyword}' onMouseOver=\"status='next $page_per_block page';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_3140.gif' border=0 align=absmiddle></a>";
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
		<input type=checkbox name="sa" value="usernm" <?if($sa) echo"checked";?>>이름
		<input type=checkbox name="sb" value="subject" <?if($sb) echo"checked";?>>제목
		<input type=checkbox name="sc" value="comment" <?if($sc) echo"checked";?>>내용
		<input size="20" maxlength="30" name="keyword" value="<?=$keyword?>" class=forms>
		<input type=image src="../images/btn_310.gif" align=absmiddle>
		</td></tr>
	</form>
	</table>

<?
}

function PDS_Right_Body() {
}

function PDS_End() {
	echo "<br></body></html>";
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
elseif(!strcmp($mode, "seldelete")) {
	PDS_SelDelete();
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