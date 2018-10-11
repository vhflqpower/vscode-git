<?
	include_once("../common.php");

	$pj_id = $_GET['pj_id'];


	if($pj_id){

			$sql = "SELECT * FROM psj_project WHERE  pj_id = '$pj_id'";
			$result = sql_query($sql);
			$view = sql_fetch_array($result);



			//$str = nl2br($view['wr_content']);
			$str_content = url_auto_link($view['pj_content']);


		$oper = 'edit';
	}else{

		$oper = 'add';
		$view[bo_skin] = 'basic';
	}

	if($_GET['tab_id'])$tab_id=$_GET['tab_id'];else $tab_id=1;

	include_once("./head.php");
?>

<link rel="stylesheet" href="/css/boot_tab.css" type="text/css">
 
	<?
		include_once("./nav.php");
	?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header"><?=$view['pj_subject']?></h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./project_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="bo_table"  id="bo_table" value="project" />
				<input type="hidden" name="p_id"  id="p_id" value="<?=$view['pj_id']?>" />
				<input type="hidden" name="wr_file_link" id="wr_file_link" value="<?=$view['wr_file_link']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled">
			<!-- table-hover -->
				
			<table class="table table-bordered ">
			<!-- <table  class="table table-bordered table-hover"> -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<tr>				
					<th>시작일</th>
					<td><?=$view['pj_start_date']?></td>
					</tr>
					<tr>				
					<th>오픈일</th>
					<td><?=$view['pj_open_date']?></td>
					</tr>
					<tr>
					<td colspan="2">

					<!-- <div class="progress">
					  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
					    <span class="sr-only">40% Complete (success)</span>
					  </div>
					</div>
					<div class="progress">
					  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
					    <span class="sr-only">20% Complete</span>
					  </div>
					</div>
					<div class="progress">
					  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
					    <span class="sr-only">60% Complete (warning)</span>
					  </div>
					</div>
					<div class="progress">
					  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
					    <span class="sr-only">80% Complete (danger)</span>
					  </div>
					</div> -->


					<div style="padding:10px;min-height:300px"><?echo $str_content;?></div>
					</td>
					</tr>
					<tr>
				</tbody>
			</table>



		<div style="float:left;">

				<?if($view['wr_id']){ ?>
				<button type="button" class="btn btn-danger btn-sm" onclick="del()">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
				</button>
				<? } ?>			
		</div>			


		<div style="float:right">		
					
					<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./project_list.php?part=project'">
					  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
					</button>
					<button type="button" class="btn btn-default btn-sm"  onclick="write_page()">
					  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정
					</button>

					<script>
					function write_page(){
					var tab_id = $("#tab_id").val();		
					  location.href='./project_write.php?pj_id=<?=$view[pj_id]?>&part=project&tab_id='+tab_id;
					}					
					
					</script>
		</div>

		<div style="height:50px;"></div>		

		    <div class="col-md-12" style="padding:0px;">
			  <div class="panel with-nav-tabs panel-info">
				<input type="hidden" name="tab_id" id="tab_id" value="<?=$tab_id?>">
			      <div class="panel-heading">
				    <ul class="nav nav-tabs">
				        <li ><a href="#tab1info" data-toggle="tab" id="tab1">이슈목록</a></li><!-- class="active"  -->
				        <li ><a href="#tab2info" data-toggle="tab" id="tab2">관련파일</a></li>
				        <li ><a href="#tab3info" data-toggle="tab" id="tab3">담당정보</a></li>
				      <li ><a href="#tab4info" data-toggle="tab" id="tab4">관련정보</a></li>
				        <!-- <li class="dropdown">
					  <a href="#" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
					  <ul class="dropdown-menu" role="menu">
					      <li><a href="#tab4info" data-toggle="tab">info 4</a></li>
					      <li><a href="#tab5info" data-toggle="tab">info 5</a></li>
					  </ul>
				        </li> -->
				    </ul>
			      </div>
			      <div class="panel-body">
				<div class="tab-content">
				    <div class="tab-pane fade in active" id="tab1info">


				<form name="frmComm" method="post" action=""  enctype="multipart/form-data" >
					<input type="hidden" name="co_id"   id="co_id"  value="" />	
					<input type="hidden" name="cmode"   id="cmode"  value="add" />	
					<textarea id="co_content" name="co_content" class="form-control" id="bf_content"  style="width:100%;height:80px;"></textarea>
				</form>

				<div style="float:right;padding:6px;">	
				 <button type="button" class="btn btn-default btn-sm"  id="commAddCancle">
				<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
				 <button type="button" class="btn btn-primary btn-sm"  onclick="commSubmit()">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>글쓰기</button>
				</div>

					<table border="1" width="100%" cellspacing="0" id="commentTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="100%">
						</colgroup>

						<tbody id="comm_results"></tbody>
						</table>


						<div align="center">
							<div class="pagination" ></div>
						</div>


				     </div>
				    <div class="tab-pane fade" id="tab2info">

			<!--비용추가정보START-->
				<!-- <input type="button" value="열기" id="btn_file_open_" onclick="window.open('/pop_item/company_info_pop.php','company','top=10,left=10,width=840px,height=440px')"/>
					<input type="button" value="추가" onclick="javascript:fileAddRow();"/>
					<input type="button" value="제거" onclick="javascript:fileDeleteRow();"/> -->
				
					<table border="1" width="100%" cellspacing="0" id="fileTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="10%">
							<col width="15%">
							<col width="75%">
			
						</colgroup>
						<tr>
							<th >NO</th>
							<th >파일넘버</th>
							<th >파일명</th>

						</tr>
