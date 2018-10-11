<? 
include_once("./_common.php");


/*
	if($member[mb_id]){
			$data = sql_fetch("select * from g4_member where mb_id = '$member[mb_id]'");
	
	}else{
			alert('회원 정보가 없습니다.');
	}
*/

$time = time(); 
$maxDate = date("Y-m-d",strtotime("+29 day", $time));


	$home_active = 'active';


include_once("./head.php");
?>


	<script>
		$(function(){
			$( ".date-input-css" ).datepicker();
		})
	</script>

<div data-role="page" id="photo_regist">
  <div data-role="header">
      <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a>
   <h1><a href="./" class='menu'>HANSABU GYM</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>

<? 
include_once("./navbar.php");
?>


<div data-role="main" class="ui-content">
    <h2>촬영스케쥴 홀딩</h2>

<font color='orange'>금일 기준 30일 이후 스케쥴만 홀딩이 가능합니다.<br> 30일 이전 스케쥴은 잔여타임 프로모션 게시판 이용<br></font><br>

<font color="red"> 디마주는 10p 스몰웨딩 스케쥴 홀딩만 가능합니다.</font>
<div data-role="main" class="ui-content">
<form name="frm" method="post" action=""  onsubmit="return scheduleSubmit(this);" />
<input type="hidden"  name="mb_no" value="<?=$data['mb_no']?>" />
<input type="hidden"  id="check_schedule" value="N" />
<input type="hidden"  id="maxDate" value="<?=$maxDate?>" />

  <div class="ui-field-contain" data-ajax="false">
    <label for="br_id">브랜드:</label>
    <select id="br_id" name="br_id" data-ajax="false" onchange="choiceTime(this.value);">
  <option value=''>브랜드선택</option>
	<?
	$query = mysql_query("select br_id,br_name,br_code from cc_brand where br_id in('13060001','13060002','13102311','15073024')");
	   while($row = mysql_fetch_array($query)){		
	 ?>
	 <option value="<?=$row['br_id']?>" ><?=$row['br_name']?></option>
	<? } ?>
    </select>
  </div>



  <div class="ui-field-contain">
    <label for="date">촬영일선택:</label>
    <input type="date" name="photo_date" id="photo_date" value="">
  </div>


  <div class="ui-field-contain">
    <label for="rhs_hour">촬영시간:</label>
	<select   name="rhs_hour" id="rhs_hour"  onchange="checkDate();">
	<option value="">-시-</option>
	</select> 
	<input type="hidden" name="rhs_min" id="rhs_min" value="00">
    <!-- <label for="rhs_min">촬영시간:</label>
	<select  class="form-control" name="rhs_min" id="rhs_min" >
	<option value="00" <? if($data['rhs_takepic_min']=='00')echo"selected";?>>00분</option>
	</select> -->
    </div>




  <div class="ui-field-contain">
    <label for="name">추천타임:</label>
	<select class="form-control" id="sche_time" onchange="copy_time(this.value)";>
	<option value=''>-추천촬영타임-</option>
	</select> 
    </div>

    <div class="ui-field-contain">
    <label for="search">신부명</label>
    <input type="search" name="cm_wname" id="cm_wname" value="" placeholder="신부명">
  </div>


      <!-- <input type="button" data-inline="true" value="저장하기" onclick="scheduleSubmit()">
 -->
			<button class="ui-btn ui-btn-b ui-corner-all" onclick="scheduleSubmit()">저장하기</button>


</div>


</form>


</div>



<script>

function choiceTime(br_id) {


    if(br_id == '13060001' || br_id == '13060002' )  
     {

       $("#rhs_hour").html("<option value=>-시-</option><option value=09 >09시</option><option value=11 >11시</option><option value=12 >12시</option><option value=13 >13시</option><option value=14 >14시</option><option value=15 >15시</option><option value=16 >16시</option><option value=17 >17시</option><option value=18 >18시</option>");

     }
     else if(br_id == '13102311')
     {

       $("#rhs_hour").html("<option value=>-시-</option><option value=09 >09시</option><option value=11 >11시</option><option value=13 >13시</option><option value=15 >15시</option><option value=17 >17시</option><option value=19 >19시</option>");

	 }else if(br_id == '15073024'){

       $("#rhs_hour").html("<option value=>-시-</option><option value=10 >10시</option><option value=16 >16시</option>");

	 }
}



