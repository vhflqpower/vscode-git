<?
	//DB
	include_once("./_common.php");

// 코드분류 상세정보

	$oper = $_POST['oper']; 
	$pj_id = $_POST['pj_id']; 
	$pi_id = $_POST['pi_id']; 
	$subject = $_POST['subject']; 
	$protage = $_POST['protage']; 
	$pcode = $_POST['pcode'];
	$sdate = $_POST['sdate'];
	$edate = $_POST['edate'];
	$mb_id = $_POST['mb_id'];
	$pj_step = $_POST['pj_step'];




//print_r2($_POST); exit;


	$results = sql_query("SELECT code FROM psj_project_item where 1=1 ORDER BY pi_id DESC LIMIT 1");
	$max_row = sql_fetch_array($results);



	if($oper=='c1_add' && $pi_id==''){
	

	$results = sql_query("SELECT code,sort FROM psj_project_item where part = '1' && pj_id = '$pj_id' ORDER BY sort DESC LIMIT 1");
	$row = sql_fetch_array($results);

	if($row['code']){

	$code = $max_row['code']+1;
	$sort = $row['sort']+1;
	}else{

	$code =  10000;
	$sort =  1;
	}

	$query = "INSERT INTO  psj_project_item SET 
				    pj_id = '$pj_id',
				    code = '$code',
				    subject = '$subject',
				    part = '1',
				    sort = '$sort',
				    pj_step = '$pj_step',
				    protage = '$protage'
				    ";

	$result = sql_query( $query );
	$responce['flag'] = 'succ';
	$responce['message']='정상입력완료';

	
	}



	if($oper=='c1_edit' && $pi_id){
	
	$query = "UPDATE psj_project_item SET 
								pj_step = '$pj_step',
								protage = '$protage',
								subject = '$subject' 
						WHERE pi_id = '$pi_id'";
	$result = sql_query( $query );
	
	$responce['flag'] = 'succ';
	$responce['message']='정상수정완료';

	}



   if($oper=='c1_del' && $pi_id){

			$query = "DELETE FROM psj_project_item WHERE pi_id = $pi_id";
			$result = sql_query( $query );

			$responce['flag'] = 'succ';
			$responce['message']='삭제 되었습니다.';
	   }


	if($oper=='c2_add' && $pi_id==''){
	

	$results = sql_query("SELECT code,sort FROM psj_project_item where part = '2' && pcode = '$pcode' ORDER BY sort DESC LIMIT 1");
	$row = sql_fetch_array($results);

	$code2 = $max_row['code']+1;


	if($row['sort']){
	
	$sort = $row['sort']+1;
	}else{

	
	$sort =  1;
	}

	$query = "INSERT INTO  psj_project_item SET 
				    pj_id = '$pj_id',
				    code = '$code2',
				    subject = '$subject',
				    pcode ='$pcode',
				    part = '2',
				    sort = '$sort',
				    pj_step = '$pj_step',
				    protage = '$protage'
				    ";


	$result = sql_query( $query );
	$responce['flag'] = 'succ';
	$responce['message']='정상입력완료';

	
	}


	
	if($oper=='c2_edit' && $pi_id){
	
	$query = "UPDATE  psj_project_item SET 
									pj_step = '$pj_step',
									protage = '$protage',
									subject = '$subject' 
							WHERE pi_id = '$pi_id'";
							//echo $query; exit;
	$result = sql_query( $query );
	
	$responce['flag'] = 'succ';
	$responce['message']='정상수정완료';

	}


   if($oper=='c2_del' && $pi_id){

			$query = "DELETE FROM psj_project_item WHERE pi_id = $pi_id";
			$result = sql_query( $query );

			$responce['flag'] = 'succ';
			$responce['message']='삭제 되었습니다.';
	}



	if($oper=='c3_add' && $pi_id==''){
	

	$code3 = $max_row['code']+1;

	$results = sql_query("SELECT code,sort FROM psj_project_item where part = '3' && pcode = '$pcode' ORDER BY sort DESC LIMIT 1");
	$row = sql_fetch_array($results);


	if($row['code']){

	$sort = $row['sort']+1;
	}else{

	$code =  10000;
	$sort =  1;
	}

	$query = "INSERT INTO  psj_project_item SET 
				    pj_id = '$pj_id',
				    code = '$code3',
				    subject = '$subject',
				    pcode ='$pcode',
				    part = '3',
				    sort = '$sort',
				    sdate = '$sdate',
				    edate = '$edate',
				    mb_id = '$mb_id',
				    pj_step = '$pj_step',
				    protage = '$protage'
				    ";
					//echo $query; exit;
	$result = sql_query( $query );
	$responce['flag'] = 'succ';
	$responce['message']='정상입력완료';

	
	}




	if($oper=='c3_edit' && $pi_id){
	
	$query = "UPDATE  psj_project_item SET 
									pj_step = '$pj_step',
									protage = '$protage',
									sdate = '$sdate',
									edate = '$edate',
									mb_id = '$mb_id',
									subject = '$subject'
							WHERE pi_id = '$pi_id'";
	$result = sql_query( $query );
	
	$responce['flag'] = 'succ';
	$responce['message']='정상수정완료';

	}


   if($oper=='c3_del' && $pi_id){

			$query = "DELETE FROM psj_project_item WHERE pi_id = $pi_id";
			$result = sql_query( $query );

			$responce['flag'] = 'succ';
			$responce['message']='삭제 되었습니다.';
	}





echo json_encode($responce);


?>