<?
$app = "../"; // common.php 의 상대 경로
include_once($app ."/common.php");

include_once(G5_PATH."/theme/offcanvas/head.php");

//	include_once("./head.php");
//	include_once("./nav.php");

?>

 <div class="row row-offcanvas row-offcanvas-right">

       <div class="main"><!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
         <!-- <h1 class="page-header">Dashboard</h1> -->

          <h2 class="sub-header">마이페이지</h2>
		  <hr>

          <div class="col-xs-12 col-sm-9">

    <div class="container" style="width:370px;margin-top:50px;">

      <form class="form-signin" name="frm" method="post" action="./mypage_pw_check_exe.php">

        <h5 class="form-signin-heading">회원님의 정보보호를 위해 비밀번호를 입력 해주세요.</h5>
                <input type="text" id="input_id" name="input_id" value="<?=$member['mb_id']?>" class="form-control top" READONLY>
                <input type="password" id="input_pw" name="input_pw" value="" placeholder="사용자 패스워드" class="form-control bottom">
        <div style="height:20px;">

        </div>
        <button class="btn btn-lg btn-primary btn-block" onclick="saveSubmit()">확인</button>
      </form>

    </div> <!-- /container -->



	<div style="height:70px;"></div>

		  <!-- table-responsive -->
       
	 </div><!--col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->


      </div>    <!-- row -->
   </div>  <!-- row row-offcanvas row-offcanvas-right -->


<?
	//include_once("./footer.php");
?>


<script type="text/javascript">


$(document).ready(function(){

  $("#input_pw").focus();
});

function saveSubmit() {

	var mb_password = $("#input_pw").val();

if(!mb_password){
		alert("비밀번호를 확인해주세요.");
		$('#input_pw').focus();
		return false;
	}
document.frm.submit();
}




</script>



<?
	include_once(G5_PATH."/theme/offcanvas/tail.php");

?>
