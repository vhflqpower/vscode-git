<?
include_once("./_common.php");

	include_once("./head.php");

?>
<style>
	body{ padding:0px;}
</style>
<div style="postion:absolute;top:0px;">
      <!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->
          <h2 class="sub-header">개발내역</h2>
          <div class="table-responsive">
		  <input type="hidden" id="is_id" value="<?=$_GET['is_id']?>">

			<div id="pagination">
			<input type="hidden" name="rowcount" id="rowcount" value="3" />
			</div> 
         </div> 

		  <!-- table-responsive -->

   
   <!-- container-fluid -->
</div>



<script type="text/javascript">

function getresult(url) {

	//alert($("#cat1").val())

	$.ajax({
		url: url,
		type: "GET",
		data:{
			rowcount:$("#rowcount").val(),
			is_id:$("#is_id").val()
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
getresult('/admin/ajax/ajax_issu_his_pop_row_data.php');

</script>

<?
	include_once("./tail.php");
?>
