<?
	include_once("./_common.php");


	// 페이징용 카운트 

		$item_per_page = 10;
		$sql = "SELECT COUNT(*)as cnt FROM psj_member";
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
    <?

	?>
          <!-- <h2 class="sub-header">메인MAIN</h2> -->

                <div class="page-header">
                    <h1>CODE CONFIG</h1>
                </div>


                <div class="row">
                    <div class="col-sm-5">
                        
						<div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">코드분류</a></h3>
                            </div>

							<div class="panel-body" id="category_list1">
							<!-- 분류 로드 -->

							</div>
				
						</div>

<input type="hidden" id="item_pcode" name="item_pcode"><!-- code값 -->

		<div style="float:left;">
<?
    //if(get_member_access($menu="company",$part='c',$_SESSION['ss_mb_id'],$mode=2) > 0){
?>
			<button type="button" class="btn btn-primary btn-sm"  data-toggle='modal' data-target='#myModal'  id="write_btn" onclick="code_reset()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기	<!-- 코드분류 -->
			</button>
<? //} ?>

         </div>
        </div>






                    <!-- /.col-sm-4 -->
                    <div class="col-sm-5">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="./board_list.php?part=info">코드항목</a></h3>
                            </div>
                            <div class="panel-body" id="category_list2">
							<!-- 항목 로드 -->
                            </div>

                        </div>
<?
    //if(get_member_access($menu="company",$part='c',$_SESSION['ss_mb_id'],$mode=2) > 0){
?>
			<button type="button" class="btn btn-primary btn-sm"  data-toggle='modal' data-target='#myModal2'  id="write_btn" onclick="code_reset2()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기	<!-- 코드항목 -->
			</button>
<? //} ?>
                    </div>
                    <!-- /.col-sm-4 -->
                   
					



                </div>


	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

     </div>    <!-- row -->

   </div>  <!-- container-fluid -->




<?
	include_once("./footer.php");
?>




<!-- Button trigger modal -->
<!-- 코드분류 -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CODE INFO</h4>
      </div>
      <div class="modal-body">
	<form name="codeform" id="codeform" method="post" action="./code_update.php" onSubmit="return codesubmit(f)" enctype="multipart/form-data" >
		<input type="hidden" id="oper" name="oper" value="add">
		<input type="hidden" id="idx" name="idx">
		<input type="hidden" id="code" name="code">
		<input type="hidden" id="pcode" name="pcode">
		<input type="hidden" id="part" name="part">

	<!-- table start -->
		<table  class="table table-bordered table-hover">
		<col width="20%">
		<col width="80%">
		<tr>
		<th>CODE NAME</th>
		<td>
			<input type="text" id="codename" name="codename" class="form-control" style="width:200px;" />
		</td>
		</tr>

		</tbody>
		</table>
<!-- table end -->
	
      </div>
      <div class="modal-footer">
		<div style="display:none;float:left;" id="del-btn">
        <button type="button" class="btn btn-danger" id ="btn_absent" onclick="filedelSubmit()">삭제</button>
         </div>
		<button type="button" class="btn btn-default"  id ="btn_absent_close" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary" id ="btn_absent" onclick="codesubmit()">저장하기</button>
      </div>
    </div>
  </div>
</div>	</form>
<!-- Button trigger modal -->







<!-- Button trigger modal -->
<!-- 코드항목 -->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">CODE ITEM</h4>
      </div>
      <div class="modal-body">
	<form name="codeform2" id="codeform2" method="post" action="./codeitem_update.php" onSubmit="return codesubmit2(f)" enctype="multipart/form-data" >
		<input type="hidden" id="oper2" name="oper2" value="add">
		<input type="hidden" id="idx2" name="idx2">
		<input type="hidden" id="code2" name="code2">
		<input type="hidden" id="pcode2" name="pcode2">
		<input type="hidden" id="part2" name="part2">

	<!-- table start -->
		<table  class="table table-bordered table-hover">
		<col width="20%">
		<col width="80%">
		<tr>
		<th>CODE NAME</th>
		<td>
			<input type="text" id="codename2" name="codename2" class="form-control" style="width:200px;" />
		</td>
		</tr>

		</tbody>
		</table>
