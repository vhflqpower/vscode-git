<?
	include_once("./_common.php");


	// 페이징용 카운트 

		$item_per_page = 10;
		$sql = "SELECT COUNT(*)as cnt FROM psj_member";
		$result = sql_query($sql);
		$row = sql_fetch_array($result);
		$pages = ceil($row['cnt']/$item_per_page);



	include_once("./head.php");
?>
   <style>

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
	//echo $_SESSION['ss_mb_id']."<===============";
	?>
          <h2 class="sub-header">회원목록</h2>

          <div class="table-responsive">

	<form class="navbar-form navbar-left" role="search" id="searchform">
	  <div class="form-group">
		<input type="text" id="search_value" class="form-control" placeholder="Search">
	  </div>
	  <button type="button" id="btn_search" class="btn btn-default">검색하기</button>
	</form>

	 <input type="hidden" id="row_cnt" value="">
            <table class="table table-striped">
              <thead>
                <tr>
	     <th><input type="checkbox" name="check_all" id="check_all" onclick="checkFunction()"></th>
                  <th>NO</th>
                  <th>아이디</th>
                  <th>회원명</th>
                  <th>이메일</th>
                  <th>생년월일</th>
                  <th>LEVEL</th>
                  <th>수정</th>
                </tr>
		</thead>
	<tbody id="results"></tbody>
            </table>



		<div style="float:left;">
			<button type="button" class="btn btn-danger btn-sm" onclick="select_delete()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>선택삭제
			</button>

<?

    //if(get_member_access($menu="company",$part='c',$_SESSION['ss_mb_id'],$mode=2) > 0){
?>
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./member_write.php?part=member'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			</button>
<? //} ?>

         </div>

<!-- 
			<div style="float:left;">
				<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./member_write.php'">
				  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
				</button>
			 </div>
			 <div style="float:right;">

			</div> -->


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


<!-- Button trigger modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">DIARY INFO</h4>
      </div>
      <div class="modal-body">
	<!-- <form name="frm1" method="post"> -->
			<form name="inputForm" id="inputForm" class="searchForm">
			<input type="hidden" name="wr_id" id="wr_id" value="">
	<!-- table start -->
		<table  class="table table-bordered table-hover">
		<col width="20%">
		<col width="80%">
		<tr>
		<th>DATE</th>
		<td><input type="text" id="wr_date" name="wr_date" style="width:30%;" ></td>
		</tr>
		<tr>
		<th>제목</th>
		<td><input type="text" id="wr_subject" name="wr_subject" style="width:100%;" >
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<textarea id="wr_content" name="wr_content" style="width:100%;height:200px;"></textarea>
		</td>
		</tr>
		</tbody>
		</table>
<!-- table end -->
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  id ="btn_absent_close" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary" id ="btn_absent" onclick="mbSubmit()">저장하기</button>
      </div>
    </div>
  </div>
</div>
<!-- Button trigger modal -->







<script type="text/javascript">

$(document).ready(function() {

	//$("#btn_search").trigger("click");
	get_member_row()

	// 그리드 검색
	$("#btn_search" ).on('click',function() { 
		get_member_row(); 
	});



});

	
// 로데이터 AJAX 로깅
function get_member_row(){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var ca_name = $("#ca_name").val();

	$("#results").load("./ajax/ajax_member_row_data.php",{'search_field':s_field,'search_value':s_value,'ca_name':ca_name});



/*
		var part = 'count';
		var params = {
			part : part,
		};

		console.log(params);

        $.ajax({
            url:'./ajax/ajax_page_count.php',
            type:'post',
            data:params,
			 contentType: 'application/x-www-form-urlencoded; charset=UTF-8',        
			success:function(data){
            
			$("#row_cnt").val(data);
            
			}
        })
*/


        var obj = $('.pagination').twbsPagination({
            totalPages: <?php echo $pages; ?>,
            visiblePages: 5,
            onPageClick: function (event, page) {

			  //  console.info(page);			  
		   	event.preventDefault();

			$("#results").load("./ajax/ajax_member_row_data.php", {'page':page});
			
			}
        });
   
		console.info(obj.data());

}





// 페이지구현부분

/*
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

*/




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


// 전체선택 / 해제
function checkFunction(){
    $('input:checkbox[name="check_all"]').change(function(){
        $('input:checkbox[name="chk_mb_no"]').each(function(){
            $(this).prop("checked",$('input:checkbox[name="check_all"]').prop("checked"));
        });
    })
}

//	선택삭제
function select_delete(){



   var oper = "check_del";
   
    // name이 같은 체크박스의 값들을 배열에 담는다.
    var checkboxValues = [];
    $("input[name='chk_mb_no']:checked").each(function(i) {
        checkboxValues.push($(this).val());
    });

	//alert(checkboxValues);
     
    // 사용자 ID(문자열)와 체크박스 값들(배열)을 name/value 형태로 담는다.
    var allData = {
		oper : oper,
		checkArray : checkboxValues,
			};
     
    $.ajax({
        url:"./member_update.php",
        type:'POST',
        data: allData,
        success:function(data){
            alert("완료");
			get_member_row();

        }

    });
}








</script>

<?
	include_once("./tail.php");
?>
