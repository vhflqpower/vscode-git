<?
include_once("../common.php");



$access = explode('_',$_POST['check_cnt']);

$mb_id = $member['mb_id'];

$abc = $_POST['menu_cd'];

$menu_check = explode('_','$abc');


print_r($menu_check);


exit;

for($i=0; $i<count($_POST['menu_cd']); $i++){

$sql ="select count(1) AS cnt from psj_menu_auth where menu_cd = '$menu_cd[0]' AND part = '$menu_cd[1]' AND mb_id = '$mb_id'";
$resurt =sql_query($sql);
$row = sql_fetch_array($resurt);
	if($row['cnt'] == '0'){
		//for($i=0; $i<count($_POST['menu_cd']); $i++){
			$menu_cd = explode("_",$_POST['menu_cd'][$i]);
			$query ="insert into psj_menu_auth set
					menu_cd = '$menu_cd[0]',
					part = '$menu_cd[1]',
					access = '$access[$i]',
					mb_id = '$mb_id'
					";
			echo $query.$i."<==============<br>";
			//sql_query($query);
		//}
	}else{
		//for($i=0; $i<count($_POST['menu_cd']); $i++){
			$menu_cd = explode("_",$_POST['menu_cd'][$i]);
			$query ="update psj_menu_auth set
					access = '$access[$i]'
					where menu_cd = '$menu_cd[0]' AND part = '$menu_cd[1]' AND mb_id = '$mb_id'
					";
			echo $query.$i."<==============<br>";
			//sql_query($query);
		//}
	}
}
?>