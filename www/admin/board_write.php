<?
	include_once("../common.php");

	$wr_id = $_GET['wr_id'];
	$part = $_GET['part'];
	$bo_table = $_GET['bo_table'];

	if($wr_id){

			$sql = "SELECT * FROM psj_board WHERE  wr_id = '$wr_id'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);

		$oper = 'edit';

		
		$notice_array = explode(',', trim($board['bo_notice']));

		$is_notice = false;
		$notice_checked = '';
				// 답변 수정시 공지 체크 없음
				if ($row['wr_reply']) {
					$is_notice = false;
				} else {
					if (in_array((int)$wr_id, $notice_array)) {
						$notice_checked = 'checked';
					}
				}

	}else{

		$oper = 'add';
		$row[bo_skin] = 'basic';
	}

		$is_dhtml_editor = false;
		$is_dhtml_editor_use = false;
		$editor_content_js = '';

		$content = get_text(html_purifier($row['wr_content']), 0);
		$editor_html = editor_html('wr_content', $content, $is_dhtml_editor);
		$editor_js = '';
		$editor_js .= get_editor_js('wr_content', $is_dhtml_editor);
		$editor_js .= chk_editor_js('wr_content', $is_dhtml_editor);

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






	function saveSubmit(){

		var f = document.frm;

		if(!f.wr_subject.value){
		alert('제목은 필수입니다.');
		f.wr_subject.focus();
		return false;

		}


		if (confirm('저장하시겠습니까?'))
		{
		f.submit();
		return false;
		}


	}



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


	<? if($_GET['bo_table'] !='bugreport'){ ?>  
          <h3 class="sub-header"><?=$view['wr_subject']?></h3>
          <? }else{ ?>
          <h3 class="sub-header">버그&제안 등록</h3>
	<? } ?>





          <div class="table-responsive">
			<form name="frm" method="post" action="./board_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="wr_id" value="<?=$row['wr_id']?>" />
				<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
				<input type="hidden" name="part" value="<?=$_GET['part']?>" />
				<input type="hidden" name="page" value="<?=$_GET['page']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled">
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered"><!--  table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

	<? if($_GET['bo_table'] =='info'){ ?>  
					<tr>
					<th>대분류 / 소분류</th>
					<td>
					<div style="border:0px solid red;">
					<select class="selectpicker cat1" name="cat1" id="cat1" onchange="get_cat2_load(this.value,'')"><!-- onchange="get_cat2_load(this.value)" -->
						<option value="">선택하세요</option>			
					<?
						$arr_info_gubun =  select_info_group();
						foreach($arr_info_gubun as $key => $val){
					?> 
					  <option value="<?=$key?>" <?if($key==$row['wr_cat1'])echo"selected"?>><?=$val[0]?></option>
					  <? } ?>
					</select>
					<select  name="cate2" id="cate2" style="width:220px;height:33px;border-radius:4px;padding-left:5px;">
					<option value=''>=====선택하세요=====</option>
					</select></div>

					</td>
					</tr>
 
	<? } ?>

	<? if($_GET['bo_table'] =='bugreport'){ ?>  

					<tr>
					<th>구분</th>
					<td>
					<select class="selectpicker wr_2" name="wr_2" id="wr_2" ><!-- onchange="get_cat2_load(this.value)" -->
						<option value="">선택하세요</option>			
					  <option value="1" <?if($row['wr_2']=='1')echo"selected"?>>버그신고</option>
					  <option value="2" <?if($row['wr_2']=='2')echo"selected"?>>제안하기</option>
					</select>
					</td>
					</tr>


					<tr>
					<th>진행상태</th>
					<td>
					<select class="selectpicker wr_1" name="wr_1" id="wr_1" ><!-- onchange="get_cat2_load(this.value)" -->
						<option value="">선택하세요</option>			
					<?
						for($i=0; $i < count($arr_status);$i++){
					?> 
					  <option value="<?=$i?>" <?if($i==$row['wr_1'])echo"selected"?>><?=$arr_status[$i]?></option>
					  <? } ?>
					</select>
					</td>
					</tr>
 

	<? } ?>

					<tr>
					<th>제목</th>
					<td><input type="text" name="wr_subject" value="<?=$row['wr_subject']?>" class="form-control"  style="font-weight:bold;"/></td>
					</tr>
					<? if($member['mb_id']=='admin'){ ?>					
					<tr>
					<th>옵션</th>
					<td><input type="checkbox" name="notice" id="notice" value="1" <?=$notice_checked?>/>공지</td>
					</tr>	

				<? } ?>

					<tr>
					<th>등록상태</th>
					<td>
					<select class="selectpicker wr_status" name="wr_status" id="wr_status" ><!-- onchange="get_cat2_load(this.value)" -->	
					  <option value="N" <?if($row['wr_status']=='N')echo"selected"?>>등록중</option>
					  <option value="Y" <?if($row['wr_status']=='Y')echo"selected"?>>등록완료</option>
					</select>
					</td>
					</tr>



					<? if($member['mb_id']=='admin'){ ?>
					<tr>
					<th>담당자</th>
					<td>
					<select class="selectpicker member" name="mb_id" id="mb_id" data-style="btn-default">
						  <option value="">담당선택</option>			
						<?
							$arr_member=  select_member();
							foreach($arr_member as $key => $val){
						?> 
						  <option value="<?=$key?>" <?if($key==$row['mb_id'])echo"selected"?>><?=$val?></option>
						  <? } ?>
						</select>
					</td>
					</tr>

				<? if($_GET['bo_table'] =='info'|| $_GET['bo_table'] =='bugreport'){ ?>  
					<tr>
					<th>정보등급 /마일리지</th>
					<td>
			<div style="float:left;">	
					<select class="selectpicker info_level" name="info_level" id="info_level" ><!-- onchange="get_cat2_load(this.value)" -->
						<option value="">==선택==</option>			
					  <option value="1" <?if($row['info_level']=='1')echo"selected"?>>1등급</option>
					  <option value="2" <?if($row['info_level']=='2')echo"selected"?>>2등급</option>
					  <option value="3" <?if($row['info_level']=='3')echo"selected"?>>3등급</option>
					  <option value="4" <?if($row['info_level']=='4')echo"selected"?>>4등급</option>
					  <option value="5" <?if($row['info_level']=='5')echo"selected"?>>5등급</option>
					  <option value="6" <?if($row['info_level']=='6')echo"selected"?>>6직접부여</option>
					</select>
			</div>
			<div style="float:left;margin-left:10px;">
					<input type="text" name="info_point" value="<?=$row['info_point']?>" class="form-control" style="font-weight:bold;width:120px;"/>
					</div>


					</td>
					</tr>

					<tr>
					<th>승인여부</th>
					<td>
					<select class="selectpicker wr_confirm" name="wr_confirm" id="wr_confirm" ><!-- onchange="get_cat2_load(this.value)" -->
						<option value="">==선택==</option>			
					  <option value="N" <?if($row['wr_confirm']=='N')echo"selected"?>>확인중</option>
					  <option value="Y" <?if($row['wr_confirm']=='Y')echo"selected"?>>승인완료</option>
					</select>
					</td>
					</tr>

						<? } ?>

						<? } ?>

					<tr>
					<td colspan="2">

					  <div class="form-group" style="height:100%">
						<!-- <label for="wr_content">Example textarea</label> -->
						<!-- <textarea id="wr_content" name="wr_content" ><?=$row['wr_content']?></textarea>	 -->
						<?echo $editor_html?>
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
							<option value="{ file_orl : '<?=$tmp_row[bf_file]?>&bo_table=<?=$tmp_row[bo_table]?>&wr_id=<?=$tmp_row[wr_id]?>&bf_no=<?=$tmp_row[bf_no]?>' , file : '<?=$tmp_row[bf_source]?>', re_file : '<?=$tmp_row[bf_file]?>', folder : 'http://mta.master36.com/data/board/img/<?=$tmp_row[bo_table]?>' , file_size : '<?=$tmp_row[bf_filesize]?>' , extension : 'null' , type : 'application/octet-stream' }" selected="selected"><?=$tmp_row[bf_source]?>(<?echo number_format($tmp_row[bf_filesize])?>)</option>

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

						<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./board_list.php?part=<?=$part?>&bo_table=<?=$bo_table?>'">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
						</button>
						
						<button type="button" class="btn btn-primary btn-sm"  onclick="saveSubmit();">
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


		</script>

<script type="text/javascript">


function  get_cat2_load(pid,id){

	  url = './ajax/ajax_cat2_load.php?pid='+pid+'&id='+id;

  $.ajax
      ({
         type: "POST",
         url: url,
         data: "id="+id,
         success: function(option)
         {
           $("#cate2").html(option);
		  
		 }

      });
  
	 return false;

}

<? if($row['wr_cat2']){ ?>

get_cat2_load('<?=$row[wr_cat1]?>','<?=$row[wr_cat2]?>');

<? } ?>

// 				$('.bootstrap-select.project  .filter-option').text(cell.pj_subject);







$(document).ready(function() {
	CKEDITOR.on('instanceLoaded', function(e) {e.editor.resize('100%', 360)} );
});

</script>
<?
  $app_root = "/home/mta/www";//$_SERVER['DOCUMENT_ROOT'];
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
