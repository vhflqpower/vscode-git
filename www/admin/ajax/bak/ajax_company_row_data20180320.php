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


	$position = (($page_number-1) * $item_per_page);


	$results = sql_query("SELECT co_id,co_name,co_tel,mb_name,co_condition FROM psj_company where 1=1 ORDER BY co_id DESC LIMIT $position, $item_per_page");
	while($row = sql_fetch_array($results))
	{
		$co_id = $row['co_id'];
		$co_name = $row['co_name'];
		$co_tel = $row['co_tel'];
		$mb_name = $row['mb_name'];
		$co_condition = $row['co_condition'];
		//$str = url_auto_link($str);
?>
		 <tr>
			 <!-- <td ><div align=center><font color=blue><?=$row['ca_name']?></a></div></td>; -->
			 <td><input type="checkbox" id="chk_co_id" name="chk_co_id" value="<?=$row['co_id']?>"></td>
			 <td><?=$co_id?></td>
			 <td style="text-align:center;font-weight:bold;" id=item_<?=$row['co_id']?>><a href="./company_view.php?co_id=<?=$co_id?>&part=company"><?=$co_name?></a></td>
			 <td><?=$co_tel?></td>
			 <td><?=$co_tel?></td>
			 <td id=item_<?=$row['co_id']?>><a href="./company_view.php?co_id=<?=$co_id?>"><?=$mb_name?></a></td>
			 <td id=item_<?=$row['co_id']?>><a href="./company_view.php?co_id=<?=$co_id?>"><?=$co_condition?></a></td>
			 <td> <button type="button" class="btn btn-default btn-sm"  onclick="location.href='./company_write.php?co_id=<?=$co_id?>&part=company'" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button></td>
		 </tr>

<?

	if(count($row['co_id']) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

	}

				
?>

