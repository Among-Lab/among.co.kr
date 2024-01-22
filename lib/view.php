<html>
<head><title>확대보기</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<style type=text/css>
BODY { 
scrollbar-face-color: #ffffff;
scrollbar-highlight-color: #999999;
scrollbar-3dlight-color: #FFFFFF;
scrollbar-shadow-color: #999999;
scrollbar-darkshadow-color: #FFFFFF;
scrollbar-track-color: #FFFFFF;
scrollbar-arrow-color: #ffffff}
</style>
<SCRIPT LANGUAGE="JavaScript">
<!-- 
var isNav4, isIE4;
if (parseInt(navigator.appVersion.charAt(0)) >= 4) {
isNav4 = (navigator.appName == "Netscape") ? 1 : 0;
isIE4 = (navigator.appName.indexOf("Microsoft") != -1) ? 1 : 0;
}
function fitWindowSize() {
if (isNav4) {
window.innerWidth = document.layers[0].document.images[0].width;
window.innerHeight = document.layers[0].document.images[0].height;
}
if (isIE4) {
window.resizeTo(500, 500);
width = 500 - (document.body.clientWidth -  document.images[0].width);
height = 500 - (document.body.clientHeight -  document.images[0].height);

if(width > 830) width=840;
if(height > 630) height=630;
window.resizeTo(width, height);
/*
function move() { window.scroll(window.event.clientX - 80,window.event.clientY -80); }
document.onmousemove = move
*/
   }
}
//-->
</script>
</head>
<!--body bgcolor=#ffffff onLoad="fitWindowSize()" onblur="javascript:self.close();"-->
<body bgcolor=#ffffff onLoad="fitWindowSize();self.focus();window.onblur=function(){window.focus()}" onclick="javascript:self.close();">
<div style="position:absolute; left:0px; top:0px"><img src="<?=$imgsrc?>" alt="닫기"></div>
</body>
</html>

<!--html>
<head><title>코오롱 하늘채</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<SCRIPT LANGUAGE="JavaScript">
var isNav4, isIE4;
if (parseInt(navigator.appVersion.charAt(0)) >= 4) {
isNav4 = (navigator.appName == "Netscape") ? 1 : 0;
isIE4 = (navigator.appName.indexOf("Microsoft") != -1) ? 1 : 0;
}
function fitWindowSize() {
if (isNav4) {
window.innerWidth = document.layers[0].document.images[0].width;
window.innerHeight = document.layers[0].document.images[0].height;
}
if (isIE4) {
window.resizeTo(500, 500);
width = 500 - (document.body.clientWidth -  document.images[0].width);
height = 500 - (document.body.clientHeight -  document.images[0].height);
window.resizeTo(width, height);
   }
}
</script>
</head>
<body bgcolor=#ffffff onLoad="fitWindowSize()" onclick="javascript:self.close();" style="cursor: hand">
<div style="position:absolute; left:0px; top:0px">
<img src="<?=$imgsrc?>" alt="닫기">
</div>
</body>
</html-->