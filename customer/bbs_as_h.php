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
$image_width = "630";//�̹��� view

$arr_file_not_ext = array("htm","html","php","php3","phtml","pl");//Ȯ����
$arr_file_yes_ext = array("gif","jpg","png");//Ȯ����

$upload_file_cnt = 0;//�ִ� 6��
$upload_file_ext = 0;//0:�Ϲ�,1:�̹���
$upload_file_tdy = 0;//0:�Ϲ�,1:�����̸�time����
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
*/
?>