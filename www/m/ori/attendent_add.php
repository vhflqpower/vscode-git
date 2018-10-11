<? 
include_once("./_common.php");


	//$tomonth = date('Y-m');
    $br_id = $_GET['br_id'];

		$time = time(); 
		$todate = date("d");

		if($_GET['Month']=='nextMonth'){

			$s_year = date("Y");

		if($todate==31)
			$s_month = date("m",strtotime("+29 day", $time));		
		else
			$s_month = date("m",strtotime("+1 month", $time));

			$btn_now = 'btn btn-default';
			$btn_next = 'btn btn-primary';
			$tomonth = $s_year.'-'.$s_month;

		}else{

			$s_year = date("Y");
			$s_month = date("m");

			$btn_now = 'btn btn-primary';
			$btn_next = 'btn btn-default';
			$tomonth = $s_year.'-'.$s_month;

		}


			$d_month = date("m");
		if($todate==31)
			$nMon = date("m",strtotime("+29 day", $time));		
		else
			$nMon = date("m",strtotime("+1 month", $time));
			


		$result = mysql_query("SELECT subject_cd,study_cnt FROM `psj_payment` WHERE mb_cd = '$member[mb_cd]' and pm_status = '1' order by pm_id desc limit 1");
		$row = mysql_fetch_array($result);

		$query1 = "SELECT cs_date,count(*)as cnt FROM cf_class_info WHERE  subject_id = '$row[subject_cd]' and cs_date LIKE  '$tomonth%'  group by cs_date";
		$dbresult1 = mysql_query($query1);
		$cnt = 0;
		while($row1 = mysql_fetch_array($dbresult1)){
			
			$wdate = $row1['cs_date'];
			$ARR_ABSENT_CNT[$wdate] = $row1['cnt'];	
		$cnt++;
		}





include_once("./head.php");
?>


<div data-role="page" id="attdent_add">
  <div data-role="header">
      <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a>
   <h1><a href="./" class='menu'>HANSABU GYM</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>

<? 

include_once("./navbar.php");

	
?>
<div data-role="main" class="ui-content">
    <h2>수업예약</h2>

	<input type="hidden" id="toYear" value="<?=$s_year?>">
	<input type="hidden" id="toMonth" value="<?=$s_month;?>">
	 <input type="hidden"  id="request_date" >
	<input type="hidden" id="co_id" name="co_id" value="<?=$member[mb_3];?>">
	<input type="hidden" id="black_company" name="black_company" value="<?=$row_co[cnt];?>">
	<input type="hidden"  id="ab_cnt" >
	<input type="hidden"  id="study_cnt" value="<?=$row['study_cnt']?>">


	<!-- <div style="margin:0 auto;border:0px solid red;"> -->
<?
	
	if($Month=='nextMonth'){
		$NOW_CHECKED = "";
		$NEXT_CHECKED = "checked='checked'";
	}else{
		$NOW_CHECKED = "checked='checked'";
		$NEXT_CHECKED = "";
	}


//  회원 예약 내역
		$query2 = "SELECT ab_id,ab_date,mb_cd,pm_id,class_id FROM cf_absent WHERE   mb_cd = '$member[mb_cd]' and ab_date LIKE  '$tomonth%'";
		$dbresult2 = mysql_query($query2);
		$cnt = 0;
		while($row2 = mysql_fetch_array($dbresult2)){

			$pm_id = $row2['pm_id'];	
			$mb_cd = $row2['mb_cd'];
			$wdate = $row2['ab_date'];

			$ARR_ABSENT_MB_CNT[$cnt][$wdate][$mb_cd] = array($row2['mb_cd'],$row2['pm_id'],$row2['class_id'],$row2['ab_id']);	
		$cnt++;
		}


?>

<!-- <div style="float:right;width:260px;border:0px solid red;"> -->
	<input type="hidden"  id="add_cnt" value="<?echo count($ARR_ABSENT_MB_CNT)?>">
  <div class="ui-field-contain">
	 <table data-role="table" border=0 data-mode="">
	  <tr><td style="text-align:center">

		<div data-role="fieldcontain"> 
			<fieldset data-role="controlgroup" data-type="horizontal">
				<input data-theme="a" type="radio" name="radio-view-a" id="radio-view-a-a" value="list" onclick="location.href='./attendent_add.php?Year=thisYear&Month=thisMonth&br_id=<?=$br_id?>'" <?=$NOW_CHECKED?>/> 
				<label for="radio-view-a-a" data-form="ui-btn-up-a"><?=$d_month?>월 스케쥴</label> 
				<input data-theme="a" type="radio" name="radio-view-a" id="radio-view-b-a" value="grid"  onclick="location.href='./attendent_add.php?Year=nextYear&Month=nextMonth&br_id=<?=$br_id?>'" <?=$NEXT_CHECKED?>/> 
				<label for="radio-view-b-a" data-form="ui-btn-up-a"><?=$nMon?>월 스케쥴</label> 
			</fieldset> 
		</div>


	</td></tr>
	</table>

