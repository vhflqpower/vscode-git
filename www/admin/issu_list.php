<?
	include_once("./_common.php");


	include_once("./head.php");


?>

   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
       <!--
	<style>
        .table-sortable {
            position: relative;
        }
        .table-sortable .sortable-placeholder {
            height: 37px;
        }
        .table-sortable .sortable-placeholder:after {
            position: absolute;
            z-index: 10;
            content: " ";
            height: 37px;
            background: #f9f9f9;
            left: 0;
            right: 0;
        }
	</style>  -->

	 <script>
	  $(function() {
	    $( ".row_position" ).sortable({
	        delay: 150,
	        change: function() {
	    var selectedLanguage = new Array();
	    $('.row_position>tr').each(function() {
	    selectedLanguage.push($(this).attr("id"));
	    });
	    document.getElementById("row_order").value = selectedLanguage;
	    }
	   
	    });
	  });
	  
	  function save() { 
	    var data = new Array();
	    $('.row_position tr').each(function() {
	       data.push($(this).attr("id"));
	    });
	    
	    $.ajax({
	        url:"./issu_sort_proc.php",
	        type:'post',
	        data:{position:data},
	        success:function(){
		  alert('your change successfully saved');
	        }
	    })
	  }
	  </script>
	  <style>
	  .row_position{
	  cursor:move
	  }
	  </style>

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
          <h2 class="sub-header">이슈목록</h2>

          <div class="table-responsive">


			
	<form name="form1" method="get">
	<input type="hidden" name="status" value="<?=$_GET['status']?>">
	<!-- <input type="hidden" name="pj_id" value="<?=$_GET['pj_id']?>"> -->

	<div class="btn-group" role="group" aria-label="...">
	<? 
		for($i=1; $i<=count($arr_is_status); $i++){ 
	
		if($_GET[status]== $i){  $active='active'; }else{  $active='';     }
	?>
	  <button type="button" class="btn btn-default <?=$active?>"  onclick="location.href='./issu_list.php?status=<?=$i?>&pj_id=<?=$_GET[pj_id]?>'"><?=$arr_is_status[$i]?></button>
	<? } ?>

	</div>

	<select class=" project" name="pj_id" id="pj_id" onchange="document.form1.submit();" style="width:150px;height:32px;border-radius:4px;">
		  <option value="">프로젝트선택</option>			
		<?
			$arr_prject =  select_project();
			foreach($arr_prject as $key => $val){
		?> 
		  <option value="<?=$key?>" <?if($key==$_GET['pj_id'])echo"selected"?>><?=$val?></option>
		  <? } ?>
		</select>

	<div class="form-group pull-right" >
	   <input type="text" id="search_value" value="<?=$_POST['search_keyword']?>" class="form-control" placeholder="Search" onkeyup="getresult('/admin/ajax/ajax_board_row_data.php?bo_table=<?=$_GET['bo_table']?>&part=<?=$__GET['part']?>')">
	   <!-- <button type="button" id="btn_search" class="btn btn-info">검색하기</button> -->
	 </div> 
			
			</form>

                <section>
                    <table class="table table-sortable"  class="table">
					<col width="10%">
					<col width="5%">
					<col width="65%">
					<col width="10%">
					<col width="5%">
					<col width="5%">
                        <thead>
                        <tr>
                            <th>프로젝트명</th>
                            <th>담당자</th>
                            <th>제목</th>
                            <th>DATE</th>
                            <th>수정</th>
                            <th>MOVE</th>
                        </tr>
                        </thead>
                        <tbody   class="row_position" >
                 

