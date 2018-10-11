<?
	// $get == "parm8"?"1":"2";

?>
     <div class="row">
		<div class="sidebar">        
			  <div class="list-group">
				<a href="./mypage.php" class="list-group-item " id="mypage"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span>마이페이지</a>
				<a href="./board_list.php?part=bugreport&bo_table=bugreport" class="list-group-item "><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>나의 이슈내역<?=$menu_icon_new?></a>
				<a href="./my_board.php?part=info&bo_table=info" class="list-group-item "  id="my_info"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>나의 정보 / 제안<?=$menu_icon_new?></a>
				<a href="./my_calendar.php" class="list-group-item" id="my_calendar"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>일정보기<?=$menu_icon_new?></a>
				<a href="./my_memo.php" class="list-group-item" id="my_memo"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>메모장 / 파일<?=$menu_icon_new?></a>
				<a href="./my_plan.php" class="list-group-item" id="my_plan"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>마이플랜<?=$menu_icon_new?></a>
				<a href="./my_makery_plan.php" class="list-group-item" id="my_maker_plan"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>메이커플랜<?=$menu_icon_new?></a>
		</div>
        </div>