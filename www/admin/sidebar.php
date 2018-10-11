<?
	// $get == "parm8"?"1":"2";
	if($_GET['part']=='mem')$mem='active';else $mem='';
	if($_GET['part']=='company')$company='active';else $company='';
	if($_GET['part']=='manager')$manager='active';else $manager='';
	if($_GET['part']=='bbs')$bbs='active';else $bbs='';
	if($_GET['part']=='code')$code='active';else $code='';
	if($_GET['part']=='account')$account='active';else $account='';
	if($_GET['part']=='info')$info='active';else $info='';
	if($_GET['part']=='data')$data='active';else $data='';
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
		
	$sql_m = "select count(*)as cnt from psj_board where bo_table='$data[me_code]' and wr_datetime >= '".date("Y-m-d H:i:s", G5_SERVER_TIME - (48 * 3600))."'";
	$resurt_m = sql_query($sql_m);
	 $data_m = sql_fetch_array($resurt_m);
		# 새로운글 아이콘
		if ($data_m[cnt] >0)
	          $menu_icon_new = '<img src=http://g5.master36.com/skin/board/test/img/icon_new.gif alt=새글>';
		else
		     $menu_icon_new  = '';


		// 이슈로그 뉴아이콘
	if($data[me_code]=='issu'){
		$sql_i = "select count(*)as cnt from psj_issu_log where regdate >= '".date("Y-m-d H:i:s", G5_SERVER_TIME - (48 * 3600))."'";
		$resurt_i = sql_query($sql_i);
		 $data_i = sql_fetch_array($resurt_i);
			# 새로운글 아이콘
			if (0 < $data_i[cnt] && $data[me_code]=='issu')
			$issu_icon_new = '<img src=http://g5.master36.com/skin/board/test/img/icon_new.gif alt=새글>';
			else
			     $issu_icon_new  = '';
	}


		$me_subject = $data['me_subject'];
		$me_code = $data['me_code'];
		$me_skin = $data['me_skin'];

		if($me_code=='info'){
		$filename = 'board';
		}else{
		$filename = $me_code;
		}

?>
	<a href="./<?=$filename?>_list.php?part=<?=$me_code?>&bo_table=<?=$me_code?>" class="list-group-item <?if($me_code==$part){echo "active";}?>"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span> <?=$me_subject?><?=$menu_icon_new?><? if($data[me_code]=='issu'){ echo $issu_icon_new;} ?> <!-- <span class="badge">14</span> --></a>
<?
	}
?>
<?

	$sql_m = "select count(*)as cnt from psj_board where bo_table='bugreport' and wr_datetime >= '".date("Y-m-d H:i:s", G5_SERVER_TIME - (48 * 3600))."'";
	$resurt_m = sql_query($sql_m);
    $data_m = sql_fetch_array($resurt_m);
		# 새로운글 아이콘
		if ($data_m[cnt] >0)
	          $menu_icon_new = '<img src=http://g5.master36.com/skin/board/test/img/icon_new.gif alt=새글>';
		else
		     $menu_icon_new  = '';
?>

	<a href="./board_list.php?part=bugreport&bo_table=bugreport" class="list-group-item <?if($_GET['part']=='bugreport'){echo "active";}?>"><span class="glyphicon glyphicon-<?=$me_skin?>" aria-hidden="true"></span> 버그&제안<?=$menu_icon_new?></a>

	</div>
        </div>