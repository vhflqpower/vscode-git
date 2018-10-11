<?
include_once("_common.php");



 			$mode = $_POST['mode'];

 			$ab_id = $_POST['ab_id'];
 			$class_id = $_POST['cs_id'];
			$mb_cd = $_POST['mb_cd'];
			$pm_id = $_POST['pm_id'];
			$ab_date = $_POST['ab_date'];
			$today = date("Y-m-d");





if($mode=='I' && $ab_date){


			$query  = "insert into cf_absent set 			
					  class_id = '$cs_id',
					  pm_id ='$pm_id',
					  mb_cd = '$mb_cd',
					  ab_status ='1', 
					  add_type ='s', 
					  ab_date ='$ab_date', 
					  ab_regdate = Now()";
			$result = mysql_query($query);	


}else if($mode=='D' && $ab_id){

			$query  = "delete from cf_absent where  ab_id = '$ab_id'";
			$result = mysql_query($query);	



}



        $responce['flag'] = 'succ';
	    $responce['message'] = '정상적으로 이루어졌습니다.';

			//echo "<script>alert('출석을 정상 등록하였습니다.');</script>";
			

	echo json_encode($responce); 
	







?>
