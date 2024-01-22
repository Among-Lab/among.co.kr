<? session_start();?>
<?
include "./lib/connect.php";
$dbCon = new dbConn();
?>
<?
function Assign_Confirm_Head() {
?>
	<html>
	<head><title>인트라넷</title>
	<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
	<link href="./lib/admin.css" type="text/css" rel=stylesheet>
	<script language="JavaScript">
	<!-- 
	function login_check(form) {
	if(!form.ConfirmUId.value) {
		alert('아이디를 입력하여 주십시오');
		form.ConfirmUId.focus();
		return(false);
	}
	if(!form.ConfirmUPasswd.value) {
		alert('패스워드를 입력하여 주십시오');
	   	form.ConfirmUPasswd.focus();
  		return(false);
	}
  	form.submit();
	}
	//  --> 
	</script> 
	</head>
	<body bgcolor=#ffffff onload="document.user_login.ConfirmUId.focus()">
	<center>
	<table border=0 cellpadding=0 cellspacing=0 width=100% height=90%>
	<tr><td align=center>
<?
}

function Assign_Confirm_LogIn() {
    global $PHP_SELF;
?>
<form method="post" name="user_login" action="<?=$PHP_SELF?>?mode=loginchk" onsubmit="return login_check(this)">
<!--table border=0 cellpadding=0 cellspacing=0 width=550>
<tr><td><img src="images/logo.gif"></td></tr>
</table-->
<table border=0 cellpadding=0 cellspacing=0 width='582' height='244'>
<!--tr><td background="images/admchk_bg.jpg" valign=top-->
<tr><td background="images/bg_intranet.jpg" valign=top>

	<table border=0 cellpadding=0 cellspacing=0 width='100%'>
	<tr><td width=295></td>
		<td width=227 align=center valign=top>


		<table border=0 cellpadding=0 cellspacing=0 width='100%'>
		<tr><td height=143></td></tr>
		</table>

		<table width=227 border=0 cellpadding=4 cellspacing=1 bgcolor=#cccccc>
		<tr bgcolor=#ffffff><td align=center>
			<table border=0 cellpadding=0 cellspacing=0 width=218>
			<tr><td>
				<table border=0 cellpadding=1 cellspacing=0 width=100%>
				<tr><td align=right><img src="images/admchk_id.gif"></td>
					<td style=padding-left:5px><input name=ConfirmUId maxlength=18 size=14 style="font-size: 12px;border-right: #DBDBDB 1px solid;border-top: #999999 1px solid;border-left: #999999 1px solid; border-bottom: #DBDBDB 1px solid;color:#666666"></td></tr>
				<tr><td align=right><img src="images/admchk_pw.gif"></td>
					<td style=padding-left:5px><input type=password name=ConfirmUPasswd maxlength=18 size=14 style="font-size: 12px;border-right: #DBDBDB 1px solid;border-top: #999999 1px solid;border-left: #999999 1px solid; border-bottom: #DBDBDB 1px solid;color:#666666"></td></tr>
				</table>
				</td>
				<td style=padding-left:5px><input type=image src="images/admchk_login.gif" border=0 align=absmiddle></td></tr>
			</table>
			</td></tr>
		</table>
		
		</td>
		<td width=50>&nbsp;</td></tr>
	</table>

	</td></tr>
</table>
</form>
<?
}

function Assign_Confirm_LoginChk() {
	global $dbCon;
	global $PHP_SELF;

	global $ConfirmUId, $ConfirmUPasswd;
	global $AGRD,$AWEB,$AADM,$AUID,$AUPW,$AUNM,$AUNI,$AEML,$AHPG,$ATEL,$APHN;

  	//------------ 사용자가 입력한 암호문자열을 암호화한다. ##########
  	//$result = $dbCon->setResult("SELECT password('$ConfirmUPasswd')");
  	//$user_pass = mysql_result($result,0,0);

	$str = $dbCon->dbSelect("ATmembers", "WHERE userid='$ConfirmUId' AND userpw='$ConfirmUPasswd' AND usechk > 0","grade,admweb,admadm,userid,userpw,usernm,userni,email,homepage,tel,phone");
	if(!$str[cnt]) {
		echo "<script>
			alert('아이디 또는 비밀번호가 맞지 않습니다.');
			history.back();
			</script>";
	}
	else {
		mysql_data_seek($str[result],0);
		$Row=mysql_fetch_object($str[result]);

		//session_destroy();

		$AGRD = $Row->grade;
		$AWEB = $Row->admweb;
		$AADM = $Row->admadm;
		$AUID = $Row->userid;
		$AUPW = $Row->userpw;
		$AUNM = $Row->usernm;
		$AUNI = $Row->userni;
		$AEML = $Row->email;
		$AHPG = $Row->homepage;
		$ATEL = $Row->tel;
		$AHPG = $Row->phone;
		session_register('AGRD','AWEB','AADM','AUID','AUPW','AUNM','AUNI','AEML','AHPG','ATEL','APHN');


		$dd = time();
		$q_up = "UPDATE ATmembers SET logincnt=logincnt+1, loginlst='$dd' WHERE userid='$ConfirmUId' LIMIT 1";
		$dbCon->setResult($q_up);

		//echo "<script>location.replace('./assign_login.php?mode=loginok');</script>";
		echo "<script>location.replace('./');</script>";
	}
}

function Assign_Confirm_Html_End() {
	echo "</td></tr></table></body></html>";
}

if(!strcmp($mode, "loginchk")) {
	Assign_Confirm_LoginChk();
}
else {
    Assign_Confirm_Head();
	Assign_Confirm_LogIn();
	Assign_Confirm_Html_End();
}
?>