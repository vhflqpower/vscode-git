<?php
	include_once("../../common.php");

  $app_root = $_SERVER['DOCUMENT_ROOT'];
  $g4[board_file_table] = 'psj_board_img';
  // 절대경로 
  $FILE_DIR = $app_root."/data/board/img/$bo_table/";  //jquery.syaku.file.v1.0.2

  $error = 'false';
  $message = '';
  $file_orl = '';
  $file = '';
  $re_file = '';
  
  // 상대경로
  $folder = "/data/board/img/$bo_table";
  $file_size = '';
  $extension = '';
  $type = '';


	@mkdir($app_root."/data/board/img/$bo_table", 0707);
	@chmod($app_root."/data/board/img/$bo_table", 0707);


	if (!isset($_FILES["file_upload"]) || !is_uploaded_file($_FILES["file_upload"]["tmp_name"]) || $_FILES["file_upload"]["error"] != 0) {
    $error = 'true';
    $message = 'ERROR:invalid upload';
	} else {

    $file = $_FILES["file_upload"]["name"];

/*
    $extension = substr(strrchr($file, "."), 1);
    $filename = substr($file, 0, strlen($file) - strlen($extension) - 1);
    $re_filename = date('siHdmY');
    $re_file = $re_filename .'.' . $extension;
*/

	$upload     = array();
	$tmp_file   = $_FILES['file_upload']['tmp_name'];
	$filenamex   = $_FILES["file_upload"]["name"]; // $_FILES['file']['name'];
	$filesize   = $_FILES['file_upload']['size'];


// if ($_FILES["file_upload"]["tmp_name"]) {


	$wr_id = $wr_id;

if (!$wr_id || $w == "r") { //새글일 경우;김철호071116 //답글일 경우추가:황보석영 2010-12-20
	$wr_id=abs(ip2long($_SERVER['REMOTE_ADDR'])); //IP를 임시로 사용;김철호071116
	if($wr_id >= 2147483647) //IP가 너무 클경우;김철호071116
		 $wr_id=substr($wr_id,-9); //아홉자리로 자름;김철호071116
}


    $upload['source'] = $filenamex;
    $upload['filesize'] = $filesize;

    // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
    $filenamex = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filenamex);

    // 접미사를 붙인 파일명
    $upload['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr(md5(uniqid($g4['server_time'])),0,8).'_'.str_replace('%', '', urlencode($filenamex)); 


        $dest_file =  $FILE_DIR.$upload[file];

	// $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['file']['error']);
  	// 올라간 파일의 퍼미션을 변경합니다.
	//  chmod($dest_file, 0606);

  //  $timg = @getimagesize($upload[file]);



	$timg =  @getimagesize($dest_file);

    $res = sql_query("select max(bf_no) as fn from $g4[board_file_table] where bo_table='$bo_table' and wr_id='{$wr_id}'");
	$row = sql_fetch_array($res);

    if($row['fn']=='') 
		$bf_no = 0;
	else
		$bf_no = $row['fn']+1; 


    $re_file = $upload[file];




    $cnt = 0;
    while( file_exists($FILE_DIR.$re_file) ) {
      $cnt++;
      
	  //$re_file = $re_filename."_".$cnt.".".$extension;
		$re_file = $upload[file];
	}


		$sql = " insert into $g4[board_file_table] ";
		$sql .= " set bo_table = '$bo_table' ";
		$sql .= ",wr_id = '$wr_id'";
		$sql .= ",bf_no = '$bf_no'";
		$sql .= ",bf_source = '$file'";		
		$sql .= ",bf_file = '{$upload[file]}'";
		$sql .= ",bf_filesize = '{$filesize}'";
		$sql .= ",bf_width = '{$timg[image][0]}'";
		$sql .= ",bf_height = '$timg[image][1]'";
		$sql .= ",bf_type = '{$timg[image][2]}'";
		$sql .= ",bf_datetime = Now()";
		sql_query($sql);
	


	$file_size = $_FILES["file_upload"]["size"];
    $type = $_FILES["file_upload"]["type"];

//}


    if ( !move_uploaded_file( $_FILES["file_upload"]["tmp_name"] , $FILE_DIR.$re_file ) ) {
      $error = 'true';
      $message = 'ERROR1:not upload';
    }

  }

  header("Content-Type: text/xml; charset=UTF-8");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");

  echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>
    <data><item>
    <error>" . $error . "</error>
    <message>" . $message . "</message>
    <file_orl>" . $file_orl . "</file_orl>
    <filename>" . $file . "</filename>
    <re_file>" . $re_file . "</re_file>
    <folder>" . $folder . "</folder>
    <file_size>" . $file_size . "</file_size>
    <extension>" . $extension . "</extension>
    <type>" . $type . "</type>
  </item></data>
  ";
?>
