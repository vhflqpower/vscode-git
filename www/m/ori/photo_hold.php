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
			

		$query1 = "SELECT cs_date,count(*)as cnt FROM cf_class_info WHERE  cs_date LIKE  '$tomonth%'  group by cs_date";
		$dbresult1 = mysql_query($query1);
		$cnt = 0;
		while($row1 = mysql_fetch_array($dbresult1)){
			
			$wdate = $row1['cs_date'];
			$ARR_ABSENT_CNT[$wdate] = $row1['cnt'];	
		$cnt++;
		}


	$home_active = 'active';

include_once("./head.php");
?>


<div data-role="page" id="photo_hold">
  <div data-role="header">
      <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a>
   <h1><a href="./" class='menu'>CHOIJAEHOON PLANNERS</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>


<? 
include_once("./navbar.php");
?>
<div data-role="main" class="ui-content">
    <h2>잔여타임 홀딩</h2>


	<input type="hidden" id="toYear" value="<?=$s_year?>">
	<input type="hidden" id="toMonth" value="<?=$s_month;?>">
	 <input type="hidden"  id="request_date" >
	<input type="hidden" id="co_id" name="co_id" value="<?=$member[mb_3];?>">
	<input type="hidden" id="black_company" name="black_company" value="<?=$row_co[cnt];?>">
	<input type="hidden"  id="ab_cnt" >

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
				<input data-theme="a" type="radio" name="radio-view-a" id="radio-view-a-a" value="list" onclick="location.href='./photo_hold.php?Year=thisYear&Month=thisMonth&br_id=<?=$br_id?>'" <?=$NOW_CHECKED?>/> 
				<label for="radio-view-a-a" data-form="ui-btn-up-a"><?=$d_month?>월 스케쥴</label> 
				<input data-theme="a" type="radio" name="radio-view-a" id="radio-view-b-a" value="grid"  onclick="location.href='./photo_hold.php?Year=nextYear&Month=nextMonth&br_id=<?=$br_id?>'" <?=$NEXT_CHECKED?>/> 
				<label for="radio-view-b-a" data-form="ui-btn-up-a"><?=$nMon?>월 스케쥴</label> 
			</fieldset> 
		</div>

	</td></tr>
	</table>

</div>


  <div class="ui-field-contain">
	 <table data-role="table" border=0 data-mode="" class="ui-responsive" id="myTable">

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


if($today >= $torrow  AND   $today < $twonine){

if($ARR_RHS_CNT[$today] > 0){
	echo "<br><font color=red>마감</font>";
	}else{
// 업체정보가 없으면	
	if($member[mb_3]==0 || $member[mb_3]==''){
	echo "<a href='#1' onclick=\"alert('업체정보가 없을 시 스케쥴 예약이 불가능합니다. 본사에 문의바랍니다.')\">선택</a>";
	}else{
	//echo $ARR_RHS_COUNT[$today]."<br>";
	echo "<br><a href='#1' onclick=\"checkDate($ff)\"><img src='./img/check.png' width='30px' height='30px'></a>";
	}
 }
}



	if($today==$real_today)echo"<br><font color=red>오늘</font>";
	echo "";
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
    <label for="to_date">촬영일선택:</label>
      <input type="text" class="form-control" id="to_date" style="font-weight:bold;" placeholder="촬영일">
    </div>

  <div class="ui-field-contain">
    <label for="sche_time">촬영시간선택:</label>
	<select class="form-control" id="sche_time" style="font-weight:bold;" onChange="getPromoPrice()";>
	<option value=''>촬영시간선택</option>
	</select>
    </div>


  <div class="ui-field-contain">
    <label for="photo_price">촬영가:</label>
      <input type="text" class="form-control" id="photo_price" style="font-weight:bold;" placeholder="촬영가">
    </div>

  <div class="ui-field-contain">
    <label for="photo_price">신부명:</label>
          <input type="text" class="form-control" id="cm_wname" style="font-weight:bold;" placeholder="신부명">
    </div>



  <button class="ui-btn ui-btn-b ui-corner-all"  onclick="scheduleSubmit()" id="btn_submit" >스케쥴 홀딩</button>	



  </div><!-- data-role="main" -->