<!-- 
						<tr>
						 <td>
						 <span id="file_no_1"></span>
						 </td>
						 <td>
						  <span id="file_id_1"></span>
						 
						 </td>
						 <td>
						  <span id=""></span>
					
						<span id="bf_source_1"></span><br>
						<span id="bf_content_1"></span><br>

						</td>
						</tr> -->

							<!-- <td><input type="button" value="DEL" onclick="javascript:delRow(this);"></td> -->

							<!--- ###### ROOP ###### ------->
							<textarea id="file_item_row" style="display:none;">
							<tr>
							 <td>
							  <!-- <span id="file_no_CHCNT"></span> -->
							   <div style="text-align:center"><span id="sort_id_CHCNT"></span></div>
							</td>
							 <td>
							  <span id="file_id_CHCNT"></span>
							
							 </td>

							 <td>
							  <span id="bf_source_CHCNT"></span><br>
							  <span id="bf_content_CHCNT"></span>

							</td>
							<!-- <td><input type="button" value="DEL" onclick="javascript:delRow(this);"></td> -->
							</tr>
							</textarea>
						</table><BR>

					</div>
				    <div class="tab-pane fade" id="tab3info">
				    
<!-- 
					<input type="button" value="추가" onclick="javascript:mbAddRow();"/>
					<input type="button" value="제거" onclick="javascript:mbDeleteRow();"/> -->
					<table border="1" width="100%" cellspacing="0" id="mbTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="5%">
							<col width="10%">
							<col width="15%">
							<col width="10%">
							<col width="10%">
							<col width="15%">
							<col width="55%">
			
						</colgroup>
						<tr>
							<th class="sub_head">SORT</th>
							<th class="sub_head">업체</th>
							<th class="sub_head">담당명</th>
							<th class="sub_head">핸드폰</th>
							<th class="sub_head">전화</th>
							<th class="sub_head">E메일</th>
							<th class="sub_head">메모</th>
						</tr>

						<!--- ###### ROOP ###### ------->
						<textarea id="mb_item_row" style="display:none;">
						<tr>
						 <td style="text-align:center;">
						 <span id="li_sort_MBCNT"></span>
						 </td>

						 <td>
						<span id="company_MBCNT"></span>
						</td>
						 <td> <div style="float:left;height:30px;">

						<span  id="mb_name_MBCNT" ></span><div style="float:right;">
						</div>
						 </td>

						 <td>
						<span  id="mb_hp_MBCNT"></span>
						</td>
						 <td>
						<span  id="mb_tel_MBCNT"></span>
						</td>
						 <td>
						<span  id="mb_email_MBCNT"></span>
						</td>

						 <td>
						<span  id="li_memo_MBCNT" ></span>
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
			</div> <!-- <div class="col-md-12"> -->
		
			</form>
         </div> 



		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

	<div style="height:20px;"></div>

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


	<form name="fdel" method="post" action="./project_update.php">
	<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
	<input type="hidden" name="oper" value="del" />
	</form>

	<!-- <div style="position:absolute;left:400px;top:200px;width:1000px;height:800px;" id="detailListViewLayer">
	</div>-->

<?

	include_once("./footer.php");
?>

<script type="text/javascript">



             
 // $("frmComm").submit(function(event){		

