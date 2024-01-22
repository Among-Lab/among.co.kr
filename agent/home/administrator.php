<? session_start();?>
<?
include "../lib/connect.php";
$dbCon = new dbConn();
include "administrator_h.php";
?>
<?
function Assign_Confirm_Head() {
?>
	<html>
	<head><title>인트라넷</title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<link href="../lib/admin.css" type="text/css" rel=stylesheet>
	<script language="JavaScript">
	<!--
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
	function goCheckIt(form) {
		if(both_trim(form.usernm.value) == "") {
      		alert('이름을 입력하세요');
	      	form.usernm.focus();
    	  	return;
   		}/*
		if(both_trim(form.userni.value) == "") {
			alert('닉네임을 입력하세요!');
			form.userni.focus();
			return;
   		}*/
		if(form.pw_chk.checked) {
			if(form.userpw.value.length < 4) {
				alert('비밀번호는 4자 이상이어야 합니다.');
				form.userpw.focus();
				return;
			}
		}
		signform.method="POST";
		signform.action="?";
		signform.submit();
		return;
	}
	//  --> 
	</script> 
	</head>
	<body bgcolor=#ffffff>
<?
}

function Assign_Confirm_Admin() {
	global $dbCon;
    global $PHP_SELF, $db_name;

	//----- 선택한 게시물의 입력값을 뽑아낸다. ##########
	$str = $dbCon->dbSelect($db_name,"WHERE userid='$_SESSION[AUID]' LIMIT 1","userid,userpw,usernm,userni,phone");
	mysql_data_seek($str[result],$i);
	$Row=mysql_fetch_object($str[result]);
?>
	<table width='500' border=0 cellpadding=3 cellspacing=1>
	<tr><td height=30>개인정보를 수정합니다</td></tr>
	</table>
	<table width='500' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<form name=signform onsubmit='return false'>
	<input type=hidden name="mode" value="admchk">
	<input type=hidden name=userid value="<?=$Row->userid?>">
	<input type=hidden name="userpw_tmp" value="<?=$Row->userpw?>">
	<tr bgcolor=#f7f7f7><td align=right height=26>아이디</td>
		<td bgcolor=#ffffff><b><?=$Row->userid?></b> <font color=red>(변경불가)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right width='100'>이름</td>
		<td bgcolor=#ffffff><input type=text name=usernm size=16 maxlength=20 class=forms value="<?=$Row->usernm?>"></td></tr>
	<!--tr bgcolor=#f7f7f7><td align=right>닉네임</td>
		<td bgcolor=#ffffff><input type=text name=userni size=16 maxlength=20 class=forms value="<?=$userni?>"> <font color=red>(외부에표기)</font></td></tr-->
	<tr bgcolor=#f7f7f7><td align=right>비밀번호</td>
		<td bgcolor=#ffffff><input type=password name='userpw' maxlength=10 size=16 class=forms> <input type=checkbox name=pw_chk value=1>비밀번호 변경시 체크 <font color=red>(4~10자, 영/숫자조합)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>개인연락처</td>
		<td bgcolor=#ffffff><input type=text name=phone size=20 maxlength=30 class=forms value="<?=$Row->phone?>"> <font color=#777777>(구분자 '-')</td></tr>
	</table>


	<table width='500' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td><?//if($_SESSION[AADM]) echo "<a href=\"./administratorlst.php\"><font color=blue>[인트라넷회원관리]</font></a>";?>&nbsp;</td>
		<td align=right><a href="javascript:goCheckIt(signform)"><img src='../images/btn_307.gif' border=0 align=absmiddle></a></td></tr>
	</form>
	</table>
<?
}

function Assign_Confirm_Left_Body() {
}

function Assign_Confirm_Right_Body() {
}

function Assign_Confirm_AdmChk() {
	global $dbCon;
	global $PHP_SELF,$db_name;

	global $userpw,$userpw_tmp,$pw_chk;
	global $userid,$usernm,$userni,$phone;

	if($pw_chk) $upw = $userpw;
	else $upw = $userpw_tmp;

	//$q1_up = "UPDATE $db_name SET usernm='$usernm', phone='$phone' WHERE userid='$userid' LIMIT 1";
	$q1_up = "UPDATE $db_name SET usernm='$usernm', userpw='$upw', phone='$phone' WHERE userid='$userid' LIMIT 1";
	$dbCon->setResult($q1_up);

	$encoded_key = urlencode($key);
    $tmp = time();
   	echo "<script>location.replace('$PHP_SELF?mode=admok&time=$tmp');</script>";
}

function Assign_Confirm_AdmOk() {
    global $PHP_SELF;
?>
	<table width='500' border=0 cellpadding=10 cellspacing=1 bgcolor=#d7d7d7>
	<tr bgcolor=#ffffff><td>
		<b>정보가 정상적으로 수정되었습니다.</b>
		<br><br>
		변경된 정보는 다음 로그인시 적용됩니다.<br>
		반드시 로그아웃을 하신 뒤 이용하여 주시기 바랍니다.<br>
		</td></tr>
	</table>
<?
}

function Assign_Confirm_AdmFail() {
    global $PHP_SELF;
?>
	<table width='500' border=0 cellpadding=10 cellspacing=1 bgcolor=#d7d7d7>
	<tr bgcolor=#ffffff><td>
		<b>정보가 정상적으로 처리되지 않았습니다.</b>
		<br><br>
		다시한번 시도하여 주시기 바랍니다.<br>
		<br>
		<br>
		<a href="javascript:history.go(-1);">◀이전으로</a>
		</td></tr>
	</table>
<?
}

function Assign_Confirm_Html_End() {
	echo "</body></html>";
}

if(!strcmp($mode, "admchk")) {
	Assign_Confirm_AdmChk();
}
elseif(!strcmp($mode, "admfail")) {
    Assign_Confirm_Head();
	Assign_Confirm_Left_Body();
	Assign_Confirm_AdmFail();
	Assign_Confirm_Right_Body();
	Assign_Confirm_Html_End();
}
elseif(!strcmp($mode, "admok")) {
    Assign_Confirm_Head();
	Assign_Confirm_Left_Body();
	Assign_Confirm_AdmOk();
	Assign_Confirm_Right_Body();
	Assign_Confirm_Html_End();
}
else {
    Assign_Confirm_Head();
	Assign_Confirm_Left_Body();
	Assign_Confirm_Admin();
	Assign_Confirm_Right_Body();
	Assign_Confirm_Html_End();
}
?>