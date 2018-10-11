<?

	// $get == "parm8"?"1":"2";
	if($_GET['part']=='member')$member='active';else $member='';
	if($_GET['part']=='company')$company='active';else $company='';
	if($_GET['part']=='manager')$manager='active';else $manager='';
	if($_GET['part']=='bbs')$bbs='active';else $bbs='';
	if($_GET['part']=='code')$code='active';else $code='';
	if($_GET['part']=='account')$account='active';else $account='';
	if($_GET['part']=='info')$info='active';else $info='';
	if($_GET['part']=='dataroom')$dataroom='active';else $dataroom='';
	if($_GET['part']=='project')$project='active';else $project='';
	if($_GET['part']=='issu')$issu='active';else $issu='';
	if($_GET['part']=='menus')$menus='active';else $menus='';
	if(!$_GET['part'])$main='active';else $main='';

?>

       <div class="row">
	<div class="sidebar">        
          <div class="list-group">
            <a href="./main.php" class="list-group-item <?=$main?>"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> 메인페이지</a>
            <a href="./issu_list.php?part=issu" class="list-group-item <?=$issu?>"> <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> 이슈트래킹</a>
            <a href="./member_list.php?part=member" class="list-group-item <?=$member?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> 회원목록</a>
<?
	if(get_member_access($menu="company",$part='R',$_SESSION['ss_mb_id'],$mode=2) > 0){

?>
            <!-- <a href="./company_list.php?part=company" class="list-group-item <?=$company?>">고객&제휴사</a> -->
<? } ?>




	  <a href="./company_list.php?part=company" class="list-group-item <?=$company?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 고객&제휴사</a>
            <a href="./account_list.php?part=account" class="list-group-item <?=$account?>"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 계정목록</a>
            <a href="./manager_list.php?part=manager" class="list-group-item <?=$manager?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> 업체담당목록</a>
            <a href="./project_list.php?part=project" class="list-group-item <?=$project?>"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 프로젝트 </a>
            <a href="./dataroom_list.php?part=dataroom" class="list-group-item <?=$dataroom?>"> <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> 자료실</a>
            <a href="./board_list.php?part=info" class="list-group-item <?=$info?>"> <span class="glyphicon glyphicon-book" aria-hidden="true"></span> 정보관리</a>
            <a href="./bbs_list.php?part=bbs" class="list-group-item <?=$bbs?>"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> 게시판관리</a>
            <a href="./code_main.php?part=code" class="list-group-item <?=$code?>"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 코드관리</a>
            <a href="./menu_list.php?part=menus" class="list-group-item <?=$menus?>"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 메뉴관리</a>
	</div>
        </div>