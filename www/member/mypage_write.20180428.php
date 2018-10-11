<?
$app = "../"; // common.php 의 상대 경로
include_once($app ."/common.php");

include_once(G5_PATH."/theme/offcanvas/head.php");

	include_once("./head.php");
?>
 
	<?
		include_once("./nav.php");


$aa = "SELECT count(*) FROM `g4_schedule_add` WHERE mb_id = '$member[mb_id]'";
$schedule_check = sql_query("SELECT count(mb_id) as s_check FROM `g4_schedule_add` WHERE mb_id = '$member[mb_id]'");
$schedule_row = sql_fetch_array($schedule_check);


		//print_r2($member);
	?>

 <div class="row row-offcanvas row-offcanvas-right">

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">마이페이지</h2>
		  <hr>

          <div class="col-xs-12 col-sm-9">
			<form name="frm" method="post" action="../admin/member_update.php" enctype="multipart/form-data" >
				<input type="text" name="mb_no" value="<?=$member['mb_no']?>" />
				<input type="text" name="oper" id="oper" value="edit" />
				<input type="text" name="mta" id="mta" value="mta" />

			<!-- table-hover -->
				
				<!-- <table class="table table-striped table-bordered "> -->
			<table  class="table table-bordered"><!--  table-hover -->
				<!-- <caption>테이블 설명</caption> -->
				<col width="15%">
				<col width="">
				<tbody>

					<tr>

						<th style="text-align:center;">활동 정보</th>

						<td>
						누적출석일<input type="text" name="mb_id" value="<?=$schedule_row['s_check']."일"?>" class="form-control" style="width:80px;" READONLY/>

						마일리지<input type="text" name="mb_id" value="<?=$member['mb_point']."점"?>" class="form-control" style="width:80px;" READONLY/>

						마이캘린더<input type="text" name="mb_id" value="???" class="form-control" style="width:80px;" READONLY/>
						</td>
					</tr>


					<tr>
					<th>아이디</th>
					<td><input type="text" name="mb_id" value="<?=$member['mb_id']?>" class="form-control" style="width:200px;" READONLY/></td>
					</tr>

					<tr>
					<th>비밀번호</th>
					<td><input type="password" id="mb_password" name="mb_password" value="" class="form-control" style="width:200px;" /></td>
					</tr>

					<tr>
					<th>비밀번호확인</th>
					<td><input type="password" id="mb_password_re" name="mb_password_re" value="" class="form-control" style="width:200px;" /></td>
					</tr>

					<tr>
					<th>E-mail</th>
					<td><input type="text" name="mb_email" value="<?=$member['mb_email']?>" class="form-control" style="width:300px;" READONLY/>
					</td>
					</tr>


					<tr>
					<th>회원명</th>
					<td><input type="text" id="mb_name" name="mb_name" value="<?=$member['mb_name']?>" class="form-control" style="width:200px;" /></td>
					</tr>
					<tr>
					<th>생년월일</th>
					<td>
					<div class="input-group date" style="width:200px;">
						<input type="text" name="mb_birth"  value="<?=$member['mb_birth']?>"  class="form-control" style="width:200px;"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					 </div></td>
					</tr>
					<tr>
					<tr>
					<th>메모</th>
					<td>

					  <div class="form-group">
						<label for="mb_memo">Example textarea</label>
						<textarea class="form-control" id="mb_memo" name="mb_memo" rows="10"><?=$member['mb_memo']?></textarea>
					  </div>


					</td>
					</tr>

				</tbody>
			</table>

		<div align="right">
			<button type="button" class="btn btn-default btn-sm"  onclick="location.href='/index.php'">
			  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>HOME
			</button>
			
			<button type="button" onclick="saveSubmit()" class="btn btn-primary btn-sm" >
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>저장하기
			</button>
		</div>
			</form>

	<div style="height:70px;"></div>


         </div> 

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->



		<? 	include_once(G5_PATH."/theme/offcanvas/sidebar_mypage.php");?>


      </div>    <!-- row -->
   </div>  <!-- row row-offcanvas row-offcanvas-right -->


<?
	include_once("./footer.php");
?>


<script type="text/javascript">



	  $(function(){

			$('.input-group.date').datepicker({

				calendarWeeks: false,
				todayHighlight: true,
				autoclose: true,
				format: "yyyymmdd",
				language: "kr"

			});

		});



function saveSubmit() {
	

	var mb_password = $("#mb_password").val();
	var mb_password_re = $("#mb_password_re").val();


if(mb_password != mb_password_re || !mb_password || !mb_password_re){
		alert("비밀번호를 확인해주세요.");
		$('#reg_mb_id').focus();
		return false;
	}


document.frm.submit();
}


</script>






<?
	include_once(G5_PATH."/theme/offcanvas/tail.php");

?>
