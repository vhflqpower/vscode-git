<?php
	include_once("_common.php");


	$page = $_GET['page']; 
	$limit = $_GET['rows']; 
	$sidx = $_GET['sidx']; 
	$sord = $_GET['sord']; 
	$search_field = $_GET['search_field'];
	$search_value = $_GET['search_value'];
	if(!$sidx) $sidx =1;

	$search_date_field = $_GET['search_date_field'];
	$sdate = $_GET['sdate'];
	$edate = $_GET['edate'];
	$search_date = $_GET['search_date'];


	$ta_id = $_GET['ta_id'];


	$WHERE  ="";

	if($gd_id){
	$WHERE .="AND a.gd_id = '$gd_id'";
	}


	if($sdate && $edate){
	$WHERE .= "AND  mo_date BETWEEN '$sdate' AND '$edate'";
	}

	if($search_field && $search_value){
	$WHERE .= "AND $search_field LIKE '%$search_value%'";
	}


	//print_r($_GET);exit;


	if($gd_id){

	$result = sql_query("SELECT COUNT(*) AS count FROM 
														tt_goods_tag_cell a 
												WHERE 1=1
														 $WHERE");

	$row = sql_fetch_array($result);
	$count = $row['count'];

	//echo $count."<-----------";

	$limit = $limit;
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)

	
    // AND a.gd_id =  'test0324'


		$sql = "SELECT a.seq,
					   a.is_open, 
					   b.ta_id,
					   b.ti_percent,
					   c.ta_price,
					   (c.ta_price -((c.ta_price / 100) * b.ti_percent)) as taPrice ,
					   a.is_open 
				FROM tt_goods_tag_cell a,tt_tag_item b,tt_tag c 
				WHERE a.ti_id = b.ti_serial AND b.ta_id = c.ta_id
					$WHERE  ORDER BY  $sidx $sord LIMIT $start , $limit";
			$result = sql_query( $sql );

		// echo $sql;


//  

	@$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = sql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['seq'];        
		
		$responce->rows[$i]['cell']=array($row['tc_no'],$row['seq'],$row['ti_percent'],$row['taPrice'],$row['is_open']);  // $row['regdate_tag'],$row['ti_percent'],$row['taPrice'],$row['is_open']
		$i++;
	}     
	
}
	echo json_encode($responce);



?>
