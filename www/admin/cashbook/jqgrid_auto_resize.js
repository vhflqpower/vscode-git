
<!-- jqgrid �������� ��ũ��Ʈ -->
	<script type="text/javascript">
	
			/*
			 * @param string grid_id ����� ������ �׸����� ���̵�
			 * @param string div_id �׸����� �������� ������ ������ div �� ���̵�
			 * @param string width �׸����� �ʱ�ȭ width ������
			 */

	// ���ΰ�ħ�� ����
			$(window).bind('resize', function() {

			 var gridWidth = window.innerWidth;
			 $("#<?=$grid_div?>").setGridWidth(gridWidth);

			}).trigger('resize');

			 
			$(window).bind('resize', function() {
			 
		//	 gridWidth = window.innerWidth;      // ������ ����
		 var gridWidth = $('.grid_warp').width();  // div ����


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