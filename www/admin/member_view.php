<?
	include_once("../common.php");

	$mb_no = $_GET['mb_no'];


	if($mb_no){

			$sql = "SELECT * FROM psj_member WHERE  mb_no = '$mb_no'";
			$result = sql_query($sql);
			$view = sql_fetch_array($result);

		$oper = 'edit';
	}else{

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
 
 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">회원 정보</h2>


          <div class="table-responsive">
			<!-- <form name="frm" method="post" action="./member_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="mb_no" value="<?=$view['mb_no']?>" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled"> -->
			<!-- table-hover -->
				
			<table class="table table-bordered ">
			<!-- <table  class="table table-bordered table-hover"> -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>
					<tr>
					<th>회원아이디</th>
					<td><?=$view['mb_id']?></td>
					</tr>

					<tr>
					<th>회원명</th>
					<td><?=$view['mb_name']?></td>
					</tr>
					<tr>
					<tr>
					<th>체크박스 샘플</th>
					<td>
					
				        <div class="checkbox">
					  <label style="font-size: 1em">
					      <input type="checkbox" value="" checked>
					      <span class="cr"><i class="cr-icon fa fa-check"></i></span>
					     https://bootsnipp.com/snippets/featured/animated-radios-amp-checkboxes-nojs
					  </label>
				        </div>
					</td>
					</tr>
					<tr>
				</tbody>
			</table>



		    <div class="col-md-12">
			  <div class="panel with-nav-tabs panel-info">
				<input type="hidden" name="tab_id" id="tab_id" value="<?=$tab_id?>">
			      <div class="panel-heading">
				    <ul class="nav nav-tabs">
				        <li class="active" ><a href="#tab1info" data-toggle="tab" id="tab1">이슈목록</a></li>
				        <li ><a href="#tab2info" data-toggle="tab" id="tab2">관련파일</a></li>
				        <li ><a href="#tab3info" data-toggle="tab" id="tab3">담당정보</a></li>
				      <li ><a href="#tab4info" data-toggle="tab" id="tab4">관련정보</a></li>

				    </ul>
			      </div>
			      <div class="panel-body">
				<div class="tab-content">
				    <div class="tab-pane fade in active" id="tab1info">
<!--  -->
				<form name="frmComm" method="post" action="./member_menu_update.php"  enctype="multipart/form-data" >


				<?
				/*
				$results = sql_query("select menu_cd,part,mb_id,access from psj_menu_auth where mb_id = TRIM('$_SESSION[ss_mb_id]')");
				while($row = sql_fetch_array($results)){
				echo $row['menu_cd'].'_'.$row['part']."<input type='checkbox' name='menu' value='".$row['access']."'></br>";
				} 
				*/

				?>

		<table width="100%" border="1"> 
			<tr> 
			<? 
			$query4 = " select me_code,me_subject from psj_menu_config where 1=1";
			$result4 = sql_query($query4);
			$list_cols = 5; 
			for($i=1; $i<=($row4 = sql_fetch_array($result4)); $i++) { 

				//$img_title = str_cut($row4[mb_id], 20, '..');
			?> 
			<td width="14%" height="24">
			
				
			<font color=blue><b><?=$row4['me_subject']?></b></font></br>			
			
			<?
			   foreach($arr_menu_part as $key => $val){  //($a=0; $a<count($arr_menu_part); $a++){


				 $val = $row4['me_code'].'_'.$key;
				 $a++;
				
				echo $arr_menu_part[$a]."<input type='text' id='menu_cd' name='menu_cd' value='$val'>
										<input type='checkbox' id='$val' name='che' value='$val'></br>";
	
			}

			?>

			</td> 
			<? if($i % $list_cols ==0 ) { 
			echo "</tr><tr>"; 
			} 
			?> 
			<?} 
			if (($cnt = ($i-1)%$list_cols) != 0) 
				for ($k=$cnt; $k<$list_cols; $k++) 
					echo " <td width='14%'>&nbsp;</td>\n"; 
			?> 
			</table>
				
				<div style="float:right;padding:6px;">	
				 <button type="button" class="btn btn-default btn-sm"  id="commAddCancle">
				<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
				 <button type="button" class="btn btn-primary btn-sm"  >
				<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>글쓰기</button>
				<input type="button" onclick="menu_update()" value="보내기">
				</div>
</form>

					<table border="1" width="100%" cellspacing="0" id="commentTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="100%">
						</colgroup>

						<tbody id="comm_results"></tbody>
						</table>


						<div align="center">
							<div class="pagination" ></div>
						</div>


				     </div>
				    <div class="tab-pane fade" id="tab2info">

					<!--  -->
					</div>
				    <div class="tab-pane fade" id="tab3info">
				    
				    <!--  -->
				    </div>
				    <div class="tab-pane fade" id="tab4info">info 4</div>
				    <div class="tab-pane fade" id="tab5info">info 5</div>
				</div>




			      </div>
			  </div>
		        </div>
			</div> <!-- <div class="col-md-12"> -->




		<div style="float:left">

				<?if($view['mb_no']){ ?>
							<button type="button" class="btn btn-danger btn-sm" onclick="del()">
							  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
							</button>
				<? } ?>			
		</div>			


		<div style="float:right;height:50px;">		
					
					<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./member_list.php?part=member'">
					  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
					</button>
					
					<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./member_write.php?mb_no=<?=$view[mb_no]?>&part=member'">
					  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정
					</button>
		</div>

			</form>



         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


	<form name="fdel" method="post" action="./member_update.php">
	<input type="hidden" name="mb_no" value="<?=$view['mb_no']?>" />
	<input type="hidden" name="oper" value="del" />
	</form>




<?
	include_once("./footer.php");
?>



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

// 멤버 메뉴 업데이트
function menu_update() {
 

var f = document.frmComm; 
var check_cnt = ""; 
	for(x = 0 ; x < f.che.length ; x ++) { 
	check_cnt += (f.che[x].checked == true) ? "1" : "0"; 
	check_cnt += "_";
	}
	

	var menu_cd = [];
	  $("input[id='menu_cd']").each(function(i){
		menu_cd.push($(this).val());
	  });
	

//alert(bb);

//console.log(ids);
	var url = './member_menu_update.php'//url 수정;
		$.ajax({
			url:url,
			data: {
			check_cnt : check_cnt,
			menu_cd : menu_cd,
			},
			type:'post',
			dataType:'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			success:function(response) {
				var success = (response.flag == 'succ');
				var message = response.message;
				var new_id = response.id;
				var msgs = response.msg2;
			}
		});



}




</script>

<?
	include_once("./tail.php");
?>
