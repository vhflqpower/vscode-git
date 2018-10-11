<?
include_once("./_common.php");



	$grid = 'cat1_list';
	$grid_pager = 'p'.$grid;
	$grid_div = 'div_'.$grid;
	$ajax_url = './ajax_file_info_data.php';
	$ajax_edit_url = './income_proc_server.php';
	$default_sort = 'seq';
	//$sch_uri = '?1=1';


	$now_path = '.';
	$g4['title'] = "jqgrid sample";

	include_once('./top_jqgrid.php');
	include_once("./jquery_lib.php");


?>
	<script type="text/javascript" src="/pop_item/grid_util.js"></script>


<script language="JavaScript">

var isMemberEdit = false;
var $j = jQuery; //전역 jQuery 네이밍 변경

/* ---------------------------------------------------------- */
var $grid = false; //전역 그리드 변수
var $grid_div = false; //전역 그리드페이저 변수
 
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
	width:790,
	height:230,
	
	datatype: "json",
	caption:"<font size=2px>업체정보</font>",
   	url:'<?=$ajax_url?><?=$sch_uri?>',
	editurl: "<?=$ajax_edit_url?>",
   	pager: '#<?=$grid_pager?>',
   	sortname: '<?=$default_sort?>',	
	colNames:['NO','FILE ID','파일명','메모','보기'],
	colModel:[
		{name:'seq',index:'seq', width:70, align:"center", editable:true,hidden:false, viewable: false, hidedlg:false,formoptions:{ rowpos:1 }},
		{name:'wr_id',index:'wr_id', width:114,align:"center",editable:true,editoptions:{readonly:false,size:10},formoptions:{ rowpos:2 }},	
		{name:'bf_source',index:'bf_source', width:480,align:"left",editable:true,editoptions:{readonly:false,size:10},formoptions:{ rowpos:3 }},	
		{name:'bf_content',index:'bf_content', width:48,align:"left",hidden:true,editable:true,editoptions:{readonly:false,size:10},formoptions:{ rowpos:3 }},	
		{name:'act',index:'act', width:60, align:"center", editable:false, viewable: true, hidedlg:true},
		],

/* edittype:'textarea', */

	shrinkToFit: false,
	sortable: true,
	multiselect: false,
   	rowNum:50,
   	rowList:[10,15,30,50,100],
    viewrecords: true,
    sortorder: "asc"


	,gridComplete: function(){
		var ids = $grid.jqGrid('getDataIDs');
		var cl, be, be2;
		var daa_url = 'http://www.tagintag.com/data/category/';

		for(var i=0; i < ids.length;i++){
			cl = ids[i];

	 	wr_id = $grid.jqGrid("getRowData", cl).wr_id;	
		var bf_source = $grid.jqGrid("getRowData", cl).bf_source;	



			be = "<a href='#' onclick=\"parentsend('"+wr_id+"','"+bf_source+"')\"><input style='height:22px;width:40px;' type='button' value='적용' ></a>"; 
//		be = "<input style='height:22px;width:20px;' type='button' value='E' onclick=\"$grid.editGridRow('"+cl+"');\"  />"; 
//			$grid.jqGrid('setRowData',ids[i],{act:be});
			

			
			be2 = $grid.getCell(cl,'cat1_img')
			be2 = be2 && "<img src='"+daa_url+be2+"' width='30' height='30'>"; 		
			$grid.jqGrid('setRowData',ids[i],{act:be,icon_view:be2});

		}
	}

	,onSelectRow: function(){

			var rowid, gubun_cd1;			
			rowid  = $grid.jqGrid("getGridParam", "selrow");	
			c1_code = $grid.jqGrid("getRowData", rowid).cat1;
			ca_no = $grid.jqGrid("getRowData", rowid).ca_no;

			getCat1(ca_no)
				$grid2.jqGrid('setGridParam',{url:"<?=$ajax_url2?>?cat1="+c1_code,page:1});
				$grid2.jqGrid('setCaption',"대메뉴ID: "+ca_no)
				.trigger('reloadGrid');
				$grid3.clearGridData();
				
				cat2Reset();
				cat3Reset();
	}



});


$grid.jqGrid('navGrid',"#<?=$grid_pager?>",{edit:false,add:true,del:false});

//$("#<?=$grid?>").setSelection($(10000);


}); 



//컬럼 보이기 감추기
function columnChooser() {
	$grid.jqGrid('columnChooser');
}

//컬럼 추가
/*
function addData() {
	$grid.editGridRow('new');
}
*/
function addData() {
 $grid.editGridRow('new', {reloadAfterSubmit:true} );
}


function  parentsend(rowid,bf_source){
		// var row_id = $("#row_id").val();
		//rowid  = $grid.jqGrid("getGridParam", "selrow");		
		//no_car = $grid.jqGrid("getRowData", rowid).no_car;
		//alert(rowid);


		bf_content = $grid.jqGrid("getRowData", rowid).bf_content;
	//	bf_source = $grid.jqGrid("getRowData", rowid).bf_source;
		var part = $("#part").val();

		$("#file_id_"+part, opener.document).val(rowid);
		$("#file_source_"+part, opener.document).val(bf_source);
		$("#file_memo_"+part, opener.document).val(bf_content);

			window.close();

}

