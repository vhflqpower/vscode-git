<?
	include_once("../common.php");

	$mb_no = $_GET['mb_no'];


	if($mb_no){

			$sql = "SELECT * FROM psj_member WHERE  mb_no = '$mb_no'";
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

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">회원 수정</h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./member_update.php" enctype="multipart/form-data" >
				<input type="hidden" name="mb_no" value="<?=$row['mb_no']?>" />
				<input type="hidden" name="oper" id="oper" value="<?=$oper?>" />
				<input type="hidden" name="mb_id_enabled"    value="" id="mb_id_enabled">
				<input type="hidden" name="mb_email_enabled"    value="" id="mb_email_enabled">
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered"><!--  table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<tr>
				<? if($row['mb_id']){ ?>
					<th>아이디</th>
					<td><input type="text" name="mb_id" value="<?=$row['mb_id']?>" class="form-control" style="width:200px;" READONLY/></td>
					</tr>
				<? }else{ ?>
					<th>아이디</th>
					<td><input type="text" name="mb_id" value="<?=$row['mb_id']?>"  id="reg_mb_id" onblur='reg_mb_cd_check();' class="form-control" style="width:200px;" />
					<span id='msg_mb_id'></span>
					</td>
					</tr>
				<? } ?>
					
					<tr>
					<th>비밀번호</th>
					<td><input type="password" id="mb_password" name="mb_password" value="" class="form-control" style="width:200px;" /></td>
					</tr>

					<tr>
					<th>비밀번호확인</th>
					<td><input type="password" id="mb_password_re" name="mb_password_re" value="" class="form-control" style="width:200px;" /></td>
					</tr>

					<tr>
				<? if($row['mb_email']){ ?>
					<th>E-mail</th>
					<td><input type="text" name="mb_email" value="<?=$row['mb_email']?>" class="form-control" style="width:300px;" READONLY/>
					</td>
					</tr>
				<? }else{ ?>
					<th>E-mail</th>
					<td><input type="text" name="mb_email" value="<?=$row['mb_email']?>"  id="reg_mb_email" onblur='reg_mb_email_check();' class="form-control" style="width:300px;" />
					<span id='msg_mb_email' style="color:#ffff00;"></span>
					</td>
					</tr>
				<? } ?>

					<tr>
					<th>회원명</th>
					<td><input type="text" id="mb_name" name="mb_name" value="<?=$row['mb_name']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>
					<th>생년월일</th>
					<td>
					<div class="input-group date" style="width:200px;">
						<input type="text" name="mb_birth"  value="<?=$row['mb_birth']?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					 </div></td>
					</tr>

					<tr>
					<th>회원레벨</th>
					<td>
						<select name='mb_level' id="mb_level" required itemname="회원레벨" class="form-control" style="width:150px">
						<option value="1" <?if($row['mb_level']=='1')echo"selected"?>>1</option>
						<option value="2" <?if($row['mb_level']=='2')echo"selected"?>>2</option>
						<option value="3" <?if($row['mb_level']=='3')echo"selected"?>>3</option>
						<option value="4" <?if($row['mb_level']=='4')echo"selected"?>>4</option>
						<option value="5" <?if($row['mb_level']=='5')echo"selected"?>>5</option>
						<option value="6" <?if($row['mb_level']=='6')echo"selected"?>>6</option>
						<option value="7" <?if($row['mb_level']=='7')echo"selected"?>>7</option>
						<option value="8" <?if($row['mb_level']=='8')echo"selected"?>>8</option>
						<option value="9" <?if($row['mb_level']=='9')echo"selected"?>>9</option>
						<option value="10" <?if($row['mb_level']=='10')echo"selected"?>>10</option>
						</select> 
					</td>
					</tr>
						
					<tr>
					<th>접근제한일</th>
					<td>
					<div class="input-group date" style="width:200px;">
						<input type="text" name="mb_intercept_date"  value="<?=$row['mb_intercept_date']?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					 </div></td>
					</tr>

					<tr>
					<tr>
					<th>메모</th>
					<td>

					  <div class="form-group">
						<label for="mb_memo">메모</label>
						<textarea class="form-control" id="mb_memo" name="mb_memo" rows="10"><?=$row['mb_memo']?></textarea>
					  </div>


					</td>
					</tr>

				</tbody>
			</table>

		<div align="right">
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./member_list.php?part=mem'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			
			<button type="button" onclick="saveSubmit()" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>
		</div>
			</form>
	<div style="height:70px;"></div>


         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


<?
	include_once("./footer.php");
?>


<script type="text/javascript">


$(document).ready(function() {
	//$("#btn_search").trigger("click");
	//get_member_row()

});


	  $(function(){

			$('.input-group.date').datepicker({

				calendarWeeks: false,
				todayHighlight: true,
				autoclose: true,
				format: "yyyy/mm/dd",
				language: "kr"

			});

		});


//------------------------------------------------------------------> 코멘트업데이트
function memoSubmit() {
 
	var postData;
	var rows = Object();

	var oper = $('#oper').val();

	var mb_no = $('#mb_no').val();
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
		mb_no : mb_no,
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
			
			$('#mb_no').val();
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


				$('#mb_no').val(cell3.mb_no);
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
	$('#mb_no').val('');
	$('#wr_content').val('');


}


//------------------------------------------------------------------> 코멘트삭제
function memoDelete(id) {
 
	var postData;
	var rows = Object();

	var oper = 'del';
	var mb_no = id;

	var rows= {
		oper : oper,
		mb_no : mb_no,

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
				$('#mb_no').val();
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

			$("#mb_no").val('');
			$("#wr_is_notice").val('');
			$("#wr_is_notice_view").val('');
			$("#wr_content").val('');
}


	function viewWriteForm() {

			$("#mb_no").val('');
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


// id 유일성검사
var reg_mb_cd_check = function() {

	var member_skin_path = './ajax';

    $.ajax({ 
        type: 'POST',
        url: member_skin_path+'/ajax_mb_id_check.php',
        data: {
            'mb_id': encodeURIComponent($('#reg_mb_id').val())
        },
        cache: false,
        async: false,
        success: function(result) {
            var msg = $('#msg_mb_id');
            switch(result) {
                case '110' : msg.html('영문자, 숫자, _ 만 입력하세요.').css('color', 'red'); break;
                case '120' : msg.html('최소 4자이상 입력하세요.').css('color', 'red'); break;
                case '130' : msg.html('이미 사용중인 코드.').css('color', 'red'); break;
                case '140' : msg.html('예약어로 사용할 수 없는 아이디 입니다.').css('color', 'red'); break;
                case '000' : msg.html('사용가능 코드.').css('color', 'blue'); break;
                default : alert( '잘못된 접근입니다.\n\n' + result ); break;
            }
            $('#mb_id_enabled').val(result);
        }
    });
}





//var reg_mb_email_check = function() {
  
function reg_mb_email_check(){
	
	var result = "";
    $.ajax({
        type: "POST",
        url: "./ajax/ajax.mb_email.php",
        data: {
            "reg_mb_email": $("#reg_mb_email").val(),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(result) {

            var msg = $('#msg_mb_email');
            switch(result) {
                case '110000' : msg.html('E-mail 주소가 형식에 맞지 않습니다.').css('color', 'red'); break;
                case '120110130000' : msg.html('E-mail 주소를 입력해 주십시오.').css('color', 'red'); break;
                case '130000' : msg.html('이미 사용중인 코드.').css('color', 'red'); break;
                case '140000' : msg.html('해당 도메인 메일은 사용할 수 없습니다.').css('color', 'red'); break;
                case '000' : msg.html('사용가능 코드.').css('color', 'blue'); break;
            }
			$('#mb_email_enabled').val(result);

		//$("#msg_mb_email").html(data);
		// alert(data);return false;
		//	result = data;
        
		}
    });
}

function saveSubmit() {
	

	var check_email = $("#mb_email_enabled").val();
	var check_id = $("#mb_id_enabled").val();

	var oper = $("#oper").val();
	

if(oper=='add'){
	if(check_id != "000"){
		alert("ID를 확인해주세요.");
		$('#reg_mb_id').focus();
		return false;
	}

	if(check_email != "000"){
		alert("E-MAIL를 확인해주세요.");
		$('#reg_mb_email').focus();
		return false;
	}
}


	document.frm.submit();
}





</script>

<?
	include_once("./tail.php");
?>
