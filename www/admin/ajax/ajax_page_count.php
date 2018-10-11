<?php
	include_once("./_common.php");


	$search_field = $_POST["search_field"];
	$search_value = $_POST["search_value"];
	$ca_name = $_POST["ca_name"];

	$where = " 1=1";
	if($search_value) $where .= " ANd wr_subject LIKE '%$search_value%'"; 

	$item_per_page = 10;

	$sql = "SELECT COUNT(*)as cnt FROM psj_member where ".$where;


	$result = sql_query($sql);
	$row = sql_fetch_array($result);
	$pages = ceil($row['cnt']/$item_per_page);



	echo $pages;
	

?>

