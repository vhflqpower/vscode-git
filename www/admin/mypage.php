<?
	include_once("../common.php");




	if($_GET['mb_no']){

	$mb_no = $_GET['mb_no'];

			$sql = "SELECT * FROM psj_member WHERE  mb_no = '$mb_no'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);

			$mb_id = $row['mb_id'];

		$oper = 'edit';
	}else{

			$sql = "SELECT * FROM psj_member WHERE  mb_no = '$member[mb_no]'";
			$result = sql_query($sql);
			$row = sql_fetch_array($result);
		
			$mb_id = $row['mb_id'];

		$oper = 'add';
		$view[bo_skin] = 'basic';
	}


	include_once("./head.php");
?>



<style>
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}
</style>
 
	<?
		include_once("./nav.php");
	?>
<link rel="stylesheet" href="/css/boot_tab.css" type="text/css">
 
 <div class="container-fluid">
	<?
		include_once("./sidebar_mypage.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->
<? if($_GET['mb_no']){ ?>
          <h2 class="sub-header"><?=$row['mb_name']?></h2>
<? }else{ ?>
          <h2 class="sub-header">MY PAGE</h2>
<? } ?>

          <div class="table-responsive">

			

		    <div class="col-md-12" style="padding:0px;">
			  <div class="panel with-nav-tabs panel-info">
				<input type="hidden" name="tab_id" id="tab_id" value="<?=$tab_id?>">
			      <div class="panel-heading">
				    <ul class="nav nav-tabs">
				        <li class="active" ><a href="#tab1info" data-toggle="tab" id="tab1">나의정보</a></li>
				        <li ><a href="#tab2info" data-toggle="tab" id="tab2">게시글 현황</a></li>
				        <li ><a href="#tab3info" data-toggle="tab" id="tab3">마일리지</a></li>
						<li ><a href="#tab4info" data-toggle="tab" id="tab4">접속로그</a></li>
						 <li ><a href="#tab5info" data-toggle="tab" id="tab5">출석내역</a></li>

				    </ul>
			      </div>
			      <div class="panel-body">
				<div class="tab-content">
				    <div class="tab-pane fade in active" id="tab1info">


<form name="frm" method="post" action="./member_update.php" enctype="multipart/form-data" >
				<input type="hidden" name="mb_no" value="<?=$row['mb_no']?>" />
				<input type="hidden" name="oper" id="oper" value="<?=$oper?>" />
				<input type="hidden" name="mb_id_enabled"    value="" id="mb_id_enabled">
				<input type="hidden" name="mb_email_enabled"    value="" id="mb_email_enabled">
			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered"><!--  table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<tr>
				<? if($row['mb_id']){ ?>
					<th>아이디</th>
					<td><input type="text" name="mb_id" value="<?=$row['mb_id']?>" class="form-control" style="width:200px;" READONLY/></td>
					</tr>
				<? }else{ ?>
					<th>아이디</th>
					<td><input type="text" name="mb_id" value="<?=$row['mb_id']?>"  id="reg_mb_id" onblur='reg_mb_cd_check();' class="form-control" style="width:200px;" />
					<span id='msg_mb_id'></span>
					</td>
					</tr>
				<? } ?>
					
					<tr>
					<th>비밀번호</th>
					<td><input type="password" id="mb_password" name="mb_password" value="" class="form-control" style="width:200px;" /></td>
					</tr>

					<tr>
					<th>비밀번호확인</th>
					<td><input type="password" id="mb_password_re" name="mb_password_re" value="" class="form-control" style="width:200px;" /></td>
					</tr>

					<tr>
				<? if($row['mb_email']){ ?>
					<th>E-mail</th>
					<td><input type="text" name="mb_email" value="<?=$row['mb_email']?>" class="form-control" style="width:300px;" READONLY/>
					</td>
					</tr>
				<? }else{ ?>
					<th>E-mail</th>
					<td><input type="text" name="mb_email" value="<?=$row['mb_email']?>"  id="reg_mb_email" onblur='reg_mb_email_check();' class="form-control" style="width:300px;" />
					<span id='msg_mb_email' style="color:#ffff00;"></span>
					</td>
					</tr>
				<? } ?>

					<tr>
					<th>회원명</th>
					<td><input type="text" id="mb_name" name="mb_name" value="<?=$row['mb_name']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>
					<th>생년월일</th>
					<td>
					<div class="input-group date" style="width:200px;">
						<input type="text" name="mb_birth"  value="<?=$row['mb_birth']?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					 </div></td>
					</tr>

					<tr>
					<th>회원레벨</th>
					<td>
						<select name='mb_level' id="mb_level" required itemname="회원레벨" class="form-control" style="width:150px" >
						<option value="1" <?if($row['mb_level']=='1')echo"selected"?>>1</option>
						<option value="2" <?if($row['mb_level']=='2')echo"selected"?>>2</option>
						<option value="3" <?if($row['mb_level']=='3')echo"selected"?>>3</option>
						<option value="4" <?if($row['mb_level']=='4')echo"selected"?>>4</option>
						<option value="5" <?if($row['mb_level']=='5')echo"selected"?>>5</option>
						<option value="6" <?if($row['mb_level']=='6')echo"selected"?>>6</option>
						<option value="7" <?if($row['mb_level']=='7')echo"selected"?>>7</option>
						<option value="8" <?if($row['mb_level']=='8')echo"selected"?>>8</option>
						<option value="9" <?if($row['mb_level']=='9')echo"selected"?>>9</option>
						<option value="10" <?if($row['mb_level']=='10')echo"selected"?>>10</option>
						</select> 
					</td>
					</tr>
						

					<tr>
					<th>마일리지</th>
					<td>
						<?=number_format($row['mb_point'])?>
					</td>
					</tr>
				</tbody>
			</table>
				


				     </div>
				    <div class="tab-pane fade" id="tab2info"><!-- #########   ######### -->

						<table  class="table table-bordered"><!--  table-hover -->

							<col width="15%">
							<col width="">
							<tbody>


								<tr>
								<th>이슈트랙킹(로그)</th>
								<td>
								<? 
								$sql = "SELECT count(*)as issu_cnt FROM psj_issu WHERE  mb_id = '$mb_id'";
								$result = sql_query($sql);
								$row = sql_fetch_array($result);
								echo $row['issu_cnt'];
								?>
								<? 
								$sql = "SELECT count(*)as issu_log_cnt FROM psj_issu_log WHERE  mb_id = '$mb_id'";
								$result = sql_query($sql);
								$row = sql_fetch_array($result);
								echo '('.$row['issu_log_cnt'].')';
								?>
								</td>
								</tr>


								<tr>
								<th>정보게시판</th>
								<td>
								<? 
								$sql = "SELECT count(*)as info_cnt FROM psj_board WHERE bo_table='info' and  mb_id = '$mb_id'";
								$result = sql_query($sql);
								$row = sql_fetch_array($result);
								echo $row['info_cnt'];
								?>
								</td>
								</tr>

								<tr>
								<th>버그&제안</th>
								<td>
								<? 
								$sql = "SELECT count(*)as bug_cnt FROM psj_board WHERE bo_table='bugreport' and  mb_id = '$member[mb_id]'";
								$result = sql_query($sql);
								$row = sql_fetch_array($result);
								echo $row['bug_cnt'];
								?>
								</td>
								</tr>
									

							</tbody>
						</table>
				
					<!--  -->
					</div>
				    <div class="tab-pane fade" id="tab3info"><!-- #########   ######### -->
				
					<script>
					function getresult(url) {

						//alert($("#cat1").val())

						$.ajax({
							url: url,
							type: "GET",
							data:{
								rowcount:$("#rowcount").val(),
								search_field:$("#search_field").val(),
								search_value:$("#search_value").val(),
								cat1:$("#cat1").val(),
								mb_id: '<?=$mb_id?>',
								nowpage:$("#nowpage").val()
								},
							success: function(data){

							$("#mileage_data_result").html(data);
							},
							error: function() 
							{}
					   });
					}

					<? if(!$_GET[page]){ $page =1; }else{  $page =$_GET[page];} ?>
					getresult('/admin/ajax/ajax_mb_mileage_row_data.php?page=<?=$page?>');

					</script>

						<div id="mileage_data_result">
						<input type="text" name="rowcount" id="rowcount" value="5" />
						</div> 

				    </div>
				    <div class="tab-pane fade" id="tab4info"><!-- ######### 접속로그  ######### -->
					

					<script>
					function getresult2(url) {

						//alert($("#cat1").val())

						$.ajax({
							url: url,
							type: "GET",
							data:{
								rowcount:$("#rowcount").val(),
								search_field:$("#search_field").val(),
								search_value:$("#search_value").val(),
								mb_id: '<?=$mb_id?>',
								nowpage:$("#nowpage").val()
								},
							success: function(data){

							$("#login_data_result").html(data);
							},
							error: function() 
							{}
					   });
					}

					<? if(!$_GET[page]){ $page =1; }else{  $page =$_GET[page];} ?>
					getresult2('/admin/ajax/ajax_mb_login_row_data.php?page=<?=$page?>');

					</script>

						<div id="login_data_result">
						<input type="text" name="rowcount" id="rowcount" value="5" />
						</div> 
										
					
					
					</div>
				    <div class="tab-pane fade" id="tab5info">
					
						<table class="table table-striped">
										<col width="20%">
										<col width="20%">
										<col width="40%">
										<col width="20%">
												  <thead>
													<tr>
													  <th>NO</th>
													  <th>IP</th>
													  <th>DATE TIME</th>
													</tr>
												  </thead>
										  <tbody >

											<?php
											$num = 1;
												$query = "select a.*,b.* from psj_schedule_add a left join psj_board_schedule b on a.board_seq = b.wr_id  where a.mb_id = '$member[mb_id]' order by a.regdate desc";
												$results = sql_query($query);
												while($row = sql_fetch_array($results))
												{
											 ?>
											 <tr>
												 <td ><?=$num?></td>
												 <td ><?=$row['wr_subject']?></a></td>
												 <td><?=$row['regdate']?></td>
												 <td><?=$row['regdate']?></td>
											 </tr>
										<?
										$num++;
											 } ?>
								</table>					
					
					
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

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->




<?
	include_once("./footer.php");
?>

<script>
$(document).ready(function() {

   $('#mypage').attr("class", "list-group-item active");

});

</script>



<?
	include_once("./tail.php");
?>
