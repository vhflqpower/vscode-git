<?
	include_once("./_common.php");

   if($oper=='c1_del' && $pi_id){

			$count_sql = "select count(*) AS cnt from psj_project_item where pcode = '$code' AND part = '2'";
			$count_result = sql_query( $count_sql ) or die("Couldn t execute query.".sql_error());
			$count_row = sql_fetch_array($count_result);


			$responce['flag'] = 'succ';
			$responce['cnt'] = $count_row['cnt'];

	}


   if($oper=='c2_del' && $pi_id){

			$count_sql = "select count(*) AS cnt from psj_project_item where pcode = '$code' AND part = '3'";
			$count_result = sql_query( $count_sql ) or die("Couldn t execute query.".sql_error());
			$count_row = sql_fetch_array($count_result);


			$responce['flag'] = 'succ';
			$responce['cnt'] = $count_row['cnt'];

	}


   if($oper=='c3_del' && $pi_id){

			$responce['flag'] = 'succ';
			$responce['cnt'] = '0';

	}





echo json_encode($responce);
?>