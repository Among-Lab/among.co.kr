// 2006-04-10
// s: source url
// w: source width
// h: source height
// d: flash id
// t: wmode (choice of 'transparent', 'none', 'opaque' ...)
function fflash(s,w,h,d,t){
        return "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0\" width="+w+" height="+h+" id="+d+"><param name=wmode value="+t+" /><param name=movie value="+s+" /><param name=quality value=high /><embed src="+s+" quality=high wmode="+t+" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/shockwave/download/index.cgi?p1_prod_version=shockwaveflash\" width="+w+" height="+h+"></embed></object>";
}
// write document contents
function documentwrite(src){
        document.write(src);
}
// assign code innerHTML
function setcode(target, code){
        target.innerHTML = code;
}

// html source file write, url is 상대디렉토리 또는 전체URL 기제
//<script>var objf=fflash("img/img.swf",230,78,"ban","transparent");documentwrite(objf);</script>
//<script>var objf=fflash("../images/img.swf",335,300,"ban","transparent");documentwrite(objf);</script>