<?
	include_once("../common.php");




	if($_POST[mode]=='smt'){


	$query ="update g5_config set cf_title='$_POST[cf_title]'  where 1=1";
	 sql_query($query);

	}else{


				$sql = "SELECT * FROM psj_menu_config WHERE  me_code = '$me_code'";
				$result = sql_query($sql);
				$row = sql_fetch_array($result);

	}
/*
	if($_GET['me_code']){

	$me_code = $_GET['me_code'];


		$oper = 'edit';
	}else{

		$oper = 'add';
		$row[me_skin] = 'basic';
	}
*/




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

          <h3 class="sub-header">기본 환경 설정</h3>

          <div class="table-responsive">
    <?		
		//print_r2($config);
	?>

    <form name="fwrite" id="fwrite" action="<?=$PHP_SELF?>" onsubmit="return saveSubmit(this);" method="post" enctype="multipart/form-data" autocomplete="off">


				<input type="hidden" id="mode" name="mode" value="smt" />
	
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered table-hover">
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>


					<th>제목</th>
					<td><input type="text" id="cf_title" name="cf_title" value="<?=$config['cf_title']?>" class="form-control" style="width:200px;" /></td>
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
