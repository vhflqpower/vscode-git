


	<div class="page-header">
            <h3><?=$board['bo_subject']?></h3>
      </div> 

<!-- 출석체크 폼 -->
<form name="chk" method="post" action="../board/schedule_add_server.php">
<input type="hidden" name="mb_id" value="<?=$member['mb_id']?>">
<input type="hidden" name="mb_name" value="<?=$member['mb_name']?>">
<input type="hidden" name="wr_id" value="<?=$wr_id?>">
<input type="hidden" name="bo_table" value="<?=$board['bo_table']?>">
</form>


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
						<th>제목</th>
						<td><?=$view['wr_subject']?></td>
					</tr>
					<tr>
						<th>작성자</th>
						<td><?=$view['wr_name']?></td>
					</tr>
					<tr>
						<th>DATE</th>
						<td><?=$view['wr_1']?></td>
					</tr>
					<tr>
						<td colspan="2" style="height:150px;"><?=$view['wr_content']?></td>
					</tr>      
					<!-- <tr>
					<th >이전글</th><td></td>
					</tr>
					<tr>
					<tr>
					<th >다음글</th><td></td>
					</tr>
					<tr> -->

				</tbody>
			</table>


<hr>
			<button type="button" class="btn btn-default btn-sm" onclick="lfn_seq_confirm()">
			  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>출 석
			</button>
		<table width="100%" border="0"> 
			<tr> 
			<? 
			$query4 = " 
				SELECT mb_id,mb_name,regdate FROM `g4_schedule_add` where board_id ='$board[bo_table]' and board_seq = '$wr_id'";
			$result4 = sql_query($query4);

			$list_cols = 5; 
			for($i=1; $i<=($row4 = sql_fetch_array($result4)); $i++) { 

				//$img_title = str_cut($row4[mb_id], 20, '..');
			?>
			<td width="14%" height="24">
				<font color=blue><b><?=$row4['mb_name']?></b></font><br><?=$row4['regdate']?>
			</td> 
			<? if($i % $list_cols ==0 ) { 
			echo "</tr><tr>"; 
			} 
			?> 
			<?} 
			if (($cnt = ($i-1)%$list_cols) != 0) 
				for ($k=$cnt; $k<$list_cols; $k++) 
					echo " <td width='14%'>&nbsp;</td>\n"; 
			?> 
			</table>
			<hr>

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


			<!-- 게시글 삭제 폼 -->
			<form name="fdel" method="post" action="./board_del.php">
			<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
			<input type="hidden" name="wr_id" value="<?=$wr_id?>" />
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
		
			
//출석체크
	function lfn_seq_confirm() {
		if(confirm("출석 등록 하시겠습니까?")) {
			document.chk.submit();
		}
	}

</script>