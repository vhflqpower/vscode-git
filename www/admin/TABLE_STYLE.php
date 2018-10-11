<?
	include_once("../common.php");


		$item_per_page = 10;
		$sql = "SELECT COUNT(*)as cnt FROM psj_board_config";
		$result = sql_query($sql);
		$row = sql_fetch_array($result);
		$pages = ceil($row['cnt']/$item_per_page);

	include_once("./head.php");
?>
<style>

	table a:link {
		color: #666;
		font-weight: bold;
		text-decoration:none;
	}
	table a:visited {
		color: #999999;
		font-weight:bold;
		text-decoration:none;
	}
	table a:active,
	table a:hover {
		color: #bd5a35;
		text-decoration:underline;
	}
	.tableEX{
		font-family:Arial, Helvetica, sans-serif;
		color:#666;
		font-size:12px;
		text-shadow: 1px 1px 0px #fff;
		background:#eaebec;
		margin:20px;
		border:#ccc 1px solid;

		-moz-border-radius:3px;
		-webkit-border-radius:3px;
		border-radius:3px;

		-moz-box-shadow: 0 1px 2px #d1d1d1;
		-webkit-box-shadow: 0 1px 2px #d1d1d1;
		box-shadow: 0 1px 2px #d1d1d1;
	}
	.tableEX th {
		padding:21px 25px 22px 25px;
		border-top:1px solid #fafafa;
		border-bottom:1px solid #e0e0e0;

		background: #ededed;
		background: -webkit-gradient(linear, left top, left bottom, from(#ededed), to(#ebebeb));
		background: -moz-linear-gradient(top,  #ededed,  #ebebeb);
	}
	.tableEX th:first-child {
		text-align: left;
		padding-left:20px;
	}
	.tableEX tr:first-child th:first-child {
		-moz-border-radius-topleft:3px;
		-webkit-border-top-left-radius:3px;
		border-top-left-radius:3px;
	}
	.tableEX tr:first-child th:last-child {
		-moz-border-radius-topright:3px;
		-webkit-border-top-right-radius:3px;
		border-top-right-radius:3px;
	}
	.tableEX tr {
		text-align: center;
		padding-left:20px;
	}
	.tableEX td:first-child {
		text-align: left;
		padding-left:20px;
		border-left: 0;
	}
	.tableEX td {
		padding:18px;
		border-top: 1px solid #ffffff;
		border-bottom:1px solid #e0e0e0;
		border-left: 1px solid #e0e0e0;

		background: #fafafa;
		background: -webkit-gradient(linear, left top, left bottom, from(#fbfbfb), to(#fafafa));
		background: -moz-linear-gradient(top,  #fbfbfb,  #fafafa);
	}
	.tableEX tr.even td {
		background: #f6f6f6;
		background: -webkit-gradient(linear, left top, left bottom, from(#f8f8f8), to(#f6f6f6));
		background: -moz-linear-gradient(top,  #f8f8f8,  #f6f6f6);
	}
	.tableEX tr:last-child td {
		border-bottom:0;
	}
	.tableEX tr:last-child td:first-child {
		-moz-border-radius-bottomleft:3px;
		-webkit-border-bottom-left-radius:3px;
		border-bottom-left-radius:3px;
	}
	.tableEX tr:last-child td:last-child {
		-moz-border-radius-bottomright:3px;
		-webkit-border-bottom-right-radius:3px;
		border-bottom-right-radius:3px;
	}
	.tableEX tr:hover td {
		background: #f2f2f2;
		background: -webkit-gradient(linear, left top, left bottom, from(#f2f2f2), to(#f0f0f0));
		background: -moz-linear-gradient(top,  #f2f2f2,  #f0f0f0);	
	}

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
    <?

	?>
          <h2 class="sub-header">자료실 목록</h2>

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>TABLE</th>
                  <th>게시판명</th>
                  <th>이메일</th>
                  <th>생년월일</th>
                  <th>수정</th>
                </tr>
              </thead>
			<tbody id="results"></tbody>
            </table>



<table cellspacing='0' width="90%" class="tableEX"> <!-- cellspacing='0' is important, must stay -->

	<!-- Table Header -->
	<thead>
		<tr>
			<th>Task Details</th>
			<th>Progress</th>
			<th>Vital Task</th>
		</tr>
	</thead>
	<!-- Table Header -->

	<!-- Table Body -->
	<tbody>

		<tr>
			<td>Create pretty table design</td>
			<td>100%</td>
			<td>Yes</td>
		</tr><!-- Table Row -->

		<tr class="even">
			<td>Take the dog for a walk</td>
			<td>100%</td>
			<td>Yes</td>
		</tr><!-- Darker Table Row -->

		<tr>
			<td>Waste half the day on Twitter</td>
			<td>20%</td>
			<td>No</td>
		</tr>

		<tr class="even">
			<td>Feel inferior after viewing Dribble</td>
			<td>80%</td>
			<td>No</td>
		</tr>

		<tr>
			<td>Wince at "to do" list</td>
			<td>100%</td>
			<td>Yes</td>
		</tr>

		<tr class="even">
			<td>Vow to complete personal project</td>
			<td>23%</td>
			<td><button type="button" class="btn btn-default btn-sm"  data-toggle='modal' data-target='#myModal' onclick="memoEdit('<?=$wr_id?>');" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button></td>
		</tr>

		<tr>
			<td>Procrastinate</td>
			<td>80%</td>
			<td>No</td>
		</tr>

		<tr class="even">
			<td><a href="#yep-iit-doesnt-exist">Hyperlink 	Example</a></td>
			<td>80%</td>
			<td><a href="#inexistent-id">Another</a></td>
		</tr>

	</tbody>
	<!-- Table Body -->

</table>







		<div style="float:left;">
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./bbs_write.php'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			</button>
         </div>


		<div align="center">
			<div class="pagination" ></div>
		</div>
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
	get_member_row()

});


function get_member_row(){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var ca_name = $("#ca_name").val();

	$("#results").load("./ajax/ajax_bbs_row_data.php",{'search_field':s_field,'search_value':s_value,'ca_name':ca_name});

	$(".pagination").bootpag({
	   total: <?php echo $pages; ?>,
	   page: 1,
	   maxVisible: 5, 
	}).on("page", function(e, num){

		e.preventDefault();
		$("#results").load("./ajax/ajax_bbs_row_data.php", {'page':num});
	});



}

    $(function () {

		$(".bootpag").remove();

        var obj = $('.pagination').twbsPagination({
            totalPages: <?php echo $pages; ?>,
            visiblePages: 5,
            onPageClick: function (event, page) {
                console.info(page);
            }
        });
        console.info(obj.data());
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

</script>

<?
	include_once("./tail.php");
?>
