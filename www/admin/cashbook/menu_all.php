<?
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/common.php"; 
	include $_SERVER['DOCUMENT_ROOT']."/intranet/include/connect.php"; 

	$root ='.';
	$grid = 'menu1';
	$grid_pager = 'p'.$grid;
	$grid_div = 'div_'.$grid;
	$ajax_url = './test.php';
	$ajax_edit_url = './proc_server.php';  // 	$ajax_edit_url = 'clientArray';
	$default_sort = 'SEQ';
	//$sch_uri = '?1=1';

	$grid3 = 'menu3';
	$grid_pager3 = 'q'.$grid3;
	$grid_div3 = 'div_'.$grid3;
	$ajax_url3 = './ajax_menu3_json.php';
	$ajax_edit_url3 = './ajax_menu3_server.php';
	$default_sort3 = 'me_no';
	$sch_uri3 = '?1=1';

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
<script type="text/javascript" src="/board/studio/js/cal_han.js"></script>

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
	<link rel="stylesheet" type="text/css" href="../bootstrap.css"  media="all" />
	<link rel="stylesheet" type="text/css" href="../doc.css"  media="all" />
	<link rel="stylesheet" type="text/css" href="../common.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../main.css" media="all" />
	
	
	<script type="text/javascript" src="../jquery.js"></script>
	<script type="text/javascript" src="../login.js"></script>
	<script type="text/javascript" src="../bootstrap-dropdown.js"></script>

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
<script type="text/javascript" src="/js/member.js"></script>
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

