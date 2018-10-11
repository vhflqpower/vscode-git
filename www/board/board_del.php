<?
$app_path = ".."; // common.php 의 상대 경로
include_once("../common.php");



		$query2 ="delete from psj_board_schedule where wr_id = '$wr_id'";

		//echo $query2."<===쿼리"; exit;
			sql_query($query2);

		goto_url("list.php?bo_table=schedule");



?>