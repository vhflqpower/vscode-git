<?
	include_once("../common.php");


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

          <h2 class="sub-header">담당자 목록</h2>

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
	<button type="button" id="btn_search" class="btn btn-default">검색하기</button>

            <table class="table table-striped">
              <thead>
                <tr>
			  <th><input type="checkbox" name="check_all" id="check_all" onclick="checkFunction()"></th>
                  <th style="text-align:center;">NO</th>
                  <th>업체</th>
                  <th>담당자명</th>
                  <th>휴대전화</th>
                  <th>일반전화</th>
				  <th>Email</th>
                  <th>수정</th>
                </tr>
              </thead>
			<tbody id="results"></tbody>
            </table>


		<div style="float:left;" class="btn_area">
			<button type="button" class="btn btn-danger btn-sm" onclick="select_delete()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>선택삭제
			</button>


			<button type="button" class="btn btn-primary btn-sm"  data-toggle='modal' data-target='#myModal'  id="write_btn">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
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
		<style>
			/* Style the tab content */
			.btn_area{
				display: block;
				padding: 6px 0px;
				-webkit-animation: fadeEffect 2s;
				animation: fadeEffect 2s;
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


<!-- Button trigger modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">FILE INFO</h4>
      </div>
      <div class="modal-body">
	<form name="managerForm" id="managerForm" method="post" action="./manager_update.php" onSubmit="return fileSubmit(f)" enctype="multipart/form-data" >
	<input type="hidden" name="mb_no" id="mb_no" value="<?=$view['mb_no']?>" />
	<input type="hidden" name="mb_email_enabled"    value="" id="mb_email_enabled">
	<input type="hidden" name="oper"  id="oper" value="add" />

	<!-- table start -->
		<table  class="table table-bordered table-hover">
		<col width="20%">
		<col width="80%">
		<tr>
		<th>구분</th>
		<td>
			<select class="selectpicker company" name="co_id" id="co_id">
			  <option value="">선택하세요</option>			
			<?
			foreach($arr_company as $key => $val){
			?> 
			  <option value="<?=$key?>"><?=$val?></option>
			  <? } ?>
			</select>
			
		</td>
		</tr>
		<tr>
		<th>담당명(직급)</th>
		<td><input type="text" name="mb_name" id="mb_name" value="" class="form-control"  style="width:40%;"/>
		
			<select class="selectpicker levelname" name="levelname" id="levelname">
			  <option value="">선택하세요</option>			
			<?
			 $arr_level_info =  select_info_gubun('300000');
			foreach($arr_level_info as $key => $val){
			?> 
			  <option value="<?=$key?>"><?=$val[0]?></option>
			  <? } ?>
			</select>
		</td>
		</tr>
		<tr>
		<th>휴대전화</th>
		<td><input type="text" name="mb_hp" id="mb_hp" value="" class="form-control"  /></td>
		</tr>
		<tr>
		<th>일반전화</th>
		<td><input type="text" name="mb_tel" id="mb_tel" value="" class="form-control"  /></td>
		</tr>
		<tr>
		<th>이메일</th>
		<td><input type="text" name="mb_email" id="reg_mb_email" value="" class="form-control"  onblur='reg_mb_email_check();'/>
		<span id='msg_mb_email'></span>
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<textarea  class="form-control" id="mb_memo" name="mb_memo" style="width:100%;height:160px;"></textarea>
		</td>
		</tr>
		</tbody>
		</table>
<!-- table end -->
	
      </div>
      <div class="modal-footer">
		<div style="display:none;float:left;" id="del-btn">
        <button type="button" class="btn btn-danger" id ="btn_absent" onclick="managerSubmit('del')">삭제</button>
         </div>
		<button type="button" class="btn btn-default"  id ="btn_manager_close" data-dismiss="modal">닫기</button>
        <button type="button" class="btn btn-primary" id ="btn_absent" onclick="managerSubmit()">저장하기</button>
      </div>
    </div>
  </div>
</div>	</form>
<!-- Button trigger modal -->




<script type="text/javascript">





// 추천인 검사
var mbpages = function() {


    var co_id = $('#search_company').val();


    var result = "";
    $.ajax({
        type: "POST",
        url: "./ajax/ajax_manager_cnt.php",
        data: {
            "co_id": co_id
        },
        cache: false,
        async: false,
        success: function(data) {
		
		 result = data;

        }
    });


    return result;
}


function get_member_row(){

		var co_id = $("#search_company").val();

		var total_page = mbpages();

   var $pagination = $('.pagination');
    var defaultOpts = {
        totalPages: total_page
    };
    $pagination.twbsPagination(defaultOpts);

		
		 $.ajax({
			type: "POST",
			url: "./ajax/ajax_manager_cnt.php",
			data: {
				"co_id": co_id
			},
			cache: false,
			async: false,
			success: function(data) {	
				

				var totalPages = data;   // data.newTotalPages
				var currentPage = $pagination.twbsPagination('getCurrentPage');


			//	alert(currentPage+'<--currentPage');	
				//if(data < 1){ var currentPage =1; }
						
				$pagination.twbsPagination('destroy');
				$pagination.twbsPagination($.extend({}, defaultOpts, {
					startPage: currentPage,
					totalPages: totalPages,

					onPageClick: function (event, page) {
						
						$("#results").load("./ajax/ajax_manager_row_data.php", {'page':page,'co_id':co_id});
				  
				}


				}));
			

			}
		});



/*
$('.pagination').twbsPagination({
        totalPages: 3,
        visiblePages: 5,
        onPageClick: function (event, page) {
				
				$("#results").load("./ajax/ajax_manager_row_data.php", {'page':page,'co_id':co_id});
          
        }

    });
*/

}


//function get_member_row(){
/*

   var $pagination = $('.pagination');
    var defaultOpts = {
        totalPages: 3
    };
    $pagination.twbsPagination(defaultOpts);
    		 $.ajax({
			type: "POST",
			url: "./ajax/ajax_manager_cnt.php",
			data: {
				"co_id": co_id
			},
			cache: false,
			async: false,
			success: function(data) {

            var totalPages = data.newTotalPages;
            var currentPage = $pagination.twbsPagination('getCurrentPage');
            $pagination.twbsPagination('destroy');
            $pagination.twbsPagination($.extend({}, defaultOpts, {
                startPage: currentPage,
                totalPages: totalPages
            }));
        }
    });
*/
//}
	
// 로데이터 AJAX 로깅

/*
function get_member_row(){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var co_id = $("#search_company").val();


	var pages = mbpages();
	

	 var $pagination = $('.pagination');
		var defaultOpts = {
			totalPages: pages
		};

	
	#$("#results").load("./ajax/ajax_manager_row_data.php",{'page':'1','search_field':s_field,'search_value':s_value,'co_id':co_id});


		$pagination.twbsPagination(defaultOpts)
		
		 $.ajax({
			type: "POST",
			url: "./ajax/ajax_manager_cnt.php",
			data: {
				"co_id": co_id
			},
			cache: false,
			async: false,
			success: function(data) {	
				

				var totalPages = data;   // data.newTotalPages
				var currentPage = $pagination.twbsPagination('getCurrentPage');

			
				$pagination.twbsPagination('destroy');
				$pagination.twbsPagination($.extend({}, defaultOpts, {
					startPage: currentPage,
					totalPages: totalPages,

#
				     onPageClick: function (event, page) {

							 #console.info(page);			  
							event.preventDefault();

							
							}
#

				}));

					$("#results").load("./ajax/ajax_manager_row_data.php", {'page':page});
							

			}
		});

*/


/*
	$("#results").load("./ajax/ajax_manager_row_data.php",{'page':'1','search_field':s_field,'search_value':s_value,'co_id':co_id});

        var obj = $('.pagination').twbsPagination({
            totalPages: pages,//<?php echo $pages; ?>,
            visiblePages: 5,
            onPageClick: function (event, page) {

			  #console.info(page);			  
		   	event.preventDefault();

			$("#results").load("./ajax/ajax_manager_row_data.php", {'page':page});
			
			}
        });
   
		#console.info(obj.data());
	

}


*/


</script>


<script>


	 


//------------------------------------------------------------------> 담당자 정보업데이트
        function managerSubmit(oper){	

	var postData;
	var rows = Object();

	if(!oper){
	var oper = $('#oper').val();
	}

	var mb_no = $('#mb_no').val();
	var co_id = $('#co_id').val();
	var mb_name = $('#mb_name').val();
	var mb_hp = $('#mb_hp').val();
	var mb_tel = $('#mb_tel').val();
	var mb_email = $('#reg_mb_email').val();
	var mb_memo = $('#mb_memo').val();
	var levelname = $('#levelname').val();

/*
        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }
*/

	if(mb_name == ''){
		alert('회원명은 필수입니다');
		$('#mb_name').focus();
		return;
	}


	var rows= {

		oper : oper,
		mb_no : mb_no,
		mb_name : mb_name,
		mb_hp : mb_hp,
		mb_tel : mb_tel,
		mb_email : mb_email,
		co_id : co_id,
		levelname : levelname,
		mb_memo : mb_memo,

	};
	
	var postData = $.param(rows);
	var url = './ajax/ajax_manager_update.php'//url 수정;
	
		
		if(oper=='del'){
		var msg ="선택된 데이터를 정말 삭제하시겠습니까?";
		}else if(oper=='edit'){
		var msg ="선택된 데이터를 정말 수정하시겠습니까?";
		
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

			get_member_row(); 
			
			$("#btn_manager_close").trigger("click");

			}
		});

	return;
	}

} 


       function filedelSubmit(){	
	 
		var f = document.fileForm;
		$("#oper").val('del');

		 if(confirm("선택된 데이터를 정말 삭제하시겠습니까?"))
		 {

				f.action = './dataroom_update.php';
				f.submit();
				
		  }else{ return false; } 

		}





