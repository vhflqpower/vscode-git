<? 
include_once('./common.php');


$now_page = "index";

include_once(G5_PATH."/theme/offcanvas/head.php"); 

?>


        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
          </p>
          <div class="jumbotron">
            <h1>Hello, M.T.A World!</h1>
            <p>This is an example to show the potential of an offcanvas layout pattern in Bootstrap. Try some responsive-range viewport sizes to see it in action.</p>
          </div>
      
	
	 <div class="row">
            <!-- <div class="col-xs-6 col-lg-4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div>
            <div class="col-xs-6 col-lg-4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div>
            <div class="col-xs-6 col-lg-4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div> -->
            <!-- <div class="col-xs-6 col-lg-4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div>
            <div class="col-xs-6 col-lg-4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div>
            <div class="col-xs-6 col-lg-4">
              <h2>Heading</h2>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
            </div> -->
          </div>
	<!--/row-->







	<form name="frm" method="get" action="<?=$PHP_SELF?>" >
		<input type="hidden" name="ms_part" id="ms_part" value="<?=$_GET[part]?>">
		<p style="text-align:left;margin:5px 0 5px 0;"><a href="/board/list.php?bo_table=schedule">스터디 일정</a></p>
		<p style="text-align:center;margin:5px 0 5px 0;">
		<span class="button white"><a href="#" onclick="javascript:goSearch('prev');">이전</a></span>
             <input type="text" name="at_year" id="at_year" value="<?echo date("Y")?>" style="width:50px;font-weight:bold;border:0px;text-align:center;" />
		    <input type="text" name="at_month" id="at_month"  value="<?echo sprintf("%02d",date("m"))?>" style="width:30px;font-weight:bold;border:0px">
       		 
			<span class="button white"><a href="#" onclick="javascript:goSearch('next');">다음</a></span>
		</p>
			</form>
	<!--##### 스케쥴AJAX S #####--> 
			<div id="results" class="abc"></div>
	<!--##### 스케쥴AJAXE E #####--> 

			



        </div><!--/.col-xs-12.col-sm-9-->




	<? include_once(G5_PATH."/theme/offcanvas/sidebar.php"); ?>
	  


	<? include_once(G5_PATH."/theme/offcanvas/tail.php"); ?>


<script language="JavaScript" type="text/javascript">
			function goto_page(href) {
	
				var xmlhttp =GetXmlHttpObject();
				if (xmlhttp ==null) {
					alert ("Your browser does not support AJAX!");
					return;
				}
				var url="ajax_study_calender.php";
				url=url+"?"+href;
			
				xmlhttp.onreadystatechange=function() {
					if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete") {
						document.getElementById('results').innerHTML=xmlhttp.responseText;
					}
				}
				xmlhttp.open("GET",url,true);
				xmlhttp.send(null);
			}
			 


		function GetXmlHttpObject() {
				var xmlhttp=null;
				try {
					// Firefox, Opera 8.0+, Safari
					xmlhttp=new XMLHttpRequest();
				}
				catch (e) {
					// Internet Explorer
					try {
						xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
					}
					catch (e) {
						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
					}
				}
				return xmlhttp;
			}



		function goSearch(id){

				fm = document.frm;
			//	at_year = fm.at_year.value;
				at_year = $('#at_year').val();
				at_month = $('#at_month').val();
				var pass = id;
				if(pass=='next'){
				var at_month = Number(at_month) + 1;
				if(at_month > '12'){				
				var at_year = Number(at_year) + 1;
				var at_month =  1;
				}
				}else if(pass=='prev'){
				var at_month = Number(at_month) - 1;
				if(at_month < '1'){				
				var at_year = Number(at_year) - 1;
				var at_month =  12;
				}
				}

				part = $('#ms_part').val();

				if(!at_month) { alert('검색어를 입력하세요'); return;}
			//	var m_id = document.getElementById("m_id").value;
				goto_page('at_year='+at_year+'&at_month='+at_month+'&ms_part='+part)
					
				at_year = $('#at_year').val(at_year);
				at_month = $('#at_month').val(at_month);

				}


			</script>

		<script>goSearch();</script>

