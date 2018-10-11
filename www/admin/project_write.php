<?
	include_once("../common.php");

	$pj_id = $_GET['pj_id'];


	if($pj_id){

			$sql = "SELECT * FROM psj_project WHERE  pj_id = '$pj_id'";
			$result = sql_query($sql);
			$view = sql_fetch_array($result);

		$oper = 'edit';
	}else{

		$oper = 'add';
		$view[bo_skin] = 'basic';
	}

	if($_GET['tab_id'])$tab_id=$_GET['tab_id'];else $tab_id=1;

	include_once("./head.php");
?>



  		<script src="../ckeditor/ckeditor.js"></script>
		<script>
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
		  MEIeditor[1] = CKEDITOR.replace( "pj_content" , ckeditor_config );
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
	<link rel="stylesheet" href="/css/boot_tab.css" type="text/css">

	<div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">프로젝트 정보</h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./project_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="pj_id" value="<?=$view['pj_id']?>" />
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
					<th>제목</th>
					<td><input type="text" name="pj_subject" value="<?=$view['pj_subject']?>" class="form-control"  /></td>
					</tr>

				<tr>
					<th>오픈일</th>
					<td>
						<div class="input-group date" style="width:200px;">
						<input type="text" name="pj_open_date"  value="<?=$view['pj_open_date']?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					 </div>
					</td>
					</tr>


					<tr>
					<td colspan="2">
					  <div class="form-group">
						<label for="wr_content"></label>
						<textarea class="form-control" id="pj_content" name="pj_content" rows="1"><?=$view['pj_content']?></textarea>
					  </div>


					</td>
					</tr>

					<!-- <tr>
					<th>연결파일</th>
					<td><input type="text" name="wr_file_link" value="<?=$view['wr_file_link']?>" class="form-control"  /></td>
					</tr>
					<tr>	
 -->

				</tbody>
			</table>




		        <div class="col-md-12">
			  <div class="panel with-nav-tabs panel-info">
			  <input type="hidden" name="tab_id" id="tab_id" value="<?=$tab_id?>">
			      <div class="panel-heading">
				    <ul class="nav nav-tabs">
				        <li ><a href="#tab1info" data-toggle="tab" id="tab1">이슈목록</a></li><!-- class="active"  -->
				        <li ><a href="#tab2info" data-toggle="tab" id="tab2">관련파일</a></li>
				      <li ><a href="#tab3info" data-toggle="tab" id="tab3">담당정보</a></li>
				        <li ><a href="#tab4info" data-toggle="tab" id="tab4">관련정보</a></li>

				    </ul>
			      </div>
			      <div class="panel-body">
				<div class="tab-content">
				    <div class="tab-pane fade in active" id="tab1info">info 1
								

				     </div>
				    <div class="tab-pane fade" id="tab2info">
								
			<!--파일정정보START-->


					<!--  onclick="payPop()" -->

					<input type="button" value="추가" onclick="javascript:fileAddRow();"/>
				
					<input type="button" value="제거" onclick="javascript:fileDeleteRow();"/>
				
					<table border="1" width="100%" cellspacing="0" id="fileTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="10%">
							<col width="15%">
							<col width="75%">
			
						</colgroup>
						<tr>
							<th class="sub_head">NO</th>
							<th class="sub_head">파일넘버</th>
							<th class="sub_head">파일명</th>

						</tr>

						<!--- ###### ROOP ###### ------->
						<textarea id="file_item_row" style="display:none;">
						<tr>
						 <td><input class="form-control" type=hidden id="file_no_CHCNT" name="file_no[]" maxlength=10 size=2 value="CHCNT"  style='text-align:center;width:80px;'/>
						 
						 <input class="form-control" type=text id="sort_id_CHCNT" name="sort_id[]" maxlength=10 size=2 value=""  style='text-align:center;width:80px;'/>
						 </td>
						 <td> <div style="float:left;">
						<input type=text id="file_id_CHCNT"  name="file_id[]" maxlength=12 value=""  class="form-control" style='width:140px;'></div><div style="float:right;">
						<input type="button" value="열기" id="btn_file_open_" onclick="window.open('/popItem/file_data_pop.php?id='+CHCNT,'attfile','top=10,left=10,width=840px,height=440px')"/></div>
						 </td>

						 <td>
						<input type=text  maxlength=10 size=12  id="file_source_CHCNT"  name="file_source[]"   class="form-control" value="" >
					

						</td>
						<!-- <td><input type="button" value="DEL" onclick="javascript:delRow(this);"></td> -->
						</tr>
						</textarea>
						</table><BR>

			<!--파일정정보 END-->

					</div>
				    <div class="tab-pane fade" id="tab3info">
				    
 
			<!--파일정정보START-->
					<!--  onclick="payPop()" -->

					<input type="button" value="추가" onclick="javascript:mbAddRow();"/>
					<input type="button" value="제거" onclick="javascript:mbDeleteRow();"/>
					<table border="1" width="100%" cellspacing="0" id="mbTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="5%">
							<col width="10%">
							<col width="15%">
							<col width="15%">
							<col width="15%">
							<col width="55%">
			
						</colgroup>
						<tr>
							<th class="sub_head">SORT</th>
							<th class="sub_head">업체</th>
							<th class="sub_head">담당명</th>
							<th class="sub_head">핸드폰</th>
							<th class="sub_head">E메일</th>
							<th class="sub_head">메모</th>
						</tr>

						<!--- ###### ROOP ###### ------->
						<textarea id="mb_item_row" style="display:none;">
						<tr>
						 <td><input class="form-control" type=hidden id="mb_no_MBCNT" name="mb_no[]" maxlength=10 size=2 value="MBCNT"  style='text-align:center;width:80px;'/>
						 
						 <input class="form-control" type=text id="li_sort_MBCNT" name="li_sort[]" maxlength=10 size=2 value="0"  style='text-align:center;width:80px;'/>
						 </td>

						 <td>
						<input type=hidden  maxlength=10 size=12  id="co_id_MBCNT"  name="co_id[]"   class="form-control" value="" >
						<input type=text  maxlength=10 size=12  id="company_MBCNT"  name="company[]"   class="form-control" value="" >
						</td>
						 <td> <div style="float:left;">

						<input class="form-control" type=hidden id="mb_id_MBCNT" name="mb_id[]" maxlength=10 size=2 value=""  style='text-align:center;width:80px;'/>

						<input type=text id="mb_name_MBCNT"  name="mb_name[]" maxlength=12 value=""  class="form-control" style='width:140px;'></div><div style="float:right;">
						<input type="button" value="열기" id="btn_mb_open_" onclick="window.open('/popItem/mb_data_pop.php?id='+MBCNT,'attmb','top=10,left=10,width=840px,height=440px')"/></div>
						 </td>

						 <td>
						<input type=text  maxlength=30 size=12  id="mb_hp_MBCNT"  name="mb_hp[]"   class="form-control" value="" >
						</td>

						 <td>
						<input type=text  maxlength=30 size=12  id="mb_email_MBCNT"  name="mb_email[]"   class="form-control" value="" >
						</td>

						 <td>
						<input type=text  maxlength=255 size=12  id="li_memo_MBCNT"  name="li_memo[]"   class="form-control" value="" >
						</td>
						<!-- <td><input type="button" value="DEL" onclick="javascript:delRow(this);"></td> -->
						</tr>
						</textarea>
						</table><BR>

			<!--파일정정보 END-->				    
				    

				    </div>
				    <div class="tab-pane fade" id="tab4info">info 4</div>
				    <div class="tab-pane fade" id="tab5info">info 5</div>
				</div>
			      </div>
			  </div>
		        </div>
			</div>


	<div style="float:left">

			<?if($view['seq']){ ?>
				<button type="button" class="btn btn-danger btn-sm" onclick="fileDel();">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
				</button>
			<? } ?>			
				


	</div>

	<div style="float:right">
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./project_list.php?part=project'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			<button type="button" class="btn btn-default btn-sm"  onclick="view_page()">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>보 기
			</button>
			
			<button type="submit" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>

			<script>
			function view_page(){
			var tab_id = $("#tab_id").val();
			  location.href='./project_view.php?pj_id=<?=$view[pj_id]?>&part=project&tab_id='+tab_id;
			}					
			
			</script>
	</div>

			</form>

	<div style="height:70px;"></div>


         </div> 
		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->

	<form name="fdel" method="post" action="./dataroom_update.php">
	<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
	<input type="hidden" name="seq" value="<?=$view['seq']?>" />
	<input type="hidden" name="oper" value="del" />
	</form>




