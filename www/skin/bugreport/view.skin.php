	<!-- <script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shCore.js"></script>
	<script type="text/javascript" src="syntaxhighlighter_3.0.83/scripts/shBrushJScript.js"></script>
	<link type="text/css" rel="stylesheet" href="syntaxhighlighter_3.0.83/styles/shCoreDefault.css"/>
	<script type="text/javascript">SyntaxHighlighter.all();</script>
 -->

<?
// [code:xxx] ..... [/code] 변환
function conv_syntaxhighlighter($contents)
{
    if(!$contents)
        return;

    // code 내에 포함된 tag 제거
    preg_match_all('/\[code:[^\]]*\]([^\[]*)\[\/code\]/i', $contents, $matchs);

    for($i=0; $i<count($matchs[0]); $i++) {
        $code = $matchs[0][$i];
        $code = preg_replace('/<[^>]*>[^<]*<\/[^>]*>/', '', $code);
        $code = preg_replace('/<[^\/>]*\/?>/', '', $code);

        $contents = str_replace($matchs[0][$i], $code, $contents);
    }

    // br 태그 제거
    $contents = preg_replace("/<br\s?\/>/i", "", $contents);

    $contents = preg_replace("/\[code:\s*([^\]]+)\]/i", "<pre class=\"brush:\\1\">", $contents);
    $contents = preg_replace("/\[\/code\]/i", "</pre>", $contents);

    return $contents;
}


$content = $view['contents'];
  // $content = conv_syntaxhighlighter($view['contents']);
?>



	<div class="page-header">
            <h3><!-- <?=$board['bo_subject']?> --><?=$view['wr_subject']?></h3>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">



        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>


          <!-- <h3 class="sub-header">Section title</h3> -->
           <div class="table-responsive">

				<table class="table table-striped table-bordered ">
				<col width="15%">
				<col width="">
				<!-- table-hover -->
				<!-- <caption><h3><?=$view['wr_subject']?></h3></caption> -->
				<!-- <thead>
					<tr>
						<th>NO</th>
						<th>제목</th>

					</tr>
				</thead> -->
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
						$upsql = "select wr_id, wr_subject from $write_table where bo_table='$bo_table' and wr_is_comment = 0 && wr_subject != '' && wr_id > $view[wr_id] order by wr_id ASC  limit 1";
						$upres = sql_query($upsql);
						$uprow = sql_fetch_array($upres);

						//아래글(이전글)을 얻는쿼리   
						$downsql = "select wr_id, wr_subject from $write_table where  bo_table='$bo_table' and   wr_is_comment = 0 && wr_subject != '' && wr_id < $view[wr_id] order by wr_id DESC  limit 1";
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
		<? if($view['wr_source']){ ?>
			<pre class="brush:php;"><?=$view['wr_source']?></pre>
		<? } ?>

<div style="float:right;">
			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>


		<?if($member['mb_id'] == 'psj007' || $member['mb_id'] == $view['mb_id']){ ?>

			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>&wr_id=<?=$wr_id?>&oper=edit'">
			  <span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>수 정
			</button>
			<button type="button" class="btn btn-default btn-sm" onclick="del()">
			  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
			</button>
		
		<?}	?>


			<button type="button" class="btn btn-default btn-sm" onclick="location.href='./write.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>글쓰기
			</button><br><br>
</div>		


          </div>

<!-- 출석 리스트 -->




<!-- 댓글 폼 -->
		<form name="form_memo" method="post" action="../board/comment_update.php">
		<input type="hidden" name="memo_oper" value="add" />
		<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
		<input type="hidden" name="p_id" value="<?=$view['wr_id']?>" />
		<div id="add_content_form">
			<table class="table table-bordered " >
				<col width="15%">
				<col width="">
				<tbody>
					<tr>
					<!-- <th>내역</th> -->
					<td colspan="2">
					<textarea class="form-control" id="proc_memo" name="proc_memo" rows="4" ></textarea>

					<div style="float:right;padding:6px;">	


						 <button type="button" class="btn btn-primary btn-sm"  onclick="commSubmit()">
						<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>등록하기</button>
					</div>
					</td>
					</tr>
					</table>		
			</form>
		</div>
<!-- 댓글 폼 끝 -->



<!-- 댓글 리스트 -->
		<table border="1" width="100%" cellspacing="0" id="commentTable"  class="table table-bordered " style="border-collapse: collapse;">
			<colgroup>
				<col width="100%">
			</colgroup>

			<tbody id="comm_results"></tbody>
		</table>
<!-- 댓글 리스트 끝 -->

        </div><!--/.col-xs-12.col-sm-9-->

			<!-- 게시글 삭제 폼 -->
			<form name="fdel" method="post" action="./delete.php">
			<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
			<input type="hidden" name="wr_id" value="<?=$wr_id?>" />
			<input type="hidden" name="oper" value="del" />
			</form>


		<!-- 출석체크 폼 -->
		<form name="chk" method="post" action="../board/schedule_add_server.php">
		<input type="hidden" name="mb_id" value="<?=$member['mb_id']?>">
		<input type="hidden" name="mb_name" value="<?=$member['mb_name']?>">
		<input type="hidden" name="wr_id" id="p_id" value="<?=$wr_id?>">
		<input type="hidden" id= "bo_table"name="bo_table" value="<?=$board['bo_table']?>">
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



	
//comment 로드
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

</script>






	 <script>



//글 삭제
	function del()	{
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


//코멘트 서브밋
	 function commSubmit()	{

		var f = document.form_memo;

		if(!f.proc_memo.value){
		alert('내용을 입력하세요');
		f.proc_memo.focus();
		return false;
		}

		if (confirm('등록하시겠습니까?'))
		{

			document.form_memo.submit();
			//$('#fdel').submit();
		}
	}

			
	 </script>
