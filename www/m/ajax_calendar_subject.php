<?
include_once("./_common.php");


	if($_GET['wdate']=='undefined'){
		$wr_date = date("Ymd");
	}else{
		$wr_date = $_GET['wdate'];
	}

	$where = '';

	if($wr_date){ 
		$where .= " and wr_1 = '$wr_date'";
	}

	$sql_r = "SELECT *  FROM  psj_board_schedule WHERE 1=1 ".$where." ORDER BY wr_id DESC LIMIT 10";
	$result_r = sql_query($sql_r);
	$cnt = 0;
	while( $row = sql_fetch_array($result_r)){
		$cnt++;

//		print_r($row);

		$wr_id = $row['wr_id'];
		$wr_subject = $row['wr_subject'];
		$mb_id = $row['mb_id'];
		$wr_name = $row['wr_name'];


?>
		<tr class='item_row'>
		  <td style="padding:6px;border-bottom:1px solid #ccc;"><a  href="./schedule_view.php?wr_id=<?=$row['wr_id']?>&page=<?=$page?>" data-rel="external" data-transition="slide"><?=$wr_subject?></a></td>
		  <td style="padding:6px;border-bottom:1px solid #ccc;"><?=$wr_name?></td>
		</tr>

<?	}	?>