function commSubmit(){	
	

	var bo_table = $("#bo_table").val();
	var mode = $("#cmode").val();
	var p_id = $("#p_id").val();
	var co_id = $("#co_id").val();
	var co_content = $("#co_content").val();

	if(!co_content) {
		$("#co_content").focus();
		alert('메모 사항은 필수입니다.');
		return;
	}

	var postData;
	var rows = Object();
	var rows= {
			mode  : mode,
			p_id  : p_id,
			co_id : co_id,
			co_content  : co_content,
			bo_table  : bo_table,

		};

	var postData = $.param(rows);

	$.ajax({
		url: "./ajax/ajax_comment_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {
				//location.reload();

			$("#co_content").val('');
			// $(".comm_row").remove();
			get_comment_row();
			}

		//location.replace();

		}
	});
	
	return false;
	
}



function commDelSubmit(id){	
	


	if(!id) {
		alert('선택 된 항목이 없습니다.');
		return;
	}

	var postData;
	var rows = Object();
	var rows= {

			mode  : 'del',
			seq  : id,

		};

	var postData = $.param(rows);

		if (confirm('정말로 삭제하시겠습니까?'))
		{

	$.ajax({
		url: "./ajax/ajax_comment_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {
				//location.reload();

			$("#co_content").val('');
		//	$(".comm_row").remove();
			get_comment_row();
			}


		}
	});
		}
	
	return false;
	
}




function commEdit(id) {


//	console.log('getCustOrder',id);
	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_comment_load.php?id=' + id;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
       contentType: "application/x-www-form-urlencoded; charset=UTF-8",

		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩

			if(success) {

				var cell = response.rows;


				$('#cmode').val('edit');
				$('#co_id').val(cell.seq);
				$('#co_content').val(cell.co_content);
				
				
				} else {
				alert('fail to load data');
			}
		}
	});
}





$(document).ready(function() {

	//$("#btn_search").trigger("click");
	get_comment_row()

	// 그리드 검색
	$("#btn_search" ).on('click',function() { 
		get_member_row(); 
	});


	$("#commAddCancle" ).on('click',function() { 
		
		$('#cmode').val('add');
		$('#co_id').val('');
		$('#co_content').val('');
	});


	$("#tab1" ).on('click',function() { 
		$("#tab_id").val(1);
	});
	$("#tab2" ).on('click',function() { 
		$("#tab_id").val(2);
	});
	$("#tab3" ).on('click',function() { 
		$("#tab_id").val(3);
	});
	$("#tab4" ).on('click',function() { 
		$("#tab_id").val(4);
	});


});

function onTab(){
	var tab_id = $("#tab_id").val();
	$("#tab"+tab_id).trigger("click");

}
	setTimeout(function() {
	  onTab()
	}, 100);



	
// 로데이터 AJAX 로깅
function get_comment_row(){


	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var ca_name = $("#ca_name").val();
	var bo_table = $("#bo_table").val();

	var p_id = $("#p_id").val();


	$("#comm_results").load("./ajax/ajax_comment_row_data.php",{'search_field':s_field,'search_value':s_value,'p_id':p_id});


        var obj = $('.pagination').twbsPagination({
            totalPages: 1,
            visiblePages: 5,
            onPageClick: function (event, page) {

			  //  console.info(page);			  
		   	event.preventDefault();

			$("#comm_results").load("./ajax/ajax_comment_row_data.php", {'page':page,'p_id':p_id,'bo_table':bo_table});
			
			}
        });
   
		console.info(obj.data());

}






// ######----------------------------------------------------> 관련파일정보동적추가
  
 //  var ITEM_CNT = 2;
  function fileAddRow(){


	var lastItemNo = jQuery("#fileTable tr").length;  // tr count
	var ITEM_CNT = lastItemNo;



    var row = $("#file_item_row").val();

//	$(row).appendTo("#fileTable");
  	$('#fileTable').append( row.replace(/CHCNT/gi, ITEM_CNT) );

	// $('.use-datepicker_'+(ITEM_CNT)).datepicker();
	// $(document).ready(function() { $("#total_wr_id2_"+(ITEM_CNT)).select2(); });

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
   
   if(jQuery("#fileTable tr").length < 3){
  alert("더이상 삭제 할 수 없습니다.");
  return false;
}
   
  // if(confirm("행을 삭제 하시겠습니까?")){
    jQuery(obj).parent().parent().remove();
  // }
}


