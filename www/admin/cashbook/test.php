<?
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/common.php"; 
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/connect.php"; 


	$i=0;
		$query2 = " select m.MENU_NM,s.me_code,s.me_name  from TB_CM_MENU m, TB_CM_MENU_SUB s where m.MENU_CD = s.p_code  order by m.SEQ, s.me_no";
		$dbresult2 = mysql_query($query2);
		while($row2 = mysql_fetch_array($dbresult2)){

			$sid = $row2['me_code'];

			$ARR_NUM[] = $row2['me_code'];	
			$ARR_MENU[] = $row2['me_name'];

			$query3 = " select c.me_code,c.me_name,c.me_url,c.p_code_name  from TB_CM_MENU_SUB c where c.p_code ='$sid'";
			$dbresult3 = mysql_query($query3);
	
			while($row3 = mysql_fetch_array($dbresult3)){


				$ARR_NUM[]  = $row3['me_code'];
				$ARR_MENU[] = "&nbsp;&nbsp;<font color=blue>".$row3['me_name']."</font>";


				$responce->rows[$i]['id']=$row2['me_code'];
				$responce->rows[$i]['cell']=array($ARR_NUM[$i],$ARR_MENU[$i]); 
			
			//	echo $i."<br>";
				
				
				$i++;
			}


	}



	 echo json_encode($responce); 
	

//print_r($responce);

exit;
echo"<select multiple SIZE=25 onchange='alert(this.value)'>";
	for($i=0; $i < count($ARR_MENU);$i++){

		echo "<option>".$ARR_MENU[$i]."</option>";

	}
echo"</select>";






?>


