<?
	include_once("../common.php");

	$co_id = $_GET['co_id'];


	if($co_id){

			$sql = "SELECT * FROM psj_company WHERE  co_id = '$co_id'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);

		$oper = 'edit';
	}else{

		$oper = 'add';
		$row[bo_skin] = 'basic';
	}


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

          <h2 class="sub-header">업체 정보</h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./company_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				
				<input type="hidden" id="co_id" name="co_id" value="<?=$row['co_id']?>" />
				<input type="hidden" id="oper" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled">
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered"><!--  table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<th>상호</th>
					<td><input type="text" id="co_name" name="co_name" value="<?=$row['co_name']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>
					<th>성명(대표자)</th>
					<td><input type="text" id="mb_name" name="mb_name" value="<?=$row['mb_name']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>
					<th>생년월일(ex:19840101)</th>
					<td><input type="text" id="mb_birth" name="mb_birth" value="<?=$row['mb_birth']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>					
					<th>개업년월일(ex:20180101)</th>
					<td><input type="text" id="co_open_date" name="co_open_date" value="<?=$row['co_open_date']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>					
					<th>사업장 주소</th>
					<td><input type="text" id="co_address" name="co_address" value="<?=$row['co_address']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>					
					<th>사업의 종류</th>
					<td><input type="text" id="co_condition" name="co_condition" value="<?=$row['co_condition']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>
					<th>내용</th>
					<td>

					  <div class="form-group">
						<textarea class="form-control" id="co_content" name="co_content" rows="10"><?=$row['co_content']?></textarea>
					  </div>
					</td>
					</tr>

				</tbody>
			</table>

<div style="float:left">
		<?if($row['co_id']){ ?>
					<button type="button" class="btn btn-danger btn-sm" onclick="del()">
					  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
					</button>
		<? } ?>			
</div>
<div style="float:right">			
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./company_list.php?part=company'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			
			<button type="button" class="btn btn-primary btn-sm" id ="btn_absent" onclick="coSubmit()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>


</div>

			</form>



         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->


<?
	include_once("./footer.php");
?>




<script type="text/javascript">


//----------------------------	입력


function coSubmit() {


   var postData;
   var rows = Object();


   var oper = $('#oper').val();
   var co_id = $('#co_id').val();
   var co_name = $('#co_name').val();
   var mb_name = $('#mb_name').val();
   var mb_birth = $('#mb_birth').val();
   var co_open_date = $('#co_open_date').val();
   var co_address = $('#co_address').val();
   var co_condition = $('#co_condition').val();
   var co_content = $('#co_content').val();

   var rows= {
		oper : oper,
		co_id : co_id,
		co_name : co_name,
		mb_name : mb_name,
		mb_birth : mb_birth,
		co_open_date : co_open_date,
		co_address : co_address,
		co_condition : co_condition,
		co_content : co_content,



}
   
   var postData = $.param(rows);

   //var postData = $('.inputForm :input').serialize() + '&oper=edit&id=';

   var url = './company_update.php'//url 수정;

   if(oper =='add'){
   var msg = '업체 정보를입력하시겠습니까?';
   }else if(oper == 'edit'){
   var msg = '업체 정보를 수정하시겠습니까?';
   }

   if(confirm(msg)) {

      $.ajax({
         url:url,
         data: postData,
         type:'post',
         dataType:'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
         cache:false,
         success:function(response) {
            var success = (response.flag == 'succ');
            var message = response.message;
			
		//	alert(message);
			location.href='./company_list.php?part=company';

         }
      });

   } //confirm msg

   return;

}


</script>

<script>
//-------	삭제
function del() {

   $("#oper").val("del");
   var postData;
   var rows = Object();

   
   var oper = $('#oper').val();
   var co_id = $('#co_id').val();


   var rows= {
      oper : 'del',
      co_id : co_id,
   
   };
   
   var postData = $.param(rows);

   //var postData = $('.inputForm :input').serialize() + '&oper=edit&id=';

   var url = './company_update.php'//url 수정;

   var msg = '한번 삭제한 정보는 복구 할 수 없습니다.\n 정말 삭제하시겠습니까?';

   if(confirm(msg)) {

      $.ajax({
         url:url,
         data: postData,
         type:'post',
         dataType:'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
         cache:false,
         success:function(response) {
            var success = (response.flag == 'succ');
            var message = response.message;
            alert(message);
			
	location.href='./company_list.php?part=company';
            
         }
      });
   }
   return;
}
</script>








<?
	include_once("./tail.php");
?>
