<?
include_once("_common.php");




	$wr_subject = '';
	if (isset($_POST['wr_subject'])) {
		$wr_subject = substr(trim($_POST['wr_subject']),0,255);
		$wr_subject = preg_replace("#[\\\]+$#", "", $wr_subject);
	}
	if ($wr_subject == '') {
		$msg[] = '<strong>제목</strong>을 입력하세요.';
	}


	$wr_content = '';
	if (isset($_POST['wr_content'])) {
		$wr_content = substr(trim($_POST['wr_content']),0,65536);
		$wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
	}
	if ($wr_content == '') {
		$msg[] = '<strong>내용</strong>을 입력하세요.';
	}


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

	//print_r2($_POST);exit;

			for($i=0; $i<count($checkArray);$i++){
				$id = $checkArray[$i];


				if($id){

				$row =  sql_fetch_array(sql_query("select mb_id,mi_point from psj_mileage where mi_id = '$id'"));

				$query="delete from psj_mileage where mi_id='$id'";
				sql_query($query);

				$query2="update  psj_member set mb_point - '$row[mi_point]'  where mb_id='$row[mb_id]'";
				sql_query($query);
			}

		}
	$responce['flag'] = 'succ';
	$responce['message'] = '성공';
	echo json_encode($responce);
	}




		goto_url("./mileage_list.php?wr_id=$wr_id&part=account");








?>