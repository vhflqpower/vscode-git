<?
	include_once("../common.php");

	$co_id = $_GET['co_id'];


	if($co_id){

			$sql = "SELECT * FROM psj_company WHERE  co_id = '$co_id'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);

		$oper = 'edit';
	}else{

		$oper = 'add';
		$row[bo_skin] = 'basic';
	}


	include_once("./head.php");
?>
 
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

          <h2 class="sub-header">고객사 정보</h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./company_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
			<input type="hidden" name="bo_table"  id="bo_table" value="company" />
				<input type="hidden" id="co_id" name="co_id" value="<?=$row['co_id']?>" />
				<input type="hidden" id="oper" name="oper" value="<?=$oper?>" />
				<input type="hidden" id="bo_table_enabled" name="bo_table_enabled"    value="" id="bo_table_enabled">
			<!-- table-hover -->
				
			<table class="table table-bordered ">
			<!-- <table  class="table table-bordered table-hover"> -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<th>상호</th>
					<td><?=$row['co_name']?></td>
					</tr>
					<th>성명(대표자)</th>
					<td><?=$row['mb_name']?></td>
					</tr>
					<th>생년월일(ex:19840101)</th>
					<td><?=$row['mb_birth']?></td>
					</tr>
					<th>개업년월일(ex:20180101)</th>
					<td><?=$row['co_open_date']?></td>
					</tr>
					<th>사업장 주소</th>
					<td>(<?=$row['zip_code']?>)<br><?=$row['co_address']?>&nbsp;&nbsp;<?=$row['co_address2']?></td>
					</tr>
					<th>사업의 종류</th>
					<td><?=$row['co_condition']?></td>
					</tr>
					</tr>
					<th>대표전화</th>
					<td><?=$row['co_tel']?></td>
					</tr>
					</tr>
					<th>FAX</th>
					<td><?=$row['co_fax']?></td>
					</tr>
					<tr>
					<th>내용</th>
					<td><?=$row['co_content']?></td>
					</tr>

				</tbody>
			</table>



<div style="float:left">
		<?if($row['co_id']){ ?>
					<button type="button" class="btn btn-danger btn-sm" onclick="del()">
					  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
					</button>
		<? } ?>		
	</div>	
<div style="float:right">		
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./company_list.php?part=company'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./company_write.php?co_id=<?=$row[co_id]?>&part=company'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정
			</button>
</div>

		<div style="height:50px;"></div>	
	<!-- 하단 아이템 -->
	<div class="col-md-12">
			  <div class="panel with-nav-tabs panel-info">
			      <div class="panel-heading">
				    <ul class="nav nav-tabs">
				        <li class="active"><a href="#tab1info" data-toggle="tab">이슈목록</a></li>
				        <li><a href="#tab2info" data-toggle="tab">관련파일</a></li>
				        <li><a href="#tab3info" data-toggle="tab">관련정보</a></li>
				      <li><a href="#tab4info" data-toggle="tab">담당정보</a></li>
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
							<col width="75%">
							<col width="10%">
							<col width="15%">
						</colgroup>

						<tbody id="comm_results"></tbody>
						</table>


						<div align="center">
							<div class="pagination" ></div>
						</div>


				     </div>
				    <div class="tab-pane fade" id="tab2info">
				
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
							<textarea id="file_item_row" style="display:none;">
							<tr>
							 <td>
							  <span id="file_no_CHCNT"></span>
							</td>
							 <td>
							  <span id="file_id_CHCNT"></span>
							
							 </td>

							 <td>
							  <span id="bf_source_CHCNT"></span><br>
							  <span id="bf_content_CHCNT"></span>

							</td>
							</tr>
							</textarea>
						</table><BR>

					</div>
				    <div class="tab-pane fade" id="tab3info">info 3</div>
				    <div class="tab-pane fade" id="tab4info">info 4</div>
				    <div class="tab-pane fade" id="tab5info">info 5</div>
				</div>
			      </div>
			  </div>
		        </div>
	</div>	<!-- 하단 아이템 끝 -->



			</form>



         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


<?
	include_once("./footer.php");
?>




<script type="text/javascript">
// 코멘트 데이터 로우
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



});


$(document).ready(function() {
	//$("#btn_search").trigger("click");
	get_member_row()

});


</script>





<script>

/*------------------------------------------------------------> 삭제 */
function del() {

   $("#oper").val("del");
   var postData;
   var rows = Object();

   
   var oper = $('#oper').val();
   var co_id = $('#co_id').val();


   var rows= {
      oper : 'del',
      co_id : co_id,
   
   };
   
   var postData = $.param(rows);

   //var postData = $('.inputForm :input').serialize() + '&oper=edit&id=';

   var url = './company_update.php'//url 수정;


   var msg = '한번 삭제한 정보는 복구 할 수 없습니다.\n 정말 삭제하시겠습니까?';

   if(confirm(msg)) {

      $.ajax({
         url:url,
         data: postData,
         type:'post',
         dataType:'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
         cache:false,
         success:function(response) {
            var success = (response.flag == 'succ');
            var message = response.message;
            alert(message);
			location.href='./company_list.php?part=company';
         }
      });

   } //confirm msg

   return;


}

// 서브 목록 코멘트
function commSubmit(){	
	

	var bo_table = $("#bo_table").val();
	var mode = $("#cmode").val();
	var p_id = $("#co_id").val();
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
			$(".comm_row").remove();
			get_comment_row();
			}

		//location.replace();

		}
	});
	
	return false;
	
}



	
// 코멘트 데이터 로우
function get_comment_row(){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var ca_name = $("#ca_name").val();

	var p_id = $("#co_id").val();
	var bo_table = $("#bo_table").val();

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




</script>

<?
	include_once("./tail.php");
?>
