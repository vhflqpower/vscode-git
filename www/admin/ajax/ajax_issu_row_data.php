<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
//	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	$WHERE =" 1=1";

	$search_field = $_POST["search_field"];
	$search_value = $_POST["search_value"];
	$ca_name = $_POST["ca_name"];


	if(isset($_POST["page"])){
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1;
	}


//$page_number = 1;
// $position, $item_per_page  


	$position = (($page_number-1) * $item_per_page);



	$results = sql_query("SELECT is_id,is_subject FROM psj_issu where 1=1 ORDER BY is_id DESC LIMIT $position, $item_per_page");
	$totalRows = sql_num_rows($results);	
	while($row = sql_fetch_array($results))
	{
		$wr_id = $row['is_id'];
		$wr_subject = $row['is_subject'];

		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);
?>
		 <tr>
			 <!-- <td ><div align=center><font color=blue><?=$row['ca_name']?></a></div></td>; -->
			 <td ><?=$wr_id?><span class="glyphicon glyphicon-move"></span></td>;
			 <td id=item_<?=$row['wr_id']?>><a href="./account_view.php?wr_id=<?=$wr_id?>&part=account"><?=$wr_subject?></a></td>

			 <td><div align="center"><button type="button" class="btn btn-default btn-sm"  data-toggle='modal' data-target='#myModal' onclick="memoEdit('<?=$wr_id?>');" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button></div></td>
		 </tr>

<?

	}

	if( $totalRows < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }			
?>

