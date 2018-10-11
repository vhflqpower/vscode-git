<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	$WHERE =" 1=1";

	$search_field = $_POST["search_field"];
	$search_value = $_POST["search_value"];
	$co_id = $_POST["co_id"];

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

	$arr_gubun =  select_gubun();
	$WHERE ="where mb_id ='' and mb_status < 3";
	if($co_id) $WHERE .= " and mb_1 = '$co_id'";


	$results = sql_query("SELECT mb_no,mb_id,mb_name,mb_hp,mb_tel,mb_email,mb_1,mb_2 FROM psj_member ".$WHERE."  ORDER BY mb_no DESC LIMIT $position, $item_per_page");

	$totalRows = sql_num_rows($results);

	while($row = sql_fetch_array($results))
	{
		$mb_no = $row['mb_no'];
		$wr_id = $row['wr_id'];
		$mb_1 = $row['mb_1'];
		$mb_2 = $row['mb_2'];		
		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);

		$arr_company =  select_company();

		 $arr_level_info =  select_info_gubun('300000');

		$company = $arr_company[$mb_1];
		$levelname = $arr_level_info[$mb_2][0];
?>
		 <tr>
			 <td><input type="checkbox" id="chk_mb_no" name="chk_mb_no" value="<?=$row['mb_no']?>"></td>
			 <td ><div align=center><font color=blue><?=$row['mb_no']?></a></div></td>
			 <td id=item_<?=$row['co_id']?>><?=$row['co_id']?><?=$company?> </td>
			 <td id=item_<?=$row['bo_table']?>><strong><?=$row['mb_name']?></strong><span style="color:#0000ff;"><?=$levelname?></style> </td>
			 <td><?//=$arr_gubun [$bo_table]?><?=$row['mb_hp']?></td>
			 <td><?=$row['mb_tel']?></td>
			 <td ><?=$row['mb_email']?></td>
			 <!-- <td >
			<?=$row['bf_datetime']?>
			 </td> -->
			 <td>
			 <button type="button" class="btn btn-default btn-sm"  data-toggle='modal' data-target='#myModal'  onclick="popEdit('<?=$mb_no?>')" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>
			</td>
		 </tr>

<?

	
	
}

	if( $totalRows < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

	

?>