function popEdit(id) {


//	console.log('getCustOrder',id);
	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_member_load.php?id=' + id;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
       contentType: "application/x-www-form-urlencoded; charset=UTF-8",

		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩

			if(success) {
							
				var cell = response.rows;
				//$('select[name=wr_bo_table]').val(cell.bo_table);
				//$('.bootstrap-select .filter-option').val(cell.mb_1);

				$('.bootstrap-select.company .filter-option').text(cell.company);
				$('#co_id').val(cell.mb_1);

				$('.bootstrap-select.levelname .filter-option').text(cell.levelname);
				$('#mb_2').val(cell.mb_2);

				$('#mb_no').val(cell.mb_no);				
				$('#mb_name').val(cell.mb_name);
				$('#mb_hp').val(cell.mb_hp);
				$('#mb_tel').val(cell.mb_tel);
				$('#reg_mb_email').val(cell.mb_email);
				$('#mb_no').val(cell.mb_no);	
				$('#co_id').val(cell.mb_1);
				$('#mb_memo').val(cell.mb_memo);
				$('#oper').val('edit');

				$('#bf_content').val(cell.bf_content);
				$('#del-btn').css("display","block");
				$('#seq').val(cell.seq);
				
				
				} else {
				alert('fail to load data');
			}
		}
	});
}


