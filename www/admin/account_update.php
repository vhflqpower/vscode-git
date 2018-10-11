<?
include_once("_common.php");







	if($oper=='add'){

	$query ="insert into psj_account set
			
			wr_subject = '$wr_subject',
			wr_content = '$wr_content',
			co_id  = '$search_company',
			wr_sort = '$wr_sort',
			wr_datetime = Now()
			";
		sql_query($query);

	 $wr_id = sql_insert_id();


	}else if($oper=='edit'){


	$query ="update psj_account set
			wr_subject = '$wr_subject',
			wr_content = '$wr_content',
			co_id  = '$search_company',
			wr_sort = '$wr_sort'
			
			where wr_id = '$wr_id'";
		sql_query($query);




	}else if($oper=='del'){


	$query ="delete from psj_account

			where bo_table = '$bo_table'";
	
		sql_query($query);


		goto_url("./account_list.php&part=account");
	}

	if($oper=='check_del'){

		$checkArray  = $_POST['checkArray'];

			for($i=0; $i<count($checkArray);$i++){
				$id = $checkArray[$i];

				if($id){
				$query="delete from psj_account where wr_id='$id'";
				sql_query($query);

			}

		}
	$responce['flag'] = 'succ';
	$responce['message'] = '¼º°ø';
	echo json_encode($responce);
	}






		goto_url("./account_view.php?wr_id=$wr_id&part=account");








?>