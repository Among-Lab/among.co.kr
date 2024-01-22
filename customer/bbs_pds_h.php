<?
#<!---------------------------- 웹게시판 -----------------------------------
#웹게시판 솔루션입니다.
#알고리즘및 소스를 무단 도용 및 이용 시에는 법적인 제제가 가해짐을 알립니다.
#Web Site  - http://www.iclc.co.kr
#Copyright(c) ICLC Corp. All Right Reserved.
#--------------------------------------------------------------------------->

$db_name = "Tboard";
$part = "4";
$tit_doc = "";

//------------------------------- Administrator mail send y/n(0:no)
$allow_comment = 0; //allow note comment;
$db_name_comment = "TboardComment";
$admin_notify = 0;
$admin_mail = "";

$max_filesize = "5000000"; //file upload max size
$savedir = "../datas/pds/"; //file save directory
$saveurl = "../datas/pds/"; //file save directory
//$file_download = 1; //file download y/n (0:no)

$table_width = "640";	//table width size
$image_width = "630";//이미지 view


$arr_file_not_ext = array("","html","htm","php","php3","phtml","pl");//확장자
$arr_file_yes_ext = array("","gif","jpg","png");//확장자
$upload_file_cnt = 1;//최대 6개
$upload_file_ext = 0;//0:일반,1:이미지
$upload_file_tdy = 0;//0:일반,1:파일이름time지정
$reply_yesno_act = 0;//답변글
$regit_yesno_act = 0;//등록글

$num_per_page = 15;
$page_per_block = 10;
$notify_new_article = 1;//최근게시물 one days
$reply_indent = 5;//답변글 indent 한계치
$allow_delete_thread = 0;//1:답변글에상관없이 삭제
$complete_delete = 1; //1:완전삭제
$memo_enable = 0;//회원커뮤니티/메모
$color_table_list = array("top"=>"#1e60a1","tit"=>"#e2edf4","txt"=>"#1e60a1","bar"=>"#bacfdb","mid"=>"#1e60a1","dot"=>"#ededed","ove"=>"#f7f7f7");
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
*/
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
?>