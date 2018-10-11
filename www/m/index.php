<? 
include_once("./_common.php");


	if(!$member[mb_id]){
		echo "<script>location.href='./login.php';</script>";
	}


include_once("./head.php");
?>

<div data-role="page" id="pageone">
  <div data-role="header">
  <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a> 
   <h1><a href="./" class='menu'>M.T.A 엠티에이</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>

<? 
include_once("./navbar.php");
?>

<div data-role="main" class="ui-content" id="index">
    <h2>M.T.A 엠티에이</h2>

 <ul data-role="listview" data-inset="true">
      <li>
        <a href="./attendent_add.php">
		 <img src="./img/last_time_icon.jpg" width="130px;">
        <!-- <img src="./img/chrome.png"> -->
        <h2>수업예약</h2>
        <p><!-- Google Chrome is a free, open-source web browser. Released in 2008. --></p>
        </a>
      </li>
      <li>
        <a href="#1" onclick="('준비중입니다.')">
         <img src="./img/photo_hold_icon.jpg" width="130px;">
		<!-- <img src="./img/firefox.png"> -->
        <h2>행사일정보기</h2>
        <p><!-- Firefox is a web browser from Mozilla. Released in 2004. --></p>
        </a>
      </li>
      <li>
        <a href="./my_info_f.php">
        <img src="./img/planeer_info_icon.jpg" width="130px;">
        <h2>내 정보</h2>
        <p><!-- Firefox is a web browser from Mozilla. Released in 2004. --></p>
        </a>
      </li>

      <li>
        <a href="./mileage.php">
        <img src="./img/mileage_icon.jpg" width="130px;">
        <h2>마일리지</h2>
        <p><!-- Firefox is a web browser from Mozilla. Released in 2004. --></p>
        </a>
      </li>


    </ul>
 

	</div><!-- data-role="main" -->


<? 
include_once("./foot.php");
?>



