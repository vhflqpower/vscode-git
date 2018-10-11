<?
	//DB
	include_once("./_common.php");

// 코드분류 상세정보


	$id = $_GET['id']; // get the requested page
	//if($id){

	$sql = "SELECT *  FROM  psj_code WHERE code = '$id'";
	$result = sql_query( $sql );
	$row = sql_fetch_array($result);
	//}

	$responce['flag'] = 'succ';
	$responce['message']['cell'] = $row;
	$responce['rows'] = $row;

echo json_encode($responce);


?>