<script>

function checkDate(id){

	var br_id = $("#br_id").val();

	if(br_id==''){
		alert('브랜드를 선택하세요');
		return false;
	}

	var toMon = $("#toMonth").val();
	var toYear = $("#toYear").val();
	var day = fillzero(id, 2);	
	$("#to_date").val(toYear+'-'+toMon+'-'+day);
	$("#request_date").val(toMon+'월'+day+'일');


	var photo_date = $("#to_date").val();
//	var br_id = $("#br_id").val();


	 if(br_id =='13060001' || br_id =='13060002'){

	  url = './ajax_get_schedule.php?br_id='+br_id+'&photo_date='+photo_date;

	 }else if(br_id =='13102311'){

	  url = './ajax_get_schedule_de.php?br_id='+br_id;

	 }else if(br_id =='15073024'){

	  url = './ajax_get_schedule_choi.php?br_id='+br_id;

	 }


  $.ajax
      ({
         type: "POST",
         url: url,
         data: "photo_date="+photo_date,
         success: function(option)
         {
           $("#sche_time").html(option);
		  
		 }

      });
  

		  return false;



}



//------------------------------------------------------------------> 카테고리2로딩
function getPromoPrice() {

 var br_id= $("#br_id").val();
 var co_id = $("#co_id").val();
 var to_date = $("#to_date").val();
 var black_company = $("#black_company").val();
 

url = './ajax_promo_price.php?br_id=' + br_id + '&toDate='+to_date;
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


			if(black_company > 0){  // 디자인웨딩(구OK웨딩) , 와이즈웨딩
			alert('소속하신 업체는 잔여타임 홀딩이 불가합니다.');
			return false;
			}

				$('#photo_price').val(cell.promo_price);

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

	var co_id = $("#co_id").val();
	var black_company = $("#black_company").val();
	var to_date = $("#to_date").val();
	var br_id = $("#br_id").val();
	var br_name = $("#br_id option:selected").text();

	var sche_time = $("#sche_time").val();
	var photo_price = $("#photo_price").val();
	var request_date = $("#request_date").val();

	var cm_wname = $("#cm_wname").val();

	if(!br_id){
	alert('브랜드를 선택하세요');
	return false;
	}

	if(!to_date){
	alert('촬영일을 선택하세요');
	return false;
	}

	if(!sche_time){
	alert('촬영 시간을 선택하세요');
	return false;
	}


	if(!cm_wname){
	alert('신부명을 입력하세요');
	return false;
	}

			if(black_company > 0){  // 디자인웨딩(구OK웨딩) , 와이즈웨딩
			alert('소속하신 업체는 잔여타임 홀딩이 불가합니다.');
			return false;
			}


	var rows= {

		to_date : to_date,
		br_id : br_id,
		co_id : co_id,
		sche_time : sche_time,
		photo_price : photo_price,
        cm_wname : cm_wname,

	};
	
	var postData = $.param(rows);
//	var postData = $('.inputForm :input').serialize() + '&oper=edit&id=<?=$id?>';
	var url = './ajax_schedule_request_server.php'//url 수정;


	var msg =  request_date+' '+br_name +'스튜디오 '+sche_time+'시 스케쥴 홀딩 하시겠습니까?';

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
				var msgs2 = response.msg2;
				
				alert(msgs1+'\n'+msgs2);
			
				window.location.reload();

			}
		});
	}

	return;

}





function fillzero(obj, len) {
  obj= '000000000000000'+obj;
  return obj.substring(obj.length-len);
} 

</script>



<? 
include_once("./foot.php");
?>
