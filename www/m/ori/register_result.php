<? 
$g4_path = ".."; // common.php 의 상대 경로
include_once("$g4_path/common.php");

	$home_active = 'active';

include_once("./head.php");
?>

<div data-role="page" id="pageone">
  <div data-role="header">
   <h1><a href="./" class='menu'>HANSABU CROSSFIT</a></h1>
  </div>

<? 
include_once("./navbar.php");
?>


<div data-role="main" class="ui-content">
    <h2>한사부 마샬라츠 가입완료</h2>

  <div class="ui-field-contain">
    <!-- <label for="date">생년월일:</label> -->
    <font color="orange">한사부 마샬라츠 가입을 축합니다.</font>
  </div>
  <button type="button" class="btn btn-sm btn-default" id="btn_cancle" onclick="location.href='./login.php'">로그인하기</button>

</div>
</form>


<script type="text/javascript">
</script>


<? 
include_once("./foot.php");
?>
