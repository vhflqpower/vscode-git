


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

				<table class="table table-striped table-bordered "><!-- table-hover -->
				<caption><h3><?=$view['wr_subject']?></h3></caption>
				<!-- <thead>
					<tr>
						<th>NO</th>
						<th>제목</th>

					</tr>
				</thead> -->
				<tbody>

					<tr>
						<td><?=$view['wr_subject']?></td>

					</tr>
					<tr>
					
						<td>
						<div style="min-height:350px;"><?=$view['wr_content']?></div></td>

					</tr>      

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
			<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
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
