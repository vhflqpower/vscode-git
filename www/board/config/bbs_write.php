<?
	include_once("./_common.php");



if($bo_table){

		$sql = "SELECT * FROM psj_board_config WHERE  bo_table = '$bo_table'";
		$result = mysql_query($sql);
		$row = mysql_fetch_array($result);


	$oper = 'edit';
}else{


	$oper = 'add';

    $row[bo_skin] = 'basic';
}

	include_once(G5_PATH."/head.php");
?>



	<div class="page-header">
        <h2><?=$row['wr_subject']?></h2>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">



        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>


          <!-- <h3 class="sub-header">Section title</h3> -->
           <div class="table-responsive">

			<script type="text/javascript" src="<?=$app[path]?>/ckeditor/ckeditor.js"></script>
			<form name="frm" method="post" action="./bbs_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="bo_table" value="<?=$row['bo_table']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
			<!-- table-hover -->
				
				<table class="table table-striped table-bordered ">
				<caption>테이블 설명</caption>
				<col width="15%">
				<col width="">
				<tbody>

				<? if($row['bo_table']){ ?>
					<th>TABLE</th>
					<td><input type="text" name="bo_table" value="<?=$row['bo_table']?>" class="form-control" style="width:200px;" READONLY/></td>
					</tr>
				<? }else{ ?>
					<th>TABLE</th>
					<td><input type="text" name="bo_table" value="<?=$row['bo_table']?>" class="form-control" style="width:200px;" /></td>
					</tr>
				<? } ?>

					<th>제목</th>
					<td><input type="text" name="bo_subject" value="<?=$row['bo_subject']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>
					<th>스킨</th>
					<td>
					<select name=bo_skin required itemname="스킨 디렉토리" class="form-control" style="width:150px">
					<?
					 $arr = get_skin_dir();

					for ($i=0; $i<count($arr); $i++) {
						echo "<option value='$arr[$i]'>$arr[$i]</option>\n";
					}
					?></select> 
					<script type="text/javascript">document.frm.bo_skin.value="<?=$row[bo_skin]?>";</script>
					</td>
					</tr>

					<tr>
					<th>카테고리</th>
					<td>
						<input type="text" name="bo_category_list" value="<?=$row['bo_category_list']?>" class="form-control" style="width:80%;" />
					</td>
					</tr>
					

					<tr>
					<th>카테고리타입</th>
					<td>
					<select name='bo_cate_type' required itemname="카테고리타입" class="form-control" style="width:150px">
					<option value="none" <?if($row['bo_cate_type']=='none')echo"selected"?>>사용안함</option>
					<option value="selectbox" <?if($row['bo_cate_type']=='selectbox')echo"selected"?>>셀렉트박스</option>
					<option value="inline" <?if($row['bo_cate_type']=='inline')echo"selected"?>>인라인</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>멀티업로더사용</th>
					<td>
					<select name='bo_use_multiupload' required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="N" <?if($row['bo_subject']=='N')echo"selected"?>>미사용</option>
					<option value="Y" <?if($row['bo_subject']=='Y')echo"selected"?>>사용</option>
					</select> 
					</td>
					</tr>


					<tr>
					<th>글목록권한</th>
					<td>
					<select name='bo_list_level' id="bo_list_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['bo_list_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['bo_list_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['bo_list_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['bo_list_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['bo_list_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['bo_list_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['bo_list_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['bo_list_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['bo_list_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['bo_list_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>글보기권한</th>
					<td>
					<select name='bo_read_level' id="bo_read_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['bo_read_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['bo_read_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['bo_read_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['bo_read_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['bo_read_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['bo_read_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['bo_read_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['bo_read_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['bo_read_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['bo_read_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>글쓰기권한</th>
					<td>
					<select name='bo_write_level' id="bo_write_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['bo_write_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['bo_write_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['bo_write_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['bo_write_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['bo_write_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['bo_write_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['bo_write_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['bo_write_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['bo_write_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['bo_write_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>
					<tr>
					<th>답변권한</th>
					<td>
					<select name='bo_comment_level' id="bo_comment_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['bo_comment_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['bo_comment_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['bo_comment_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['bo_comment_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['bo_comment_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['bo_comment_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['bo_comment_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['bo_comment_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['bo_comment_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['bo_comment_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>

				</tbody>
			</table>
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./bbs_list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>목 록
			</button>
			
			<button type="submit" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>
			<button type="button" class="btn btn-danger btn-sm" onclick="del()">
			  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
			</button>

			</form>

          </div>

        </div><!--/.col-xs-12.col-sm-9-->



			<form name="fdel" method="post" action="./write_update.php">
			<input type="hidden" name="bo_table" value="<?=$$row['bo_table']?>" />
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



<?	include_once(G5_PATH."/include/side_navi_board_bar.php"); ?>


<? 	include_once(G5_PATH."/tail.php"); ?>

