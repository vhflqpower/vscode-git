<?php
	header("Content-type: text/xml;charset=utf-8");
	header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");

include_once("./_common.php");


	$pn_id = $_POST['pn_id'];
	$pn_subject = $_POST['pn_subject'];
	$pn_content = $_POST['pn_content'];
	$pn_end_yn = $_POST['pn_end_yn'];
	$pn_grade = $_POST['pn_grade'];
	$check_del = $_POST['check_del'];

if($oper=='add' || $oper=='edit'){
	if(!$pn_id){


	$sql = "INSERT INTO  psj_plan  SET

			pn_subject = '$pn_subject',
			pn_content ='$pn_content',
			mb_id = '$member[mb_id]',
			pn_end_yn = '$pn_end_yn',
			pn_grade = '$pn_grade',
			pn_regdate = Now()";

		 $result = sql_query( $sql );

	    $responce['flag'] = 'succ';
	
	}else{

		if($pn_end_yn=='Y')$ENDDATE = ",pn_endtime = '".date('Y-m-d H:i:s')."'"; else $ENDDATE ='';

		$sql = "UPDATE  psj_plan SET
			pn_subject = '$pn_subject',
			pn_content ='$pn_content',
			pn_end_yn = '$pn_end_yn',
			pn_grade = '$pn_grade'
			$ENDDATE

 			WHERE pn_id = '$pn_id' ";


		 $result = sql_query( $sql );

	    $responce['flag'] = 'succ';
	    $responce['msg2'] = '수정성공';
	
	}
}

if($oper=='del'){

	if($pn_id){


	$sql = "DELETE FROM  psj_plan  WHERE

			pn_id = '$pn_id'";

		 $result = sql_query( $sql );

	    $responce['flag'] = 'succ';
	    $responce['msg2'] = '삭제성공';
	
	}
}



	if($oper=='check_del'){

		$checkArray  = $_POST['checkArray'];

			for($i=0; $i<count($checkArray);$i++){
				$id = $checkArray[$i];

				if($id){
				$query="delete from psj_plan where pn_id='$id'";
				
			//	echo $query."<br>";
				
				sql_query($query);

			}

		}
	$responce['flag'] = 'succ';
	$responce['message'] = '성공';
//	echo json_encode($responce);
	}



	echo json_encode($responce); 
	


?>
