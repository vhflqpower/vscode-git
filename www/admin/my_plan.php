<?
	include_once("../common.php");

	include_once("./head.php");
?>


	<?
		include_once("./nav.php");
	?>

	<link rel="stylesheet" href="/css/boot_tab.css" type="text/css">
 
 <script>



	  </script>




 <div class="container-fluid">
	<?
		include_once("./sidebar_mypage.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">마이 플랜</h2>

          <div class="table-responsive">


		 
		    <div class="col-md-12" style="padding:0px;">
			  <div class="panel with-nav-tabs panel-info">
				<input type="hidden" name="tab_id" id="tab_id" value="<?=$tab_id?>">
			      <div class="panel-heading">
				    <ul class="nav nav-tabs">
				        <li class="active" ><a href="#tab1info" data-toggle="tab" id="tab1">해야할일</a></li>
				        <li ><a href="#tab2info" data-toggle="tab" id="tab2">종료된일</a></li>
				        <li ><a href="#tab3info" data-toggle="tab" id="tab3">캘린더보기</a></li>
		
				    </ul>
			      </div>
			      <div class="panel-body">
					<div class="tab-content">

						 <div class="tab-pane fade in active" id="tab1info"><!-- ###### tab1 START #####-->


						<div style="border:0px solid #ccc;padding:10px;" class="content_area">	
						</div>

						<div id="showmsg"></div>
		
						<button type="button" class="btn btn-default btn-sm"  data-toggle='modal' data-target='#myModal'  id="write_btn">
						  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
						</button>

						<button type="button" class="btn btn-default btn-sm"  id ="btn_move_btn" onclick="save()">순서변경</button>
			 

						 </div><!-- ###### tab1 END #####-->


						<div class="tab-pane fade" id="tab2info">
							<!-- <div style="border:2px solid #ccc;padding:10px;">	
							</div> -->

						<div id="pagination">
						<input type="text" name="rowcount" id="rowcount" value="5" />
						</div> 


						</div><!-- ###### tab2 END #####-->

						<div class="tab-pane fade" id="tab3info">


						  <div style="float:left;width:250px;margin-bottom:10px;">
							<span  style="float:left;">
								<select  id="at_year" name="at_year" style="width:120px;height:33px;border-radius:4px;padding-left:5px;">
										  <option value=''>-년도-</option>
										  <? 
												$thisYear = date("Y");
												for($i=1960;$i<2031; $i++){	
											 ?>
											 <option value="<?=$i?>" <? if($thisYear== $i)echo"selected"?> style="font-weight:bold;"><?=$i?></option>
											<? } ?>
										</select> -
										</span>
										<span  style="float:right;">
										<select   id="at_month" name="at_month" onchange="getAttdentCalendar()" style="width:120px;height:33px;border-radius:4px;padding-left:5px;">
										  <option value=''>-월-</option>
										  <? 
												$thisMon = date("m");
												for($ii=1;$ii<13; $ii++){	
												 $m = sprintf('%02d',$ii);
											 ?>
											 <option value="<?=$m?>" <? if($thisMon== $m)echo"selected"?> ><?=$ii?></option>
											<? } ?>
										</select>
									</span>
							</div>

						  <div class="ui-field-contain">
			
								 <table  width="100%" class="table-bordered" id="myTable">
									<col width="14.28%">
									<col width="14.28%">
									<col width="14.28%">
									<col width="14.28%">
									<col width="14.28%">
									<col width="14.28%">
									<col width="14.28%">
									<thead>
									<tr>
									<th  height=20 bgcolor="#ebebeb"><font color=red>일</font></th>
									<th  height=20 bgcolor="#ebebeb">월</th>
									<th  height=20 bgcolor="#ebebeb">화</th>
									<th  height=20 bgcolor="#ebebeb">수</th>
									<th  height=20 bgcolor="#ebebeb">목</th>
									<th  height=20 bgcolor="#ebebeb">금</th>
									<th  height=20 bgcolor="#ebebeb"><font color=blue>토</font></th>
									</tr>
									</thead>
									<tbody id='calendarLoad'>
									
									</tbody>
								</table>


						  </div>


						</div>


					 </div><!--tab-content end  -->



			      </div><!-- panel-body end -->
				  </div>
		        </div>
			
			
			</div> <!-- <div class="col-md-12"> -->

			</form>


		 
		 </div> <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


<?
	include_once("./footer.php");
?>
		<style>
			/* Style the tab content */
			.content_area{
				display: block;
				padding: 6px 0px;
				-webkit-animation: fadeEffect 1s;
				animation: fadeEffect 1s;
			}

			@-webkit-keyframes fadeEffect {
				from {opacity: 0;}
				to {opacity: 1;}
			}

			@keyframes fadeEffect {
				from {opacity: 0;}
				to {opacity: 1;}
			}

		</style>


<!-- Button trigger modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">MYPLAN INFO</h4>
      </div>
      <div class="modal-body">
		<form name="managerForm" id="managerForm" method="post" action="./manager_update.php" onSubmit="return fileSubmit(f)" enctype="multipart/form-data" >
		<input type="hidden" name="pn_id" id="pn_id" value="<?=$view['pn_id']?>" />
		<input type="hidden" name="mb_email_enabled"    value="" id="mb_email_enabled">
		<input type="hidden" name="oper"  id="oper" value="add" />

	<!-- table start -->

		<table  class="table table-bordered table-hover">
		<col width="20%">
		<col width="80%">
		<tr>
		<th>제목</th>
		<td>
		
		<div id="pop_edit_subject" style="display:none;">
			<input type="text" name="pn_subject" id="pn_subject" value="" class="form-control"  style="font-weight:bold;"/>
		</div>

		<div id="pop_view_subject" style="display:block;">
			<span id="pn_subject_view"></span>
		</div>

		<tr>
		<th>중요도</th>
		<td>

			<div id="pop_edit_grade" style="display:none;">
				<!-- <select class="selectpicker pn_grade_name" name="pn_grade" id="pn_grade">
				  <option value="">선택하세요</option>			
				  <option value="3">상</option>
				  <option value="2">중</option>
				  <option value="1">하</option>
				</select> -->
				<div class="btn-group" data-toggle="buttons">
				  <button type="button" class="btn btn-default" style="color:#ff0000;" name="grade_btn" id="grade_btn_3" value="3" onclick="grade_val_choice(this.value)">상</button>
				  <button type="button" class="btn btn-default" style="color:#0000ff;" name="grade_btn" id="grade_btn_2"  value="2" onclick="grade_val_choice(this.value)">중</button>
				  <button type="button" class="btn btn-default" style="color:#000000;" name="grade_btn" id="grade_btn_1"  value="1" onclick="grade_val_choice(this.value)">하</button>
				</div>
				<input type="hidden" name="pn_grade_val" id="pn_grade_val" value="">

			</div>

			<div id="pop_view_grade" style="display:block;">
				<span id="pn_grade_view"></span>
			</div>

		</td>
		</tr>		


		</td>
		</tr>
		<th>진행여부</th> 
		<td>

		<div id="pop_edit_endYn" style="display:none;">

				<div class="btn-group" data-toggle="buttons">
				  <button type="button" class="btn btn-default active" style="color:#ff0000;"  name="end_yn"  id="end_yn_N" value="N" onclick="end_yn_choice(this.value)">진행중</button>
				  <button type="button" class="btn btn-default" style="color:#0000ff;"  name="end_yn"  id="end_yn_Y" value="Y" onclick="end_yn_choice(this.value)">완료</button>
				</div><input type="hidden" name="pn_end_yn" id="pn_end_yn" value="N">
			<!-- <select class="selectpicker end_yn_name" name="pn_end_yn" id="pn_end_yn">
			  <option value="">선택하세요</option>			
			  <option value="N">진행중</option>
			  <option value="Y">완료</option>
			</select> -->
			</div>
			
			<div id="pop_view_endYn" style="display:block;">
			<span id="pn_end_yn_view"></span>
			</div>

		</td>
		</tr>
		<tr>
		<td colspan="2">  
		
		<div id="pop_edit_content" style="display:none;">
			<textarea  class="form-control" id="pn_content" name="pn_content" style="width:100%;height:160px;"></textarea>
		</div>

		<div id="pop_view_content" style="display:block;">
			<div id="pn_content_view" name="pn_content_view" style="width:100%;min-height:150px;"></div>
		</div>		

		<!--  -->
		</td>
		</tr>
		</tbody>
		</table>
	
<!-- table end -->

      </div>
      <div class="modal-footer">
		<div style="display:block;float:left;" id="del-btn">
        <button type="button" class="btn btn-danger" id ="btn_absent" onclick="pnSubmit('del')">삭제</button>
         </div>

		<div id="pop_view_btn_area" style="display:block;">
				<button type="button" class="btn btn-default"  id ="btn_manager_close" data-dismiss="modal">닫기</button>
				<button type="button" class="btn btn-default" id ="btn_edit" >수정하기</button>
		 </div>

		<div id="pop_edit_btn_area" style="display:none;">

				<button type="button" class="btn btn-default"  id ="btn_edit_cancle" >취소</button>
				<button type="button" class="btn btn-primary" id ="btn_absent" onclick="pnSubmit()">저장하기</button>
		 </div>


	  </div>
    </div>
  </div>
</div>	</form>
<!-- Button trigger modal -->




<script type="text/javascript">

/*
function toggle_layer() {
	if($("#layer").css("display") == "none"){
		$("#layer").show();
	}else{
		$("#layer").hide();
	}
}
*/

//	선택삭제

$(document).ready(function() {


   $('#my_plan').attr("class", "list-group-item active");


	$("#btn_edit" ).on('click',function() { 
		
		if($("#pop_view_btn_area").css("display") == "block"){

			$("#pop_edit_subject").css("display","block");
			$("#pop_view_subject").css("display","none");

			$("#pop_edit_btn_area").css("display","block");
			$("#pop_view_btn_area").css("display","none");
			
			$("#pop_edit_content").css("display","block");
			$("#pop_view_content").css("display","none");

			$("#pop_edit_grade").css("display","block");
			$("#pop_view_grade").css("display","none");

			$("#pop_edit_endYn").css("display","block");
			$("#pop_view_endYn").css("display","none");

		}
		
		/*
		else{

			$("#pop_edit_subject").css("display","none");
			$("#pop_view_subject").css("display","block");

			$("#pop_edit_btn_area").css("display","none");
			$("#pop_view_btn_area").css("display","block");
			
			$("#pop_edit_content").css("display","none");
			$("#pop_view_content").css("display","block");

			$("#pop_edit_grade").css("display","none");
			$("#pop_view_grade").css("display","block");

			$("#pop_edit_endYn").css("display","none");
			$("#pop_view_endYn").css("display","block");
			//$("#pop_view_area").css("display","block");

		}
		*/
	});


	$("#btn_edit_cancle" ).on('click',function() { 
		
			$("#pop_edit_subject").css("display","none");
			$("#pop_view_subject").css("display","block");

			$("#pop_edit_btn_area").css("display","none");
			$("#pop_view_btn_area").css("display","block");
			
			$("#pop_edit_content").css("display","none");
			$("#pop_view_content").css("display","block");

			$("#pop_edit_grade").css("display","none");
			$("#pop_view_grade").css("display","block");

			$("#pop_edit_endYn").css("display","none");
			$("#pop_view_endYn").css("display","block");


	});


	$("#btn_manager_close" ).on('click',function() { 

			$("#pop_edit_subject").css("display","none");
			$("#pop_view_subject").css("display","block");

			$("#pop_edit_btn_area").css("display","none");
			$("#pop_view_btn_area").css("display","block");
			
			$("#pop_edit_content").css("display","none");
			$("#pop_view_content").css("display","block");

			$("#pop_edit_grade").css("display","none");
			$("#pop_view_grade").css("display","block");

			$("#pop_edit_endYn").css("display","none");
			$("#pop_view_endYn").css("display","block");
		//$("#btn_edit" ).trigger();

	});


	$("#btn_manager_close" ).on('click',function() { 

			$("#pn_id" ).val('');
			$("#pn_id" ).val('');
			$("#oper" ).val('add');
			$("#pn_grade" ).val('');
			$("#pn_end_yn" ).val('');
			$("#pn_content" ).val('');
	});



	$("#write_btn" ).on('click',function() { 

			$("#pop_edit_subject").css("display","block");
			$("#pop_view_subject").css("display","none");

			$("#pop_edit_btn_area").css("display","none");
			$("#pop_view_btn_area").css("display","block");
			
			$("#pop_edit_content").css("display","block");
			$("#pop_view_content").css("display","none");

			$("#pop_edit_grade").css("display","block");
			$("#pop_view_grade").css("display","none");

			$("#pop_edit_endYn").css("display","block");
			$("#pop_view_endYn").css("display","none");
			
			$("#pn_id" ).val('');
			$("#oper" ).val('add');
			$("#pn_grade" ).val('');
			$("#pn_end_yn" ).val('');
			$("#pn_subject" ).val('');
			$("#pn_content" ).val('');
			$("#del-btn").css("display","none");

				$('.bootstrap-select.pn_grade_name .filter-option').text('선택하세요');
				$('.bootstrap-select.end_yn_name .filter-option').text('선택하세요');


			$("#pop_edit_btn_area").css("display","block");
			$("#pop_view_btn_area").css("display","none");
			$('#btn_edit_cancle').attr("data-dismiss","modal");  



	});


	$("#pn_grade" ).on('change',function() { 
		$("#pn_grade_val" ).val($(this).val());
	});


	$("#at_month" ).on('change',function() { 
		getMyPlanCalendar();
	});



});


	function  grade_val_choice(val){

		$('#grade_btn_1').attr("class", "btn btn-default");
		$('#grade_btn_2').attr("class", "btn btn-default");
		$('#grade_btn_3').attr("class", "btn btn-default");
		$("#pn_grade_val").val(val);
	}


	function  end_yn_choice(val){

		$('#end_yn_Y').attr("class", "btn btn-default");
		$('#end_yn_N').attr("class", "btn btn-default");
		$("#pn_end_yn").val(val);
	}


// 전체선택 / 해제
function checkFunction(){
    $('input:checkbox[name="check_all"]').change(function(){
        $('input:checkbox[name="chk_mb_no"]').each(function(){
            $(this).prop("checked",$('input:checkbox[name="check_all"]').prop("checked"));
        });
    })
}



//  선택삭제
function checkDel(){

   var oper = "check_del";
   
    // name이 같은 체크박스의 값들을 배열에 담는다.
    var checkboxValues = [];
    $("input[name='chk_mb_no']:checked").each(function(i) {
        checkboxValues.push($(this).val());
    });

	if(checkboxValues.length < 1){
	 alert('선택 된 항목이 없습니다.');
		return false;
	}
	//alert(checkboxValues);
     
    // 사용자 ID(문자열)와 체크박스 값들(배열)을 name/value 형태로 담는다.
    var allData = {
		oper : oper,
		checkArray : checkboxValues,
			};
     
		 if(confirm('한 번 삭제 된 항목은 복구가 불가합니다. \n 정말 삭제 하시겠습니까?'))
		 {
    $.ajax({
        url:"./ajax/ajax_myplan_update.php",
        type:'POST',
        data: allData,
        success:function(data){

			getresult('/admin/ajax/ajax_myplan_row_data.php');

        }

    });
		 }


}

// 캘린터 형태 출력
	function getMyPlanCalendar() {

		var  at_year = $("#at_year").val();
		var  at_month = $("#at_month").val();

		var param = "at_year="+at_year+"&at_month="+at_month;
		//console.log( "=====> param: "+ param );
		  $(".tblBody").remove();
		//  $("#ajax_list_data").remove();
		  $(".item_row").remove();

		$.ajax({
			url: "./ajax/ajax_myplan_calendar.php",
			type: "GET",
			data: param,
			success: function( data ){
				
				$("#calendarLoad").append( data );
				$('#myTable').table('refresh');
				
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Ajax failure');
			}
	   });
	}


getMyPlanCalendar(); // 캘린터 초기로딩


	function getPlanItem() {
	
		$(".content_area").empty();

		var param = "page=1";
		console.log( "=====> param: "+ param );
	
		
		$.ajax({
			url: "./ajax/ajax_myplan_row_load.php",
			type: "GET",
			data: param,
			success: function( data ){
				//console.log( "=====> data: "+ JSON.stringify(data) );
				
				$(".content_area").append( data );
				
				//$(".ajax_content_data").remove();
			//	if( data ) G_PAGE++;
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Ajax failure');
			}
	   });
	}



function editPlan(id){

	$('#myModal').modal('show');

	$('#grade_btn_1').attr("class", "btn btn-default");
	$('#grade_btn_2').attr("class", "btn btn-default");
	$('#grade_btn_3').attr("class", "btn btn-default");


	$('#end_yn_Y').attr("class", "btn btn-default");
	$('#end_yn_N').attr("class", "btn btn-default");


//	console.log('getCustOrder',id);
	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_myplan_load.php?pn_id=' + id;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
		//  contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩


			if(success) {

				var cell = response.rows;

				$("#pn_id").val(cell.pn_id);
				$("#pn_subject").val(cell.pn_subject);
				//$('#pn_grade').val(cell.pn_grade);
				$('#pn_content').val(cell.pn_content);
				$('#pn_end_yn').val(cell.pn_end_yn);

				$('#pn_grade_val').val(cell.pn_grade);


				var grade = cell.pn_grade;
				$('#grade_btn_'+ grade).attr("class", "btn btn-default active");


				var end_yn = cell.pn_end_yn;
				$('#end_yn_'+end_yn).attr("class", "btn btn-default active");

				$('.bootstrap-select.pn_grade_name .filter-option').text(cell.pn_grade_name);
				$('.bootstrap-select.end_yn_name .filter-option').text(cell.end_yn_name);

				//$('#co_id').val(cell.mb_1);pn_grade_view
				$('#pn_grade_view').html(cell.pn_grade_name);
				$('#pn_content_view').html(cell.pn_content_view);
				$("#pn_subject_view").html(cell.pn_subject);
				$("#pn_end_yn_view").html(cell.end_yn_name);

				$('#oper').val('edit');
				$("#del-btn").css("display","block");

				$('#btn_edit_cancle').removeAttr("data-dismiss","modal");  


			} else {
				alert('fail to load data');
			}
		}
	});
}



	 


