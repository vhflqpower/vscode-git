<?
	include_once("./_common.php");

// 코드항목 상세정보


	$id = $_GET['id'];
	$pid = $_GET['pid'];

	$sql = "SELECT *  FROM  psj_code WHERE pcode = '$pid' AND code = '$id'";
	$result = sql_query( $sql );
	$row = sql_fetch_array($result);


	$responce['flag'] = 'succ';
	$responce['message']['cell'] = $row;
	$responce['rows'] = $row;

echo json_encode($responce);


?>