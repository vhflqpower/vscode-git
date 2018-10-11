<?
include_once("./_common.php");


	$wr_id = $_GET['wr_id'];

    $view = sql_fetch("SELECT * FROM psj_board_schedule WHERE  wr_id = '$wr_id'");
    $str_content = url_auto_link($view['wr_content']);
    
	include_once("./head.php"); 
?>
<!-- Start of first page: #one -->


<div data-role="page" id="notice_view" ><!-- data-dialog="true" -->

	<div data-role="header" data-add-back-btn="true" data-position="fixed" >
		  <h1>M.T.A 엠티에이</h1>
	</div>
	
	<!-- /header -->

	<div role="main" class="ui-content">
		 <h2><?=$view[wr_subject]?></h2>
		<?echo $str_content;?>
	<hr>
	
	<table width="100%" border="0"> 
			<tr> 
			<?
			$query4 = " 
				SELECT idx,mb_id,mb_name,late_yn,regdate FROM `psj_schedule_add` where board_id ='schedule' and board_seq = '$wr_id'";
			$result4 = sql_query($query4);

			$list_cols = 5; 
			for($i=1; $i<=($row4 = sql_fetch_array($result4)); $i++) { 

				//$img_title = str_cut($row4[mb_id], 20, '..');
				$late_yn=($row4['late_yn']=='Y')?"<font color=red>지각</font>":"";

			?>
			<td width="14%" height="24">
				<font color=blue><b><?=$row4['mb_name']?></b><?=$late_yn?></font><br><?=$row4['regdate']?>
			 <? if($member[mb_id]=='psj007'){ ?>
			  <!-- <button type="button" class="btn btn-default btn-xs" onclick="late_confirm('<?=$row4[idx]?>','<?=$row4[mb_id]?>')">
			  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>지각
			</button> -->
			<? } ?>
			</td> 
			<? if($i % $list_cols ==0 ) { 
			echo "</tr><tr>"; 
			} 
			?> 
			<?} 
			if (($cnt = ($i-1)%$list_cols) != 0) 
				for ($k=$cnt; $k<$list_cols; $k++) 
					echo " <td width='14%'>&nbsp;</td>\n"; 
			?> 
			</table><br>
	
	
			<!-- <div style="float:left;">
			<button type="button" class="btn btn-success btn-sm" onclick="lfn_seq_confirm()">
			  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>출 석
			</button>
			</div> -->
			
				<div class="btn-wrap clearfix">
					<span class="grid1of2 pr3"><a href="./notice_list.php?page=<?=$page?>"  data-rel="back" class="btn btn-block btn-lg bg-wh btn-border">목록으로</a></span>
					<span class="grid1of2 pl3"><a href="/m/login.php?chUrl=<?=$_GET['chUrl']?>" class="btn btn-block btn-lg bg-wh btn-border">출석체크</a></span>
				</div>

			<!-- <a href="./notice_list.php?page=<?=$page?>" data-rel="back" class="ui-btn ui-shadow ui-corner-all ui-btn-a">출석하기</a> -->
			<!-- <a href="./notice_list.php?page=<?=$page?>" data-rel="back" class="ui-btn ui-shadow ui-corner-all ui-btn-a">목록으로</a> -->
	
	</div><!-- /content -->
<!-- 
  <div data-role="footer" data-theme="a">
		<h4>CopyRight M.T.A</h4>
	</div>
 -->

<div data-role="footer"  data-position="fixed">
	<h2>CopyRight M.T.A </h2>
	<!-- <a href="./notice_list.php?page=2" class="jqm-navmenu-link ui-nodisc-icon ui-alt-icon ui-btn-left ui-btn ui-icon-carat-l ui-btn-icon-notext ui-corner-all"  data-rel="back">Menu</a> -->
  </div>

</div> 

<? 
include_once("./foot.php");

?>
