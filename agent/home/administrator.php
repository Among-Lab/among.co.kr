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
	<head><title>��Ʈ���</title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<link href="../lib/admin.css" type="text/css" rel=stylesheet>
	<script language="JavaScript">
	<!--
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
	function goCheckIt(form) {
		if(both_trim(form.usernm.value) == "") {
      		alert('�̸��� �Է��ϼ���');
	      	form.usernm.focus();
    	  	return;
   		}/*
		if(both_trim(form.userni.value) == "") {
			alert('�г����� �Է��ϼ���!');
			form.userni.focus();
			return;
   		}*/
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
	//  --> 
	</script> 
	</head>
	<body bgcolor=#ffffff>
<?
}

function Assign_Confirm_Admin() {
	global $dbCon;
    global $PHP_SELF, $db_name;

	//----- ������ �Խù��� �Է°��� �̾Ƴ���. ##########
	$str = $dbCon->dbSelect($db_name,"WHERE userid='$_SESSION[AUID]' LIMIT 1","userid,userpw,usernm,userni,phone");
	mysql_data_seek($str[result],$i);
	$Row=mysql_fetch_object($str[result]);
?>
	<table width='500' border=0 cellpadding=3 cellspacing=1>
	<tr><td height=30>���������� �����մϴ�</td></tr>
	</table>
	<table width='500' border=0 cellpadding=3 cellspacing=1 bgcolor=#dfdfdf>
	<form name=signform onsubmit='return false'>
	<input type=hidden name="mode" value="admchk">
	<input type=hidden name=userid value="<?=$Row->userid?>">
	<input type=hidden name="userpw_tmp" value="<?=$Row->userpw?>">
	<tr bgcolor=#f7f7f7><td align=right height=26>���̵�</td>
		<td bgcolor=#ffffff><b><?=$Row->userid?></b> <font color=red>(����Ұ�)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right width='100'>�̸�</td>
		<td bgcolor=#ffffff><input type=text name=usernm size=16 maxlength=20 class=forms value="<?=$Row->usernm?>"></td></tr>
	<!--tr bgcolor=#f7f7f7><td align=right>�г���</td>
		<td bgcolor=#ffffff><input type=text name=userni size=16 maxlength=20 class=forms value="<?=$userni?>"> <font color=red>(�ܺο�ǥ��)</font></td></tr-->
	<tr bgcolor=#f7f7f7><td align=right>��й�ȣ</td>
		<td bgcolor=#ffffff><input type=password name='userpw' maxlength=10 size=16 class=forms> <input type=checkbox name=pw_chk value=1>��й�ȣ ����� üũ <font color=red>(4~10��, ��/��������)</font></td></tr>
	<tr bgcolor=#f7f7f7><td align=right>���ο���ó</td>
		<td bgcolor=#ffffff><input type=text name=phone size=20 maxlength=30 class=forms value="<?=$Row->phone?>"> <font color=#777777>(������ '-')</td></tr>
	</table>


	<table width='500' border=0 cellspacing=0 cellpadding=0>
	<tr><td height=10 colspan=2></td></tr>
	<tr><td><?//if($_SESSION[AADM]) echo "<a href=\"./administratorlst.php\"><font color=blue>[��Ʈ���ȸ������]</font></a>";?>&nbsp;</td>
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
		<b>������ ���������� �����Ǿ����ϴ�.</b>
		<br><br>
		����� ������ ���� �α��ν� ����˴ϴ�.<br>
		�ݵ�� �α׾ƿ��� �Ͻ� �� �̿��Ͽ� �ֽñ� �ٶ��ϴ�.<br>
		</td></tr>
	</table>
<?
}

function Assign_Confirm_AdmFail() {
    global $PHP_SELF;
?>
	<table width='500' border=0 cellpadding=10 cellspacing=1 bgcolor=#d7d7d7>
	<tr bgcolor=#ffffff><td>
		<b>������ ���������� ó������ �ʾҽ��ϴ�.</b>
		<br><br>
		�ٽ��ѹ� �õ��Ͽ� �ֽñ� �ٶ��ϴ�.<br>
		<br>
		<br>
		<a href="javascript:history.go(-1);">����������</a>
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