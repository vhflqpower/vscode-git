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

/*

		$Sync = new Sync();
		$arrayDatax=array('ordercode'=>$ordercode);
		$srtn=$Sync->OrderInsert($arrayDatax);

*/




	$position = (($page_number-1) * $item_per_page);

	$results = sql_query("SELECT pj_id,pj_subject,pj_open_date FROM psj_project where 1=1 ORDER BY pj_sort DESC LIMIT $position, $item_per_page");
	while($row = sql_fetch_array($results))
	{
		$pj_id = $row['pj_id'];
		$pj_subject = $row['pj_subject'];

		$str = nl2br($row['pj_content']);
		//$str = url_auto_link($str);
?>
		 <tr>
			 <td><input type="checkbox" id="chk_pj_id" name="chk_pj_id" value="<?=$row['pj_id']?>"></td>
			 <!-- <td ><div align=center><font color=blue><?=$row['ca_name']?></a></div></td> -->
			 <td><?=$pj_id?></td>
			 <td id=item_<?=$row['wr_id']?>><a href="./project_view.php?pj_id=<?=$row['pj_id']?>&part=project"><strong><?=$pj_subject?></strong></a></td>
			  <td ><a href="./project_wbs_view.php?pj_id=<?=$row['pj_id']?>&part=project"><strong>[WBS]</strong></a></td>
			 <td ></td>
			 <td ><?=$row['pj_open_date']?></td>
			 <td>
			 <!-- data-toggle='modal' data-target='#myModal' -->
			 <button type="button" class="btn btn-default btn-sm"  onclick="location.href='./project_write.php?pj_id=<?=$pj_id?>&part=project'" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button></td>
		 </tr>

<?

			if(!$row['pj_id']){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

	}


?>

