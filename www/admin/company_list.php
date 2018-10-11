<?
include_once("./_common.php");

	//	get_member_access($menu="company",$part='r',$_SESSION['ss_mb_id'],$mode=1); // $mode = 1 리턴없음 2 있음 


		$item_per_page = 10;
		$sql = "SELECT COUNT(*)as cnt FROM psj_company";
		$result = sql_query($sql);
		$row = sql_fetch_array($result);
		$pages = ceil($row['cnt']/$item_per_page);

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

          <h2 class="sub-header">업체목록</h2>
<?

?>
          <div class="table-responsive">
            <table class="table table-striped">
			<col width="3%">
			<col width="7%">
			<col width="10%">
			<col width="20%">
			<col width="10%">
			<col width="20%">
			<col width="10%">
			<col width="10%">
              <thead>
                <tr>
			<th><input type="checkbox" name="check_all" id="check_all" onclick="checkFunction()"></th>
			<th>NO</th>
			<th style="text-align:center;">업체명</th>
			<th>대표전화</th>					
			<th>대표자</th>
			<th>전화</th>
			<th>업종</th>
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
		$acc = get_member_access($menu="company",$part='W',$_SESSION['ss_mb_id'],$mode=2);
   // if($acc > 0){
?>
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./company_write.php?part=company'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			</button>
<? //} ?>

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
			<input type="hidden" name="pj_id" id="pj_id" value="">
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
	get_company_row()

});



// 로데이터 AJAX 페이징
function get_company_row(){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var ca_name = $("#ca_name").val();

	$("#results").load("./ajax/ajax_company_row_data.php",{'search_field':s_field,'search_value':s_value,'ca_name':ca_name});
        var obj = $('.pagination').twbsPagination({
            totalPages: <?php echo $pages; ?>,
            visiblePages: 5,
            onPageClick: function (event, page) {

			  //  console.info(page);			  
		   	event.preventDefault();

			$("#results").load("./ajax/ajax_company_row_data.php", {'page':page});
			
			}
        });
   
		console.info(obj.data());

}






</script>


<script>

// 전체선택 / 해제
function checkFunction(){
    $('input:checkbox[name="check_all"]').change(function(){
        $('input:checkbox[name="chk_co_id"]').each(function(){
            $(this).prop("checked",$('input:checkbox[name="check_all"]').prop("checked"));
        });
    })
}

//	선택삭제
function select_delete(){



   var oper = "check_del";
   
    // name이 같은 체크박스의 값들을 배열에 담는다.
    var checkboxValues = [];
    $("input[name='chk_co_id']:checked").each(function(i) {
        checkboxValues.push($(this).val());
    });

	//alert(checkboxValues);
     
    // 사용자 ID(문자열)와 체크박스 값들(배열)을 name/value 형태로 담는다.
    var allData = {
		oper : oper,
		checkArray : checkboxValues,
			};
     
    $.ajax({
        url:"./company_update.php",
        type:'POST',
        data: allData,
        success:function(data){
            alert("완료");
			get_company_row();

        }

    });
}

</script>




<?
	include_once("./tail.php");
?>
