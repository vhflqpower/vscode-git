<?
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/common.php"; 
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/connect.php"; 



		$query1 = " select MENU_CD,MENU_NM  from TB_CM_MENU WHERE 1 ORDER BY SEQ ASC";
		$dbresult1 = mysql_query($query1);
		$a = 0;
		while($row1 = mysql_fetch_array($dbresult1)){

		$arr_menu1_cd[$a] = $row1['MENU_CD'];
		$arr_menu1_nm[$a] = $row1['MENU_NM'];
		$a++;
		}


	$i=0;
		$query2 = " select m.MENU_CD,m.MENU_NM,s.me_code,s.me_name  from TB_CM_MENU m, TB_CM_MENU_SUB s where m.MENU_CD = s.p_code  order by m.SEQ, s.me_no";
		$dbresult2 = mysql_query($query2);
		while($row2 = mysql_fetch_array($dbresult2)){

			$mid = $row2['MENU_CD'];
			$sid = $row2['me_code'];

			$ARR_NUM[$mid][$sid][] = $row2['me_code'];	
			$ARR_MENU[$mid][$sid][] = array($row2['me_code'],$row2['me_name']);

			$query3 = " select c.me_code,c.me_name,c.me_url,c.p_code_name  from TB_CM_MENU_SUB c where c.p_code ='$sid'";
			$dbresult3 = mysql_query($query3);
	
			while($row3 = mysql_fetch_array($dbresult3)){


				$ARR_NUM[$mid][$sid][]  = $row3['me_code'];
				//$ARR_MENU[$mid][$sid][] = "&nbsp;&nbsp;<font color=blue>".$row3['me_name']."</font>";


			//	$responce->rows[$i]['id']=$row3['me_code'];
			//	$responce->rows[$i]['cell']=array($ARR_NUM[$i],$ARR_MENU[$i]); 
			
				$i++;
			}


	}
	
	#echo json_encode($responce); 
	





$menu1_cd1 = $arr_menu1_cd[0];
$menu1_cd2 = $arr_menu1_cd[1];
$menu1_cd3 = $arr_menu1_cd[2];


	foreach ($ARR_MENU[$menu1_cd1] as $key => $vals) {
	

	echo $vals[0][0].'_'.$vals[0][1]."<br>";

	
	}


	echo "<br>";

	foreach ($ARR_MENU[$menu1_cd2] as $vals) {
	
	echo $vals[0][0].'_'.$vals[0][1]."<br>";


	}

	echo "<br>";

	foreach ($ARR_MENU[$menu1_cd3] as $vals) {
		

	echo $vals[0][0].'_'.$vals[0][1]."<br>";



	}



exit;

?>


