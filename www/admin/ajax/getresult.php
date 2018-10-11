<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include_once("./_common.php");


	require_once("./pagination.class.php");

	$perPage = new PerPage();
    $arr_gubun =  select_gubun(); // 자료구분
	$arr_project =  select_project(); // 자료구분

	$rowcnt = sql_query("SELECT count(*) as cnt from psj_board_file  where 1=1".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);



	$sql = "SELECT * from psj_board_file where 1=1 ".$WHERE;
	//$result = sql_query($sql);
	$paginationlink = "./ajax/getresult.php?page=";


	$total_count =$cntsql[cnt];

	$rows = 15;
	if (!$page) $page = 1;
	$total_page  = ceil($total_count / $rows);  
	$start = ($page - 1) * $rows;



	if($start < 0) $start = 0;

	$query =  $sql . " limit " . $start . "," . $rows;


	$result = sql_query($query);

	if(empty($_GET["rowcount"])) {

	}

	$perpageresult = $perPage->perpage($total_page, $paginationlink);
	$output = '';




		$s = 0;
		while($row=sql_fetch_array($result)){
		$wdate = explode(" ",$row[wr_datetime]);
		$page_seq = $total_count - ($page - 1) * 45 - $s;


		$seq = $row['seq'];
		$wr_id = $row['wr_id'];
		$pj_id = $row['pj_id'];
		$bo_subject = $row['bf_source'];
		$bo_table = $row['bo_table'];
		

	echo "<tr>";
	echo "<td><input type='checkbox' id='chk_seq' name='chk_seq' value='".$seq."'></td>";
	echo "<td ><div align=center><font color=blue><a>".$seq."</a></div></td>";
	echo "<td>".$wr_id."</td>";
	echo "<td>".$arr_gubun [$bo_table]."</td>";
	echo "<td id=item_".$row['bo_table'].">
			<span style='color:#0000FF'>[<?=$arr_project [$pj_id]?>]</span>
			".$bo_subject."
			<button type='button' class='btn btn-default btn-xs'onclick='location.href='./download.php?bo_table=".$bo_table."&bf_file=".$row[bf_file]."&bf_source=".$row[bf_source]."&seq=".$row[seq]."''><spanclass='glyphicon glyphicon-floppy-disk' aria-hidden='true'></span> Down</button>
			".getFileSize($row['bf_filesize'])."
		</td>";
	echo "<td>".$row['mb_name']."</td>";
	echo "<td>".$row['bf_datetime']."</td>";
	echo "<td>
			 <button type='button' class='btn btn-default btn-sm'  data-toggle='modal' data-target='#myModal'  onclick='popEdit('".$seq."')' >
			<span class='glyphicon glyphicon-pencil' aria-hidden='true' ></span>수정</button>			
		</td>";
	echo "</tr>";
		 
		$s++;	 
	}





	echo "<div style='float:left;'>

			<button type='button' class='btn btn-danger btn-sm' onclick='select_delete()'>
			  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>선택삭제
			</button>

			<button type='button' class='btn btn-primary btn-sm'  data-toggle='modal' data-target='#myModal'  id='write_btn'>
			  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>등록하기
			</button>
		</div>";
	echo "<div stlye='float:right;'></div>";


			
		if(!empty($perpageresult)) {

		$output .= "<nav align='center'>";
		$output .= $perpageresult;
		$output .= "</nav>";

		}



print $output;

?>