function getScheCnt() {

 var br_id= $("#br_id").val();

 var to_date = $("#photo_date").val();
 var rhs_hour = $("#rhs_hour").val();
 var br_id= $("#br_id").val();



/*
	if(!br_id){
	alert('브랜드를 선택하세요');
	return false;
	}

	if(!to_date){
	alert('촬영일을 입력하세요');
	return false;
	}

	if(!rhs_hour){
	alert('촬영시간을 선택하세요');
	return false;
	}
*/



url = './ajax_get_schedule_cnt.php?br_id=' + br_id + '&toDate='+to_date+'&rhour='+rhs_hour;
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
				
			

				if(cell.ms_title=='스튜디오촬영마감'){
							
				$('#check_msg').val('Y');
				
				}

				 if(cell.cnt > 0){	
							
					$('#check_schedule').val('Y');

					
				//	alert("예약 된  시간대가 있습니다. 다시 선택해 주세요");
				//	return;
				}


			}
			/*
			else {
				alert('fail to load data');
			}
			*/
		}
	});
}





function scheduleSubmit(f){


	//var f = document.frm;

	$('#check_msg').val('N');
	$('#check_schedule').val('N');

	var br_id = $("#br_id").val();

	var br_name = $("#br_id option:selected").text();
	var request_date = $("#photo_date").val();
	var cm_wname = $("#cm_wname").val();

	var rhs_hour = $("#rhs_hour").val();
	var rhs_min = $("#rhs_min").val();


	if(f.br_id.value==''){
	alert('브랜드를 선택하세요');
	return false;
	}


	if(!request_date){
	alert('촬영일을  선택하세요');
	return false;
	}

	if(!rhs_hour){
	alert('촬영시간을 선택하세요');
	return false;
	}

 var maxDate = $("#maxDate").val();
	if(request_date < maxDate){
	alert('금일 기준 29일 이후 스케쥴만 홀딩이 가능합니다');
	return false;
	}



	getScheCnt(); //

	var check_msg = $("#check_msg").val();
	if(check_msg=='Y'){
	alert('촬영 스케쥴이 없는 날입니다.. 다른 날짜와 시간을 선택하세요');
	return false;
	}



	var check_schedule = $("#check_schedule").val();
	if(check_schedule=='Y'){
	alert('이미 홀딩된 스케쥴 입니다. 다른 스케쥴을 선택해 주세요.');
	return false;
	}


	if(!f.cm_wname.value){
	alert('신부명을 입력하세요');
	return false;
	}


	var sche_time = rhs_hour +':'+ rhs_min;

/*

		to_date : to_date,
		sche_time : sche_time,
		photo_price : photo_price,
        cm_wname : cm_wname,

*/

	var rows= {

		br_id : br_id,
		request_date : request_date,
        sche_time : sche_time,
		cm_wname : cm_wname,
	};
	
	var postData = $.param(rows);
//	var postData = $('.inputForm :input').serialize() + '&oper=edit&id=<?=$id?>';
	var url = './ajax_photo_schedule_server.php'//url 수정;


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



function checkDate(id){

	var br_id = $("#br_id").val();

	if(br_id==''){
		alert('브랜드를 선택하세요');
		return false;
	}


	var photo_date = $("#photo_date").val();


 if(br_id =='13060001' || br_id =='13060002'){

  url = './ajax_get_schedule.php?br_id='+br_id;

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

/* 카테고리2 데이터 로딩 */

  function copy_time(time){
   
  	var arr_time = time.split(':');
  
 //	alert(arr_time[0]);

	$("#rhs_hour").val(arr_time[0]);
	   
  }




</script>



<? 
include_once("./foot.php");
?>
