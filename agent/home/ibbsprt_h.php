<?
#<!---------------------------- ���Խ��� -----------------------------------
#������ �ַ���Դϴ�.
#�˰���� �ҽ��� ���� ���� �� �̿� �ÿ��� ������ ������ �������� �˸��ϴ�.
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
$image_width = "650";//�̹��� view

$arr_file_not_ext = array("","html","htm","php","php3","phtml","pl");//Ȯ����
$arr_file_yes_ext = array("","gif","jpg","png");//Ȯ����

$num_per_page = 20;
$page_per_block = 10;
$notify_new_article = 1;//�ֱٰԽù� one days
$reply_indent = 5;//�亯�� indent �Ѱ�ġ
$allow_delete_thread = 0;//1:�亯�ۿ�������� ����
$lock_enable = 1; //1:��бۼ���:������ ��б� �����ϰ�� �亯�� �ڵ� ����
$complete_delete = 1; //1:��������
$memo_enable = 0;//ȸ��Ŀ�´�Ƽ/�޸�
?>

<?
switch($part) {
case 1 :
	$tit_doc = "��������";
	$upload_file_cnt = 2;//�ִ� 6��
	$upload_file_ext = 0;//0:�Ϲ�,1:�̹���
	$upload_file_tdy = 0;//0:�Ϲ�,1:�����̸�time����
	$reply_yesno_act = 0;//�亯��
	$regist_yesno_act = 1;//��Ϲ׼���
	$upload_file_nme = "";//�����̸���time�����ϰ�� �����̸�_time.Ȯ���� �������� ó��
	$popup_gonji = 1;
	break;
case 2 :
	$tit_doc = "�������亯";
	$upload_file_cnt = 2;//�ִ� 6��
	$upload_file_ext = 0;//0:�Ϲ�,1:�̹���
	$upload_file_tdy = 0;//0:�Ϲ�,1:�����̸�time����
	$reply_yesno_act = 1;//�亯��
	$regist_yesno_act = 1;//��Ϲ׼���
	$upload_file_nme = "";//�����̸���time�����ϰ�� �����̸�_time.Ȯ���� �������� ó��
	break;
case 3 : break; //A/S�װ�����û
case 4 :
	$tit_doc = "�ڷ��";
	$upload_file_cnt = 2;//�ִ� 6��
	$upload_file_ext = 0;//0:�Ϲ�,1:�̹���
	$upload_file_tdy = 0;//0:�Ϲ�,1:�����̸�time����
	$reply_yesno_act = 0;//�亯��
	$regist_yesno_act = 1;//��Ϲ׼���
	$upload_file_nme = "";//�����̸���time�����ϰ�� �����̸�_time.Ȯ���� �������� ó��
	break;

default	:
	$tit_doc = "������";
	$upload_file_cnt = 0;//�ִ� 6��
	$upload_file_ext = 0;//0:�Ϲ�,1:�̹���
	$upload_file_tdy = 0;//0:�Ϲ�,1:�����̸�time����
	$reply_yesno_act = 0;//�亯��
	break;
}
?>
<?
if(!trim($_SESSION[AGRD]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>top.location.replace('../login.php'); alert('�̿������ �����ϴ�.');</script>";
	exit;
}
?>