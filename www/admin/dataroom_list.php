<?
include_once("./_common.php");

		$item_per_page = 10;
		$sql = "SELECT COUNT(*)as cnt FROM psj_board_file";
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

          <h2 class="sub-header">자료실 목록</h2>

          <div class="table-responsive">

	<select class="selectpicker select_project" name="select_project" id="select_project" data-style="btn-default">
	 <option value="">선택하세요</option>
	<?
		$arr_project =  select_project();
		foreach($arr_project as $key => $val){
	?> 
	  <option value="<?=$key?>"><?=$val?></option>
	  <? } ?>
	</select>

            <table class="table table-striped">
              <thead>
                <tr>
				  <th><input type="checkbox" name="check_all" id="check_all" onclick="checkFunction()"></th>
                  <th>NO</th>
                  <th>파일NO</th>
                  <th>구분</th>
                  <th>파일명</th>
                  <th>작성자</th>
                  <th>등록일</th>
                  <th>수정</th>
                </tr>
              </thead>
			<tbody id="results"></tbody>
            </table>


		<div style="float:left;">

			<button type="button" class="btn btn-danger btn-sm" onclick="select_delete()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>선택삭제
			</button>

			<button type="button" class="btn btn-primary btn-sm"  id="write_btn2" onclick="location.href='./dataroom_write.php'">
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




<script type="text/javascript">

$(document).ready(function() {

	//$("#btn_search").trigger("click");
	get_member_row()

	// 그리드 검색
	$("#btn_search" ).on('click',function() { 
		get_member_row(); 
	});


	$("#write_btn" ).on('click',function() { 
		$("#seq").val('');
		$("#wr_id").val('');
		$("#bo_table_w").val('');
		$("#bf_file").val('');
		$("#bf_content").val('');
		$("#oper").val('add');
	});

	$("#btn_absent_close" ).on('click',function() { 
		$("#seq").val('');
		$("#wr_id").val('');
		$("#bo_table").val('');
		$("#bf_file").val('');
		$("#bf_content").val('');
		$('#file_name').html('');
		$('#del-btn').css("display","none");
	});


	$("#select_project").on('change',function() { 

	get_member_row();

	});


});


	
// 로데이터 AJAX 로깅
function get_member_row(){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var pj_id = $("#select_project").val();

	$("#results").load("./ajax/ajax_dataroom_row_data.php",{'search_field':s_field,'search_value':s_value,'pj_id':pj_id});


        var obj = $('.pagination').twbsPagination({
            totalPages: <?php echo $pages; ?>,
            visiblePages: 5,
            onPageClick: function (event, page) {

			  //  console.info(page);			  
		   	event.preventDefault();

			$("#results").load("./ajax/ajax_dataroom_row_data.php", {'page':page});
			
			}
        });
   
		console.info(obj.data());

}



</script>


<script>

        function fileSubmit(){	
	 

		var f = document.fileForm;

		if($("#oper").val()=='add'){

		if($("#bo_table").val()==''){
		 alert('구분을 선택하세요');
	          return false();
		}


		if($("#bf_file").val()==''){
		 alert('파일을 선택하세요');
		   return false();

		}
	}else if($("#oper").val()=='edit'){


		//alert($("#bo_table").val());

		if($("#bo_table").val()==''){
		 alert('구분을 선택하세요');
	          return false();
		}


	}

		 if(confirm("정말 저장 하시겠습니까?"))
		 {

				f.action = './dataroom_write_server.php';
				f.submit();

		  }else{ return false; } 


	
	}




       function filedelSubmit(){	
	 
		var f = document.fileForm;
		$("#oper").val('del');

		 if(confirm("선택된 데이터를 정말 삭제하시겠습니까?"))
		 {

				f.action = './dataroom_write_server.php';
				f.submit();
				
		  }else{ return false; } 

		}





function popEdit(id) {


//	console.log('getCustOrder',id);
	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_dataroom_load.php?id=' + id;
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
				//$('select[name=bo_table]').val(cell.bo_table);
				
				$('.bootstrap-select.bo_table .filter-option').text(cell.bo_subject);
				$('.bootstrap-select.project  .filter-option').text(cell.pj_subject);
				$('#bo_table').val(cell.bo_table);
				$('#ori_bo_table').val(cell.bo_table);
				$('#pj_id').val(cell.pj_id);
				$('#oper').val('edit');

				$('#file_name').html(cell.bf_source);				
				$('#bf_content').val(cell.bf_content);
				$('#del-btn').css("display","block");
				$('#seq').val(cell.seq);
				
				
				} else {
				alert('fail to load data');
			}
		}
	});
}



// 전체선택 / 해제
function checkFunction(){
    $('input:checkbox[name="check_all"]').change(function(){
        $('input:checkbox[name="chk_seq"]').each(function(){
            $(this).prop("checked",$('input:checkbox[name="check_all"]').prop("checked"));
        });
    })
}

//	선택삭제
function select_delete(){



   var oper = "check_del";
   
    // name이 같은 체크박스의 값들을 배열에 담는다.
    var checkboxValues = [];
    $("input[name='chk_seq']:checked").each(function(i) {
        checkboxValues.push($(this).val());
    });

	//alert(checkboxValues);
     
    // 사용자 ID(문자열)와 체크박스 값들(배열)을 name/value 형태로 담는다.
    var allData = {
		oper : oper,
		checkArray : checkboxValues,
			};
     
    $.ajax({
        url:"./dataroom_write_server.php",
        type:'POST',
        data: allData,
        success:function(data){
            alert("완료");
			get_member_row();

        }

    });
}

</script>

<?
	include_once("./tail.php");
?>
