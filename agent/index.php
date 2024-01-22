<? session_start();?>
<?
if(!trim($_SESSION[AGRD]) OR !trim($_SESSION[AUID])) {
	echo "<script language='javascript'>";
	echo "top.location.replace('./login.php');";
	echo "</script>";
	exit;
} else{
	echo "<script language='javascript'>";
	echo "top.location.replace('./home/');";
	echo "</script>";
	exit;
}
?>