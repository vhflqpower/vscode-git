<?
	include_once("../common.php");




	if($_GET['mb_no']){

	$mb_no = $_GET['mb_no'];

			$sql = "SELECT * FROM psj_member WHERE  mb_no = '$mb_no'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);

			$mb_id = $row['mb_id'];

		$oper = 'edit';
	}else{

			$sql = "SELECT * FROM psj_member WHERE  mb_no = '$member[mb_no]'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);
		
			$mb_id = $row['mb_id'];

		$oper = 'add';
		$view[bo_skin] = 'basic';
	}


	include_once("./head.php");
?>



<style>
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}
</style>
 
	<?
		include_once("./nav.php");
	?>
<link rel="stylesheet" href="/css/boot_tab.css" type="text/css">
 
	<!-- <link href="https://rawgithub.com/hayageek/jquery-upload-file/master/css/uploadfile.css" rel="stylesheet"> -->

	<link href="./css/uploadfile.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://rawgithub.com/hayageek/jquery-upload-file/master/js/jquery.uploadfile.min.js"></script>



 <div class="container-fluid">
	<?
		include_once("./sidebar_mypage.php");
	?>

       <div class="main" style="padding-right:20px;"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->
<? if($_GET['mb_no']){ ?>
          <h2 class="sub-header"><?=$row['mb_name']?></h2>
<? }else{ ?>
          <h2 class="sub-header">MY MEMO</h2>
<? } ?>

          <div class="table-responsive" >

		    <div class="col-md-12" style="padding:0px;">
			  <div class="panel with-nav-tabs panel-info">
				<input type="hidden" name="tab_id" id="tab_id" value="<?=$tab_id?>">
			      <div class="panel-heading">
				    <ul class="nav nav-tabs">
				        <li class="active" ><a href="#tab1info" data-toggle="tab" id="tab1">간단메모작성</a></li>
				        <li ><a href="#tab2info" data-toggle="tab" id="tab2">간단파일등록</a></li>
		
				    </ul>
			      </div>
			      <div class="panel-body">
				<div class="tab-content">

				 <div class="tab-pane fade in active" id="tab1info">


					<form name="frmComm" method="post" action=""  enctype="multipart/form-data" >
					<div id="add_content_form">
						<table class="table table-bordered " >
							<col width="15%">
							<col width="">
							<tbody>
								<tr>
								<!-- <th>내역</th> -->
								<td colspan="2">
									 <div style="border:0px solid red;">


										<div style="border:0px solid red;">	
											<input type="hidden" name="me_id"   id="me_id"  value="" />	
											<input type="hidden" name="mmode"   id="mmode"  value="add" />	
											<!-- <input type="text" id="co_subject" name="co_subject" value=""  placeholder="제목" class="form-control"> -->
											<textarea class="form-control" id="me_content" name="me_content" rows="4" ></textarea>
										</div>

										<div style="float:left;padding:6px;margin-top:0px;">
											<div style="margin-top:4px;margin-left:10px;">
												<select  name="search_ca_name" id="search_ca_name" style="width:152px;height:30px;border-radius:4px;">
												</select>
											</div>
										</div>

													<div style="float:right;padding:6px;margin-top:0px;border:0px solid red;">	
														<button type="button" class="btn btn-default btn-sm"  onclick="del_ca_name()">
														<span class="glyphicon glyphicon-remove" aria-hidden="true" ></span>삭제</button>
														
														<select  name="ca_name" id="ca_name" style="width:150px;height:30px;border-radius:4px;">
														</select>
														<input type="text" name="ca_name_new" id="ca_name_new"  value="" placeholder="분류추가" style="width:120px;height:30px;border-radius:4px;border:1px solid #ccc;padding:4px"/>
														<input type="checkbox" name="is_notice" id="is_notice" value="1">메인

															 <button type="button" class="btn btn-default btn-sm"  id="memoAddCancle">
															<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
															 <button type="button" class="btn btn-primary btn-sm"  onclick="memoSubmit()">
															<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>글쓰기</button>
														</div>

										</div>
								</td>
								</tr>
								</table>		
						</form>
					</div>


						<div id="pagination">
						<input type="hidden" name="rowcount" id="rowcount" value="" />
						</div> 


				     </div><!-- ###### tab1 END #####-->


				    <div class="tab-pane fade" id="tab2info">

						<div style="border:2px solid #ccc;padding:10px;">	

							<div id="fileuploader">Upload</div>
							<script>
							$(document).ready(function() {
								$("#fileuploader").uploadFile({
									url:"./multi_upload_server.php?bo_table=myfile&wr_id=<?=$member[mb_no]?>",
									fileName:"myfile"
								});
							});

							</script>

							  <div class="panel-body" id="disp_log_div" style="padding:5px;margin-left:10px;">
							</div>

						</div>
					</div><!-- ###### tab2 END #####-->

				</div>




			      </div>
			  </div>
		        </div>
			</div> <!-- <div class="col-md-12"> -->





			</form>



         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->




<?
	include_once("./footer.php");
?>

<script>
$(document).ready(function() {

   $('#my_memo').attr("class", "list-group-item active");
	 get_ca_name(); // 분류코드
	getresult('./ajax/ajax_my_memo_row_data.php');

	$("#search_ca_name").change(function(){
		//var ca_name =  $(this).val();
		getresult('./ajax/ajax_my_memo_row_data.php');
	});

	// 첨부파일 로딩
	getAddFiles(<?=$member[mb_no]?>);



});


	
// 로데이터 AJAX 로깅


