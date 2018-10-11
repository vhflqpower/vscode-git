


	<div class="page-header">
            <h3><?=$board['bo_subject']?></h3>
      </div> 

<!-- 출석체크 폼 -->
<form name="chk" method="post" action="../board/schedule_add_server.php">
<input type="hidden" name="mb_id" value="<?=$member['mb_id']?>">
<input type="hidden" name="mb_name" value="<?=$member['mb_name']?>">
<input type="hidden" name="wr_id" id="p_id" value="<?=$wr_id?>">
<input type="hidden" id= "bo_table"name="bo_table" value="<?=$board['bo_table']?>">
</form>


      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>


         <h3 class="sub-header"><?=$row['wr_subject']?></h3>
           <div class="table-responsive">

				<table class="table table-striped table-bordered "><!-- table-hover -->
				<col width="20%">
				<col width="80%">
				<tbody>

					<tr>
						<th>제목</th>
						<td><?=$view['wr_subject']?></td>
					</tr>
					<tr>
						<th>작성자</th>
						<td><?=$view['wr_name']?></td>
					</tr>
					<tr>
						<th>DATE</th>
						<td><?=$view['wr_1']?></td>
					</tr>
					<tr>
						<td colspan="2" style="height:150px;"><?=$view['wr_content']?></td>
					</tr>

<?
	//윗글(다음글)을 얻는 쿼리
    $upsql = "select wr_id, wr_subject from $write_table where wr_is_comment = 0 && wr_subject != '' && wr_id > $view[wr_id] order by wr_id ASC  limit 1";
    $upres = sql_query($upsql);
    $uprow = sql_fetch_array($upres);

	//아래글(이전글)을 얻는쿼리   
    $downsql = "select wr_id, wr_subject from $write_table where wr_is_comment = 0 && wr_subject != '' && wr_id < $view[wr_id] order by wr_id DESC  limit 1";
    $downres = sql_query($downsql);
    $downrow = sql_fetch_array($downres);

?>

					<tr>
					<th >다음글</th><td><a href="./view.php?bo_table=<?=$bo_table?>&wr_id=<?=$uprow[wr_id]?>"><?=$uprow[wr_subject]?></a></td>
					</tr>
					<tr>
					<tr>
					<th >이전글</th><td><a href="./view.php?bo_table=<?=$bo_table?>&wr_id=<?=$downrow[wr_id]?>"><?=$downrow[wr_subject]?></a></td>
					</tr>
					<tr>
				</tbody>
			</table>


<hr>
			<div>
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			<button type="button" class="btn btn-info btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&oper=edit'">
			  <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>수 정
			</button>

			<button type="button" class="btn btn-danger btn-sm" onclick="del()">
			  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
			</button>
			<button type="button" class="btn btn-primary btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>글쓰기
			</button>
			</div><br>
			<button type="button" class="btn btn-success btn-sm" onclick="lfn_seq_confirm()">
			  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>출 석
			</button><br><br>

		<table width="100%" border="0"> 
			<tr> 
			<? 
			$query4 = " 
				SELECT mb_id,mb_name,regdate FROM `g4_schedule_add` where board_id ='$board[bo_table]' and board_seq = '$wr_id'";
			$result4 = sql_query($query4);

			$list_cols = 5; 
			for($i=1; $i<=($row4 = sql_fetch_array($result4)); $i++) { 

				//$img_title = str_cut($row4[mb_id], 20, '..');
			?>
			<td width="14%" height="24">
				<font color=blue><b><?=$row4['mb_name']?></b></font><br><?=$row4['regdate']?>
			</td> 
			<? if($i % $list_cols ==0 ) { 
			echo "</tr><tr>"; 
			} 
			?> 
			<?} 
			if (($cnt = ($i-1)%$list_cols) != 0) 
				for ($k=$cnt; $k<$list_cols; $k++) 
					echo " <td width='14%'>&nbsp;</td>\n"; 
			?> 
			</table>
			<hr>
		    <div class="col-md-12">
			  <div class="panel with-nav-tabs panel-info">
				<input type="hidden" name="tab_id" id="tab_id" value="<?=$tab_id?>">
			      <div class="panel-heading" align="center">댓글작성
				    <!-- <ul class="nav nav-tabs">
				        <li ><a href="#tab1info" data-toggle="tab" id="tab1">이슈목록</a></li>
				        <li ><a href="#tab2info" data-toggle="tab" id="tab2">관련파일</a></li>
				         <li ><a href="#tab3info" data-toggle="tab" id="tab3">담당정보</a></li>
				      <li ><a href="#tab4info" data-toggle="tab" id="tab4">관련정보</a></li>
				    </ul> -->
			      </div>
			      <div class="panel-body">
				<div class="tab-content">
				    <div class="tab-pane fade in active" id="tab1info">


				<form name="frmComm" method="post" action=""  enctype="multipart/form-data" >
					<input type="hidden" name="co_id"   id="co_id"  value="" />	
					<input type="hidden" name="cmode"   id="cmode"  value="add" />	
					<textarea id="co_content" name="co_content" class="form-control" id="bf_content"  style="width:100%;height:80px;"></textarea>
				</form>

				<div style="float:right;padding:6px;">	
				 <button type="button" class="btn btn-default btn-sm"  id="commAddCancle">
				<span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span>취소</button>			
				 <button type="button" class="btn btn-primary btn-sm"  onclick="commSubmit()">
				<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>저장</button>
				</div>

					<table border="1" width="100%" cellspacing="0" id="commentTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="100%">
						</colgroup>

						<tbody id="comm_results"></tbody>
						</table>


						<div align="center">
							<div class="pagination" ></div>
						</div>


				     </div>
				    <div class="tab-pane fade" id="tab2info">

			<!--비용추가정보START-->
				<!-- <input type="button" value="열기" id="btn_file_open_" onclick="window.open('/pop_item/company_info_pop.php','company','top=10,left=10,width=840px,height=440px')"/>
					<input type="button" value="추가" onclick="javascript:fileAddRow();"/>
					<input type="button" value="제거" onclick="javascript:fileDeleteRow();"/> -->
				
					<table border="1" width="100%" cellspacing="0" id="fileTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="10%">
							<col width="15%">
							<col width="75%">
			
						</colgroup>
						<tr>
							<th >NO</th>
							<th >파일넘버</th>
							<th >파일명</th>

						</tr>
