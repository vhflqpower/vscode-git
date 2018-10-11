<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	require_once("./pagination.class.php");

	$perPage = new PerPage();


	$search_value = $_GET['search_value'];
	$cat1 = $_GET['cat1'];
	$cat2 = $_GET['cat2'];
	$bo_table = $_GET['bo_table'];
	$part = $_GET['part'];
	//print_r($_GET);


	$grade_name[3] = '상';
	$grade_name[2] = '중';
	$grade_name[1] = '하';

	$WHERE = "";

	if($_GET['search_value']){ 
		$WHERE .= " and wr_subject LIKE '%$search_value%'"; 
		}



	$page = $_GET['page'];
	$rowcnt = sql_query("SELECT count(*) as cnt from psj_plan  where  pn_end_yn ='Y'  and mb_id = '$member[mb_id]' ".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);

	$sql = "SELECT * from psj_plan where pn_end_yn ='Y'  and mb_id = '$member[mb_id]' ".$WHERE." ORDER BY pn_id DESC";
	$paginationlink = "/admin/ajax/ajax_myplan_row_data.php?bo_table=$bo_table&page=";				
	$total_count =$cntsql[cnt];

	$rows = 10;
	if (!$page) $page = 1;
	$total_page  = ceil($total_count / $rows);  
	$start = ($page - 1) * $rows;


	if($start < 0) $start = 0;

	$query =  $sql . " limit " . $start . "," . $rows;


	$result = sql_query($query);

	if(empty($_GET["rowcount"])) {

	}

		//echo $query;

	$perpageresult = $perPage->perpage($total_page, $paginationlink);
?>

	<table class="table table-striped">
	<col width="5%">
	<col width="50%">
	<col width="10%">
	<col width="15%">
	<col width="15%">
              <thead>
                <tr>
                  <th><input type="checkbox" name="check_all" id="check_all" onclick="checkFunction()"></th>
                  <th>제목</th>
                  <th>중요도</th>
                  <th>등록일</th>
                  <th>완료일</th>
                </tr>
              </thead>
	  <tbody >
<?

		while($row=sql_fetch_array($result)){

		$pn_subject = $row['pn_subject'];

		$grade = $row['pn_grade'];

?>
	
		 <tr>
			 <td><input type="checkbox" id="chk_mb_no" name="chk_mb_no" value="<?=$row['pn_id']?>"></td>
			 <td > <a href="#1" onclick="editPlan(<?=$row['pn_id']?>)"><?=$pn_subject?></a>
			 </td>
			 <td id=item_<?=$row['wr_id']?>>
			  <?=$grade_name[$grade]?>
			 </td>
			 <td ><?if($row['pn_regdate'] > 0)echo $row['pn_regdate'] ?></td>
			 <td ><?if($row['pn_endtime'] > 0)echo $row['pn_endtime'] ?></td>
		 </tr>
		
<?
		
}
		if($total_count < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
		echo " </tbody></table>";


		echo "<button type='button' class='btn btn-danger btn-sm' onclick=\"checkDel()\">
				  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>선택삭제
				</button>";

		if(!empty($perpageresult)) {
		$output .="<div align='center'>";
		$output .= "<nav>";
		$output .= $perpageresult;
		$output .= "</nav>";
		$output .= "</div>";
		}

print $output;
echo "<div style='height:70px;></div>";
?>