<?

	$status = $_GET['status'];

	
	$where = "";

	if($member[mb_id] > 5 || $member[mb_id]=='admin'){

	$where .= " 1=1";
	}else{
		$where .= " 1=1 and a.mb_id ='$member[mb_id]'";

	}



	if(!$_GET['status']){
	$where .= "  and a.is_status = '3'";
	}else{
	$where .= "  and a.is_status = '$status'";
	}

	if($_GET['pj_id']){
	$where .= "  and a.pj_id = '$pj_id'";
	}

	$query = "SELECT a.is_id,a.is_subject,a.is_status,a.is_datetime,a.is_status,a.is_sort,a.is_proc_percent,a.wr_name,
				(select b.pj_subject from psj_project b where b.pj_id = a.pj_id) as project FROM psj_issu a where ".$where." ORDER BY a.is_sort ASC";
	$results = sql_query($query);


	$totalRows = sql_num_rows($results);	
	while($row = sql_fetch_array($results))
	{

		$is_id = $row['is_id'];
		$pj_id = $row['pj_id'];
		$status = $row['is_status'];
		$date = $row['is_datetime'];

		 $is_date = short_date($date);

?>

	 <tr id="<?php echo $row['is_id']; ?>" >
                            <td><?=$row['project']?></td>
			<td><strong><?=$row['wr_name']?></strong></td>
                            <td><?=$row['is_sort']?>)<a href="./issu_view.php?is_id=<?=$row[is_id]?>&part=issu"><strong><?=$row[is_subject]?></strong></a>
				<a href="#1" id="issu_log_btn_<?=$is_id?>">[내역보기]
			<?if($status < 5){?>

					<div class="progress">
					  <div class="progress-bar <?=$arr_proc_status[$status]?> <?if($status < 5)echo'active';?>" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:<?=$row['is_proc_percent']?>%">
						<span class="sr-only">80% Complete (danger)</span>
					  </div>
					  </div>	
					  <? } ?>
						</td>
                            <td><?=$is_date?></td>
                            <td><?=$arr_is_status[$status]?></td>
                            <td><span class="glyphicon glyphicon-move"></span>
							
						<script>

							$("#issu_log_btn_<?=$is_id?>").on("click", function(){
								cw=screen.availWidth;     //화면 넓이
								ch=screen.availHeight;    //화면 높이

								sw=1024;    //띄울 창의 넓이
								sh=780;    //띄울 창의 높이

								ml=(cw-sw)/2;        //가운데 띄우기위한 창의 x위치
								mt=(ch-sh)/2;         //가운데 띄우기위한 창의 y위치
								 window.open('./issu_his_list.php?is_id=<?=$row[is_id]?>','popup_window','width='+sw+',height='+sh+',top=0,left='+ml+',resizable=no,scrollbars=yes');
							});


						</script>
							
							
							</td>
                        </tr>
<? } ?>

                        </tbody>
                    </table>
                </section>

		<div style="float:left;height:50px;">
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./issu_write.php?part=account'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			</button>

			<input type="submit" class="btn btn-info btn-sm" value="정렬저장"   onClick="save();" />
			<input type="button" class="btn btn-default btn-sm" value="이슈내역보기"   onClick="location.href='./issu_his_list_search.php?part=issu';" />
         </div>



		<!-- <div align="center">
			<div class="pagination" ></div>
		</div> -->

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





$(document).ready(function() {
	//$("#btn_search").trigger("click");
	get_member_row()

});


	

function get_member_row(){

	var s_field = $("#search_field").val();
	var s_value = $("#search_value").val();
	var ca_name = $("#ca_name").val();

	$("#results").load("./ajax/ajax_issu_row_data.php",{'search_field':s_field,'search_value':s_value,'ca_name':ca_name});

	$(".pagination").bootpag({
	   total: <?php echo $pages; ?>,
	   page: 1,
	   maxVisible: 5, 
	}).on("page", function(e, num){

		e.preventDefault();
		$("#results").load("./ajax/ajax_issu_row_data.php", {'page':num});
	});


}

    $(function () {
		$(".bootpag").remove();
        var obj = $('.pagination').twbsPagination({
            totalPages: <?php echo $pages; ?>,
            visiblePages: 5,
            onPageClick: function (event, page) {
                console.info(page);
            }
        });
        console.info(obj.data());
    });




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

</script>


    <!-- Latest compiled and minified JavaScript -->

    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
 -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
	<script src="./js/jquery.sortable.js"></script> 
	
	
	<script>

		$(function() {
            $('.thumbnail-sortable').sortable({
                placeholderClass: 'col-sm-6 col-md-4'
            });

            $('.table-sortable2 tbody').sortable({
                handle: 'span'
            });

            $('.table-sortable tbody').sortable({
                handle: 'span'
            });
            $('.list-group-sortable').sortable({
                placeholderClass: 'list-group-item'
            });
            $('.list-group-sortable-exclude').sortable({
                placeholderClass: 'list-group-item',
                items: ':not(.disabled)'
            });
            $('.list-group-sortable-handles').sortable({
                placeholderClass: 'list-group-item',
                handle: 'span'
            });
            $('.list-group-sortable-connected').sortable({
                placeholderClass: 'list-group-item',
                connectWith: '.connected'
            });
		});
	
	</script>



<?
	include_once("./tail.php");
?>
