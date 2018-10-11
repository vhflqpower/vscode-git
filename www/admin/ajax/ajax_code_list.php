<?
	//DB
	include_once("./_common.php");

// 코드분류 리스트


	$WHERE = "";

	$sql = "SELECT * FROM psj_code WHERE part = 1 ORDER BY idx ASC";
	$result = sql_query($sql);
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
	$responce->rows[$i] = $row;
	$i++;
	}


echo json_encode($responce);


?>