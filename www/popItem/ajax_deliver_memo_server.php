<?php
include_once("./_common.php");



		$oper = $_POST['oper'];
		$de_subject = $_POST['de_subject'];
		$de_content = $_POST['de_content'];
		$de_no = $_POST['de_no'];


	# print_r($_POST);exit;

 if($oper=='edit' && $de_no){


	$query ="UPDATE tt_deliver_memo SET

		de_subject = '$de_subject',
		de_content = '$de_content'
			where  de_no = '$de_no'";
			sql_query($query);

        $responce['flag'] = 'succ';
	    $responce['msg2'] = '수정성공';

}


if($oper=='del'  && $de_no){

	$query ="delete from tt_deliver_memo 
			where  de_no = '$de_no'";
			sql_query($query);


        $responce['flag'] = 'succ';
	    $responce['msg2'] = '삭제성공';

}



	echo json_encode($responce);




?>
