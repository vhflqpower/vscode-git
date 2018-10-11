<?
include_once("./_common.php");

	$item_per_page = 10;
	$sql = "SELECT COUNT(*)as cnt FROM psj_board";
	$result = sql_query($sql);
	$row = sql_fetch_array($result);
	$pages = ceil($row['cnt']/$item_per_page);


	include_once("./head.php");

?>
<script>

</script>


 

	<?
		include_once("./nav.php");
	?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->
          <h2 class="sub-header">정보목록</h2>
          <div class="table-responsive">

			<form  role="search" id="searchform" style="width:100%;">
			<input type="hidden" id="cat1">
			<input type="hidden" id="cat2">
			<input type="hidden" id="bo_table">
			
			
			<? if($_GET['bo_table'] =='info'){ ?>  
			<div class="btn-group" role="group" aria-label="...">
			
			  <button type="button" class="btn btn-default" onclick="search_tab(this.value);">전체보기</button>
			<?
				$arr_info_gubun =  select_info_group();
				foreach($arr_info_gubun as $key => $val){

				if($val[1]>0)$info_cnt = $val[1];else $info_cnt='';
			?> 
			  <button type="button" class="btn btn-default" onclick="search_tab(this.value);" value="<?=$key?>"><?=$val[0]?> <span class='badge'><?=$info_cnt?></span></button>
			  <? } ?>
			</div><br><br>

			 <div class="btn-group" role="group" aria-label="..."  id="sub_item">
				  <!-- <button type="button" class="btn btn-default " onclick="search_gubun('')">하위분류</button> -->
			</div>
			<? } ?>

	 <!-- <div class="form-group pull-right" >
	   <input type="text" id="search_value" class="form-control" placeholder="Search">
	   <button type="button" id="btn_search" class="btn btn-default">검색하기</button>
	 </div> -->

	</form>
							
			<table class="table table-striped">
			<col width="10%">
			<col width="10%">
			<col width="50%">
			<col width="9%">
			<col width="8%">
			<col width="8%">
			<col width="5%">
              <thead>
                <tr>
                  <th>NO[<?=$total_count?>]</th>
                  <th>분류</th>
                  <th>제목</th>
                  <th>구분</th>
                  <th>작성자</th>
                  <th>작성일</th>
                  <th>조회</th>
                </tr>
              </thead>
			 <tbody id="results"></tbody>
            </table>

			<div style="float:left;">
				<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./board_write.php?part=info'">
				  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
				</button>
			 </div>
			 <div style="float:right;">
							<a href="#1" class="page-link2" id="page-link2">9</a>
			</div>

			<div align="center">
				<input type="hidden" id="pages" value="<?=$pages;?>">
				<input type="text" id="page" value="<?=$page;?>">
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
var get_info_pages = function() {
   // var obj = '';

	var cell = '';

    $.ajax({
        type: "POST",
        url: "./ajax/ajax_rows_count_load.php",
        data: {
            "mb_id": encodeURIComponent($("#mb_id").val()),
			"part" : "info" 
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


	 var cnt_rows = get_info_pages();// 카운트쿼리
	 var total_cnt = cnt_rows['cnt'];
	 var total_page = cnt_rows['pages'];
		$("#total").html(total_cnt);
		get_login_row(total_page);

      $('#login').attr("class", "list-group-item active");

	   $("#mb_id").on('change',function() { 

	 var cnt_rows = get_info_pages();// 카운트쿼리
	 var total_cnt = cnt_rows['cnt'];
	 var total_page = cnt_rows['pages'];
		$("#total").html(total_cnt);
		get_login_row(total_page);

	});



    $(".page-link").click(function(){
      var page = $(this).text();
		 $("#page").val(page);
        });

		//$(".page-link").trigger('click')  

});

/*
$("#myLink").click(function () {
  var id = $(this).attr('href');
  alert(id);
  return false;
});
*/
	
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


			$("#results").load("./ajax/ajax_board_row_new_data.php", {'page':page,'mb_id':mb_id});
			
			}
        });
} 


function search_tab(id){

	$("#cat1").val(id);
	$("#cat2").val('');
	get_cat2_inline_load(id);
	getresult('/admin/ajax/ajax_board_row_data.php?bo_table=<?=$bo_table?>&part=<?=$part?>');

}

function search_tab2(id){

	$("#cat2").val(id);
	getresult('/admin/ajax/ajax_board_row_data.php?bo_table=<?=$bo_table?>&part=<?=$part?>');

}


function  get_cat2_inline_load(pid){

	  url = './ajax/ajax_cat2_inline_load.php?pid='+pid;
  $.ajax
      ({
         type: "POST",
         url: url,
         data: "pid="+pid,
         success: function(option)
         {
           $("#sub_item").html(option);
		  
		 }

      });
  
	 return false;

}



</script>

<?
	include_once("./tail.php");
?>