</script>


	<script type="text/javascript">

	</script> 


<style>
	.tit{ font-size: 100%; }
</style>
</head>
<body>

		<h3 class="tit">파일정보</h3><br>
	
		<input type="text" id="part" value="<?=$_GET['id']?>">
		<div style="float:left;width:800px;border:0px solid blue;margin-left:5px;">  
				<form name="searchForm" id="searchForm" class="searchForm">
				<!-- <input type="button" value="search" class="pSearch"> -->
				<div style="float:left;width:300px;height:300px;border:0px solid blue;">
				<div id="<?=$grid_div?>">
						<table id="<?=$grid?>" class="grid_font"></table>
						<div id="<?=$grid_pager?>"></div>
						</div></form>
		<br />
		<form id="ajaxform" action="./ajax_cat1_img_server.php" method="post" enctype="multipart/form-data">
		</form>

		<script>
			
		function cat1_sort_pop(){
			window.open("./code_sort.php","frm","width=300,height=360,top=0,left=0")
		}
		</script>

		</div>
	</div>
			</form>

	

	<script type="text/javascript">

// # 코드개별데이터로딩------------------------------------------------#


function getMemoload(de_no) {

	//alert(me_no);
	pop_mb_schedul(de_no);
//	console.log('getCustOrder',id);
	if(de_no == '') {
		alert('코드가 없습니다.');
		return;
	}

	url = './ajax_deliver_memo_load.php?de_no=' + de_no;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
		//  contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩
			if(success) {

				var cell = response.rows;

				$('#de_no').val(cell.de_no);
				$('#de_subject').val(cell.de_subject);
				$('#de_content').val(cell.de_content);



			} else {
				alert('fail to load data');
			}
		}
	});
}

	function pop_mb_schedul() {
				var obj = document.getElementById("mbschedulePop");	 
				 if(obj.style.display == "none") {
					 obj.style.display = "block";
				 } else {
					 obj.style.display = "none";
					// reset_form("inputForm"); 
				 }
			}

	function pop_close() {
				var obj = document.getElementById("mbschedulePop");	 
					 obj.style.display = "none";
					 reset_form("inputForm"); 
			}



/*------------------------------------------------------------> 메모수정 */

function memoSubmit() {
 
	var postData;
	var rows = Object();


	var de_no = $('#de_no').val();
	var de_subject = $('#de_subject').val();
	var de_content = $('#de_content').val();



	if( de_subject == '') {
		alert('제목은 필수입니다.');
		$('#de_subject').focus();
		return;
	}


	if( de_content == '') {
		alert('내용은  필수입니다.');
		$('#de_content').focus();
		return;
	}


	var rows= {
		oper : 'edit',
		de_no : de_no,
		de_subject : de_subject,
		de_content : de_content,

	};
	
	var postData = $.param(rows);

// var postData = $('.inputForm :input').serialize() + '&oper=edit&id=<?=$id?>';

	var url = './ajax_deliver_memo_server.php'


	var msg = '배송 메모 유형을 정말 수정하시겠습니까?';


	if(confirm(msg)) {
		$.ajax({
			url:url,
			data: postData,
			type:'post',
			dataType:'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			success:function(response) {
				var success = (response.flag == 'succ');
				var message = response.message;
				var new_id = response.id;
				var msgs = response.msg2;
			
				$grid.trigger('reloadGrid');
				pop_close() 

				
			}
		});

	} 

	return;
} 







function cat1Reset(){

	$('#oper1').val('add');
	$("#cat1_cd").val('');
	$("#cat1_nm").val('');
	$("#c1_yn").val('');
}



/*------------------------------------------------------------> cat1 삭제 */

function memoDelete() {
 
	var postData;
	var rows = Object();


	var de_no = $('#de_no').val();
	var oper = 'del';

	if( de_no == '') {
		alert('삭제할 항목이 없습니다.');
		return;
	}



	var rows= {
		oper : oper,
		de_no : de_no,


	};
	
	var postData = $.param(rows);

	//var postData = $('.inputForm :input').serialize() + '&oper=edit&id=<?=$id?>';

	var url = './ajax_deliver_memo_server.php'//url 수정;


	var msg = '배송 메모를 정말 삭제하시겠습니까?';

	if(confirm(msg)) {

		$.ajax({
			url:url,
			data: postData,
			type:'post',
			dataType:'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			success:function(response) {
				var success = (response.flag == 'succ');
				var message = response.message;
				var new_id = response.id;
				var msgs = response.msg2;
			
				$grid.trigger('reloadGrid');
				pop_close() 
				
			}
		});

	} //confirm msg

	return;

} 

	
	</script>


</body>
</html>



