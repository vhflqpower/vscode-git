<?
include_once("./_common.php");


	$search_keyword = $_GET['search_keyword'];
	$page = $_GET['page'];

//	print_r($_GET);

	$where = '';

	if($search_keyword){ 
		$where .= " and wr_subject LIKE '%$search_keyword%'";
	}

	// 데이터카운트
	$sql = "SELECT COUNT(*) AS cnt FROM psj_board WHERE 1=1". $where;
	$row = sql_fetch($sql);
	$total_count = $row[cnt];


//	echo $sql;

	// 페이징
	$rows = 10;
	$total_page  = ceil($total_count / $rows);
	if( !$page ) $page = 1;
	$start_cnt = ($page - 1) * $rows;
	$start_num = $total_count - (($page - 1) * $rows );

	// 마지막 중지
	if( $page > $total_page) exit;

//
	$sql_r = "SELECT *  FROM psj_board WHERE 1=1 ".$where." ORDER BY wr_id DESC LIMIT  $start_cnt, $rows";

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
	                  <td style="padding:6px;border-bottom:1px solid #ccc;"><a  href="./notice_view.php?wr_id=<?=$row['wr_id']?>&page=<?=$page?>" data-rel="external" data-transition="slide"><?=$row['wr_subject']?></a></td>
	                  <td style="padding:6px;border-bottom:1px solid #ccc;"><?=$row['wr_name']?></td>
	                </tr>

<?	}	?>

<script>
	setMoreString( "<?=( $start_cnt + $cnt )?>", "<?=$total_count?>");
</script>