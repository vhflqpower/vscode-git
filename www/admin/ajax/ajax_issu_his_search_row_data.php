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
	$mb_id = $_GET['mb_id'];	
	$sdate = str_replace("/","-",$_GET['sdate']);	
	$edate = str_replace("/","-",$_GET['edate']);	
	
	$WHERE = " 1=1";

	if($_GET['search_value']){ 
		$WHERE .= " and a.subject LIKE '%$search_value%' and a.subject !=''";   //  OR b.is_subject LIKE '%$search_value%'
		}


	if($_GET['cat1']){ 
		$WHERE .= " and wr_cat1 = '$cat1'"; 
		}


	if($_GET['mb_id']){ 
		$WHERE .= " and b.mb_id = '$mb_id'"; 
		}

	if($_GET['sdate'] && $_GET['edate']){ 
		$WHERE .= " and a.regdate between '$sdate' and '$edate'"; 
		}


	$page = $_GET['page'];

	$rowcnt = sql_query("SELECT count(*) as cnt from psj_issu_log a left join psj_issu b on a.is_id=b.is_id  where ".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);

	$sql = "SELECT a.*,b.is_subject,b.wr_name,
			(select p.pj_subject from psj_project p where p.pj_id=b.pj_id) as pj_name
	        from 
			psj_issu_log a  left join psj_issu b on a.is_id=b.is_id 
	        where ".$WHERE."
			 ORDER BY a.regdate DESC";

		//	 echo $sql;

	$paginationlink = "/admin/ajax/ajax_issu_his_search_row_data.php?part=issu&page=";				

	$total_count =$cntsql[cnt];

	$rows = 20;
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
	<col width="10%">
	<col width="10%">
	<col width="50%">
	<col width="10%">
	<col width="10%">
	<col width="10%">
              <thead>
                <tr>
                  <th>NO[<?=$total_count?>]</th>
                  <th>프로젝트</th>
                  <th>제목</th>
                  <th>작성자</th>
                  <th>작성일</th>
                  <th>조회</th>
                </tr>
              </thead>
	  <tbody >
<?

		while($row=sql_fetch_array($result)){

		$is_id = $row['is_id'];
		$pj_name = $row['pj_name'];
		$wr_name = $row['wr_name'];
		$subject = $row['subject'];
		$is_subject = $row['is_subject'];
		//$regdate  $row['regdate'];
		//$str = url_auto_link($str);

?>
	
		 <tr>
			 <td><?=$wr_id?></td>
			 <td ><!-- <div align=center> --><font color=blue><?=$pj_name?></a><!-- </div> --></td>
			 <td id=item_<?=$row['wr_id']?>>
			<!-- <?=$row['is_subject']?><br> -->
			<a href="./issu_view.php?is_id=<?=$is_id?>&part=issu&"><?=$is_subject?></a><br>
			 <a href="#1" onclick="issu_log_pop('<?=$row[idx]?>')" style='color:#000;'><?=$subject?></a>
			 </td>
			 <td ><?=$row['wr_name']?></td>
			 <td ><a href="./board_write.php?wr_id=<?=$wr_id?>&part=<?=$part?>&bo_table=<?=$bo_table?>"><?=$row['regdate']?></a></td>
			 <td><?=$row['wr_hit']?></td>
		 </tr>
		
<?
		
}
		if($total_count < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
		echo " </tbody></table>";

		echo "<button type='button' class='btn btn-primary btn-sm' onclick=\"location.href='./issu_list.php?part=issu'\">
				  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>이슈메인
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

