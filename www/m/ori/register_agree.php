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
    <h2>개인정보 수집동의</h2>

<form name="fregister" method="POST" autocomplete="off">
<!-- <textarea style="width: 98%;height:100px;" rows=10 readonly ></textarea> -->
			 <textarea rows="10" name="textarea-11" id="textarea-1" class="foo" style="overflow:auto"></textarea>
			
			<b>개인정보수집동의</b>
              <input type=radio value=1 name=agree id=agree11><label for=agree11>동의합니다.</label>
              <input type=radio value=0 name=agree id=agree10><label for=agree10>동의하지 않습니다.</label>
           <b>개인정보취급방침</b>
		   
		   <textarea style="width: 98%" rows=10 readonly class="form-control"><?//=get_text($config[cf_privacy])?></textarea>

            <!-- <textarea rows="9" name="textarea-12" id="textarea-2" class="foo" style="overflow:auto"></textarea> -->

		   
		   <input type=radio value=1 name=agree2 id=agree21><label for=agree21>동의합니다.</label>
            <input type=radio value=0 name=agree2 id=agree20><label for=agree20>동의하지 않습니다</label>
           
</div>

<div data-role="main" class="ui-content" >
 <button type="button" class="ui-btn ui-btn-b ui-corner-all"  id="btn_submit" onclick="agree_submit()">확인</button>
   <button type="button" class="btn btn-sm btn-default" id="btn_submit"onclick="location.href='./'">취 소</button>
</div>

</form>


<script type="text/javascript">
function agree_submit() 
{

	var f = document.fregister;

    var agree1 = document.getElementsByName("agree");
    if (!agree1[0].checked) {
        alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree1[0].focus();
        return false;
    }

    var agree2 = document.getElementsByName("agree2");
    if (!agree2[0].checked) {
        alert("개인정보취급방침의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
        agree2[0].focus();
        return false;
    }

    f.action = "./regist_secound.php";
    document.fregister.submit();
	return true;
}

if (typeof(document.fregister.mb_name) != "undefined")
    document.fregister.mb_name.focus();

/*
setTimeout(function () {
    //$('.foo').addClass('bar');
    $('.foo').css({
        'height': 'auto'
    });
}, 100);
*/
</script>


<? 
include_once("./foot.php");
?>
