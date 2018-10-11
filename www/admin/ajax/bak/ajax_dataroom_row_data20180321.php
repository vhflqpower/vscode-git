<?php


	include_once("./_common.php");



	$WHERE =" 1=1";

	$pj_id = $_POST["pj_id"];

	$bo_table = 'data';


		$arr_gubun =  select_gubun(); // 자료구분
		$arr_project =  select_project(); // 자료구분

	
		$WHERE ="where 1=1";

		if($pj_id) $WHERE .= " and pj_id = '$pj_id'";



	$results = sql_query("SELECT * FROM psj_board_file ".$WHERE." ORDER BY seq DESC");
	while($row = sql_fetch_array($results))
	{
		$seq = $row['seq'];
		$wr_id = $row['wr_id'];
		$pj_id = $row['pj_id'];
		$bo_subject = $row['bf_source'];
		$bo_table = $row['bo_table'];

		$str = nl2br($row['wr_content']);
		//$str = url_auto_link($str);


?>
		 <tr>
			 <td><input type="checkbox" id="chk_seq" name="chk_seq" value="<?=$row['seq']?>"></td>
			 <td ><div align=center><font color=blue><?=$row['seq']?></a></div></td>;
			 <td><?=$wr_id?></td>
			 <td><?=$arr_gubun [$bo_table]?></td>
			 <td id=item_<?=$row['bo_table']?>>
			 <span style="color:#0000FF">[<?=$arr_project [$pj_id]?>]</span>
			 <?=$bo_subject?>
			 <button type="button" class="btn btn-default btn-xs" onclick="location.href='./download.php?bo_table=<?=$bo_table?>&bf_file=<?=$row[bf_file]?>&bf_source=<?=$row[bf_source]?>&seq=<?=$row[seq]?>'"><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Down</button>
			 <?=getFileSize($row['bf_filesize'])?>

			 </td>
			 <td ><?=$row['mb_name']?></td>
			 <td >
				 <?=$row['bf_datetime']?>
			 </td>
			 <td>
			 
			 <button type="button" class="btn btn-default btn-sm"  data-toggle='modal' data-target='#myModal'  onclick="popEdit('<?=$seq?>')" >
			<span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>수정</button>
			
			
			</td>
		 </tr>

<?

}


			//if(!$row['seq']){ echo "<tr><td colspan=7 style='text-align:center'>NO DATA</td></tr>"; }

?>

