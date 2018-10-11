<? 
include_once("./_common.php");




include_once("./head.php");
?>


<div data-role="page" id="absent_his">
  <div data-role="header">
      <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a>
   <h1><a href="./" class='menu'>M.T.A 엠티에이</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>


<? 
include_once("./navbar.php");
?>


<script>

	// 온로드		
	$( function() {
		// 데이터 조회
		getAttdentCalendar();
	    getSubjectData();

	});
  

	function getAttdentCalendar() {

		var  at_year = $("#at_year").val();
		var  at_month = $("#at_month").val();

		var param = "at_year="+at_year+"&at_month="+at_month;
		//console.log( "=====> param: "+ param );
		  $(".tblBody").remove();
		  $("#ajax_list_data").remove();
		  $(".item_row").remove();

		$.ajax({
			url: "./ajax_attendent_calendar.php",
			type: "GET",
			data: param,
			success: function( data ){
				
				$("#calendarLoad").append( data );
				$('#myTable').table('refresh');
				
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Ajax failure');
			}
	   });
	}


	function getSubjectData(wdate) {

		var param = "wdate="+wdate;
		//console.log( "=====> param: "+ param );
		 // $(".tblBody").remove();
		  $(".item_row").remove();

		$.ajax({
			url: "./ajax_calendar_subject.php",
			type: "GET",
			data: param,
			success: function( data ){
				
				$("#ajax_subject_data").append( data );
				$('#myTable').table('refresh');
				
				$("body").scrollTop($(document).height());

			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Ajax failure');
			}
	   });
	}

</script>

<div data-role="main" class="ui-content">
    <!-- <h2>출석내역</h2>
	-->



<!-- <div style="float:right;width:260px;border:0px solid red;"> -->
  
  <!-- <div class="ui-field-contain">

 -->


 <div class="ui-field-contain"> 

		<div class="btn-wrap clearfix">
			<span class="grid1of2 pr3">
				<select class="form-control" id="at_year" name="at_year" >
			  <option value=''>-년도-</option>
			  <? 
					$thisYear = date("Y");
					for($i=1960;$i<2031; $i++){	
				 ?>
				 <option value="<?=$i?>" <? if($thisYear== $i)echo"selected"?> style="font-weight:bold;"><?=$i?></option>
				<? } ?>
			</select>
			</span>
			<span class="grid1of2 pl3">

			<select class="form-control" id="at_month" name="at_month" onchange="getAttdentCalendar()">
			  <option value=''>-월-</option>
			  <? 
					$thisMon = date("m");
					for($ii=1;$ii<13; $ii++){	
					 $m = sprintf('%02d',$ii);
				 ?>
				 <option value="<?=$m?>" <? if($thisMon== $m)echo"selected"?> ><?=$ii?></option>
				<? } ?>
			</select>
			
			
			</span>
		</div>

	 </div> 


  <div class="ui-field-contain">

		 <table  width="100%" class="table-bordered" id="myTable">
		    <col width="14.28%">
		    <col width="14.28%">
		    <col width="14.28%">
		    <col width="14.28%">
		    <col width="14.28%">
		    <col width="14.28%">
		    <col width="14.28%">
			<thead>
			<tr>
			<th  height=20 bgcolor="#ebebeb"><font color=red>일</font></th>
			<th  height=20 bgcolor="#ebebeb">월</th>
			<th  height=20 bgcolor="#ebebeb">화</th>
			<th  height=20 bgcolor="#ebebeb">수</th>
			<th  height=20 bgcolor="#ebebeb">목</th>
			<th  height=20 bgcolor="#ebebeb">금</th>
			<th  height=20 bgcolor="#ebebeb"><font color=blue>토</font></th>
			</tr>
			</thead>
			<tbody id='calendarLoad'>
			
			</tbody>
		</table>

		<br>
	    <table border="0" width="100%" style="padding-collapse:collapse;">
					  <col width="80%">
					  <col width="20%">	  
					  <thead></thead>
					  <tbody class="slideListBody" id="ajax_subject_data">
					  </tbody>
		 </table>
		<br><br>

  </div>
		 <!--
				<div class="btn-wrap clearfix">
					<span class="grid1of2 pr3"><a href="/app/member_join_step1.php" class="btn btn-block btn-lg">회원가입</a></span>
					<span class="grid1of2 pl3"><a href="/m/login.php?chUrl=<?=$_GET['chUrl']?>" class="btn btn-block btn-lg bg-pink">로그인</a></span>
				</div>
		 -->



		   <!-- <div data-role="content">
				<div class="ui-grid-a ui-responsive">
					 <div class="ui-block-a"><a href="#" data-role="button">Yes</a></div>
					 <div class="ui-block-b"><a href="#" data-role="button">No</a></div>
				</div>
		   </div>
		 -->



  </div><!-- data-role="main" -->



<? 
include_once("./foot.php");



?>