<?
	include_once("./footer.php");
?>




<script type="text/javascript">


function saveSubmit(){


}



	 function fileDel(){
		if (confirm('한번 삭제한 자료는 복구가 되지 않습니다. 정말로 삭제하시겠습니까?'))
		{
			document.fdel.submit();
			//$('#fdel').submit();
		}
	}
			

// 	var bo_table_enabled = $("#bo_table_enabled").val();


$(document).ready(function() {
	//$("#btn_search").trigger("click");
	//get_comment_row();

	$("#tab1").on('click',function() { 
		$("#tab_id").val(1);
	});

	$("#tab2").on('click',function() { 
		$("#tab_id").val(2);
	});
	$("#tab3").on('click',function() { 
		$("#tab_id").val(3);
	});
	$("#tab4").on('click',function() { 
		$("#tab_id").val(4);
	});

	CKEDITOR.on('instanceLoaded', function(e) {e.editor.resize('100%', 360)} );

});



function onTab(){
	var tab_id = $("#tab_id").val();
	$("#tab"+tab_id).trigger("click");

}
	setTimeout(function() {
	  onTab()
	}, 100);


function memoNew(id) {

	$('#oper').val('write');
	$('#wr_id').val('');
	$('#wr_content').val('');
}


// ######----------------------------------------------------> 파일정보동적추가
  
 //  var ITEM_CNT = 2;
  function fileAddRow(){


	var lastItemNo = jQuery("#fileTable tr").length;  // tr count
	var ITEM_CNT = lastItemNo;

    var row = $("#file_item_row").val();

//	$(row).appendTo("#eadTable");
  	$('#fileTable').append( row.replace(/CHCNT/gi, ITEM_CNT) );

	//$('.use-datepicker_'+(ITEM_CNT)).datepicker();
	//$(document).ready(function() { $("#total_wr_id2_"+(ITEM_CNT)).select2(); });

	ITEM_CNT++;
  }
 
  //마지막 Row 삭제
  function fileDeleteRow(){
   
   if(jQuery("#fileTable tr").length < 2){
    alert("더이상 삭제 할 수 없습니다.");
    return false;
   }
   
   jQuery("#fileTable tr").last().remove();
  }
  
  //선택한 Row 삭제
  function fileCheckDelRow(obj){
   
   if(jQuery("#fileTable tr").length < 2){
  alert("더이상 삭제 할 수 없습니다.");
  return false;
}
   
  // if(confirm("행을 삭제 하시겠습니까?")){
    jQuery(obj).parent().parent().remove();
  // }
}

