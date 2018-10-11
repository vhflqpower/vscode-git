<?
	include_once("./_common_guest.php");


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
          <h2 class="sub-header">멤버 COUNT</h2>

          <div class="table-responsive">


			
	<form name="form1" method="get">
	<input type="hidden" name="status" value="<?=$_GET['status']?>">


                <section>
                    <table class="table table-sortable"  class="table">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
					<col width="5%">
					<col width="45%">
                        <thead>
                        <tr>
                            <th>NO</th>
                            <th>이름</th>
                            <th>정보게시판</th>
                            <th>이슈게시판</th>
                            <th>버그&제안</th>
                            <th>TOTAL</th>
                        </tr>
                        </thead>
                        <tbody   class="row_position" >
                 

<?




	$query = "SELECT mb_id,count(*)as cnt from psj_board where bo_table = 'info' group by mb_id ";
	$results = sql_query($query);
	$totalRows = sql_num_rows($results);	
	while($row = sql_fetch_array($results))
	{
	$id = $row['mb_id'];
	 $arr_info_count[$id] = $row['cnt'];
	}


	$query = "SELECT mb_id,count(*)as cnt from psj_issu where 1=1  group by mb_id ";
	$results = sql_query($query);
	while($row = sql_fetch_array($results)){
	$id = $row['mb_id'];
	 $arr_issu_count[$id] = $row['cnt'];
	}


	$query = "SELECT mb_id,count(*)as cnt from psj_board where bo_table = 'bugreport' group by mb_id ";
	$results = sql_query($query);
	$totalRows = sql_num_rows($results);	
	while($row = sql_fetch_array($results))
	{
	$id = $row['mb_id'];
	 $arr_bug_count[$id] = $row['cnt'];
	}




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

	$query = "SELECT a.mb_no,a.mb_id,a.mb_name          
	from psj_member a where a.mb_id in('whitedew','myroom123','spritoes','hodoole','dereklee','psj007','dlrldus') order by mb_10 desc ";
	$results = sql_query($query);

$num = 1;
	$totalRows = sql_num_rows($results);	
	while($row = sql_fetch_array($results))
	{

		$mb_id = $row['mb_id'];
		$pj_id = $row['pj_id'];
		$status = $row['is_status'];
		$date = $row['is_datetime'];

		 $is_date = short_date($date);


		 $total = $arr_info_count[$mb_id] +  $arr_issu_count[$mb_id] +  $arr_bug_count[$mb_id];

?>

	 <tr id="<?=$num?>" >
                            <td><?=$num?></td>
			<td><strong><?=$row['mb_name']?></strong></td>
                            <td><?=$arr_info_count[$mb_id]?>
						</td>
                            <td><?=$arr_issu_count[$mb_id]?>
                            <td><?=$arr_bug_count[$mb_id]?></td>
                            <td><?=$total?><!-- <span class="glyphicon glyphicon-move"></span> -->
							</td>
                        </tr>
<? 

	$num++;
	
	} ?>

                        </tbody>
                    </table>
                </section>
<!-- 
		<div style="float:left;height:50px;">
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./issu_write.php?part=account'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기
			</button>
			<input type="submit" class="btn btn-info btn-sm" value="정렬저장"   onClick="save();" />
		  </div>
 -->


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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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
