<? 
$g4_path = ".."; // common.php 의 상대 경로
include_once("$g4_path/common.php");


	if($_GET['mb_name'] && $_GET['mb_hp']){

			$mb_hp =  $_GET['mb_hp'];

			$data = sql_fetch("select * from g4_member where  mb_name = '$mb_name' && mb_hp = '$mb_hp'");
	

			if($data['mb_id']){
			$mb_id = $data['mb_id'];
			$mb_hp = $data['mb_hp'];
			$mbId =  '<b>'.$data['mb_id'].'</b>';

			}else{
			$mb_id = $_GET['mb_id'];	
			$mb_hp = $_GET['mb_hp'];		
			$mbId = '<font color=orange>해당 플래너가 존재하지 않습니다.</font>';
			
			}

	}



	$home_active = 'active';


include_once("./head.php");
?>

<div data-role="page" id="pageone">
  <div data-role="header">
   <h1><a href="./" class='menu'>CHOIJAEHOON PLANNERS</a></h1>
  </div>

<? 
include_once("./navbar.php");
?>


<div data-role="main" class="ui-content">
    <h2>아이디 찾기</h2>


<form name="fregister" method="GET"  action="<?=$PHP_SELF?>" autocomplete="off">


  <div class="ui-field-contain">
    <label for="name">플래너명:</label>
    <input type="text"  id="mb_name" name="mb_name" value="<?=$mb_name?>" placeholder="플래너명">
    </div>
    
 <div class="ui-field-contain">
        <label for="fullname">핸드폰</label>
        <input type="text" name="mb_hp" id="mb_hp" value="<?=$mb_hp?>" placeholder="010-0000-0000">   
      </div>




<? if($_GET['mb_name'] && $_GET['mb_hp']){ ?>


 <div class="ui-field-contain">
        <label for="fullname">아이디</label>
        <font color=blue><?=$mbId?></font> 
	<? if($data['mb_id']){ ?>	
		/ 초기비번 <font color=blue>0000</font>  
<? } ?>
      </div>


<? } ?>



<br>
<div align=center>

 <button type="submit" class="ui-btn ui-btn-b ui-corner-all" id="btn_submit" >조회하기</button>
  <button type="button" class="ui-btn ui-btn-a ui-corner-all" id="btn_submit"onclick="location.href='../../'">로그인</button>
  <button type="button" class="ui-btn ui-btn-a ui-corner-all" id="btn_submit"onclick="location.href='./register_agree.php'">회원가입</button>
</div>

</form>

</div>


<script type="text/javascript">
</script>


<? 
include_once("./foot.php");
?>
