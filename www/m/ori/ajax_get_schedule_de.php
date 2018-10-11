<?php
include_once("./_common.php");


$br_id =  $_GET['br_id'];
$photo_date =  $_POST['photo_date'];

//if(isset($_POST['cat_level']) && $_POST['cat_level'] != ''){


	echo "<option value=''>--선택하세요--</option>";

  $query5 = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '15' AND rhs_takepic_hour <= '17'";
  $res5 = mysql_query($query5);
   $row5 = mysql_fetch_array($res5);
   $cnt5 =  $row5[cnt];


  $query7 = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '17' AND rhs_takepic_hour <= '19'";
  $res7 = mysql_query($query7);
   $row7 = mysql_fetch_array($res7);
   $cnt7 =  $row7[cnt];

  $query3 = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '13' AND rhs_takepic_hour <= '15'";
  $res3 = mysql_query($query3);
   $row3 = mysql_fetch_array($res3);
   $cnt3 =  $row3[cnt];

  $query9 = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '19' AND rhs_takepic_hour <= '20'";
  $res9 = mysql_query($query9);
   $row9 = mysql_fetch_array($res9);
   $cnt9 =  $row9[cnt];

  $query2 = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '11' AND rhs_takepic_hour <= '13'";
  $res2 = mysql_query($query2);
   $row2 = mysql_fetch_array($res2);
   $cnt2 =  $row2[cnt];

  $query = "select count(*) as cnt from cc_photo where br_id = '$br_id' and rhs_takepic_date='$photo_date' and st_contract_status IN('1','2','5') AND rhs_takepic_hour >= '09' AND rhs_takepic_hour <= '11'";
  $res = mysql_query($query);
   $row = mysql_fetch_array($res);
   $cnt =  $row[cnt];



if($cnt5 == 0 && $cnt7 == 0 && $cnt3 == 0){

echo"<option value='13:00'>13:00</option>";
echo"<option value='15:00'>15:00</option>";
echo"<option value='17:00'>17:00</option>";


}else if($cnt7 == 0 && $cnt3 == 0 && $cnt9 == 0){


echo"<option value='13:00'>13:00</option>";
echo"<option value='17:00'>17:00</option>";
echo"<option value='19:00'>19:00</option>";


}else if($cnt3 == 0 && $cnt9 == 0 && $cnt2 == 0){

echo"<option value='11:00'>11:00</option>";
echo"<option value='13:00'>13:00</option>";
echo"<option value='19:00'>19:00</option>";


}else if($cnt9 == 0 && $cnt2 == 0 && $cnt == 0){



echo"<option value='09:00'>09:00</option>";
echo"<option value='11:00'>11:00</option>";
echo"<option value='19:00'>19:00</option>";


}else if($cnt5 == 0 && $cnt3 == 0 && $cnt9 == 0){

echo"<option value='13:00'>13:00</option>";
echo"<option value='15:00'>15:00</option>";
echo"<option value='19:00'>19:00</option>";

}else if($cnt5 == 0 && $cnt9 == 0 && $cnt2 == 0){

echo "<option value='11:00'>11:00</option>";
echo "<option value='15:00'>15:00</option>";
echo "<option value='19:00'>19:00</option>";


}else if($cnt5 == 0 && $cnt2 == 0 && $cnt == 0){

echo "<option value='09:00'>09:00</option>";
echo "<option value='11:00'>11:00</option>";
echo"<option value='15:00'>15:00</option>";

}else if($cnt7 == 0 && $cnt9 == 0 && $cnt2 == 0){

echo "<option value='11:00'>11:00</option>";
echo "<option value='17:00'>17:00</option>";
echo "<option value='19:00'>19:00</option>";


}else if($cnt7 == 0 && $cnt2 == 0 && $cnt == 0){

echo "<option value='09:00'>09:00</option>";
echo "<option value='11:00'>11:00</option>";
echo "<option value='17:00'>17:00</option>";


}else if($cnt3 == 0 && $cnt2 == 0 && $cnt == 0){

echo "<option value='09:00'>09:00</option>";
echo "<option value='11:00'>11:00</option>";
echo "<option value='13:00'>13:00</option>";


}else if($cnt5 == 0 && $cnt7== 0){   


echo "<option value='15:00'>15:00</option>"; 
echo "<option value='17:00'>17:00</option>";


}else if($cnt5 == 0 && $cnt3== 0){     
	
echo "<option value='13:00'>13:00</option>";
echo "<option value='15:00'>15:00</option>"; 


}else if($cnt5 == 0 && $cnt9== 0){ 


echo "<option value='15:00'>15:00</option>"; 
echo "<option value='19:00'>19:00</option>";


}else if($cnt5 == 0 && $cnt2== 0){  
	

echo "<option value='11:00'>11:00</option>";
echo "<option value='15:00'>15:00</option>"; 


}else if($cnt5 == 0 && $cnt== 0){   
	
echo "<option value='09:00'>09:00</option>";
echo "<option value='15:00'>15:00</option>"; 



}else if($cnt7 == 0 && $cnt3== 0){


echo "<option value='13:00'>13:00</option>";
echo "<option value='17:00'>17:00</option>";


}else if($cnt7 == 0 && $cnt9== 0){


echo "<option value='17:00'>17:00</option>";
echo "<option value='19:00'>19:00</option>";

}else if($cnt7 == 0 && $cnt2== 0){ 

echo "<option value='11:00'>11:00</option>";
echo "<option value='17:00'>17:00</option>";


}else if($cnt7 == 0 && $cnt== 0){ 

echo "<option value='09:00'>09:00</option>";
echo "<option value='17:00'>17:00</option>";


}else if($cnt3 == 0 && $cnt9== 0){


 echo "<option value='13:00'>13:00</option>"; 
 echo "<option value='19:00'>19:00</option>";

}else if($cnt9 == 0 && $cnt2== 0){

echo "<option value='11:00'>11:00</option>";
echo "<option value='19:00'>19:00</option>";


}else if($cnt2 == 0 && $cnt== 0){

echo "<option value='09:00'>09:00</option>";
echo "<option value='11:00'>11:00</option>";


}else if($cnt5 == 0 && $cnt3== 0){

echo "<option value='13:00'>13:00</option>";
echo "<option value='15:00'>15:00</option>";


}else if($cnt5 == 0 && $cnt9== 0){

echo "<option value='15:00'>15:00</option>";
echo "<option value='19:00'>19:00</option>";

}else if($cnt5 == 0 && $cnt2== 0){

echo "<option value='11:00'>11:00</option>";
echo "<option value='15:00'>15:00</option>";


}else if($cnt5 == 0 && $cnt== 0){

echo "<option value='09:00'>09:00</option>";
echo "<option value='15:00'>15:00</option>";


}else if($cnt5== 0){

echo "<option value='15:00'>15:00</option>";

}else if($cnt7== 0){

echo "<option value='17:00'>17:00</option>";

}else if($cnt3== 0){

echo "<option value='13:00'>13:00</option>";

}else if($cnt9== 0){

echo "<option value='19:00'>19:00</option>";

}else if($cnt2== 0){


 echo "<option value='11:00'>11:00</option>"; 

}else if($cnt== 0){

 echo "<option value='09:00'>09:00</option>"; 

}





?>
