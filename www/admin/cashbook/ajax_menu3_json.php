<?php
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/common.php"; 
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/connect.php"; 


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


	$id = $_GET['id'];

	$WHERE = "";

	if($_GET['id']){
	$WHERE .=" where 1=1 AND p_id = '$id'";
	}

	if($search_date){
	$WHERE .= "AND  mo_date BETWEEN '$search_date' AND '$search_date'";
	}


	if($sdate && $edate){
	$WHERE .= "AND  mo_date BETWEEN '$sdate' AND '$edate'";
	}


	if($search_field && $search_value){
	$WHERE .= "AND $search_field LIKE '%$search_value%'";
	}


	$result = mysql_query("SELECT COUNT(*) AS count FROM TB_CM_MENU_SUB  where me_part = '3' and p_code = '$id'");
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	$count = $row['count'];



	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}

	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		

	$sql = "SELECT * from TB_CM_MENU_SUB   where me_part = '3' and p_code = '$id' ORDER BY $sidx $sord LIMIT $start , $limit";
	$result = mysql_query( $sql );


	@$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['me_no'];
		$responce->rows[$i]['cell']=array($row['me_code'],$row['me_name'],$row['me_url'],$row['p_code']); 
		$i++;
	}       
	echo json_encode($responce);

// $row['wedd_place'],

//  구성품 검색 조건    
/*
	public function search_qry($_search,$searchField, $searchString, $searchOper) {
		$wh = "";
		if($_search=='true') {
			// costruct where
			$wh .= $searchField;
			switch ($searchOper) {
				case "bw":
					$searchString .= "%";
					$wh .= " LIKE '".$searchString."'";
					break;

				case "bn":
					$searchString .= "%";
					$wh .= " NOT LIKE '".$searchString."'";
					break;

				case "eq":
					if(is_numeric($searchString)) {
						$wh .= " = ".$searchString;
					} else {
						$wh .= " = '".$searchString."'";
					}
					break;
				case "ne":
					if(is_numeric($searchString)) {
						$wh .= " <> ".$searchString;
					} else {
						$wh .= " <> '".$searchString."'";
					}
					break;
				case "lt":
					if(is_numeric($searchString)) {
						$wh .= " < ".$searchString;
					} else {
						$wh .= " < '".$searchString."'";
					}
					break;
				case "le":
					if(is_numeric($searchString)) {
						$wh .= " <= ".$searchString;
					} else {
						$wh .= " <= '".$searchString."'";
					}
					break;
				case "gt":
					if(is_numeric($searchString)) {
						$wh .= " > ".$searchString;
					} else {
						$wh .= " > '".$searchString."'";
					}
					break;
				case "ge":
					if(is_numeric($searchString)) {
						$wh .= " >= ".$searchString;
					} else {
						$wh .= " >= '".$searchString."'";
					}
					break;
				case "ew":
					$wh .= " LIKE '%".$searchString."'";
					break;
				case "en":
					$wh .= " NOT LIKE '%".$searchString."%'";
					break;
				case "nu":
					$wh .= " IS NULL OR ".$searchField." = ''";
					break;
				case "nn":
					$wh .= " IS NOT NULL AND ".$searchField." != ''";
					break;

				case "cn":
					$wh .= " LIKE '%".$searchString."%'";
					break;

				case "nc":
					$wh .= " NOT LIKE '%".$searchString."'";
					break;

				default :
					$wh = "";
			}
		}
		return $wh;
	}

*/



?>
