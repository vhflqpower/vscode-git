
<?php 
include_once("../common.php");

$position = $_POST['position'];
/*
if($_GET['item']){

	foreach ($_GET['item'] as $position => $item) :
		$position = $position + 1;
	  $query = "UPDATE  psj_plan  SET pn_no = '$position' WHERE pn_id = '$item'";

	//  echo $query;
	  echo "\n";
	  $result = sql_query($query);
		
	  endforeach;


	echo '<center id="successmsg" style="font-size:14px;">순서변경성공</center>';
	//make the success message disappear slowly
	echo '<script>$(document).ready(function(){ $("#successmsg").fadeOut(1000); });</script>';
}
*/

$i=1;
foreach($position as $k=>$v){

    $data = array(
        "position_order"=>$i
    );
   
	$query ="update psj_plan set
		pn_no = '$i'
		where pn_id='".$v."'";
		sql_query($query);
	
//	 echo $query."<br>";
    
    $i++;
}

?>