</div>

  <div class="ui-field-contain">


	 <!-- <table data-role="table" border=0 data-mode="" class="ui-responsive" id="myTable"> -->
	 <table  width="100%" class="table-bordered" id="myTable">
	    <col width="14.2%">
	    <col width="14.2%">
	    <col width="14.2%">
	    <col width="14.2%">
	    <col width="14.2%">
	    <col width="14.2%">
	    <col width="14.2%">
		<tr>
		<th  height=20 bgcolor="#ebebeb"><font color=red>일</font></th>
		<th   bgcolor="#ebebeb">월</th>
		<th   bgcolor="#ebebeb">화</th>
		<th   bgcolor="#ebebeb">수</th>
		<th   bgcolor="#ebebeb">목</th>
		<th   bgcolor="#ebebeb">금</th>
		<th   bgcolor="#ebebeb"><font color=blue>토</font></th>
		</tr>
		<tr>
		</tr>
		<tr height= valign=top>
			<?

			$sYear =  $s_year;
			$sMon =  $s_month;

			$startnum = date("w", mktime(0,0,0,$sMon,1,$sYear));
			$endnum = date("t", mktime(0,0,0,$sMon,1,$sYear) );

			for ($i = 0; $i < $startnum; $i++)
			{
				echo "";
				echo "<td></td>";
			}


			for ($f = 1; $f <= $endnum; $f++)
			{
				if (!date("w", mktime(0,0,0,$sMon,$f,$sYear)) && !($f == 1 && $startnum ==0))
				{
					echo "";
					echo "</tr>";
					echo "<tr>";
					echo "</tr>";
					echo "<tr  valign=top>";
					$cellrow = 0;
				}

				$ff = sprintf("%02d",$f);  

				$tmp_today = $sYear.'-'.$sMon; 
				$today =$tmp_today.'-'.$ff;
				$day = date("d"); 
				$real_today = date("Y-m-d");
			 
				if($today==$real_today)$BGCOLOR='#a5e1a2';else$BGCOLOR='#fff';

				echo "<td  height='60px' style=\"background-color:$BGCOLOR;\" >$f";


				$torrow =  date("Y-m-d",strtotime("+1 day"));
				$twonine =  date("Y-m-d",strtotime("+29 day"));


				$mbcd = $member['mb_cd'];

				if($today >= $real_today){ 

					if($ARR_ABSENT_CNT[$today] > 0)
					echo"<br><a href='#1' onclick=\"checkDate($ff)\"><img src='./img/check.png' width='30px' height='30px'></a>";
					echo "<br><font color=blue>$ARR_ABSENT_CNT[$today]</font>";

				}else{		
				// <a href='#1' onclick=\"checkDate($ff)\"><img src='./img/close.PNG' width='30px' height='30px'></a>
					echo "<br><font color=blue>$ARR_ABSENT_CNT[$today]</font>";
				}

					
					foreach($ARR_ABSENT_MB_CNT as $key => $val){

						if($val[$today][$mb_cd][0]){

							$mb_cd = $val[$today][$mb_cd][0];
							$pm_id = $val[$today][$mb_cd][1];
							$cs_id = $val[$today][$mb_cd][2];
							$ab_id = $val[$today][$mb_cd][3];


					if($today < $real_today){
												echo "<br><a href=#  onclick=\"getabsentDataPast('$cs_id','$pm_id','$ab_id','$today')\"><font color=black size=5>&#9787;</font></a>";
					}else{
												echo "<br><a href=#  onclick=\"getabsentData('$cs_id','$pm_id','$ab_id','$today')\"><font color=blue size=5>&#9787;</font></a>";

					}


						}


					}

				echo "</td>";
				$cellrow++;
			}

			for ($i = $cellrow; $i < 7; $i++)
			{ 
				echo "<td ></td>";
			}

			?> 

		</tr>

