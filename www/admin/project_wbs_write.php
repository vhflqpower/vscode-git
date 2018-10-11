<?
	include_once("../common.php");

	$pj_id = $_GET['pj_id'];
	$codename = $_GET['codename'];
	$pj_step = $_GET['codename'];





	if($pj_id){

			$sql = "SELECT * FROM psj_project WHERE  pj_id = '$pj_id'";
			$result = sql_query($sql);
			$view = sql_fetch_array($result);

			//$str = nl2br($view['wr_content']);
			$str_content = url_auto_link($view['pj_content']);


		$oper = 'edit';
	}else{

		$oper = 'add';
		$view[bo_skin] = 'basic';
	}

	if($_GET['tab_id'])$tab_id=$_GET['tab_id'];else $tab_id=1;

	include_once("./head.php");
?>

<link rel="stylesheet" href="/css/boot_tab.css" type="text/css">
 
	<?
		include_once("./nav.php");
	?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->
			<div >
				<h2 class="sub-header">
					<?=$view['pj_subject']?>
						<div class="col-sm-3" style="float:right;margin-right:10px;">
							<span class="input-group-addon" id="sizing-addon2"><?=$codename?></span>
						</div>
				</h2>
			</div>




                <div class="row">
                    <div class="col-sm-4">
                        
		 <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">대분류</a></h3>
                            </div>
			<!-- 분류 로드 -->
			<div class="panel-body" id="cat1_list">

			</div><!-- 대분류 -->
			
			</div>
			<input type="hidden" id="pj_id"  value="<?=$view['pj_id']?>"><!-- code값 -->
			<input type="hidden" id="c1_id"  value=""><!-- code값 -->
			<input type="hidden" id="c1_code"  value=""><!-- code값 -->
			<input type="hidden" id="oper1"  value="c1_add"><!-- code값 -->
			<input type="hidden" id="pj_step"  value="<?=$pj_step?>"><!-- code값 -->

			<div class="input-group" style="margin-bottom:5px;">
			  <span class="input-group-addon" id="sizing-addon2">코드명</span>
			  <input type="text" id="cat1_subject" class="form-control" placeholder="코드명" aria-describedby="sizing-addon2">
			</div>

			<div class="input-group">
			  <span class="input-group-addon" id="sizing-addon2">비율%</span>
			  <input type="text" class="form-control" placeholder="protage" id="protage1" aria-describedby="sizing-addon2">
			</div>

			<div style="float:left;margin-top:10px;">

			<button type="button" class="btn btn-primary btn-sm"   id="write_btn" onclick="catSubmit('c1_add',1)">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기	<!-- 코드분류 -->
			</button>
			<button type="button" class="btn btn-default btn-sm"  id="write_btn" onclick="catSubmit('c1_del',1)">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>삭제	<!-- 코드분류 -->
			</button>
			<button type="button" class="btn btn-default btn-sm"  id="write_btn" onclick="cat_reset(1)">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>취소	<!-- 코드분류 -->
			</button>
		         </div>
		        </div>

                    <!-- /.col-sm-4 -->
                    <div class="col-sm-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="./board_list.php?part=info">중분류</a></h3>
                            </div>
                            <div class="panel-body" id="cat2_list">
							<!-- 항목 로드 -->
                            </div>

                        </div>

			<input type="hidden" id="c2_code"  value=""><!-- code값 -->
			<input type="hidden" id="c2_id"  value=""><!-- code값 -->
			<input type="hidden" id="oper2"  value="c2_add"><!-- code값 -->
			<div class="input-group" style="margin-bottom:5px;">
			  <span class="input-group-addon" id="sizing-addon2">코드명</span>
			  <input type="text" id="cat2_subject" class="form-control" placeholder="코드명" aria-describedby="sizing-addon2">
			</div>

			<div class="input-group">
			  <span class="input-group-addon" id="sizing-addon2">비율%</span>
			  <input type="text" class="form-control" placeholder="protage" id="protage2" aria-describedby="sizing-addon2">
			</div>

		
		<div style="float:left;margin-top:10px;">
			<button type="button" class="btn btn-primary btn-sm"   id="write_btn" onclick="catSubmit('c2_add',2)">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기	<!-- 코드항목 -->
			</button>
			<button type="button" class="btn btn-default btn-sm"  id="write_btn" onclick="catSubmit('c2_del',2)">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>삭제	<!-- 코드분류 -->
			</button>		
			<button type="button" class="btn btn-default btn-sm"  id="write_btn" onclick="cat_reset2()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>취소	<!-- 코드분류 -->
			</button>
		</div>

                    </div>
                    <!-- /.col-sm-4 -->


                    <!-- /.col-sm-4 -->
                    <div class="col-sm-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="./board_list.php?part=info">소분류</a></h3>
                            </div>
                            <div class="panel-body" id="cat3_list">
							<!-- 항목 로드 -->
                            </div>

                        </div>
			<input type="hidden" id="c3_code"  value=""><!-- code값 -->
			<input type="hidden" id="c3_id"  value=""><!-- code값 -->
			<input type="hidden" id="oper3"  value="c3_add"><!-- code값 -->
			<div class="input-group" style="margin-bottom:5px;">
			  <span class="input-group-addon" id="sizing-addon2">코드명</span>
			  <input type="text" id="cat3_subject" class="form-control" placeholder="코드명" aria-describedby="sizing-addon2">
			</div>

			<div class="input-group" style="margin-bottom:5px;">
			  <span class="input-group-addon" id="sizing-addon2">비율%</span>
			  <input type="text" class="form-control" placeholder="protage" id="protage3" aria-describedby="sizing-addon2">
			</div>

			<div class="input-group date" style="margin-bottom:5px;">
			  <span class="input-group-addon">시작일</span>
			  <input type="text" id="sdate" class="form-control" placeholder="시작일" aria-describedby="sizing-addon2">
			  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>

			<div class="input-group date" style="margin-bottom:5px;">
			  <span class="input-group-addon">종료일</span>
			  <input type="text" class="form-control" placeholder="종료일" id="edate" aria-describedby="sizing-addon2">
			  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">담당자</span>
					<select class="form-control" name="mb_id" id="mb_id" data-style="btn-default">
						  <option value="">담당자 선택</option>			
						<?
							$arr_member=  select_member();
							foreach($arr_member as $key => $val){
						?> 
						  <option value="<?=$key?>" <?if($key==$row['mb_id'])echo"selected"?>><?=$val?></option>
						  <? } ?>
						</select>
			</div>


		<div style="float:left;margin-top:10px;">
			<button type="button" class="btn btn-primary btn-sm"   id="write_btn" onclick="catSubmit('c3_add',3)">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>등록하기	<!-- 코드항목 -->
			</button>
			<button type="button" class="btn btn-default btn-sm"  id="write_btn" onclick="catSubmit('c3_del',3)">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>삭제	<!-- 코드분류 -->
			</button>		
			<button type="button" class="btn btn-default btn-sm"  id="write_btn" onclick="cat_reset3()">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>취소	<!-- 코드분류 -->
			</button>
		</div>

                    </div>
                    <!-- /.col-sm-4 -->


                </div>




		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

	<div style="height:20px;"></div>

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->



	<!-- <div style="position:absolute;left:400px;top:200px;width:1000px;height:800px;" id="detailListViewLayer">
	</div>-->

