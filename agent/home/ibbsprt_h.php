<?
#<!---------------------------- 웹게시판 -----------------------------------
#씨엘씨 솔루션입니다.
#알고리즘및 소스를 무단 도용 및 이용 시에는 법적인 제제가 가해짐을 알립니다.
#Web Site  - http://www.iclc.co.kr
#Copyright(c) ICLC Corp. All Right Reserved.
#--------------------------------------------------------------------------->

$db_name = "Tboard";

//------------------------------- Administrator mail send y/n(0:no)
//$allow_comment = 0; //allow note comment;
//$db_name_comment = "TboardComment";

$max_filesize = "10000000"; //file upload max size
$savedir = "../../datas/pds/"; //file save directory
$saveurl = "../../datas/pds/"; //file save directory
//$file_download = 1; //file download y/n (0:no)

$table_width = "750";	//table width size
$image_width = "650";//이미지 view

$arr_file_not_ext = array("","html","htm","php","php3","phtml","pl");//확장자
$arr_file_yes_ext = array("","gif","jpg","png");//확장자

$num_per_page = 20;
$page_per_block = 10;
$notify_new_article = 1;//최근게시물 one days
$reply_indent = 5;//답변글 indent 한계치
$allow_delete_thread = 0;//1:답변글에상관없이 삭제
$lock_enable = 1; //1:비밀글설정:원문이 비밀글 설정일경우 답변글 자동 설정
$complete_delete = 1; //1:완전삭제
$memo_enable = 0;//회원커뮤니티/메모
?>

<?
switch($part) {
case 1 :
	$tit_doc = "공지사항";
	$upload_file_cnt = 2;//최대 6개
	$upload_file_ext = 0;//0:일반,1:이미지
	$upload_file_tdy = 0;//0:일반,1:파일이름time지정
	$reply_yesno_act = 0;//답변글
	$regist_yesno_act = 1;//등록및수정
	$upload_file_nme = "";//파일이름이time지정일경우 파일이름_time.확장자 형식으로 처리
	$popup_gonji = 1;
	break;
case 2 :
	$tit_doc = "질문과답변";
	$upload_file_cnt = 2;//최대 6개
	$upload_file_ext = 0;//0:일반,1:이미지
	$upload_file_tdy = 0;//0:일반,1:파일이름time지정
	$reply_yesno_act = 1;//답변글
	$regist_yesno_act = 1;//등록및수정
	$upload_file_nme = "";//파일이름이time지정일경우 파일이름_time.확장자 형식으로 처리
	break;
case 3 : break; //A/S및견적요청
case 4 :
	$tit_doc = "자료실";
	$upload_file_cnt = 2;//최대 6개
	$upload_file_ext = 0;//0:일반,1:이미지
	$upload_file_tdy = 0;//0:일반,1:파일이름time지정
	$reply_yesno_act = 0;//답변글
	$regist_yesno_act = 1;//등록및수정
	$upload_file_nme = "";//파일이름이time지정일경우 파일이름_time.확장자 형식으로 처리
	break;

default	:
	$tit_doc = "미지정";
	$upload_file_cnt = 0;//최대 6개
	$upload_file_ext = 0;//0:일반,1:이미지
	$upload_file_tdy = 0;//0:일반,1:파일이름time지정
	$reply_yesno_act = 0;//답변글
	break;
}
?>
<?
if(!trim($_SESSION[AGRD]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>top.location.replace('../login.php'); alert('이용권한이 없습니다.');</script>";
	exit;
}
?>