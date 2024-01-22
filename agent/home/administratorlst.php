<?session_start();?>
<?
include "../lib/connect.php";
include "administrator_h.php";
$dbCon = new dbConn();
?>
<?
if(!trim($_SESSION[AADM]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>history.back(); alert('�̿������ �����ϴ�.');</script>";
	exit;
}
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
	global $part,$page,$sn,$ss,$sc,$keyword;
?>
	<html>
	<head><title><?=$title_doc?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<link href="../lib/admin.css" type="text/css" rel=stylesheet>
	<script language="JavaScript">
	<!--
<?
	echo "var v_pgm='". $PHP_SELF. "'\n";
	echo "var v_string='part=".$part. "&page=".$page. "&sn=".$sn. "&ss=".$ss. "&sc=".$sc. "&keyword=".$keyword. "'\n";
?>
	function strCheck(str, ch, msg) {
		var s = str.value;
		for(i=0; i<s.length; i++) {
			if(ch.indexOf(s.substring(i,i+1)) == -1) {
				alert(msg + '�� ����� �� ���� ���ڰ� �ԷµǾ����ϴ�');
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
				alert(msg + '�� ����� �� ���� ���ڰ� �ԷµǾ����ϴ�');
				num.focus();
				return true
			}
		}
		return false
	}
	function both_trim(a) {//���ʹ��ڿ�����
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
			alert('�ϳ��� ���� �ϼž� �մϴ�.');
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
			alert('�ϳ� �̻��� �����ϼž߸� �մϴ�!');
			return;
		} else{
			if(confirm('�����Ͻ� ������ �����Ͻðڽ��ϱ�?')){
				form.method="POST";
				form.action="?mode=seldelete";
				form.submit();
			} else return;
		}					
	}
	function Open_CheckAID() {
		var AlphaNum = '+_-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		if(document.signform.userid.value.length < 3) {
			alert('���̵�(ID)�� 3�� �̻��̾�� �մϴ�.');
			document.signform.userid.focus();
			return;
		}
		else {
			if(strCheck(document.signform.userid, AlphaNum, 'ID')) return;
			chkUId = window.open("../lib/function.php?mode=checkaid&UId="+document.signform.userid.value, "���̵��ߺ�Ȯ��", "height=200,width=410,top=100, left=50, scrollbars=no,resizable=no");
		}
	}
	function delAction(num)	{
		if( confirm("���� ���� �Ͻðڽ��ϱ�") )
		window.location.href="?mode=delete&number="+num+"&"+v_string;
	}
	function goPost() {
		window.location.href="?mode=postform&"+v_string;
	}
	function goModify(num) {
		window.location.href="?mode=modifyform&number="+num+"&"+v_string;
	}
	function goReply(num) {
		window.location.href="?mode=replyform&number="+num+"&"+v_string;
	}
	function goList() {
		window.location.href="?"+v_string;
	}
	function goRefresh() {
		window.location.href="?";
	}
	function goPostCheckIt(form) {
		var AlphaNum = '+_-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		var Num = '0123456789';
		var PostNum = '-0123456789';

		if(both_trim(form.userid.value) == "") {
      		alert('���̵� ��Ȯ�ϰ� �Է��Ͽ� �ֽʽÿ�');
	      	form.userid.focus();
    	  	return;
   		}
		if(both_trim(form.usernm.value) == "") {
      		alert('�̸��� �Է��ϼ���');
	      	form.usernm.focus();
    	  	return;
   		}/*
		if(both_trim(form.userni.value) == "") {
			alert('�г����� �Է��ϼ���!');
			form.userni.focus();
			return;
   		}*/
		if(form.userpw.value.length < 4) {
			alert('��й�ȣ�� ��Ȯ�ϰ� �Է��Ͽ� �ֽʽÿ�.');
			form.userpw.focus();
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

		if(both_trim(form.userid.value) == "") {
      		alert('���̵� ��Ȯ�ϰ� �Է��Ͽ� �ֽʽÿ�');
	      	form.userid.focus();
    	  	return;
   		}
		if(both_trim(form.usernm.value) == "") {
      		alert('�̸��� �Է��ϼ���');
	      	form.usernm.focus();
    	  	return;
   		}/*
		if(both_trim(form.userni.value) == "") {
			alert('�г����� �Է��ϼ���!');
			form.userni.focus();
			return;
   		}*/
		if(form.pw_chk.checked) {
			if(form.userpw.value.length < 4) {
				alert('��й�ȣ�� 4�� �̻��̾�� �մϴ�.');
				form.userpw.focus();
				return;
			}
		}
		signform.method="POST";
		signform.action="?";
		signform.submit();
		return;
	}
	function popup_image(page,nam,wid,hit){ 
		var  windo=eval('window.open("'+page+'","'+nam+'","status=no,toolbar=no,resizable=no,scrollbars=no, menubar=no,width='+wid+',height='+hit+',top=10,left=10")'); 
	}
	//-->
	</script>
	</head>
	<body bgcolor=#ffffff>
<?
}

