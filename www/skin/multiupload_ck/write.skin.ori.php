<!-- json & xml parser -->
<script type="text/javascript" language="javascript" src="./multiuploader/common/json2.js"></script>
<script type="text/javascript" language="javascript" src="./multiuploader/common/xml2json.js"></script>
<!-- json & xml parser -->

<!-- jQuery -->
<script type="text/javascript" language="javascript" src="./multiuploader/common/jquery-2.0.2.min.js"></script>
<!-- jQuery -->

<!-- SWFUpload -->
<script type="text/javascript" src="./multiuploader/SWFUpload/swfupload.js"></script>
<script type="text/javascript" src="./multiuploader/SWFUpload/swfupload.queue.js"></script>
<!-- SWFUpload -->

<!-- Sayku Library -->
<link rel="stylesheet" type="text/css" charset="UTF-8" media="all" href="./multiuploader/syaku.file.css" />
<script type="text/javascript" src="./multiuploader/syaku.file.js"></script>
<script type="text/javascript" src="./multiuploader/syaku.file.handlers.js"></script>
<!-- Sayku Library -->

<!-- Sayku Library -->
<link rel="stylesheet" type="text/css" charset="UTF-8" media="all" href="./multiuploader/syaku.file.css" />
<script type="text/javascript" src="./multiuploader/syaku.file.js"></script>
<script type="text/javascript" src="./multiuploader/syaku.file.handlers.js"></script>
<!-- Sayku Library -->