<?

	include_once("./footer.php");
?>


<style>
.pcode_ul_off{border:0px solid#ccc;cursor:pointer; }
.pcode_ul_on{border:0px solid#ccc;background-color:#5882FA;color:black;cursor:pointer;color:#fff; }

.pcode_ul_off1{border:0px solid#ccc;cursor:pointer; }
.pcode_ul_on1{border:0px solid#ccc;background-color:#5882FA;color:black;cursor:pointer;color:#fff; }

.pcode_ul_off2{border:0px solid#ccc;cursor:pointer; }
.pcode_ul_on2{border:0px solid#ccc;background-color:#5882FA;color:black;cursor:pointer;color:#fff; }

.pcode_ul_off3{border:0px solid#ccc;cursor:pointer; }
.pcode_ul_on3{border:0px solid#ccc;background-color:#5882FA;color:black;cursor:pointer;color:#fff; }

.pcode_ul_off_f{border:0px solid#ccc;cursor:pointer; }
.pcode_ul_on_f{border:0px solid#ccc;background-color:#CEF6F5;color:black;cursor:pointer; }
</style>
<script type="text/javascript">

	//켈린더
	  $(function(){

			$('.input-group.date').datepicker({
				calendarWeeks: false,
				todayHighlight: true,
				autoclose: true,
				format: "yyyy-mm-dd",
				language: "kr"
			});

		});


var $j = jQuery;
$j(document).ready(function(){
	
	get_code_list(1);


});



function cat_reset(id){

   jQuery(".cat"+id+"_row").remove();

	get_code_list(id);
	$("#oper"+id).val('c'+id+'_add');
	$("#cat"+id+"_subject").val('');
	$("#c"+id+"_id").val('');
	$("#protage"+id).val('');
	$("#sdate").val('');
	$("#edate").val('');
	$('#mb_id').val('');
	//$('#mb_id option:selected').text('');



/*
	if(id==2){
	   jQuery(".cat"+id+"_row").remove();
	}

*/
}


function cat_reset2(){

	//get_code_list(id);
	$("#oper2").val('c2_add');
	$("#cat2_subject").val('');
	$("#c2_id").val('');
	$("#protage2").val('');

}




function cat_reset3(){
	
	//get_code_list(id);
	$("#oper3").val('c3_add');
	$("#cat3_subject").val('');
	$("#protage3").val('');
	$("#c3_id").val('');
	$("#sdate").val('');
	$("#edate").val('');
	$('#mb_id').val('');
}



function get_code_list(part) {



		  var pj_id = $('#pj_id').val();

		if(part==1){

		jQuery(".cat2_row").remove();

		url = '/admin/ajax/ajax_pj_cat_list.php?part='+part+'&pj_id='+pj_id
		
		
		}else if(part==2){

	         var pcode = $('#c1_code').val();
	            jQuery(".cat3_row").remove();
		 jQuery(".cat"+part+"_row").remove();

		url = '/admin/ajax/ajax_pj_cat_list.php?part='+part+'&pcode='+pcode+'&pj_id='+pj_id

		}else if(part==3){

	         var pcode = $('#c2_code').val();
	            jQuery(".cat3_row").remove();
		 jQuery(".cat"+part+"_row").remove();

		url = '/admin/ajax/ajax_pj_cat_list.php?part='+part+'&pcode='+pcode+'&pj_id='+pj_id
		
		}



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
			var cell = response.rows;	

				var cs_table = $('#cat'+part+'_list');
				
				cs_table.find('.cs_row').remove();

				cs_table.find('.cat'+part+'_row').remove();


				if(success){
					//alert(part);
					
				
				for(var i = 0; i < cell.length ; i++ ) {


				var cell_text = "<ul class='cat"+part+"_row' onclick='code_action("+part+","+cell[i].code+","+cell[i].pi_id+")' id='pcodeRow_"+cell[i].pi_id+"' >"
						+"<li class='pcode_ul_off"+part+"' id='pcode"+cell[i].pi_id+"'>"+cell[i].subject+"</li>"
						+"</ul>";
				//return cell_text;
					cs_table.append(cell_text);
				}

				}else{
			
				 jQuery(".cat"+part+"_row").remove();
				      cs_table.append("<ul class='cat"+part+"_row'><li>NO DATA</li></ul>");

				}

			}
		});
}




//-----------------------	코드분류 상세정보

function code_action(part,id,pi_id) {

//alert(part);
		if(part=='1'){
		
			$("#cat2_subject").val('');
			$("#cat3_subject").val('');
			$("#protage2").val('');
			$("#protage3").val('');
			$("#sdate").val('');
			$("#edate").val('');
		
		jQuery(".pcode_ul_on1").attr('class','pcode_ul_off1');
		
		}else if(part=='2'){

			$("#cat3_subject").val('');
			$("#protage3").val('');
			$("#sdate").val('');
			$("#edate").val('');
			jQuery(".pcode_ul_on2").attr('class','pcode_ul_off2');

		}else if(part=='3'){		
		
		jQuery(".pcode_ul_on3").attr('class','pcode_ul_off3');		
		}
		url = './ajax/ajax_pj_code_load.php?id='+pi_id;
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
				
				// 코드분류 정보
				if(success) {
				var cell = response.rows;

				$('#oper'+part).val('c'+part+'_edit');
				$('#c'+part+'_id').val(cell.pi_id);
				$('#cat'+part+'_subject').val(cell.subject);
				$('#c'+part+'_code').val(cell.code);
				$('#protage'+part).val(cell.protage);
				$('#sdate').val(cell.sdate);
				$('#edate').val(cell.edate);
				$('#mb_id').val(cell.mb_id);


				$('#pcode'+pi_id).attr('class','pcode_ul_on'+part);



				if(part==1){
				 get_code_list(2)
				}else if(part==2){
				 get_code_list(3)
				 }

				}
			}
		});


}


//------------------------------------------------------------------> 서브밋
    function catSubmit(mode,part){


	var postData;
	var rows = Object();


	if(mode=='c'+part+'_del'){
	
	var check_code = checkcode(mode,part);
	//alert(check_code);
		if(check_code > '0'){
			alert('하위 항목이 있으면 삭제 할 수 없습니다.'); return;
		}else{
			var oper = mode;
			//alert(oper);
		}
	}else{
	    var oper = $('#oper'+part).val();
	}


	var pj_id = $('#pj_id').val();
	var pi_id = $('#c'+part+'_id').val();
	var code = $('#c'+part+'_code').val();
	var sdate = $('#sdate').val();
	var edate = $('#edate').val();
	var mb_id = $('#mb_id').val();
	var pj_step = $('#pj_step').val();


	if(part==2){
		var pcode = $('#c1_code').val();
		//alert(pcode)
	}else if(part==3){
		var pcode = $('#c2_code').val();	
		//alert(pcode)
	}else{
		var pcode =0;
	}


	var cat_subject = $('#cat'+part+'_subject').val();

	var protage = $('#protage'+part).val();


	if(cat_subject == ''){
		alert('코드은 필수입니다');
		$('#cat'+part+'_subject').focus();
		return;
	}

	var rows= {

		oper : oper,
		pj_id : pj_id,
		pi_id : pi_id,
		subject : cat_subject,
		code : code,
		pcode : pcode,
		protage : protage,
		sdate : sdate,
		edate : edate,
		mb_id : mb_id,
		pj_step : pj_step,


	};
	
	var postData = $.param(rows);
	var url = './ajax/ajax_pj_code_update.php'//url 수정;
	
		
		if(oper=='c'+part+'_del'){
		var msg ="선택된 데이터를 정말 삭제하시겠습니까?";
		}else if(oper=='c'+part+'_edit'){
		var msg ="선택된 데이터를 정말 수정하시겠습니까?";
		
		}else if(oper=='c'+part+'_add'){
		var msg ="작성 된 자료로 정말 입력하시겠습니까?";
		}


		 if(confirm(msg))
		 {
		
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
			
			//alert(response.message);
				
			if(part){

			cat_reset(part);
			}

			//get_member_row();
			//$("#btn_manager_close").trigger("click");
			}
			
	

			}
		});

	return;
	}

}




