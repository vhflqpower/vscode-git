


	<div class="page-header">
            <h3><?=$board['bo_subject']?></h3>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>


         <h3 class="sub-header"><?=$row['wr_subject']?></h3>
           <div class="table-responsive">

				<table class="table table-striped table-bordered "><!-- table-hover -->
				<col width="20%">
				<col width="80%">
				<tbody>

					<tr>
					<th >첨부</th><td><?=$row['wr_subject']?>[<?=$board['bo_upload_count']?>]</td>
					</tr>
					<tr>
					
						<td colspan="2">
						<div style="min-height:350px;"><?=$row['wr_content']?></div></td>

					</tr>      

					<? if($board['bo_upload_count'] > 0){ ?>
						<tr>
							<th>첨부</th>
							<td>
							<? 
							for($i=0; $i< $board['bo_upload_count']; $i++){ 
							
							$data = sql_fetch(" select bf_file,bf_source from `psj_board_file` where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");

							?>
							<? if($data['bf_file']){ ?><a href="./download.php?bo_table=<?=$bo_table?>&bf_file=<?=$data[bf_file]?>&bf_source=<?=$data[bf_source]?>"><?=$data['bf_source'];?></a><br>
								<? }
							} ?>

							</td>
							</tr>
					<? } ?>

					<tr>
					<th >이전글</th><td><?=$row['wr_subject']?></td>
					</tr>
					<tr>
					<tr>
					<th >다음글</th><td><?=$row['wr_subject']?></td>
					</tr>
					<tr>

				</tbody>
			</table>

			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&oper=edit'">
			  <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>수 정
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="del()">
			  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
			</button>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>글쓰기
			</button>



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
