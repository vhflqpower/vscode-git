
//컬럼 보이기 감추기
function columnChooser(grid_no) {
	grid_no = grid_no || 1;
	$grid_local = getGrid(grid_no);
		$grid_local.jqGrid('columnChooser',
			{width: 550, msel_opts: {dividerLocation: 0.5}});
		var columnChooser = $j("#colchooser_"+$grid_local.attr('id'));
		
		columnChooser.css('min-width', columnChooser.width() + 'px');
		var dialog = columnChooser.closest('div.ui-dialog');
		columnChooser.closest('div.ui-dialog').css('min-width', dialog.width() + 'px');

		var div = columnChooser.children('div:has(div.ui-multiselect)');
		div.css('width', '100%');

		var uiMultiselect = div.children('div.ui-multiselect');

		uiMultiselect.css('width', '100%');
		uiMultiselect.children('div.available').css('width', '49.9%');
		uiMultiselect.children('div.selected').css('width', '49.9%');
}

//컬럼 추가
function addData(grid_no) {
	grid_no = grid_no || 1;
	$grid_local = getGrid(grid_no);
	$grid_local.editGridRow('new', {reloadAfterSubmit:true} );
}

//컬럼 삭제
function delSelData(grid_no) {
	grid_no = grid_no || 1;
	$grid_local = getGrid(grid_no);

	
	var ids;
	var gr = $grid_local.jqGrid('getGridParam','selrow');
	if( gr == null ) {
		alert('삭제할 항목을 선택해주세요');
		return;
	}

	ids = $grid_local.jqGrid('getGridParam','selarrrow');

	var editurl = $grid_local.jqGrid('getGridParam','editurl');

	if(confirm('정말 삭제하시겠습니까?')) {
		if(editurl == 'clientArray') {
			for(var ids = $grid_local.jqGrid('getGridParam','selarrrow'); ids.length; ids = $grid_local.jqGrid('getGridParam','selarrrow')){
				$grid_local.jqGrid( "delRowData", ids[0]);
			}
			$grid_local.jqGrid( "delRowData", ids);
		} else {
			$grid_local.jqGrid( "delGridRow", ids, {reloadAfterSubmit:true} );
		}
		return;
	}
	return;

}

function delSelData2() {delSelData(2)}

var grid_height = Array();
var grid_width = Array();

function fullGrid(grid_no) {
	grid_no = grid_no || 1;
	$grid_local = getGrid(grid_no);
	$grid_local_div = $('#div_'+$grid_local.attr('id'));
	grid_width[grid_no] = 	$grid_local.getGridParam("width");
	grid_height[grid_no] = 	$grid_local.getGridParam("height");

	var w = $(window).width();
	var h = $(window).height();

	var w2 = $(document).width();
	var h2 = $(document).height();

	$grid_local.setGridWidth(w - 50);
	$grid_local.setGridHeight(h - 150);

	$grid_local_div.css({'width':w2, 'height':h2}).addClass('fullscreen');
	$(document).scrollTop(0);
	$(document).scrollLeft(0);
}

function smallGrid(grid_no) {
	grid_no = grid_no || 1;
	$grid_local = getGrid(grid_no);
	$grid_local_div.removeAttr('style').removeClass('fullscreen');

	var w = grid_width[grid_no];
	var h = grid_height[grid_no];

	$grid_local.setGridWidth(w);
	$grid_local.setGridHeight(h);
}

function getGrid(no) {
	no = no || 1;
	var idx = Number(no) - 1;
	if(!idx || idx < 0) idx = 0;
	return $(".ui-jqgrid-btable").eq(idx);
}


/*#------------------------------------------------------------------->#검색*/
function search(frm_id,grid_no) {

	frm_id = frm_id || '.searchForm';
	grid_no = grid_no || 1;
	$grid_local = getGrid(grid_no);
	var sch_params = $(frm_id + ' :input').serialize();
	var url = $grid.getGridParam('url');
	url = url.split('?')[0];
	$grid_local.setGridParam({url : url + '?' + sch_params}).trigger("reloadGrid");

}


function search2(frm_id,grid_no) {

	frm_id = frm_id || '.searchForm2';
	grid_no = grid_no || 2;
	$grid_local = getGrid(grid_no);

	var sch_params = $(frm_id + ' :input').serialize();

	var url = $grid2.getGridParam('url');
	url = url.split('?')[0];

	$grid_local.setGridParam({url : url + '?' + sch_params}).trigger("reloadGrid");

}



function saveAllCell(grid_no) {
	grid_no = grid_no || 1;
	$grid_local = getGrid(grid_no);
 
  var ids = $grid_local.jqGrid('getDataIDs');

  for(var i=0; i < ids.length;i++){
   $grid_local.saveRow(ids[i])
  }

  for(var i=0; i < ids.length;i++){
   $grid_local.editRow(ids[i])
  }

} 


function cancelData(grid_no) {
	grid_no = grid_no || 1;
	$grid_local = getGrid(grid_no);
	$grid_local.trigger('reloadGrid');
}

