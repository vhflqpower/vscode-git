<?
include_once("./_common.php");




$sch_type = $_GET['sch_type'];
$sch_val = $_GET['sch_val'];


$sch_val = iconv("euc-kr", "utf-8", $sch_val);
$href = "sch_type=$sch_type&sch_val=$sch_val&m_id=$m_id";

if($sub_mid) $where_ext = "  ";
if($sub_sid) $where_ext .= "  ";

//if (is_numeric($_GET['page'])) {

	$query = "SELECT COUNT(1) AS cnt FROM psj_money  WHERE 1=1 $where_ext  ";
	$result = sql_query($query);
	$row=sql_fetch_array($result);
	$total = $row[cnt];

	// 페이징
	if(!$page) $page = 1;
	$page_count = 10;
	$end_count = 30;
	$start_count = ($page-1)*$end_count;
	$show_num = $total-$end_count*($page-1);
	$total_page=(int)(($total-1)/$end_count)+1;

	$sql = "SELECT 
	* FROM psj_money  WHERE 1=1 $where_ext order by mo_id desc limit 10"; // $start_count, $end_count
	$result_list=sql_query($sql);


	while($rows = sql_fetch_array($result_list)){ 

		$mo_id = $rows['mo_id'];

		$mo_date = $rows['mo_date'];


		$mo_part = ($rows['mo_part']==1)?"<font color=blue>수입</font>":"<font color=red>지출</font>";
 
		$checkbox = "<input type=checkbox name='chk_mo_id' id='chk_mo_id' value='".$mo_id."'>";
		//$img = "<img src='../data/file/erd/".$rows[bf_file]."' border='0' width='80' height=''>";


		$editBtn = "<button type=\"button\" class=\"btn btn-default btn-sm\" onclick=\"editMoneyPop(".$mo_id.");\"  >
			<span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\" ></span>수정</button>";


		echo "<tr id='".$mo_id."'>\n
		<td style='width:40px'><div align=center>".$checkbox."</div></td>\n	
		<td  style='width:200px'><div style='padding-left:5px'>".$mo_date."</div></td>\n	
		<td style='width:50px'><div align=center>".$mo_part."</div></td>\n
		<td style='width:50px'><div align=center>".$co_height."</div></td>\n
		<td style='width:50px'><div align=right>".number_format($rows['mo_price'])."</div></td>\n
		<td style='width:50px'><div align=left>".$rows['mo_memo']."</div>
		</td>\n
		<td style='width:140px'><div align=center>".$editBtn."</div></td>\n		
		</tr>\n";

		// <span class=\"button white\"></span><a href=\"#1\" onclick=\"javascript:pop_content_edit('".$wr_id."');\">수정</a>
		$show_num = $show_num - 1;
	}
	if(!$mo_id){ echo"<tr><td height=40 colspan=11 align=center>NO DATA</td></tr>"; }				 
	

	echo "<tr>\n";
/*
	echo "<td colspan=\"11\" height=20 align=center>\n";
 <input type='button' value='선택' onclick=\"pop_content_edit('".$wr_id."');\"</div>
	AjaxPage($page_count,$page, $total_page, $href);
	echo "</td>\n";
	echo "</tr>\n";
*/
?>