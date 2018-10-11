<?
include_once("./_common.php");


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
          <h2 class="sub-header">회비내역</h2>



  <div class="table-responsive">

	<select class="selectpicker company" name="search_company" id="search_company">
		<option value="">선택하세요</option>			
	<?
		$arr_company =  select_company();
		foreach($arr_company as $key => $val){
	?> 
	  <option value="<?=$key?>"><?=$val?></option>
	  <? } ?>
	</select>

	<form name="list_form">
            <table  class="table table-striped" id="cash_list">
			<col width="5%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="5%">
			<col width="40%">
			<col width="10%">
              <thead class="cash_head">
                <tr>
				 <th><div style='text-align:center'><input type="checkbox" name="check_all" id="check_all" onclick="checkFunction()"></div></th>
                  <th>DATE</th>
                  <th>구분</th>
                  <th>분류</th>
                  <th>금액</th>
                  <th>내용</th>
                  <th>수정</th>
                </tr>
                <!-- <tr>
 -->
              </thead>
				<tbody id="cash_body"></tbody>
            </table>
			</form>

		<div style="float:left;">

			<button type="button" class="btn btn-default btn-sm" onclick="addRow()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>+추가하기
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="submitMulti()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>

			<button type="button" class="btn btn-default btn-sm" id="addCancle">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>취소하기
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="select_delete()">
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


<!-- Button trigger modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">MONEY INFO</h4>
      </div>
      <div class="modal-body">
	<!-- <form name="frm1" method="post"> -->
			<form name="inputForm" id="inputForm" class="searchForm">
			<input type="hidden" name="mo_id" id="mo_id" value="">
			<input type="hidden" name="oper" id="oper" value="add">
	<!-- table start -->
		<table  class="table table-bordered table-hover">
		<col width="20%">
		<col width="80%">
		<tr>
		<th>DATE</th>
		<td><input type="text" id="mo_date" name="mo_date" style="width:30%;" ></td>
		</tr>
		<tr>
		<th>구분</th>
		<td><input type="text" id="mo_part" name="mo_part" class="form-control" style="width:200px;" >
		</td>
		</tr>
		<tr>
		<th>분류</th>
		<td><input type="text" id="mo_cat1" name="mo_cat1" class="form-control" style="width:200px;" >
		</td>
		</tr>
		<tr>
		<th>금액</th>
		<td><input type="text" id="mo_price" name="mo_price" class="form-control" style="width:200px;">
		</td>
		</tr>
		<tr>
		<th>메모</th>
		<td><input type="text" id="mo_memo" name="mo_memo" class="form-control" style="width:100%;" >
		</td>
		</tr>
		</tbody>
		</table>
<!-- table end -->
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  id ="btn_absent_close" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary" id ="btn_absent" onclick="moSubmit()">저장하기</button>
      </div>
    </div>
  </div>
</div>
<!-- Button trigger modal -->

		<style>
			/* Style the tab content */
			#cash_list{
				display: block;
				padding: 6px 0px;
				-webkit-animation: fadeEffect 1.5s;
				animation: fadeEffect 1.5s;
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




$(function() {
             
            $(document).on("click",".input-group",function(){        
                    $(this).datepicker({                        
                            changeMonth: true,
							todayHighlight: true,
                            changeYear: true,
							autoclose: true,
                            format: 'yyyy/mm/dd'                       
                        }).datepicker("show");
                });



            $(document).on("click","#addCancle",function(){        

					$(".addrow").empty(); 

                });

          
    });








function editMoneyPop(id){

	$('#myModal').modal('show');

	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_money_load.php?id=' + id;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
		//  contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩


			if(success) {

				var cell = response.rows;

				$("#oper").val('edit');
				$("#mo_id").val(cell.mo_id);
				$("#mo_date").val(cell.mo_date);
				$('#mo_price').val(cell.mo_price);
				$('#mo_memo').val(cell.mo_memo);



			} else {
				alert('fail to load data');
			}
		}
	});
}



//------------------------------------------------------------------> 담당자 정보업데이트
    function moSubmit(oper){	

	var postData;
	var rows = Object();

	if(!oper){
	var oper = $('#oper').val();
	}


	var mo_id = $('#mo_id').val();
	var mo_date = $('#mo_date').val();
	var mo_price = $('#mo_price').val();
	var mo_memo = $('#mo_memo').val();

	

	if(!mo_price){
		alert('금액은  필수입니다');
		return;
	}


	if(!mo_memo){
		alert('내역은  필수입니다');
		return;
	}

	alert(mo_price)

	var rows= {

		oper : oper,
		mo_id : mo_id,
		mo_date : mo_date,
		mo_price : mo_price,
		mo_memo : mo_memo,


	};
	
	var postData = $.param(rows);
	var url = './ajax/ajax_multi_income_update.php'//url 수정;
	
		
		if(oper=='del'){
		var msg =" 정말 삭제하시겠습니까?";
		}else if(oper=='edit'){
		var msg ="정말 수정하시겠습니까?";
		
		}else if(oper=='add'){
		var msg ="작성 된 자료로 정말 입력하시겠습니까?";
		}


		 if(confirm(msg))
		 {
		
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
				var new_id = response.id;
				var msgs = response.msg2;


					$('#myModal').modal('hide');
					getMoneyList()



			}
		});

	return;
	}

} 



