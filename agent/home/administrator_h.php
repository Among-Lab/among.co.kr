<?
$db_name = "ATmembers";
$tit_doc = "��Ʈ���ȸ������";

$arr_grade = array("0","1","2","3","4","5","6","7","8","9");
//$arr_gradedoc = array("","���","�μ���","�߿�","��ǥ","","","","","");
//$arr_jpart = array("������","���������","������","������","����������","ǰ����");
$arr_gradedoc = array("","���","������");
$arr_jpart = array("������");


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
$image_width = "650";//�̹��� view

//----------------- ȭ����� �������� �Խù� �� �� ������
$num_per_page = 15;
$page_per_block = 10;
//---------------------- �ֱ� �Խù� �����ð�(day) �� �亯�ۿ� ���� indent �Ѱ�ġ
$notify_new_article = 1;
$reply_indent = 5;
//----------------------- �亯�� �޸� �ۿ����� ������뿩��(�������� 1, �����Ұ��� 0)
$allow_delete_thread = 0;
//----------------------- HTML �������
$allow_html = 1; //html tag y/n (0:no)
?>

<?
if(!trim($_SESSION[AGRD]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>top.location.replace('../login.php'); alert('�̿������ �����ϴ�.');</script>";
	exit;
}
?>