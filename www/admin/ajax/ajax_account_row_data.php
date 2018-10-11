<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
//	include_once("./_common.php");
	$item_per_page = 10;
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
	
	if($_POST['co_id']){
		
	$WHERE .= " and co_id = '$_POST[co_id]'";
	}

	$sql = "SELECT wr_id,wr_subject,wr_sort,co_id FROM psj_account $WHERE ORDER BY wr_sort desc,wr_id DESC LIMIT $position, $item_per_page";
	$results = sql_query($sql);

	while($row = sql_fetch_array($results))
	{
		$wr_id = $row['wr_id'];
		$wr_sort = $row['wr_sort'];
		$wr_subject = $row['wr_subject'];
		
		$co_id = $row['co_id'];
		$str = nl2br($row['wr_content']);

		$arr_company = select_company();
		$company = $arr_company[$co_id];
		//$str = url_auto_link($str);
?>
		 <tr>
			 <!-- <td ><div align=center><font color=blue><?=$row['ca_name']?></a></div></td>; -->
			 <td><input type="checkbox" id="chk_wr_id" name="chk_wr_id" value="<?=$row['wr_id']?>"></td>
			 <td><?=$wr_id?></td>
			 <td><?=$company?></td>
			 <td id=item_<?=$row['wr_id']?> style="font-weight:bold;"><a href="./account_view.php?wr_id=<?=$wr_id?>&part=account"><?=$wr_subject?></a></td>
			  <td><?=$wr_sort?></td>
			 <td><div align="center"><button type="button" class="btn btn-default btn-sm" onclick="location.href='./account_write.php?wr_id=<?=$row['wr_id']?>&part=account'"  >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button></div>
			
			<!-- data-toggle='modal' data-target='#myModal' onclick="memoEdit('<?=$wr_id?>');"  -->
			</td>
		 </tr>

<?

	if(count($row['wr_id']) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

	}

				
?>

