<?
	include_once("../common.php");

	$wr_id = $_GET['wr_id'];


	if($wr_id){

		$sql = "SELECT * FROM psj_account WHERE  wr_id = '$wr_id'";
		$result = sql_query($sql);
		$row = sql_fetch_array($result);

		$oper = 'edit';
		$view['content'] = conv_content($row['wr_content'], $html=0);

	}else{

		$oper = 'add';
		$row[bo_skin] = 'basic';
	}


	include_once("./head.php");
?>
 
	<?
		include_once("./nav.php");
	?>
  <style>
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,1); /* Black w/ opacity */
        }
    
        /* Modal Content/Box */

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
          /*  width: 30%;    */          
        }
/*
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;              
        }
 */
</style>


 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header"><?=$row['wr_subject']?></h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./account_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="wr_id" value="<?=$row['wr_id']?>" />
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
					<th>DATE</th>
					<td><?=$row['wr_datetime']?></td>
					</tr>
					<tr>
					<th>업체명</th>
					<td><strong><?		
					$co_id = $row['co_id'];
					$arr_company = select_company();
					$company = $arr_company[$co_id];
					echo $company;
					?></strong></td>
					</tr>
					<tr>
					<td colspan="2">
					<div style="padding:10px;"><?echo $view['content'];?></div>
					</td>
					</tr>

				</tbody>
			</table>

<div style="float:left">
		<?if($row['wr_id']){ ?>
					<button type="button" class="btn btn-danger btn-sm" onclick="del()">
					  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
					</button>

			<button type="button" class="btn btn-primary btn-sm"  data-toggle='modal' data-target='#myModal'  id="popup_btn">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>팝업
			</button>

		<? } ?>			

</div>



<div style="float:right">
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./account_list.php?part=account'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./account_write.php?wr_id=<?=$row[wr_id]?>&part=account'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정
			</button>

			


</div>

		<div style="height:70px;"></div>	

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
		
  $("#popup_btn").trigger("click");

    // $('#myModal').show();

});



        //팝업 Close 기능
        function close_pop(flag) {
             $('#myModal').hide();
        };
        


</script>


<!-- Button trigger modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">비밀번호입력</h4>
      </div>
      <div class="modal-body">
	<form name="fileForm" id="fileForm" method="post" action="./dataroom_write_server.php" onSubmit="return fileSubmit(f)" enctype="multipart/form-data" >
	<input type="hidden" name="seq"   id="seq"  value="<?=$view['seq']?>" />	
	<input type="hidden" name="wr_id" id="wr_id" value="<?=$view['wr_id']?>" />
	<input type="hidden" name="ori_bo_table"  id="ori_bo_table" value="" />
	<input type="hidden" name="oper"  id="oper" value="add" />

	<!-- table start -->
		<table  class="table table-bordered table-hover">
		<col width="20%">
		<col width="80%">
		<tr>
		<th>비밀번호</th>
		<td>
		<input type="text" id="mb_name" name="mb_name" value="<?=$row['mb_name']?>" class="form-control" style="width:200px;" />	
		</td>
		</tr>
		</tbody>
		</table>
<!-- table end -->
	
      </div>
      <div class="modal-footer">
   <div style="display:none;float:left;" id="del-btn">
        <button type="button" class="btn btn-danger" id ="btn_absent" onclick="filedelSubmit()">삭제</button>
         </div>
		<button type="button" class="btn btn-default"  id ="btn_absent_close" data-dismiss="modal" onclick="history.back();">닫기</button>
		<button type="button" class="btn btn-default"  id ="btn_absent_close" data-dismiss="modal">확인</button>
        <!-- <button type="button" class="btn btn-primary" id ="btn_absent" onclick="fileSubmit()">저장하기</button> -->
      </div>
    </div>
  </div>
</div>	</form>
<!-- Button trigger modal -->







<script type="text/javascript">


//------------------------------------------------------------------> 코멘트업데이트
function memoSubmit() {
 
	var postData;
	var rows = Object();

	var oper = $('#oper').val();

	var wr_id = $('#wr_id').val();
	var wr_content = $('#wr_content').val();


	if ( $("#wr_is_notice").is(":checked") == true ){
	var wr_is_notice ='1';
	}else{
	var wr_is_notice ='';
	}


		
	if(wr_content == ''){
		alert('내용은 필수입니다');
		$('#wr_content').focus();
		return;
	}


	var rows= {

		oper : oper,
		wr_id : wr_id,
		wr_content : wr_content,
		wr_is_notice : wr_is_notice,

	};
	
	var postData = $.param(rows);
	var url = './ajax_memo_server.php'//url 수정;
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
			
			$('#wr_id').val();
			$('#wr_content').val('');

				write_form_reset()

			$("#btn_search").trigger("click");
			}
		});

	return;

} 





function memoEdit(id) {



		$("#comment_write").css("display","block"); 

		$("input:checkbox[name='wr_is_notice']").attr('checked', false);	
		$('#wr_is_notice_view').val('');

//	console.log('getCustOrder',id);
	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax_memo_load.php?id=' + id;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
       contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩
			if(success) {
				var cell3 = response.rows;


				$('#wr_id').val(cell3.wr_id);
				$('#wr_content').val(cell3.wr_content);
				

				var val = cell3.wr_is_notice;

				if(cell3.wr_is_notice==1){
					
					//$("input[id=wr_is_notice][value=" + val + "]").attr("checked", true);
					//$("input:checkbox[name='wr_is_notice']").attr("checked", true);	
					
					$('input:checkbox[id="wr_is_notice"]').attr("checked", true); 


					$('#wr_is_notice_view').val('공지사항');

				}
				
				
				} else {
				alert('fail to load data');
			}
		}
	});
}




function memoNew(id) {

	$('#oper').val('write');
	$('#wr_id').val('');
	$('#wr_content').val('');


}


//------------------------------------------------------------------> 코멘트삭제
function memoDelete(id) {
 
	var postData;
	var rows = Object();

	var oper = 'del';
	var wr_id = id;

	var rows= {
		oper : oper,
		wr_id : wr_id,

	};
	
	var postData = $.param(rows);
	var url = './ajax_memo_del_server.php'//url 수정;
	
	var msg = '메모를 정말 삭제하시겠습니까?';
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


				$('#oper').val('del');
				$('#wr_id').val();
				$('#wr_content').val('');

				$("#btn_search").trigger("click");

			}
		});
	}

	return;

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