<!-- 
						<tr>
						 <td>
						 <span id="file_no_1"></span>
						 </td>
						 <td>
						  <span id="file_id_1"></span>
						 
						 </td>
						 <td>
						  <span id=""></span>
					
						<span id="bf_source_1"></span><br>
						<span id="bf_content_1"></span><br>

						</td>
						</tr> -->

							<!-- <td><input type="button" value="DEL" onclick="javascript:delRow(this);"></td> -->

							<!--- ###### ROOP ###### ------->
							<textarea id="file_item_row" style="display:none;">
							<tr>
							 <td>
							  <!-- <span id="file_no_CHCNT"></span> -->
							   <div style="text-align:center"><span id="sort_id_CHCNT"></span></div>
							</td>
							 <td>
							  <span id="file_id_CHCNT"></span>
							
							 </td>

							 <td>
							  <span id="bf_source_CHCNT"></span><br>
							  <span id="bf_content_CHCNT"></span>

							</td>
							<!-- <td><input type="button" value="DEL" onclick="javascript:delRow(this);"></td> -->
							</tr>
							</textarea>
						</table><BR>

					</div>
				    <div class="tab-pane fade" id="tab3info">
				    
<!-- 
					<input type="button" value="추가" onclick="javascript:mbAddRow();"/>
					<input type="button" value="제거" onclick="javascript:mbDeleteRow();"/> -->
					<table border="1" width="100%" cellspacing="0" id="mbTable"  class="table table-bordered " style="border-collapse: collapse;">
						<colgroup>
							<col width="5%">
							<col width="10%">
							<col width="15%">
							<col width="10%">
							<col width="10%">
							<col width="15%">
							<col width="55%">
			
						</colgroup>
						<tr>
							<th class="sub_head">SORT</th>
							<th class="sub_head">업체</th>
							<th class="sub_head">담당명</th>
							<th class="sub_head">핸드폰</th>
							<th class="sub_head">전화</th>
							<th class="sub_head">E메일</th>
							<th class="sub_head">메모</th>
						</tr>

						<!--- ###### ROOP ###### ------->
						<textarea id="mb_item_row" style="display:none;">
						<tr>
						 <td style="text-align:center;">
						 <span id="li_sort_MBCNT"></span>
						 </td>

						 <td>
						<span id="company_MBCNT"></span>
						</td>
						 <td> <div style="float:left;height:30px;">

						<span  id="mb_name_MBCNT" ></span><div style="float:right;">
						</div>
						 </td>

						 <td>
						<span  id="mb_hp_MBCNT"></span>
						</td>
						 <td>
						<span  id="mb_tel_MBCNT"></span>
						</td>
						 <td>
						<span  id="mb_email_MBCNT"></span>
						</td>

						 <td>
						<span  id="li_memo_MBCNT" ></span>
						</td>
						<!-- <td><input type="button" value="DEL" onclick="javascript:delRow(this);"></td> -->
						</tr>
						</textarea>
						</table><BR>

			<!--파일정정보 END-->							    

				    
				    </div>

				</div>




			      </div>
			  </div>
		        </div>
			</div> <!-- <div class="col-md-12"> -->
		
			</form>
         </div> 



		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

	<div style="height:20px;"></div>

          </div>

        </div><!--/.col-xs-12.col-sm-9-->


			<!-- 게시글 삭제 폼 -->
			<form name="fdel" method="post" action="./board_del.php">
			<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
			<input type="hidden" name="wr_id" value="<?=$wr_id?>" />
			<input type="hidden" name="oper" value="del" />
			</form>