function PDS_Left_Body() {
	global $allow_center;
	global $table_width,$tit_doc;
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
	global $AICLC_GRD,$AICLC_ADM,$AICLC_WEB,$AICLC_UID,$AICLC_UPW,$AICLC_UNM,$AICLC_UNI,$AICLC_EML,$AICLC_HPG;

	global $table_width;
	global $part,$page,$sn,$ss,$sc,$keyword;
	global $arr_gradedoc;

	global $allow_addfile,$max_filesize;
	global $arr_jpart;

?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	function formresize_comment(obj) { obj.rows += 3; }
	//-->
	</SCRIPT>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#777777></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>ȸ�� ���</td></tr>
	<tr><td height=1 background="../images/bbs_line.gif"></td></tr>
	<tr><td height=1></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<form name=signform enctype="multipart/form-data" onsubmit='return false'>
	<input type=hidden name="mode" value="postsave">
	<tr bgcolor=#f7f7f7><td align=right>���̵�</td>
		<td bgcolor=#ffffff colspan=3><input name='userid' maxlength=10 size=12 class=forms> <input type="image" src="../images/btn_find_id.gif" border=0 align=absmiddle onclick="Open_CheckAID()"> <font color=red>(3~10�� �̳�, ������ ���� ����, �����Ұ�, �ѱ��ԷºҰ�)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>�̸�</td>
		<td bgcolor=#ffffff width='38%'><input type=text name=usernm size=16 maxlength=20 class=forms></td>
		<td align=right width='12%'>&nbsp;</td>
		<td bgcolor=#ffffff width='38%'>&nbsp;</td></tr>
		<!--td align=right width='12%'>�г���</td>
		<td bgcolor=#ffffff><input type=text name=userni size=16 maxlength=20 class=forms value="���"> <font color=#777777>(�ܺο� ǥ��)</font></td></tr-->
	<tr bgcolor=#f7f7f7><td align=right>��й�ȣ</td>
		<td bgcolor=#ffffff><input type=password name='userpw' maxlength=10 size=16 class=forms> <font color=red>(4~10��,��/��������)</font></td>
		<td align=right>�̿����</td>
		<td bgcolor=#ffffff><select name="grade">
		<option value="">--����--</option>
		<?
		for($i=1; $i<count($arr_gradedoc); $i++) {
			echo "<option value='$i'>$arr_gradedoc[$i]</option>";
		}
		?>
		</select></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>�μ���</td>
		<td bgcolor=#ffffff><select size=1 name="jpart">
		<option value="">--����--</option>
		<?
		for($i=0; $i<count($arr_jpart); $i++) {
			echo "<option value='$arr_jpart[$i]'>$arr_jpart[$i]</option>";
		}
		?>
		</select></td>
		<td align=right>��å��</td>
		<td bgcolor=#ffffff><input type=text name=duty size=20 maxlength=30 class=forms></td></tr>
	</table>

	<table border=0><tr><td></td></tr></table>

	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<tr bgcolor=#f7f7f7><td align=right width='12%'><b>������</b></td>
		<td bgcolor=#ffffff width='38%'><input type=checkbox name=admweb value="1">�������� ����</td>
		<td align=right width='12%'><b>����������</b></td>
		<td bgcolor=#ffffff width='38%'><input type=checkbox name=admadm value="1">���������� ����</td></tr>
	</table>

	<table border=0><tr><td></td></tr></table>

	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>���ο���ó</td>
		<td bgcolor=#ffffff><input type=text name=phone size=20 maxlength=30 class=forms> <font color=#77777>(�ڵ��� ǥ��)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>�̸���</td>
		<td bgcolor=#ffffff><input type=text name=email size=34 maxlength=50 class=forms> <font color=#77777>(��Ȯ�ϰ� ǥ��)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>����Ȩ������</td>
		<td bgcolor=#ffffff><input type=text name=homepage size=34 maxlength=50 class=forms value=""> <font color=#77777>('http://' ����)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right><b>���¼���</b></td>
		<td bgcolor=#ffffff><input type=radio name=usechk value="1" checked>�̿밡�� <input type=radio name=usechk value="0">�̿�Ұ� &nbsp;&nbsp; <img src="../images/bbs_icon_down.gif" border=0 valign=absmiddle style=cursor:hand; onclick="javascript:formresize_comment(document.signform.comment);"></td></tr>
	</table>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0 bgcolor=#f7f7f7>
	<tr><td height=10 bgcolor=#ffffff></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	<tr><td height=10></td></tr>
	<tr><td align=center><textarea name=comment cols=100 rows=5 class=forms></textarea></td></tr>
	<tr><td height=10></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td>&nbsp;</td>
		<td align=right><a href="javascript:goPostCheckIt(signform)"><img src='../images/btn_303.gif' border=0 align=absmiddle></a> <a href="javascript:goList()"><img src='../images/btn_302.gif' border=0 align=absmiddle></a></td></tr>
	</form>
	</table>

<?
}