</table>

  </div>



  <div class="ui-field-contain">
    <label for="to_date">회원수강정보</label>
		<select class="form-control" id="pm_id" name="pm_id" style="font-weight:bold;" >
					<!-- <option value=''>-선택-</option> -->	
				<?				
						$sql_pm = "select  a.pm_id,
									a.pm_pay_date,
									a.pm_sdate,
									a.pm_edate,
									a.pm_price,
									a.paid_price,
									(select b.pi_subject from psj_pay_item b where b.pi_id = a.pay_item_id) as subject
							from 
									psj_payment  a 
							where 	a.mb_cd = '$member[mb_cd]' && a.pm_status = '1' order by a.pm_no desc";
							$res = mysql_query($sql_pm);
							while($row_pay = mysql_fetch_array($res)){
								
				?>					
				<option value='<?=$row_pay[pm_id]?>' ><?=$row_pay['subject'];?>(<?=number_format($row_pay['paid_price']);?>)<font color=blue><?=$row_pay['pm_sdate'];?></font>~<font color=red><?=$row_pay['pm_edate'];?></font></option>
				<? } ?>

				<input type="hidden" id="ab_id">
				<input type="hidden" id="past_ab">
    </div>


  <div class="ui-field-contain">
    <label for="to_date">수업일선택:</label>
      <input type="text" class="form-control" id="to_date" style="font-weight:bold;" placeholder="수업일">
    </div>

  <div class="ui-field-contain" id="cs_id_sel">
    <label for="cs_id">수업선택:</label>
	<select class="form-control" id="cs_id" style="font-weight:bold;" onChange="getPromoPrice()";>
	<option value=''>수강항목선택</option>
	</select>
    </div>


  <div class="ui-field-contain" id="cs_id_view">
    <label for="cs_id_name">수업선택</label>
	<input type="text" class="form-control" id="cs_id_name" style="font-weight:bold;" placeholder="수강항목" readonly/>
	</select>
    </div>



  <div class="ui-field-contain">
    <label for="teacher">강사명:</label>
          <input type="text" class="form-control" id="teacher" style="font-weight:bold;" placeholder="강사" readonly/>
    </div>

  <button class="ui-btn ui-btn-b ui-corner-all"  onclick="scheduleSubmit('I')" id="btn_submit" >예약하기</button>	
  <button class="ui-btn ui-btn-w ui-corner-all"  onclick="scheduleSubmit('D')" id="btn_cancle" >예약취소</button>	
  <button class="ui-btn ui-btn-w ui-corner-all"  onclick="location.href='./attendent_add.php'" id="btn_cancle" >새로고침</button>	
  </div><!-- data-role="main" -->



<script>

// 날짜 클릭 시 해당일 수업 정보 가져오기
function checkDate(id){

	$("#ab_cnt").val('');
	$("#ab_id").val('');
	$("#past_ab").val('');

	$("#cs_id_sel").css("display","block");
	$("#cs_id_view").css("display","none");

	$("#btn_submit").css("display","block");
	$("#btn_cancle").css("display","none");

/*
	var br_id = $("#br_id").val();

	if(br_id==''){
		alert('브랜드를 선택하세요');
		return false;
	}
*/
	var toMon = $("#toMonth").val();
	var toYear = $("#toYear").val();
	var day = fillzero(id, 2);	
	$("#to_date").val(toYear+'-'+toMon+'-'+day);
	$("#request_date").val(toMon+'월'+day+'일');


	var photo_date = $("#to_date").val();
//	var br_id = $("#br_id").val();
	  url = './ajax_get_schedule.php?photo_date='+photo_date;

  $.ajax
      ({
         type: "POST",
         url: url,
         data: "photo_date="+photo_date,
         success: function(option)
         {
           $("#cs_id").html(option);
		  
		 }

      });
  
		  return false;

}



function getabsentData(cs_id,pm_id,ab_id,today){

		$("#past_ab").val('');
		$("#to_date").val(today);
		$("#pm_id").val(pm_id);
		$("#ab_id").val(ab_id);
		$('#pm_id').selectmenu('refresh', true);

		$("#cs_id_sel").css("display","none");
		$("#cs_id_view").css("display","block");
		$("#btn_submit").css("display","none");
		$("#btn_cancle").css("display","block");

	
	  url = './ajax_ab_subject_load.php?cs_id='+cs_id;

  $.ajax
      ({
         type: "POST",
         url: url,
         data: "cs_id="+cs_id,
		dataType:'json',
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩
			if(success) {
				var cell = response.rows;

			$("#cs_id_name").val(cell.subject);
			$("#teacher").val(cell.teacher_name);
		  

			}
		 }

      });
  
		  return false;


}

