<?
@include_once("../common.php");



class MEMBER{

      public $sql, $res, $row,$ARR_ROW,$limit,$val,$msg;  //public으로 변수 선언
 

function select_member($limit){

	$sql = "select * from psj_member where 1=1 limit $limit";
	$res = sql_query($sql);
	while($row = sql_fetch_array($res)){
		$ARR_ROW[] = $row;
	}
	return $ARR_ROW;

}



function update_member($val,$id){


	$sql = "update  psj_member set mb_name='$val' where mb_id='$id'";
	$res = sql_query($sql);


	if(!$res){
		 $msg="UPDATE FAILD";
	}else{
		 $msg="UPDATE SUCESS";
	}

	return $msg;
}





}
?>
