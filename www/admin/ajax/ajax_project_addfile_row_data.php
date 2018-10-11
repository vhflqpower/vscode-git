<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	$WHERE =" 1=1";

	$wr_link_file = $_POST["wr_link_file"];
	$search_value = $_POST["search_value"];
	$ca_name = $_POST["ca_name"];

	$bo_table = 'data';

	if(isset($_POST["page"])){
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1;
	}


//$page_number = 1;
// $position, $item_per_page  


	$position = (($page_number-1) * $item_per_page);



	$results = sql_query("SELECT * FROM psj_board_file where 1=1 ORDER BY seq DESC LIMIT $position, $item_per_page");
	while($row = sql_fetch_array($results))
	{
		$seq = $row['seq'];
		$wr_id = $row['wr_id'];
		$bo_subject = $row['bf_source'];

		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);
?>
		 <tr>;
			 <td ><div align=center><font color=blue><?=$row['ca_name']?></a></div></td>
			 <td><?=$wr_id?>]</td>
			 <td id=item_<?=$row['bo_table']?>><?=$bo_subject?> 
			
			 <button type="button" class="btn btn-default btn-xs" onclick="location.href='./download.php?bo_table=<?=$bo_table?>&bf_file=<?=$row[bf_file]?>&bf_source=<?=$row[bf_source]?>&seq=<?=$row[seq]?>'"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Down</button>
			 </td>
			 <td ></td>
			 <td ></td>
			 <td>
			 
			 <button type="button" class="btn btn-default btn-sm"  data-toggle='modal' data-target='#myModal'  onclick="location.href='./dataroom_write.php?seq=<?=$seq?>'" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>
			
			
			</td>
		 </tr>

<?


		if(count($row['seq']) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

}

?>

