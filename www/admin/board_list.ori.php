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

	<form class="navbar-form navbar-left" role="search" id="searchform">
	<input type="hidden" id="cat1">
	<div class="btn-group" role="group" aria-label="...">
	  <button type="button" class="btn btn-default " onclick="search_gubun('')">전체</button>
	<?
		$arr_info_gubun =  select_info_gubun('100000');
		foreach($arr_info_gubun as $key => $val){
	?> 
	  <button type="button" class="btn btn-default" onclick="search_gubun('<?=$key?>')"><?=$val?></button>
	  <? } ?>
	</div><br><br>

<div class="btn-group" role="group" aria-label="...">
	  <button type="button" class="btn btn-default " onclick="search_gubun('')">전체</button>
	<?
		$arr_info_gubun =  select_info_gubun('200000');
		foreach($arr_info_gubun as $key => $val){
	?> 
	  <button type="button" class="btn btn-default" onclick="search_gubun('<?=$key?>')"><?=$val?></button>
	  <? } ?>
	</div>

	<script>
	function search_gubun(code){

	$("#cat1").val(code);
	get_board_row();

	}
	</script>
	 <!-- <div class="form-group pull-right" >
	   <input type="text" id="search_value" class="form-control" placeholder="Search">
	   <button type="button" id="btn_search" class="btn btn-default">검색하기</button>
	 </div> -->

	</form>
							
			<table class="table table-striped">
			<col width="10%">
			<col width="10%">
			<col width="50%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>분류</th>
                  <th>제목</th>
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

			</div>

			<div align="center">
				<input type="hidden" id="pages" value="<?=$pages;?>">
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

//	get_page_count();
	get_board_row();
	// bootpag();

	// 그리드 검색
	$("#btn_search" ).on('click',function() { 
		//get_page_count();
		get_board_row(); 
		//bootpag();
		
	
		//setTimeout(function() { 		  }, 300); 
	
	
	});
	


});


function get_page_count(){
   // $('#execute').click(function(){

		//var params = $("#searchform").serialize()

		var search_value = $("#search_value").val();

		var params = {
			search_value: search_value,
		};

		console.log(params);

	        $.ajax({
		  url:'./ajax/ajax_board_page_count.php',
		  type:'post',
		  data:params,
			 contentType: 'application/x-www-form-urlencoded; charset=UTF-8',        
			success:function(data){
            

			$("#pages").val(data);
			   
			//	$('#time').text(data);
            
			}
        })
}





function get_board_row(){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var cat1 = $("#cat1").val();

	var pages = $("#pages").val();

     $("#results").load("./ajax/ajax_board_row_data.php",{'search_field':s_field,'search_value':s_value,'cat1':cat1});

        var obj = $('.pagination').twbsPagination({
            totalPages: <?php echo $pages; ?>,
            visiblePages: 5,
            onPageClick: function (event, page) {

			  //  console.info(page);			  
		   	event.preventDefault();

			$("#results").load("./ajax/ajax_board_row_data.php", {'page':page});
			
			}
        });
   
		console.info(obj.data());

/*
	$("#results").load("./ajax/ajax_board_row_data.php",{'search_field':s_field,'search_value':s_value,'cat1':cat1});

	$(".pagination").bootpag({
	   total: pages,
	   page: 1,
	   maxVisible: 5, 
	}).on("page", function(e, num){

		e.preventDefault();
		$("#results").load("./ajax/ajax_board_row_data.php", {'page':num});
	});
*/


}


   // $(function () {

/*
	function  bootpag(){

	$(".bootpag").remove();
	var pages = $("#pages").val();
        var obj = $('.pagination').twbsPagination({
            totalPages: pages,
            visiblePages: 5,
            onPageClick: function (event, page) {
                console.info(page);
            }
        });
        console.info(obj.data());

    //});
	}

*/




</script>


<script>


</script>

<?
	include_once("./tail.php");
?>
