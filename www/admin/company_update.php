<?
include_once("_common.php");




	if($oper=='add'){

	$query ="insert into psj_company set
			
			co_name = '$co_name',
			mb_name = '$mb_name',
			mb_birth = '$mb_birth',
			co_open_date = '$co_open_date',
			zip_code = '$sample6_postcode',
			co_address = '$sample6_address',
			co_address2 = '$sample6_address2',
			co_condition = '$co_condition',
			co_tel = '$co_tel',
			co_fax = '$co_fax',
			co_content = '$co_content'";

		sql_query($query);

	}


	if($oper=='edit'){


	$query ="update psj_company set
			co_name = '$co_name',
			mb_name = '$mb_name',
			mb_birth = '$mb_birth',
			co_open_date = '$co_open_date',
			zip_code = '$sample6_postcode',
			co_address = '$sample6_address',
			co_address2 = '$sample6_address2',
			co_condition = '$co_condition',
			co_tel = '$co_tel',
			co_fax = '$co_fax',
			co_content = '$co_content'	
			where co_id = '$co_id'";
		sql_query($query);


		//echo $query;

	}


	if($oper=='del'){


	$query ="delete from psj_company

			where co_id = '$co_id'";

		sql_query($query);

	}


	if($oper=='check_del'){

		$checkArray  = $_POST['checkArray'];

			for($i=0; $i<count($checkArray);$i++){
				$id = $checkArray[$i];

				if($id){
				$query="delete from psj_company where co_id='$id'";
				sql_query($query);

			}

		}

	}


	$responce['flag'] = 'succ';
	$responce['message'] = '성공';
	echo json_encode($responce);
	//	goto_url("./company_list.php?part=company");


?>