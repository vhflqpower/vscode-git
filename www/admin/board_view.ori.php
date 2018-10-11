<?
	include_once("../common.php");

	$wr_id = $_GET['wr_id'];


	if($wr_id){

			$sql = "SELECT * FROM psj_board WHERE  wr_id = '$wr_id'";
			$result = sql_query($sql);
			$view = sql_fetch_array($result);

			$html = 0;
			if (strstr($view['wr_option'], 'html1')){
				$html = 1;

			}else if (strstr($view['wr_option'], 'html2')){
				$html = 2;
			}

			$str_content = url_auto_link($view['wr_content']);
		//	$view['content'] = conv_content($view['wr_content'], $html);


			if (strstr($sfl, 'content')){
				$view['content'] = search_font($stx, $view['content']);

			function conv_rich_content($matches)
			{
				global $view;
				return view_image($view, $matches[1], $matches[2]);

			}
			$view['rich_content'] = preg_replace_callback("/{이미지\:([0-9]+)[:]?([^}]*)}/i", "conv_rich_content", $view['content']);
			}

		$oper = 'edit';
	}else{

		$oper = 'add';
		$view[bo_skin] = 'basic';
	}


	include_once("./head.php");
?>
	<style>
	@import url(//fonts.googleapis.com/earlyaccess/notosanskannada.css);
	font-family: 'Noto Sans Kannada', sans-serif;
	</style>
	<?
		include_once("./nav.php");
	?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h3 class="sub-header"><?=$view['wr_subject']?></h3>

          <div class="table-responsive">
			<form name="frm" method="post" action="./board_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled">
			<!-- table-hover -->

			<table class="table table-bordered ">
			<!-- <table  class="table table-bordered table-hover"> -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<th>DATE</th>
					<td>
					<?=$view['wr_datetime']?></td>
					</tr>
					<tr>
				
					<tr>
					<td colspan="2">
					<div style="padding:10px;"><?echo $str_content;?></div>
					</td>
					</tr>

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

							<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./board_list.php?part=info'">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
							</button>
							
							<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./board_write.php?wr_id=<?=$view[wr_id]?>&part=info'">
							  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정
							</button>


				</div>
		
			</form>
			</br></br></br></br>



         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


<?
	include_once("./footer.php");
?>


	<form name="fdel" method="post" action="./board_update.php">
	<input type="hidden" name="bo_table" value="<?=$_GET['part']?>" />
	<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
	<input type="hidden" name="oper" value="del" />
	</form>



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


	 if(oper=='add'){
		if(bo_table_enabled=='130'){
		alert('사용할 수 없는 TABLE CODE입니다.');
		return;
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
