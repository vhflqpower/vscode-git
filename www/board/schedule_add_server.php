<?
include_once("../common.php");



if($_POST[mode]=='add'){




		if($mb_id && $wr_id && $bo_table){


			$wr_id = $_POST[wr_id];
			$today = date("Ymd");

			$view_at_date = substr($at_date,0,4).'.'.substr($at_date,4,2).'.'.substr($at_date,6,2);


			$row2 = sql_fetch("select wr_1 from psj_board_schedule where wr_id = '$wr_id'");


			if($row2[wr_1] > $today)
					alert("아직 수업이 진행 되지 않았습니다.");


			$query = sql_query("select * from `psj_schedule_add` where board_id ='$bo_table' and mb_id ='$mb_id' and  board_seq = '$wr_id'");
			$row  = sql_fetch_array($query);

			if($row){
				$msg = "이미 출석등록하였습니다.";
				if ($cwin) // 코멘트 보기
					alert_close($msg);
				else
					alert($msg);
			}

			if($row2[wr_1] < $today)
					alert("수업 일정이 지났습니다.");


		 $query ="INSERT INTO `psj_schedule_add` SET
					board_id = '$bo_table',
					board_seq = '$wr_id',
					mb_id = '$mb_id',
					late_yn='N',
					at_date ='".$at_date."',
					mb_name = '$mb_name',
					regdate = NOW()";
			$result = sql_query($query);

			$idx = sql_insert_id();


		$url = "http://mta.master36.com/board/view.php?bo_table=schedule&wr_id=$wr_id";

		// 출석체크 시 3000점
		 $query2 ="INSERT INTO psj_mileage SET
					mb_id = '$mb_id',
					mi_point = '3000',
					menu_cd = 'schedule_add',
					menu_id = '$idx',
					mi_memo ='{$view_at_date} 출석체크 3000 점',
					url = '$url',
					mi_date = '".date('Ymd')."',
					mi_regdate = NOW()";

			$result = sql_query($query2);


		// 출석체크 시 3000점
		 $query3 ="UPDATE  psj_member SET mb_point = mb_point + 3000 where   mb_id = '$mb_id'";
			$result3 = sql_query($query3);



		}else{

		$msg = "넘어 온 값이 없습니다.";
				if ($cwin) // 코멘트 보기
					alert_close($msg);
				else
					alert($msg);

		}


}else if($mode=='edit' && $idx){



		// 지각 처리
		 $query ="UPDATE `psj_schedule_add` SET
				late_yn='Y'
				WHERE 	idx = '$idx'";

			$result = sql_query($query);


		 $query1 ="UPDATE psj_mileage SET

					mi_point = '1000',
					mi_memo ='출석체크 1000(지각 2000감점) 점'
				WHERE mb_id = '$mb_id' and	menu_cd = 'schedule_add' AND menu_id = '$idx'";
			$result1 = sql_query($query1);



		// 지각 처리 시 -2000점
		 $query3 ="UPDATE  psj_member SET mb_point = mb_point - 2000 where  mb_id = '$mb_id'";
			$result = sql_query($query3);






		$responce['msg']='ok';

		 echo json_encode($responce);




}









    goto_url("./view.php?bo_table=$bo_table&wr_id=$wr_id");


?>