<?
	include_once("./_common.php");

	$is_id = $_GET['is_id'];


	if($is_id){

			$sql = "SELECT * FROM psj_issu WHERE  is_id = '$is_id'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);


			if($row['is_proc_percent']){
			   $is_proc_percent = $row['is_proc_percent'];
			}else{
			   $is_proc_percent = '0';
			}

		$oper = 'edit';
	}else{

		$oper = 'add';
		$row[bo_skin] = 'basic';
		$is_proc_percent = '0';
	}

		$is_dhtml_editor = false;
		$is_dhtml_editor_use = false;
		$editor_content_js = '';

		$content = get_text(html_purifier($row['is_content']), 0);
		$editor_html = editor_html('is_content', $content, $is_dhtml_editor);
		$editor_js = '';
		$editor_js .= get_editor_js('is_content', $is_dhtml_editor);
		$editor_js .= chk_editor_js('is_content', $is_dhtml_editor);


	include_once("./head.php");
?>
 		<script src="../ckeditor/ckeditor.js"></script>
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
		  MEIeditor[1] = CKEDITOR.replace( "is_content" , ckeditor_config );
		  objEditor = CKEDITOR.instances.wr_content;

		  console.log(objEditor);
		});

		function save() {
		  MEIeditor[1].updateElement();
		  alert( MEIeditor[1].getData() );
		  //jQuery('#form').submit();
		}



	  $(function(){

			$('.input-group.date').datepicker({
				calendarWeeks: false,
				todayHighlight: true,
				autoclose: true,
				format: "yyyy/mm/dd",
				language: "kr"

			});

		});

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

          <h2 class="sub-header">이슈 등록</h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./issu_update.php" enctype="multipart/form-data" ><!--  onSubmit="return saveSubmit(f)"  -->
				<input type="hidden" name="is_id" value="<?=$row['is_id']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered"><!--  table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>
					<tr>
					<th>제목</th>
					<td><input type="text" name="is_subject" value="<?=$row['is_subject']?>" class="form-control" style="font-weight:bold;"/></td>
					</tr>
					

					<tr>
					<th>프로젝트</th>
					<td>
					<select class="selectpicker project" name="pj_id" id="pj_id" data-style="btn-info">
						  <option value="">프로젝트선택</option>			
						<?
							$arr_prject =  select_project();
							foreach($arr_prject as $key => $val){
						?> 
						  <option value="<?=$key?>" <?if($key==$row['pj_id'])echo"selected"?>><?=$val?></option>
						  <? } ?>
						</select>
					</td>
					</tr>

					<tr>
					<th>진행상태</th>
					<td>
						<select class="selectpicker status"  name="is_status" id="is_status" data-style="btn-primary">
						  <option value="">진행상태</option>
						  
						<? for($i=1; $i<=count($arr_is_status); $i++){ ?>
						  <option value="<?=$i?>" <?if($i==$row['is_status'])echo"selected"?>><?=$arr_is_status[$i]?></option>
						<? } ?>

						</select>
					</td>
					</tr>
					<tr>
					<th>시작일/종료일</th>
					<td>
					<div class="input-group date" style="width:200px;float:left;">
						<input type="text" name="sdate"  value="<?=$row['sdate']?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					 </div>
					
					<div class="input-group date" style="width:200px;float:left;margin-left:10px;">
						<input type="text" name="edate"  value="<?=$row['edate']?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					 </div>
					</td>
					</tr>
					<tr>
					<th>진행률(%)<br/>내역</th>
					<td><input type="text" name="is_proc_precent" value="<?=$is_proc_percent?>" class="form-control" style="font-weight:bold;width:50px" maxlength="3"/>
					<input type="hidden" name="is_ori_precent" value="<?=$is_proc_percent?>" />
					<!-- <textarea class="form-control" id="proc_memo" name="proc_memo" rows="2" ></textarea>-->
					</td>
					</tr>
					
				<?// if($member['mb_id']==$row['mb_id'] || $member['mb_id']=='psj007'){ ?> 
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

				<? //} ?>
					<tr>
					<td colspan="2">

					  <div class="form-group" style="height:100%;">
						<!-- <label for="wr_content">Example textarea</label> -->
						<?echo $editor_html?>
						<!-- <textarea class="form-control" id="is_content" name="is_content" rows="15" ><?=$row['is_content']?></textarea> -->					  
					  </div>


					</td>
					</tr>

				</tbody>
			</table>

			</form>
			<div align="right">
					<?if($row['wr_id']){ ?>
						<button type="button" class="btn btn-danger btn-sm" onclick="del()">
						  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
						</button>
					<? } ?>			
						
						<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./issu_list.php?part=issu'">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
						</button>
						
						<button type="button" class="btn btn-primary btn-sm" onclick="issuSubmit()" >
						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
						</button>
			</div>



         </div> 

		  <!-- table-responsive -->
       
			 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->



   </div>  <!-- container-fluid -->
   <div style="height:60px;"></div>
<script>
	function issuSubmit(){


		var f = document.frm;

		if(!f.is_subject.value){
		alert('제목은 필수입니다.');
		f.is_subject.focus();
		return false;

		}

/*
		if(f.is_ori_precent.value < f.is_proc_precent.value){

		if(!f.proc_memo.value){
			alert('개발 내역을 입력하세요.');
			f.proc_memo.focus();
			return false;
		}
		
		}
*/

		if (confirm('등록하시겠습니까?'))
		{

		f.submit();
		return false;
		}

	}
</script>


<?
	include_once("./footer.php");
?>

	<script type="tex/javascript">


		// wr_content  textarea 를 ck에디터로 변환 해줌
			window.onload=function(){
			CKEDITOR.replace('is_content',{height:300});
			CKEDITOR.instances.is_content.getData();
		}


		</script>

<script type="text/javascript">


// 	var bo_table_enabled = $("#bo_table_enabled").val();

/*
	 if(oper=='add'){
		if(bo_table_enabled=='130'){
		alert('사용할 수 없는 TABLE CODE입니다.');
		return;
		}

	 }
*/

$(document).ready(function() {
	//$("#btn_search").trigger("click");
	get_member_row();



	 $('#cke_is_content').css({'height:400px'});


});






function memoNew(id) {

	$('#oper').val('write');
	$('#wr_id').val('');
	$('#wr_content').val('');


}




</script>


<script>


$(document).ready(function() {
	
  $("#btn_reload").click(function(){
		write_form_reset()
  });
 });




function write_form_reset(){

			$("#wr_id").val('');
			$("#wr_is_notice").val('');
			$("#wr_is_notice_view").val('');
			$("#wr_content").val('');
}


		function viewWriteForm() {


			$("#wr_id").val('');
			$("#wr_is_notice").val('');
			$("#wr_content").val('');
			$("#wr_is_notice_view").val('');


			var obj = document.getElementById("comment_write");  
			if(obj.style.display == "block") {
			obj.style.display = "none";

			} else {
			obj.style.display = "block";
			}
		} 





$(document).ready(function() {
	CKEDITOR.on('instanceLoaded', function(e) {e.editor.resize('100%', 360)} );
});


</script>

<?
	include_once("./tail.php");
?>
