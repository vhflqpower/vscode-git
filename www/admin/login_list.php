<?
include_once("./_common.php");



		$item_per_page = 20;
		$sql = "SELECT COUNT(*)as cnt FROM psj_login";
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
		include_once("./sidebar_meney.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->
    <?

	?>
          <h2 class="sub-header">접속 내역</h2>

          <div class="table-responsive">
		<H3>Total:<span id="total"></span></H3>
		<select class="selectpicker mb_id" name="mb_id" id="mb_id">
		  <option value="0">회원 선택</option>			
		<?
			$arr_member=  select_member();
			foreach($arr_member as $key => $val){
		?> 
		  <option value="<?=$key?>" <?if($key==$row['mb_id'])echo"selected"?>><?=$val?></option>
		  <? } ?>
		</select>
	<form name="list_form">
            <table class="table table-striped" id="cash_list">
				<col width="5%">
				<col width="15%">
				<col width="20%">
				<col width="40%">
				<col width="20%">
              <thead>
                <tr>
				<tr>
				 <th><input type="checkbox" name="check_all" id="check_all" onclick="checkFunction()"></th>
				  <th>NO</th>
				  <th>IP</th>
				  <th>회원명</th>
				  <th>DATE TIME</th>
				</tr>
              </thead>
			<tbody id="results"></tbody>
            </table>
			</form>

		<div style="float:left;">
			<button type="button" class="btn btn-danger btn-sm" onclick="select_delete()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>선택삭제
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



/*  페이징 카우트쿼리 */
var get_login_pages = function() {
   // var obj = '';

	var cell = '';

    $.ajax({
        type: "POST",
        url: "./ajax/ajax_rows_count_load.php",
        data: {
            "mb_id": encodeURIComponent($("#mb_id").val()),
			"part" : "login" 
        },
        cache: false,
        async: false,
         dataType:'json',
         contentType: "application/x-www-form-urlencoded; charset=UTF-8",
         success: function(response) {
          var success = (response.flag == 'succ');
		
		  cell = response.rows;


        }
    });

    return cell;
}


$(document).ready(function() {


	 var cnt_rows = get_login_pages();// 카운트쿼리
	 var total_cnt = cnt_rows['cnt'];
	 var total_page = cnt_rows['pages'];
	$("#total").html(total_cnt);
	get_login_row(total_page);

    $('#login').attr("class", "list-group-item active");

	$("#mb_id").on('change',function() { 

	 var cnt_rows = get_login_pages();// 카운트쿼리
	 var total_cnt = cnt_rows['cnt'];
	 var total_page = cnt_rows['pages'];
	$("#total").html(total_cnt);
	get_login_row(total_page);

	});



});



	
// 로데이터 AJAX 로깅
function get_login_row(total_page){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var mb_id = $("#mb_id").val();

      //   var totalCnt = get_login_pages();// 카운트쿼리

	if(mb_id){
			 $('.pagination').twbsPagination('destroy');
	}

			// $('.pagination').twbsPagination('destroy');
        var obj = $('.pagination').twbsPagination({

            totalPages:total_page,
            visiblePages:5,
            onPageClick: function (event, page) {
			  //  console.info(page);			  
		   	event.preventDefault();


			$("#results").load("./ajax/ajax_login_row_data.php", {'page':page,'mb_id':mb_id});
			
			}
        });
} 




</script>



<?
	include_once("./tail.php");
?>
