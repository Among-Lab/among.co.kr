<?
$db_name = "Tboard";
$part = "3";
$tit_doc = "";

$max_filesize = "5000000"; //file upload max size
$savedir = "../datas/pds/"; //file save directory
$saveurl = "../datas/pds/"; //file save directory
$file_download = 1; //file download y/n (0:no)

$allow_center = 0;	// document align center y/n(0:no)
$table_width = "100%";	//table width size
$image_width = "630";//이미지 view

$arr_file_not_ext = array("htm","html","php","php3","phtml","pl");//확장자
$arr_file_yes_ext = array("gif","jpg","png");//확장자

$upload_file_cnt = 0;//최대 6개
$upload_file_ext = 0;//0:일반,1:이미지
$upload_file_tdy = 0;//0:일반,1:파일이름time지정
?>

<?
//로그인 체크
/*
if(!trim($_SESSION[UID]) OR !trim($_SESSION[UNM])) {
	echo "<script language='javascript'>";
	echo "history.back();";
	echo "alert('로그인을 하셔야만 이용하실 수 있습니다.')";
	echo "</script>";
	exit;
}
//쓰기,답변권한 체크
if( !strcmp($mode,"postform") || !strcmp($mode,"postsave") || !strcmp($mode,"replyform") || !strcmp($mode,"replysave") ) {
	if(!trim($_SESSION[UID]) OR !trim($_SESSION[UNM])) {
		echo "<script language='javascript'>";
		echo "history.back();";
		echo "alert('로그인을 하셔야만 이용하실 수 있습니다.')";
		echo "</script>";
		exit;
	}
}
*/
?>