//------------------------------------------------------------------> 담당자 정보업데이트
    function pnSubmit(oper){	

	var postData;
	var rows = Object();

	if(!oper){
	var oper = $('#oper').val();
	}


	var pn_id = $('#pn_id').val();
	var pn_subject = $('#pn_subject').val();

	var pn_end_yn = $('#pn_end_yn').val();
	var pn_content = $('#pn_content').val();

/*
	if( oper =='edit'){
	var pn_grade =  $('#pn_grade_val').val();// $('.bootstrap-select.pn_grade_name .filter-option').text();
	}else{
	var pn_grade =  $('#pn_grade').val();
	}
*/
	var pn_grade =  $('#pn_grade_val').val();

	if(pn_subject == ''){
		alert('제목은 필수입니다');
		$('#pn_subject').focus();
		return;
	}

if(oper !='del'){
	if(!pn_grade){
		alert('중요도는  필수입니다');
		return;
	}
}

		if(!pn_end_yn)var pn_end_yn = 'N';


	var rows= {

		oper : oper,
		pn_id : pn_id,
		pn_end_yn : pn_end_yn,
		pn_subject : pn_subject,
		pn_content : pn_content,
		pn_grade : pn_grade,

	};
	
	var postData = $.param(rows);
	var url = './ajax/ajax_myplan_update.php'//url 수정;
	
		
		if(oper=='del'){
		var msg ="선택된 데이터를 정말 삭제하시겠습니까?";
		}else if(oper=='edit'){
		var msg ="선택된 데이터를 정말 수정하시겠습니까?";
		
		}else if(oper=='add'){
		var msg ="작성 된 자료로 정말 입력하시겠습니까?";
		}


		 if(confirm(msg))
		 {
		
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
				var new_id = response.id;
				var msgs = response.msg2;

		//	get_member_row(); 

			 getPlanItem();
			$('#myModal').modal('hide');

			$("#pop_edit_subject").css("display","none");
			$("#pop_view_subject").css("display","block");

			$("#pop_edit_btn_area").css("display","none");
			$("#pop_view_btn_area").css("display","block");
			
			$("#pop_edit_content").css("display","none");
			$("#pop_view_content").css("display","block");

			$("#pop_edit_grade").css("display","none");
			$("#pop_view_grade").css("display","block");

			$("#pop_edit_endYn").css("display","none");
			$("#pop_view_endYn").css("display","block");

			$('#oper').val('add');


		//$("#btn_edit" ).trigger();

			}
		});

	return;
	}

} 

	getPlanItem();


function getresult(url) {

	//alert($("#cat1").val())

	$.ajax({
		url: url,
		type: "GET",
		data:{
			rowcount:$("#rowcount").val(),
			search_field:$("#search_field").val(),
			search_value:$("#search_value").val(),
			cat1:$("#cat1").val(),
			cat2:$("#cat2").val(),
			nowpage:$("#nowpage").val()
			},
		success: function(data){

		$("#pagination").html(data);
		},
		error: function() 
		{}
   });
}

getresult('/admin/ajax/ajax_myplan_row_data.php');

</script>

<?
	include_once("./tail.php");
?>
