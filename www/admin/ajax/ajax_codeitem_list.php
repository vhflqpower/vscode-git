<?
	//DB
	include_once("./_common.php");

	$code = $_GET['id'];


// 코드항목 리스트

	$sql = "SELECT *  FROM psj_code WHERE pcode = '$code' && part = 2 ORDER BY idx ASC";
	//echo $sql;
	$result = sql_query($sql);
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
	$responce->rows[$i] = $row;
	$i++;
	}


echo json_encode($responce);


?>