<script language="JavaScript" src="../lib/public.js"></script>
<script language="javascript">
function movieView(mName){
	movieAct(1);
	document.MediaPlayer1.filename = "mov/"+mName;
}

function playIt()
{
	movieAct(1);
	if ((navigator.userAgent.indexOf('IE') > -1) && (navigator.platform == "Win32"))
	{	MediaPlayer1.Play();
	}
	else
	{	document.MediaPlayer1.Play();
	}
}

function pauseIt()
{
	movieAct(2);
	if ((navigator.userAgent.indexOf('IE') > -1) && (navigator.platform == "Win32"))
	{	if (MediaPlayer1.PlayState == 2)
		{	MediaPlayer1.Pause();	}
	}
	else
	{	if (document.MediaPlayer1.GetPlayState() == 2)
		{	document.MediaPlayer1.Pause();
		}
	}
}

function stopIt()
{
	movieAct(3);
	if ((navigator.userAgent.indexOf('IE') > -1) && (navigator.platform == "Win32"))
	{	MediaPlayer1.Stop();
		MediaPlayer1.currentPosition = 0;
	}
	else
	{	document.MediaPlayer1.Stop();
		document.MediaPlayer1.CurrentPosition=0;
	}
}

function movieAct(num)
{
	b_play.src = "img/media_play.gif";	
	b_pause.src = "img/media_pause.gif";
	b_stop.src = "img/media_stop.gif";

	if(num==1) b_play.src = "img/media_play.gif";	
	else if(num==2) b_pause.src = "img/media_pause.gif";
	else if(num==3) b_stop.src = "img/media_stop.gif";
}

function volChange(UpDown)
{	if ((navigator.userAgent.indexOf("IE") > -1) && (navigator.platform == "Win32"))
	{	var curVol = MediaPlayer1.Volume;	}
	else
	{	var curVol = document.MediaPlayer1.GetVolume();		}

	if (UpDown == "up")
	{	//curVol = -((Math.abs(curVol))/AUDIOSTEP);
		curVol = -(Math.abs(curVol) - 200);
		if (curVol > -1)
		{	curVol = -1;	}
	}
	else if (UpDown == "down")
	{	//curVol = -((Math.abs(curVol) + 1)*AUDIOSTEP);
		curVol = -(Math.abs(curVol) + 200);
		if (curVol < -10000)
		{	curVol = -10000;	}
	}
	else
	{	if ( vol == -10000 ){  vol = curVol; curVol = -10000; }
		else {  curVol = vol; vol = -10000; }
	}

	curVol = Math.floor(curVol);
	if ((navigator.userAgent.indexOf("IE") > -1) && (navigator.platform == "Win32"))
	{	MediaPlayer1.Volume = curVol;
	}
	else
	{	document.MediaPlayer1.SetVolume(curVol);	}
}
</script>


<table border="0" cellpadding="0" cellspacing="0" width="123">
<tr><td height=125 background="img/bg_vod.gif" align=center valign=top>
	
	<table border=0 cellpadding=0 cellspacing=0 width=114>
	<tr><td height=4></td></tr>
	<tr><td height=77><font color=ffffff>µ¿¿µ»ó</font></td></tr>
	<tr><td height=5></td></tr>
	<tr><td style=padding-left:5px>
		<table border=0 cellpadding=0 cellspacing=0>
		<tr><td><span onclick="javascript:playIt();" style="cursor:hand;" ><img src="img/media_play.gif" border=0 id="b_play"></span></td>	
			<td width=3><img src="../iamges/space.gif" width=3 height=1></td>
			<td><span onclick="javascript:pauseIt();" style="cursor:hand;"><img src="img/media_pause.gif" border=0 id="b_pause"></span></td>
			<td width=3><img src="../iamges/space.gif" width=3 height=1></td>
			<td><span onclick="javascript:stopIt();" style="cursor:hand;"><img src="img/media_stop.gif" border=0 id="b_stop"></span></td></tr>
		</table></td></tr>
	</table>

	


</td></tr>
</table>