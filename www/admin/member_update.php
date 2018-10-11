<?
include_once("_common.php");

	if($oper=='add'){





	$mb_intercept_date = str_replace("/","",$_POST['mb_intercept_date']);


   
	$mb_password =  get_encrypt_string($mb_password);

	$query ="insert into psj_member set
			
			mb_id = '$mb_id',
			mb_password = '$mb_password',
			mb_email = '$mb_email',
			mb_name = '$mb_name',
			mb_birth = '$mb_birth',
			mb_memo = '$mb_memo',
			mb_level = '$mb_level',
			mb_status = '2',
			mb_intercept_date ='$mb_intercept_date',
			mb_memo = '$mb_memo'
			";
		sql_query($query);




	}else if($oper=='edit'){

	

	//print_r($_POST);exit;


	$mb_intercept_date = str_replace("/","",$_POST['mb_intercept_date']);

	
    $sql_password = "";
    if ($mb_password)
        $sql_password = " , mb_password = '".get_encrypt_string($mb_password)."' ";



	$query ="update psj_member set
			mb_name = '$mb_name',
			mb_level = '$mb_level',
			mb_intercept_date ='$mb_intercept_date',
			mb_memo = '$mb_memo'
			$sql_password

			where mb_no = '$mb_no'";
	
		sql_query($query);


	}else if($oper=='del'){


	$query ="delete from psj_member

			where mb_no = '$mb_no'";
	
		sql_query($query);


		goto_url("./member_list.php?part=mem");
	}

	if($oper=='check_del'){

		$checkArray  = $_POST['checkArray'];

			for($i=0; $i<count($checkArray);$i++){
				$id = $checkArray[$i];

				if($id){
				$query="delete from psj_member where mb_no='$id'";
				sql_query($query);

			}

		}
	$responce['flag'] = 'succ';
	$responce['message'] = '¼º°ø';
	echo json_encode($responce);
	}



		goto_url("./member_view.php?mb_no=$mb_no&part=mem");








?>