<?php
//if(!defined("_DOJANGMASTER_")) exit; // 개별 페이지 접근 불가 
include_once("common.php");


	$href = $_GET['href'];
	$at_year = $_GET['at_year'];
	$at_month = $_GET['at_month'];
	$pass_month = $_GET['pass_month'];

	$ms_part = $_GET['ms_part'];

	//$at_month = iconv("euc-kr", "utf-8", $at_month);
	$href = "at_year=$at_year&at_month=$at_month&ms_part=$ms_part";
	$searchDate=$at_year.$at_month;

	$searchDate ="";
	if($searchDate) $where_ext = " AND in_date LIKE '$searchDate%' ";

// if (is_numeric($_GET['href'])) {

	$monthNames = Array("1월", "2월", "3월", "4월", "5월", "6월", "7월", 
	"8월", "9월", "10월", "11월", "12월");


	if (!isset($_REQUEST["at_month"])) $_REQUEST["month"] = date("n");
	if (!isset($_REQUEST["at_year"])) $_REQUEST["year"] = date("Y");

	$cMonth = $_REQUEST["at_month"];
	$cYear = $_REQUEST["at_year"];

	echo "<table width='100%' border='1' cellpadding='0' cellspacing='0' style='border-collapse:collapse;' />";
//	echo "<tr align='center'>";
//	echo "<td colspan='7' bgcolor='#999999' style='color:#FFFFFF' height='24'>".$cYear.'-'.$cMonth."월";
//	echo "</td>";
//	echo "</tr>";
	echo "<tr>";
	echo "<td align='left' width='14.2%' height='22' bgcolor='#cccccc' style='color:#FF0000'><strong>일</strong></td>";
	echo "<td align='left' width='14.2%' bgcolor='#cccccc' style='color:#FFFFFF'><strong>월</strong></td>";
	echo "<td align='left' width='14.2%' bgcolor='#cccccc' style='color:#FFFFFF'><strong>화</strong></td>";
	echo "<td align='left' width='14.2%' bgcolor='#cccccc' style='color:#FFFFFF'><strong>수</strong></td>";
	echo "<td align='left' width='14.2%' bgcolor='#cccccc' style='color:#FFFFFF'><strong>목</strong></td>";
	echo "<td align='left' width='14.2%' bgcolor='#cccccc' style='color:#FFFFFF'><strong>금</strong></td>";
	echo "<td align='left' width='14.2%' bgcolor='#cccccc' style='color:#0000FF'><strong>토</strong></td>";
	echo "</tr>";



	$at_month = sprintf("%02d",$at_month);
		$tomonth =$at_year.$at_month;
		$query = "SELECT wr_id,wr_subject,wr_1 FROM psj_board_schedule  WHERE wr_1 LIKE '$tomonth%'";

		$dbresult = sql_query($query);
			$cnt = 1;
		while($row = sql_fetch_array($dbresult)){
			$cnt++;

			$wr_id = $row['wr_id'];
			$wr_1 = $row['wr_1'];
			$ARR_MBSC[$cnt][$wr_1] = array($row['wr_id'],$row['wr_1'],$row['wr_subject']);	
		}




		$sYear = $cYear;
		$sMon = $cMonth; 
		$startnum = date('w', mktime(0,0,0,$sMon,1,$sYear));
		$endnum = date('t', mktime(0,0,0,$sMon,1,$sYear) );



		for ($i = 0; $i < $startnum; $i++)
		{
			echo "";
			echo "<td height=50></td>";
		}


		for ($f = 1; $f <= $endnum; $f++)
		{
			if (!date("w", mktime(0,0,0,$sMon,$f,$sYear)) && !($f == 1 && $startnum ==0))
			{
				echo "";
				echo "</tr>";
				echo "<tr>";
				echo "</tr>";
				echo "<tr  valign=top>";
				$cellrow = 0;
			}

			echo "";
			echo "<td style='cursor:hand'onmouseover=\"this.style.background='#F2F2F2'\" onmouseout=\"this.style.background='#FFFFFF'\" ><table border=0 cellspacing=0 cellpadding=0 width=100>";

			$tmp_today = date("Ymd");
			$s_mon = sprintf("%02d",$sMon);
			$day = sprintf("%02d",$f);  
			$today =$sYear.$s_mon.$day;
			
			echo "<tr><td height=50>";

			if($today==$tmp_today)echo"<font color=red>오늘~</font>";

			echo "<br>";





			foreach ($ARR_MBSC as $val) {
			if($val[$today][2]){
				$wr_id = $val[$today][0];

			$row_cnt = sql_fetch("SELECT count(*) as add_cnt FROM `psj_schedule_add` where board_id ='schedule' and board_seq = '$wr_id'");

				if($row_cnt[add_cnt])$att_cnt = $row_cnt[add_cnt];else $att_cnt='';

				echo  "<a href=./board/view.php?bo_table=schedule&wr_id=$wr_id'".$wr_id."'>".$val[$today][2]."</a><br><font color=blue><b>".$att_cnt."</b></font>";	

			}
		}


			if(!$cellrow || $cellrow==0){
			echo "</td><font color=red>$f</font></tr>";
			}else if($cellrow==6){
			echo "</td><font color=blue>$f</font></tr>";
			}else{
			echo "</td><a href=/board/write.php?bo_table=schedule&wdate={$cYear}{$s_mon}{$day}&subdate={$cYear}-{$s_mon}-{$day}>$f</a></tr>";
			}
			
			echo "</table></td>"; 
			$cellrow++;
		}

		for ($i = $cellrow; $i < 7; $i++)
		{ 
			echo "<td width=50></td>";
		}

		echo"</tr>";
		echo"<tr>";
		echo"<td colspan=15 bgcolor='#dedede'></td>";
		echo"</tr>";
		echo"</table>";




// }
?>