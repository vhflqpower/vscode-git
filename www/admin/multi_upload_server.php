<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
include_once("_common.php");

	$bo_table= $_GET['bo_table'];
	$wr_id= $_GET['wr_id'];

	$file_path = "..";

		# 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
		@mkdir("$file_path/data/pms/$bo_table", 0707);
		@chmod("$file_path/data/pms/$bo_table", 0707);


if(isset($_FILES["myfile"]))
{
	$ret = array();
          $upload = array();


	$error =$_FILES["myfile"]["error"];
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{


			$fileName = $_FILES["myfile"]["name"];
			$tmp_file = $_FILES['myfile']["tmp_name"];
			$oriName =$_FILES["myfile"]["name"];
			$file_type =$_FILES["myfile"]["type"];
			$file_size =$_FILES["myfile"]["size"];


			$fileName = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x",$fileName);
			$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
			shuffle($chars_array);
			$shuffle = implode("", $chars_array);
			$upload[file] = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $fileName)));

			$dest_file = "$file_path/data/pms/$bo_table/".$upload[file];
			# 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
			$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES["myfile"]["error"]);
			# 올라간 파일의 퍼미션을 변경합니다.
			chmod($dest_file, 0606);



		    $res = sql_query("select bf_no  from psj_board_file where bo_table = '".$bo_table."' and wr_id = '".$wr_id."' order by bf_no desc limit 1");
		    $row = sql_fetch_array($res);

	  		if($row['bf_no']==''){ $bf_no = 0; }else{ $bf_no = $row['bf_no'] + 1;}


		    $encodeFile = $upload[file];

			$file_up = "insert into psj_board_file
				set
					bo_table = '$bo_table',
					wr_id = '$wr_id',
					bf_source = '$oriName',
					bf_filesize = '$file_size',
					bf_no = '$bf_no',
					bf_width = '0',
					bf_height = '0',
					bf_type = '$file_type',
					bf_file = '$encodeFile',
					mb_id = '$member[mb_id]',
					bf_datetime = Now()";

					sql_query($file_up);


 	// 	$fileName = $_FILES["myfile"]["name"];
 	//	move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName);
    	

	$ret[]= $fileName;

	}
	else  //Multiple files, file[]
	{
	
	  
	  $fileCount = count($_FILES["myfile"]["name"]);
	
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["myfile"]["name"][$i];
		//move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);


			$file_type =$_FILES["myfile"]["type"];
			$file_size =$_FILES["myfile"]["size"];

			$tmp_file = $_FILES['myfile']["tmp_name"][$i];
			$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
			$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
			shuffle($chars_array);
			$shuffle = implode("", $chars_array);
			$upload[$i][file] = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));

			$dest_file = "$file_path/data/pms/$bo_table/".$upload[$i][file];
			# 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
			$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES["myfile"]["error"]);
			# 올라간 파일의 퍼미션을 변경합니다.
			chmod($dest_file, 0606);


			$oriName =$_FILES["myfile"]["name"][$i];
			$encodeFile = $upload[$i][file];

		
		    $res = sql_query("select bf_no  from psj_board_file where bo_table = '".$bo_table."' and wr_id = '".$wr_id."' order by bf_no desc limit 1");
		    $row = sql_fetch_array($res);

	  		if($row['bf_no']==''){ $bf_no = 0; }else{ $bf_no = $row['bf_no'] + 1;}

			$file_up = "insert into psj_board_file
				set
					bo_table = '$bo_table',
					wr_id = '$wr_id',
					bf_source = '$oriName',
					bf_filesize = '$bf_filesize',
					bf_no = '$bf_no',
					bf_width = '0',
					bf_height = '0',
					bf_type = '0',
					bf_file = '$encodeFile',
					mb_id = '$member[mb_id]',
					bf_datetime = Now()";

					sql_query($file_up);


			  	$ret[]= $fileName;
	  }
	
	}
    echo json_encode($ret);
 }
 ?>