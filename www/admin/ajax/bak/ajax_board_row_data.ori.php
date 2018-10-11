<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	$WHERE =" 1=1";

	$search_field = $_POST["search_field"];
	$search_value = $_POST["search_value"];
	$cat1 = $_POST["cat1"];



	if(isset($_POST["page"])){
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1;
	}


//$page_number = 1;
// $position, $item_per_page  


	$position = (($page_number-1) * $item_per_page);


	$where = " bo_table='info'";
	if($cat1) $where .= " AND a.wr_cat1 = '$cat1'"; 
	//if($search_value) $where .= " AND a.wr_subject LIKE '%$search_value%'"; 

	$results = sql_query("SELECT a.*,(select c.codename from psj_code c where a.wr_cat1= c.code && c.pcode='100000') as ca_name FROM psj_board a where ".$where." ORDER BY a.wr_id DESC LIMIT $position, $item_per_page");
	while($row = sql_fetch_array($results))
	{
		$wr_id = $row['wr_id'];
		$wr_subject = $row['wr_subject'];

		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);
?>
		 <tr>
			 <td><?=$wr_id?></td>;
			 <td ><!-- <div align=center> --><font color=blue><?=$row['ca_name']?></a><!-- </div> --></td>
			 <td id=item_<?=$row['wr_id']?>><strong><a href="./board_view.php?wr_id=<?=$wr_id?>&part=info"><?=$wr_subject?></a></strong></td>
			 <td ><?=$row['wr_name']?></td>
			 <td ><?=$row['wr_datetime']?></td>
			 <td></td>
		 </tr>

<?


		if(count($row) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

}

?>

