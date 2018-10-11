<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!-- Include meta tag to ensure proper rendering and touch zooming -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Include jQuery Mobile stylesheets -->
  <!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css"> -->
  <link rel="stylesheet" href="./css/jquery.mobile-1.4.5.min.css">
  <!-- Include the jQuery library -->
  <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
  <!-- Include the jQuery Mobile library -->
  <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<!-- <script src="./index.js"></script> -->
<script >

$(document).bind( "mobileinit", function(){
 $.mobile.page.prototype.options.addBackBtn=true;
});


//var mb_level = '<?=$member[mb_level]?>';
/*
$(document).on("pagebeforecreate",function(event){
	var mode = '<?=$mode?>';
	var mb_level = '<?=$member[mb_level]?>';

}); 


*/


$(document).on('pageinit', '#index' ,function(){
	 var mb_id = '<?=$member[mb_id]?>';

		$.mobile.changePage("./index.php");


});



$(document).on('pageinit', '#attdent_add' ,function(){
	 var mb_id = '<?=$member[mb_id]?>';
	if(!mb_id){
		$.mobile.changePage("./login.php");
	}

});



 // $("#backBtn").bind("click",function(){
      //  $.mobile.changePage( "#page1", { transition: "flip", changeHash: false });
   // });



/*
$(document).on('pageinit', '#notice_list' ,function(){
	 
	$.mobile.changePage("./notice_list.php");

});
*/


function changePage(){
	$.mobile.changePage("./notice_list.php",{transition:"slide",reverse:true});

}


$(document).on('pageinit', '#one' ,function(){

	 var mb_id = '<?=$member[mb_id]?>';
	//if(!mb_id){
	//	$.mobile.changePage("./login.php");
	//}
	$.mobile.changePage("./notice_view.php");

});



$(document).on('pageinit', '#my_info' ,function(){

	 var mb_id = '<?=$member[mb_id]?>';
			
	if(!mb_id){
	//	$.mobile.changePage("./login.php");
		$.mobile.changePage("./login.php");
	}
});

$(document).on('pageinit', '#my_info_first' ,function(){

	//	alert('welcome');
		$.mobile.changePage("./my_info.php");
		//window.location.reload();


});


$(document).on('pageinit', '#login' ,function(){

	//	alert('welcome');
		$.mobile.changePage("./login.php");
		//window.location.reload();


});




$(document).on('pageinit', '#regist_first' ,function(){
	
		//location.href='./register_form.php';
		$.mobile.changePage("./register_form.php");

});


$(document).on('pageinit', '#my_mileage' ,function(){
	
	 var mb_id = '<?=$member[mb_id]?>';
			
	if(!mb_id){
	//	$.mobile.changePage("./login.php");
		$.mobile.changePage("./login.php");
	}else{
		$.mobile.changePage("./my_mileage.php");
	}
});

</script> 
<style>
a:link, a:visited, a:active { text-decoration:none; color:#466C8A; }
a.menu:hover { text-decoration:none; }
</style>
<link rel="stylesheet" href="./static/css/common.css">
<link rel="stylesheet" href="./static/css/component.css">
<link rel="stylesheet" href="./static/css/content.css?v=1">

 <link rel="stylesheet" href="./table.css">
</head>
<body> 