function exportCvs(filename, grid_no)
{
	filename = filename || $(document).attr('title') + '_' + $.datepicker.formatDate('yymmdd', new Date()) + '.xls';
	grid_no = grid_no || 1;
	exportFile('/main/csvExport',filename, grid_no)
}
function exportCsv(filename, grid_no)
{
	filename = filename || $(document).attr('title') + '_' + $.datepicker.formatDate('yymmdd', new Date()) + '.xls';
	grid_no = grid_no || 1;
	exportFile('/main/csvExport',filename, grid_no)
}

function exportXls(filename, grid_no)
{
	filename = filename || $(document).attr('title') + '_' + $.datepicker.formatDate('yymmdd', new Date()) + '.xls';
	grid_no = grid_no || 1;
	exportFile('/main/xlsExport',filename, grid_no)
}

function exportFile(url,filename, grid_no,ignore_col,show_hidden)
{
	url = url || '/main/xlsExport';
	filename = filename || $(document).attr('title') + '_' + $.datepicker.formatDate('yymmdd', new Date()) + '.xls';
	grid_no = grid_no || 1;
	ignore_col = ignore_col || Array('cb','act');
	show_hidden = false;
	$grid_local = getGrid(grid_no);
	ignore_hash = {};

	for (var k in ignore_col) {ignore_hash[ignore_col[k]] = true;}

	if(!$grid_local) return;

	var mya=new Array();
	mya=$grid_local.getDataIDs();  // Get All IDs

	var data=$grid_local.getRowData(mya[0]);     // Get First row to get the labels
	var tmpName = $grid_local.getGridParam('colNames');
	var colModel = $grid_local.getGridParam('colModel');
	var colIdx=new Array(); 
	var colName=new Array(); 
	var colOption=new Array();
/*
var option_str = options.replace(/;/g,'\',\'').replace(/:/g,'\':\'');
eval('var x = {\''+option_str+'\'};');
*/

	var ii = 0;
	var option_str;
	for(var i in colModel) {
		if(!ignore_hash.hasOwnProperty(colModel[i].name) && (show_hidden || !colModel[i].hidden)){
			colName[ii] = tmpName[i];
			colIdx[ii] = colModel[i].name;
			if(colModel[i].formatter && colModel[i].formatter != "text" &&  colModel[i].editoptions && colModel[i].editoptions.value && colModel[i].editoptions.value.length) {
				option_str = colModel[i].editoptions.value;
				option_str = option_str.replace(/;$/g,'').replace(/;/g,'\',\'').replace(/:/g,'\':\'');
				colOption[ii] = eval('({\''+option_str+'\'});');
				if(!colOption['']) colOption[''] = '';
			}
			ii++;
		}
	}
/*
	var ii=0;
	for (var i in data){colIdx[ii++]=i;}    // capture col names
*/
	var headerHtml = colName.join();

	var html="",tmpData = '';
	for(i=0;i<mya.length;i++)
		{
		data=$grid_local.getRowData(mya[i]); // get each row
		for(j=0;j<colIdx.length;j++)
			{
			tmpData = (data[colIdx[j]]);
			if(colOption[j] && colOption[j][tmpData]) {
				tmpData = colOption[j][tmpData];
			} 
			
			html += strip_tags(tmpData);
			html += ","; // output each column as comma delimited
			}
		html=html+"\n";  // output each row with end of line

		}
	html=html+"\n";  // end of line at the end

	if($('#exportForm'))$('#exportForm').remove();

	var formHtml = '<form id="exportForm"><input type="hidden" name="fn" id="fn"><input type="hidden" name="colheader" id="colheader"><input type="hidden" name="buffer" id="buffer"></form>';

	$grid_local.after(formHtml);

	var form = $('#exportForm');
	var fn = $('#fn').val(filename);
	var colHeader = $('#colheader').val(headerHtml);
	var buffer = $('#buffer').val(html);
	form.attr('method','POST');
	form.attr('action',url);
	form.attr('target','_blank');
	form.submit();
}

function strip_tags (input, allowed) {
	allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
	var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
		commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
	return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {        return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
	});
}



	// 숫자콤마
	function setComma( num ){
		//return Number(String(num).replace(/\..*[^\d]/g,"")).toLocaleString().slice(0,-3);
	return Number(String(num).replace(/\..*[^\d]/g,"")).toLocaleString();
	}




	
function getMonth(part){

var newDate = new Date();
dateYear   = newDate.getFullYear();
//dateDay    = formatNumber(newDate.getDate());  // 날짜

	if(part==1){
	dateMonth  = formatNumber(newDate.getMonth()+1 );
	$("#sdate").val(dateYear+'-'+dateMonth+'-'+'01');
	$("#edate").val(dateYear+'-'+dateMonth+'-'+'31');
	}else if(part==2){
	dateMonth  = formatNumber(newDate.getMonth());
	$("#sdate").val(dateYear+'-'+dateMonth+'-'+'01');
	$("#edate").val(dateYear+'-'+dateMonth+'-'+'31');
	}else if(part==3){
	dateMonth  = formatNumber(newDate.getMonth()-1);
	$("#sdate").val(dateYear+'-'+dateMonth+'-'+'01');
	$("#edate").val(dateYear+'-'+dateMonth+'-'+'31');
	}else if(part==0){
	$("#sdate").val('');
	$("#edate").val('');
	}
}