function PDS_Save_Check() {
}

function PDS_PostSave() {
    global $dbCon;
	global $PHP_SELF,$db_name;

	global $grade,$userid,$userpw,$usernm,$userni,$duty,$jpart,$tel,$email,$homepage,$photo,$phone,$zip,$addr,$comment,$usechk;
	global $admweb,$admadm;

	if($userid) {
		$str = $dbCon->dbSelect($db_name, "WHERE userid='$userid'","userid");
		if($str[cnt] > 0) {
	   		popup_msg("���̵� �ߺ��� �Է��Դϴ�.");
			exit;
		}
	}

	$today = time();
	if(!$usechk) $usechk = 0;
	if(!$admweb) $admweb = 0;
	if(!$admadm) $admadm = 0;
	if(!$grade) $grade = 1;//���
	$comment = addslashes($comment);

	$arr = array("",$grade,$admweb,$admadm,$userid,$userpw,$usernm,$userni,$duty,$jpart,$tel,"","",$email,$homepage,"",$phone,$zip,$addr,$comment,$usechk,0,0,"",0,"",$today,$today);
	$re = $dbCon->dbInsert($db_name,$arr);
	if($re) {
	    $tmp = time();
		echo("<script>location.replace('${PHP_SELF}?page=1&time=${tmp}');</script>");
	} else {
   		popup_msg("DB insert error!");
   		exit;
	}
}

