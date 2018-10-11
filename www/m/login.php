<?
include_once("./_common.php");

	if($_COOKIE["cookie_id"]) { $checked = "checked"; }else{ $checked = "";}


	$app[path] ="../hansabu";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login Page</title>
    
    <meta name="description" content="Free Admin Template Based On Twitter Bootstrap 3.x">
    <meta name="author" content="">
    
    <meta name="msapplication-TileColor" content="#5bc0de" />
    <meta name="msapplication-TileImage" content="assets/img/metis-tile.png" />
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="./assets/lib/bootstrap/css/bootstrap.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/lib/font-awesome/css/font-awesome.css">
    
    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="./assets/css/main.css">
    
    <!-- metisMenu stylesheet -->
    <link rel="stylesheet" href="./assets/lib/metismenu/metisMenu.css">
    
    <!-- animate.css stylesheet -->
    <link rel="stylesheet" href="./assets/lib/animate.css/animate.css">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  <script type="text/JavaScript" src="./js/jquery-1.7.2.min.js"></script>
</head>

<body class="login">
      <div class="form-signin">
    <div class="text-center">
	<h3>MTA LOGIN</h3>
	<!-- <img src="../img/add/interpass_login_logo2.png" alt="Metis Logo"> --></div>
    <hr>
    <div class="tab-content">
        <div id="login" class="tab-pane active">
            <form name="frm1" method="post" action="/m/login_check.php">
                <p class="text-muted text-center">
                    <!-- Enter your username and password -->
                </p>
                <input type="text" id="mb_id" name="mb_id" value="<?=$_COOKIE['cookie_id']?>" placeholder="사용자 아이디" class="form-control top">
                <input type="password" id="mb_pwd" name="mb_pwd" placeholder="사용자 패스워드" class="form-control bottom">
                <div class="checkbox">
		  <label>
		    <input type="checkbox" name="remember_id" value="1" <?=$checked?>> 아이디 저장하기
		  </label>
		</div>
                <button class="btn btn-lg btn-primary btn-block" type="submit"><!-- Sign in -->로그인</button>
           
        </div>
        <div id="forgot" class="tab-pane">

                <p class="text-muted text-center">Enter your valid e-mail</p>
                <input type="email" placeholder="mail@domain.com" class="form-control">
                <br>
                <button class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
           
        </div>
        <div id="signup" class="tab-pane">

                <input type="text" placeholder="username" class="form-control top">
                <input type="email" placeholder="mail@domain.com" class="form-control middle">
                <input type="password" placeholder="password" class="form-control middle">
                <input type="password" placeholder="re-password" class="form-control bottom">
                <button class="btn btn-lg btn-success btn-block" type="submit">Register</button>
           
        </div>
    </div>
    <hr>
    <div class="text-center">

<ul class="list-inline">
            <li><a class="text-muted" href="./register_agree.php" data-toggle="tab">회원가입</a></li>
        </ul>


        <!-- <ul class="list-inline">
            <li><a class="text-muted" href="#login" data-toggle="tab">Login</a></li>
            <li><a class="text-muted" href="#forgot" data-toggle="tab">Forgot Password</a></li>
            <li><a class="text-muted" href="#signup" data-toggle="tab">Signup</a></li>
        </ul> -->
    </div>
  </div>

</form>



 <script>
	
	$(function(){
		$('#mb_id').focus();
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
    <script src="assets/lib/jquery/jquery.js"></script>

    <!--Bootstrap -->
    <script src="assets/lib/bootstrap/js/bootstrap.js"></script>


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
</body>

</html>
