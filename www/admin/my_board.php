<?
	include_once("../common.php");

	include_once("./head.php");
?>


	<?
		include_once("./nav.php");
	?>

	<link rel="stylesheet" href="/css/boot_tab.css" type="text/css">
 
 <script>



	  </script>




 <div class="container-fluid">
	<?
		include_once("./sidebar_mypage.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">MY INFO</h2>

          <div class="table-responsive">


		    <div class="col-md-12" style="padding:0px;">
			  <div class="panel with-nav-tabs panel-info">
				<input type="hidden" name="tab_id" id="tab_id" value="<?=$tab_id?>">
			      <div class="panel-heading">
				    <ul class="nav nav-tabs">
				        <li class="active" ><a href="#tab1info" data-toggle="tab" id="tab1">나만의 정보</a></li>
				        <li ><a href="#tab2info" data-toggle="tab" id="tab2">공개된 정보</a></li>
				        <li ><a href="#tab3info" data-toggle="tab" id="tab3">제안하기</a></li>
				    </ul>
			      </div>
			      <div class="panel-body">
					<div class="tab-content">

						 <div class="tab-pane fade in active" id="tab1info"><!-- ###### tab1 START #####-->

								<div id="my_info_list">
								<input type="hidden" name="rowcount" id="rowcount" value="5" />
								</div> 

						 </div><!-- ###### tab1 END #####-->


						<div class="tab-pane fade" id="tab2info">

							<div id="open_info_list">
							<input type="hidden" name="rowcount2" id="rowcount2" value="5" />
							</div> 

						</div><!-- ###### tab2 END #####-->


						<div class="tab-pane fade" id="tab3info">

							<div id="my_report_list">
								<input type="hidden" name="rowcount3" id="rowcount3" value="5" />
							</div> 

						</div><!-- tab3info END -->


					 </div><!--tab-content end  -->



			      </div><!-- panel-body end -->
				  </div>
		        </div>
			
			
			</div> <!-- <div class="col-md-12"> -->

			</form>



		 
		 </div> <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


<?
	include_once("./footer.php");
?>
		<style>
			/* Style the tab content */
			.content_area{
				display: block;
				padding: 6px 0px;
				-webkit-animation: fadeEffect 1s;
				animation: fadeEffect 1s;
			}

			@-webkit-keyframes fadeEffect {
				from {opacity: 0;}
				to {opacity: 1;}
			}

			@keyframes fadeEffect {
				from {opacity: 0;}
				to {opacity: 1;}
			}

		</style>





<script type="text/javascript">

/*
function toggle_layer() {
	if($("#layer").css("display") == "none"){
		$("#layer").show();
	}else{
		$("#layer").hide();
	}
}
*/

//	선택삭제




$(document).ready(function() {

  // $('#my_plan').attr("class", "list-group-item active");

<? if(!$_GET[page]){ $page =1; }else{  $page =$_GET[page];} ?>

	getresult('/admin/ajax/ajax_my_board_row_data.php?bo_table=<?=$bo_table?>&page=<?=$page?>');
	getresult2('/admin/ajax/ajax_my_openinfo_row_data.php?bo_table=<?=$bo_table?>&page=<?=$page?>');
	getresult3('/admin/ajax/ajax_my_report_row_data.php?bo_table=<?=$bo_table?>&page=<?=$page?>');

<? if($part=='myinfo' || $part=='info'){ ?>
   $('#my_info').attr("class", "list-group-item active");
<? }else if($part=='myreport'){ ?>
   $('#my_bugs').attr("class", "list-group-item active");
<? }?>

})


function getresult(url) {
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

		$("#my_info_list").html(data);

		},
		error: function() 
		{}
   });
}



function getresult2(url) {

	//alert($("#cat1").val())
	$.ajax({
		url: url,
		type: "GET",
		data:{
			rowcount:$("#rowcount2").val(),
			search_field:$("#search_field").val(),
			search_value:$("#search_value").val(),
			cat1:$("#cat1").val(),
			cat2:$("#cat2").val(),
			part : 'myopeninfo',
			nowpage:$("#nowpage").val()
			},
		success: function(data){

		$("#open_info_list").html(data);

		},
		error: function() 
		{}
   });
}




function getresult3(url) {

	//alert($("#cat1").val())
	$.ajax({
		url: url,
		type: "GET",
		data:{
			rowcount:$("#rowcount3").val(),
			search_field:$("#search_field").val(),
			search_value:$("#search_value").val(),
			cat1:$("#cat1").val(),
			cat2:$("#cat2").val(),
			part : 'myreport',
			nowpage:$("#nowpage").val()
			},
		success: function(data){

		$("#my_report_list").html(data);

		},
		error: function() 
		{}
   });
}







</script>

<?
	include_once("./tail.php");
?>
