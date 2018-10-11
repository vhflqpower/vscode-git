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
	$part = $_POST["part"];


	if(isset($_POST["page"])){
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1;
	}

//$page_number = 1;
// $position, $item_per_page  

	//$where = " 1=1 and mb_status > 1";
	$where = "1=1 and mb_status > 1 and mb_id !='admin' ";
	if($search_value) $where .= " AND mb_name LIKE '%$search_value%'"; 

/*

		$Sync = new Sync();
		$arrayDatax=array('ordercode'=>$ordercode);
		$srtn=$Sync->OrderInsert($arrayDatax);

*/

	$position = (($page_number-1) * $item_per_page);

	$results = sql_query("SELECT mb_no,mb_id,mb_name,mb_email,mb_birth,mb_level FROM psj_member where  ".$where."  ORDER BY mb_id DESC LIMIT $position, $item_per_page");
	
	while($row = sql_fetch_array($results))
	{
		$mb_id = $row['mb_id'];
		$mb_name = $row['mb_name'];

		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);
?>
		 <tr>
			 <td><input type="checkbox" id="chk_mb_no" name="chk_mb_no" value="<?=$row['mb_no']?>"></td>
			 <td><!-- <div align=center><font color=blue><?=$row['ca_name']?></a></div> --><?=$row['mb_no']?></td>;
			 <td><a href="./mypage.php?mb_no=<?=$row['mb_no']?>&part=member"><?=$mb_id?></a></td>;
			 <td id=item_<?=$row['wr_id']?>><a href="./member_view.php?mb_no=<?=$row['mb_no']?>&part=member"><?=$mb_name?></a></td>
			 <td><?=$row['mb_email']?></td>
			 <td><?=$row['mb_birth']?></td>
			 <td><?=$row['mb_level']?></td>
			 <td><button type="button" class="btn btn-default btn-sm" onclick="location.href='./member_write.php?mb_no=<?=$row['mb_no']?>&part=mem'"  >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>
			
			<!-- data-toggle='modal' data-target='#myModal' onclick="memoEdit('<?=$mb_id?>');"  -->
			</td>
		 </tr>

<?

			if(!$row['mb_id']){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

	}

?>

