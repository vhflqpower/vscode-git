<?
	include_once("../common.php");


	$bo_table = $_GET['bo_table'];

	if($bo_table){
			$sql = "SELECT * FROM psj_board_config WHERE  bo_table = '$bo_table'";
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

          <h2 class="sub-header">게시판 목록</h2>

          <div class="table-responsive">
    

    <form name="fwrite" id="fwrite" action="./bbs_update.php" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">

				<input type="hidden" name="bo_table" value="<?=$row['bo_table']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled">
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered table-hover">
				<caption>테이블 설명</caption>
				<col width="15%">
				<col width="">
				<tbody>

				<? if($row['bo_table']){ ?>
					<th>TABLE</th>
					<td><input type="text" name="bo_table" value="<?=$row['bo_table']?>" class="form-control" style="width:200px;" READONLY/></td>
					</tr>
				<? }else{ ?>
					<th>TABLE</th>
					<td><input type="text" name="bo_table" value="<?=$row['bo_table']?>"  id="reg_bo_table" onblur='reg_mb_cd_check();' class="form-control" style="width:200px;" />
					<span id='msg_bo_table'></span>
					</td>
					</tr>
				<? } ?>

					<th>제목</th>
					<td><input type="text" name="bo_subject" value="<?=$row['bo_subject']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>
					<th>스킨</th>
					<td>
					<select name=bo_skin required itemname="스킨 디렉토리" class="form-control" style="width:150px">
					<?
					 $arr = get_skin_dir();

					for ($i=0; $i<count($arr); $i++) {
						echo "<option value='$arr[$i]'>$arr[$i]</option>\n";
					}
					?></select> 
					<script type="text/javascript">document.fwrite.bo_skin.value="<?=$row[bo_skin]?>";</script>
					</td>
					</tr>

					<tr>
					<th>카테고리</th>
					<td>
						<input type="text" name="bo_category_list" value="<?=$row['bo_category_list']?>" class="form-control" style="width:80%;" />
					</td>
					</tr>
					

					<tr>
					<th>카테고리타입</th>
					<td>
					<select name='bo_cate_type' required itemname="카테고리타입" class="form-control" style="width:150px">
					<option value="none" <?if($row['bo_cate_type']=='none')echo"selected"?>>사용안함</option>
					<option value="selectbox" <?if($row['bo_cate_type']=='selectbox')echo"selected"?>>셀렉트박스</option>
					<option value="inline" <?if($row['bo_cate_type']=='inline')echo"selected"?>>인라인</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>멀티업로더사용</th>
					<td>
					<select name='bo_use_multiupload' required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="N" <?if($row['bo_use_multiupload']=='N')echo"selected"?>>미사용</option>
					<option value="Y" <?if($row['bo_use_multiupload']=='Y')echo"selected"?>>사용</option>
					</select> 
					</td>
					</tr>


					<tr>
					<th>글목록권한</th>
					<td>
					<select name='bo_list_level' id="bo_list_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['bo_list_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['bo_list_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['bo_list_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['bo_list_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['bo_list_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['bo_list_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['bo_list_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['bo_list_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['bo_list_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['bo_list_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>글보기권한</th>
					<td>
					<select name='bo_read_level' id="bo_read_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['bo_read_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['bo_read_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['bo_read_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['bo_read_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['bo_read_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['bo_read_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['bo_read_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['bo_read_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['bo_read_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['bo_read_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>글쓰기권한</th>
					<td>
					<select name='bo_write_level' id="bo_write_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['bo_write_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['bo_write_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['bo_write_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['bo_write_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['bo_write_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['bo_write_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['bo_write_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['bo_write_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['bo_write_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['bo_write_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>
					<tr>
					<th>답변권한</th>
					<td>
					<select name='bo_comment_level' id="bo_comment_level" required itemname="멀티업로더" class="form-control" style="width:150px">
					<option value="1" <?if($row['bo_comment_level']=='1')echo"selected"?>>1</option>
					<option value="2" <?if($row['bo_comment_level']=='2')echo"selected"?>>2</option>
					<option value="3" <?if($row['bo_comment_level']=='3')echo"selected"?>>3</option>
					<option value="4" <?if($row['bo_comment_level']=='4')echo"selected"?>>4</option>
					<option value="5" <?if($row['bo_comment_level']=='5')echo"selected"?>>5</option>
					<option value="6" <?if($row['bo_comment_level']=='6')echo"selected"?>>6</option>
					<option value="7" <?if($row['bo_comment_level']=='7')echo"selected"?>>7</option>
					<option value="8" <?if($row['bo_comment_level']=='8')echo"selected"?>>8</option>
					<option value="9" <?if($row['bo_comment_level']=='9')echo"selected"?>>9</option>
					<option value="10" <?if($row['bo_comment_level']=='10')echo"selected"?>>10</option>
					</select> 
					</td>
					</tr>

					<tr>
					<th>Syntax Type</th>
					<td>

						 <select name="bo_syntax_type" class="form-control" style="width:200px">
							<option value="Default" <?if($row['bo_syntax_type']=='Default')echo"selected"?>>기본스타일</option>
							<option value="Eclipse" <?if($row['bo_syntax_type']=='Eclipse')echo"selected"?>>이클립스</option>
							<option value="Djangjo" <?if($row['bo_syntax_type']=='Djangjo')echo"selected"?>>파이썬</option>
							<option value="RDark" <?if($row['bo_syntax_type']=='RDark')echo"selected"?>>다크스타일1</option>
							</select>		

					</td>
					</tr>
					<tr>
					<th>노출순서</th>
					<td>

						 <select name="bo_use_yn" class="form-control" style="width:200px">
							<option value="Y" <?if($row['bo_use_yn']=='Y')echo"selected"?>>사용</option>
							<option value="N" <?if($row['bo_use_yn']=='N')echo"selected"?>>미사용</option>
							</select>		
					</td>
					</tr>
					<tr>
					<th>노출여부</th>
					<td>
						<input type="text" name="bo_sort" value="<?=$row['bo_sort']?>" class="form-control" style="width:10%;" />		
					</td>
					</tr>
				</tbody>
			</table>


		<div style="margin-bottom:20px;height:40px;">
			<div style="float:left">
				<?if($row['bo_table']){ ?>
							<button type="button" class="btn btn-danger btn-sm" onclick="del()">
							  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
							</button>
				<? } ?>			

			</div>


			<div style="float:right">
			
					<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./bbs_list.php?bo_table=<?=$bo_table?>&part=bbs'">
					  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
					</button>
					
					<button type="submit" class="btn btn-primary btn-sm" >
					  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
					</button>
			</div>
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


 	var bo_table_enabled = $("#bo_table_enabled").val();



    function fwrite_submit(f)
    {
		var f = document.frm;

	 if(oper=='add'){
		if(bo_table_enabled=='130'){
		alert('사용할 수 없는 TABLE CODE입니다.');
		return;
		}

	 }

		if (confirm('저장하시겠습니까?'))
		{
		f.submit();
		return false;
		}

	}



$(document).ready(function() {
	//$("#btn_search").trigger("click");
	// get_member_row()

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
            $('#bo_table_enabled').val(result);
        }
    });
}






</script>

<?
	include_once("./tail.php");
?>
