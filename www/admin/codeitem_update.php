<?
   header("Content-type: text/xml;charset=utf-8");
   header("Cache-Control: no-cache, must-revalidate");
   header("Pragma: no-cache");
	//DB
	include_once("./_common.php");

	$oper = $_POST['oper2'];
	$idx = $_POST['idx2'];
	$code = $_POST['code2'];
	$pcode = $_POST['pcode2'];
	$part = $_POST['part2'];
	$codename = $_POST['codename2'];


//	print_r($_POST); exit;


// 항목분류

// 입력

   if($oper=='add' && !$idx){


   $sql = "select code from psj_code 
			WHERE pcode = '$pcode' && part = '2' order by  code desc limit 1";
	$rel = sql_query($sql);
	$row = sql_fetch_array($rel);

	if(!$row['code']){
		$code = '1000';
	}else{
		$code = $row['code'] + '1';
	}


   $query = "INSERT INTO psj_code SET
						code = '$code',
						codename = '$codename',
						pcode= '$pcode',
						part = '2'";

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

   $sql = "DELETE FROM psj_code WHERE idx = $idx";
   $result = sql_query( $sql ) or die("Couldn t execute query.".sql_error());

   
	
			echo "<script>alert('삭제 되었습니다.');</script>";
			echo "<script>location.href='./code_list.php?part=code';</script>";
   }





	//echo json_encode($responce);
	//goto_url("./code_list.php?part=code");
	

?>