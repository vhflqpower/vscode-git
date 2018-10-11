<?
	//DB
	include_once("./_common.php");

// 코드분류 상세정보

	$mb_id = $member['mb_id']; // get the requested page
	$arr_item = array();
	$sql = "select ca_name from psj_memo where mb_id ='$mb_id' and ca_name !='' group by ca_name";
	$result = sql_query( $sql );
	while($row = sql_fetch_array($result)){

		$code = $row['ca_name'];

		$arr_item[$code] = $row[ca_name];
	}

//	$responce['flag'] = 'succ';
//	$responce['message']['cell'] = $row;
//	$responce['rows'] = $row;

	$responce = $arr_item;


echo json_encode($responce);


?>