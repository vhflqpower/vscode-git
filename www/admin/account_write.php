<?
	include_once("../common.php");

	$wr_id = $_GET['wr_id'];


	if($wr_id){

			$sql = "SELECT * FROM psj_account WHERE  wr_id = '$wr_id'";
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

          <h2 class="sub-header">계정 정보</h2>

          <div class="table-responsive">
			<!-- <form name="frm" method="post" action="./account_update.php" onSubmit="return fwrite_submit(f)" enctype="multipart/form-data" > -->
	 <form name="fwrite" id="fwrite" action="./account_update.php" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">

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
					<th>업체</th>
					<td>
					<select class="selectpicker company" name="search_company" id="search_company">
						<option value="">선택하세요</option>			
					<?
						$arr_company =  select_company();
						foreach($arr_company as $key => $val){
					?> 
					  <option value="<?=$key?>" <?if($key==$row['co_id'])echo"selected"?>><?=$val?></option>
					  <? } ?>
					</select>
					</td>
					</tr>
					<tr>
					<th>제목</th>
					<td><input type="text" name="wr_subject" value="<?=$row['wr_subject']?>" class="form-control" /></td>
					</tr>
					<tr>
					<th>SORT</th>
					<td><input type="text" name="wr_sort" value="<?=$row['wr_sort']?>" class="form-control" style="width:50px;" /></td>
					</tr>
					<tr>
					<td colspan="2">

					  <div class="form-group">
						<label for="wr_content">Example textarea</label>
						<textarea class="form-control" id="wr_content" name="wr_content" rows="10"><?=$row['wr_content']?></textarea>
					  </div>


					</td>
					</tr>

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
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./account_list.php?part=account'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./account_view.php?wr_id=<?=$row['wr_id']?>&part=account'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>보 기
			</button>			

			<button type="button" class="btn btn-primary btn-sm" onclick="fwrite_submit();">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>
</div>




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


    //var bo_table_enabled = $("#bo_table_enabled").val();



    function fwrite_submit()
    {
		var f = document.fwrite;


			if(f.wr_subject.value==''){
			alert('제목은 필수입니다..');
			return;
			}
/*
		 if(oper=='add'){
			if(bo_table_enabled=='130'){
			alert('사용할 수 없는 TABLE CODE입니다.');
			return;
			}
		 }
*/
		if (confirm('저장하시겠습니까?'))
		{
		f.submit();
		return false;
		}

	}







$(document).ready(function() {
	//$("#btn_search").trigger("click");
	get_member_row()

});




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
