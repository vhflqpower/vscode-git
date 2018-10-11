<?php

	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	require_once("./pagination.class.php");

	$perPage = new PerPage();


	$search_ca_name = $_GET['search_ca_name'];
	$search_value = $_GET['search_value'];
	$is_id = $_GET['is_id'];
	$mb_id = $member['mb_id'];


	$WHERE = "";

	if($_GET['search_value']){ 
		$WHERE .= " and wr_subject LIKE '%$search_value%'"; 
		}

	if($_GET['search_ca_name']){ 
		$WHERE .= " and ca_name ='$search_ca_name'";
		}

	$page = $_GET['page'];

	$rowcnt = sql_query("SELECT count(*) as cnt from psj_memo  where 1=1 and mb_id='$mb_id'  ".$WHERE);
	$cntsql = sql_fetch_array($rowcnt);

	$sql = "SELECT * from psj_memo where 1=1 and mb_id='$mb_id'  ".$WHERE." ORDER BY is_notice DESC,me_datetime DESC";
	$paginationlink = "/admin/ajax/ajax_my_memo_row_data.php?page=";				


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

?>

	<table class="table table-striped">
	<col width="100%">

	  <tbody >
<?

		while($row=sql_fetch_array($result)){

		$seq = $row['me_id'];
		$is_notice = $row['is_notice'];
		$ca_name = $row['ca_name'];
		$me_datetime = $row['me_datetime'];
		$str = nl2br($row['me_content']);
		$me_content = conv_content($row['me_content'], $html=0);


?>
	
		 <tr>
			 <td style='padding-left:20px;'>
			 <span style="color:#0000ff"><?=$ca_name?></span> <span style="color:#cccccc"><?=$me_datetime?></span>
			 <? if($is_notice){?><span class="label label-danger">메인</span><? } ?>
			 <br>

			 <div style="padding-left:10px;"><?=$me_content;?></div><br>
			 <div id="edit_id_<?=$seq?>" style="display:none;"  class="content_warp">
			 
			 
			 <div style="border:0px solid red;">
			 <div style="border:0px solid red;">
				 <input type="hidden" id="idx_<?=$seq?>" value="<?=$seq?>">
				<textarea class="form-control" id="content_<?=$seq?>" name="content_<?=$seq?>" rows="4" ><?=$row['me_content']?></textarea>
			</div>
			

				<div style="float:left;padding:6px;margin-bottom:0px;border:0px solid red;">
				
					<select  name="ca_name_<?=$seq?>" id="ca_name_<?=$seq?>" style="width:150px;height:30px;border-radius:4px;">
						<option value="">선택하세요</option>			
					<?
						$arr_company =  select_memo_gubun($member['mb_id']);
						foreach($arr_company as $key => $val){
					?> 
					  <option value="<?=$key?>" <? if($ca_name==$key)echo"selected"?>><?=$val?></option>
					  <? } ?>
					</select>
					<input type="checkbox" name="is_notice_<?=$seq?>" id="is_notice_<?=$seq?>" value="1" <?if($is_notice==1)echo"checked"?>>메인
				</div>
				
				
				<div style="float:right;padding:6px;">	
					 <button type="button" class="btn btn-default btn-sm"  id="memoAddCancle_<?=$seq?>" onclick="comment_close()">
					<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
					 <button type="button" class="btn btn-primary btn-sm"  onclick="memoSubmit_<?=$seq?>('edit')">
					<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>내역작성</button>
				</div>			 

			</div>


			 </div>

				<div style="float:left;padding:6px;" id="edit_btn_<?=$seq?>">	
				  <!-- <button type="button" class="btn btn-default btn-xs"   onclick="memoEdit_<?=$seq?>('<?=$seq?>');" >
					<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button> -->
					<a href="#1" onclick="memoEdit_<?=$seq?>('<?=$seq?>');" style="text-decoration: none" id="memo_edit_<?=$seq?>">수정</a>  
					<a href="#2"  onclick="memoDelete_<?=$seq?>();" style="text-decoration: none">삭제</a>
				  <!-- <button type="button" class="btn btn-default btn-xs"  onclick="memoDelete_<?=$seq?>();" >
					<span class="glyphicon glyphicon-remove" aria-hidden="true" ></span>삭제</button>
				</div> -->



				<script>



$(document).ready(function() {
	$("#memo_edit_<?=$seq?>" ).on('click',function() { 

		$("#edit_btn_<?=$seq?>").css("display","none");
	});

	$("#memoAddCancle_<?=$seq?>" ).on('click',function() { 
		$("#edit_btn_<?=$seq?>").css("display","block");
	});

	});



function  memoEdit_<?=$seq?>(seq){

	comment_close()
	$("#edit_id_<?=$seq?>").css("display","block");
	$("#add_content_form").css("display","none");
	

}


function memoSubmit_<?=$seq?>(mode){	
	

	var me_id = $("#idx_<?=$seq?>").val();
	var me_content = $("#content_<?=$seq?>").val();


	var is_notice = $("#is_notice_<?=$seq?>").is(':checked') ? 1 : 0;

	var ca_name = $("#ca_name_<?=$seq?>").val();

	if(!me_content) {
		$("#content_<?=$seq?>").focus();
		alert('내용을 입력하세요.');
		return;
	}


	var postData;
	var rows = Object();
	var rows= {
			mode  : mode,
			me_id : me_id,
			ca_name : ca_name,
			me_content  : me_content,
			is_notice : is_notice,
		};

	var postData = $.param(rows);

	$.ajax({
		url: "./ajax/ajax_memo_update.php",
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

			getresult('/admin/ajax/ajax_my_memo_row_data.php?page=<?=$page?>');
			comment_close();

			}

		}
	});
	
	return false;
	
}



function memoDelete_<?=$seq?>(){	
	

	var me_id = $("#idx_<?=$seq?>").val();

	if(!me_id) {
		alert('삭제할 항목이 없습니다..');
		return;
	}


	var postData;
	var rows = Object();
	var rows= {
			mode  : 'del',
			me_id : me_id,
		};

	var postData = $.param(rows);

		if (confirm('정말로 삭제하시겠습니까?')){ 

	$.ajax({
		url: "./ajax/ajax_memo_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {

			getresult('/admin/ajax/ajax_my_memo_row_data.php?page=<?=$page?>');
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

