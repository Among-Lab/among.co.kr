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
	
	<!----------- 서브메뉴 ------------------->
		
		
		<table border="0" cellpadding="0" cellspacing="0" width="190">
		<tr><td height="215" valign="top">
		<DIV style="POSITION: absolute">
		<DIV id=submenu style="LEFT:0px; POSITION: absolute; TOP:-50px">
		<script>var objf=fflash("img/sub_menu.swf?mainNum=2",190,258,"submenu","transparent");documentwrite(objf);</script>
		</DIV></DIV>
		</td></tr>		
		</table>

		<?include "../lib/banner.php"?>
	<!----------- //서브메뉴 end ---------------->	
	
	</td>
	<td width="50"><img src="../images/space.gif" width="50" height="1"></td>
	<td width="650" valign="top">

	<!----------경로-------->
	<table cellspacing="0" cellpadding="0" border="0" width="640">
	<tr><td valign="top" style="padding-top:12px"><img src="img/tit_license.gif"></td>
		<td align="right" valign="top" style="padding-top:15px">
		<table cellspacing="0" cellpadding="0" border="0">
		<tr><td valign="top" nowrap class="mtext02"><img src="../images/icon_home.gif"> <a href='../' target='_top' class="cate">Home</a> &gt  <font color="#888888">회사소개</font> &gt  <font color="#888888">인증현황</font></td></tr>
		</table>		
	</td></tr>
	</table>
		
	<!----------//경로 end--------->


		
	<br style="line-height:20px">


	<!----------- 내용 ----------------------->

		<script language=javascript>
		<!--
		var bNetscape4plus = (navigator.appName == "Netscape" && navigator.appVersion.substring(0,1) >= "4");
		var bExplorer4plus = (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.substring(0,1) >= "4");
		function CheckUIElements(){
				var yMenuFrom, yMenuTo, yButtonFrom, yButtonTo, yOffset, timeoutNextCheck;

				if ( bNetscape4plus ) { 
						yMenuFrom   = document["divMenu"].top;
						yMenuTo     = top.pageYOffset + 400;
				}
				else if ( bExplorer4plus ) {
						yMenuFrom   = parseInt (divMenu.style.top, 10);
						yMenuTo     = document.body.scrollTop + 400;
				}

				timeoutNextCheck = 500;

				if ( Math.abs (yButtonFrom - (yMenuTo + 152)) < 6 && yButtonTo < yButtonFrom ) {
						setTimeout ("CheckUIElements()", timeoutNextCheck);
						return;
				}

				if ( yButtonFrom != yButtonTo ) {
						yOffset = Math.ceil( Math.abs( yButtonTo - yButtonFrom ) / 10 );
						if ( yButtonTo < yButtonFrom )
								yOffset = -yOffset;

						if ( bNetscape4plus )
								document["divLinkButton"].top += yOffset;
						else if ( bExplorer4plus )
								divLinkButton.style.top = parseInt (divLinkButton.style.top, 10) + yOffset;

						timeoutNextCheck = 10;
				}
				if ( yMenuFrom != yMenuTo ) {
						yOffset = Math.ceil( Math.abs( yMenuTo - yMenuFrom ) / 20 );
						if ( yMenuTo < yMenuFrom )
								yOffset = -yOffset;

						if ( bNetscape4plus )
								document["divMenu"].top += yOffset;
						else if ( bExplorer4plus )
								divMenu.style.top = parseInt (divMenu.style.top, 10) + yOffset;

						timeoutNextCheck = 10;
				}

				setTimeout ("CheckUIElements()", timeoutNextCheck);
		}
		function OnLoad() {
				var y;
				if ( top.frames.length )
				if ( bNetscape4plus ) {
						document["divMenu"].top = top.pageYOffset + 500;
						document["divMenu"].visibility = "visible";
				}
				else if ( bExplorer4plus ) {
						divMenu.style.top = document.body.scrollTop + 500;
						divMenu.style.visibility = "visible";
				}
				CheckUIElements();
				return true;
		}
		OnLoad();
		//-->
		</script>

		<table cellspacing="0" cellpadding="0" border="0" width="610">
		<tr><td valign=top><img src="img/img_lic.gif"></td></tr>			
		</table>

		<br>



		<table border="0" cellpadding="0" cellspacing="0" align="center">
		<tr><td width="160" align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="155" background="img/bg_lic.gif">
			<tr><td height="199" valign="top" style="padding:27 0 0 28"><a href="#" onClick="popup_image('../lib/view.php?imgsrc=../intro/img/img_01.gif','zoom',358,268);return false"><img src="img/img_s01.gif" border=0 width=100 height=145></td></tr>
			</table></td>
			<td width="160" align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="155" background="img/bg_lic.gif">
			<tr><td height="199" valign="top" style="padding:27 0 0 28"><a href="#" onClick="popup_image('../lib/view.php?imgsrc=../intro/img/img_02.gif','zoom',358,268);return false"><img src="img/img_s02.gif" border=0 style='border-color:#967870;'></td></tr>
			</table></td>
			<td width="160" align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="155" background="img/bg_lic.gif">
			<tr><td height="199" valign="top" style="padding:27 0 0 28"><a href="#" onClick="popup_image('../lib/view.php?imgsrc=../intro/img/img_03.gif','zoom',358,268);return false"><img src="img/img_s03.gif" border=0 style='border-color:#967870;'></td></tr>
			</table></td>
			<td width="160" align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="155" background="img/bg_lic.gif">
			<tr><td height="199" valign="top" style="padding:27 0 0 28"><a href="#" onClick="popup_image('../lib/view.php?imgsrc=../intro/img/img_04.gif','zoom',358,268);return false"><img src="img/img_s04.gif" border=0 style='border-color:#967870;'></td></tr>
			</table>
		
		
		</td></tr>
		<tr><td colspan=4 height=4></td></tr>
		<tr align=center>
			<td valign=top>사업자등록증</td>	
			<td valign=top>벤처기업확인서</td>
			<td valign=top>소프트웨어사업자</td>
			<td valign=top>기업부설연구소인정서</td></tr>
		</table>


		<br style="line-height:10px">



		<table border="0" cellpadding="0" cellspacing="0" align="center">
		<tr><td width="160" align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="155" background="img/bg_lic.gif">
			<tr><td height="199" valign="top" style="padding:27 0 0 28"><a href="#" onClick="popup_image('../lib/view.php?imgsrc=../intro/img/img_04.gif','zoom',358,268);return false"><img src="img/img_s05.gif" border=0 width=100 height=145></td></tr>
			</table></td>
			<td width="160" align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="155" background="img/bg_lic.gif">
			<tr><td height="199" valign="top" style="padding:27 0 0 28"><a href="#" onClick="popup_image('../lib/view.php?imgsrc=../intro/img/img_06.gif','zoom',358,268);return false"><img src="img/img_s06.gif" border=0 style='border-color:#967870;'></td></tr>
			</table></td>
			<td width="160" align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="155">
			<tr><td height="199" valign="top" style="padding:27 0 0 28"><a href="#" onClick="popup_image('#','zoom',358,268);return false">&nbsp;</td></tr>
			</table></td>
			<td width="160" align="center">
			<table border="0" cellpadding="0" cellspacing="0" width="155">
			<tr><td height="199" valign="top" style="padding:27 0 0 28"><a href="#" onClick="popup_image('#','zoom',358,268);return false">&nbsp;</td></tr>
			</table>
		
		
		</td></tr>
		<tr><td colspan=4 height=4></td></tr>
		<tr align=center>
			<td valign=top>공장등록증명서</td>	
			<td valign=top>정보통신공사등록증</td>
			<td valign=top>&nbsp;</td>
			<td valign=top>&nbsp;</td></tr>
		</table>
		
		


<!----------- //내용end ----------------------->	



	</td></tr>
</table>







<br style="line-height:45px">
<?include "../lib/trail.php"?>