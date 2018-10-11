<?php


	//include("config.inc.php"); //include config file
	include_once("./_common.php");
	$item_per_page = 10;
//	include_once("./dbconfig.php");

	$WHERE =" 1=1";

	$p_id = $_POST["p_id"];
	$search_value = $_POST["search_value"];
	$ca_name = $_POST["ca_name"];
	$bo_table = $_POST["bo_table"];



	if(isset($_POST["page"])){
		$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1;
	}


//$page_number = 1;
// $position, $item_per_page  


	$position = (($page_number-1) * $item_per_page);


	$where = " 1=1 AND p_id = '$p_id' AND bo_table = '$bo_table'";

	if($search_value) $where .= " ANd wr_subject LIKE '%$search_value%'"; 

	$results = sql_query("SELECT * FROM psj_board_comment where ".$where." ORDER BY seq DESC LIMIT $position, $item_per_page");
	while($row = sql_fetch_array($results))
	{

		$seq = $row['seq'];
		$wr_id = $row['wr_id'];
		$content = cut_str(conv_content($row['co_content'], $html=0),"300","...");


?>
		 <tr class="comm_row">
		<td >
			<span style="color:#000;">[<?=$row['wr_name']?>]</span> <span style="color:#0000ff;"><?=$row['co_datetime']?> </span><br>





			 <div style="padding:10px;"><?=$content;?></div><br>
			 <div id="edit_id_<?=$seq?>" style="display:none;"  class="content_warp"><textarea class="form-control" id="content_<?=$seq?>" name="content_<?=$seq?>" rows="4" ><?=$row['co_content']?></textarea><input type="hidden" id="idx_<?=$seq?>" value="<?=$seq?>">
			 
				<div style="float:right;padding:6px;">	
					 <button type="button" class="btn btn-default btn-sm"  id="commAddCancle" onclick="comment_close()">
					<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
					 <button type="button" class="btn btn-primary btn-sm"  onclick="commSubmit_<?=$seq?>('edit')">
					<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>내역작성</button>
				</div>			 

			 </div>

			<?if($member['mb_id'] == 'admin' || $member['mb_id'] == $row['mb_id']){ ?>

			  <button type="button" class="btn btn-default btn-xs"   onclick="commEdit_<?=$seq?>('<?=$seq?>');" >
				<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>

			  <button type="button" class="btn btn-default btn-xs"    onclick="commDelete_<?=$seq?>();" >
				<span class="glyphicon glyphicon-remove" aria-hidden="true" ></span>삭제</button>
			
			<?}	?>

			 </td>


<script>

function  commEdit_<?=$seq?>(seq){



	comment_close()
	$("#edit_id_<?=$seq?>").css("display","block");

	$("#add_content_form").css("display","none");

	

}



function commSubmit_<?=$seq?>(mode){	
	

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
		url: "../admin/ajax/ajax_comment_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {


			//$("#co_content").val('');
			// $(".comm_row").remove();
			comment_close();
			get_comment_row();
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
		url: "../admin/ajax/ajax_comment_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {

			comment_close();
			get_comment_row();
			}



		}
	});
	
		}
	return false;
	
}

</script>

 </tr>



<?


		if(count($row) < 1){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

}

?>

<script>

function  comment_close(){

	$(".content_warp").css("display","none");
	$("#add_content_form").css("display","block");

}

</script>