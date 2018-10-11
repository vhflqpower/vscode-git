<?
	include_once("../common.php");

	$wr_id = $_GET['wr_id'];


	if($wr_id){

			$sql = "SELECT * FROM psj_board_data WHERE  wr_id = '$wr_id'";
			$result = sql_query($sql);
			$write = sql_fetch_array($result);

		$oper = 'edit';
	}else{

		$oper = 'add';
		$view[bo_skin] = 'basic';

		$tmp_wr_id=abs(ip2long($_SERVER['REMOTE_ADDR'])); //IP를 임시로 사용;김철호071116
		if($tmp_wr_id >= 2147483647) //IP가 너무 클경우;김철호071116
		$tmp_wr_id=substr($tmp_wr_id,-9); //아홉자리로 자름;김철호07111



	}



	include_once("./head.php");
?>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<style>
	#dragandrophandler
	{
	border:2px dotted #0B85A1;
	width:400px;
	color:#92AAB0;
	text-align:left;vertical-align:middle;
	padding:10px 10px 10 10px;
	margin-bottom:10px;
	font-size:200%;
	}
	.progressBar {
	    width: 200px;
	    height: 22px;
	    border: 1px solid #ddd;
	    border-radius: 5px; 
	    overflow: hidden;
	    display:inline-block;
	    margin:0px 10px 5px 5px;
	    vertical-align:top;
	}
	 
	.progressBar div {
	    height: 100%;
	    color: #fff;
	    text-align: right;
	    line-height: 22px; /* same as #progressBar height if we want text middle aligned */
	    width: 0;
	    background-color: #0ba1b5; border-radius: 3px; 
	}
	.statusbar
	{
	    border-top:1px solid #A9CCD1;
	    min-height:25px;
	    width:700px;
	    padding:10px 10px 0px 10px;
	    vertical-align:top;
	}
	.statusbar:nth-child(odd){
	    background:#EBEFF0;
	}
	.filename
	{
	display:inline-block;
	vertical-align:top;
	width:250px;
	}
	.filesize
	{
	display:inline-block;
	vertical-align:top;
	color:#30693D;
	width:100px;
	margin-left:10px;
	margin-right:5px;
	}
	.abort{
	    background-color:#A8352F;
	    -moz-border-radius:4px;
	    -webkit-border-radius:4px;
	    border-radius:4px;display:inline-block;
	    color:#fff;
	    font-family:arial;font-size:13px;font-weight:normal;
	    padding:4px 15px;
	    cursor:pointer;
	    vertical-align:top
	    }
	</style>



	<link href="https://rawgithub.com/hayageek/jquery-upload-file/master/css/uploadfile.css" rel="stylesheet">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://rawgithub.com/hayageek/jquery-upload-file/master/js/jquery.uploadfile.min.js"></script>


	<?
		include_once("./nav.php");
	?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">자료 정보</h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./data_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="seq" value="<?=$write['seq']?>" />	
				<input type="hidden" name="wr_id" value="<?=$write['wr_id']?>" />
				<input type="hidden" name="bo_table" value="data" />
				<input type="hidden" name="oper" value="<?=$oper?>" />
				<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled">
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered"><!--  table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<tr>
						<th>제목</th>
							<td>
							<input type="text" name="wr_subject" value="<?=$write['wr_subject']?>" class="form-control" />
							</td>
					</tr>

					<tr>				
					<tr>
						<th>첨부</th>
						<td>
						<?
							if($write[wr_id])$wr_id = $write[wr_id];else $wr_id = $tmp_wr_id;

						?>
						<div id="fileuploader">Upload</div>
						<script>
						$(document).ready(function() {
							$("#fileuploader").uploadFile({
								url:"./multi_upload_server.php?bo_table=data&wr_id=<?=$wr_id?>",
								fileName:"myfile"
							});
						});

						</script>

					      <div class="panel-body" id="disp_log_div" style="padding:5px;margin-left:10px;">
						</div>

						</td>
					</tr>
					<tr>
						<th>내용</th>
						<td>

							<div class="form-group">
								<label for="wr_content"></label>
								<textarea class="form-control" id="wr_content" name="wr_content" rows="5"><?=$write['wr_content']?></textarea>
							</div>
						</td>
					</tr>

				</tbody>
			</table>




