<?
	include_once("../common.php");


	$me_code = $_GET['me_code'];

	if($me_code){
			$sql = "SELECT * FROM psj_menu_config WHERE  me_code = '$me_code'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);


		$oper = 'edit';
	}else{

		$oper = 'add';
		$row[me_skin] = 'basic';
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

          <h2 class="sub-header">메뉴 목록</h2>

          <div class="table-responsive">
    

    <form name="fwrite" id="fwrite" action="./menu_update.php" onsubmit="return saveSubmit(this);" method="post" enctype="multipart/form-data" autocomplete="off">

				<input type="hidden" name="me_code" value="<?=$row['me_code']?>" />
				<input type="hidden" id="oper" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="me_table_enabled"    value="" id="me_table_enabled">
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered table-hover">
				<caption>테이블 설명</caption>
				<col width="15%">
				<col width="">
				<tbody>

				<? if($row['me_code']){ ?>
					<th>MENU CODE</th>
					<td><input type="text" id="me_code" name="me_code" value="<?=$row['me_code']?>" class="form-control" style="width:200px;" READONLY/></td>
					</tr>
				<? }else{ ?>
					<th>MENU CODE</th>
					<td><input type="text" id="me_code" name="me_code" value="<?=$row['me_code']?>"  id="reg_me_table" onblur='reg_mb_cd_check();' class="form-control" style="width:200px;" />
					<span id='msg_me_table'></span>
					</td>
					</tr>
				<? } ?>

					<th>제목</th>
					<td><input type="text" id="me_subject" name="me_subject" value="<?=$row['me_subject']?>" class="form-control" style="width:200px;" /></td>
					</tr>


					<tr>
					<th>카테고리</th>
					<td>
						<input type="text" name="me_category_list" value="<?=$row['me_category_list']?>" class="form-control" style="width:80%;" />
					</td>
					</tr>
					

					<tr>
					<th>카테고리타입</th>
					<td>
					<select name='me_cate_type' required itemname="카테고리타입" class="form-control" style="width:150px">
					<option value="none" <?if($row['me_cate_type']=='none')echo"selected"?>>사용안함</option>
					<option value="selectbox" <?if($row['me_cate_type']=='selectbox')echo"selected"?>>셀렉트박스</option>
					<option value="inline" <?if($row['me_cate_type']=='inline')echo"selected"?>>인라인</option>
					</select> 
					</td>
					</tr>

					<tr>
						<th>멀티업로더사용</th>
						<td>
							<select name='me_use_multiupload' required itemname="멀티업로더" class="form-control" style="width:150px">
								<option value="N" <?if($row['me_subject']=='N')echo"selected"?>>미사용</option>
								<option value="Y" <?if($row['me_subject']=='Y')echo"selected"?>>사용</option>
							</select> 
						</td>
					</tr>


					<tr>
					<th>글목록권한</th>
					<td>
					<select name='me_list_level' id="me_list_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['me_list_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['me_list_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['me_list_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['me_list_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['me_list_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['me_list_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['me_list_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['me_list_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['me_list_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['me_list_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>글보기권한</th>
					<td>
					<select name='me_read_level' id="me_read_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['me_read_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['me_read_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['me_read_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['me_read_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['me_read_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['me_read_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['me_read_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['me_read_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['me_read_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['me_read_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>글쓰기권한</th>
					<td>
					<select name='me_write_level' id="me_write_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['me_write_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['me_write_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['me_write_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['me_write_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['me_write_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['me_write_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['me_write_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['me_write_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['me_write_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['me_write_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>
					<tr>
					<th>답변권한</th>
					<td>
					<select name='me_comment_level' id="me_comment_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['me_comment_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['me_comment_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['me_comment_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['me_comment_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['me_comment_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['me_comment_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['me_comment_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['me_comment_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['me_comment_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['me_comment_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>
					<tr>
						<th>라디오</th>
						<td>
							<label class="radio-inline">
								<input type="radio" id="me_skin" name="me_skin" value="blackboard">
								<span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span>
							</label>
							<label class="radio-inline">
								<input type="radio" id="me_skin" name="me_skin" value="bell">
								  <span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_skin" name="me_skin" value="user">
								  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_skin" name="me_skin" value="home">
								  <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_skin" name="me_skin" value="lock">
								  <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_skin" name="me_skin" value="list-alt">
								  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_skin" name="me_skin" value="floppy-disk">
								  <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_skin" name="me_skin" value="book">
								  <span class="glyphicon glyphicon-book" aria-hidden="true"></span>
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_skin" name="me_skin" value="cog">
								  <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_skin" name="me_skin" value="th-list">
								  <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
								</label>
							</td>
					</tr>
					<tr>
						<th>리스트갯수</th>
						<td>
							<label class="radio-inline">
								<input type="radio" id="me_list_cnt" name="me_list_cnt" value="10">
									10
							</label>
							<label class="radio-inline">
								<input type="radio" id="me_list_cnt" name="me_list_cnt" value="20">
									20
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_list_cnt" name="me_list_cnt" value="30">
								  30
								</label>
								<label class="radio-inline">
								  <input type="radio" id="me_list_cnt" name="me_list_cnt" value="50">
								  50
								</label>
							</td>
					</tr>
					<tr>
					<th>노출여부</th>
					<td>
						<input type="text" name="me_sort" value="<?=$row['me_sort']?>" class="form-control" style="width:10%;" />		
					</td>
					</tr>

				</tbody>
			</table>

	<div style="float:left">
		<?if($row['me_table']){ ?>
					<button type="button" class="btn btn-danger btn-sm" onclick="del()">
					  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
					</button>
		<? } ?>			

	</div>


	<div style="float:right">
	
			
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./menu_list.php?me_table=<?=$me_table?>&part=menus'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			
			<button type="submit" class="btn btn-primary btn-sm" >
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




function saveSubmit() {
	

	var me_code = $("#me_code").val();
	var me_subject = $("#me_subject").val();
	var oper = $("#oper").val();


if(oper=='add'){

	if(me_code == ''){
		alert("메뉴 코드를 입력해주세요.");
		$('#me_code').focus();
		return false;
	}
	if(me_subject == ''){
		alert("제목을 입력해주세요.");
		$('#me_subject').focus();
		return false;
	}
}



	if (confirm('저장하시겠습니까?'))
	{
		document.fwrite.submit();
	return false;
	}else{

	return false;
	}







}












 	var me_table_enabled = $("#me_table_enabled").val();



    function fwrite_submit(f)
    {

	 if(oper=='add'){
		if(me_table_enabled=='130'){
		alert('사용할 수 없는 TABLE CODE입니다.');
		return;
		}

	 }


	alert(f)

	}



$(document).ready(function() {
	//$("#btn_search").trigger("click");
	get_member_row()

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


var reg_mb_cd_check = function() {

	var member_skin_path = './ajax';

    $.ajax({ 
        type: 'POST',
        url: member_skin_path+'/ajax_me_table_check.php',
        data: {
            'me_table': encodeURIComponent($('#reg_me_table').val())
        },
        cache: false,
        async: false,
        success: function(result) {
            var msg = $('#msg_me_table');
            switch(result) {
                case '110' : msg.html('영문자, 숫자, _ 만 입력하세요.').css('color', 'red'); break;
                case '120' : msg.html('최소 4자이상 입력하세요.').css('color', 'red'); break;
                case '130' : msg.html('이미 사용중인 코드.').css('color', 'red'); break;
                case '140' : msg.html('예약어로 사용할 수 없는 아이디 입니다.').css('color', 'red'); break;
                case '000' : msg.html('사용가능 코드.').css('color', 'blue'); break;
                default : alert( '잘못된 접근입니다.\n\n' + result ); break;
            }
            $('#me_table_enabled').val(result);
        }
    });
}






</script>
<div style="height:70px;"></div>
<?
	include_once("./tail.php");
?>