// 오늘 이전 출석정보 로딩
function getabsentDataPast(cs_id,pm_id,ab_id,today){



		$("#past_ab").val(1);
		$("#to_date").val(today);
		$("#pm_id").val(pm_id);
		$("#ab_id").val(ab_id);
		$('#pm_id').selectmenu('refresh', true);

		$("#cs_id_sel").css("display","none");
		$("#cs_id_view").css("display","block");
		$("#btn_submit").css("display","none");
		$("#btn_cancle").css("display","block");

	
	  url = './ajax_ab_subject_load.php?cs_id='+cs_id;

  $.ajax
      ({
         type: "POST",
         url: url,
         data: "cs_id="+cs_id,
		dataType:'json',
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩
			if(success) {
				var cell = response.rows;

			$("#cs_id_name").val(cell.subject);
			$("#teacher").val(cell.teacher_name);
		  

			}
		 }

      });
  
		  return false;


}
//------------------------------------------------------------------> 강사정보로딩
function getPromoPrice(cs_id) {

 var cs_id= $("#cs_id").val();

url = './ajax_promo_price.php?cs_id=' + cs_id ;
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
			//데이타 로딩
			if(success) {
				var cell = response.rows;

		//	if(black_company > 0){  // 디자인웨딩(구OK웨딩) , 와이즈웨딩
		//	alert('소속하신 업체는 잔여타임 홀딩이 불가합니다.');
		//	return false;
		//	}
				$('#teacher').val(cell.teacher_name);

			} else {
				alert('fail to load data');
			}
		}
	});
}



function br_copy(id){

	$("#br_id").val(id);

}


function scheduleSubmit(mode){

	var ab_id = $("#ab_id").val();
	var pm_id = $("#pm_id").val();
	var to_date = $("#to_date").val();
	var cs_id = $("#cs_id").val();
	var mb_cd = '<?=$member[mb_cd]?>';
	 $("#ab_cnt").val('');

	var study_cnt = $("#study_cnt").val();
	var add_cnt = $("#add_cnt").val();


//	var br_name = $("#br_id option:selected").text();

	//alert(ab_cnt)
	//add_absent_check()
if(mode=='I'){
		add_absent_check()
		if($("#ab_cnt").val() > 0){ 
		alert('이미 수강 예약을 등록 하였습니다.'); 
		return false;
		}

	if(!to_date){
	alert('수업일을 선택하세요');
	return false;
	}

	if(!cs_id){
	alert('선택일의 수강정보를 선택하세요.');
	return false;
	}


	if(study_cnt <= add_cnt){
	  alert('이미 모든 수강 횟수를 사용하였습니다..');
	return false;
	}



}else{

	if(!ab_id){
	alert('해당 예약정보가 없습니다.');
	return false;
	}


	if($("#past_ab").val() !=''){
	alert('오늘 이전 정보는 취소할 수 없습니다.');
	return false;
	}


}


	var rows= {

		ab_id : ab_id,
		pm_id : pm_id,
		ab_date : to_date,
		cs_id : cs_id,
		mb_cd : mb_cd,
		mode : mode,


	};
	
	var postData = $.param(rows);
//	var postData = $('.inputForm :input').serialize() + '&oper=edit&id=<?=$id?>';
	var url = './ajax_absent_add_server.php'//url 수정;

if(mode=='I'){
	var msg =  '수강을 정말 예약하시겠습니까?';
}else{
	var msg =  '수강을 정말 취소하시겠습니까?';
}


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
				var msgs1 = response.msg1;

			 	//alert(msgs1);
			 	window.location.reload();

			}
		});
	}

	return;

}




function add_absent_check() {

 var cs_id= $("#cs_id").val();
 var mb_cd = '<?=$member[mb_cd]?>';


	var rows= {
		cs_id : cs_id,
		mb_cd : mb_cd,

	};


	var postData = $.param(rows);
	url = './ajax_mb_ab_add_load.php' ;
	$.ajax({
		url:url,
		type:'POST',
		data: postData,
		dataType:'json',
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
		success:function(response) {
			var success = (response.flag == 'succ');
		//	var message = response.message;
			var new_id = response.id;
			//데이타 로딩
			if(success) {
				var cell = response.rows;

				$("#ab_cnt").val(cell.cnt);
				//alert(cell.cnt)

			} else {
				alert('fail to load data');
			}
		}
	});
}



function fillzero(obj, len) {
  obj= '000000000000000'+obj;
  return obj.substring(obj.length-len);
} 


$(document).ready(function() { 

	
	$("#cs_id_view").css("display","none");
	$("#btn_cancle").css("display","none");

	$("#ab_id").val('');
	$("#ab_cnt").val('');
	});

</script>


<? 
include_once("./foot.php");
?>