function PDS_ModifyForm() {
	global $dbCon;
	global $PHP_SELF,$db_name;

	global $table_width;
	global $part,$page,$sn,$ss,$sc,$keyword;

	global $number;
	global $arr_gradedoc,$arr_jpart;
	global $allow_addfile,$max_filesize;

	$str = $dbCon->dbSelect($db_name,"WHERE num='$number' LIMIT 1");
	mysql_data_seek($str[result],0);
	$Row=mysql_fetch_object($str[result]);

	$comment = stripslashes($Row->comment);
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	function formresize_comment(obj) { obj.rows += 3; }
	//-->
	</SCRIPT>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#777777></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>���� ����</td></tr>
	<tr><td height=1 background="../images/bbs_line.gif"></td></tr>
	<tr><td height=1></td></tr>
	</table>


	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<form name=signform enctype="multipart/form-data" onsubmit='return false'>
	<input type=hidden name="mode" value="modifysave">
	<input type=hidden name="number" value="<?=$number?>">
	<input type=hidden name="page" value="<?=$page?>">
	<input type=hidden name="sn" value="<?=$sn?>">
	<input type=hidden name="ss" value="<?=$ss?>">
	<input type=hidden name="sc" value="<?=$sc?>">
	<input type=hidden name="keyword" value="<?=$keyword?>">
	<input type=hidden name=userid value="<?=$Row->userid?>">
	<input type=hidden name="userpw_tmp" value="<?=$Row->userpw?>">
	<tr bgcolor=#f7f7f7><td align=right>���̵�</td>
		<td bgcolor=#ffffff colspan=3><b><?=$Row->userid?></b> <font color=red>(���� �Ұ�)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>�̸�</td>
		<td bgcolor=#ffffff width='38%'><input type=text name=usernm size=16 maxlength=20 class=forms value="<?=$Row->usernm?>"></td>
		<td align=right width='12%'>&nbsp;</td>
		<td bgcolor=#ffffff width='38%'>&nbsp;</td></tr>
	<tr bgcolor=#f7f7f7><td align=right>��й�ȣ</td>
		<td bgcolor=#ffffff><input type=password name='userpw' maxlength=10 size=16 class=forms> <input type=checkbox name=pw_chk value=1>����� üũ</td>
		<td align=right>�̿����</td>
		<td bgcolor=#ffffff><select name="grade">
		<option value="">--����--</option>
		<?
		for($i=1; $i<count($arr_gradedoc); $i++) {
			if($i == $Row->grade) echo "<option value='$i' selected>$arr_gradedoc[$i]</option>";
			else echo "<option value='$i'>$arr_gradedoc[$i]</option>";
		}
		?>
		</select></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>�μ���</td>
		<td bgcolor=#ffffff><select size=1 name="jpart">
		<option value="">--����--</option>
		<?
		for($i=0; $i<count($arr_jpart); $i++) {
			if(!strcmp($Row->jpart,$arr_jpart[$i])) echo "<option value='$arr_jpart[$i]' selected>$arr_jpart[$i]</option>";
			else echo "<option value='$arr_jpart[$i]'>$arr_jpart[$i]</option>";
		}
		?>
		</select></td>
		<td align=right>��å��</td>
		<td bgcolor=#ffffff><input type=text name=duty size=20 maxlength=30 class=forms value="<?=$Row->duty?>"></td></tr>
	</table>

	<table border=0><tr><td></td></tr></table>

	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<tr bgcolor=#f7f7f7><td align=right width='12%'><b>������</b></td>
		<td bgcolor=#ffffff width='38%'><input type=checkbox name=admweb value="1" <?if($Row->admweb) echo"checked";?>>�������� ����</td>
		<td align=right width='12%'><b>����������</b></td>
		<td bgcolor=#ffffff width='38%'><input type=checkbox name=admadm value="1" <?if($Row->admadm) echo"checked";?>>���������� ����</td></tr>
	</table>

	<table border=0><tr><td></td></tr></table>

	<table width='<?=$table_width?>' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>���ο���ó</td>
		<td bgcolor=#ffffff><input type=text name=phone size=20 maxlength=30 class=forms value="<?=$Row->phone?>"> <font color=#77777>(�ڵ��� ǥ��)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>�̸���</td>
		<td bgcolor=#ffffff><input type=text name=email size=34 maxlength=50 class=forms value="<?=$Row->email?>"> <font color=#77777>(��Ȯ�ϰ� ǥ��)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>����Ȩ������</td>
		<td bgcolor=#ffffff><input type=text name=homepage size=34 maxlength=50 class=forms value="<?=$Row->homepage?>"> <font color=#77777>('http://' ����)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right><b>���¼���</b></td>
		<td bgcolor=#ffffff><input type=radio name=usechk value="1" <?if($Row->usechk) echo"checked";?>>�̿밡�� <input type=radio name=usechk value="0" <?if(!$Row->usechk) echo"checked";?>>�̿�Ұ� &nbsp;&nbsp; <img src="../images/bbs_icon_down.gif" border=0 valign=absmiddle style=cursor:hand; onclick="javascript:formresize_comment(document.signform.comment);"></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0 bgcolor=#f7f7f7>
	<tr><td height=10 bgcolor=#ffffff></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	<tr><td height=10></td></tr>
	<tr><td align=center><textarea name=comment cols=100 rows=6 class=forms><?=$comment?></textarea></td></tr>
	<tr><td height=10></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	</table>


	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td>&nbsp;</td>
		<td align=right><a href="javascript:goModifyCheckIt(signform)"><img src='../images/btn_307.gif' border=0 align=absmiddle></a> <a href="javascript:goList()"><img src='../images/btn_302.gif' border=0 align=absmiddle></a></td></tr>
	</form>
	</table>
<?
}

