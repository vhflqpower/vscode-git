<?
include_once("./_common.php");

	$part= $_GET['part'];
	$bo_table= $_GET['bo_table'];
	include_once("./head.php");


	include_once("./nav.php");
?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->
         
	<h2 class="sub-header">이슈내역조회</h2>
	
	<div class="table-responsive">

	<form class="navbar-form navbar-left" role="search" id="searchform">
	<input type="hidden" id="cat1">
	<input type="hidden" id="cat2">
	<input type="hidden" id="bo_table">
시작일
	<div class="input-group date" style="width:160px;">
	<input type="text" name="sdate" id="sdate"  value=""  class="form-control" style="width:160px;">
	<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span></div>
종료일
	<div class="input-group date" style="width:160px;">
	<input type="text"name="edate" id="edate"  value=""  class="form-control" style="width:160px;">
	<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span></div>

					<select class="selectpicker member" name="mb_id" id="mb_id" data-style="btn-default">
						  <option value="">담당선택</option>			
						<?
							$arr_member=  select_member();
							foreach($arr_member as $key => $val){
						?> 
						  <option value="<?=$key?>" <?if($key==$row['mb_id'])echo"selected"?>><?=$val?></option>
						  <? } ?>
						</select>

검색어
	<div class="form-group pull-right" >
	   <input type="text" id="search_value" value="<?=$_POST['search_keyword']?>" class="form-control" placeholder="Search" onkeyup="getresult('/admin/ajax/ajax_issu_his_search_row_data.php?bo_table=<?=$_GET['bo_table']?>&part=<?=$_GET['part']?>')">
	  <button type="button" id="btn_search" class="btn btn-info" onclick="getresult('/admin/ajax/ajax_issu_his_search_row_data.php?bo_table=<?=$_GET['bo_table']?>&part=<?=$_GET['part']?>')">검색하기</button>
	 </div> 

	</form>


	<div id="pagination">
	<input type="hidden" name="rowcount" id="rowcount" value="3" />
	</div> 


			<!-- <div style="float:left;">

			 </div> -->

			 <div style="float:right;">

			</div>

			<div style="height:120px;">
				<!-- <input type="hidden" id="pages" value="<?=$pages;?>">
				<div class="pagination" ></div> -->
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

function getresult(url) {

	//alert($("#cat1").val())

	$.ajax({
		url: url,
		type: "GET",
		data:{
			rowcount:$("#rowcount").val(),
			search_field:$("#search_field").val(),
			search_value:$("#search_value").val(),
			cat1:$("#cat1").val(),
			cat2:$("#cat2").val(),
			mb_id:$("#mb_id").val(),
			sdate:$("#sdate").val(),
			edate:$("#edate").val()
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
	$("#cat2").val('');
	get_cat2_inline_load(id);
	getresult('/admin/ajax/ajax_issu_his_search_row_data.php?bo_table=<?=$bo_table?>&part=<?=$part?>');

}


function search_tab2(id){

	$("#cat2").val(id);
	getresult('/admin/ajax/ajax_issu_his_search_row_data.php?bo_table=<?=$bo_table?>&part=<?=$part?>');

}



	  $(function(){

			$('.input-group.date').datepicker({
				calendarWeeks: false,
				todayHighlight: true,
				autoclose: true,
				format: "yyyy/mm/dd",
				language: "kr"
			});

		});
</script>


<script>
getresult('/admin/ajax/ajax_issu_his_search_row_data.php?bo_table=<?=$bo_table?>&part=<?=$part?>');

	//$("#issu_log_btn").on("click", function(id){

 function issu_log_pop(id){
		cw=screen.availWidth;     //화면 넓이
		ch=screen.availHeight;    //화면 높이

		sw=1024;    //띄울 창의 넓이
		sh=780;    //띄울 창의 높이


		ml=(cw-sw)/2;        //가운데 띄우기위한 창의 x위치
		mt=(ch-sh)/2;         //가운데 띄우기위한 창의 y위치
		 window.open('./issu_his_pop.php?idx='+id,'popup_window','width='+sw+',height='+sh+',top=0,left='+ml+',resizable=no,scrollbars=yes');
//	});
 }
</script>




<?
	include_once("./tail.php");
?>
