<? 
include_once("./_common.php");


/*
	if($_GET['mb_name'] && $_GET['mb_hp']){

			$mb_hp =  $_GET['mb_hp'];

			$data = sql_fetch("select * from psj_member where  mb_name = '$mb_name' && mb_hp = '$mb_hp'");
	

			if($data['mb_id']){
			$mb_id = $data['mb_id'];
			$mb_hp = $data['mb_hp'];
			$mbId =  '<b>'.$data['mb_id'].'</b>';

			}else{
			$mb_id = $_GET['mb_id'];	
			$mb_hp = $_GET['mb_hp'];		
			$mbId = '<font color=orange>해당  회원이 존재하지 않습니다.</font>';
			
			}

	}
	*/



	$home_active = 'active';


include_once("./head.php");
?>

<div data-role="page" id="login">
  <div data-role="header">
   <h1><a href="./" class='menu'>HANSABU GYM</a></h1>
  </div>

<? 
include_once("./navbar.php");
?>


<div data-role="main" class="ui-content">
    <h2>LOGIN</h2>


<form id="callAjaxForm">
  <div class="ui-field-contain">
    <label for="name">회원NO:</label>
    <input type="text"  id="mb_id" name="mb_id" value="<?=$mb_id?>" placeholder="회원ID">
    </div>
    
	 <div class="ui-field-contain">
        <label for="fullname">비밀번호</label>
        <input type="text" name="mb_pwd" id="mb_pwd" value="<?=$mb_hp?>" placeholder="비밀번호">   
      </div>


	<? if($_GET['mb_name'] && $_GET['mb_hp']){ ?>

	 <div class="ui-field-contain">
			<label for="fullname">아이디</label>
			<font color=blue><?=$mbId?></font> 
		<? if($data['mb_id']){ ?>	
			/ 초기비번 <font color=blue>4321</font>  
	<? } ?>
		  </div>


	<? } ?>


<br>
<div align=center>
<!-- type="submit" -->
 <button  class="btn btn-sm btn-primary" id="submit" >확인하기</button>
  <button type="button" class="btn btn-sm btn-default" id="btn_submit"onclick="location.href='../../'">취 소</button>
</div>

</form>

</div>


<script type="text/javascript">


        function onSuccess(data, status)
        {
            data = $.trim(data);
            $("#notification").text(data);
        }
  
        function onError(data, status)
        {
            // handle an error
        }        
  
        $(document).ready(function() {
            $("#submit").click(function(){
  
                var formData = $("#callAjaxForm").serialize();
  
                $.ajax({
                    type: "POST",
                    url: "login_check.php",
                    cache: false,
                    data: formData,
                    error: onError,

				success:function(response) {
				var success = (response.flag == 'succ');
				var message = response.message;
				var new_id = response.id;
				var msgs1 = response.msg1;
				
				
				location.href='./index.php';
				//window.location.reload();

			}


//                     success: onSuccess,



                });
  
                return false;
            });
        });





 function fwrite_submit(f){


	if(f.mb_cd.value==''){
	alert('회원 번호는 필수입니다.');
	 f.mb_cd.focus();
	return false;
	}


	if(f.mb_pwd.value==''){
	alert('비번은 필수입니다.');
	 f.mb_pwd.focus();
	return false;
	}


		f.action = './login_check.php';
		//document.fregister.submit();

}




function scheduleSubmit(f){


	//var f = document.frm;

	var mb_cd =  $('#mb_cd').val();
	var mb_pwd = $('#mb_pwd').val();


/*

		to_date : to_date,
		sche_time : sche_time,
		photo_price : photo_price,
        cm_wname : cm_wname,

*/

	var rows= {

		mb_cd : mb_cd,
		mb_pwd : mb_pwd,

	};
	
	var postData = $.param(rows);
//	var postData = $('.inputForm :input').serialize() + '&oper=edit&id=<?=$id?>';
	var url = './login_check.php'//url 수정;


	var msg =  '로그인 하시겠습니까?';

	if(confirm(msg)) {

		$.ajax({
			url:url,
			data: postData,
			type:'post',
			dataType:'json',
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			cache:false,
			success:function(response) {
				var success = (response.flag == 'succ');
				var message = response.message;
				var new_id = response.id;
				var msgs1 = response.msg1;
				var msgs2 = response.msg2;
				
				//alert(msgs1+'\n'+msgs2);
					alert(2);
				//window.location.reload();

			}
		});
	}

	return;

}

// http://www.giantflyingsaucer.com/blog/?p=2574






</script>


<? 
include_once("./foot.php");
?>
