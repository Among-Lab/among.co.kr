<?
include "../lib/connect.php";
$dbCon = new dbConn();
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

function Html_Head() {
?>
	<html>
	<head>
	<title>�����˻�</title>
	<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
	<STYLE TYPE="text/css">
	<!--
	BODY,TD,TR,input,DIV,form{font-size:9pt; font-family:����,Tahoma,Verdana,MS Sans Serif,Courier New;}
	.box0{border:solid 1 #bcbcbc;color:#01507D;background-color:FFFFFF;}
	.text0{color:666666;}
	.blinespace { line-height: 150%}
	A:link {FONT-SIZE: 9pt; COLOR:#777777; FONT-FAMILY: ����,����; TEXT-DECORATION: none }
	A:hover {FONT-SIZE: 9pt; COLOR:#03BAD0; FONT-FAMILY: ����,����; TEXT-DECORATION: underline}
	-->
	</style>
<?
}

#--------------------------------------------------------------------------------------------------------------------------������ ���̵� �ߺ�üũ
function Check_AUId() {
	global $dbCon;
	global $UId;
?>
	</head>
	<body bgcolor=#ffffff topmargin=0 leftmargin=0><center>
	<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
	<tr><td bgcolor=#f7f7f7 height=35>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=#0285B0><b>���̵� ��Ͽ��θ� Ȯ���մϴ�.</b></font></td></tr>
	<tr><td bgcolor=#bcbcbc height=1></td></tr>
	<tr><td align=center valign=top><br>

	<table border=0 cellpadding=0 cellspacing=0>
	<tr><td><img src="../images/bg_pop_04.gif"></td></tr>
	<tr><td background="../images/bg_pop_06.gif" align=center height=80 class=text0>

	<?
	$str = $dbCon->dbSelect1("ATmembers", "WHERE userid='$UId'");
	$row = mysql_fetch_row($str);

	if($row) echo "�Է��Ͻ� ���̵�<br><br><b>${UId}</b> (��)�� �̹� <font color=#ff0000>����</font>�մϴ�.";
	else echo "�Է��Ͻ� ���̵�<br><br><b>${UId}</b> (��)�� <font color=#ff0000>��밡��</font>�մϴ�.";
	?>
		</td></tr>
	<tr><td><img src="../images/bg_pop_05.gif"></td></tr>
	</table>

	<br></td></tr>
	<tr><td bgcolor='#bcbcbc' height=1></td></tr>
	<tr><td bgcolor='#f7f7f7' height=24 align=center><a href='javascript:self.close();'>[�ݱ�]</a></td></tr>
	</table>
<?
}

#--------------------------------------------------------------------------------------------------------------------------�г��� �ߺ�üũ
function Check_AUNi() {
	global $dbCon;
	global $uid,$UNi;
?>
	</head>
	<body bgcolor=#ffffff topmargin=0 leftmargin=0><center>
	<table border=0 cellpadding=0 cellspacing=0 width=100% height=100%>
	<tr><td bgcolor=#f7f7f7 height=35>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=#0285B0><b>�г��� ��Ͽ��θ� Ȯ���մϴ�.</b></font></td></tr>
	<tr><td bgcolor=#bcbcbc height=1></td></tr>
	<tr><td align=center valign=top><br>

	<table border=0 cellpadding=0 cellspacing=0>
	<tr><td><img src="../images/bg_pop_04.gif"></td></tr>
	<tr><td background="../images/bg_pop_06.gif" align=center height=80 class=text0>

	<?
	if(!trim($uid)) $str = $dbCon->dbSelect1("ATmembers", "WHERE userni='$UNi'");
	else $str = $dbCon->dbSelect1("ATmembers", "WHERE userid <> '$uid' AND userni='$UNi'");
	$row = mysql_fetch_row($str);

	if($row) echo "�Է��Ͻ� �г���<br><br><b>${UNi}</b> (��)�� �̹� <font color=#ff0000>����</font>�մϴ�.";
	else echo "�Է��Ͻ� �г���<br><br><b>${UNi}</b> (��)�� <font color=#ff0000>��밡��</font>�մϴ�.";
	?>
		</td></tr>
	<tr><td><img src="../images/bg_pop_05.gif"></td></tr>
	</table>

	<br></td></tr>
	<tr><td bgcolor='#bcbcbc' height=1></td></tr>
	<tr><td bgcolor='#f7f7f7' height=24 align=center><a href='javascript:self.close();'>[�ݱ�]</a></td></tr>
	</table>
<?
}

#--------------------------------------------------------------------------------------------------------------------------����ã��
function FindBookForm() {
	global $cdr;
?>
	<script language='javascript'>
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
	function isFormValid( form ) {
		/*
		if(both_trim(form.key.value) == "") { 
			alert("�˻������� �Է��ϼ���."); 
			form.key.focus(); 
			return false; 
		} */
		return true; 
	} 
	function selfclose(val1) {
		opener.signform.bookcd.value=val1;
		self.close();
	}
	//-->
	</script>
	</head>
	<body bgcolor=#ffffff topmargin=0 leftmargin=0><center>
	<table border=0 cellpadding=0 cellspacing=0 width=100%>
	<tr><td bgcolor=#f7f7f7 height=40>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=#0285B0><b>����ã��</b></font></td></tr>
	<tr><td bgcolor=#bcbcbc height=1></td></tr>
	</table>
	<br>
	<form name="mySearchFunc" method="post" action="<?=$PHP_SELF?>" TARGET="_self" onSubmit="return isFormValid(this);">
	<input type=hidden name="mode" value="findbookresult">
	<table border=0 cellpadding=0 cellspacing=0>
	<tr><td><img src="../images/zip_pop_01.gif"></td></tr>
	<tr><td background="../images/zip_pop_03.gif" align=center class=text0>
		<input size="20" maxlength="30" name="key" class=box0> &nbsp; <input type=image src="../images/zip_btn.gif" align=absmiddle>
		<br><br>
		ã���� �ϴ� ����� �Ǵ� ���ڸ��� �Է��ϼ���</td></tr>
	<tr><td><img src="../images/zip_pop_02.gif"></td></tr>
	</table>
	</form>
<?
}

function FindBook() {
	global $dbCon;
	global $key;
	global $cdr;

	//------------ ��ü�Խù��� �� ������ ���� ���Ѵ�. ##########
	if(!eregi("[^[:space:]]+",$key)) {
		$str = $dbCon->dbSelect("Tbooks","ORDER BY regdate DESC","bcod,useauth,subject");
	} else {
   		$encoded_key = urlencode($key);
		$str = $dbCon->dbSelect("Tbooks", "WHERE (binary subject LIKE '%$key%' OR binary useauth LIKE '%$key%') ORDER BY regdate DESC","bcod,useauth,subject");
	}
	echo "<p class=text0>�� $str[cnt] ���� ���簡 �˻��Ǿ����ϴ�.</p>\n";
	echo "<table width='430' border='0' cellpadding=3>\n";
	echo "<tr><td colspan=5 height=2 bgcolor=#bcbcbc></td></tr>";
	echo "<tr align=center><td>�����ڵ�</td><td width=1>|</td><td>�����</td><td width=1>|</td><td>����</td></tr>";
	echo "<tr><td colspan=5 height=1 bgcolor=#bcbcbc></td></tr>";

	
	for($i = 0; $i < $str[cnt]; $i++) {
		mysql_data_seek($str[result],$i);
		$Row=mysql_fetch_object($str[result]);

		echo "<tr><td align=center><a href=\"javascript:selfclose('$Row->bcod')\">$Row->bcod</a></td><td class=text0 width=1>|</td><td>$Row->subject</td><td class=text0 width=1>|</td><td>$Row->useauth</td></tr>\n";
	}
	echo "</table>";
	echo "<br>";
	echo "<table border=0 cellpadding=0 cellspacing=0 width=100%>
		<tr><td bgcolor='#bcbcbc' height=1></td></tr>
		<tr><td bgcolor='#f7f7f7' height=30 align=center><a href='javascript:self.close();'>[�ݱ�]</a></td></tr>
		</table>";
}

function Html_End()
{
	echo "</body></html>";
}

if(!strcmp($mode,"checkaid")) {	//������ ���̵� �ߺ�Ȯ�� üũ
	Html_Head();
	Check_AUId();
	Html_End();
} elseif(!strcmp($mode,"checkni")) {//������ �г��� �ߺ�Ȯ�� üũ
	Html_Head();
	Check_AUNi();
	Html_End();
} elseif(!strcmp($mode,"findbook")) {	//����ã��
	Html_Head();
	FindBookForm();
	Html_End();
} elseif(!strcmp($mode, "findbookresult")) {
	Html_Head();
	FindBookForm();
	FindBook();
	Html_End();
}
?>