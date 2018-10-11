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
         
	<? if($bo_table =='bugreport'){ ?> 
	<h2 class="sub-header"><?=$board['bo_subject']?></h2>

          <? }else{ ?>
	<h2 class="sub-header">자료목록</h2>
	<? } ?>

	<div class="table-responsive">

	<form class="navbar-form navbar-left" role="search" id="searchform" style="width:100%">
	<input type="hidden" id="cat1">
	<input type="hidden" id="cat2">
	<input type="hidden" id="bo_table">



	<div class="form-group pull-right" >
	   <input type="text" id="search_value" value="<?=$_POST['search_keyword']?>" class="form-control" placeholder="Search" onkeyup="getresult('/admin/ajax/ajax_data_row_data.php?bo_table=<?=$_GET['bo_table']?>&part=<?=$__GET['part']?>')">
	   <!-- <button type="button" id="btn_search" class="btn btn-info">검색하기</button> -->
	 </div> 

	</form>


	<div id="pagination">
	<input type="text" name="rowcount" id="rowcount" value="5" />
	</div> 


			 <div style="float:right;">

			</div>

			<div style="height:20px;">
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
			nowpage:$("#nowpage").val()
			},
		success: function(data){

		$("#pagination").html(data);
		},
		error: function() 
		{}
   });
}





</script>


<script>

<? if(!$_GET[page]){ $page =1; }else{  $page =$_GET[page];} ?>

getresult('/admin/ajax/ajax_data_row_data.php?bo_table=<?=$bo_table?>&part=<?=$part?>&page=<?=$page?>');

setTimeout(function() {
 // console.log('Works!'
//pageclick()
//

}, 1000);

function pageclick(){
$("#pageNo3").trigger('click');  
}


</script>

<?
	include_once("./tail.php");
?>