<!-- CKEditor4 -->
<script src="./ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="./multiuploader/syaku.ckeditor.handlers.js"></script>
<script>
var ckeditor_config = {
  resize_enabled : false,
  enterMode : CKEDITOR.ENTER_BR , 
  shiftEnterMode : CKEDITOR.ENTER_P , 
  toolbarCanCollapse : true , 
  removePlugins : "elementspath",

  toolbar : [
    [ 'Source', '-' , 'NewPage', 'Preview' ],
    [ 'Cut', 'Copy', 'Paste', 'PasteText', '-', 'Undo', 'Redo' ],
    [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'],
    [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ],
    '/',
    [ 'Styles', 'Format', 'Font', 'FontSize' ],
    [ 'TextColor', 'BGColor' ],
    [ 'Image', 'Flash', 'Table' , 'SpecialChar' , 'Link', 'Unlink']
    
  ] 

};

var MEIeditor = [ ];
var objEditor;
jQuery(function() {
  MEIeditor[1] = CKEDITOR.replace( "content" , ckeditor_config );
  objEditor = CKEDITOR.instances.content;

  console.log(objEditor);
});

function save() {
  MEIeditor[1].updateElement();
  alert( MEIeditor[1].getData() );
  //jQuery('#form').submit();
}

</script>


<!-- CKEditor4 -->

<script>
var swfu;
</script>


	<div class="page-header">
        <h2><?=$row['wr_subject']?></h2>
      </div> 


      <div class="row row-offcanvas row-offcanvas-right">

        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>


          <!-- <h3 class="sub-header">Section title</h3> -->
           <div class="table-responsive">

			<!-- <script type="text/javascript" src="./ckeditor/ckeditor.js"></script> -->
			<form name="frm" method="post" action="./write_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="bo_table" value="<?=$_GET['bo_table']?>" />
				<input type="hidden" name="wr_id" value="<?=$write['wr_id']?>" />
				<input type="hidden" name="oper" value="<?=$_GET['oper']?>" />
				<table class="table table-striped table-bordered "><!-- table-hover -->
				<caption>테이블 설명</caption>
				<col width="15%">
				<col width="">
				<!-- <thead>
					<tr>
						<th>NO</th>
						<th>제목</th>

					</tr>
				</thead> -->
				<tbody>
				<? if($board['bo_use_category']){ ?>
					<th>구분</th>
						<td><select name="ca_name" class="form-control" style="width:200px">
						<?=get_category_option($bo_table,'선택',$write['ca_name']);?>
						</select>
						<? } ?>
					
					<tr>
					<th>옵션</th>
					<td><input type="checkbox" name="is_notice" id="is_notice" value="1" <?=$notice_checked?>/>공지
						<!-- <input type="checkbox" name="wr_scrit" id="wr_scrit" value="1" />공지 -->
					</td>
					</tr>
					<tr>					
					
					
					<tr>
					<th>제목</th>
					<td><input type="text" name="wr_subject" value="<?=$write['wr_subject']?>" class="form-control" /></td>
					</tr>
					<tr>
     
						<td colspan="2"><textarea id="content" name="content" class="ckeditor" rows="10" cols="80"><?=$write['wr_content']?></textarea></td>

					</tr> 

				<? if($board['bo_use_multiupload'] == 'Y'){ ?>
					<tr>
					<th>이미지소스</th>
					<td>
<!-- start -->
						<div class='file_upload' style='padding-bottom:5px;'>
						  <div class='file_head'>
							<span id='swfu_button'></span>

							<button type="button" onclick="jQuery.syakuFileUpload.deleteSwfupload(swfu,objEditor[1]);">삭제</button>
							<button type="button" onclick="jQuery.syakuFileUpload.editor_file_input(swfu,objEditor[1]);">선택삽입</button>
							<button type="button" onclick="jQuery.syakuFileUpload.editor_file_remove(swfu,objEditor[1]);">선택모두제거</button>
						  </div>
						  <div class='file_content'>
							<div class='file_preview' id='file_preview'></div>
							<div class='file_field'>

							  <select class='file_view' id='file' name='file' multiple='multiple' onclick='jQuery.syakuFileUpload.preview(swfu);'>   
							 <?
							 $tmp_query = mysql_query("select bo_table,wr_id,bf_no,bf_source,bf_file,bf_filesize from `psj_board_img` where bo_table = '$bo_table' && wr_id = '$wr_id' order by bf_no asc");
								while($tmp_row = mysql_fetch_array($tmp_query)){
							 ?>
							<option value="{ file_orl : '<?=$tmp_row[bf_file]?>&bo_table=<?=$tmp_row[bo_table]?>&wr_id=<?=$tmp_row[wr_id]?>&bf_no=<?=$tmp_row[bf_no]?>' , file : '<?=$tmp_row[bf_source]?>', re_file : '<?=$tmp_row[bf_file]?>', folder : './data/ckeditor/<?=$bo_table?>' , file_size : '<?=$tmp_row[bf_filesize]?>' , extension : 'null' , type : 'application/octet-stream' }" selected="selected"><?=$tmp_row[bf_source]?>(<?echo number_format($tmp_row[bf_filesize])?>)</option>

							 <!-- <option value="<?=$tmp_row[bf_file]?>"><?=$tmp_row[bf_source]?></option> -->
							<? } ?>	  	  
							  </select>
							</div>
							<div class='file_text'>
							  <p>총 용량 : <span id='file_size_text'>0 KB</span> / 무제한</p>
							  <p>개당 용량 : 무제한</p>
							  <p>파일 형식 : *.jpg;*.png;*.gif;</p>
							  <p>파일 제한 수 : 무제한</p>
							</div>
							<div class="clear"></div>
						  </div>
						</div>

						<script>
						  // SWFUpload
						  swfu = jQuery.syakuFileUpload.swfupload({
							ele_file : '#file',
							ele_file_orl : '#file_orl',
							ele_file_size : '#file_size_text',
							ele_preview : '#file_preview',
							file_size_limit : 0 ,
							file_types : '*.jpg;*.png;*.gif;',
							file_types_description : '사용자 파일',
							file_upload_multi : true,
							file_upload_limit : 0,
							file_upload_unlimited : true, 

							post_params: { 
							 bo_table : '<?=$bo_table?>',
							 wr_id : '<?=$wr_id?>'
							},

							button_placeholder_id : 'swfu_button',
							debug : false
						  });

						</script>
<!-- end -->
					</td>
					</tr>
					<tr>	
					<? } ?>


					<? if($board['bo_upload_count'] > 0){ ?>

							<th>첨부</th>
							<td>
							<? 
							for($i=0; $i< $board['bo_upload_count']; $i++){ 
							
							$data = sql_fetch(" select bf_file,bf_source from `psj_board_file` where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");

							?>
							<input type="file" name="bf_file[]" value="" class="form-control" style="width:300px;"/>
							<? if($data['bf_file']){ ?><input type="checkbox" name="bf_file_del[<?=$i?>]" value="1"><font color=red>삭제</font><?=$data['bf_source'];?>
								<? }
							} ?>
							</td>
							</tr>
					<? } ?>

				</tbody>
			</table>
			<button type="submit" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./list.php?bo_table=<?=$bo_table?>'">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>취소
			</button>
			</form>



          </div>



        </div><!--/.col-xs-12.col-sm-9-->


		<script type="tex/javascript">

			window.onload=function(){

			CKEDITOR.replace('wr_content');

			CKEDITOR.instances.wr_content.getData();

		}


	function saveSubmit(){


		alert(f)


	}


		</script>


<?

/*
$timer[now] = date("Y-m-d"); // 현재 날짜 
    $wr_id_code=abs(ip2long($_SERVER['REMOTE_ADDR']));
    if($wr_id_code >= 2147483647)
        $wr_id_code=substr($wr_id_code,-9);
$file = get_img($bo_table, $wr_id_code);


 for($i=0; $i<$file["count"]; $i++){
@unlink($app[path]."/data/ckeditor/$bo_table/".$file[$i][file]);
}
 sql_query(" delete from psj_board_img where wr_id = '$wr_id_code'"); 



 $sql3 = " select * from g4_board_img where wr_id > '100000000' and DATE_FORMAT(bf_datetime, '%Y-%m-%d') < '$timer[now]'"; 
    $result = sql_query($sql); 
    while ($row3 = sql_fetch_array($result3)) 
    { 
	@unlink("$g4[path]/data/ckeditor/$bo_table/$row3[bf_file]");

 sql_query(" delete from g4_board_img where bf_file='$row3[bf_file]'"); 
    } 




function get_img($bo_table, $wr_id)
{
    global $g4, $qstr;
    $file["count"] = 0;
    $sql = " select * from psj_board_img where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
    $result = sql_query($sql);
    while ($row = sql_fetch_array($result))
    {
        $no = $row[bf_no];
        $file[$no][href] = "./download.php?bo_table=$bo_table&wr_id=$wr_id&no=$no" . $qstr;
        $file[$no][download] = $row[bf_download];

        $file[$no][path] = "$app[path]/data/ckeditor/$bo_table";

        $file[$no][size] = get_filesize($row[bf_filesize]);

        $file[$no][datetime] = $row[bf_datetime];
        $file[$no][source] = addslashes($row[bf_source]);
        $file[$no][bf_content] = $row[bf_content];
        $file[$no][content] = get_text($row[bf_content]);

        $file[$no][view] = view_file_link($row[bf_file], $row[bf_width], $row[bf_height], $file[$no][content]);
        $file[$no][file] = $row[bf_file];
        $file[$no][image_width] = $row[bf_width] ? $row[bf_width] : 640;
        $file[$no][image_height] = $row[bf_height] ? $row[bf_height] : 480;
        $file[$no][image_type] = $row[bf_type];
        $file["count"]++;
    }

    return $file;
}
*/
?>

