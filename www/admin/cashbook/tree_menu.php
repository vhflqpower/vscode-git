<?
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/common.php"; 
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/connect.php"; 

	$root ='.';
	$grid = 'menu1';
	$grid_pager = 'p'.$grid;
	$grid_div = 'div_'.$grid;
	$ajax_url = './ajax_tree_xml.php';
	$ajax_edit_url = './proc_server.php';  // 	$ajax_edit_url = 'clientArray';
	$default_sort = 'SEQ';
	//$sch_uri = '?1=1';


// $ajax_edit_url2 = 'clientArray';

/* 은행코드정보*/
		$query1 = "SELECT * from TB_CM_MENU   where 1=1";
		$dbresult1 = mysql_query($query1);
		while($row1 = mysql_fetch_array($dbresult1)){
			$cnt++;
			$ARR_MENU1[$cnt] =  array($row1['MENU_CD'],$row1['MENU_NM']);	
		}


	$now_path = '.';
	$g4['title'] = "jqgrid sample";
	include_once("./jquery_lib.php")
?>


<script src="./grid_util.js"></script>

<style>
 .site_item li{ display:inline; }
 .search_tbl{ border-collapse: collapse;border-color:#ccc; }
 .search_tbl td{ padding:4px;}


</style>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>JQGRID 카테고리</title>

	<script type="text/javascript">
	var win_height =  $(window).height();
	$(window).resize(function() {
		win_height = $(window).height();
		response();
	});

	$(document).ready(function() {
		response();
	});

	function response() {
		if( $(window).width() > 1024) {
			$(".bs-docs-sidebar").show();
			$(".container").css("margin-left","180px");
		} else {
			$(".bs-docs-sidebar").hide();
			$(".container").css("margin-left","10px");
		}
	}
	</script> 

<style>
* {
    margin: 0;
    padding: 0;
    font-style: normal;
    font-family: 굴림, Gulim, 돋움, Dotum, AppleGothic, Sans-serif;
}

img, fieldset {
    border: none;
}

hr, legend {
    display：none;
}

li {
    list-style: none;
}

a {
}

a:visited {
}

a:hover, a:active, a:focus {
}

html, body{
height:100%;
margin:0;
padding:0;
overflow-x:hidden; 
overflow-y:hidden;
}




</style>


<script language="JavaScript">

var isMemberEdit = false;

var $j = jQuery; //전역 jQuery 네이밍 변경
var $grid = false; //전역 그리드 변수
var $grid_div = false; //전역 그리드페이저 변수

// 그리드초기 넓이값
var pageWidth = $("#<?=$grid_div?>").parent().width();// - 100;
var pageHeigth = $("#<?=$grid_div?>").parent().height();

if(pageHeigth == 987 )
	var rowcnt = 37;
else
	var rowcnt = 20;





jQuery("#treegrid").jqGrid({

   	url: 'ajax_tree_xml.php',
	treedatatype: "xml",
	mtype: "POST",
   	colNames:["id","Account","Acc Num", "Debit", "Credit","Balance"],
   	colModel:[
   		{name:'id',index:'id', width:1,hidden:true,key:true},
   		{name:'name',index:'name', width:180},
   		{name:'num',index:'acc_num', width:80, align:"center"},
   		{name:'debit',index:'debit', width:80, align:"right"},		
   		{name:'credit',index:'credit', width:80,align:"right"},		
   		{name:'balance',index:'balance', width:80,align:"right"}		
   	],
	height:'auto',
	pager : "#ptreegrid",
    treeGrid: true,
	ExpandColumn : 'name',
	caption: "Treegrid example"
});




 $j(document).ready(function(){


	$(".pSearch" ).bind('click',function() { 
		search('#searchForm');
	});

	 $grid = $j("#<?=$grid?>");
	 $grid_div = $j("#<?=$grid_div?>");


 $grid.jqGrid({
	autowidth:false,
	autoheight:false, 
	width:500,
	height:200,
	
	datatype: "json",
	caption:"<font size=2px>대메뉴</font>",
   	url:'<?=$ajax_url?><?=$sch_uri?>',
	editurl: "<?=$ajax_edit_url?>",
   	pager: '#<?=$grid_pager?>',
   	sortname: '<?=$default_sort?>',	
 	colNames:['MENU_CD','MENU_NAME','DATE','보기'],
	colModel:[
		{name:'CD',index:'NAME', width:55, align:"DATE", editable:true, viewable: true, hidedlg:false,formoptions:{ rowpos:1 }},
		{name:'MENU_CD',index:'MENU_CD', width:140,editable:true,editoptions:{readonly:false,size:40},formoptions:{ rowpos:2 }},
		{name:'MENU_NM',index:'MENU_NM', width:140,editable:false,editoptions:{readonly:false,size:10},formoptions:{ rowpos:3 }},
		{name:'수정',index:'수정', width:75, align:"center", editable:false, viewable: false, hidedlg:false},
		],

	shrinkToFit: false,
	sortable: true,
	multiselect: true,
   	rowNum:rowcnt,
   	rowList:[10,15,30,50,100],
    viewrecords: true,
    sortorder: "asc"


});

$grid.jqGrid('navGrid',"#<?=$grid_pager?>",{edit:false,add:true,del:false});

// New Row 추가
$grid.jqGrid('navGrid','#<?=$grid_pager?>',{});

$(".add-new-row").on("click",function(){
    $grid.jqGrid('addRow',"new");
});


}); 





//컬럼 보이기 감추기
function columnChooser() {
	$grid.jqGrid('columnChooser');
}


function addData() {
 $grid.editGridRow('new', {reloadAfterSubmit:true} );
}

 






</script>



</head>

 <body>
  
<div style="float:left;width:510px;border:1px solid blue;">

	<div id="<?=$grid_div?>">
			<table id="<?=$grid?>" class="grid_font"></table>
			<div id="<?=$grid_pager?>"></div>
			</div>
 </div>

<div style="float:left;width:510px;border:1px solid red;">
	<table id="treegrid"></table> 

</div>
</form>
<!-- <input type="button" value="등록하기" onclick="pop_mb_schedul();" />

 -->






<!-- <div class="navbar-fixed-bottom">
    <div id="footer" style="background:#ddd;padding:2px 10px;font-family:consolas, tahoma; font-size:11px;">
	&copy; PLUS1000
	</div>
</div>
 -->
</body>
</html>



