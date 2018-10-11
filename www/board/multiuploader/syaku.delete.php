<?php
include_once("./_common.php");

   $g4[board_file_table] = 'psj_board_img';
  // $FILE_DIR = $_SERVER['DOCUMENT_ROOT']."/mysite/board/data/ckeditor/";  //jquery.syaku.file.v1.0.2
   $app_root = $_SERVER['DOCUMENT_ROOT']; 
   $FILE_DIR = $app_root."/data/board/img/";  //jquery.syaku.file.v1.0.2



	$bo_table = $_POST['bo_table'];
	$file_orl = $_POST['file_orl'];
	$wr_id = $_POST['wr_id'];
	$bf_no = $_POST['bf_no'];

/*
if (!$wr_id) { 
	$wr_id=abs(ip2long($_SERVER['REMOTE_ADDR']));
	if($wr_id >= 2147483647)
		 $wr_code =substr($wr_id,-9);
		 sql_query(" delete from $g4[board_file_table] where  wr_id = '$wr_code'"); 	
}
*/


	if($file_orl && $wr_id && isset($bf_no)){


		@unlink($FILE_DIR.$bo_table."/".$file_orl);
		 sql_query("delete from $g4[board_file_table] where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$bf_no'"); 
		
	}
	

	  header("Content-Type: text/xml; charset=UTF-8");
	  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	  header("Cache-Control: no-store, no-cache, must-revalidate");
	  header("Cache-Control: post-check=0, pre-check=0", false);
	  header("Pragma: no-cache");

	  echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
		<data><item>
		<error>false</error>
		<message>삭제완료</message>
	  </item></data>
	  ";
?>
