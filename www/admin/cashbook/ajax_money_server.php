<?php
include_once("_common.php");



		$oper = $_POST['oper'];
		$ca_wdate = $_POST['wdate'];
		$ca_part = $_POST['part'];
		$ca_code1 = $_POST['code1'];
		$ca_money = $_POST['money'];
		$ca_memo = $_POST['memo'];


	//print_r($_POST);exit;

if($oper=='add'){


		for ($i=0; $i < count($ca_money); $i++) {
			
			if($ca_money[$i]){

			$seq = $i + 1;

			$c_memo = $ca_memo[$i];
			$c_price = $ca_money[$i];
			$c_part = $ca_part[$i];
			$c_ca_code1 = $ca_code1[$i];
			$c_ca_wdate = $ca_wdate[$i];


			$ca_id = time();

			$query  = "INSERT INTO co_cashbook SET 
			
			ca_id = '$ca_id',
			ca_part = '$c_part',
			ca_code1 = '$c_ca_code1',
			ca_money = '$c_price',
			ca_memo = '$c_memo',
			ca_wdate = '$c_ca_wdate',
			ca_regdate = Now()";
			$result = mysql_query($query);	

		
			//echo $query;exit;


			}

		}

}



if($oper=='edit'){

	if($id > 0){

			$query2  = "UPDATE co_cashbook SET 
			part = '$part',
			money = '$price',
			memo = '$memo',
			wdate = '$wdate'
			WHERE seq = '$id'";

			$result = mysql_query($query2);	

	}

}





if($oper=='del'){

	if($id > 0){

			$query2  = "DELETE FROM co_cashbook  WHERE seq = '$id'";

			$result = mysql_query($query2);	

	}

}




        $responce['flag'] = 'succ';
	    $responce['msg2'] = '수정성공';


	echo json_encode($responce);




?>
