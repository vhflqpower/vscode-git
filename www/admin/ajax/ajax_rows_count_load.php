<?
	//DB
	include_once("./_common.php");

// 코드분류 상세정보

	$cat1 = $_POST['cat1']; // get the requested page
	$mb_id = $_POST['mb_id']; // get the requested page
	//if($id){
	$WHERE = "1=1";


if($_POST['part']=='login'){
	if($mb_id){ $WHERE .= " AND mb_id = '$mb_id'"; }
	$item_per_page = 20;
	$sql = "SELECT COUNT(*)as cnt FROM psj_login WHERE $WHERE";

}else if($_POST['part']=='mileage'){
	
	if($mb_id){ $WHERE .= " AND mb_id = '$mb_id'"; }
	$item_per_page = 20;
	$sql = "SELECT COUNT(*)as cnt,SUM(mi_point)as mileage_sum  FROM psj_mileage WHERE $WHERE";

}else if($_POST['part']=='info'){
	
	$item_per_page = 20;
	$sql = "SELECT COUNT(*)as cnt  FROM psj_board WHERE  bo_table='info'";

}
	
	
	$result = sql_query($sql);
	$row = sql_fetch_array($result);
	$pages = ceil($row['cnt']/$item_per_page);


	$responce['flag'] = 'succ';
	//$responce['message']['cell'] = $row;


if($_POST['part']=='login'){

	$responce['rows'] = array("pages"=>$pages,"cnt"=>$row['cnt']);//$row['cnt'];

}else if($_POST['part']=='mileage'){
	
	$responce['rows'] = array("pages"=>$pages,"cnt"=>$row['cnt'],"mileage_sum"=>$row['mileage_sum']);//$row['cnt'];

}else if($_POST['part']=='info'){
	
	$responce['rows'] = array("pages"=>$pages,"cnt"=>$row['cnt']);//$row['cnt'];

}






echo json_encode($responce);


?>