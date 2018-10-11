

				<!-- json & xml parser -->
		<script type="text/javascript" language="javascript" src="./multiuploader/common/json2.js"></script>
		<script type="text/javascript" language="javascript" src="./multiuploader/common/xml2json.js"></script>
		<!-- json & xml parser -->

		<!-- jQuery -->
		<script type="text/javascript" language="javascript" src="./multiuploader/common/jquery-2.0.2.min.js"></script>
		<!-- jQuery -->

		<!-- SWFUpload -->
		<script type="text/javascript" src="./multiuploader/SWFUpload/swfupload.js"></script>
		<script type="text/javascript" src="./multiuploader/SWFUpload/swfupload.queue.js"></script>
		<!-- SWFUpload -->

		<!-- Sayku Library -->
		<link rel="stylesheet" type="text/css" charset="UTF-8" media="all" href="./multiuploader/syaku.file.css" />
		<script type="text/javascript" src="./multiuploader/syaku.file.js"></script>
		<script type="text/javascript" src="./multiuploader/syaku.file.handlers.js"></script>
		<!-- Sayku Library -->

		<!-- Sayku Library -->
		<link rel="stylesheet" type="text/css" charset="UTF-8" media="all" href="./multiuploader/syaku.file.css" />
		<script type="text/javascript" src="./multiuploader/syaku.file.js"></script>
		<script type="text/javascript" src="./multiuploader/syaku.file.handlers.js"></script>
		<!-- Sayku Library -->



 		<script src="../ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="./multiuploader/syaku.ckeditor.handlers.js"></script>
		<script>
		// ckeditor  초기설정

		var ckeditor_config = {
		  resize_enabled : false,
		  enterMode : CKEDITOR.ENTER_P , 
		  shiftEnterMode : CKEDITOR.ENTER_BR , 
		  toolbarCanCollapse : true , 
		  removePlugins : "elementspath",

		  toolbar : [
			[ 'Source', '-' , 'NewPage', 'Preview' ],
			[ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo' ],
			[ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'],
			[ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
		//	'/',
			[ 'Styles', 'Format', 'Font', 'FontSize' ],
			[ 'TextColor', 'BGColor' ],
			[ 'Image', 'Flash', 'Table' , 'SpecialChar' , 'Link', 'Unlink']
			
		  ] 

		};

		var MEIeditor = [ ];
		var objEditor;
		jQuery(function() {
		  MEIeditor[1] = CKEDITOR.replace( "wr_content" , ckeditor_config );
		  objEditor = CKEDITOR.instances.wr_content;

		  console.log(objEditor);
		});

		function save() {
		  MEIeditor[1].updateElement();
		  alert( MEIeditor[1].getData() );
		  //jQuery('#form').submit();
		}

		</script>

		<script>
		var swfu;
		</script>


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


				<form name="frm" method="post" action="./write_update.php" onSubmit="return saveSubmit(this)" enctype="multipart/form-data" >
				<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
				<input type="hidden" name="wr_id" value="<?=$write['wr_id']?>" />
				<input type="hidden" name="w" value="<?=$w?>" />
				<table class="table table-striped table-bordered "><!-- table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<!-- <thead>
					<tr>
						<th>NO</th>
						<th>제목</th>

					</tr>
				</thead> -->
				<tbody>
				<? if($board['bo_use_category']){ ?>
					<th>구분</th>
						<td><select name="ca_name" class="form-control" style="width:200px">
						<?=get_category_option($bo_table,'선택',$write['wr_cat1']);?>
						</select>
						<? } ?>
					
					<!-- <tr>
					<th>옵션</th>
					<td><input type="checkbox" name="is_notice" id="is_notice" value="1" <?=$notice_checked?>/>공지
					</td>
					</tr> -->
					<tr>					
					<tr>
					<th>제목</th>
					<td><input type="text" name="wr_subject" value="<?=$write['wr_subject']?>" class="form-control" /></td>
					</tr>
					<tr>
					<td colspan="2"><?echo $editor_html;?>
					
					<!-- <textarea id="wr_content" name="wr_content"  rows="10" cols="80"><?=$write['wr_content']?></textarea> --></td>

					</tr> 

					<tr>
					<th>이미지</th>
					<td>

						<div class='file_upload' style='padding-bottom:5px;'>
						  <div class='file_head'>
							<span id='swfu_button'></span>

							<button type="button" onclick="jQuery.syakuFileUpload.deleteSwfupload(swfu,objEditor);">삭제</button>
							<button type="button" onclick="jQuery.syakuFileUpload.editor_file_input(swfu,objEditor);">선택삽입</button>
							<button type="button" onclick="jQuery.syakuFileUpload.editor_file_remove(swfu,objEditor);">선택모두제거</button>
						  </div>
						  <div class='file_content'>
							<div class='file_preview' id='file_preview'></div>
							<div class='file_field'>
							  <select class='file_view' id='file' name='file' multiple='multiple' onclick='jQuery.syakuFileUpload.preview(swfu);'>
							 <?
							 $tmp_query = sql_query("select bo_table,wr_id,bf_no,bf_source,bf_file,bf_filesize from `psj_board_img` where bo_table = '$bo_table' && wr_id = '$wr_id' order by bf_no asc");
								while($tmp_row = sql_fetch_array($tmp_query)){
							 ?>
							<option value="{ file_orl : '<?=$tmp_row[bf_file]?>&bo_table=<?=$tmp_row[bo_table]?>&wr_id=<?=$tmp_row[wr_id]?>&bf_no=<?=$tmp_row[bf_no]?>' , file : '<?=$tmp_row[bf_source]?>', re_file : '<?=$tmp_row[bf_file]?>', folder : '/data/board/img/<?=$tmp_row[bo_table]?>/' , file_size : '<?=$tmp_row[bf_filesize]?>' , extension : 'null' , type : 'application/octet-stream' }" selected="selected"><?=$tmp_row[bf_source]?>(<?echo number_format($tmp_row[bf_filesize])?>)</option>

							 <!-- <option value="<?=$tmp_row[bf_file]?>"><?=$tmp_row[bf_source]?></option> -->
							<? } ?>	
							  <!--
							  <option value="{ 
							  file_orl : '파일 번호' , 
							  file : '파일명' , 
							  re_file : '변경된 파일 명' , 
							  folder : '폴더경로' , 
							  file_size : '파일사이즈' ,
							  extension : '파일 확장자명' , 
							  type : '파일 형식' 
							  }">파일명 (파일용량)</option>
							  -->

							  </select>
							</div>
							<div class='file_text'>
							  <p>총 용량 : <span id='file_size_text'>0 KB</span> / 무제한</p>
							  <p>개당 용량 : 무제한</p>
							  <p>파일 형식 : *.jpg;*.png;*.gif;</p>
							  <p>파일 제한 수 : 무제한</p>
							</div>
							<div class="clear"></div>
						  </div>
						  <div id='swfu_progress'></div>
						</div>

						<!-- <div>
						<button type="button" onclick="save();">전송하기</button>
						</div> -->

					

						<script>

						  // SWFUpload
						  swfu = jQuery.syakuFileUpload.swfupload({
							ele_file : '#file',
							ele_file_orl : '#file_orl',
							ele_file_size : '#file_size_text',
							ele_preview : '#file_preview',
							file_size_limit : 0 ,
							file_types : '*.jpg;*.png;*.gif;',
							file_types_description : '사용자 파일',
							file_upload_multi : true,
							file_upload_limit : 0, // 파일 첨부수 (0 = 무제한)
							file_upload_unlimited : true, // file_upload_limit 가 0인 경우 true , 아닌 경우 false

							post_params: { 
							 bo_table : '<?=$bo_table?>',
							 wr_id : '<?=$wr_id?>'
							},

						//	post_params: { // 그외 전송될 파라메터
							  /*
							  file_orl : '',
							  target_orl : '',
							  mid : '',
							  sid : '',
							  seq : '',
							  member_orl : ''
							  */
						//	},


							button_placeholder_id : 'swfu_button'
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





					<tr>
					<th>소스구분</th>
					<td><select name="wr_source_type" class="form-control" style="width:200px">
						<option value="">--선택--</option>
						<option value="css" <?if($write['wr_source_type']=='css')echo "selected"?>>CSS</option>
						<option value="javascript" <?if($write['wr_source_type']=='javascript')echo "selected"?>>javascript</option>
						<option value="php" <?if($write['wr_source_type']=='php')echo "selected"?>>PHP</option>
						<option value="python" <?if($write['wr_source_type']=='python')echo "selected"?>>python</option>
						<option value="java" <?if($write['wr_source_type']=='java')echo "selected"?>>JAVA</option>
						</select>

						</td>
					</tr>
					<tr>
						<td colspan="2"><textarea class="form-control" id="wr_source" name="wr_source"  rows="6" cols="80"><?=$write['wr_source']?></textarea></td>

					</tr> 






				</tbody>
			</table>


		<div style="float:right;">
			<!-- <button type="submit" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button> -->
			 <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit btn" class="btn btn-primary btn-sm">
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>취소
			</button>
			</form>
		</div>



          </div>



        </div><!--/.col-xs-12.col-sm-9-->


	<script type="tex/javascript">
		// wr_content  textarea 를 ck에디터로 변환 해줌
			window.onload=function(){
			CKEDITOR.replace('wr_content');
			CKEDITOR.instances.wr_content.getData();
		
		
		}

	function saveSubmit(f){


	  alert(f)


	}


		</script>

<script type="text/javascript">




$(document).ready(function() {

		CKEDITOR.on('instanceLoaded', function(e) {e.editor.resize('100%', 360)} );

});

</script>
<?
  $app_root = $_SERVER['DOCUMENT_ROOT'];
//  임시파일삭제 방법1
$timer[now] = date("Y-m-d"); 
 $sql3 = " select wr_id,bf_datetime,bf_file from psj_board_img where wr_id > '100000000' and DATE_FORMAT(bf_datetime, '%Y-%m-%d') <= '$timer[now]'"; 


    $result3 = sql_query($sql3); 
    while ($row3 = sql_fetch_array($result3)) 
    { 

		@unlink($app_root."/data/board/img/$bo_table/$row3[bf_file]");
	 sql_query(" delete from psj_board_img where bf_file='$row3[bf_file]'"); 
    } 
?>