function PDS_ModifySave() {
    global $dbCon;
	global $PHP_SELF,$db_name;

	global $number;
	global $part,$page,$sn,$ss,$sc,$keyword;

	global $userpw,$userpw_tmp,$pw_chk;
	global $grade,$userid,$usernm,$userni,$duty,$jpart,$tel,$email,$homepage,$photo,$phone,$zip,$addr,$comment,$usechk;
	global $admweb,$admadm;

	$today = time();
	if(!$usechk) $usechk = 0;
	if(!$admweb) $admweb = 0;
	if(!$admadm) $admadm = 0;
	if(!$grade) $grade = 1;

	if($pw_chk) $upw = $userpw;
	else $upw = $userpw_tmp;

	$comment = addslashes($comment);

	if($_SESSION[AADM]) {//����������
		$arr = array("grade"=>$grade,"admweb"=>$admweb,"admadm"=>$admadm,"userpw"=>$upw,"usernm"=>$usernm,"userni"=>$userni,"duty"=>$duty,"jpart"=>$jpart,"email"=>$email,"homepage"=>$homepage,"phone"=>$phone,"comment"=>$comment,"usechk"=>$usechk,"moduser"=>$_SESSION[AUID],"moddate"=>$today);
		$dbCon->dbUpdate($db_name,$arr,"WHERE num='$number' LIMIT 1");
		echo("<script>location.replace('${PHP_SELF}?page=${page}&sn=${sn}&ss=${ss}&sc=${sc}&keyword=${keyword}&time=${today}');</script>");
	} else {
   		popup_msg("DB update error!");
   		exit;
	}
}

function PDS_Delete() {
	global $dbCon;
	global $PHP_SELF,$db_name;

	global $number;
	global $part,$page,$sn,$ss,$sc,$keyword;

	$today = time();
	$usechk = 0;

	if($_SESSION[AADM]) {//����������
		$str = $dbCon->dbDelete($db_name,"WHERE num='$number' LIMIT 1");//��������
		//$arr=array("usechk"=>$usechk,"deluser"=>$AICLC_UID,"deldate"=>$today);//���븸 ����
		//$dbCon->dbUpdate($db_name,$arr,"WHERE num='$number' LIMIT 1");
		echo("<script>location.replace('${PHP_SELF}?page=${page}&sn=${sn}&ss=${ss}&sc=${sc}&keyword=${keyword}&time=${today}');</script>");
	} else {
   		popup_msg("DB delete error!");
   		exit;
	}
}

function PDS_SelDelete() {
	global $dbCon;
	global $PHP_SELF,$db_name;

	global $part,$page,$sn,$ss,$sc,$keyword;
	global $savedir;
	global $chkid;


	$del_str ="";
	$i=0;
	while($chkid[$i]) {
		if($i != 0) {
			$del_str = $del_str. " OR ";
		}
		$del_str = $del_str. "num='". $chkid[$i]. "'";
		$i++;
	}

	$today = time();

	if($_SESSION[AADM]) {//����������
		$str = $dbCon->dbDelete($db_name,"WHERE ($del_str)");//��������
		//$arr=array("usechk"=>$usechk,"deluser"=>$AICLC_UID,"deldate"=>$today);//���븸 ����
		//$dbCon->dbUpdate($db_name,$arr,"WHERE $del_str");
		echo("<script>location.replace('${PHP_SELF}?page=${page}&sn=${sn}&ss=${ss}&sc=${sc}&keyword=${keyword}&time=${today}');</script>");
	} else {
   		popup_msg("DB update error!");
   		exit;
	}
}

