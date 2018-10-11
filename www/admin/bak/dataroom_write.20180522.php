<?
	include_once("../common.php");

	$seq = $_GET['seq'];


	if($seq){

			$sql = "SELECT * FROM psj_board_file WHERE  seq = '$seq'";
			$result = sql_query($sql);
			$view = sql_fetch_array($result);

		$oper = 'edit';
	}else{

		$oper = 'add';
		$view[bo_skin] = 'basic';
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

	<?
		include_once("./nav.php");
	?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">파일 정보</h2>

          <div class="table-responsive">
			<form name="frm" method="post" action="./dataroom_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
				<input type="hidden" name="seq" value="<?=$view['seq']?>" />	
				<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
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
						<th>구분</th>
							<td>
								<select class="selectpicker bo_table" name="bo_table" id="bo_table">
								  <option value="">선택하세요</option>			
								<?
									$arr_gubun =  select_gubun();
									foreach($arr_gubun as $key => $val){
								?> 
								  <option value="<?=$key?>"><?=$val?></option>
								  <? } ?>
								</select>
							</td>
					</tr>
					<tr>
						<th>프로젝트</th>
							<td>
								<select class="selectpicker project" name="pj_id" id="pj_id">
								  <option value="">프로젝트선택</option>			
								<?
									$arr_prject =  select_project();
									foreach($arr_prject as $key => $val){
								?> 
								  <option value="<?=$key?>"><?=$val?></option>
								  <? } ?>
								</select>
							</td>
					</tr>
					<tr>				
					<tr>
						<th>첨부</th>
						<td>


						<div id="dragandrophandler">Drag & Drop Files Here</div>
						<div id="status1"></div>
						<script>
						function sendFileToServer(formData,status)
						{
						    var uploadURL ="./drag_upload_update.php"; //Upload URL// http://hayageek.com/examples/jquery/drag-drop-file-upload/upload.php
						    var extraData ={}; //Extra Data.
						    var jqXHR=$.ajax({
							  xhr: function() {
							  var xhrobj = $.ajaxSettings.xhr();
							  if (xhrobj.upload) {
								xhrobj.upload.addEventListener('progress', function(event) {
								    var percent = 0;
								    var position = event.loaded || event.position;
								    var total = event.total;
								    if (event.lengthComputable) {
								        percent = Math.ceil(position / total * 100);
								    }
								    //Set progress
								    status.setProgress(percent);
								}, false);
							      }
							  return xhrobj;
						        },
						    url: uploadURL,
						    type: "POST",
						    contentType:false,
						    processData: false,
						        cache: false,
						        data: formData,
						        success: function(data){
							  status.setProgress(100);
						 
							  $("#status1").append("File upload Done<br>");         
						        }
						    }); 
						 
						    status.setAbort(jqXHR);
						}
						 
						var rowCount=0;
						function createStatusbar(obj)
						{
						     rowCount++;
						     var row="odd";
						     if(rowCount %2 ==0) row ="even";
						     this.statusbar = $("<div class='statusbar "+row+"'></div>");
						     this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
						     this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
						     this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
						     this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
						     obj.after(this.statusbar);
						 
						    this.setFileNameSize = function(name,size)
						    {
						        var sizeStr="";
						        var sizeKB = size/1024;
						        if(parseInt(sizeKB) > 1024)
						        {
							  var sizeMB = sizeKB/1024;
							  sizeStr = sizeMB.toFixed(2)+" MB";
						        }
						        else
						        {
							  sizeStr = sizeKB.toFixed(2)+" KB";
						        }
						 
						        this.filename.html(name);
						        this.size.html(sizeStr);
						    }
						    this.setProgress = function(progress)
						    {       
						        var progressBarWidth =progress*this.progressBar.width()/ 100;  
						        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
						        if(parseInt(progress) >= 100)
						        {
							  this.abort.hide();
						        }
						    }
						    this.setAbort = function(jqxhr)
						    {
						        var sb = this.statusbar;
						        this.abort.click(function()
						        {
							  jqxhr.abort();
							  sb.hide();
						        });
						    }
						}
						function handleFileUpload(files,obj)
						{
						   for (var i = 0; i < files.length; i++) 
						   {
						        var fd = new FormData();
						        fd.append('file', files[i]);
						 
						        var status = new createStatusbar(obj); //Using this we can set progress.
						        status.setFileNameSize(files[i].name,files[i].size);
						        sendFileToServer(fd,status);
						 
						   }
						}
						$(document).ready(function()
						{
						var obj = $("#dragandrophandler");
						obj.on('dragenter', function (e) 
						{
						    e.stopPropagation();
						    e.preventDefault();
						    $(this).css('border', '2px solid #0B85A1');
						});
						obj.on('dragover', function (e) 
						{
						     e.stopPropagation();
						     e.preventDefault();
						});
						obj.on('drop', function (e) 
						{
						 
						     $(this).css('border', '2px dotted #0B85A1');
						     e.preventDefault();
						     var files = e.originalEvent.dataTransfer.files;
						 
						     //We need to send dropped files to Server
						     handleFileUpload(files,obj);
						});
						$(document).on('dragenter', function (e) 
						{
						    e.stopPropagation();
						    e.preventDefault();
						});
						$(document).on('dragover', function (e) 
						{
						  e.stopPropagation();
						  e.preventDefault();
						  obj.css('border', '2px dotted #0B85A1');
						});
						$(document).on('drop', function (e) 
						{
						    e.stopPropagation();
						    e.preventDefault();
						});
						 
						});
						</script>





						</td>
					</tr>
					<tr>
						<th>내용</th>
						<td>

							<div class="form-group">
								<label for="wr_content"></label>
								<textarea class="form-control" id="bf_content" name="bf_content" rows="5"></textarea>
							</div>
						</td>
					</tr>

				</tbody>
			</table>




<div style="float:left">
		<?if($view['seq']){ ?>
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
			<input type="hidden" name="bo_table" value="<?=$view[bo_table]?>" />
			<input type="hidden" name="seq" value="<?=$view['seq']?>" />
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
		alert(1)
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
<?
  $app_root = "/home/mta/www";//$_SERVER['DOCUMENT_ROOT'];
//  임시파일삭제 방법1
$timer[now] = date("Y-m-d"); 
 $sql3 = " select wr_id,bf_datetime,bf_file from psj_board_file where wr_id > '18042700035000' and DATE_FORMAT(bf_datetime, '%Y-%m-%d') <= '$timer[now]'"; 

    $result3 = sql_query($sql3); 
    while ($row3 = sql_fetch_array($result3)) 
    { 


	//echo $app_root."/data/temp/$row3[bf_file]"."<hr>";
	
		@unlink($app_root."/data/temp/$row3[bf_file]");
	 sql_query("delete from psj_board_file where bf_file='$row3[bf_file]'"); 
    } 
?>
<?
	include_once("./tail.php");
?>
