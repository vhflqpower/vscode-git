
<!-- ### jquery grid  API ### -->	
	<link rel="stylesheet" type="text/css" href="<?=$now_path?>/css/jqgrid/ui.jqgrid.css" /> 
	<link rel="stylesheet" type="text/css" href="<?=$now_path?>/css/jqgrid/ui.multiselect.css" />
	<script type="text/JavaScript" src="<?=$now_path?>/js/jquery-1.7.2.min.js"></script>
	<script type="text/JavaScript" src="<?=$now_path?>/js/jqgrid/jquery-ui.min.js"></script>
	<script type="text/JavaScript" src="<?=$now_path?>/js/jqgrid/ui.multiselect.js"></script>
	<script type="text/JavaScript" src="<?=$now_path?>/js/jqgrid/i18n/grid.locale-kr.js"></script>
	<script type="text/JavaScript" src="<?=$now_path?>/js/jqgrid/jquery.jqGrid.min.js"></script>
	 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/jquery-ui.min.js"></script>
	 <script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.22/jquery-ui.js"></script>	
	<!-- <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.4/themes/blue/jquery-ui.css" rel="stylesheet" /> -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?=$now_path?>/css/jqgrid/redmond/jquery-ui.css" />
	<!-- <link rel="stylesheet" type="text/css" media="screen" href="<?=$now_path?>/css/jqgrid/ui-lightness/jquery-ui.css" />	 -->
    <link rel="Stylesheet" href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10/themes/redmond/jquery-ui.css" />

	<script>

         $(document).ready(function(){
            $('search_value').focus();
            $("#search_value").bind("keydown", function(e) {
                if (e.keyCode == 13) { // enter key
                   	search('#searchForm');
                    return false
                }
            });
        });

         $(document).ready(function(){
            $('search_value2').focus();
            $("#search_value2").bind("keydown", function(e) {
                if (e.keyCode == 13) { // enter key
                   	search2('#searchForm2');
                    return false
                }
            });
        });


</script>
<style>
 caption{ font-size:12px;padding:3px;background-color:#ebebeb;}
 th{ font-size:12px;padding:3px;background-color:#ebebeb;}


.ui-datepicker { font:12px dotum; }
.ui-datepicker select.ui-datepicker-month, 
.ui-datepicker select.ui-datepicker-year { width: 70px;}
.ui-datepicker-trigger { margin:0 0 -5px 2px; }

</style>
