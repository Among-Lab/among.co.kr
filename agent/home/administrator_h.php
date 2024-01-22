<?
$db_name = "ATmembers";
$tit_doc = "인트라넷회원관리";

$arr_grade = array("0","1","2","3","4","5","6","7","8","9");
//$arr_gradedoc = array("","사원","부서장","중역","대표","","","","","");
//$arr_jpart = array("관리팀","기술영업팀","생산팀","설계팀","연구개발팀","품질팀");
$arr_gradedoc = array("","사원","관리자");
$arr_jpart = array("관리팀");


//------------------------------- Administrator mail send y/n(0:no)
$allow_comment = 0; //allow note comment;
$db_name_comment = "TboardComment";


$admin_notify = 0;
$admin_mail = "";

$max_filesize = "2000000"; //file upload max size
$savedir = "../../datas/pds/"; //file save directory
$file_download = 0; //file download y/n (0:no)
$allow_addfile = 0; //allow add file y/n(0:no)


$allow_center = 0;	// document align center y/n(0:no)
$table_width = "750";	//table width size
$image_width = "650";//이미지 view

//----------------- 화면출력 한페이지 게시물 수 및 블럭단위
$num_per_page = 15;
$page_per_block = 10;
//---------------------- 최근 게시물 설정시간(day) 및 답변글에 대한 indent 한계치
$notify_new_article = 1;
$reply_indent = 5;
//----------------------- 답변이 달린 글에대한 삭제허용여부(삭제허용시 1, 삭제불가시 0)
$allow_delete_thread = 0;
//----------------------- HTML 사용유무
$allow_html = 1; //html tag y/n (0:no)
?>

<?
if(!trim($_SESSION[AGRD]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>top.location.replace('../login.php'); alert('이용권한이 없습니다.');</script>";
	exit;
}
?>