.containerx {min-height:100%;position:relative;}
.containerx .header {background:#000;height:40px;}
.containerx .content {padding-bottom:100px;}
.containerx .footerx {position:absolute;bottom:0;left:0; background:#999;width:100%;height:34px;}




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
	var rowcnt = 60;
else
	var rowcnt = 60;




// , hidden:true, editrules:{edithidden:true}   에디터창 출력 옵션
 $j(document).ready(function(){

	// 그리드 검색
	$(".pSearch" ).bind('click',function() { 
		search('#searchForm');
	});

	 $grid = $j("#<?=$grid?>");
	 $grid_div = $j("#<?=$grid_div?>");


 $grid.jqGrid({
	autowidth:false,
	autoheight:false, 
	width:300,
	height:700,
	
	datatype: "json",
	caption:"<font size=2px>대메뉴</font>",
   	url:'<?=$ajax_url?><?=$sch_uri?>',
	editurl: "<?=$ajax_edit_url?>",
   	pager: '#<?=$grid_pager?>',
   	sortname: '<?=$default_sort?>',	
 	colNames:['MENU_CD','MENU_NAME'],
	colModel:[
		{name:'MENU_CD',index:'MENU_CD', width:120, align:"DATE",hidden:true, editable:true, viewable: true, hidedlg:false,formoptions:{ rowpos:1 }},
		{name:'MENU_NM',index:'MENU_NM', width:290,editable:true,editoptions:{readonly:false,size:40},formoptions:{ rowpos:2 }},
//		{name:'수정',index:'수정', width:75, align:"center", editable:false, viewable: false, hidedlg:false},
		],

	shrinkToFit: false,
	sortable: true,
	multiselect: false,
   	rowNum:rowcnt,
   	rowList:[60,60,30,50,100],
    viewrecords: true,
    sortorder: "asc"

// deposit
/* 셀 클릭시 상세보기
	,onCellSelect: function(rowid,iCol,cellcontent,e){
		if(iCol >= 1) {
			$grid.jqGrid('setSelection',rowid , false);
			$grid.viewGridRow(rowid, true);
		}
	}
*/

/*
	,gridComplete: function(){
		var ids = $grid.jqGrid('getDataIDs');
		var cl, be;
		for(var i=0; i < ids.length;i++){
			cl = ids[i];

	#	be = "<a href='./photo_write_pop.php?url=photo_list&po_no="+cl+"' target='_blank'>보기</a>"; 	
	be ="<button class='btn btn-mini btn-success' onclick='alim_view(31)'><i class='icon-white icon-eye-open'></i> 보기</button>";
			$grid.jqGrid('setRowData',ids[i],{act:be});
		}
	}	
*/


	,onSelectRow: function(ids) {

		if(ids == null) {
			ids=0;
			if($grid3.jqGrid('getGridParam','records') >0 )
			{
				alert(1);
				$grid3.jqGrid('setGridParam',{url:"<?=$ajax_url3?>?id="+ids,page:1});
				$grid3.jqGrid('setCaption',"대메뉴ID: "+ids)
				.trigger('reloadGrid');
			}
		} else {

			$("#p_code").val(ids);
			$grid3.jqGrid('setGridParam',{url:"<?=$ajax_url3?>?id="+ids,page:1});
			$grid3.jqGrid('setCaption',"대메뉴ID: "+ids)
			.trigger('reloadGrid');			
		}
	}

});


$grid.jqGrid('navGrid',"#<?=$grid_pager?>",{edit:false,add:false,del:false});

// New Row 추가
$grid.jqGrid('navGrid','#<?=$grid_pager?>',{});
/*
 $(".add-new-row").on("click",function(){
        $("#grid").editGridRow( "new" );
   });
*/

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


function saveSelCell() {

	var gr = $grid3.jqGrid('getGridParam','selrow');

/*
	if( gr == null ) {
		alert('저장할 항목을 선택해주세요');
		return;
	}
*/		
	var ids = $grid3.jqGrid('getGridParam','selarrrow');

	for(var i=0; i < ids.length;i++){
		$grid3.saveRow(ids[i]);
	}

/*
	for(var i=0; i < ids.length;i++){
		$grid3.editRow(ids[i]);
	}
*/
}

function cancelData() {
	$grid3.trigger('reloadGrid');
}




// 상세메뉴시작
/*----------------------------------------------------------------*/

var isMemberEdit = false;

var $j = jQuery; //전역 jQuery 네이밍 변경
var $grid3 = false; //전역 그리드 변수
var $grid_div3 = false; //전역 그리드페이저 변수



// , hidden:true, editrules:{edithidden:true}   에디터창 출력 옵션
 $j(document).ready(function(){

	// 그리드 검색
	$(".pSearch2" ).bind('click',function() { 
		search2('#searchForm2');
	});


 $grid3 = $j("#<?=$grid3?>");
 $grid_div3 = $j("#<?=$grid_div3?>");
 
 $grid3.jqGrid({
	width:960,
	height:400,
	datatype: "json",
	caption:"소메뉴",
   	url:'<?=$ajax_url3?><?=$sch_uri3?>',
	editurl: "<?=$ajax_edit_url3?>",
   	pager: '#<?=$grid_pager3?>',

	sortname: '<?=$default_sort3?>',	
 	colNames:['메뉴코드','메뉴명','URL','보기'],
	colModel:[
		{name:'me_code',index:'me_code', width:120, align:"center", editable:true, viewable: true, hidedlg:false,formoptions:{ rowpos:1 }},
		{name:'me_name',index:'me_name', width:160,editable:true,editoptions:{readonly:false,size:40},formoptions:{ rowpos:2 }},
		{name:'me_url',index:'me_url', width:360,editable:false,editoptions:{readonly:false,size:10},formoptions:{ rowpos:3 }},
		{name: 'myac', width:60, fixed:true, sortable:false, resize:false, formatter:'actions', formatoptions:{keys:true}},
		],

	shrinkToFit: false,
	sortable: true,
	multiselect: true,
   	rowNum:30,
   	rowList:[10,15,30,50,100],
    viewrecords: true,
    sortorder: "asc"
         

	,gridComplete: function(){
		var ids = $grid3.jqGrid('getDataIDs');
		var cl, be;
		for(var i=0; i < ids.length;i++){
			cl = ids[i];
	be = "<a href='../studio/photo_write_pop.php?st_no="+cl+"&url=co_income_list' target='_blank' >수정</a>"; 

			$grid3.jqGrid('setRowData',ids[i],{act:be});
		}
	}	

});




$grid3.jqGrid('navGrid',"#<?=$grid_pager3?>",{edit:false,add:false,del:false});


$grid3.jqGrid('navGrid',"#<?=$grid_pager3?>",{edit:false,add:false,del:false});

// New Row 추가
$grid3.jqGrid('navGrid','#<?=$grid_pager3?>',{});
/*
 $(".add-new-row").on("click",function(){
        $("#grid").editGridRow( "new" );
   });
*/

$(".add-new-row2").on("click",function(){
    $grid3.jqGrid('addRow',"new");
});







}); 



</script>



</head>

 <body>
  
<div style="float:left;width:310px;border:1px solid blue;">
<button class="add-new-row">Add New Row</button>
<span class="button red;"><a href="#" onclick="delSelData(1);">선택삭제</a></span>
	<div id="<?=$grid_div?>">
			<table id="<?=$grid?>" class="grid_font"></table>
			<div id="<?=$grid_pager?>"></div>
			</div>
 </div>


<div style="float:left;width:980px;border:1px solid blue;margin-top:2px;">
<button class="add-new-row2">추가하기</button>
<button class="add-save-row_grid3">저장하기</button>
<button class="add-cancle-row_grid3">취소</button>

<input type="text" id="p_code">
	 <div id="<?=$grid_div3?>">
	<table id="<?=$grid3?>" class="grid_font"></table>
	<div id="<?=$grid_pager3?>"></div>
	</div>
</div>




</form>
<!-- <input type="button" value="등록하기" onclick="pop_mb_schedul();" />

 -->




<script>
	function changeCat(obj) {
		var name = $(obj).attr("name");
		if(name == 'cat1') {
			$.get("sel_category.php","mode=cat2&val="+$(obj).val(), function(data) {
				$("#cat2").html(data);
			});
		}
		else
		if(name == 'cat2') {
			$.get("sel_category.php","mode=cat3&val="+$(obj).val(), function(data) {
				$("#cat3").html(data);
			});
		}
	}

</script>




<!-- <div class="navbar-fixed-bottom">
    <div id="footer" style="background:#ddd;padding:2px 10px;font-family:consolas, tahoma; font-size:11px;">
	&copy; PLUS1000
	</div>
</div>
 -->
</body>
</html>



