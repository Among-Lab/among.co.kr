<?include "../lib/head.php"?>
</head>
<body leftmargin="0" topmargin="0" style="background:url(../images/bg_subback.jpg) #ffffff top left repeat-X">


<?include "../lib/top.php"?>

<table border="0" cellpadding="0" cellspacing="0" width="900">
<tr><td height="145" valign="top">
	<DIV style="POSITION: absolute;">
	<DIV id=sub style="POSITION: absolute; TOP:-100px;">	
	<script>var objf=fflash("../images/sub.swf",1000,245,"sub","transparent");documentwrite(objf);</script>	
	</DIV></DIV>

	<DIV style="POSITION: absolute;">
	<DIV id=subtxt style="left:600px; POSITION: absolute; TOP:7px;">	
	<script>var objf=fflash("../images/sub_txt.swf",300,110,"subtxt","transparent");documentwrite(objf);</script>	
	</DIV></DIV>


</td></tr>
</table>



<table border="0" cellpadding="0" cellspacing="0" width="900">
<tr><td width="20" height="455"><img src="../images/space.gif" width="20" height="1"></td>
	<td width="190" valign="top">
	
	<!----------- ����޴� ------------------->
		
		
		<table border="0" cellpadding="0" cellspacing="0" width="190">
		<tr><td height="199" valign="top">
		<DIV style="POSITION: absolute">
		<DIV id=submenu style="LEFT:0px; POSITION: absolute; TOP:-50px">
		<script>var objf=fflash("img/sub_menu.swf?mainNum=3",190,258,"submenu","transparent");documentwrite(objf);</script>
		</DIV></DIV>
		</td></tr>		
		</table>

		<?include "../lib/banner.php"?>
	<!----------- //����޴� end ---------------->	
	
	</td>
	<td width="50"><img src="../images/space.gif" width="50" height="1"></td>
	<td width="650" valign="top">

	<!----------���-------->
	<table cellspacing="0" cellpadding="0" border="0" width="640">
	<tr><td valign="top" style="padding-top:12px"><img src="img/tit_pds.gif"></td>
		<td align="right" valign="top" style="padding-top:15px">
		<table cellspacing="0" cellpadding="0" border="0">
		<tr><td valign="top" nowrap class="mtext02"><img src="../images/icon_home.gif"> <a href='../' target='_top' class="cate">Home</a> &gt  <font color="#888888">������</font> &gt  <font color="#888888">�ڷ��</font></td></tr>
		</table>		
	</td></tr>
	</table>
		
	<!----------//��� end--------->


		
	<br style="line-height:20px">


	<!----------- ���� ----------------------->

		
		<script language='javascript'>
		function resizeIframe(fr) { 
		fr.setExpression('height',if_bbs_id.document.body.scrollHeight+20); 
		//fr.setExpression('width',if_bbs_id.document.body.scrollWidth); 
		} 
		</script>
		<table border=0 cellpadding=0 cellspacing=0 align=center>
		<tr><td height=200 valign=top>
		<iframe id="if_bbs_id" name="if_bbs_" src="bbs_pds.php?<?=$_SERVER[QUERY_STRING]?>" style="width:640px;" vspace="0" hspace="0" marginwidth="0" marginheight="0" frameborder="0" scrolling="no" ALLOWTRANSPARENCY="true" onload='resizeIframe(this);'></iframe>
			</td></tr>
		</table>




		<!----------- //����end ----------------------->	



	</td></tr>
</table>







<br style="line-height:45px">
<?include "../lib/trail.php"?>