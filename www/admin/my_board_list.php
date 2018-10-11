<?
include_once("./_common.php");

	$part= $_GET['part'];
	$bo_table= $_GET['bo_table'];
	include_once("./head.php");

	include_once("./nav.php");
?>

 <div class="container-fluid">
	<?
		include_once("./sidebar_mypage.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->
         
	<? if($bo_table =='bugreport'){ ?> 
	<h2 class="sub-header"><?=$board['bo_subject']?></h2>

          <? }else{ ?>
	<h2 class="sub-header">정보목록</h2>
	<? } ?>

	<div class="table-responsive">

	<form class="navbar-form navbar-left" role="search" id="searchform" style="width:100%">
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


	<div class="form-group pull-right" >
	   <input type="text" id="search_value" value="<?=$_POST['search_keyword']?>" class="form-control" placeholder="Search" onkeyup="getresult('/admin/ajax/ajax_board_row_data.php?bo_table=<?=$_GET['bo_table']?>&part=<?=$__GET['part']?>')">
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

$(document).ready(function() {

<? if($part=='info'){ ?>
   $('#my_info').attr("class", "list-group-item active");
<? }else if($part=='bugreport'){ ?>
   $('#my_bugs').attr("class", "list-group-item active");
<? }?>


});

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
			part : 'myinfo',
			nowpage:$("#nowpage").val()
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


<script>



<? if(!$_GET[page]){ $page =1; }else{  $page =$_GET[page];} ?>

getresult('/admin/ajax/ajax_board_row_data.php?bo_table=<?=$bo_table?>&part=<?=$part?>&page=<?=$page?>');

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