<?
	if($pj_id){
	
	$result = sql_query("SELECT a.bf_no,a.bf_item,b.wr_id,b.bf_file,b.bf_source,b.bf_content,b.seq,a.bf_sort,b.bo_table FROM psj_link_item a left join psj_board_file b on a.bf_item = b.wr_id WHERE  a.wr_id ='$pj_id' ORDER BY a.bf_sort ASC");
	$row_cnt =sql_num_rows($result);

	if($row_cnt > 0 ){
//	echo "var len='".sql_num_rows($result)."'\n";
	echo "var len=$row_cnt-0;\n";  // ori -1
	
	echo "while(len--){	fileAddRow(); };\n";
	
	
	echo "ITEM_CNT = 1;\n";

//	echo "alert(ITEM_CNT)";

	while($row = sql_fetch_array($result)){

?>

		$('#file_no_'+ (ITEM_CNT) ).html(ITEM_CNT);

		$('#sort_id_'+ (ITEM_CNT) ).html('<?=$row['bf_sort']?>');	
		$('#file_id_'+ (ITEM_CNT) ).html('<?=$row['bf_item']?>');		
	          $('#bf_source_'+ (ITEM_CNT) ).html("<a href='./download.php?bo_table=<?=$row[bo_table]?>&bf_file=<?=$row[bf_file]?>&seq=<?=$row[seq]?>'><?=$row[bf_source]?></a>");
	          $('#bf_content_'+ (ITEM_CNT) ).html("<?=$row[bf_content]?>");



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
	

	$result = sql_query("SELECT a.li_no,a.li_mb_no,b.mb_name,b.mb_hp,b.mb_tel,b.mb_email,b.mb_1,a.li_memo,(select c.co_name from psj_company c where c.co_id = b.mb_1)as company,a.li_sort FROM psj_link_mb a left join psj_member b on a.li_mb_no = b.mb_no WHERE  a.li_part = 'project' AND a.p_id ='$pj_id' ORDER BY a.li_sort ASC");
	$row_cnt =sql_num_rows($result);

	if($row_cnt > 0 ){
//	echo "var len='".sql_num_rows($result)."'\n";
	echo "var len=$row_cnt-0;\n";
	echo "while(len--){	mbAddRow(); };\n";
	echo "MB_CNT = 1;\n";


	while($row = sql_fetch_array($result)){

?>
	//	$('#mb_no_'+ (MB_CNT) ).val('<?=$row['li_mb_no']?>');
		$('#mb_id_'+ (MB_CNT) ).html('<?=$row['li_mb_no']?>');
		$('#li_sort_'+ (MB_CNT) ).html('<?=$row['li_sort']?>');
		$('#co_id_'+ (MB_CNT) ).html('<?=$row['mb_1']?>');
		$('#company_'+ (MB_CNT) ).html('<?=$row['company']?>');
		$('#mb_name_'+ (MB_CNT) ).html('<?=$row['mb_name']?>');
		$('#mb_hp_'+ (MB_CNT) ).html('<?=$row['mb_hp']?>');
		$('#mb_tel_'+ (MB_CNT) ).html('<?=$row['mb_tel']?>');
		$('#mb_email_'+ (MB_CNT) ).html('<?=$row['mb_email']?>');
		$('#li_memo_'+ (MB_CNT) ).html('<?=$row['li_memo']?>');

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






function payPop(id){
	  $("#pay_ment_id").val(id); 	
	  $("#modal_content").modal(); 
	//  document.payment.location="./pop_payment_view.php?pm_id="+id;
	  $("#payment").attr("src","/pop_item/company_info_pop.php?pm_id="+id);
	}



$(document).ready(function(){
 $(".open").click(function(){
  $("#modal_content").modal(); 
 });

 $("#m_close").click(function(){

	var mb_cd =  $("#id").val();	
	get_member_load(mb_cd);
	$grid2.trigger('reloadGrid');

	var mb_cd=$('#memo_mb_cd').val();

	//setTimeout("getMbMemoList(mb_cd)", 1000);

	//alert('정상수정')
	$.modal.close();
 
 });
}); 
//-->
</script>


<script>




$(document).ready(function() {
	
  $("#btn_file_open").click(function(){
			$("#detailListViewLayer").load("/pop_item/company_info_pop.php?gb_seq=" + $(".auctionSeq").val() + "&block=" + $(".pagBlock").val() + "&gotopage=" + $(".pageGotoPage").val());

  });

 });



</script>

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
//	get_project_row()

});





</script>


<script>

/*
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


	var project_skin_path = '.';

    $.ajax({ 
        type: 'POST',
        url: project_skin_path+'/ajax_bo_table_check.php',
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
*/





</script>

<?
	include_once("./tail.php");
?>
