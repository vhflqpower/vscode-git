<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
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



	$results = sql_query("SELECT * FROM psj_board_config where 1=1 ORDER BY bo_sort DESC LIMIT $position, $item_per_page");
	while($row = sql_fetch_array($results))
	{
		$bo_table = $row['bo_table'];
		$bo_subject = $row['bo_subject'];

		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);

		if($row['bo_use_yn']=='Y')$bo_use='사용';else $bo_use='미사용';
?>
		 <tr>;
			 <td ><div align=center><font color=blue><?=$row['bo_sort']?></a></div></td>;
			 <td><?=$bo_table?></td>;
			 <td id=item_<?=$row['bo_table']?>><?=$bo_subject?></td>
			 <td ><?=$bo_use?></td>
			 <td ></td>
			 <td>
			 
			 <button type="button" class="btn btn-default btn-sm"  data-toggle='modal' data-target='#myModal'  onclick="location.href='./bbs_write.php?bo_table=<?=$bo_table?>&part=bbs'" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>
			
			
			</td>
		 </tr>

<?


		if(count($row) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

}

?>

