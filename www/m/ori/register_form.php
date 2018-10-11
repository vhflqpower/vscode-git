<? 
$g4_path = ".."; // common.php 의 상대 경로
include_once("$g4_path/common.php");

	$home_active = 'active';

include_once("./head.php");

$member_skin_path = "./member";
?>


<script>
var member_skin_path = ".";
</script>
<!-- <script type="text/javascript" src="<?=$member_skin_path?>/ajax_register_form_m.jquery.js"></script>
 -->
 <!-- <link href="../planer/select2.css" rel="stylesheet"/>
<script src="../planer/js/select2.js"></script> -->
<script>
//$(document).ready(function() { $("#mb_3").select2(); });
</script>

<script>
//var member_skin_path = "<?=$member_skin_path?>";
</script>
<!-- <script type="text/javascript" src="<?=$member_skin_path?>/ajax_register_form.jquery.js"></script>
 -->
<div data-role="page" id="regist_form">
  <div data-role="header">
  <h1><!-- jQuery Mobile Demo -->HANSABU'S</h1>
  </div>



<? 
include_once("./navbar.php");
?>


<div data-role="main" class="ui-content" >
    <h2>한사부 회원가입 <font size="3" color="#ff0000">＊ 필수</font> </h2>

<form name="frm" method="post" action="./register_update_server.php"  onsubmit="return fwrite_submit(this);"/>

<input type=hidden name=w                value="<?=$w?>">
<input type=hidden name=url              value="<?=$urlencode?>">
<input type=hidden name=mb_id_enabled   value="" id="mb_id_enabled">
<input type=hidden name=mb_nick_enabled  value="" id="mb_nick_enabled">
<input type=hidden name=mb_email_enabled value="" id="mb_email_enabled">



 <div class="ui-field-contain">
        <label for="mb_id">아이디</label>
        <input type="text"  id='reg_mb_id' name="mb_id" value="<?=$data['mb_id']?>"  onblur="reg_mb_id_check()"  placeholder="ex) 01074101272">  
		 <span id='msg_mb_id'></span>
<p>      <label for="mb_password">비밀번호<font color="#ff0000">＊</font>  </label>   </p>
        <input type="password"  name="mb_password"  id="mb_password"  placeholder="비밀번호를 입력해 주세요.">
<p>       <label for="mb_password_re">비밀번호 확인<font color="#ff0000">＊</font>  </label>		</p>
        <input type="password" id="" name="mb_password_re"  placeholder="비밀번호를 다시 입력해 주세요.">
      </div>

  <div class="ui-field-contain">
    <label for="name">회원명<font color="#ff0000">＊</font>  </label>
    <input type="text"  id="mb_name" name="mb_name" value="<?=$data['mb_name']?>" placeholder="본인의 이름을 입력해 주세요.">
    </div>
 

  <div class="ui-field-contain">
    <label for="date">생년월일 <font color="#ff0000">＊</font> </label>
    <input type="date" id="mb_birth" name="mb_birth" value="<?=$data['mb_birth']?>" />
  </div>
  
 <div class="ui-field-contain">
        <label for="fullname">핸드폰 <font color="#ff0000">＊</font></label>
        <input type="text" name="mb_hp" id="mb_hp" value="<?=$data['mb_hp']?>" placeholder="ex) 010-0000-0000 / 하이픈(-) 필수">       
      </div>

 <div class="ui-field-contain">    
        <label for="bday">E-MAIL <font color="#ff0000">＊</font></label>
        <input type="text"id='reg_mb_email' name='mb_email'  value="<?=$data['mb_email']?>"  onblur="reg_mb_email_check()" placeholder="ex) request@choijaehoon.kr / 비밀번호 재발급시 사용">
                <span id='msg_mb_email'></span>

      </div>

 <div class="ui-field-contain">
        <label for="email">블로그 또는 개인 홈페이지</label>
        <input type="text" name="mb_homepage" id="mb_homepage" placeholder="blog" value="<?=$data['mb_homepage']?>"  placeholder="ex) blog.naver.com/cjhwed">
      </div>

	<font color="orange"><!-- 추가 정보 입력시 1,000 마일리지 적립 --></font>

      </div>

  
   <div data-role="main" class="ui-content" >
 <button type="button" class="ui-btn ui-btn-b ui-corner-all"  id="btn_submit" onclick="registerSubmit()">가입하기</button>
   <button type="button" class="btn btn-sm btn-default" id="btn_submit"onclick="location.href='./'">취 소</button>
</form>
</div>


<script>


