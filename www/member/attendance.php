	<?
	$app = "../"; // common.php 의 상대 경로
	include_once($app ."/common.php");


	$aa = "SELECT count(*) FROM `g4_schedule_add` WHERE mb_id = '$member[mb_id]'";
	$schedule_check = sql_query("SELECT count(mb_id) as s_check FROM `g4_schedule_add` WHERE mb_id = '$member[mb_id]'");
	$schedule_row = sql_fetch_array($schedule_check);


	include_once(G5_PATH."/theme/offcanvas/head.php");


    ?>

	<?
		include_once("./nav.php");


	?>




 <div class="row row-offcanvas row-offcanvas-right">

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">출석내역</h2>
		  <hr>

          <div class="col-xs-12 col-sm-9">
			<form name="frm" method="post" action="../admin/member_update.php" enctype="multipart/form-data" >
			<!-- table-hover -->
				
			<table class="table table-striped table-bordered" ><!-- table-hover" -->
					 <!--<caption>테이블 설명</caption> -->
					<thead>
						<tr style="background-color:#ccc;color:#000">
							<th>NO</th>
							<th>출석날짜</th>
							<th>작성자</th>
							<th>작성일</th>

						</tr>
					</thead>
					<tbody>

	
					<?
				$att_cnt = "select count(mb_id) as att_cnt from `g4_schedule_add` where mb_id = '$member[mb_id]'";
				$att_res = sql_query($att_cnt);
				$att_row = sql_fetch_array($att_res);
				

				$sql = "select * from  `g4_schedule_add` where mb_id = '$member[mb_id]' order by regdate DESC limit 15";
				$res = sql_query($sql);
				while($row = sql_fetch_array($res)){


					?>
							<tr>
							<td><?=$att_row[att_cnt]--?></td>
							<td><a href="./view.php?bo_table=<?=$bo_table?>&wr_id=<?=$list[$i][wr_id]?>"><?=$list[$i][subject]?></a></td>
							<td><?=$row['mb_name']?></td>
							<td><?=$row['regdate']?></td>

						</tr>

			 <?
											
					$num++;	 } 

					if($num < 1){ echo "<tr><td colspan=5 style='text-align:center'>NO DATA</td></tr>"; }


					$write_pages = get_paging($page_count, $page, $total_page, "./list.php?bo_table=$bo_table".$qstr."&page=");


			 ?>  

						</tr>
					</tbody>
				</table>








		<div style="height:70px;"></div>


         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->



		<? 	include_once(G5_PATH."/theme/offcanvas/sidebar_mypage.php");?>


      </div>   <!-- row -->




	<!-- side-bar
	include_once("$app[path]/include/side_navi_board_bar.php");  -->


<?

	include_once(G5_PATH."/theme/offcanvas/tail.php");

?>