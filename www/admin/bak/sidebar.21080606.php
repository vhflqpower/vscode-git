<?

	// $get == "parm8"?"1":"2";
	if($_GET['part']=='mem')$mem='active';else $mem='';
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
	if($_GET['part']=='info')$info='active';else $info='';
	if($_GET['part']=='bugreport')$bugreport='active';else $bugreport='';
	if(!$_GET['part'])$main='active';else $main='';

?>



       <div class="row">
	<div class="sidebar">        
          <div class="list-group">
            <a href="./main.php" class="list-group-item <?=$main?>"><span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span> 메인페이지</a>
            <!-- <a href="./issu_list.php?part=issu" class="list-group-item <?=$issu?>"> <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> 이슈트래킹</a>
            <a href="./member_list.php?part=mem" class="list-group-item <?=$mem?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> 회원목록</a> -->
<?
	//if(get_member_access($menu="company",$part='R',$_SESSION['ss_mb_id'],$mode=2) > 0){

?>
            <!-- <a href="./company_list.php?part=company" class="list-group-item <?=$company?>">고객&제휴사</a> -->
<? //} ?>

<?
	// AND me_list_level <= '$member[mb_level]'
	$sql = "select me_subject,me_code,me_skin from psj_menu_config where 1=1  AND me_list_level <= '$member[mb_level]'  order by me_sort desc";
	$resurt = sql_query($sql);
	while($data = sql_fetch_array($resurt)){
		
		$me_subject = $data['me_subject'];
		$me_code = $data['me_code'];
		$me_skin = $data['me_skin'];


		if($me_code=='info'){
		$board = 'board';
		}else{
		$board = $me_code;
		}


?>
	<a href="./<?=$board?>_list.php?part=<?=$me_code?>&bo_table=<?=$me_code?>" class="list-group-item <?if($me_code==$part){echo "active";}?>"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span> <?=$me_subject?> <!-- <span class="badge">14</span> --></a>


<?
	}
?>

	<a href="./board_list.php?part=bugreport&bo_table=bugreport" class="list-group-item <?if($_GET['part']=='bugreport'){echo "active";}?>"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span> 버그신고&제안하기</a>

	</div>
        </div>