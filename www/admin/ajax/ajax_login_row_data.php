<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
//	include_once("./_common.php");
	$item_per_page = 20;
//	include_once("./dbconfig.php");

	$search_field = $_POST["search_field"];
	$search_value = $_POST["search_value"];
	$co_id = $_POST["co_id"];


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

	$WHERE ="where 1=1";
	
	if($_POST['mb_id']){
		
	$WHERE .= " and mb_id = '$_POST[mb_id]'";
	}

	$sql = "SELECT a.* FROM psj_login a $WHERE ORDER BY a.lo_datetime DESC LIMIT $position, $item_per_page";
	$results = sql_query($sql);

	$num = 1;
	while($row = sql_fetch_array($results))
	{
		$mo_id = $row['mb_id'];
		$mo_date = $row['mi_date'];
		$wr_subject = $row['mi_memo'];
		
		$mb_id = $row['mb_id'];

		$mb_name =  get_member_name($mb_id);


	//	$str = nl2br($row['wr_content']);

		$arr_company = select_company();
		$company = $arr_company[$co_id];
		//$str = url_auto_link($str);
?>
		 <tr>
			 <td><input type="checkbox" id="chk_wr_id" name="chk_wr_id" value="<?=$row['wr_id']?>"></td>
			 <td><?=$num?></td>
			 <td><?=$row['lo_ip']?></td>
			 <td><?=$mb_name?><span style='color:#0000ff'><?=$mo_id?></span></td>
			 <td><?=$row['lo_datetime'];?></td>
		 </tr>

<?

	//if(count($row['mi_id']) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
$num++;
	}

				
?>

