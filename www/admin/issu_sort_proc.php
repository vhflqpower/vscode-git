
<?php 
include_once("../common.php");

$position = $_POST['position'];
$i=1;
foreach($position as $k=>$v){

    $data = array(
        "position_order"=>$i
    );
   
	$query ="update psj_issu set
		is_sort = '$i'
		where is_id='".$v."'";
		sql_query($query);
	// echo $query."<br>";
    
    $i++;
}

?>