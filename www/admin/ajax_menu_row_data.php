<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 20;
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

	$results = sql_query("SELECT * FROM psj_menu_config where 1=1 ORDER BY me_code DESC LIMIT $position, $item_per_page");
	while($row = sql_fetch_array($results))
	{
		$me_code = $row['me_code'];
		$me_subject = $row['me_subject'];

		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);
?>
		 <tr>;
			 <td ><div align=center><font color=blue><?=$row['ca_name']?></a></div></td>;
			 <td><?=$me_code?></td>;
			 <td id=item_<?=$row['me_code']?>><?=$me_subject?></td>
			 <td ><?=$row['me_list_level']?></td>
			 <td ></td>
			 <td>
			 
			 <button type="button" class="btn btn-default btn-sm"  data-toggle='modal' data-target='#myModal'  onclick="location.href='./menu_write.php?me_code=<?=$me_code?>&part=menu'" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>
			
			
			</td>
		 </tr>

<?

		if(count($row) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

}

?>

