
      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron" style="background:url('../img/main002.jpg');height:300px;">
        <h3></h3>
        <p></p>
        <!-- <p>
          <a class="btn btn-lg btn-primary" href="../../components/#navbar" role="button">View navbar docs &raquo;</a>
        </p> -->
      </div>



	<div class="page-header">
            <h3><?=$board['bo_subject']?></h3>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>


         <h3 class="sub-header"><?=$view['wr_subject']?></h3>
           <div class="table-responsive">

				<table class="table table-striped table-bordered "><!-- table-hover -->
				<col width="20%">
				<col width="80%">
				<tbody>
					<tr>
					<th>첨부파일</th>
					<td>
	
						<?php
						if ($view['file']['count']) {
							$cnt = 0;
							for ($i=0; $i<count($view['file']); $i++) {
								if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
									$cnt++;
							}
						}
						 ?>
						<?php if($cnt) { ?>
						<!-- 첨부파일 시작 { -->
						<section id="bo_v_file">
							<!-- <h2>첨부파일</h2> -->
							<ul>
							<?php
							// 가변 파일
							for ($i=0; $i<count($view['file']); $i++) {
								if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
							 ?>
								<li>
									<a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
										<!-- <img src="<?php echo $board_skin_url ?>/images/icon_file.gif" alt="첨부"> -->
										<img src="./skin/<?=$board['bo_skin']?>/img/icon_file.gif" alt="첨부">
										<strong><?php echo $view['file'][$i]['source'] ?></strong>
										<?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
									</a>
									<span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
									<span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
								</li>
							<?php
								}
							}
							 ?>
							</ul>
						</section>
						<!-- } 첨부파일 끝 -->
						<?php } ?>				

					</td>
					</tr>

				
						<td colspan="2">
						<div style="min-height:350px;"><?=$view['wr_content']?></div></td>

					</tr>      


					<!-- <tr>
					<th >이전글</th><td><?=$row['wr_subject']?></td>
					</tr>
					<tr>
					<tr>
					<th >다음글</th><td><?=$row['wr_subject']?></td>
					</tr>
					<tr> -->

				</tbody>
			</table>

	<div style="float:left">
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>이전글
			</button>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>다음글
			</button>
	</div>

	<div style="float:right">
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&oper=edit'">
			  <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>수 정
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?w=r&bo_table=<?=$board[bo_table]?>&wr_id=<?=$wr_id?>'">
			  <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>답 변
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="del()">
			  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
			</button>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>글쓰기
			</button>
	</div>


          </div>

        </div><!--/.col-xs-12.col-sm-9-->

			<form name="fdel" method="post" action="./write_update.php">
			<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
			<input type="hidden" name="wr_id" value="<?=$row['wr_id']?>" />
			<input type="hidden" name="oper" value="del" />
			</form>



	 <script>
	 function del()
	{
		if (confirm('한번 삭제한 자료는 복구가 되지 않습니다. 정말로 삭제하시겠습니까?'))
		{

			document.fdel.submit();
			//$('#fdel').submit();
		}
	}
			
	 </script>
