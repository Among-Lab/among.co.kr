<?
#<!---------------------------- ���Խ��� -----------------------------------
#���Խ��� �ַ���Դϴ�.
#�˰���� �ҽ��� ���� ���� �� �̿� �ÿ��� ������ ������ �������� �˸��ϴ�.
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
$image_width = "630";//�̹��� view


$arr_file_not_ext = array("","html","htm","php","php3","phtml","pl");//Ȯ����
$arr_file_yes_ext = array("","gif","jpg","png");//Ȯ����
$upload_file_cnt = 1;//�ִ� 6��
$upload_file_ext = 0;//0:�Ϲ�,1:�̹���
$upload_file_tdy = 0;//0:�Ϲ�,1:�����̸�time����
$reply_yesno_act = 0;//�亯��
$regit_yesno_act = 0;//��ϱ�

$num_per_page = 15;
$page_per_block = 10;
$notify_new_article = 1;//�ֱٰԽù� one days
$reply_indent = 5;//�亯�� indent �Ѱ�ġ
$allow_delete_thread = 0;//1:�亯�ۿ�������� ����
$complete_delete = 1; //1:��������
$memo_enable = 0;//ȸ��Ŀ�´�Ƽ/�޸�
$color_table_list = array("top"=>"#1e60a1","tit"=>"#e2edf4","txt"=>"#1e60a1","bar"=>"#bacfdb","mid"=>"#1e60a1","dot"=>"#ededed","ove"=>"#f7f7f7");
?>

<?
//�α��� üũ
/*
if(!trim($_SESSION[UID]) OR !trim($_SESSION[UNM])) {
	echo "<script language='javascript'>";
	echo "history.back();";
	echo "alert('�α����� �ϼž߸� �̿��Ͻ� �� �ֽ��ϴ�.')";
	echo "</script>";
	exit;
}
*/
//����,�亯���� üũ
if( !strcmp($mode,"postform") || !strcmp($mode,"postsave") || !strcmp($mode,"replyform") || !strcmp($mode,"replysave") ) {
	if(!trim($_SESSION[UID]) OR !trim($_SESSION[UNM])) {
		echo "<script language='javascript'>";
		echo "history.back();";
		echo "alert('�α����� �ϼž߸� �̿��Ͻ� �� �ֽ��ϴ�.')";
		echo "</script>";
		exit;
	}
}
?>