<div style="float:left">
		<?if($write['seq']){ ?>
			<button type="button" class="btn btn-danger btn-sm" onclick="fileDel();">
			  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
			</button>
		<? } ?>	


</div>


<div style="float:right">

			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./dataroom_list.php?part=account'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
			</button>
			
			<button type="submit" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>
</div>

			</form>

			<form name="fdel" method="post" action="./dataroom_update.php">
			<input type="hidden" name="bo_table" value="<?=$write[bo_table]?>" />
			<input type="hidden" name="seq" value="<?=$write['wr_id']?>" />
			<input type="hidden" name="oper" value="del" />
			</form>



         </div> 
		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->





<?
	include_once("./footer.php");
?>


<script type="text/javascript">


             
    


	var uf = ''; 
	function sw_file_add(size, ext) 
	{ 
	    eval('sw_file_add_form' + uf).innerHTML += "<input type=file name=file[] size='" + size + "' " + ext + "><div id='sw_file_add_form" + (uf+1) + "'></div>"; 
	    uf++; 
	} 





	jQuery("#action-1").click(function(e){
		//do something
		e.preventDefault();
	});



	 function fileDel(){
		if (confirm('한번 삭제한 자료는 복구가 되지 않습니다. 정말로 삭제하시겠습니까?'))
		{
			document.fdel.submit();
			//$('#fdel').submit();
		}
	}
			

// 	var bo_table_enabled = $("#bo_table_enabled").val();


$(document).ready(function() {
	//$("#btn_search").trigger("click");
	//get_member_row()

});





function memoNew(id) {

	$('#oper').val('write');
	$('#wr_id').val('');
	$('#wr_content').val('');
}



function getAddFiles(id) {


	if(id == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax/ajax_get_file_data.php?bo_table=data&wr_id=' + id;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
		cache:false,
		async:false,
		success:function(response) {
		var success = (response.flag == 'succ');
		var message = response.cell;

		if(success) {

			$.each(message,function(key,val){
				var content = "<ul style='margin:0px;padding-left:5px;'><li><span id='disp_cnt'></span><a href=\"./download.php?bo_table="+val.bo_table+"&bf_file="+val.bf_file+"&bf_source="+val.bf_source+"&seq="+val.seq+" \">"+val.bf_source+" ("+val.bf_filesize+")</a> <a href='' onclick=\"addFileDel("+val.seq+")\">[D]</a></li>"
				+"</ul>";

				var disp_log_list = $('#disp_log_div').append(content);

			});

			} else {
				alert('fail to load daa');
			}
		}
	});
}



function addFileDel(seq) {
 
	var postData;
	var rows = Object();


	var rows= {
		oper : 'del',
		bo_table : 'data',
		seq : seq,

	};
	
	var postData = $.param(rows);
	var url = './ajax/ajax_addFile_del_server.php'//url 수정;
	
	var msg = '파일을 정말 삭제하시겠습니까?';
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

	if(success) {
	
			 $(".panel-body ul").remove();
			   getAddFiles('<?=$write[wr_id]?>');
			
			}


			}
		});
	}

	return false;

} 


</script>


<script>


$(document).ready(function() {
	
<? if($write[wr_id]){ ?>
	getAddFiles('<?=$write[wr_id]?>');

<? } ?>

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
<?
  $app_root = "/home/mta/www";//$_SERVER['DOCUMENT_ROOT'];
//  임시파일삭제 방법1

$timer[now] = date("Y-m-d"); 

	$tmp_wr_id=abs(ip2long($_SERVER['REMOTE_ADDR'])); //IP를 임시로 사용;김철호071116
	if($tmp_wr_id >= 2147483647) //IP가 너무 클경우;김철호071116
	$tmp_wr_id=substr($tmp_wr_id,-8); //아홉자리로 자름;김철호07111

    $sql3 = " select wr_id,bf_datetime,bf_file from psj_board_file where bo_table='data' and wr_id >= '$tmp_wr_id' and DATE_FORMAT(bf_datetime, '%Y-%m-%d') <= '$timer[now]'"; 

    $result3 = sql_query($sql3); 
    while ($row3 = sql_fetch_array($result3)) 
    { 


		@unlink($app_root."/data/pms/$bo_table/$row3[bf_file]");
	   sql_query("delete from psj_board_file where bf_file='$row3[bf_file]'"); 
    } 

?>
<?
	include_once("./tail.php");
?>
