<?
include_once("_common.php");



//	$search_field = $_GET['search_field'];
//	$search_value = $_GET['search_value'];

	$keyword = $_GET['keyword'];


	if($keyword){
	$WHERE = "AND co_name2 LIKE '%$keyword%'";
	}

	
	$sql = "SELECT co_id,co_name2 FROM  cc_company WHERE 1=1 and co_type != '4' and co_no not in('95','588','590','553','542','576','612','613','614','617','642','643','644','647','670','671','681','685','686','687','688','690','691','695','701','714') $WHERE ORDER BY co_no ASC limit 100";
	$result = mysql_query( $sql ) or die("Couldn t execute query.".mysql_error());

	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['co_id'];
		$responce->rows[$i]= $row;

   //     $responce->rows[$s][num] = $count - ($page - 1) * $limit - $s;    

		$i++;
	} 

		if(!$responce)$responce['message'] = 'nodata';
	
	echo json_encode($responce); 

?>
