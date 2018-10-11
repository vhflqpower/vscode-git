<?php


	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	require_once("./pagination.class.php");

	$perPage = new PerPage();


	$search_value = $_GET['search_value'];
	$p_id = $_GET["p_id"];


	//print_r($_GET);


	$WHERE = "";



	$where = " 1=1 AND is_id = '$p_id'";

	if($search_value) $where .= " AND wr_subject LIKE '%$search_value%'"; 


	$page = $_GET['page'];

	$rowcnt = sql_query("SELECT count(*) as cnt from psj_issu_log  where".$where);
	$cntsql = sql_fetch_array($rowcnt);

	$sql = "SELECT * from psj_issu_log where  ".$where." ORDER BY regdate DESC";

	$paginationlink = "/admin/ajax/ajax_issu_log_row_data.php?page=";				


	$total_count =$cntsql[cnt];

	$rows = 5;
	if (!$page) $page = 1;
	$total_page  = ceil($total_count / $rows);  
	$start = ($page - 1) * $rows;


	if($start < 0) $start = 0;

	$query =  $sql . " limit " . $start . "," . $rows;


	$result = sql_query($query);

	if(empty($_GET["rowcount"])) {

	}

		//echo $query;

	$perpageresult = $perPage->perpage($total_page, $paginationlink);




		//$str = url_auto_link($str);
?>

	<table class="table table-striped"  border="0" width="100%">
	<col width="100%">
<?

		while($row=sql_fetch_array($result)){

		$seq = $row['idx'];
		$co_subject = $row['subject'];
		$content_view = conv_content($row['content'], $html=0);
		$content = cut_str(conv_content($row['content'], $html=0),"300","...");

?>


		 <tr>
		<td >
			 <span style="color:#0000ff"><?=$row['regdate']?></span><br>
			<div class="progress" style="margin-bottom:5px;">
				  <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?=$row['percent'];?>%">  <?=$row['percent'];?>% <?=$row['regdate'];?>
				    <span class="sr-only">80% Complete (danger)</span>
				</div>
			</div>
			 <div style="padding-left:10px;"><?=$content;?></div><br>
			 <div id="edit_id_<?=$seq?>" style="display:none;"  class="content_warp">
			  <input type="text" id="co_subject_<?=$seq?>" value="<?=$co_subject?>"  placeholder="제목" class="form-control">
			 
			 <textarea class="form-control" id="content_<?=$seq?>" name="content_<?=$seq?>" rows="4" ><?=$row['content']?></textarea><input type="hidden" id="idx_<?=$seq?>" value="<?=$seq?>">
			 
				<div style="float:right;padding:6px;">	
					 <button type="button" class="btn btn-default btn-sm"  id="commAddCancle" onclick="comment_close()">
					<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
					 <button type="button" class="btn btn-primary btn-sm"  onclick="commSubmit_<?=$seq?>('edit')">
					<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>내역작성</button>
				</div>			 

			 </div>


			  <button type="button" class="btn btn-default btn-xs"  data-toggle='modal' data-target='#myModal<?=$seq?>' >
				<span class="glyphicon glyphicon-eye-open" aria-hidden="true" ></span>보기</button>

			  <button type="button" class="btn btn-default btn-xs"   onclick="commEdit_<?=$seq?>('<?=$seq?>');" >
				<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>

			  <button type="button" class="btn btn-default btn-xs"    onclick="commDelete_<?=$seq?>();" >
				<span class="glyphicon glyphicon-remove" aria-hidden="true" ></span>삭제</button>
			 
			

					<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
					  Modal 띄우기
					</button>
 -->
					<!-- Modal -->
					<div class="modal fade" id="myModal<?=$seq?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					  <div class="modal-dialog-lg" role="document">
					    <div class="modal-content">
					      <div class="modal-header" style="background-color:#ccc;">
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					        <h4 class="modal-title" id="myModalLabel">Modal 제목</h4>
					      </div>
					      <div class="modal-body">
					        <?=$content_view;?>
					      </div>
					      <div class="modal-footer" style="background-color:#ccc;">
					        <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
					      </div>
					    </div>
					  </div></div>


			 
			 </td>



<script>

function  commEdit_<?=$seq?>(seq){

	comment_close()
	$("#edit_id_<?=$seq?>").css("display","block");

	$("#add_content_form").css("display","none");

	

}



function commSubmit_<?=$seq?>(mode){	
	

	var idx = $("#idx_<?=$seq?>").val();

	var co_subject = $("#co_subject_<?=$seq?>").val();
	var co_content = $("#content_<?=$seq?>").val();

	if(!co_content) {
		$("#co_content").focus();
		alert('내용을 입력하세요.');
		return;
	}


	var postData;
	var rows = Object();
	var rows= {
			mode  : mode,
			idx : idx,
			co_subject : co_subject,
			co_content  : co_content,

		};

	var postData = $.param(rows);

	$.ajax({
		url: "./ajax/ajax_issu_log_content_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {


			//$("#co_content").val('');
			getresult('/admin/ajax/ajax_issu_log_row_data.php');
			comment_close();
			
			}



		}
	});
	
	return false;
	
}



function commDelete_<?=$seq?>(){	
	

	var idx = $("#idx_<?=$seq?>").val();


	if(!idx) {
		alert('삭제할 항목이 없습니다..');
		return;
	}


	var postData;
	var rows = Object();
	var rows= {
			mode  : 'del',
			idx : idx,


		};

	var postData = $.param(rows);

		if (confirm('정말로 삭제하시겠습니까?')){ 

	$.ajax({
		url: "./ajax/ajax_issu_log_content_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {
		
			getresult('/admin/ajax/ajax_issu_log_row_data.php');
			comment_close();

			}



		}
	});
	
		}
	return false;
	
}

function  comment_close(){

	$(".content_warp").css("display","none");
	$("#add_content_form").css("display","block");

}
</script>


			 </td>

		 </tr>


<?

		if(count($row) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
}
		echo " </tbody></table>";

echo "<button type='button' class='btn btn-primary btn-sm' onclick=\"location.href='./board_write.php?part=info'\">
				  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>등록하기
				</button>";


	
		if(!empty($perpageresult)) {
		$output .="<div align='center'>";
		$output .= "<nav>";
		$output .= $perpageresult;
		$output .= "</nav>";
		$output .= "</div>";
		}

print $output;
echo "<div style='height:70px;></div>";


?>


