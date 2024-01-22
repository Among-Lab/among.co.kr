// Active-X 관련 스크립트 (플래쉬, 동영상에 적용)
/**
 *  f_uri : flash file path
 *  f_width : flash width size
 *  f_height : flash heigh size
 */
function writeObjFlash(f_uri,f_width,f_height){
    document.write('<object width="'+f_width+'" height="'+f_height+'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"> ');
    document.write('<param name="movie" value="'+f_uri+'"> ');
    document.write('<param name="quality" value="high"> ');
    document.write('<param name="scale" value="noscale"> ');
    document.write('<param name="bgcolor" value="#ffffff"> ');
    document.write('<param name="allowScriptAccess" value="sameDomain"> ');
    document.write('<param name="menu" value="false"> ');
    document.write('<param name="wmode" value="transparent" />');
    document.write('<embed src="'+f_uri+'" width="'+f_width+'" height="'+f_height+'" quality="high" scale="noscale" align="left" bgcolor="#ffffff" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"> ');
    document.write('</object> ');
}
function writeObjMovie(f_uri,f_width,f_height){
	document.write("<object name='MediaPlayer1' id='MediaPlayer1' width='"+f_width+"' height='"+f_height+"' classid='clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95' codebase='http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#version=6,4,7,1112' standby='loading windows media player components...' type='application/x-oleobject'>");
	document.write("<param name='filename' value='"+f_uri+"'>");
	document.write("<param name='autostart'   value='true' >");
	document.write("<param name='uiMode' value='none'>");
	document.write("<param name='showcontrols' value='0'>");
	document.write("<param name='showstatusbar' value='0'>");
	document.write("<param name='enablecontextmenu' value='false'>");
	document.write("<param name='transparentatstart' value='true'>");
	document.write("<param name='transparentonstop' value='true'>");
	document.write("<EMBED TYPE='application/x-mplayer2' SRC='"+f_uri+"' NAME='mplay1' WIDTH='"+f_width+"' HEIGHT='"+f_height+"'></EMBED>");
	document.write("</object>");
}

