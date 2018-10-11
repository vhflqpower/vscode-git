<?
	include_once("./_common.php");



	$write_table = 'psj_board_config';


	$where = '';

	$sql = " select count(*) as cnt from $write_table where 1=1";
	$row = sql_fetch($sql);
	$total_count = $row[cnt];

	$page_count =10;
	$rows = 15;
	$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
	if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
	$from_record = ($page - 1) * $rows; // 시작 열을 구함



	include_once(G5_PATH."/head.php");
?>



	<div class="page-header">
            <h3><?=$board['bo_subject']?></h3>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">



        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>


          <!-- <h3 class="sub-header">Section title</h3> -->
           <div class="table-responsive">



			<table class="table table-striped table-bordered" ><!-- table-hover" -->
					 <!--<caption>테이블 설명</caption> -->
					<thead>
						<tr style="background-color:#999;color:#000">
							<th>NO</th>
							<th>게시판명</th>
							<th>스킨명</th>
							<th>작성일</th>
							<th>조회</th>
						</tr>
					</thead>
					<tbody>
			<?
					if(!$bo_table)$bo_table='data_room';else $bo_table=$_GET['bo_table'];

					$where .= '';
					if($ca_name)$where =" and ca_name = '$ca_name'";

					// order by wr_id desc limit $from_record, $rows

					$num =0;
					$sql = "SELECT * FROM $write_table WHERE 1=1";
					$result = mysql_query($sql);
					while($row = mysql_fetch_array($result)){

		
			//1=1 $WHERE ".$sql_order." limit $from_record, $rows 
			
			?>
						<tr>
							<td><?=$row['wr_id']?></td>
							<td><a href="./bbs_write.php?bo_table=<?=$row['bo_table']?>&wr_id=<?=$row[wr_id]?>"><?=$row['bo_subject']?></a></td>
							<td><?=$row['bo_skin']?></td>
							<td><?=$row['wr_datetime']?></td>
							<td><?=$row['wr_hit']?></td>
						</tr>

			 <?
						
					
					$num++;	 } 

					if($num < 1){ echo "<tr><td colspan=5 style='text-align:center'>NO DATA</td></tr>"; }


				//	$write_pages = get_paging($page_count, $page, $total_page, "./list.php?bo_table=$bo_table".$qstr."&page=");


			 ?> 
						</tr>
					</tbody>
				</table>

		<div style="float:right;">
			 <ul class="pagination"> 
			<? if ($prev_part_href) { echo "<li><a href='$prev_part_href'>이전검색</a></li>"; } ?> 
			<? 
			// 기본으로 넘어오는 페이지를 아래와 같이 변환하여 다양하게 출력할 수 있습니다. 
			$write_pages = str_replace("이전", "<span class='glyphicon glyphicon-triangle-left' aria-hidden='true'></span>", $write_pages); 
			$write_pages = str_replace("다음", "<span class='glyphicon glyphicon-triangle-right' aria-hidden='true'></span>", $write_pages); 
			$write_pages = str_replace("처음", "<span class='glyphicon glyphicon-backward' aria-hidden='true'></span>", $write_pages); 
			$write_pages = str_replace("맨끝", "<span class='glyphicon glyphicon glyphicon-forward' aria-hidden='true'></span>", $write_pages); 
			?> 
			<?=$write_pages?> 
			<? if ($next_part_href) { echo "<li><a href='$next_part_href'>이후검색</a></li>"; } ?> 
			</ul>
		</div>

		<div style="float:left;">
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./bbs_write.php'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			</button>
          </div>

          </div>





        </div><!--/.col-xs-12.col-sm-9-->



<?	include_once(G5_PATH."/include/side_navi_board_bar.php"); ?>







<? 	include_once(G5_PATH."/tail.php"); ?>