/*
var reg_mb_email_check = function() {

	var member_skin_path = './ajax';

    $.ajax({ 
        type: 'POST',
        url: member_skin_path+'/ajax_mb_email_check.php',
        data: {
            'mb_email': encodeURIComponent($('#reg_mb_email').val())
        },
        cache: false,
        async: false,
        success: function(result) {
            var msg = $('#msg_mb_email');
            switch(result) {
                case '110' : msg.html('영문자, 숫자, _ 만 입력하세요.').css('color', 'red'); break;
                case '120' : msg.html('최소 4자이상 입력하세요?.').css('color', 'red'); break;
                case '130' : msg.html('이미 사용중인 코드.').css('color', 'red'); break;
                case '140' : msg.html('예약어로 사용할 수 없는 아이디 입니다.').css('color', 'red'); break;
                case '000' : msg.html('사용가능 코드.').css('color', 'blue'); break;
                default : alert( '잘못된 접근입니다.\n\n' + result ); break;
            }
            $('#mb_email_enabled').val(result);
        }
    });
}
*/
var reg_mb_email_check = function() {
    var result = "";

    $.ajax({
        type: "POST",
        url: "./ajax/ajax.mb_email.php",
        data: {
            "reg_mb_email": $("#reg_mb_email").val(),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(data) {
            result = data;
        }
    });
    return result;
}




// 전체선택 / 해제
function checkFunction(){
    $('input:checkbox[name="check_all"]').change(function(){
        $('input:checkbox[name="chk_mb_no"]').each(function(){
            $(this).prop("checked",$('input:checkbox[name="check_all"]').prop("checked"));
        });
    })
}

//	선택삭제

/*
function select_delete(){



   var oper = "check_del";
   
    // name이 같은 체크박스의 값들을 배열에 담는다.
    var checkboxValues = [];
    $("input[name='chk_mb_no']:checked").each(function(i) {
        checkboxValues.push($(this).val());
    });

	//alert(checkboxValues);
     
    // 사용자 ID(문자열)와 체크박스 값들(배열)을 name/value 형태로 담는다.
    var allData = {
		oper : oper,
		checkArray : checkboxValues,
			};
     
    $.ajax({
        url:"./manager_update.php",
        type:'POST',
        data: allData,
        success:function(data){
            alert("완료");
			get_member_row();

        }

    });
}
*/
$(document).ready(function() {

	//$("#btn_search").trigger("click");
	
	get_member_row();



	$("#search_company").on('change',function() { 
		get_member_row();
		//searchCount();
	});


	$("#write_btn" ).on('click',function() { 
		$("#seq").val('');
		$("#wr_id").val('');
		$("#bo_table_w").val('');
		$("#bf_file").val('');
		$("#bf_content").val('');
	});

	$("#btn_manager_close" ).on('click',function() { 
		
		$('.bootstrap-select.company .filter-option').text('');
		$('.bootstrap-select.levelname .filter-option').text('');
		$('#mb_no').val('');
		$('#co_id').val('');
		$('#mb_name').val('');
		$('#mb_hp').val('');
		$('#mb_tel').val('');
		$('#reg_mb_email').val('');
		$('#mb_memo').val('');

	});




});

</script>

<?
	include_once("./tail.php");
?>