<!-- table end -->
	
      </div>
      <div class="modal-footer">
		<div style="display:none;float:left;" id="del-btn2">
        <button type="button" class="btn btn-danger" id ="btn_absent" onclick="filedelSubmit2()">삭제</button>
         </div>
		<button type="button" class="btn btn-default"  id ="btn_absent_close" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary" id ="btn_absent" onclick="codesubmit2()">저장하기</button>
      </div>
    </div>
  </div>
</div>	</form>
<!-- Button trigger modal -->
<style>

.pcode_ul_off{border:0px solid#ccc;cursor:pointer; }
.pcode_ul_on{border:0px solid#ccc;background-color:#5882FA;color:black;cursor:pointer; }

.pcode_ul_off_f{border:0px solid#ccc;cursor:pointer; }
.pcode_ul_on_f{border:0px solid#ccc;background-color:#CEF6F5;color:black;cursor:pointer; }


</style>
<script>

//------------------------------------코드분류 로드

var $j = jQuery;
$j(document).ready(function(){
	get_code_list();
});

function get_code_list() {


		url = '/admin/ajax/ajax_code_list.php'
		$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
			success:function(response) {

			var message = response.message;	
			var new_id = response.id;
			var cell = response.rows;	

				var cs_table = $('#category_list1');
				cs_table.find('.cs_row').remove();



			if(cell.length < 1){
			cs_table.append("");
				}else{
					for(var i = 0; i < cell.length ; i++ ) {

					cs_table.append(getScheduleRow(cell[i]));

					}
				}
			}
		});
}


	//코드리스트 UI
	function getScheduleRow(cell) {

	if(!cell) return "";
		var cell_text = "<ul class='member_row' onclick='code_action("+cell.code+")' id='pcodeRow_"+cell.code+"' >"
						+"<li class='pcode_ul_off' id='pcode"+cell.code+"'>"+cell.codename+"<button type='button' style='float:right;' class='btn btn-default btn-xs' data-toggle='modal' data-target='#myModal'  onclick='popEdit()' ><span class='glyphicon glyphicon-pencil' aria-hidden='true' ></span>수정</button></li>"
						+"</ul>";
	return cell_text;

}



//-----------------------	코드분류 정보   //  코드항목 리스트

function code_action(id) {
	
		jQuery(".pcode_ul_on").attr('class','pcode_ul_off');

		url = '/admin/ajax/ajax_code_load.php?id='+id;
		$.ajax({
			url:url,
			type:'POST',
			dataType:'json',
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			async:false,
				success:function(response) {
				var success = (response.flag == 'succ');
				var message = response.message;
				var new_id = response.id;
				
				// 코드분류 정보
				if(success) {
				var cell = response.rows;
					
					$("#oper").val("edit");
					$("#codename").val(cell.codename);
					$("#code").val(cell.code);
					$("#item_pcode").val(cell.code);
					$("#idx").val(cell.idx);
					$("#pcode").val(cell.pcode);
					$("#part").val(cell.part);

					$("#pcode"+id).attr('class','pcode_ul_on');


				// 코드항목 리스트

				jQuery(".member_row2").remove();

				$("#input2").each(function()	{	// 중분류 폼 클리어
				this.reset();
				});

				url = '/admin/ajax/ajax_codeitem_list.php?id='+id;
					$.ajax({
					url:url,
					type:'POST',
					dataType:'json',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					cache:false,
					async:false,
							success:function(response) {

							var message = response.message;	
							var new_id = response.id;
							var cell = response.rows;	

								var cs_table2 = $('#category_list2');
								cs_table2.find('.cs_row').remove();

							if(cell.length < 1){
							cs_table2.append("");
							}else{
									for(var i = 0; i < cell.length ; i++ ) {

									cs_table2.append(getScheduleRow(cell[i]));

													function getScheduleRow(cell) {

														if(!cell) return "";
															var cell_text = "<ul class=member_row2 onclick='item_action("+cell.code+","+cell.pcode+")' >"
																			+"	<li class='pcode_ul_off_f' id='pcode"+cell.code+"'>"+cell.codename+"<button type='button' style='float:right;' class='btn btn-default btn-xs' data-toggle='modal' data-target='#myModal2'  onclick='popEdit2("+cell.code+","+cell.pcode+")' ><span class='glyphicon glyphicon-pencil' aria-hidden='true' ></span>수정</button></li>"
																			+"</ul>";
														return cell_text;
													}
									}
							}
						}
					});

				
				}
			}
		});


}







//---------------------------------------------------------------------------------코드
//코드 리셋
function code_reset(){
	
	$("#codeform").each(function(){
	this.reset();
	});
	$('#del-btn').css("display","none");
}

//코드 서브밋
function codesubmit(){
	 

	var f = document.codeform;

	if($("#oper").val()=='add'){

		if($("#codename").val()==''){
		 alert('코드명을 입력해주세요.');
			  return false();
		}

	}

	if(confirm("정말 저장 하시겠습니까?")){

			f.action = './code_update.php';
			f.submit();

	}else{ return false; }


	
}

//코드 수정
function popEdit(){



	$('#del-btn').css("display","block");
	
}

//코드 삭제
function filedelSubmit(){	

	var f = document.codeform;
	$("#oper").val('del');

	if(confirm("선택된 데이터를 정말 삭제하시겠습니까?"))
	{

		f.action = './code_update.php';
		f.submit();
			
	}else{ return false;}

}



//------------------------------------------------------------------------항목

//항목상세
function item_action(id,pid) {

		jQuery(".pcode_ul_on_f").attr('class','pcode_ul_off_f');

		url = '/admin/ajax/ajax_codeitem_load.php?id='+id+'&pid='+pid;
		$.ajax({
			url:url,
			type:'POST',
			dataType:'json',
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			async:false,
				success:function(response) {
				var success = (response.flag == 'succ');
				var message = response.message;
				var new_id = response.id;
				
				// 코드분류 정보
				if(success) {
				var cell = response.rows;
				var item_pcode = $("#item_pcode").val();
					
					$("#oper2").val("edit");
					$("#codename2").val(cell.codename);
					$("#code2").val(cell.code);
					$("#idx2").val(cell.idx);
					$("#pcode2").val(item_pcode);
					$("#part2").val(cell.part);

					$("#pcode"+id).attr('class','pcode_ul_on_f');


				}
			}
		});
}

//항목 리셋
function code_reset2(id,pid){

	$("#codeform2").each(function(){
	this.reset();
	});
	$('#del-btn2').css("display","none");

	var item_pcode = $("#item_pcode").val(); // 대분류의 ca_cd 값을 중분류의 pcode 값으로 이동
	//alert(ca_cd_p2);
	$("#pcode2").val(item_pcode);

}



//항목 서브밋
function codesubmit2(){

	var f = document.codeform2;

	if($("#oper2").val()=='add'){

		if($("#codename2").val()==''){
		 alert('코드명을 입력해주세요.');
			  return false();
		}

	}

	if(confirm("정말 저장 하시겠습니까?")){

			f.action = './codeitem_update.php';
			f.submit();

	}else{ return false; }


	
}

//항목 수정
function popEdit2(){

	$('#del-btn2').css("display","block");
	
}


//항목 삭제
function filedelSubmit2(){	

	var f = document.codeform2;
	$("#oper2").val('del');

	if(confirm("선택된 데이터를 정말 삭제하시겠습니까?"))
	{

		f.action = './codeitem_update.php';
		f.submit();
			
	}else{ return false;}

}

</script>

<?
	include_once("./tail.php");
?>
