

		<!-- CKEditor4 -->
		<script src="./ckeditor/ckeditor.js"></script>
		<script src="./ckeditor/config.js"></script>
<script>
	  $(function(){

			$('.input-group.date').datepicker({

				calendarWeeks: false,

				todayHighlight: true,

				autoclose: true,

				format: "yyyymmdd",

				language: "kr"

			});

		});
</script>
	<div class="page-header">
        <h3>스케쥴</h3>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>

		<?

		if($_GET['oper']){
			$oper = $_GET['oper'];
		}else{
			$oper = "add";
		}

			$wdate = ($_GET['wdate'])?$_GET['wdate']:$write['wr_1'];


		?>
          <!-- <h3 class="sub-header">Section title</h3> -->
           <div class="table-responsive">

				<form name="frm" method="post" action="./write_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
				<input type="hidden" name="wr_id" value="<?=$write['wr_id']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>"/>
				<input type="hidden" name="w" value="<?=$w?>">
				<table class="table table-striped table-bordered "><!-- table-hover -->
				<col width="15%">
				<col width="">

				<tbody>
				<? if($board['bo_use_category']){ ?>
					<th>구분</th>
						<td><select name="ca_name" class="form-control" style="width:200px">
						<?=get_category_option($bo_table,'선택',$write['ca_name']);?>
						</select>
						<? } ?>
					
					<tr>
						<th>옵션</th>
						<td><input type="checkbox" name="is_notice" id="is_notice" value="1" <?=$notice_checked?>/>공지
							<!-- <input type="checkbox" name="wr_scrit" id="wr_scrit" value="1" />공지 -->
						</td>
					</tr>
					<tr>					
					<tr>
						<th>제목</th>
						<td><input type="text" name="wr_subject" value="<?=$write['wr_subject']?>" class="form-control" /></td>
					</tr>
					<?if($oper=='add'){?>

 					<tr>
						<th>작성자</th>
						<td><input type='text' name='wr_name' value='<?=$member['mb_name']?>' class='form-control' READONLY/></td>
					</tr>


					<?}else{?>

 					<tr>
						<th>작성자</th>
						<td><input type='text' name='wr_name' value='<?=$write['wr_name']?>' class='form-control' READONLY /></td>
					</tr>
					<?}?>
					<tr>
					<th>DATE</th>
					<td>
					<div class="input-group date" style="width:200px;">
						<input type="text" name="wr_1"  value="<?=$wdate?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					 </div></td>
					</tr>
					<tr>
     
						<td colspan="2"><textarea id="wr_content" name="wr_content"  rows="10" cols="80"><?=$write['wr_content']?></textarea>
						
						<script type="text/javascript">
							CKEDITOR.replace( 'wr_content',{
							customConfig : './cheditor/config.js',
							width: '100%',
							height: 250
							});
						</script>
						
						</td>

					</tr> 
				
					<tr>	
					<? if($board['bo_upload_count'] > 0){ ?>

							<th>첨부</th>
							<td>
							<? 
							for($i=0; $i< $board['bo_upload_count']; $i++){ 
							
							$data = sql_fetch(" select bf_file,bf_source from `psj_board_file` where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");

							?>
							<input type="file" name="bf_file[]" value="" class="form-control" style="width:300px;"/>
							<? if($data['bf_file']){ ?><input type="checkbox" name="bf_file_del[<?=$i?>]" value="1"><font color=red>삭제</font><?=$data['bf_source'];?>
								<? }
							} ?>
							</td>
							</tr>
					<? } ?>

				</tbody>
			</table>


		<div style="float:right;">
			<button type="submit" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>취소
			</button>
			</form>
		</div>



          </div>



        </div><!--/.col-xs-12.col-sm-9-->




