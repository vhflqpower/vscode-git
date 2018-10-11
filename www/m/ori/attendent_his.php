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


	//print_r($member);


			$d_month = date("m");
		if($todate==31)
			$nMon = date("m",strtotime("+29 day", $time));		
		else
			$nMon = date("m",strtotime("+1 month", $time));
			

		$query1 = "SELECT ab_date,count(*)as cnt FROM cf_absent WHERE  ab_date LIKE  '$tomonth%' and mb_cd ='$member[mb_id]'  group by ab_date";

		$dbresult1 = mysql_query($query1);
		$cnt = 0;
		while($row1 = mysql_fetch_array($dbresult1)){
			
			$wdate = $row1['ab_date'];
			$ARR_ABSENT_CNT[$wdate] = $row1['cnt'];	
		$cnt++;
		}


include_once("./head.php");
?>


<div data-role="page" id="absent_add">
  <div data-role="header">
      <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a>
   <h1><a href="./" class='menu'>HANSABU GYM</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>


<? 
include_once("./navbar.php");
?>
<div data-role="main" class="ui-content">
    <h2>출석내역</h2>

	<input type="hidden" id="toYear" value="<?=$s_year?>">
	<input type="hidden" id="toMonth" value="<?=$s_month;?>">
	 <input type="hidden"  id="request_date" >
	<input type="hidden" id="co_id" name="co_id" value="<?=$member[mb_3];?>">
	<input type="hidden" id="black_company" name="black_company" value="<?=$row_co[cnt];?>">
	<input type="hidden"  id="ab_cnt" >
	<!-- <div style="margin:0 auto;border:0px solid red;"> -->

	<?
		
	if($Month=='nextMonth'){
		$NOW_CHECKED = "";
		$NEXT_CHECKED = "checked='checked'";
	}else{
		$NOW_CHECKED = "checked='checked'";
		$NEXT_CHECKED = "";
	}


	?>


<!-- <div style="float:right;width:260px;border:0px solid red;"> -->
  
  <div class="ui-field-contain">

	 <table data-role="table" border=0 data-mode="">
	  <tr><td style="text-align:center">

		<div data-role="fieldcontain"> 
			<fieldset data-role="controlgroup" data-type="horizontal">
				<input data-theme="a" type="radio" name="radio-view-a" id="radio-view-a-a" value="list" onclick="location.href='./attendent_his.php?Year=thisYear&Month=thisMonth&br_id=<?=$br_id?>'" /> 
				<label for="radio-view-a-a" data-form="ui-btn-up-a">이전달</label> 


				<input data-theme="a" type="radio" name="radio-view-a" id="radio-view-b-a" value="list" onclick="location.href='./attendent_his.php?Year=thisYear&Month=thisMonth&br_id=<?=$br_id?>'" <?=$NOW_CHECKED?>/> 
				<label for="radio-view-b-a" data-form="ui-btn-up-a">2017-<?=$d_month?></label> 


				<input data-theme="a" type="radio" name="radio-view-a" id="radio-view-c-a" value="grid"  onclick="location.href='./attendent_his.php?Year=nextYear&Month=nextMonth&br_id=<?=$br_id?>'" /> 
				<label for="radio-view-c-a" data-form="ui-btn-up-a">다음달</label> 
			</fieldset> 
		</div>

	</td></tr>
	</table>

</div>


  <div class="ui-field-contain">

		<?
		//echo $query1;
		
		?>


	 <!-- <table data-role="table" border=0 data-mode="" class="ui-responsive" id="myTable"> -->
	 <table  width="100%" class="table-bordered" id="myTable">

		<tr>
		<th  height=20 bgcolor="#ebebeb"><font color=red>일</font></th>
		<th  height=20 bgcolor="#ebebeb">월</th>
		<th  height=20 bgcolor="#ebebeb">화</th>
		<th  height=20 bgcolor="#ebebeb">수</th>
		<th  height=20 bgcolor="#ebebeb">목</th>
		<th  height=20 bgcolor="#ebebeb">금</th>
		<th  height=20 bgcolor="#ebebeb"><font color=blue>토</font></th>
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



			//	if($today >= $real_today){ 

					if($ARR_ABSENT_CNT[$today] > 0){
					//echo"<br><a href='#1' onclick=\"checkDate($ff)\"><img src='./img/check.png' width='30px' height='30px'></a>";
					//echo "<br><font color=blue>$ARR_ABSENT_CNT[$today]</font>";
					echo "<br><a href='#1' onclick=\"checkDate($ff)\"><img src='./img/user.png' width='30px' height='30px'></a>";
					}
				//}else{		
				
					//echo "<br><font color=blue>$ARR_ABSENT_CNT[$today]</font>";
				//}


			//	if($today==$real_today)echo"<br><font color=red>오늘</font>";
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
    <label for="to_date">수업일선택:</label>
      <input type="text" class="form-control" id="to_date" style="font-weight:bold;" placeholder="촬영일">
    </div>

  <div class="ui-field-contain">
    <label for="cs_id">수업선택:</label>
	<select class="form-control" id="cs_id" style="font-weight:bold;" onChange="getPromoPrice()";>
	<option value=''>수련항목선택</option>
	</select>
    </div>

<!-- 
  <div class="ui-field-contain">
    <label for="photo_price">촬영가:</label>
      <input type="text" class="form-control" id="photo_price" style="font-weight:bold;" placeholder="촬영가">
    </div> -->

  <div class="ui-field-contain">
    <label for="teacher">강사명:</label>
          <input type="text" class="form-control" id="teacher" style="font-weight:bold;" placeholder="강사" readonly/>
    </div>



  <!-- <button class="ui-btn ui-btn-b ui-corner-all"  onclick="scheduleSubmit()" id="btn_submit" >수업 등록</button>	 -->



  </div><!-- data-role="main" -->



<script>

function checkDate(id){

	$("#ab_cnt").val('');
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



//------------------------------------------------------------------> 카테고리2로딩
function getPromoPrice() {

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


function scheduleSubmit(){

//	var co_id = $("#co_id").val();
//	var black_company = $("#black_company").val();
	var to_date = $("#to_date").val();
	var cs_id = $("#cs_id").val();
	var mb_cd = '<?=$member[mb_cd]?>';
	 $("#ab_cnt").val('');

//	var br_name = $("#br_id option:selected").text();

	//alert(ab_cnt)
	//add_absent_check()

			add_absent_check()
	
			if($("#ab_cnt").val() > 0){ 
			alert('이미 수업을 등록 하였습니다.'); 
			return false;
			}


/*
	if(ab_cnt > 0){
	alert('이미 수업을 등록 하였습니다.');
	return false;
	}
*/

	if(!to_date){
	alert('수업일을 선택하세요');
	return false;
	}

	if(!cs_id){
	alert('수련 정보를 선택하세요');
	return false;
	}




	var rows= {

		ab_date : to_date,
		cs_id : cs_id,
		mb_cd : mb_cd,


	};
	
	var postData = $.param(rows);
//	var postData = $('.inputForm :input').serialize() + '&oper=edit&id=<?=$id?>';
	var url = './ajax_absent_add_server.php'//url 수정;


	var msg =  '출석을 정말 등록하시겠습니까?';

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

</script>



<? 
include_once("./foot.php");



?>
