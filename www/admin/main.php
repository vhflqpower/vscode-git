<?
	include_once("./_common.php");


	include_once("./head.php");

?>


	<?
		include_once("./nav.php");
	?>

    <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
          <!-- <h1 class="page-header">Dashboard</h1> -->
	 <?

	?>
          <!-- <h2 class="sub-header">메인MAIN</h2> -->

                <div class="page-header">
                    <h1>M.T.A INFO WORLD</h1>
                </div>
                <div class="row">


		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script> 
		<script src="./Chartjs/samples/utils.js"></script>

	<!-- <div id="canvas-holder" style="width:60%">
		<canvas id="chart-area"></canvas>
	</div>
	<button id="randomizeData">Randomize Data</button>
	<button id="addDataset">Add Dataset</button>
	<button id="removeDataset">Remove Dataset</button> -->
	<script>
		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
						window.chartColors.blue,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Red',
					'Orange',
					'Yellow',
					'Green',
					'Blue'
				]
			},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function() {
			config.data.datasets.forEach(function(dataset) {
				dataset.data = dataset.data.map(function() {
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function() {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset ' + config.data.datasets.length,
			};

			for (var index = 0; index < config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());

				var colorName = colorNames[index % colorNames.length];
				var newColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}

			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0, 1);
			window.myPie.update();
		});
	</script>


<style>
	canvas{
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>

	<div style="width:60%;">
		<canvas id="canvas"></canvas>
	</div>
	<script>
		var config = {
			type: 'line',
			data: {
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets: [{
					label: 'Unfilled',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
				}, {
					label: 'Dashed',
					fill: false,
					backgroundColor: window.chartColors.green,
					borderColor: window.chartColors.green,
					borderDash: [5, 5],
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
				}, {
					label: 'Filled',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					fill: true,
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Chart.js Line Chart'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						}
					}]
				}
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myLine = new Chart(ctx, config);
		};
	</script>








                    <!-- <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="./issu_list.php?part=issu">최근이슈</a></h3>
                            </div>

		           <div class="panel-body">
			<?
			$arr_issu = latest_notice("is_id","is_subject","psj_issu","order by is_id desc limit 5");
			  foreach($arr_issu as $key => $val){
			?>
				 
			  <ul><li><a href="./issu_view.php?is_id=<?=$key?>&part=issu"><?=$val?></a></li></ul>
				
			<?
			}
			?>         
			</div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="./project_list.php?part=project">프로젝트</a></h3>
                            </div>
                            <div class="panel-body">
			<?
			$arr_project = latest_notice("pj_id","pj_subject","psj_project","order by pj_id desc limit 5");
			  foreach($arr_project as $key => $val){
			?>
				 
			  <ul><li><a href="./project_view.php?pj_id=<?=$key?>&part=project"><?=$val?></a></li></ul>
				
			<?
			}
			?>         
                            </div>
                        </div>
                    </div> -->
                    <!-- /.col-sm-4 -->
                    <!-- <div class="col-sm-4">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="./board_list.php?part=info">최신정보</a></h3>
                            </div>
                            <div class="panel-body">
			<?
			$arr_info = latest_notice("wr_id","wr_subject","psj_board","order by wr_id desc limit 5");
			  foreach($arr_info as $key => $val){
			?>
				 
			  <ul><li><a href="./board_view.php?wr_id=<?=$key?>&part=info"><?=$val?></a></li></ul>
				
			<?
			}
			?>           
			</div>

                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="./account_list.php?part=account">계정목록</a></h3>
                            </div>
                            <div class="panel-body">
			<?
			$arr_info = latest_notice("wr_id","wr_subject","psj_account","order by wr_id desc limit 5");
			  foreach($arr_info as $key => $val){
			?>
			  <ul><li><a href="./account_view.php?wr_id=<?=$key?>&part=account"><?=$val?></a></li></ul>
				
			<?
			}
			?>          
                            </div>
                        </div>
                    </div> -->
                    <!-- /.col-sm-4 -->
                    <!-- <div class="col-sm-4">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="./company_list.php?part=company">업체정보</a></h3>
                            </div>
                            <div class="panel-body">
			<?
			$arr_company = latest_notice("co_id","co_name","psj_company","order by co_id desc limit 5");
			  foreach($arr_company as $key => $val){
			?>
			  <ul><li><a href="./company_view.php?co_id=<?=$key?>&part=company"><?=$val?></a></li></ul>
				
			<?
			}
			?>          
                            </div>
                        </div>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">최근로그인</h3>
                            </div>
                            <div class="panel-body">
				<?
				$arr_visit = latest_notice("mb_id","lo_datetime","psj_login","order by lo_datetime desc limit 5");
				  foreach($arr_visit as $key => $val){
				?>
				  <ul><li>[ <font color="#0000ff"><?=$key?></font> ] <?=$val?></li></ul>
					
				<?
				}
				?>          
                            </div>
                        </div>
                    </div>

                </div>
 -->

	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->



     </div>    <!-- row -->





   </div>  <!-- container-fluid -->




<?
	include_once("./footer.php");
?>


<?
	include_once("./tail.php");
?>
