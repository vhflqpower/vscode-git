<?

include_once("./_common.php");


	if($_COOKIE["cookie_id"]) { $checked = "checked"; }else{ $checked = "";}


	$app[path] = '';

	include_once(G5_PATH."/theme/offcanvas/head.php");

?>

    <link href="./signin.css" rel="stylesheet">
    <!-- <script src="../../assets/js/ie-emulation-modes-warning.js"></script> -->


    <div class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo G5_URL ?>/assets/js/ie10-viewport-bug-workaround.js"></script>
 <script>
/*
	$(function(){
		$('#input_id').focus();
	 });
*/

$(document).ready(function(){
  $("#input_id").focus();
});



/*
$(function(){

	$('#input_id').focus();


	$('#admin_login').submit(function() {


		if ($.trim($('#input_id').val())=='')
		{
			alert('아이디를 입력해주세요');
			$('#input_id').select();
			return false;
		}

		if ($.trim($('#input_pw').val())=='')
		{
			alert('비밀번호를 입력해주세요');
			$('#input_pw').select();
			return false;

		}

		var dataString = $('#admin_login').serialize();

		$.ajax({
			type:'POST',
			url:'./login_check.php',
			data:dataString,
			dataType:'json',
			success:function(data) {

				if (data.flag=='succ') {
					location.replace('/');				
				} else {
					$('#input_pw').select();
					alert(data.message);
				}

			}
		});

		return false;

	});


});
*/

 </script>




    <!--jQuery -->
    <script src="<?php echo G5_URL ?>/assets/lib/jquery/jquery.js"></script>

    <!--Bootstrap -->
    <script src="<?php echo G5_URL ?>/assets/lib/bootstrap/js/bootstrap.js"></script>


    <script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                $('.list-inline li > a').click(function() {
                    var activeForm = $(this).attr('href') + ' > form';
                    //console.log(activeForm);
                    $(activeForm).addClass('animated fadeIn');
                    //set timer to 1 seconds, after that, unload the animate animation
                    setTimeout(function() {
                        $(activeForm).removeClass('animated fadeIn');
                    }, 1000);
                });
            });
        })(jQuery);
    </script>

<?
	include_once(G5_PATH."/theme/offcanvas/tail.php");

?>