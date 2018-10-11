<?

	// $get == "parm8"?"1":"2";
	if($_GET['part']=='mem')$mem='active';else $mem='';
	if($_GET['part']=='company')$company='active';else $company='';

?>



       <div class="row">
	<div class="sidebar">        
          <div class="list-group">
            <a href="./main.php" class="list-group-item <?=$main?>"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span>기본설정</a>

	<a href="./memony_list.php?part=bugreport&bo_table=bugreport" class="list-group-item "><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>입출금<?=$menu_icon_new?></a>
	<a href="./board_list.php?part=bugreport&bo_table=bugreport" class="list-group-item "><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>회비내역<?=$menu_icon_new?></a>
	<a href="./attdentent_list.php?part=bugreport&bo_table=bugreport" class="list-group-item"  id="attdentent"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>출석체크<?=$menu_icon_new?></a>
	<a href="./login_list.php?part=bugreport&bo_table=bugreport" class="list-group-item"  id="login"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span>로그인내역<?=$menu_icon_new?></a>
	</div>
        </div>