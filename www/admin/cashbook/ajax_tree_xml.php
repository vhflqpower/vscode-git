<?php
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/common.php"; 
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/connect.php"; 



		$node = (integer)$_REQUEST["nodeid"];
		// detect if here we post the data from allready loaded tree
		// we can make here other checks
		if( $node >0) {
			$n_lft = (integer)$_REQUEST["n_left"];
			$n_rgt = (integer)$_REQUEST["n_right"];
			$n_lvl = (integer)$_REQUEST["n_level"];

			$n_lvl = $n_lvl+1;
			$SQL = "SELECT * FROM TB_CM_MENU WHERE 1=1";
		} else { 
			// initial grid
			$SQL = "SELECT * FROM TB_CM_MENU WHERE 1=1";
		}



		$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());
		if ( stristr($_SERVER["HTTP_ACCEPT"],"application/xhtml+xml") ) {
		header("Content-type: application/xhtml+xml;charset=utf-8"); } else {
		header("Content-type: text/xml;charset=utf-8");
		}
		$et = ">";
		echo "<?xml version='1.0' encoding='utf-8'?$et\n";
		   echo "<rows>";
		echo "<page>1</page>";
		echo "<total>1</total>";
		echo "<records>1</records>";
		// be sure to put text data in CDATA
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			echo "<row>";			
			echo "<cell>". $row[SEQ]."</cell>";
			echo "<cell>". $row[MENU_NM]."</cell>";
			echo "<cell>". $row[DT_REG]."</cell>";
			echo "<cell>". $row[SEQ]."</cell>";
			echo "<cell>". $row[SEQ]."</cell>";
			echo "<cell>". $row[SEQ]."</cell>";
			echo "<cell>". $row[SEQ]."</cell>";
			echo "<cell>". $row[SEQ]."</cell>";
			echo "<cell>". $row[SEQ]."</cell>";
			if($row[SEQ] == $row[SEQ]+1) $leaf = 'true';else $leaf='false';
			echo "<cell>".$leaf."</cell>";
			echo "<cell>false</cell>";
			echo "</row>";
		}
		echo "</rows>";	




exit;
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

	$co_id = $_GET['co_id'];
	$cat1 = $_GET['cat1'];

	if($cat1){
	$WHERE .="AND mo_part = '$cat1'";
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


	$result = mysql_query("SELECT COUNT(*) AS count FROM TB_CM_MENU  where 1=1 $WHERE");
	$row = mysql_fetch_array($result,MYSQL_ASSOC);
	$count = $row['count'];

	$limit = $limit;
	if( $count >0 ) {
		$total_pages = ceil($count/$limit);
	} else {
		$total_pages = 0;
	}
	if ($page > $total_pages) $page=$total_pages;
	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
		
	$sql = "SELECT * from TB_CM_MENU where 1=1  $WHERE  ORDER BY  $sidx $sord LIMIT $start , $limit";
	$result = mysql_query( $sql );


	@$responce->page = $page;
	$responce->total = $total_pages;
	$responce->records = $count;
	$i=0;
	while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
		$responce->rows[$i]['id']=$row['MENU_CD'];
		$responce->rows[$i]['cell']=array($row['MENU_CD'],$row['MENU_NM'],$row['DT_REG']);
		$i++;
	}       
	echo json_encode($responce);





?>
