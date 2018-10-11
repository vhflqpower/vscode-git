<?
	include_once("../common.php");

	$wr_id = $_GET['wr_id'];

	$bo_table = 'info';

	if($wr_id){

			$sql = "SELECT * FROM psj_board WHERE  wr_id = '$wr_id'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);

		$oper = 'edit';
	}else{

		$oper = 'add';
		$row[bo_skin] = 'basic';
	}


	 $ROOT_DIR = $_SERVER['DOCUMENT_ROOT'];  //jquery.syaku.file.v1.0.2


	include_once("./head.php");
?>


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
	<?
		include_once("./nav.php");
	?>
		<!-- <script src="../ckeditor_4.5/ckeditor.js"></script> -->
 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">정보 등록</h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./board_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="wr_id" value="<?=$row['wr_id']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled">
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered"><!--  table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>


					<tr>
					<th>구분</th>
					<td>
					<select class="selectpicker cat1" name="cat1" id="cat1">
						<option value="">선택하세요</option>			
					<?
						$arr_info_gubun =  select_info_gubun('100000');
						foreach($arr_info_gubun as $key => $val){
					?> 
					  <option value="<?=$key?>" <?if($key==$row['wr_cat1'])echo"selected"?>><?=$val?></option>
					  <? } ?>
					</select>
					</td>
					</tr>

					<tr>
					<th>제목</th>
					<td><input type="text" name="wr_subject" value="<?=$row['wr_subject']?>" class="form-control"/></td>
					</tr>
					<tr>
					<td colspan="2">

					  <div class="form-group" style="height:100%">
						<!-- <label for="wr_content">Example textarea</label> -->
						<textarea id="wr_content" name="wr_content" ><?=$row['wr_content']?></textarea>		  
					 </div>


					</td>
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

					</form>

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




				</tbody>
			</table>

			<div style="float:left">
			<?if($row['wr_id']){ ?>
						<button type="button" class="btn btn-danger btn-sm" onclick="del()">
						  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
						</button>
			<? } ?>			
				
			</div>

			<div style="float:right">

						<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./board_list.php?part=info'">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
						</button>
						
						<button type="submit" class="btn btn-primary btn-sm" >
						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
						</button>
			</div>

			</form>

		<div style="height:60px;"></div>

         </div> 

		  <!-- table-responsive -->
       
			 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->



   </div>  <!-- container-fluid -->


<?
	include_once("./footer.php");
?>

		<script type="tex/javascript">
		// wr_content  textarea 를 ck에디터로 변환 해줌
			window.onload=function(){
			CKEDITOR.replace('wr_content');
			CKEDITOR.instances.wr_content.getData();
		
		
		}

	function saveSubmit(){


		//alert(f)


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


<?
	include_once("./tail.php");
?>
