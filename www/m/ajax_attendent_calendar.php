<?
include_once("./_common.php");


			$sYear = trim($_GET['at_year']);
			$sMon =  trim($_GET['at_month']);


			$tomonth = $sYear.$sMon;
			$query1 = "SELECT wr_1,count(*)as cnt FROM psj_board_schedule WHERE  wr_1 LIKE  '$tomonth%'  group by wr_1";
			$dbresult1 = sql_query($query1);
			$cnt = 0;
			while($row1 = sql_fetch_array($dbresult1)){
				
				$wdate = $row1['wr_1'];
				$ARR_SCHE_CNT[$wdate] = $row1['cnt'];	
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

				$tmp_today = $sYear.$sMon; 
				$today =$tmp_today.$ff;
				$day = date("d"); 
				$real_today = date("Ymd");
			 
				if($today==$real_today)$BGCOLOR='#a5e1a2';else$BGCOLOR='#fff';

				echo "<td  height='60px' style=\"background-color:$BGCOLOR;\" >$f";


				$torrow =  date("Y-m-d",strtotime("+1 day"));
				$twonine =  date("Y-m-d",strtotime("+29 day"));

					if($ARR_SCHE_CNT[$today] > 0){

					echo "<br><a href='#1' onclick=\"getSubjectData('".$today."')\"><img src='./img/user.png' width='30px' height='30px'></a>";
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





