<?
include_once("./_common.php");



	include_once("../head.php");
	$root ='.';
	$grid = 'as_list';
	$grid_pager = 'p'.$grid;
	$grid_div = 'div_'.$grid;
	$ajax_url = './ajax_money_data.php';
	$ajax_edit_url = './ajax_money_server.php';
	$default_sort = 'ca_no';
	//$sch_uri = '?1=1';


	$now_path = '.';
	$g4['title'] = "jqgrid sample";
	include_once("./jquery_lib.php");



?>





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




// , hidden:true, editrules:{edithidden:true}   에디터창 출력 옵션
 $j(document).ready(function(){

	// 그리드 검색
	$(".pSearch" ).bind('click',function() { 
		search('#searchForm');
	});

	 $grid = $j("#<?=$grid?>");
	 $grid_div = $j("#<?=$grid_div?>");


 $grid.jqGrid({

	width:'940',
	height:'280',
	
	datatype: "json",
	caption:"<font size=2px>입출금내역</font>",
   	url:'<?=$ajax_url?><?=$sch_uri?>',
	editurl: "<?=$ajax_edit_url?>",
   	pager: '#<?=$grid_pager?>',
   	sortname: '<?=$default_sort?>',	
	colNames:['NO','wdate','구분','항목','금액','내역','보기'], 
	colModel:[
		{name:'ca_no',index:'ca_no',width:0, align:"center", editable:true,hidden:true, viewable: false, hidedlg:true,formoptions:{ rowpos:1 }},

		{name:'ca_wdate',index:'ca_wdate', width:125, editable:true, editoptions: {defaultValue: "<?=date('Y-m-d')?>", dataInit: function (elem) {		
									setTimeout(function(){
									$(elem).datepicker({dateFormat:"yy-mm-dd"}); }, 2);
				} 
		}
				,formoptions:{ rowpos:3 }},	
		{name:'ca_part',index:'ca_part', width:100, align:"center", editable:true, formoptions:{ },
			edittype:'select', formatter:'select', editoptions:{value:":선택;I:입금;O:출금"}},

		{name:'ca_code1',index:'ca_code1', width:120, align:"center", editable:true, formoptions:{ },
			edittype:'select', formatter:'select', editoptions:{value:":선택;1:AAAAA;2:BBBBB"}},	
		{name:'ca_money',index:'ca_money',width:160,align:"right",formatter:'integer',editable:true,editoptions:{readonly:false,size:14},formoptions:{ rowpos:3 }},
		{name:'ca_memo',index:'ca_memo',align:"left",width:280,editable:true,editoptions:{readonly:false,size:36},formoptions:{ rowpos:3 }},
	//	{name:'act',index:'act', width:80, align:"center", editable:false, viewable: true, hidedlg:true},
		{name: 'myac', width:60, fixed:false, sortable:false, resize:false, formatter:'actions', formatoptions:{keys:true}},
		],



	shrinkToFit: false,
	sortable: true,
	multiselect: true,
   	rowNum:rowcnt,
   	rowList:[10,15,30,50,100],
    viewrecords: true,
    sortorder: "desc"

// deposit
/* 셀 클릭시 상세보기*/             
/*
	,onCellSelect: function(rowid,iCol,cellcontent,e){
		if(iCol >= 1) {
			$grid.jqGrid('setSelection',rowid , false);
			$grid.viewGridRow(rowid, true);
		}
	}
*/

	,gridComplete: function(){
		var ids = $grid.jqGrid('getDataIDs');
		var cl, be;
		for(var i=0; i < ids.length;i++){
			cl = ids[i];

	//	be = "<a href='./photo_write_pop.php?url=photo_list&po_no="+cl+"' target='_blank'>보기</a>"; 	
	be ="<button class='btn btn-mini btn-success' onclick='alim_view(31)'><i class='icon-white icon-eye-open'></i> 보기</button>";
			
			
			
			$grid.jqGrid('setRowData',ids[i],{act:be});
		}
	}	

});


$grid.jqGrid('navGrid',"#<?=$grid_pager?>",{edit:false,add:true,del:false});


	$(".add-new-row").on("click",function(){
	  
		$grid.jqGrid('addRow',"new");

		jQuery("#<?=$grid?>").resetSelection();
		
			var add_cnt = $('#add_cnt').val();
			var add_id = $('#add_id').val();
			var total =  parseInt(add_id) - parseInt(1);
			var total_m =  parseInt(add_cnt) + parseInt(1);
			$('#add_id').val(total);
			$('#add_cnt').val(total_m);
			$("#new_row").attr('id',total);
		
			$("#new_row_ca_wdate").attr('id',"ca_wdate_e_"+total);	
			$("#new_row_ca_price").attr('id',"ca_money_"+total);	
			$("#new_row_ca_part").attr('id',"ca_part_"+total);
			$("#new_row_ca_code1").attr('id',"ca_code1_"+total);
			$("#new_row_ca_memo").attr('id',"ca_memo_"+total);

			
	});




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

function sub_cancle(){
	var add_cnt = $("#add_cnt").val();
	var s_cnt = $("#add_id").val();
		if(s_cnt == 0){
			alert('더 이상 제거 할 항목이 없습니다.');
			return false;
		}
	$grid.delRowData(s_cnt);
	var tmp_add_cnt = parseInt(add_cnt) - 1;
	var tmp_s_cnt = parseInt(s_cnt) + 1;

	$("#add_cnt").val(tmp_add_cnt);
	$("#add_id").val(tmp_s_cnt);

}

</script>


	<?
		include_once("./nav.php");
	?>

 <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->



  <h3>출납내역</h3>
<div style="border:0px solid blue;">
	<input type="radio" name="inout_type" id="inout_type" value="i">수입
	<input type="radio" name="inout_type" id="inout_type" value="o">지출
	<input type="button" id="" name="" value="추가" class="add-new-row" style="width:42px;height:22px;" />
	<input type="button" id="" name="" value="제거" onclick="sub_cancle();" style="width:42px;height:22px;" />
	<input type="button" id="" name="" value="저장" onclick="money_submit();" style="width:42px;height:22px;" />
	<input type="button" id="" name="" value="취소" onclick="money_submit();" style="width:42px;height:22px;" />
	<input type="text" id="add_cnt" value="0" style="width:60px;height:12px;">
	<input type="text" id="add_id" value="0" style="width:60px;height:12px;">


	<div id="<?=$grid_div?>">
			<table id="<?=$grid?>" class="grid_font"></table>
			<div id="<?=$grid_pager?>"></div>
			</div>

	<input type="button" id="" name="" value="선택삭제" onclick="delSelData();" style="width:82px;height:22px;" />
 </div>

</form>
<!-- <input type="button" value="등록하기" onclick="pop_mb_schedul();" />

 -->




<script>

// 단말기 아이템 저장
function money_submit() {
 


	var ids = $grid.jqGrid('getDataIDs');
	var acnt = $("#add_cnt").val();
	var bcnt = acnt - parseInt(1);
	var oper = $("#oper").val();

	//alert(ids.length)

	if(ids.length < 1) {
		alert('입력 할 항목이 없습니다..');
		return false;
	}


	var wdate = Array();
	var part = Array();
	var code1 = Array();
	var money = Array();
	var memo = Array();


for(var i=0; i < ids.length;i++){

		if(i == acnt)break;
		
		$grid.jqGrid('saveRow',ids[i]);

		wdate[i] = $grid.jqGrid('getCell',ids[i],'ca_wdate');
		part[i] = $grid.jqGrid('getCell',ids[i],'ca_part');
		code1[i] = $grid.jqGrid('getCell',ids[i],'ca_code1');
		money[i] = $grid.jqGrid('getCell',ids[i],'ca_money');
		memo[i] = $grid.jqGrid('getCell',ids[i],'ca_memo');


if(!wdate[i]) {
			alert('입력이 안된 일자 있습니다.\n전부 입력해 주십시오');
			for(var j=0; j <= i;j++){
				$grid.jqGrid('editRow',ids[j]);
			}
			return;
		}



if(!part[i]) {
			alert('입력이 안된 구분이 있습니다.\n전부 입력해 주십시오');
			for(var a=0; a <= i;a++){
				$grid.jqGrid('editRow',ids[a]);
			}
			return;
		}


if(!code1[i]) {
			alert('입력이 안된 코드가 있습니다.\n전부 입력해 주십시오');
			for(var b=0; b <= i;b++){
				$grid.jqGrid('editRow',ids[b]);
			}
			return;
		}




if(!money[i]) {
			alert('입력이 안된 금액이 있습니다.\n전부 입력해 주십시오');
			for(var b=0; b <= i;b++){
				$grid.jqGrid('editRow',ids[b]);
			}
			return;
		}



	
	}


	var rows = Object(); // 필수



	var postData; // 필수

	var rows= {        //필수

		oper : 'add',
		ids : ids,
		wdate : wdate,
		part : part,
		code1 : code1,
		money : money,
		memo : memo,


	};


	var postData = $.param(rows);   //필수



 if(confirm("선택된 데이터를 정말 저장하시겠습니까?"))
 {

  }else{


	var ids = $grid.jqGrid('getDataIDs');
			for(var i=0; i < acnt;i++){
				$grid.jqGrid('editRow',ids[i]);
	}
		return false; 

} 

	var url = './ajax_money_server.php';


		$.ajax({
			url:url,
			data: postData,
			type:'post',
			dataType:'json',
			cache:false,
			success:function(response) {
				var success = (response.flag == 'succ');
				var message = response.message;
				var new_id = response.id;

				alert('정상처리 되었습니다.');
				$grid.trigger('reloadGrid');
				$grid.clearGridData();
				$("#add_id").val(0);
				$("#add_cnt").val(0);				


			}
		}); // $.ajax({
	
}



	
	
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



	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->

      </div>    <!-- row -->
   </div>  <!-- container-fluid -->



<?
	include_once("../footer.php");
?>
<?
	include_once("../tail.php");
?>


