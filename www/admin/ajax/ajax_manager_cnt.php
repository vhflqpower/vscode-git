<?
	//DB
	include_once("./_common.php");

// 코드분류 상세정보

	$co_id = $_POST['co_id']; // get the requested page

	$WHERE = "1=1";

	if($co_id){ $WHERE .= " AND mb_1 = '$co_id'"; }



	$item_per_page = 10;
	$sql2 = "SELECT COUNT(*)as cnt FROM psj_member where $WHERE";
	$result = sql_query($sql2);
	$row = sql_fetch_array($result);
	$total_page = ceil($row['cnt']/$item_per_page);



	//$responce['flag'] = 'succ';
	$responce = $total_page;



echo json_encode($responce);


?>