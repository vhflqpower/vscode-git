<?
	include_once("../common.php");

	$is_id = $_GET['is_id'];


	if($is_id){


			// 조회 COUNT
			$res2 = sql_query("update psj_issu set is_hit = is_hit+1 where is_id = '$is_id'");
			// 조회자 로그
			sql_query("insert into psj_view_log values('','psj_issu','$is_id','$member[mb_id]',Now())");
			// 조회자 로그 카운트update
			sql_query("update psj_count set issu_log_view = issu_view+1 where mb_id = '$member[mb_id]' ");


			$sql = "SELECT * FROM psj_issu WHERE  is_id = '$is_id'";
			$result = sql_query($sql);
			$view = sql_fetch_array($result);


			$html = 0;
			if (strstr($view['wr_option'], 'html1')){
				$html = 1;

			}else if (strstr($view['wr_option'], 'html2')){
				$html = 2;
			}

			$view['content'] = conv_content($view['is_content'], $html);


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

		$pj_id = $view['pj_id'];
		$status = $view['is_status'];
		$arr_project = select_project();

		$str_content = url_auto_link($view['is_content']);

	}else{

		$oper = 'add';
		$view[bo_skin] = 'basic';
	}


	include_once("./head.php");
?>
	<style>
	  h3{ color:#0000ff;}
	</style>


	<?
		include_once("./nav.php");
	?>

	 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashissu</h1> -->

          <h3 class="sub-header"><?=$view['is_subject']?></h3>

          <div class="table-responsive">
			<!-- table-hover -->
			<table class="table table-bordered ">
			<!-- <table  class="table table-bordered table-hover"> -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<tr>
					<th>프로젝트</th>
					<td>
					<a href="./project_view.php?pj_id=<?=$pj_id?>"><strong><?=$arr_project[$pj_id]?></strong></a>
					<span style='float:right;'>작성자:<?echo $view['wr_name'];?></span>
					</td>
					</tr>
					<tr>
					<th>진행상태</th>
					<td>
					<?=$arr_is_status[$status]?></td>
					</tr>
					<tr>
					<th>시작일/ 종료일</th>
					<td>
					<strong><?echo $view['sdate'];?>~<?echo $view['edate'];?></strong></td>
					</tr>
					<tr>
					<th>진행률</th>
					<td>
					
					 <div class="progress">
					  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?=$view['is_proc_percent'];?>%">
					    <span class="sr-only">80% Complete (danger)</span>
					  </div>
					  </div>

					</td>
					</tr>


					<tr>
					<th>첨부파일</th>
					<td>

					 <!-- 멀티파일 업로드 START -->
						 <link href="https://rawgithub.com/hayageek/jquery-upload-file/master/css/uploadfile.css" rel="stylesheet">
						<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
						<script src="https://rawgithub.com/hayageek/jquery-upload-file/master/js/jquery.uploadfile.min.js"></script> 
					<!-- 멀티파일 업로드 END -->
					<div id="fileuploader">Upload</div>
					<script>
					$(document).ready(function() {
					//	$("#fileuploader").uploadFile({
					//		url:"./multi_upload_server.php?bo_table=issu&wr_id=<?=$view[is_id]?>",
					//		fileName:"myfile"
					//	});
					});
					</script>
					        <div class="panel-body" id="disp_log_div" style="padding:5px;margin-left:10px;">
						</div>


					</td>
					</tr>


					<tr>
					<td colspan="2">
					<div style="padding:10px;"><?echo $str_content?></div>


					<!-- modal 구동 버튼 (trigger) -->

					</td>
					</tr>


				</tbody>
			</table></form>

			<div>
			<div style="float:left;margin-bottom:10px">

				<?if($view['is_id']){ ?>
				<button type="button" class="btn btn-danger btn-sm" onclick="del()">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
				</button>
				<? } ?>	
				
				<?if($member['mb_id']=='admin'){ ?>
				<button type="button" class="btn btn-waring btn-sm" onclick="logdel()">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>내역삭제
				</button>
				<? } ?>	

				<button type="button" class="btn btn-waring btn-sm"  id="issu_log_btn">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>내역보기
				</button>
							
			</div>

			<div style="float:right">

				<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./issu_list.php?part=issu'">
				  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
				</button>
				
				<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./issu_write.php?is_id=<?=$view[is_id]?>&part=issu'">
				  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정
				</button>


			</div>
		</div>


		<form name="form_memo" method="post" action="./issu_update.php">
		<input type="hidden" name="memo_oper" value="add" />
		<input type="hidden" name="is_id" value="<?=$view['is_id']?>" />
		<div id="add_content_form">
			<table class="table table-bordered " >
				<col width="15%">
				<col width="">
				<tbody>
					<tr>
					<!-- <th>내역</th> -->
					<td colspan="2">
					<input type="text" id="co_subject" name="co_subject" value=""  placeholder="제목" class="form-control" style="width:85%;">
					<textarea class="form-control" id="proc_memo" name="proc_memo" rows="4" onclick="heigher()"></textarea>

					<div style="float:right;padding:6px;">	
					      <div style="float:left;margin-left:30px;">
						<input type="text" name="is_proc_precent" value="<?=$view['is_proc_percent']?>" class="form-control" style="font-weight:bold;width:80px;height:30px;" maxlength="3"/>
						<input type="hidden" name="is_ori_precent" value="<?=$view['is_proc_percent']?>" />
						</div>

						 <button type="button" class="btn btn-default btn-sm"  id="commAddCancle">
						<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
						 <button type="button" class="btn btn-primary btn-sm"  onclick="commSubmit()">
						<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>내역작성</button>
					</div>
					</td>
					</tr>
					</table>		
			</form>
		</div>
					<div id="pagination">
					<input type="text" name="rowcount" id="rowcount" value="3" />
					</div> 

			<br>	
			</br></br></br></br>
         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->

<script>
function heigher(){

	var h = $("#proc_memo").height();
	if(h != 150){
	 $("#proc_memo").height(150);
	}else{
	 $("#proc_memo").height(34);
	}

}
</script>

<!--  -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
		<h4 class="modal-title" id="myModalLabel">내역보기</h4>
	      </div>
	      <div class="modal-body">
		...
	      </div>
	      <div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>
<!--  -->

<?
	include_once("./footer.php");
?>


	<form name="fdel" method="post" action="./issu_update.php">
	<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
	<input type="hidden" name="is_id" value="<?=$view['is_id']?>" />
	<input type="hidden" name="oper" value="del" />
	</form>

	<form name="flog" method="post" action="./issu_update.php">
	<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
	<input type="hidden" name="is_id" value="<?=$view['is_id']?>" />
	<input type="hidden" name="oper2" value="logdel" />
	</form>




<script type="text/javascript">

function getresult(url) {

	//alert($("#cat1").val())

	$.ajax({
		url: url,
		type: "GET",
		data:{
			rowcount:$("#rowcount").val(),
			search_field:$("#search_field").val(),
			search_value:$("#search_value").val(),
			p_id:'<?=$view[is_id]?>'
			},
		success: function(data){

		$("#pagination").html(data);
		},
		error: function() 
		{}
   });
}

function search_tab(id){

	$("#cat1").val(id);
	getresult('/admin/ajax/ajax_issu_log_row_data.php');

}

	$("#issu_log_btn").on("click", function(){
		cw=screen.availWidth;     //화면 넓이
		ch=screen.availHeight;    //화면 높이

		sw=1024;    //띄울 창의 넓이
		sh=780;    //띄울 창의 높이

		ml=(cw-sw)/2;        //가운데 띄우기위한 창의 x위치
		mt=(ch-sh)/2;         //가운데 띄우기위한 창의 y위치
		 window.open('./issu_his_pop.php?is_id=<?=$view[is_id]?>','popup_window','width='+sw+',height='+sh+',top=0,left='+ml+',resizable=no,scrollbars=yes');
	});

</script>


<script>
getresult('/admin/ajax/ajax_issu_log_row_data.php');

</script>





 <script>


	 function commSubmit()
	{

		var f = document.form_memo;

		if(!f.co_subject.value){
		alert('제목을 입력하세요');
		f.co_subject.focus();
		return false;
		}

		if(!f.proc_memo.value){
		alert('내용을 입력하세요');
		f.proc_memo.focus();
		return false;
		}

		if (confirm('등록하시겠습니까?'))
		{

			document.form_memo.submit();
			//$('#fdel').submit();
		}
	}

	 function del()
	{
		if (confirm('한번 삭제한 자료는 복구가 되지 않습니다. 정말로 삭제하시겠습니까?'))
		{

			document.fdel.submit();
			//$('#fdel').submit();
		}
	}
	
			
	 function logdel()
	{
		if (confirm('개발내역을 정말로 삭제하시겠습니까?'))
		{

			document.flog.submit();
		}
	}
	 </script>

<script type="text/javascript">


// 	var bo_table_enabled = $("#bo_table_enabled").val();
	/*
	
	var oper =1;

	 if(oper=='add'){
		if(bo_table_enabled=='130'){
		alert('사용할 수 없는 TABLE CODE입니다.');
		return;
		}

	 }
*/

$(document).ready(function() {
	//$("#btn_search").trigger("click");
	//get_member_row()

	getAddFiles('<?=$view[is_id]?>');

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




//  첨부파일목록 AJAX 로딩

function getAddFiles(id) {


	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_get_file_data.php?bo_table=issu&wr_id=' + id;
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
				var content = "<ul style='margin:0px;padding-left:5px;'><li><span id='disp_cnt'></span><a href=\"./download.php?bo_table="+val.bo_table+"&bf_file="+val.bf_file+"&bf_source="+val.bf_source+"&seq="+val.seq+" \">"+val.bf_source+" ("+val.bf_filesize+")</a> <a href='' onclick=\"addFileDel("+val.seq+")\">[D]</a></li>"
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
		bo_table : 'issu',
		seq : seq,

	};
	
	var postData = $.param(rows);
	var url = './ajax/ajax_addFile_del_server.php'//url 수정;
	
	var msg = '파일을 정말 삭제하시겠습니까?';
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
	   getAddFiles('<?=$view[is_id]?>');
	
	}


			}
		});
	}

	return false;

} 


</script>

<?
	include_once("./tail.php");
?>
