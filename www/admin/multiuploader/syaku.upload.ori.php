<?php
//include_once("./_common.php");



/*
@mkdir("$g4[path]/data/ckeditor/", 0707);
@chmod("$g4[path]/data/ckeditor/", 0707);

$ym = date("ym", $g4[server_time]);

define("SAVE_DIR", "$g4[path]/data/ckeditor/$ym");

@mkdir(SAVE_DIR, 0707);
@chmod(SAVE_DIR, 0707);



define("SAVE_URL", "$g4[url]/data/ckeditor/$ym");


  $FILE_DIR = "$g4[url]/data/ckeditor/$ym";
*/


  $FILE_DIR = $_SERVER['DOCUMENT_ROOT']."/board/data/ckeditor/files/";  //jquery.syaku.file.v1.0.2

  $error = 'false';
  $message = '';
  $file_orl = '';
  $file = '';
  $re_file = '';
  
  // 상대경로
  $folder = "../data/ckeditor/files";

  $file_size = '';
  $extension = '';
  $type = '';




	if (!isset($_FILES["file_upload"]) || !is_uploaded_file($_FILES["file_upload"]["tmp_name"]) || $_FILES["file_upload"]["error"] != 0) {
    $error = 'true';
    $message = 'ERROR:invalid upload';
	} else {

    $file = $_FILES["file_upload"]["name"];

    $extension = substr(strrchr($file, "."), 1);
    $filename = substr($file, 0, strlen($file) - strlen($extension) - 1);
    $re_filename = date('siHdmY');
    $re_file = $re_filename .'.' . $extension;


	//	echo $FILE_DIR.$re_file."<--------";

    $cnt = 0;
    while( file_exists($FILE_DIR.$re_file) ) {
      $cnt++;
      $re_file = $re_filename."_".$cnt.".".$extension;


    }

    $file_size = $_FILES["file_upload"]["size"];
    $type = $_FILES["file_upload"]["type"];




    if ( !move_uploaded_file( $_FILES["file_upload"]["tmp_name"] , $FILE_DIR . $re_file ) ) {
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
