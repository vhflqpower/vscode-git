
<!-- jqgrid 리사이즈 스크립트 -->
	<script type="text/javascript">
	
			/*
			 * @param string grid_id 사이즈를 변경할 그리드의 아이디
			 * @param string div_id 그리드의 사이즈의 기준을 제시할 div 의 아이디
			 * @param string width 그리드의 초기화 width 사이즈
			 */

	// 새로고침시 적용
			$(window).bind('resize', function() {

			 var gridWidth = window.innerWidth;
			 $("#<?=$grid_div?>").setGridWidth(gridWidth);

			}).trigger('resize');

			 
			$(window).bind('resize', function() {
			 
		//	 gridWidth = window.innerWidth;      // 윈도우 넓이
		 var gridWidth = $('.grid_warp').width();  // div 넓이


			 $("#<?=$grid_div?>").setGridWidth( gridWidth );
			 $(".ui-jqgrid-htable").css("width", gridWidth);
			 $(".ui-jqgrid-btable").css("width", gridWidth );
			}).trigger('resize');
	

	
function resizeJqGridWidth(grid_id, div_id, width){

		$(window).bind('resize', function() {
	
			$('#' + grid_id).setGridWidth(width, true);
			$('#' + grid_id).setGridWidth($('#' + div_id).width() , true); //Resized to new width as per window



		  var height = $(window).height();
			  height = height - 390;
			$('.ui-jqgrid-bdiv').height(height);

		 }).trigger('resize');

		 location.replace();
	}

	resizeJqGridWidth('<?=$grid?>', '<?=$grid_div?>', '100%');

	</script> 		