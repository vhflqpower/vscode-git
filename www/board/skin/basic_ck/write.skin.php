

		<!-- CKEditor4 -->
		<script src="./ckeditor/ckeditor.js"></script>
		<script src="./ckeditor/config.js"></script>
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

				<form name="frm" method="post" action="./write_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
				<input type="hidden" name="wr_id" value="<?=$write['wr_id']?>" />
				<input type="hidden" name="w" value="<?=$w;?>">



				<table class="table table-striped table-bordered "><!-- table-hover -->
				<caption>테이블 설명</caption>
				<col width="15%">
				<col width="">

				<tbody>
				<? if($board['bo_use_category']){ ?>
					<th>구분</th>
						<td><select name="ca_name" class="form-control" style="width:200px">
						<?=get_category_option($bo_table,'선택',$write['ca_name']);?>
						</select></tr>
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


					<? if ($is_name) { ?>
					<tr>
						<th><label for="wr_name">이름<strong class="sound_only">필수</strong></label></th>
						<td><input type="text" name="wr_name" value="<? echo $name ?>" id="wr_name" required class="frm_input required" size="10" maxlength="20"></td>
					</tr>
					<? } ?>

				<? if ($is_password) { ?>
				<tr>
					<th scope="row"><label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label></th>
					<td><input type="password" name="wr_password" id="wr_password" <? echo $password_required ?> class="frm_input <? echo $password_required ?>" maxlength="20"></td>
				</tr>
				<? } ?>

				<? if ($is_email) { ?>
				<tr>
					<th scope="row"><label for="wr_email">이메일</label></th>
					<td><input type="text" name="wr_email" value="<? echo $email ?>" id="wr_email" class="frm_input email" size="50" maxlength="100"></td>
				</tr>
				<? } ?>


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
					<? if($board['bo_upload_count'] > 0){ ?>			
					<tr>	
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


		<div style="float:right">
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




