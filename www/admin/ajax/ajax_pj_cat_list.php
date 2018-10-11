<?
	//DB
	include_once("./_common.php");

// 코드분류 리스트

	$part = $_GET['part'];
	$pcode = $_GET['pcode'];
	$pj_id = $_GET['pj_id'];


	$WHERE = "";


	if($part==2 || $part==3){
		$sql = "SELECT * FROM psj_project_item WHERE pcode = '$pcode' and  part = {$part} and pj_id ={$pj_id} ORDER BY pi_id ASC";
	}else{
		$sql = "SELECT * FROM psj_project_item WHERE part = {$part}  and pj_id ={$pj_id}  ORDER BY pi_id ASC";
	}
		


	$result = sql_query($sql);
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
	$responce->rows[$i] = $row;
	$i++;
	}


	
	if( count($responce->rows) < 1){
	
	$responce->flag = 'fail';
	}else{
	
	
	$responce->flag = 'succ';
	$responce->message ='정상입력완료';
	
	
	}


	echo json_encode($responce);


?>