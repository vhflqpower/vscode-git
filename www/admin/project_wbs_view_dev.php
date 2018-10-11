<?
	include_once("../common.php");

	$pj_id = $_GET['pj_id'];


	if($pj_id){

			$sql = "SELECT * FROM psj_project WHERE  pj_id = '$pj_id'";
			$result = sql_query($sql);
			$view = sql_fetch_array($result);



			//$str = nl2br($view['wr_content']);
			$str_content = url_auto_link($view['pj_content']);


		$oper = 'edit';
	}else{

		$oper = 'add';
		$view[bo_skin] = 'basic';
	}

	if($_GET['tab_id'])$tab_id=$_GET['tab_id'];else $tab_id=1;

	include_once("./head.php");
?>

<link rel="stylesheet" href="/css/boot_tab.css" type="text/css">
 
	<?
		include_once("./nav.php");
	?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header"><?=$view['pj_subject']?></h2>

          <div class="table-responsive">
	<form name="frm" method="post" action="./project_update.php" onSubmit="return saveSubmit(f)" enctype="multipart/form-data" >
		<input type="hidden" name="bo_table"  id="bo_table" value="project" />
		<input type="hidden" name="p_id"  id="p_id" value="<?=$view['pj_id']?>" />
		<input type="hidden" name="wr_file_link" id="wr_file_link" value="<?=$view['wr_file_link']?>" />
		<input type="hidden" name="oper" value="<?=$oper?>" />
		<input type="hidden" name="bo_table_enabled"    value="" id="bo_table_enabled">
	<!-- table-hover -->
				
	<table class="table table-bordered ">
	<!-- <table  class="table table-bordered table-hover"> -->
		<!-- <caption>테이블 설명</caption> -->
		<col width="15%">
		<col width="">
		<tbody>

			<tr>				
			<th>시작일</th>
			<td><?=$view['pj_start_date']?></td>
			</tr>
			<tr>				
			<th>오픈일</th>
			<td><?=$view['pj_open_date']?></td>
			</tr>
			<tr>
			<td colspan="2"></td>
			</tbody>
			</table>






<?




		$query = "SELECT code,subject,pcode,part,sort FROM `psj_project_item` WHERE pj_id ='$pj_id' ORDER BY sort ASC";
		$results = sql_query($query);
		$item_total = sql_num_rows($results);
		$no=0;
		while($row2 = sql_fetch_array($results)){


		$code = $row2[code];
		$pcode = $row2[pcode];
		$part = $row2[part];
		$sort = $row2['sort'];
	

				
				//$item[$no] = array($pcode, $code, $sort, '내용', '기타');



		$no++;
		}
		

	$item[0] = array(10000, 20110321, 1, '내용', '기타');
	$item[1] = array(10000, 20110321, 2, '내용', '기타');
	$item[2] = array(10000, 20110321, 3, '내용', '기타');
	$item[3] = array(10001, 20110322, 4, '내용', '기타');
	$item[4] = array(10001, 20110322, 5, '내용', );
	$item[5] = array(10000, 20110322, 6, '내용', );
	$item[6] = array(10000, 20110322, 7, '내용', );
	$item[7] = array(10001, 20110321, 8, '내용', );
	

for ($L=0; $L < 8; $L++) {



	$param[ $item[$L][0] ][ $item[$L][1] ][] = array($item[$L][2], $item[$L][3], $item[$L][4]);



}



foreach($param as $key => $value) {

	//test, tester의 날짜 갯수
	$cnt = count($param[$key]);

	//test(2), tester(1)
	$date_cnt[$key] = $cnt;

	foreach($param[$key] as $key2 => $value) {

		//20110321, 20110322 내용 갯수

		$cnt2 = count($param[$key][$key2]);

		//test-20110321(3), test-20110322(2), tester-20110322(2)
		$memo_cnt[$key][$key2] = $cnt2;

		//1번째 필드 rowspan값
		$rowspan[$key] += $cnt2;

		//2번째 필드 rowspan값
		$rowspan2[$key][$key2] += $cnt2;

		//전체 레코드

		$total_record += $cnt2;



	}//foreach

}//foreach





echo '<table width="800" border="1" cellpadding="10" cellspacing="1" bgcolor="#DDDDDD">';

$i = $j = 0;


foreach($param as $key => $val) {



	$i = $rowspan[$key];



	foreach($param[$key] as $key2 => $val2) {



		$j = $rowspan2[$key][$key2];



		foreach($param[$key][$key2] as $key3 => $val3) {

			

			echo '<tr bgcolor="#FFFFFF">';



			//첫번째 필드

			if($i == $rowspan[$key]) echo "<td rowspan='{$rowspan[$key]}'>$key({$rowspan[$key]}개)</td>";



			//두번째 필드

			if($j == $rowspan2[$key][$key2]) echo "<td rowspan='{$rowspan2[$key][$key2]}'>$key2</td>";



			//나머지 필드

			foreach($param[$key][$key2][$key3] as $k => $v) echo "<td>$v</td>";



	

			echo '</tr>';

			

			$i--;

			$j--;



		}//foreach



	}//foreach



}//foreach



echo '</table>';

?>




		<div style="float:left;">

				<?if($view['wr_id']){ ?>
				<button type="button" class="btn btn-danger btn-sm" onclick="del()">
				  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>삭 제
				</button>
				<? } ?>			
		</div>			


		<div style="float:right">		
					
					<button type="button" class="btn btn-default btn-sm"  onclick="location.href='./project_list.php?part=project'">
					  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>목 록
					</button>
					<button type="button" class="btn btn-default btn-sm"  onclick="write_page()">
					  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정
					</button>

					<script>
					function write_page(){
				
					  location.href='./project_wbs_write.php?pj_id=<?=$view[pj_id]?>&part=project';
					}					
					
					</script>
		</div>

		
		
			</form>
         </div> 



		  <!-- table-responsive -->

	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

	

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->
<div style="height:60px;"></div>

	<form name="fdel" method="post" action="./project_update.php">
	<input type="hidden" name="wr_id" value="<?=$view['wr_id']?>" />
	<input type="hidden" name="oper" value="del" />
	</form>

	<!-- <div style="position:absolute;left:400px;top:200px;width:1000px;height:800px;" id="detailListViewLayer">
	</div>-->

<?

	include_once("./footer.php");
?>

<script type="text/javascript">





</script>

<?
	include_once("./tail.php");
?>