<script type="text/javascript">

$(document).ready(function() {

	get_comment_row()
});


	$("#commAddCancle").on('click',function() {

		$('#cmode').val('add');
		$('#co_id').val('');
		$('#co_content').val('');
	});



	
//댓글 로드
function get_comment_row(){


	//var s_field = $("#search_field").val();
	//var s_value = $("#search_value").val();
	var ca_name = $("#ca_name").val();
	var bo_table = $("#bo_table").val();

	var p_id = $("#p_id").val();


	$("#comm_results").load("../admin/ajax/ajax_comment_row_data.php",{/*'search_field':s_field,'search_value':s_value,*/'p_id':p_id,'bo_table':bo_table});


        var obj = $('.pagination').twbsPagination({
            totalPages: 1,
            visiblePages: 5,
            onPageClick: function (event, page) {

			  //  console.info(page);			  
		   	event.preventDefault();

			$("#comm_results").load("../admin/ajax/ajax_comment_row_data.php", {/*'page':page,*/'p_id':p_id,'bo_table':bo_table});
			
			}
        });
   
		console.info(obj.data());

}


//댓글 등록
function commSubmit(){	
	
	var bo_table = $("#bo_table").val();
	var mode = $("#cmode").val();
	var p_id = $("#p_id").val();
	var co_id = $("#co_id").val();
	var co_content = $("#co_content").val();

	if(!co_content) {
		$("#co_content").focus();
		alert('메모 사항은 필수입니다.');
		return;
	}

	var postData;
	var rows = Object();
	var rows= {
			mode  : mode,
			p_id  : p_id,
			co_id : co_id,
			co_content  : co_content,
			bo_table  : bo_table,

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
				//location.reload();

			$("#co_content").val('');
			// $(".comm_row").remove();
			get_comment_row();
			}

		//location.replace();

		}
	});
	
	return false;
	
}


//댓글 수정
function commEdit(id) {


//	console.log('getCustOrder',id);
	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = '../admin/ajax/ajax_comment_load.php?id=' + id;
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


				$('#cmode').val('edit');
				$('#co_id').val(cell.seq);
				$('#co_content').val(cell.co_content);
				
				
				} else {
				alert('fail to load data');
			}
		}
	});
}


//댓글 삭제
function commDelSubmit(id){	
	


	if(!id) {
		alert('선택 된 항목이 없습니다.');
		return;
	}

	var postData;
	var rows = Object();
	var rows= {

			mode  : 'del',
			seq  : id,

		};

	var postData = $.param(rows);

		if (confirm('정말로 삭제하시겠습니까?'))
		{

	$.ajax({
		url: "../admin/ajax/ajax_comment_update.php",
		data: postData,
		type:'post',
		dataType:'json',
		cache:false,
		success:function(response) {

			var success = (response.flag == 'succ');
			if(success) {
				//location.reload();

			$("#co_content").val('');
		//	$(".comm_row").remove();
			get_comment_row();
			}


		}
	});
		}
	
	return false;
	
}


	function del()
	{
		if (confirm('한번 삭제한 자료는 복구가 되지 않습니다. 정말로 삭제하시겠습니까?'))
		{

			document.fdel.submit();
			//$('#fdel').submit();
		}
	}
		
			
//출석체크
	function lfn_seq_confirm() {
		if(confirm("출석 등록 하시겠습니까?")) {
			document.chk.submit();
		}
	}

</script>