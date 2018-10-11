<?
include_once("./_common.php");


			$sYear = trim($_GET['at_year']);
			$sMon =  trim($_GET['at_month']);

	if(!$_GET['at_year'] && $_GET['at_month']){
			$sYear = date('Y');
			$sYear = date('m');
	}



			$tomonth = $sYear.'-'.$sMon;
			$query1 = "SELECT pn_id,pn_subject,substring(pn_endtime,1,10) as end_date FROM psj_plan WHERE  pn_endtime LIKE  '$tomonth%'  and mb_id = '$member[mb_id]'  group by pn_endtime";
			$dbresult1 = sql_query($query1);
			$cnt = 0;
			while($row1 = sql_fetch_array($dbresult1)){
				
				$edate = $row1['end_date'];
				$ARR_PLAN_SUB[$edate][$cnt] = array($row1['pn_id'],$row1['pn_subject']);	

			$cnt++;
			}

?>


<tr height= valign=top class='tblBody'>
<?

			$startnum = date("w", mktime(0,0,0,$sMon,1,$sYear));
			$endnum = date("t", mktime(0,0,0,$sMon,1,$sYear) );

			for ($i = 0; $i < $startnum; $i++)
			{
				echo "";
				echo "<td></td>";
			}


			for ($f = 1; $f <= $endnum; $f++)
			{
				if (!date("w", mktime(0,0,0,$sMon,$f,$sYear)) && !($f == 1 && $startnum ==0))
				{
					echo "";
					echo "</tr>";
					echo "<tr>";
					echo "</tr>";
					echo "<tr  valign=top class='tblBody'>";
					$cellrow = 0;
				}

				$ff = sprintf("%02d",$f);  

				$tmp_today = $sYear.'-'.$sMon; 
				$today =$tmp_today.'-'.$ff;
				$day = date("d"); 
				$real_today = date("Y-m-d");
			 
				if($today==$real_today)$BGCOLOR='#ebebeb';else$BGCOLOR='#fff';

				echo "<td  height='60px' style=\"background-color:$BGCOLOR;\" >$f";

				$torrow =  date("Y-m-d",strtotime("+1 day"));
				$twonine =  date("Y-m-d",strtotime("+29 day"));


					if(count($ARR_PLAN_SUB[$today]) > 0){
					//echo "<br><a href='#1' onclick=\"getSubjectData('".$today."')\"><img src='./img/user.png' width='30px' height='30px'></a>";

							echo '<br>';
						foreach($ARR_PLAN_SUB[$today] as $key=>$val){
							echo  "<a href='#1' onclick=\"editPlan(".$val[0].")\">".$val[1]."</a><br>";
						}


					}


				echo "</td>";
				$cellrow++;
			}

			for ($i = $cellrow; $i < 7; $i++)
			{ 
				echo "<td ></td>";
			}

			?> 

		</tr>





