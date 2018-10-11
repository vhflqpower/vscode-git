<?php
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/common.php"; 
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/connect.php"; 


		$me_code = $_POST['me_code'];
		$me_name = $_POST['me_name'];
		$p_code = $_POST['MENU_CD'];
		$p_code_name = $_POST['p_code_name'];


	$query ="INSERT INTO tb_cm_menu_sub SET
			me_code = '$me_code',
			me_name = '$me_name',
			p_code = '$p_code',
			p_code_name = '',
			me_part = '2'
			";
			mysql_query($query);

        $responce['flag'] = 'succ';
	    $responce['msg2'] = '수정성공';


	echo json_encode($responce);




?>
