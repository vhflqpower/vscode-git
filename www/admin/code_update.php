<?
   header("Content-type: text/xml;charset=utf-8");
   header("Cache-Control: no-cache, must-revalidate");
   header("Pragma: no-cache");
	//DB
	include_once("./_common.php");

	$oper = $_POST['oper'];
	$idx = $_POST['idx'];
	$code = $_POST['code'];
	$pcode = $_POST['pcode'];
	$part = $_POST['part'];
	$codename = $_POST['codename'];


// 코드분류

// 입력

   if($oper=='add' && !$idx){


   $sql = "select code from psj_code 
			WHERE pcode = '' && part = '1' order by  code desc limit 1";
	$rel = sql_query($sql);
	$row = sql_fetch_array($rel);

	if(!$row['code']){
		$code = '100000';
	}else{
		$code = $row['code'] + '100000';
	}


   $query = "INSERT INTO psj_code SET
						code = '$code',
						codename = '$codename',
						pcode= '',
						part = '1'";

    $result = sql_query( $query ) or die("Couldn t execute query.".sql_error());

			echo "<script>alert('등록 되었습니다.');</script>";
			echo "<script>location.href='./code_list.php?part=code';</script>";

   }




// 수정

   if($oper=='edit'){

   $sql = "UPDATE psj_code SET

					idx = '$idx',
					code = '$code',
					codename = '$codename',
					pcode = '$pcode',
					part = '$part'
			
			WHERE idx='$idx'";

    $result = sql_query( $sql ) or die("Couldn t execute query.".sql_error());

			echo "<script>alert('수정 되었습니다.');</script>";
			echo "<script>location.href='./code_list.php?part=code';</script>";

   }




//코드삭제



   if($oper=='del'){

			$count_sql = "select count(*) AS cnt from psj_code where pcode = '$code' AND part = '2'";
			$count_result = sql_query( $count_sql ) or die("Couldn t execute query.".sql_error());
			$count_row = sql_fetch_array($count_result);


	   if($count_row['cnt'] > 0 ){

			echo "<script>alert('하위 항목이 있으면 삭제 할 수 없습니다.');</script>";
			echo "<script>location.href='./code_list.php?part=code';</script>";

	   }else{

		   $sql = "DELETE FROM psj_code WHERE idx = $idx";	
		   $result = sql_query( $sql ) or die("Couldn t execute query.".sql_error());

		   echo "<script>alert('삭제 되었습니다.');</script>";
		   echo "<script>location.href='./code_list.php?part=code';</script>";
	   }
   }





	//echo json_encode($responce);
	//goto_url("./code_list.php?part=code");
	

?>