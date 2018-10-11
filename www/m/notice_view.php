<?
include_once("./_common.php");


	$page = $_GET['page'];


    $view = sql_fetch("SELECT * FROM psj_board WHERE  wr_id = '$wr_id'");
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
	<a href="./notice_list.php?page=<?=$page?>" data-rel="back" class="ui-btn ui-shadow ui-corner-all ui-btn-a">목록으로</a>
	
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