<?
	if($pj_id){
	

	$result = sql_query("SELECT a.bf_no,a.bf_item,b.wr_id,b.bf_file,b.bf_source,b.bf_content,b.seq,a.bf_sort FROM psj_link_item a left join psj_board_file b on a.bf_item = b.wr_id WHERE  a.bo_table = 'project' AND a.wr_id ='$pj_id' ORDER BY a.bf_sort ASC");
	$row_cnt =sql_num_rows($result);

	if($row_cnt > 0 ){
//	echo "var len='".sql_num_rows($result)."'\n";
	echo "var len=$row_cnt-0;\n";
	echo "while(len--){	fileAddRow(); };\n";
	echo "ITEM_CNT = 1;\n";


	while($row = sql_fetch_array($result)){

?>
		$('#file_id_'+ (ITEM_CNT) ).val('<?=$row['bf_item']?>');
		$('#sort_id_'+ (ITEM_CNT) ).val('<?=$row['bf_sort']?>');
	          $('#file_source_'+ (ITEM_CNT) ).val('<?=$row['bf_source']?>');
	          $('#file_content_'+ (ITEM_CNT) ).val('<?=$row['bf_content']?>');

	//	$('#cm_to_check_'+ (ITEM_CNT) ).attr('checked', <?=($row['to_check'] > 0)?"true":"false"?>);
	ITEM_CNT++;
<?
	  }
	 }
	}

?>