function PDS_Read() {
	global $dbCon;
	global $PHP_SELF,$db_name;
	
	global $part,$page,$sn,$ss,$sc,$keyword;
	global $number;
	global $table_width;

	global $arr_gradedoc;
    global $allow_html;
    global $file_download,$image_width;
	global $allow_comment;
	global $savedir;

	//----- ������ �Խù��� �Է°��� �̾Ƴ���. ##########
	$str = $dbCon->dbSelect($db_name,"WHERE num='$number' LIMIT 1");
	mysql_data_seek($str[result],0);
	$Row=mysql_fetch_object($str[result]);

	$comment = nl2br(stripslashes($Row->comment));
?>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=1 bgcolor=#777777></td></tr>
	<tr><td height=24 bgcolor=#f7f7f7 align=center><b>�� ����</td></tr>
	<tr><td height=1 background="../images/bbs_line.gif"></td></tr>
	<tr><td height=1></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellpadding=5 cellspacing=1 bgcolor=#dfdfdf>
	<tr bgcolor=#f7f7f7><td align=right>���̵�</td>
		<td bgcolor=#ffffff colspan=3><b><?=$Row->userid?></b></td></tr>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>�̸�</td>
		<td bgcolor=#ffffff width='38%'><?=$Row->usernm?></td>
		<td align=right width='12%'>�̿����</td>
		<td bgcolor=#ffffff width='38%'><?=$arr_gradedoc[$Row->grade]?></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>�μ���</td>
		<td bgcolor=#ffffff><?=$Row->jpart?></td>
		<td align=right>��å��</td>
		<td bgcolor=#ffffff><?=$Row->duty?></td></tr>
	</table>

	<table border=0><tr><td></td></tr></table>

	<table width='<?=$table_width?>' border=0 cellpadding=5 cellspacing=1 bgcolor=#dfdfdf>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>������</td>
		<td bgcolor=#ffffff width='38%'><?if($Row->admweb) echo"����"; else echo"������";?></td>
		<td align=right width='12%'>����������</td>
		<td bgcolor=#ffffff width='38%'><?if($Row->admadm) echo"����"; else echo"������";?></td></tr>
	</table>

	<table border=0><tr><td></td></tr></table>

	<table width='<?=$table_width?>' border=0 cellpadding=5 cellspacing=1 bgcolor=#dfdfdf>
	<tr bgcolor=#f7f7f7><td align=right>���ο���ó</td>
		<td bgcolor=#ffffff colspan=3><?=$Row->phone?></td></tr>
	<tr bgcolor=#f7f7f7><td align=right width='12%'>�̸���</td>
		<td bgcolor=#ffffff width='38%'><?=$Row->email?></td>
		<td align=right width='12%'>Ȩ������</td>
		<td bgcolor=#ffffff width='38%'><?=$Row->homepage?></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>��Ÿ����</td>
		<td bgcolor=#ffffff colspan=3>���� : <?if($Row->usechk) echo"<b>�̿밡��</b>"; else echo"<b>�̿�Ұ�</b>";?><br>
		���������� : <?= date("Y-m-d H:i:s",$Row->moddate)?> &nbsp;&nbsp; <?if($Row->loginlst) echo"�����α������� : ". date("Y-m-d H:i:s",$Row->loginlst);?> ( <?=$Row->logincnt?> ȸ )</td></tr>
	</table>


	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=10 bgcolor=#f7f7f7>
	<tr><td height=10 bgcolor=#ffffff></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	<tr><td class=ptxt1 style=padding-left:90px><?=$comment?></td></tr>
	<tr><td height=1 bgcolor=#dfdfdf></td></tr>
	</table>

	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td><a href="javascript:goList()"><img src='../images/btn_302.gif' border=0 align=absmiddle></a></td>
		<td align=right>
		<?
		if($_SESSION[AADM]) {//�����������ΰ��
			echo " <a href=\"javascript:goModify($Row->num)\"><img src='../images/btn_304.gif' border=0 align=absmiddle></a>";
			echo " <a href=\"javascript:delAction($Row->num)\"><img src='../images/btn_306.gif' border=0 align=absmiddle></a>";
		}
		?>
		</td></tr>
	</table>

	<br>
<?
}

