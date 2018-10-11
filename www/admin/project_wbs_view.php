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
		<col width="85%">
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
			<td colspan="2">


<div class="btn-group" role="group" aria-label="...">
	  <button type="button" class="btn btn-default " onclick="search_tab(this.value);">전체</button>
	<?
								$step_sql = "SELECT idx,codename FROM psj_code WHERE part='2' && pcode = '400000'";
								$step_res = sql_query($step_sql);
								while($step_row=sql_fetch_array($step_res)){

								$codename = $step_row['codename'];
	?> 
	  <button type="button" class="btn btn-default" onclick="location.href='./project_wbs_write.php?pj_id=<?=$pj_id?>&part=project&codename=<?=$codename?>'" value="<?=$codename?>"><?=$codename?></button>
	  <? } ?>
	</div>







		
			<?

				$arr_m = select_member();

				$no=0;
				$query = "SELECT code,subject,pcode,part,sort,mb_id,sdate,edate FROM `psj_project_item` WHERE pj_id ='$pj_id' ORDER BY sort ASC";
				$results = sql_query($query);
				while($row = sql_fetch_array($results)){

				$code = $row['code'];
				$subject = $row['subject'];
				$part = $row['part'];
				$pcode = $row['pcode'];
				$mb_id = $row['mb_id'];
				$sdate = $row['sdate'];
				$edate = $row['edate'];
				$mb_name = $arr_m[$mb_id];

				if($part==1){ 	
					   $arr_item1[]= array($code,$subject); 
				   }
				if($part==2){ 	
					  $arr_item2[$pcode][]= array($code,$subject); 
				   }

				if($part==3){ 	
					  $arr_item3[$pcode][]= array($code,$subject,$mb_name,$sdate,$edate); 
				   }

				$no++;
				}

				//print_r2($arr_item2);exit;


			 ?>

			     <?

					foreach($arr_item1 as $key1=> $val1){	// 대분류 
					 
				?>   

			  <table id="example" border="1px" style="margin:0px;padding:0px;" width="100%">
					<col width="10%">      
					<col width="90">  	
			     <? 
			 
					 $c1 = $val1[0];
					
					 foreach($arr_item2[$c1] as $key2=> $val2){	  // 중분류

					    $c2 = $val2[0];
						 $c2_rowspan = count($arr_item2[$c1]);

					 ?>   
				
					<tr>
			        <? if($key2==0){ ?>
				  <th style="border:1px solid; black;"  rowspan="<?=$c2_rowspan?>">
							<?=$val1[1]?></th>
			        <? } ?>
				
					<td><!-- [<?=$val2[1]?>] -->

					<table width="100%" border="1px" style="border-collapse:collapse;margin:0px;padding:0px;">
					<col width="20%">
					<col width="35%">		
					<col width="15%">
					<col width="15%">
					<col width="15%">
					
					<? 
					
					 foreach($arr_item3[$c2] as $key3=> $val3){	 
						 $c3_rowspan = count($arr_item3[$c1]);

						
					?>

					       <tr class="item1" >
						  
						  <? if($key3==0){ ?>
						  <td  rowspan="<?=$c3_rowspan?>" style="border:1px solid; black;"><!-- <input type="text" /> --><?=$val2[1]?></td>
						  <? } ?>
						  
						  <td style="border:1px solid; black;"><?=$val3[1]?></td>
						  <td style="border:1px solid; black;">담당자 [<?=$val3[2]?>]</td>
						  <td style="border:1px solid; black;">시작일 [<?=$val3[3]?>]</td>
						  <td style="border:1px solid; black;">종료일 [<?=$val3[4]?>]</td>
					        </tr>
					<? } ?>

					</table>

				 </td>

				</tr>
			 <? } ?>

			</table>

			 <? } ?>


			</td>

			</tbody>
		</table>

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
					  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>수 정	<!-- 수정버튼 codename 파라미터 X -->
					</button>

					<script>
					function write_page(){
				
					  location.href='./project_wbs_write.php?pj_id=<?=$view[pj_id]?>&part=project';
					}					
					
					</script>
		</div>

		
		
			</form>
         </div> 


   	<form name="fdel" method="post" action="./project_update.php">
	<input type="hidden" name="wr_id" value="<?=$view['pj_id']?>" />
	<input type="hidden" name="oper" value="del" />
	</form>
		  <!-- table-responsive -->

	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

	

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->






<div style="height:60px;"></div>



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