// 하위 항목 체크

var checkcode = function(mode,part) {

	var check_flag;

	var postData;
	var rows = Object();
	if(mode=='c'+part+'_del'){
		var oper = mode;
	}else{
	    var oper = $('#oper'+part).val();
	}

	var pj_id = $('#pj_id').val();
	var pi_id = $('#c'+part+'_id').val();
	var code = $('#c'+part+'_code').val();
	var cat_subject = $('#cat'+part+'_subject').val();
	var protage = $('#protage'+part).val();

	if(cat_subject == ''){
		alert('코드은 필수입니다');
		$('#cat'+part+'_subject').focus();
		return;
	}
	var rows= {

		oper : oper,
		pj_id : pj_id,
		pi_id : pi_id,
		subject : cat_subject,
		code : code,
		protage : protage,
	};
	
	var postData = $.param(rows);
	var url = './ajax/ajax_project_wbs_check.php'//url 수정;
	
				$.ajax({
					url:url,
					async:false,
					data: postData,
					type:'post',
					dataType:'json',
					contentType: "application/x-www-form-urlencoded; charset=UTF-8",
					cache:false,
						success:function(response){
					
		//	var success = (response.flag == 'succ');
		//	if(success) {
						check_flag = response.cnt;
				//		}

					}

				});

			//alert(check_flag);

	return check_flag;

}




</script>


</script>

<?
	include_once("./tail.php");
?>
