<?
include_once("./_common.php");
?>

<script src="./js/jquery.sortable.js"></script>

	<!-- <script type="text/javascript" src="./js/jquery-1.5.1.js"></script>
	<script type="text/javascript" src="./js/jquery-ui-1.8.11.custom.min.js"></script>
 -->
<script>

/*
	  $(function() {
	    $( ".row_position" ).sortable({
	        delay: 150,
	        change: function() {
	    var selectedLanguage = new Array();
	    $('.row_position>ul').each(function() {
	    selectedLanguage.push($(this).attr("id"));
	    });

			alert(selectedLanguage)
	      document.getElementById("row_order").value = selectedLanguage;
	    }
	   
	    });
	  });

*/

		$(document).ready(function() {

			$(".row_position").sortable({
				change : function () {
					alert()
				
				}
			});
		});


		  function save() { 
			var data = new Array();
			$('.row_position ul').each(function() {
			   data.push($(this).attr("id"));
			});
			
			$.ajax({
				url:"./myplan_sort_proc.php",
				type:'post',
				data:{position:data},
				success:function(){
			     alert('your change successfully saved');
				}
			})
		  }



		$(function() {
            $('.thumbnail-sortable').sortable({
                placeholderClass: 'col-sm-6 col-md-4'
            });

            $('.table-sortable2 tbody').sortable({
                handle: 'span'
            });

            $('.table-sortable tbody').sortable({
                handle: 'span'
            });
            $('.list-group-sortable').sortable({
                placeholderClass: 'list-group-item'
            });
            $('.list-group-sortable-exclude').sortable({
                placeholderClass: 'list-group-item',
                items: ':not(.disabled)'
            });
            $('.list-group-sortable-handles').sortable({
                placeholderClass: 'list-group-item',
                handle: 'span'
            });
            $('.list-group-sortable-connected').sortable({
                placeholderClass: 'list-group-item',
                connectWith: '.connected'
            });
		});
	


	  
</script>
<style>
		.row_position{
			list-style:none;
			margin:0px;
			padding:0px;
			border:solid 0px #EBEBEB;
		}
		.row_position li{
			padding:4px;
			color:#000;
			margin:4px 0;
			font-size:12px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border-radius: 5px;
			border:2px solid #CCCCFF;
		}
		.row_position li span{
			margin-right:5px;
			position:relative;
			top:2px;
			cursor:move;
		}
</style>

 <div style="border:0px solid #ccc;padding:10px;" class="row_position">	

	<?
	$arr_color[1] = 'success';
	$arr_color[2] = 'warning';
	$arr_color[3] = 'danger';

	 $i = 1;
	$query=sql_query($query = "SELECT  * FROM psj_plan where   pn_end_yn ='N'  and mb_id = '$member[mb_id]' ".$where." ORDER BY pn_no ASC");
	$total_count = sql_num_rows($query);
	while($row=sql_fetch_array($query)){


		$grade = $row['pn_grade'];
		$color = $arr_color[$grade];

	?>
		<ul class="alert alert-<?=$color?>" role="alert" style="padding:10px;"  id="<?=$row['pn_id']?>">
			  <a href="#" class="alert-link" ><?=$row['pn_subject']?></a> 
			   <a href="#1" onclick="editPlan(<?=$row['pn_id']?>)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
		</ul>
	<? 
		$i++;
	 } 
	 ?>
	 <?
	 	if($total_count < 1){
	?>
			<ul class="alert alert-default" role="alert" style="padding:5px;text-align:center;"  id="<?=$row['pn_id']?>">
			  <a href="#" class="alert-link">등록된 할일이 없습니다.</a>  
		</ul>
	 
	<? } ?>
	 </div>
