<?
	include_once("../common.php");

	$wr_id = $_GET['wr_id'];
	$bo_table = 'data';//$_GET['bo_table'];
	$part = $_GET['part'];
	$page = $_GET['page'];



	if($wr_id){



			// 조회 COUNT
			sql_query("update psj_board_data set wr_hit = wr_hit+1 where wr_id = '$wr_id' ");
			// 조회자 로그
		if($bo_table=='info'){
			//sql_query("insert into psj_view_log values('','data','$wr_id','$member[mb_id]',Now())");
			// 조회자 로그 카운트update
			//sql_query("update psj_count set info_view = info_view+1 where mb_id = '$member[mb_id]' ");
		}

			$sql = "SELECT * FROM psj_board_data WHERE  wr_id = '$wr_id'";
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


			$cat1 = $view['wr_cat1'];
			$cat2 = $view['wr_cat2'];
			$cat1name = select_info_group();
			$cat2name = select_info_gubun($cat1);

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

	<? if($bo_table !='bugreprot'){ ?>  
          <h3 class="sub-header"><?=$view['wr_subject']?></h3>
          <? }else{ ?>
          <h3 class="sub-header">버그&제안</h3>

	<? } ?>



          <div class="table-responsive">
			<form name="frm" method="post" action="./board_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
				<input type="hidden"  id="bo_table" value="<?=$bo_table?>" />
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
					<td><?=$view['wr_datetime']?> <span style="float:right;margin-right:20px;">Hit:<?=$view['wr_hit']?></span></td>
					</tr>
					<tr>
					<th>작성자</th>
					<td><?=$view['wr_name']?> <span style="float:right;margin-right:20px;"><?echo ($view['wr_status']=='Y')?"등록완료":"등록중";?></span></td>
					</tr>
					<tr>
					<th>첨부파일</th>
					<td>
					      <div class="panel-body" id="disp_log_div" style="padding:5px;margin-left:10px;">
						</div>
					</td>
					</tr>

					<tr>
					<td colspan="2">
					<div style="padding:10px;min-height:300px;"><?echo $str_content;?></div>
					</td>
					</tr>
				</tbody>
			</table>


			<div style="float:left;">

		<? if($view[mb_id]==$member[mb_id] || $member[mb_id]=='admin'){ ?>	
							<button type="button" class="btn btn-danger btn-sm" onclick="del()">
							  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
							</button>
				<? } ?>			
							
			</div>

				<div style="float:right;margin-bottom:30px;">

				<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./data_list.php?part=<?=$part?>&bo_table=<?=$bo_table?>&page=<?=$page?>'">
				  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
				</button>
				<? if($view[mb_id]==$member[mb_id] || $member[mb_id]=='admin'){ ?>		
						<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./data_write.php?wr_id=<?=$view[wr_id]?>&part=<?=$part?>&bo_table=<?=$bo_table?>&page=<?=$page?>'">
						  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정
						</button>
				<? } ?>

				</div>
		
			</form></br></br>


<? if( $bo_table =='data'){ ?>
			<form name="form_comm" method="post" action="./data_update.php">
			<input type="hidden" name="comm_oper" id="comm_oper" value="add" />
			<input type="hidden" id="p_id" value="<?=$view['wr_id']?>" />
			<div id="add_content_form">
				<table class="table table-bordered " >
					<col width="15%">
					<col width="">
					<tbody>
						<tr>
						<!-- <th>내역</th> -->
						<td colspan="2">
						<!-- <input type="text" id="co_subject" name="co_subject" value=""  placeholder="제목" class="form-control"> -->
						<textarea class="form-control" id="co_content" name="co_content" rows="4" ></textarea>

						<div style="float:right;padding:6px;margin-bottom:20px;">	

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
						<input type="hidden" name="rowcount" id="rowcount" value="" />
						</div> 

			<br></br></br></br></br>
<? } ?>


         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


<?
	include_once("./footer.php");
?>


	<form name="fdel" method="post" action="./data_update.php">
	<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
	<input type="hidden" name="part" value="<?=$_GET['part']?>" />
	<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
	<input type="hidden" name="oper" value="del" />
	</form>



	 <script>


//------------------------------------------------------------------> 코멘트업데이트
function commSubmit() {
 	
var postData;
	var rows = Object();
	var comm_oper = $('#comm_oper').val();
	var p_id = $('#p_id').val();
	var bo_table = $('#bo_table').val();
	var co_content = $('#co_content').val();

/*
	if ( $("#wr_is_notice").is(":checked") == true ){
	var wr_is_notice ='1';
	}else{
	var wr_is_notice ='';
	}

*/
	
	if(co_content == ''){
		alert('내용은 필수입니다');
		$('#co_content').focus();
		return;
	}

	var rows= {

		bo_table : bo_table,
		comm_oper : comm_oper,
		p_id : p_id,
		co_content : co_content,

	};
	
	var postData = $.param(rows);
	var url = './data_update.php'//url 수정;
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
			
				$('#co_content').val('');

				getresult('/admin/ajax/ajax_board_comment_row_data.php');		

			}
		});

	return;



} 

function getresult(url) {

	//alert($("#cat1").val())

	$.ajax({
		url: url,
		type: "GET",
		data:{
			rowcount:$("#rowcount").val(),
			search_field:$("#search_field").val(),
			search_value:$("#search_value").val(),
			p_id:'<?=$view[wr_id]?>',
			bo_table:'data',
			},
		success: function(data){

		$("#pagination").html(data);
		},
		error: function() 
		{}
   });
}


	getresult('/admin/ajax/ajax_board_comment_row_data.php');



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
	

});







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
	

	getAddFiles('<?=$view[wr_id]?>');

  $("#btn_reload").click(function(){
		write_form_reset()
  });
 });






function getAddFiles(id) {


	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_get_file_data.php?bo_table=data&wr_id=' + id;
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

				 $('#disp_log_div').append(content);
				//var disp_log_list = $('#disp_log_div').append(content);

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
		bo_table : 'data2',
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
	
			// $(".panel-body ul").remove();
			//   getAddFiles('<?=$view[wr_id]?>');
			
			}


			}
		});
	}

	return false;

} 











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




</script>

<?
	include_once("./tail.php");
?>