function PDS_ListView() {
    global $dbCon;
	global $PHP_SELF,$db_name;
	global $AICLC_GRD,$AICLC_ADM,$AICLC_WEB,$AICLC_UID,$AICLC_UPW,$AICLC_UNM,$AICLC_UNI,$AICLC_EML,$AICLC_HPG;

    global $table_width;
	global $page,$sn,$ss,$sc,$keyword;

	global $number;

	global $num_per_page;
	global $notify_new_article;
	global $page_per_block;
	global $reply_indent;
	global $notify_admin;
    global $file_download;

	if(!$page) $page = 1;
	if(trim($keyword)) {
		$sh_keyfield = "";
		if($sn) $sh_keyfield = $sh_keyfield. ",". $sn;
		if($ss) $sh_keyfield = $sh_keyfield. ",". $ss;
		if($sc) $sh_keyfield = $sh_keyfield. ",". $sc;
		if(!$sh_keyfield) {
			$ss = "usernm";
			$sh_keyfield = ",usernm";
		}
		$sh_keyfield = substr($sh_keyfield,1);
		$sh_query = make_where("AND", $sh_keyfield, $keyword, 0);//�˻�ó���Լ� ȣ��
		$sh_query = "AND ". $sh_query[where];
	}

	if(!eregi("[^[:space:]]+",$keyword)) {
		$str = $dbCon->dbSelect($db_name, "WHERE deldate<1 AND userid<>'heuri' ORDER BY regdate DESC");
	} else {
		$encoded_key = urlencode($keyword);
   		$str = $dbCon->dbSelect($db_name, "WHERE deldate<1 AND userid<>'heuri' $sh_query ORDER BY regdate DESC");
	}
	$total_record = $str[cnt];

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
	<tr><td height=26 align=right>Total <b><?=$total_record?></b> Articles &nbsp; ( <b><?=$page?></b> / <b><?=$total_page?></b> Pages )</td></tr>
	</table>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=2>
	<form name=checkform>
	<tr><td colspan=8 height=1 bgcolor=#777777></td></tr>
	<tr height=26 bgcolor=#777777>
		<td style='color:ffffff' width=40 align=center><input type="checkbox" name="checkboxAll" value="checkbox" onclick="checkAll()"></td>
		<td style='color:ffffff' align=center><nobr><b>��ȣ</b></td>
		<td style='color:ffffff'><b>���̵�</b></td>
		<td style='color:ffffff'><nobr><b>�̸�</b></td>
		<td style='color:ffffff'><nobr><b>��å��</b></td>
		<td style='color:ffffff'><nobr><b>���ο���ó</b></td>
		<td style='color:ffffff' align=center><nobr><b>�����α��νð�</b></td>
		<td style='color:ffffff' align=center><nobr><b>����|������|������</b></td></tr>
	<tr><td colspan=8 height=1 bgcolor=#DDDDDD></td></tr>

<?
	for($i = $first; $i <= $last; $i++) {
		mysql_data_seek($str[result],$i);
		$Row=mysql_fetch_object($str[result]);

		$num = $Row->num;
		$grade = $Row->grade;
		$userid = $Row->userid;
		$usernm = $Row->usernm;
		$userni = $Row->userni;
		$duty = $Row->duty;
		$jpart = $Row->jpart;
		$phone = $Row->phone;
		$usechk = $Row->usechk;
		$loginlst = $Row->loginlst;
		$regdate = $Row->regdate;

		echo "<tr height=26 bgcolor=#ffffff onMouseOver=this.style.backgroundColor='#f7f7f7' onMouseOut=this.style.backgroundColor='' style='cursor: hand;'>";
		echo "<a href=\"$PHP_SELF?mode=read&number=$num&page=${page}&sn=${sn}&ss=${ss}&sc=${sc}&keyword=${keyword}\" onMouseOver=\"status='read $uid';return true;\" onMouseOut=\"status=''\">";

		echo "<td align=center><input type=checkbox name=chkid[] value='$Row->num'></td>";
		if($number == $Row->num) echo "<td align='center'><img src='../images/bbs_icon_arrow.gif' border=0></td>";
		else echo "<td align='center'>${article_num}</td>";

		echo "<td>$Row->userid</td>";
		echo "<td>$Row->usernm</td>";
		echo "<td>$Row->duty</td>";
		echo "<td>$Row->phone</td>";
		if(!$Row->loginlst) echo "<td align=center>-</td>";
		else echo "<td align=center>". date("y-m-d H:i",$Row->loginlst). "</td>";

		echo "<td align=center>";
		if(!$Row->usechk) echo "<font color=red>�Ұ�</font>";
		else echo "����";
		if(!$Row->admweb) echo "|-";
		else echo "|<font color=blue>������</font>";
		if(!$Row->admadm) echo "|-";
		else echo "|<font color=blue>������</font>";
		echo "</td>";
   		echo "</a></tr>";

		echo "<tr><td colspan=8 height=1 bgcolor=#DDDDDD></td></tr>";

	   	$article_num--;
	}
?>
	<tr><td colspan=8 height=1 bgcolor=#777777></td></tr>
	<input type=hidden name=sn value="<?=$sn?>">
	<input type=hidden name=ss value="<?=$ss?>">
	<input type=hidden name=sc value="<?=$sc?>">
	<input type=hidden name=keyword value="<?=$keyword?>">
	</form>
	</table>

    <font size=1><br></font>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<tr><td><a href="javascript:goRefresh()"><img src='../images/btn_301.gif' border=0 align=absmiddle></a> 
		<?
		if($_SESSION[AADM]) {//����������
		echo " <a href=\"javascript:goPost()\"><img src='../images/btn_303.gif' border=0 align=absmiddle></a>";
		echo " <a href=\"javascript:goDeleteIt(checkform)\"><img src='../images/btn_306.gif' border=0 align=absmiddle></a>";
		}
		?>
		</td>
	<td align=right>
<?

	//----------- �Խù� ��� �ϴ��� �� �������� ���� �̵��� �� �ִ� ��������ũ�� ���� ������ �Ѵ�. ##########
	$total_block = ceil($total_page/$page_per_block);
	$block = ceil($page/$page_per_block);

	$first_page = ($block-1)*$page_per_block;
	$last_page = $block*$page_per_block;

	if($total_block <= $block) {
   		$last_page = $total_page;
	}

	//------------- ������������Ͽ� ���� ������ ��ũ ##########
	if($block > 1) {
   		$my_page = $first_page;
		echo "<a href='$PHP_SELF?page=$my_page&part=${part}&sn=${sn}&ss=${ss}&sc=${sc}&keyword=${keyword}' onMouseOver=\"status='load previous $page_per_block pages';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_313.gif' border=0 align=absmiddle></a> ";
	}

	//-------------- ������ ������ ������������ �� �������� �ٷ� �̵��� �� �ִ� �����۸�ũ�� ����Ѵ�. ##########
	for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
	   	if($page == $direct_page) {
    		echo "<b>[$direct_page]</b>";
	   	} else {
    		echo "<a href='$PHP_SELF?page=$direct_page&part=${part}&sn=${sn}&ss=${ss}&sc=${sc}&keyword=${keyword}' onMouseOver=\"status='direct $direct_page';return true;\" onMouseOut=\"status=''\">[$direct_page]</a>";
	   	}
	}

	//------------- ������������Ͽ� ���� ������ ��ũ ##########
	if($block < $total_block) {
   		$my_page = $last_page+1;
   		echo " <a href='$PHP_SELF?page=$my_page&part=${part}&sn=${sn}&ss=${ss}&sc=${sc}&keyword=${keyword}' onMouseOver=\"status='next $page_per_block page';return true;\" onMouseOut=\"status=''\"><img src='../images/btn_314.gif' border=0 align=absmiddle></a></font>";
	}
?>
   		</td></tr>
	</table>

	<br>
	<table width='<?=$table_width?>' border=0 cellspacing=0 cellpadding=0>
	<form name="searchword" method="get" action="<?=$PHP_SELF?>">
	<tr><td align='right'>
		<input type=checkbox name="sn" value="userid" <?if($sn) echo"checked";?>>���̵�
		<input type=checkbox name="ss" value="usernm" <?if($ss) echo"checked";?>>�̸�
		<input type=checkbox name="ss" value="duty" <?if($sc) echo"checked";?>>��å��
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