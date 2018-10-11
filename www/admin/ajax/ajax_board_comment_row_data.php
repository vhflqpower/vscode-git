<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	require_once("./pagination.class.php");

	$perPage = new PerPage();


	$search_value = $_GET['search_value'];
	$is_id = $_GET['is_id'];
	$bo_table = $_GET['bo_table'];

	$WHERE = "";

	if($_GET['search_value']){ 
		$WHERE .= " and wr_subject LIKE '%$search_value%'"; 
		}


	$page = $_GET['page'];

	$rowcnt = sql_query("SELECT count(*) as cnt from psj_board_comment  where 1=1 and bo_table='$bo_table' and p_id ='$p_id' ".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);

	$sql = "SELECT * from psj_board_comment where 1=1 and bo_table='$bo_table' and p_id ='$p_id'  ".$WHERE." ORDER BY co_datetime DESC";
	$paginationlink = "/admin/ajax/ajax_board_comment_row_data.php?page=";				


	$total_count =$cntsql[cnt];

	$rows = 10;
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
?>

	<table class="table table-striped">
	<col width="100%">

	  <tbody >
<?

		while($row=sql_fetch_array($result)){

		$seq = $row['seq'];
		$wr_id = $row['wr_id'];
		$c1 = $row['wr_cat1'];
		$c2 = $row['wr_cat2'];
		$wr_name = $row['wr_name'];
		$co_datetime = $row['co_datetime'];

		$str = nl2br($row['co_content']);
		$co_content = conv_content($row['co_content'], $html=0);
?>
	
		 <tr>



			 <td style='padding-left:20px;'>
			 <span style="color:#0000ff"><?=$co_datetime?></span><?=$wr_name?><br>

			 <div style="padding-left:10px;"><?=$co_content;?></div><br>
			 <div id="edit_id_<?=$seq?>" style="display:none;"  class="content_warp">
			 
			 
			 <textarea class="form-control" id="content_<?=$seq?>" name="content_<?=$seq?>" rows="4" ><?=$row['co_content']?></textarea><input type="hidden" id="idx_<?=$seq?>" value="<?=$seq?>">
			 
				<div style="float:right;padding:6px;">	
					 <button type="button" class="btn btn-default btn-sm"  id="commAddCancle" onclick="comment_close()">
					<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
					 <button type="button" class="btn btn-primary btn-sm"  onclick="commSubmit_<?=$seq?>('edit')">
					<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>내역작성</button>
				</div>			 

			 </div>

			  <button type="button" class="btn btn-default btn-xs"   onclick="commEdit_<?=$seq?>('<?=$seq?>');" >
				<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>

			  <button type="button" class="btn btn-default btn-xs"    onclick="commDelete_<?=$seq?>();" >
				<span class="glyphicon glyphicon-remove" aria-hidden="true" ></span>삭제</button>




<script>

function  commEdit_<?=$seq?>(seq){

	comment_close()
	$("#edit_id_<?=$seq?>").css("display","block");

	$("#add_content_form").css("display","none");

	

}



function commSubmit_<?=$seq?>(mode){	
	

	var p_id = $('#p_id').val();
	var bo_table = $('#bo_table').val();
	var idx = $("#idx_<?=$seq?>").val();
	var co_content = $("#content_<?=$seq?>").val();

	var idx = $("#idx_<?=$seq?>").val();

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
			co_content  : co_content,
		};

	var postData = $.param(rows);

	$.ajax({
		url: "./ajax/ajax_board_comment_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {


			//$("#co_content").val('');
			// $(".comm_row").remove();
			//get_comment_row();
			getresult('/admin/ajax/ajax_board_comment_row_data.php');
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
		url: "./ajax/ajax_board_comment_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {

			//get_comment_row();
			getresult('/admin/ajax/ajax_board_comment_row_data.php');
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
		
}
		//if($total_count < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }
		echo " </tbody></table>";

		//echo "<button type='button' class='btn btn-primary btn-sm' onclick=\"location.href='./board_write.php?part=info'\">
		//		  <span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>등록하기
		//		</button>";

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

