<?
include_once("./_common.php");

		$item_per_page = 10;
		$sql = "SELECT COUNT(*)as cnt FROM psj_mileage";
		$result = sql_query($sql);
		$row = sql_fetch_array($result);
		$pages = ceil($row['cnt']/$item_per_page);


		$sql2 = "SELECT sum(mi_point)as total_mileage FROM psj_mileage";
		$result2 = sql_query($sql2);
		$row2 = sql_fetch_array($result2);

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
          <h2 class="sub-header">마일리지내역</h2>

          <div class="table-responsive">

	<select class="selectpicker mb_id" name="mb_id" id="mb_id">
		<option value="0">선택하세요</option>					
		<?
			$arr_member=  select_member();
			foreach($arr_member as $key => $val){
		?> 
		  <option value="<?=$key?>" <?if($key==$row['mb_id'])echo"selected"?>><?=$val?></option>
		  <? } ?>
	</select> <H3>Total:<span id="total"></span> 합계:<span id="total_sum">0</span></H3>

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
                  <th>DATE</th>
               <th>회원명</th>
				  <th>내역</th>
                  <th>마일리지</th>
                  <th>합계</th>
                  <th style="text-align:center;">수정</th>
                </tr>

                <!-- <tr>

 -->
              </thead>
			<tbody id="results"></tbody>
            </table>
			</form>

		<div style="float:left;">
			<button type="button" class="btn btn-danger btn-sm" onclick="select_delete()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>선택삭제
			</button>


			<button type="button" class="btn btn-primary btn-sm"  data-toggle='modal' data-target='#myModal'  id="write_btn">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			  	</button>

			<button type="button" class="btn btn-default btn-sm" onclick="addRow()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>+추가하기
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="submitMulti()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
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




<script type="text/javascript">

	  $(function(){
			$('.input-group.date').datepicker({
				calendarWeeks: false,
				todayHighlight: true,
				autoclose: true,
				format: "yyyy/mm/dd",
				language: "kr"
			});

		});






/*  페이징 카우트쿼리 */
var get_login_pages = function() {
   // var obj = '';

	var cell = '';

    $.ajax({
        type: "POST",
        url: "./ajax/ajax_rows_count_load.php",
        data: {
            "mb_id": encodeURIComponent($("#mb_id").val()),
			"part" : "mileage" 
        },
        cache: false,
        async: false,
         dataType:'json',
         contentType: "application/x-www-form-urlencoded; charset=UTF-8",
         success: function(response) {
          var success = (response.flag == 'succ');
		
		  cell = response.rows;

        }
    });

    return cell;
}



$(document).ready(function() {


	 var cnt_rows = get_login_pages();// 카운트쿼리
	 var total_cnt = cnt_rows['cnt'];
	 var total_page = cnt_rows['pages'];
	 var mileage_sum = cnt_rows['mileage_sum'];

	$("#total").html(total_cnt);
	$("#total_sum").html(mileage_sum);


	get_mileage_row(total_page);

    $('#login').attr("class", "list-group-item active");



	$("#mb_id").on('change',function() { 

	 var cnt_rows = get_login_pages();// 카운트쿼리
	 var total_cnt = cnt_rows['cnt'];
	 var total_page = cnt_rows['pages'];
	 var mileage_sum = cnt_rows['mileage_sum'];

	$("#total").html(total_cnt);
	$("#total_sum").html(mileage_sum);
	get_mileage_row(total_page);

	});



});


	
// 로데이터 AJAX 로깅
function get_mileage_row(total_page){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var mb_id = $("#mb_id").val();


 //        var totalCnt = get_account();// 카운트쿼리

	if(mb_id){
			 $('.pagination').twbsPagination('destroy');
	}

        var obj = $('.pagination').twbsPagination({

            totalPages:total_page,
            visiblePages:5,
            onPageClick: function (event, page) {

		
			  //  console.info(page);			  
		   	event.preventDefault();

			$("#results").load("./ajax/ajax_mileage_row_data.php", {'page':page,'mb_id':mb_id});
			
			}
        });
   

		//console.info(obj.data());

}




</script>


<script>


/*
$(document).ready(function() {
	
  $("#btn_reload").click(function(){
	write_form_reset()
  });
 });
*/



function write_form_reset(){

			$("#wr_id").val('');
			$("#wr_is_notice").val('');
			$("#wr_is_notice_view").val('');
			$("#wr_content").val('');
}


		function viewWriteForm() {


			$("#wr_id").val('');
			$("#wr_is_notice").val('');
			$("#wr_content").val('');
			$("#wr_is_notice_view").val('');


			var obj = document.getElementById("comment_write");  
			if(obj.style.display == "block") {
			obj.style.display = "none";

			} else {
			obj.style.display = "block";
			}
		} 



// 전체선택 / 해제
function checkFunction(){
    $('input:checkbox[name="check_all"]').change(function(){
        $('input:checkbox[name="chk_mi_id"]').each(function(){
            $(this).prop("checked",$('input:checkbox[name="check_all"]').prop("checked"));
        });
    })
}

//	선택삭제
function select_delete(){



   var oper = "check_del";
   
    // name이 같은 체크박스의 값들을 배열에 담는다.
    var checkboxValues = [];
    $("input[name='chk_mi_id']:checked").each(function(i) {
        checkboxValues.push($(this).val());
    });

	//alert(checkboxValues);
     
    // 사용자 ID(문자열)와 체크박스 값들(배열)을 name/value 형태로 담는다.
    var allData = {
		oper : oper,
		checkArray : checkboxValues,
			};
     
	if(confirm('정말 삭제 하시겠습니까?')) {
    $.ajax({
        url:"./mileage_update.php",
        type:'POST',
        data: allData,
        success:function(data){


		 var cnt_rows = get_login_pages();// 카운트쿼리
		 var total_cnt = cnt_rows['cnt'];
		 var total_page = cnt_rows['pages'];
		 var mileage_sum = cnt_rows['mileage_sum'];

		$("#total").html(total_cnt);
		$("#total_sum").html(mileage_sum);
		get_mileage_row(total_page);


        }

    });
	}
}



	
$(document).ready(function() {

	//$("#btn_search").trigger("click");

/*
	$("#search_company").on('change',function() { 
	//$(".page-item li").remove();
	setTimeout(function() {
	    get_account_row(totalCnt);
	}, 100);

	});
*/


});





  var ITEM_CNT = 0;
function addRow(){


  	// $('#fileTable').append( row.replace(/ROWCNT/gi, ITEM_CNT) );


		appHtml = "<tr align=\"center\">\n";
			appHtml+= "<th style='border:0px'>222</th>\n";
			appHtml+= " <th>NO</th>\n";
			appHtml+= "<th><input type='text' name='item1' id='item_"+ITEM_CNT+"' class='use-datepicker' value = <?echo date('Y-m-d')?> dateFormat='yy-mm-dd' style='width:100px;'></th>\n";
			appHtml+= "<th><select name='item2' id='item2_"+ITEM_CNT+"'   style='width:70px;height:28px;'><option value='1'>수입</option><option value='2'>지출</option></select>\n";
			appHtml+= "<input type='text' name='item3' id='item3_"+ITEM_CNT+"'   style='width:100px;'>\n";
	
			appHtml+= "</th>\n";

			appHtml+= "<th><input type='text' name='item4'  style='width:100px;'></th>\n";
			appHtml+= "<th><input type='text' name='item5'  style='width:100px;'></th>\n";
			appHtml+= "<th></th>\n";
		appHtml+= "</tr>\n";

		//$("#cash_list").prepend(appHtml); 
		$("#cash_list tr:first").after(appHtml); 

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