function getresult(url) {


	$.ajax({
		url: url,
		type: "GET",
		data:{
			rowcount:$("#rowcount").val(),
			search_field:$("#search_field").val(),
			search_value:$("#search_value").val(),
			search_ca_name:$("#search_ca_name").val()
			},
		success: function(data){

		//	$("#pagination").html(data);
		$("#pagination").html(data);

		},
		error: function() 
		{}
   });
}



function memoSubmit(){	
	
	var mode = $("#mmode").val();
	var me_id = $("#me_id").val();
	var me_content = $("#me_content").val();
	var ca_name = $('.bootstrap-select.ca_name .filter-option').text();
	var ca_name_new = $("#ca_name_new").val();
	var is_notice = $("#is_notice").is(':checked') ? 1 : 0;

	//$('.bootstrap-select.levelname .filter-option').text(cell.levelname);


	if(!me_content) {
		$("#me_content").focus();
		alert('메모 사항은 필수입니다.');
		return;
	}


	var postData;
	var rows = Object();
	var rows= {
			mode  : mode,
			me_id : me_id,
			ca_name : ca_name,
			ca_name_new : ca_name_new,
			me_content  : me_content,
			is_notice : is_notice,

		};

	var postData = $.param(rows);

	$.ajax({
		url: "./ajax/ajax_memo_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {
				//location.reload();

				get_ca_name(); // 분류항목로드

			$("#me_content").val('');
			$("#ca_name_new").val('');
			// $(".comm_row").remove();

			getresult('./ajax/ajax_my_memo_row_data.php');


			}

		//location.replace();

		}
	});
	
	return false;
	
}





function get_ca_name(){
			  var pcode =  $("#MEMBER_AREA").val();

		      $.ajax
		      ({
		         type: "POST",
		         url: "./ajax/ajax_memo_ca_name_load.php",
		         data: "pcode="+pcode,
		         dataType: 'json',
		         success: function(option)
		         {
		        	// console.log( "=====> option: "+ JSON.stringify(option) );
		        	// console.log( "=====> 7: "+ option["7"] );
		        
					 $("#ca_name").empty();
					 $("#search_ca_name").empty();
		        	 var str = "<option value=''>분류선택</option>";
		        	 $("#ca_name").append(str);
		        	 $("#search_ca_name").append(str);
		        	
		        	 $.each( option, function( idx, val ){
		        		 
		        		// if(idx ==area_cd){ var sel ="selected";}else{ var sel ="";}  "+sel+"
		        		 
		        		 var str = "<option value='"+idx+"' >"+val+"</option>";
		        		 $("#ca_name").append(str);
		        		 $("#search_ca_name").append(str);
		        		 
		        	 });
		           	 
		        	 //$("#MEMBER_AREA2").html(option);
				  
				 }

		      });
		  

				  return false;
}



 
function del_ca_name(id){	

	var ca_name = $("#ca_name").val();//$('.bootstrap-select.ca_name .filter-option').text();
	
	if(!ca_name) {
		alert('선택 된 항목이 없습니다.');
		return;
	}
	var postData;
	var rows = Object();
	var rows= {

			mode  : 'ca_del',
			ca_name  : ca_name,

		};
	var postData = $.param(rows);

		if (confirm('정말로 삭제하시겠습니까?'))
		{
	$.ajax({
		url: "./ajax/ajax_memo_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {
				//location.reload();
			 get_ca_name(); // 분류코드로드
			getresult('./ajax/ajax_my_memo_row_data.php?page=<?=$page?>');
			}


		}
	});

	
		return false;
		}

			return false;
}





function getAddFiles(id) {

	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_get_file_data.php?bo_table=myfile&wr_id=' + id;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
		cache:false,
		async:false,
		success:function(response) {
		var success = (response.flag == 'succ');
		var message = response.cell;

		if(success) {

			$.each(message,function(key,val){
				var content = "<ul style='margin:0px;padding-left:5px;'><li style='display:block;padding:5px;'><span id='disp_cnt'></span><a href=\"./download.php?bo_table="+val.bo_table+"&bf_file="+val.bf_file+"&bf_source="+val.bf_source+"&seq="+val.seq+" \">"+val.bf_source+" ("+val.bf_filesize+")</a> <a href='#1' onclick=\"addFileDel("+val.seq+")\">[D]</a></li>"
				+"</ul>";

				var disp_log_list = $('#disp_log_div').append(content);

			});

			} else {
				alert('fail to load daa');
			}
		}
	});
}



function addFileDel(seq) {
 
	var postData;
	var rows = Object();

	var rows= {
		oper : 'del',
		bo_table : 'data',
		seq : seq,

	};
	
	var postData = $.param(rows);
	var url = './ajax/ajax_addFile_del_server.php'//url 수정;
	
	var msg = '파일을 정말 삭제하시겠습니까222?';
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
				var new_id = response.id;
				var msgs = response.msg2;

	if(success) {
	
				 $(".panel-body ul").remove();
			    getAddFiles(<?=$member[mb_no]?>);

			}


			}
		});
	}


	return false;

} 

/*
function onTab(){
	$("#tab2").trigger("click");

}

function removeFileUl(){
	 $(".panel-body ul").remove();
}
*/

</script>

<?
	include_once("./tail.php");
?>