function registerSubmit(){


		var f = document.frm;

		//	reg_mb_id_check();


        if (f.mb_id_enabled.value != 000 || f.reg_mb_id.value == '') {
            alert('아이디는 필수입니다..');
            f.reg_mb_id.focus();
            return false;
        }



        if ($('#mb_id_enabled').val() !=000) {
            alert('회원아이디를 입력하지 않았거나 입력에 오류가 있습니다.');
            document.getElementById('reg_mb_id').select();
            return false;
        }



        if (f.mb_password.value.length < 3) {
            alert('패스워드를 3글자 이상 입력하십시오.');
            f.mb_password.focus();
            return false;
        }

		if (f.mb_password.value != f.mb_password_re.value) {
			alert('패스워드가 같지 않습니다.');
			f.mb_password_re.focus();
			return false;
		}

		if (f.mb_password.value.length > 0) {
			if (f.mb_password_re.value.length < 3) {
				alert('패스워드를 3글자 이상 입력하십시오.');
				f.mb_password_re.focus();
				return false;
			}
		}


        if ($('#mb_email_enabled').val() !=000) {
            alert('E-mail 입력하지 않았거나 입력에 오류가 있습니다.');
            document.getElementById('reg_mb_email').select();
            return false;
        }



        if ($('#mb_hp').val() =='') {
            alert('핸드폰 번호는 필수입니다..');
            document.getElementById('mb_hp').select();
            return false;
        }


		var mb_id = $("#reg_mb_id").val();
		var mb_password = $("#mb_password").val();
		var mb_name = $("#mb_name").val();
		var mb_birth = $("#mb_birth").val();
		var mb_hp = $("#mb_hp").val();
		var mb_email = $("#reg_mb_email").val();
		




		var rows= {

			mb_id : mb_id,
			mb_password : mb_password,
			mb_name : mb_name,
			mb_birth : mb_birth,
			mb_email : mb_email,
			mb_hp : mb_hp,

		};
		
		var postData = $.param(rows);
	//	var postData = $('.inputForm :input').serialize() + '&oper=edit&id=<?=$id?>';
		var url = './register_update_server.php'//url 수정;


		var msg =  '정말 가입 하시겠습니까?';

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

					//alert(msgs1);
					location.href='register_result.php';
					//window.location.reload();

				}
			});
		}

		return;

}









function reg_mb_id_check() {
    $.ajax({
        type: 'POST',
        url: member_skin_path+'/ajax_mb_id_check.php',
        data: {
            'reg_mb_id': encodeURIComponent($('#reg_mb_id').val())
        },
        cache: false,
        async: false,
        success: function(result) {
            var msg = $('#msg_mb_id');
            switch(result) {

                case '110' : msg.html('영문자, 숫자, _ 만 입력하세요.').css('color', 'red'); break;
                case '120' : msg.html('최소 3자이상 입력하세요.').css('color', 'red'); break;
                case '130' : msg.html('이미 사용중인 아이디 입니다.').css('color', 'red'); break;
                case '140' : msg.html('예약어로 사용할 수 없는 아이디 입니다.').css('color', 'red'); break;
                case '000' : msg.html('사용하셔도 좋은 아이디 입니다.').css('color', 'blue'); break;
			   default : ; break; 
			  //  default : alert( '잘못된 접근입니다.\n\n' + result ); break;
            }

			if(result==000){
				 $('#msg_mb_id').html('사용하셔도 좋은 아이디 입니다.').css('color', 'blue');
			}else if(result==130){
				 $('#msg_mb_id').html('이미 사용중인 아이디 입니다.').css('color', 'red');
			}else if(result==110){
				 $('#msg_mb_id').html('영문자, 숫자, _ 만 입력하세요.').css('color', 'red');	
			}else if(result==120){
				 $('#msg_mb_id').html('최소 3자이상 입력하세요.').css('color', 'red');	
			}else if(result==140){
				 $('#msg_mb_id').html('예약어로 사용할 수 없는 아이디 입니다.').css('color', 'red'); 
			
			}

			$('#mb_id_enabled').val(result);
        }
    });
}



function reg_mb_email_check(){
	
	var result = "";
    $.ajax({
        type: "POST",
        url: "./ajax_mb_email_check.php",
        data: {
            "reg_mb_email": $("#reg_mb_email").val(),
            "reg_mb_id": encodeURIComponent($("#reg_mb_id").val())
        },
        cache: false,
        async: false,
        success: function(result) {

            var msg = $('#msg_mb_email');
         
			
			if(result==000){
				 $('#msg_mb_email').html('사용가능 코드.').css('color', 'blue');
			}else if(result==120){
				 $('#msg_mb_email').html('E-mail 형식이 맞지 않습니다.').css('color', 'red');
			}else if(result==130){
				 $('#msg_mb_email').html('이미 사용중인코드.').css('color', 'red');	
			}else if(result==140){
				 $('#msg_mb_email').html('해당 도메인 메일은 사용할 수 없습니다..').css('color', 'red');	
			}else if(result==110){
				 $('#msg_mb_email').html('E-mail을 입력해 주세요').css('color', 'red');				
			}		

			$('#mb_email_enabled').val(result);

		//$("#msg_mb_email").html(data);
		// alert(data);return false;
		//	result = data;
        
		}
    });
}


</script>



<? 
include_once("./foot.php");
?>
