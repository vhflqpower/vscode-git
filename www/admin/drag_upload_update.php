<?
include_once("_common.php");



	$file_path = "..";


if($_FILES[file][tmp_name]){

			$tmp_file = $_FILES[file][tmp_name];
			$filename = $_FILES[file][name];
			$bf_source = $_FILES[file][name];
			$bf_filesize = $_FILES[file][size];


			if (!$wr_id || $w == "r") { //������ ���;��öȣ071116 //����� ����߰�:Ȳ������ 2010-12-20
				$wr_id=abs(ip2long($_SERVER['REMOTE_ADDR'])).mt_rand(); //IP�� �ӽ÷� ���;��öȣ071116
				if($wr_id >= 2147483647433244) //IP�� �ʹ� Ŭ���;��öȣ071116
					 $wr_id=substr($wr_id,-15); //��ȩ�ڸ��� �ڸ�;��öȣ071116
			}



			
			$filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
			$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));
			shuffle($chars_array);
			$shuffle = implode("", $chars_array);
			$upload[file] = abs(ip2long($_SERVER[REMOTE_ADDR])).'_'.substr($shuffle,0,8).'_'.str_replace('%', '', urlencode(str_replace(' ', '_', $filename)));




			$dest_file = "$file_path/data/temp/".$upload[file];
			# ���ε尡 �ȵȴٸ� �����޼��� ����ϰ� �׾�����ϴ�.
			$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES[bf_file][error][$i]);
			# �ö� ������ �۹̼��� �����մϴ�.
			chmod($dest_file, 0606);

				

			$file_up = "insert into psj_board_file
				set
					wr_id = '$wr_id',
					bf_source = '$bf_source',
					bf_filesize = '$bf_filesize',
					bf_no = '0',
					bf_width = '0',
					bf_height = '0',
					bf_type = '0',
					bf_file = '$upload[file]'";

					sql_query($file_up);
		
		//echo $file_up;
	//	$file_up_seq = sql_insert_id();
			

}



/*
Array
(
    [file] => Array
        (
            [name] => 1.jpg
            [type] => image/jpeg
            [tmp_name] => /tmp/phpgZLouW
            [error] => 0
            [size] => 301690
        )

)
*/
?>