var intTextBox=1;

	 
	//FUNCTION TO REMOVE TEXT BOX ELEMENT
	function remove_tr()
	{
		if(intTextBox != 0)
		{
		var contentID = document.getElementById('row_div');
		contentID.removeChild(document.getElementById('floorstrText'+intTextBox));
		intTextBox = intTextBox-1;
		}
	}



	function getMoneyList() {


		$("#cash_body").empty();

		 var sub_mid = $("#sub_mid").val();
		 var sub_sid = $("#sub_sid").val();


		var param = "sub_mid="+sub_mid+"&sub_sid="+sub_sid;
		//console.log( "=====> param: "+ param );
		$.ajax({
			url: "./ajax/ajax_money_row_data.php",
			type: "GET",
			data: param,
			success: function( data ){
				
				//console.log( "=====> data: "+ JSON.stringify(data) );

			//	$("#cash_list").append( data );
		
				$("#cash_list").prepend(data); 


				//$(".ajax_content_data").remove();
	
				//if( data ) G_PAGE++;
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Ajax failure');
			}
	   });
	}

	getMoneyList();  // 콘텐츠 목록 로딩

</script>





<script>



// 전체선택 / 해제
function checkFunction(){
    $('input:checkbox[name="check_all"]').change(function(){
        $('input:checkbox[name="chk_mo_id"]').each(function(){
            $(this).prop("checked",$('input:checkbox[name="check_all"]').prop("checked"));
        });
    })
}

//	선택삭제
function select_delete(){


   var oper = "check_del";
   
    // name이 같은 체크박스의 값들을 배열에 담는다.
    var checkboxValues = [];
    $("input[name='chk_mo_id']:checked").each(function(i) {
        checkboxValues.push($(this).val());
    });

	//alert(checkboxValues);
     
    // 사용자 ID(문자열)와 체크박스 값들(배열)을 name/value 형태로 담는다.
    var allData = {
		oper : oper,
		checkArray : checkboxValues,
			};
    
	if (confirm('정말로 등록하시겠습니까?'))
		{ 
		$.ajax({
			url:'./ajax/ajax_multi_income_update.php',
			type:'POST',
			data: allData,
			success:function(data){
			  //  alert("완료");
					$(".addrow").empty(); 
					getMoneyList();


			}

		});
	}
}




  var ITEM_CNT = 1;
function addRow(){


  	// $('#fileTable').append( row.replace(/ROWCNT/gi, ITEM_CNT) );

		appHtml = "<tr class='addrow'>\n";
			appHtml+= "<td ><div style='text-align:center;'>"+ITEM_CNT+"</div></td>\n";
			appHtml+= "<td><div class='input-group date' style='width:120px;'><input type='text' name='in_date' id='in_date_"+ITEM_CNT+"'  value=''  data-date-format='yyyy/mm/dd' class='form-control' style='width:120px;'><span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span></div></td>\n";

			appHtml+= "<td><input type='radio' name='part"+ITEM_CNT+"' id='item"+ITEM_CNT+"' value='1' style='width:20px;height:20px;' onclick=\"partVal("+ITEM_CNT+",this.value)\"><span>수입</span><input type='radio' name='part"+ITEM_CNT+"' value='2' onclick=\"partVal("+ITEM_CNT+",this.value)\" style='width:20px;height:20px;' checked><span>지출</span><input type='hidden' name='part_val' id='partVal_"+ITEM_CNT+"' value='2'>\n";
			appHtml+= "</td>\n";	
			
			appHtml+= "<td><div id='in_"+ITEM_CNT+"' style='display:none;'><select name='income_cd' id='income_"+ITEM_CNT+"' style='width:100px;height:28px;' ><option value='1'>회비</option><option value='2'>외주개발</option></select></div>\n";
			appHtml+= "<div id='out_"+ITEM_CNT+"' style='display:block;'><select name='outgo_cd' id='outgo_"+ITEM_CNT+"' style='width:100px;height:28px;'><option value='1'>연휴지급</option><option value='2'>물품구매</option></select></div>";
			appHtml+= "</td>\n";
			appHtml+= "<td><input type='text' name='price' id='price_"+ITEM_CNT+"' style='width:100px;'></td>\n";
			appHtml+= "<td><input type='text' name='memo' id='momo_"+ITEM_CNT+"' style='width:200px;'></td>\n";
			appHtml+= " <td><input type='hidden' name='num' id='num_"+ITEM_CNT+"' value='"+ITEM_CNT+"'  style='widtd:100px;'></td>\n";


		appHtml+= "</tr>\n";

		//$("#cash_list").prepend(appHtml); 
		$("#cash_list  thead").append(appHtml); 




ITEM_CNT++;
	}



