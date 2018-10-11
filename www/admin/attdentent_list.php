<?
include_once("./_common.php");

		$item_per_page = 10;
		$sql = "SELECT COUNT(*)as cnt FROM psj_account";
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
			<button type="button" class="btn btn-danger btn-sm" onclick="select_delete()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>선택삭제
			</button>


			<button type="button" class="btn btn-primary btn-sm"  data-toggle='modal' data-target='#myModal'  id="write_btn">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			  	</button>

			<button type="button" class="btn btn-default btn-sm" onclick="addRow()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>추가하기
			</button>

			<button type="button" class="btn btn-default btn-sm" onclick="submitMulti()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>추가하기
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

		});


/*  페이징 카우트쿼리 */
var get_account = function() {
    var cnt = '';
    $.ajax({
        type: "POST",
        url: "./ajax/ajax_account_cnt_load.php",
        data: {
            "co_id": encodeURIComponent($("#search_company").val())
        },
        cache: false,
        async: false,
         dataType:'json',
         contentType: "application/x-www-form-urlencoded; charset=UTF-8",
         success: function(response) {
          var success = (response.flag == 'succ');
	cnt = response.cnt;

        }
    });

    return cnt;
}



	
// 로데이터 AJAX 로깅
function get_account_row(cnt){



	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();

	var co_id = $("#search_company").val();




         var totalCnt = get_account();// 카운트쿼리


        var obj = $('.pagination').twbsPagination({

            totalPages: totalCnt,
            visiblePages: 5,
            onPageClick: function (event, page) {

		
			  //  console.info(page);			  
		   	event.preventDefault();

			$("#results").load("./ajax/ajax_fee_data.php", {'page':page,'co_id':co_id});
			
			}
        });
   
 if(co_id){  


	
	$("#results").load("./ajax/ajax_fee_data.php",{'search_field':s_field,'search_value':s_value,'co_id':co_id});
     
         var totalCnt = get_account();// 카운트쿼리


        var obj = $('.pagination').twbsPagination({

            totalPages: totalCnt,
            visiblePages: 5,
            onPageClick: function (event, page) {

		
			  //  console.info(page);			  
		   	event.preventDefault();

			$("#results").load("./ajax/ajax_fee_data.php", {'page':page,'co_id':co_id});
			
			}
        });



 }
		//console.info(obj.data());

}




//------------------------------------------------------------------> 코멘트업데이트
function memoSubmit() {
 
	var postData;
	var rows = Object();

	var oper = $('#oper').val();

	var wr_id = $('#wr_id').val();
	var wr_content = $('#wr_content').val();


	if ( $("#wr_is_notice").is(":checked") == true ){
	var wr_is_notice ='1';
	}else{
	var wr_is_notice ='';
	}


		
	if(wr_content == ''){
		alert('내용은 필수입니다');
		$('#wr_content').focus();
		return;
	}


	var rows= {

		oper : oper,
		wr_id : wr_id,
		wr_content : wr_content,
		wr_is_notice : wr_is_notice,

	};
	
	var postData = $.param(rows);
	var url = './ajax_memo_server.php'//url 수정;
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
			
			$('#wr_id').val();
			$('#wr_content').val('');

				write_form_reset()

			$("#btn_search").trigger("click");
			}
		});

	return;

} 





function memoEdit(id) {



		$("#comment_write").css("display","block"); 

		$("input:checkbox[name='wr_is_notice']").attr('checked', false);	
		$('#wr_is_notice_view').val('');

//	console.log('getCustOrder',id);
	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax_memo_load.php?id=' + id;
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
			//데이타 로딩
			if(success) {
				var cell3 = response.rows;


				$('#wr_id').val(cell3.wr_id);
				$('#wr_content').val(cell3.wr_content);
				

				var val = cell3.wr_is_notice;

				if(cell3.wr_is_notice==1){
					
					//$("input[id=wr_is_notice][value=" + val + "]").attr("checked", true);
					//$("input:checkbox[name='wr_is_notice']").attr("checked", true);	
					
					$('input:checkbox[id="wr_is_notice"]').attr("checked", true); 


					$('#wr_is_notice_view').val('공지사항');

				}
				
				
				} else {
				alert('fail to load data');
			}
		}
	});
}




function memoNew(id) {

	$('#oper').val('write');
	$('#wr_id').val('');
	$('#wr_content').val('');


}


//------------------------------------------------------------------> 코멘트삭제
function memoDelete(id) {
 
	var postData;
	var rows = Object();

	var oper = 'del';
	var wr_id = id;

	var rows= {
		oper : oper,
		wr_id : wr_id,

	};
	
	var postData = $.param(rows);
	var url = './ajax_memo_del_server.php'//url 수정;
	
	var msg = '메모를 정말 삭제하시겠습니까?';
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
				var new_id = response.id;
				var msgs = response.msg2;


				$('#oper').val('del');
				$('#wr_id').val();
				$('#wr_content').val('');

				$("#btn_search").trigger("click");

			}
		});
	}

	return;

} 


</script>


<script>


$(document).ready(function() {
	
  $("#btn_reload").click(function(){
	write_form_reset()
  });
 });




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



	
$(document).ready(function() {

	//$("#btn_search").trigger("click");


	get_account_row('<?=$pages?>');

	//get_account();

	$("#search_company").on('change',function() { 



	//$(".page-item li").remove();

	 var totalCnt = get_account();// 카운트쿼리

	get_account_row(totalCnt);
/*
	setTimeout(function() {
	    get_account_row(totalCnt);
	}, 100);
*/
	 
	});



});





  var ITEM_CNT = 0;
function addRow(){


  	// $('#fileTable').append( row.replace(/ROWCNT/gi, ITEM_CNT) );


		appHtml = "<tr align=\"center\">\n";
			appHtml+= "<th style='border:0px'>222</th>\n";
			appHtml+= " <th>NO</th>\n";
			appHtml+= "<th><input type='text' name='item1' id='item_"+ITEM_CNT+"' class='use-datepicker' value = <?echo date('Y-m-d')?> dateFormat='yy-mm-dd' style='width:100px;'></th>\n";
			appHtml+= "<th><input type='text' name='item2' id='item2_"+ITEM_CNT+"'  style='width:100px;'></th>\n";
			appHtml+= "<th><input type='text' name='item3'  style='width:100px;'></th>\n";
			appHtml+= "<th><input type='text' name='item4'  style='width:100px;'></th>\n";
			appHtml+= "<th></th>\n";
		appHtml+= "</tr>\n";

		//$("#cash_list").prepend(appHtml); 
		$("#cash_list tr:first").after(appHtml); 

ITEM_CNT++;
	}


function submitMulti(){


		//var myvalue = $("input[name=item1]").attr("value");

		var item1 = "";
		var item2 = "";
		var cnt = 0;
		$("input[name=item1]").each(function(){
			item1 += $(this).attr('value')+",";
			//item2 += $("input[name=item2]").val()+",";

		if($("input[id=item2_"+cnt+"]").val()==''){ alert( cnt+'번째 항목을 입력하세요');return false; }

		cnt++;
		});



	var postData;
		var rows = Object();

		var oper = 'add';

		var rows= {
			oper : oper,
			item1 : item1,

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
