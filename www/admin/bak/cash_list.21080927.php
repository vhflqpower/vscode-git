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
            <table class="table table-striped" id="cash_list">
			<col width="5%">
			<col width="10%">
			<col width="10%">
			<col width="50%">
			<col width="10%">
			<col width="10%">
              <thead>
                <tr>
	       <th><input type="checkbox" name="check_all" id="check_all" onclick="checkFunction()"></th>
                  <th>NO</th>
                  <th>DATE</th>
                  <th>회원명</th>
                  <th>금액</th>
                  <th>SORT</th>
                  <th style="text-align:center;">수정</th>
                </tr>

                <!-- <tr>

 -->
              </thead>
			<tbody id="results"></tbody>
            </table>
			</form>

		<div style="float:left;">
			<!-- <button type="button" class="btn btn-danger btn-sm" onclick="select_delete()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>선택삭제
			</button>

			<button type="button" class="btn btn-primary btn-sm"  data-toggle='modal' data-target='#myModal'  id="write_btn">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			  	</button>
 -->
			<button type="button" class="btn btn-default btn-sm" onclick="addRow()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>+추가하기
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="submitMulti()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>

         </div>


						<div class="input-group date" style="width:200px;">
						<input type="text" name="pj_open_date"  value="<?=$view['pj_open_date']?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
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
        <h4 class="modal-title" id="myModalLabel">DIARY INFO</h4>
      </div>
      <div class="modal-body">
	<!-- <form name="frm1" method="post"> -->
			<form name="inputForm" id="inputForm" class="searchForm">
			<input type="hidden" name="wr_id" id="wr_id" value="">
	<!-- table start -->
		<table  class="table table-bordered table-hover">
		<col width="20%">
		<col width="80%">
		<tr>
		<th>DATE</th>
		<td><input type="text" id="wr_date" name="wr_date" style="width:30%;" ></td>
		</tr>
		<tr>
		<th>제목</th>
		<td><input type="text" id="wr_subject" name="wr_subject" style="width:100%;" >
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<textarea id="wr_content" name="wr_content" style="width:100%;height:200px;"></textarea>
		</td>
		</tr>
		</tbody>
		</table>
<!-- table end -->
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  id ="btn_absent_close" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary" id ="btn_absent" onclick="mbSubmit()">저장하기</button>
      </div>
    </div>
  </div>
</div>
<!-- Button trigger modal -->




<script type="text/javascript">

	  $(function(){
			$('.input-group.date').datepicker({
				calendarWeeks: false,
				todayHighlight: true,
				autoclose: true,
				format: "yyyy/mm/dd",
				language: "kr"
			});





	$('body').on('focus',".date", function(){
		$(this).datetimepicker();
	});​

		});



</script>


<script>



// 전체선택 / 해제
function checkFunction(){
    $('input:checkbox[name="check_all"]').change(function(){
        $('input:checkbox[name="chk_wr_id"]').each(function(){
            $(this).prop("checked",$('input:checkbox[name="check_all"]').prop("checked"));
        });
    })
}

//	선택삭제
function select_delete(){



   var oper = "check_del";
   
    // name이 같은 체크박스의 값들을 배열에 담는다.
    var checkboxValues = [];
    $("input[name='chk_wr_id']:checked").each(function(i) {
        checkboxValues.push($(this).val());
    });

	//alert(checkboxValues);
     
    // 사용자 ID(문자열)와 체크박스 값들(배열)을 name/value 형태로 담는다.
    var allData = {
		oper : oper,
		checkArray : checkboxValues,
			};
     
    $.ajax({
        url:"./account_update.php",
        type:'POST',
        data: allData,
        success:function(data){
            alert("완료");
	   get_account_row();

        }

    });
}




  var ITEM_CNT = 0;
function addRow(){


  	// $('#fileTable').append( row.replace(/ROWCNT/gi, ITEM_CNT) );


		appHtml = "<tr align=\"center\">\n";
			appHtml+= "<td style='border:0px'>"+ITEM_CNT+"</td>\n";
			appHtml+= " <td>NO</td>\n";
			
		//	appHtml+= "<td><input type='text' name='item1' id='item_"+ITEM_CNT+"' class='use-datepicker' value = <?echo date('Y-m-d')?> dateFormat='yy-mm-dd' style='widtd:100px;'></td>\n";
			
			appHtml+= "<td><div class='input-group date' style='width:200px;'><input type='text' name='in_date_"+ITEM_CNT+"' id='in_date_"+ITEM_CNT+"'  value=''  class='form-control' style='width:200px;'><span class='input-group-addon'><i class='glyphicon glyphicon-calendar'></i></span></div></td>\n";

			
			appHtml+= "<td><select name='item2' id='item2_"+ITEM_CNT+"'   style='widtd:70px;height:28px;'><option value='1'>수입</option><option value='2'>지출</option></select>\n";
			appHtml+= "<input type='text' name='item3' id='item3_"+ITEM_CNT+"'   style='widtd:100px;'>\n";
	
			appHtml+= "</td>\n";

			appHtml+= "<td><input type='text' name='item4'  style='widtd:100px;'></td>\n";
			appHtml+= "<td><input type='text' name='item5'  style='widtd:100px;'></td>\n";
			appHtml+= "<td></td>\n";
		appHtml+= "</tr>\n";

		//$("#cash_list").prepend(appHtml); 
		$("#cash_list tr:last").after(appHtml); 

ITEM_CNT++;
	}


function submitMulti(){


		//var myvalue = $("input[name=item1]").attr("value");

		var item1 = "";
		var cnt = 0;
		$("input[name=item1]").each(function(){
			item1 += $(this).val()+",";
		if($("input[id=item1_"+cnt+"]").val()==''){ alert( cnt+'번째 항목을 입력하세요');return false; }
		cnt++;
		});

		var cnt1 = 0;
		var item2 = "";
		$("input[name=item2]").each(function(){
			item2 += $(this).attr('value')+",";
		if($("input[id=item2_"+cnt1+"]").val()==''){ alert( cnt+'번째 항목을 입력하세요');return false; }
		cnt1++;
		});


		var cnt = 0;
		var item3 = "";
		$("input[name=item3]").each(function(){
			item3 += $(this).val()+",";

		if($("input[id=item3_"+cnt+"]").val()==''){ alert( cnt+'번째 항목을 입력하세요');return false; }
		cnt++;
		});


	var postData;
		var rows = Object();

		var oper = 'add';

		alert(item2);
		var rows= {
			oper : oper,
			item1 : item1,
			item2 : item2,
			item3 : item3,
		};
	
		var postData = $.param(rows);

		$.ajax({
			url:'./ajax/ajax_multi_income_update.php',
			data: postData,
			type:'post',
			dataType:'json',
			 contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			success:function(response) {
				var success = (response.flag == 'succ');



			}
		});
			

}

</script>

<?
	include_once("./tail.php");
?>