function partVal(id,val){


  $("#partVal_"+id).val(val);

if(val==1){

	 $("#in_"+id).show(true);
	 $("#out_"+id).hide(true);
	 $('#income_'+id).removeAttr('disabled'); 
	 $('#outgo_'+id).attr('disabled', '');
	 
}else{
	 
	 $("#in_"+id).hide(true);
	 $("#out_"+id).show(true);
	 $('#income_'+id).attr('disabled', '');
	 $('#outgo_'+id).removeAttr('disabled'); 

}

}



function submitMulti(){

		//var myvalue = $("input[name=item1]").attr("value");
		var num = "";
		var cnt = 1;
		$("input[name=num]").each(function(){
			num += $(this).val()+",";
		
		cnt++;
		});


		var in_date = "";
		var cnt = 1;
		$("input[name=in_date]").each(function(){
			in_date += $(this).val()+",";
		
		if($("input[id=in_date_"+cnt+"]").val()==''){ 
			alert( cnt+'번째 항목을 입력하세요');return false; 
			}
	
		cnt++;

		});


		var part_val = "";
		var cnt = 1;
		$("input[name=part_val]").each(function(){
			part_val += $(this).val()+",";
		
		if($("input[id=partVal_"+cnt+"]").val()==''){ 
			alert( cnt+'번째 항목을 입력하세요');return false; 
			}
	
		cnt++;
		});



		var income_cd = "";
		var cnt = 1;
		$("select[name=income_cd]").each(function(){
			//in_cd += $(this).attr('value')+",";
			income_cd += $(this).val()+",";
		
		if($("select[id=income_"+cnt+"]").val()==''){ 
			alert( cnt+'번째 항목을 입력하세요');return false; 
			}
		cnt++;
		});




		var outgo_cd = "";
		var cnt = 1;
		$("select[name=outgo_cd]").each(function(){
			outgo_cd += $(this).val()+",";
		
		if($("select[id=outgo_cd_"+cnt+"]").val()==''){ 
			alert( cnt+'번째 항목을 입력하세요');return false; 
			}
		cnt++;
		});


		var cnt = 1;
		var price = "";
		$("input[name=price]").each(function(){
		//	price += $(this).attr('value')+",";
			price += $(this).val()+",";
		if($("input[id=price_"+cnt+"]").val()==''){ alert( cnt+'번째 항목을 입력하세요');return false; }
		cnt++;
		});


		var cnt = 1;
		var memo = "";
		$("input[name=memo]").each(function(){
			memo += $(this).val()+",";
		if($("input[id=memo_"+cnt+"]").val()==''){ alert( cnt+'번째 항목을 입력하세요');return false; }
		cnt++;
		});




	var postData;
		var rows = Object();
		var oper = 'multi_add';

		var rows= {
			oper : oper,
			num : num,
			in_date : in_date,
			part_val : part_val,
			income_cd : income_cd,
			outgo_cd : outgo_cd,
			price : price,
			memo : memo,
		};
	
		var postData = $.param(rows);

		if (confirm('정말로 등록하시겠습니까?'))
		{

		$.ajax({
			url:'./ajax/ajax_multi_income_update.php',
			data: postData,
			type:'post',
			dataType:'json',
			 contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			success:function(response) {
				var success = (response.flag == 'succ');

				$(".addrow").empty(); 
				getMoneyList();

			}
		});
	}

}

</script>

<?
	include_once("./tail.php");


			/*
				appHtml+= "	<select style='width:150px;height:26px;' class=\"class_arr\" name='class_arr' id='class_arr"+i+"' onchange=\"getClassSum(this.value,"+i+",1)\">\n";
				appHtml+= "		<option value=''>-선택-</option>\n";
				<?
				$tmp_res = mysql_query("select code,cd_name from psj_code where p_id ='classItem' && part = '2' and use_yn ='Y'  order by sortno desc");
				while($row_cd = mysql_fetch_array($tmp_res)){
				?>
					// appHtml+= "		<option value='<?=$row_cd['pi_id']."|".$row_cd['pi_turn']."|".$row_cd['pi_price']?>'><?=$row_cd['pi_subject']?></option>\n";
					appHtml+= "		<option value='<?=$row_cd['code']?>'><?=$row_cd['cd_name']?></option>\n";
				<? 
				} 
				?>
				appHtml+= "	</select>\n";
			*/



?>