// ######----------------------------------------------------> 담당정보동적추가
  
 //  var ITEM_CNT = 2;
  function mbAddRow(){


	var lastItemNo = jQuery("#mbTable tr").length;  // tr count
	var MB_CNT = lastItemNo;

    var row = $("#mb_item_row").val();

//	$(row).appendTo("#eadTable");
  	$('#mbTable').append( row.replace(/MBCNT/gi, MB_CNT) );

	//$('.use-datepicker_'+(MB_CNT)).datepicker();
	//$(document).ready(function() { $("#total_wr_id2_"+(MB_CNT)).select2(); });

	MB_CNT++;
  }
 
  //마지막 Row 삭제
  function mbDeleteRow(){
   
   if(jQuery("#mbTable tr").length < 2){
    alert("더이상 삭제 할 수 없습니다.");
    return false;
   }
   
   jQuery("#mbTable tr").last().remove();
  }
  
  //선택한 Row 삭제
  function mbCheckDelRow(obj){
   
   if(jQuery("#mbTable tr").length < 2){
  alert("더이상 삭제 할 수 없습니다.");
  return false;
}
   
  // if(confirm("행을 삭제 하시겠습니까?")){
    jQuery(obj).parent().parent().remove();
  // }
}


<?
	if($pj_id){
	

	$result = sql_query("SELECT a.li_no,a.li_mb_no,b.mb_name,b.mb_hp,b.mb_email,b.mb_1,(select c.co_name from psj_company c where c.co_id = b.mb_1)as company,a.li_sort,a.li_memo FROM psj_link_mb a left join psj_member b on a.li_mb_no = b.mb_no WHERE  a.li_part = 'project' AND a.p_id ='$pj_id' ORDER BY a.li_sort ASC");
	$row_cnt =sql_num_rows($result);

	if($row_cnt > 0 ){
//	echo "var len='".sql_num_rows($result)."'\n";
	echo "var len=$row_cnt-0;\n";
	echo "while(len--){	mbAddRow(); };\n";
	echo "MB_CNT = 1;\n";


	while($row = sql_fetch_array($result)){

?>
	//	$('#mb_no_'+ (MB_CNT) ).val('<?=$row['li_mb_no']?>');
		$('#mb_id_'+ (MB_CNT) ).val('<?=$row['li_mb_no']?>');
		$('#li_sort_'+ (MB_CNT) ).val('<?=$row['li_sort']?>');
		$('#co_id_'+ (MB_CNT) ).val('<?=$row['mb_1']?>');
		$('#company_'+ (MB_CNT) ).val('<?=$row['company']?>');
		$('#mb_name_'+ (MB_CNT) ).val('<?=$row['mb_name']?>');
		$('#mb_hp_'+ (MB_CNT) ).val('<?=$row['mb_hp']?>');
		$('#mb_email_'+ (MB_CNT) ).val('<?=$row['mb_email']?>');
		$('#li_memo_'+ (MB_CNT) ).val('<?=$row['li_memo']?>');


	//	$('#sort_id_'+ (MB_CNT) ).val('<?=$row['bf_sort']?>');
	  //        $('#file_source_'+ (MB_CNT) ).val('<?=$row['bf_source']?>');
	   //       $('#file_content_'+ (MB_CNT) ).val('<?=$row['bf_content']?>');

	//	$('#cm_to_check_'+ (MB_CNT) ).attr('checked', <?=($row['to_check'] > 0)?"true":"false"?>);

	MB_CNT++;
<?
	  }
	 }
	}

?>




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




var reg_mb_cd_check = function() {


	var member_skin_path = '.';

    $.ajax({ 
        type: 'POST',
        url: member_skin_path+'/ajax_bo_table_check.php',
        data: {
            'bo_table': encodeURIComponent($('#reg_bo_table').val())
        },
        cache: false,
        async: false,
        success: function(result) {
            var msg = $('#msg_bo_table');
            switch(result) {
                case '110' : msg.html('영문자, 숫자, _ 만 입력하세요.').css('color', 'red'); break;
                case '120' : msg.html('최소 4자이상 입력하세요.').css('color', 'red'); break;
                case '130' : msg.html('이미 사용중인 코드.').css('color', 'red'); break;
                case '140' : msg.html('예약어로 사용할 수 없는 아이디 입니다.').css('color', 'red'); break;
                case '000' : msg.html('사용가능 코드.').css('color', 'blue'); break;
                default : alert( '잘못된 접근입니다.\n\n' + result ); break;
            }
            $('#mb_cd_enabled').val(result);
        }
    });
}






</script>

<?
	include_once("./tail.php");
?>
