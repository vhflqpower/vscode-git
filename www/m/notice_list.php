<? 
include_once("./_common.php");

include_once("./head.php");


	$page = $_GET['page'];
?>


<div data-role="page" id="notice_list">
  <div data-role="header" data-position="fixed">
      <!-- <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a> -->
 <a  href="#myPanel" class="jqm-navmenu-link ui-nodisc-icon ui-alt-icon ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all">Menu</a>
   <h1><a href="./" class='menu'>M.T.A 엠티에이</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>

	<? 
	include_once("./navbar.php");
	?>

<script>

	//$.mobile.changePage("second.php", { type: "post", data: $("form#search").serialize(), changeHash: false });

	// 온로드		
	$( function() {
		// 데이터 조회
		getTransferHistoryList();

	});
  



    	var G_PAGE = 1;//'<?=$page?>';
	// 즉시구매 희망자 조회

	function getTransferHistoryList() {

        if(!G_PAGE){  G_PAGE = 1;}else{   G_PAGE = G_PAGE; }

		var skeyword = $("#autocomplete-input").val();

       if(skeyword){ 
		   G_PAGE = 1;
		   $(".item_row").remove();		     
		 }


		var param = "page="+G_PAGE+"&search_keyword="+skeyword;
		//console.log( "=====> param: "+ param );

		$.ajax({
			url: "./ajax_notice_list.php",

			type: "GET",
			data: param,
			success: function( data ){
				
				console.log( "=====> data: "+ JSON.stringify(data) );
				$("#ajax_list_data").append( data );
		
				$('#table-column-toggle').table('refresh');
				
			//	 $("#ajax_list_data").html(data).trigger("create");
				
				if( data ) G_PAGE++;

			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Ajax failure');
			}
	   });
	}



		// 페이징 더보기
	function setMoreString( cnt, total ){
		//console.log( "=====> ["+cnt+"] ["+total+"] " );
		$("#page_more_string").html( cnt+"/"+total );
	}
</script>


<div data-role="main" class="ui-content">
    <!-- <h2 style="margin:0px;font-size:1.5em">정보목록</h2> -->
 <div class="ui-field-contain">

<form class="ui-filterable">
	<input id="autocomplete-input" data-type="search" placeholder="Search fruits..."  onkeyup="getTransferHistoryList()">
</form>
 <!-- <table data-role="table"   id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
 -->
  <table border="0" width="100%" style="padding-collapse:collapse;">
	              <col width="80%">
				  <col width="20%">	  
				  <thead>
	                <!-- <tr>
	                  <th data-priority="persist">제목</th>
	                  <th data-priority="persist">작성자</th>
	                </tr>
	              </thead> -->
	              <tbody class="slideListBody" id="ajax_list_data">
	              </tbody>
	  </table>

	<button type="button" class="ui-btn ui-btn-w ui-corner-all"  id="btn_submit" onClick="getTransferHistoryList()">더보기(<span id="page_more_string">0/0</span>)</button><!-- -->


  </div>

  </div><!-- data-role="main" -->


<? 
include_once("./foot.php");

?>
