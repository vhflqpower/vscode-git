<? 
include_once("./_common.php");


if($member[mb_id]){
	$data = sql_fetch("select sum(pp_point) as p_plus  from  cc_planer_point where mb_id ='$member[mb_id]' and pp_type = 1");
	$data2 = sql_fetch("select sum(pp_point) as p_minus  from  cc_planer_point where mb_id ='$member[mb_id]' and pp_type = 2");

	$sum_total =  $data['p_plus'] - $data2['p_minus'];
}



	$home_active = 'active';


include_once("./head.php");
?>

<div data-role="page" id="my_mileage2">
  <div data-role="header">
      <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a>
   <h1><a href="./" class='menu'>HAMSABU GYM</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>

<? 
include_once("./navbar.php");
?>


<div data-role="main" class="ui-content">
    <h2>MEMBER MILEAGE</h2>

<font color="orange">100,000 마일리지부터 사용이 가능합니다.</font>

Total:<font color:red><?=number_format($sum_total)?></font>
<table data-role="table" class="ui-responsive table-stroke">
	<thead>
	  <tr>
		<th>DATE</th>
		<th>구분</th>
		<th>마일리지</th>
		<th>MEMO</th>
	  </tr>
	</thead>
	<tbody>
<?php
	$num = 1;
    $sql = " select * from cc_planer_point where 1=1 and mb_id ='$member[mb_id]' order by pp_no desc";
	$result = sql_query($sql);
	while ($row = sql_fetch_array($result)){
	if($row[pp_type]=='1'){
		$ptype = '<font color=blue>부여</font>';
	}else{
		$ptype = '<font color=red>차감</font>';
	}

?>
	<tr>
	<td><?=$row['pp_date']?></td>
	<td><?=$ptype?></td>
	<td><?=number_format($row['pp_point']);?></td> 
	<td><?=$row['pp_etc'];?></td> 
	</tr>
<? } ?>

	</tbody>
</table>
<input type="hidden" id="mileage_total" value="<?=$sum_total?>">
  <!-- <button type="button" class="btn btn-sm btn-default" id="btn_cancle" onclick="location.href='../../'">로그인하기</button>
 -->

<p style="text-align:center;">
 <button type="submit" class="ui-btn ui-btn ui-corner-all"  id="btn_submit" onclick="useMileageSubmit(1)">선불카드 10만원권 교환</button>
  <button type="submit" class="ui-btn ui-btn ui-corner-all"  id="btn_submit" onclick="useMileageSubmit(2)">결제금액 차감 100,000 마일리지</button>
</p>



</div>
</form>


<script type="text/javascript">


function useMileageSubmit(id){

	var mileage_total = $("#mileage_total").val();
	if(mileage_total < 100000){
	alert('사용 가능한 마일리지가 아닙니다.');
	return false;
	}

	var rows= {

		type : id,

	};
	
	var postData = $.param(rows);

	var url = './ajax_use_mileage_server.php'//url 수정;


	if(id==1){
		var msg =  '마일리지를 선불카드 10만원권으로 교환 신청 하시겠습니까?';
	}else{
		var msg =  '마일리지를 결제금액 차감 신청 하시겠습니까?';
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

				
				alert(msgs1);
		
				window.location.reload();

			}
		});
	}

	return;

}

</script>


<? 
include_once("./foot.php");
?>
