<? 
$g4_path = ".."; // common.php 의 상대 경로
include_once("$g4_path/common.php");
$home_active = 'active';
include_once("./head.php");
$member_skin_path = "$g4[path]/skin/member/basic";
?>


<script>
var member_skin_path = "<?=$member_skin_path?>";
</script>
<script type="text/javascript" src="<?=$member_skin_path?>/ajax_register_form_m.jquery.js?tsp=20160704"></script>
<link href="../planer/select2.css" rel="stylesheet"/>
<script src="../planer/js/select2.js"></script>
<script src="/board/js/util.js"></script>
<script>
$(document).ready(function() { $("#mb_3").select2(); });
var member_skin_path = "<?=$member_skin_path?>";
</script>
<script type="text/javascript" src="<?=$member_skin_path?>/ajax_register_form.jquery.js?tsp=20160704"></script>
<div data-role="page" id="regist_form">
	<div data-role="header">
		<h1><!-- jQuery Mobile Demo -->CHOIJAEHOON'S PLANER</h1>
	</div>
	<? 
		include_once("./navbar.php");
	?>
	<div data-role="main" class="ui-content" >
	    <h2>플래너 가입하기 <font size="3" color="#ff0000">＊ 필수</font> </h2>
		<form name="frm" method="post" action="./register_update_server.php"  onsubmit="return fwrite_submit(this);"/>
		<input type=hidden name=w                value="<?=$w?>">
		<input type=hidden name=url              value="<?=$urlencode?>">
		<input type=hidden name=mb_jumin         value="<?=$jumin?>">
		<input type=hidden name=mb_id_enabled    value="" id="mb_id_enabled">
		<input type=hidden name=mb_nick_enabled  value="" id="mb_nick_enabled">
		<input type=hidden name=mb_email_enabled value="" id="mb_email_enabled">
		<div class="ui-field-contain">
			<label for="mb_id">아이디<font color="#ff0000">★</font> <br/> 아이디는 본인의 핸드폰 번호로만 사용이 가능합니다 ID: 01012345678</label>
			<input type="text"  id='reg_mb_id' name="mb_id" value="<?=$data['mb_id']?>"  placeholder="ex) 01074101272" maxlength="11">  
			<span id='msg_mb_id'></span>
			<p><label for="mb_password">비밀번호<font color="#ff0000">★</font></label></p>
			<input type="text"  name="mb_password"  id=""  placeholder="비밀번호를 입력해 주세요.">
			<p><label for="mb_password_re">비밀번호 확인<font color="#ff0000">★</font></label></p>
			<input type="text" id="" name="mb_password_re"  placeholder="비밀번호를 다시 입력해 주세요.">
		</div>
		<div class="ui-field-contain">
			<label for="search">업체명<font color="#ff0000">★</font>  텍스트 박스에서 업체명을 검색해 주세요.</label>
			<select  id="mb_3" name="mb_3" style="width:200px;height:50px;" alt="업체목록" onchange="getCompany(this.value);"><!-- class="form-control" -->
				<option value="0" selected="selected"><!-- --업체선택-- --></option>
				<?
					$tmp_result= mysql_query("select * from `cc_company` where 1=1 and co_type != '4' and co_no not in('95','588','590','553','542','576','612','613','614','617','642','643','644','647','670','671','681','685','686','687','688','690','691','695','701','714') ORDER BY co_name ASC");
					while($tmp_row = mysql_fetch_array($tmp_result)){

				?>
				<option value="<?=$tmp_row['co_id']?>" <?if($tmp_row['co_id']==$data['mb_3'])echo"selected";?>><?=$tmp_row['co_name2']?></option>
				<? } ?>
			</select>
			<span id="msg" style="color:#ff0000;"></span>
		</div>
		<div class="ui-field-contain">
			<label for="name">플래너명<font color="#ff0000">★</font>  </label>
			<input type="text"  id="mb_name" name="mb_name" value="<?=$data['mb_name']?>" placeholder="본인의 이름을 입력해 주세요.">
		</div>
		<div class="ui-field-contain">
		    <label for="fullname">핸드폰<font color="#ff0000">★</font></label>
		    <input type="text" name="mb_hp" id="mb_hp" value="<?=$data['mb_hp']?>" placeholder="ex) 010-7410-1272 / 하이픈(-) 필수">       
		</div>
		<div class="ui-field-contain">
			<label for="date">생년월일 </label>
			<input type="date" id="mb_birth" name="mb_birth" value="<?=$data['mb_birth']?>" />
		</div>
		<div class="ui-field-contain">    
		    <label for="bday">E-MAIL</label>
		    <input type="text"id='reg_mb_email' name='mb_email'  value="<?=$data['mb_email']?>"  onblur="reg_mb_email_check()" placeholder="ex) request@choijaehoon.kr / 비밀번호 재발급시 사용">
            <span id='msg_mb_email'></span>
		</div>
		<div class="ui-field-contain">
			<label for="email">블로그 또는 개인 홈페이지</label>
			<input type="text" name="mb_homepage" id="mb_homepage" placeholder="blog" value="<?=$data['mb_homepage']?>"  placeholder="ex) blog.naver.com/cjhwed">
		</div>
		<font color="orange">추가 정보 입력시 1,000 마일리지 적립</font>
		<div class="ui-field-contain">
		    <label for="mb_6">선호하는스튜디오</label>
		    <select class="form-control" id="mb_6" name="mb_6" >
				<option value=''>브랜드선택</option>
				<? 
				$query = mysql_query("select br_id,br_name,br_code from cc_brand where br_id in('13060001','13060002','13102311','15073024','15060222','13102315','15121026')");
				while($row = mysql_fetch_array($query)){		
				?>
				<option value="<?=$row['br_id']?>" <?if($data['mb_6']==$row[br_id])echo"selected";?>><?=$row['br_name']?></option>
				<? } ?>
			</select>
			<label for="mb_7">포토그래퍼</label>
			<select class="form-control" id="mb_7" name="mb_7" >
			  <option value=''>직원선택</option>
			  <? 
				$query = mysql_query("select mb_id,mb_name from g4_member where mb_level !=1  AND  mb_2 != '11' and mb_id != 'admin' and mb_2 in ('4','5','6','13','15') ORDER BY mb_name ASC");
				   while($row = mysql_fetch_array($query)){		
				 ?>
				 <option value="<?=$row['mb_id']?>" <?if($data['mb_7']==$row['mb_id'])echo"selected";?>><?=$row['mb_name']?></option>
				<? } ?>
			</select>	
			<label for="mb_8">드레스 스타일</label>
			<select class="form-control" id="mb_8" name="mb_8" >
				<option value=''>스타일선택</option>
				<option value="1" <?if($data['mb_8']=='1')echo"selected";?>>클래식</option>
				<option value="2" <?if($data['mb_8']=='2')echo"selected";?>>모던</option>
				<option value="3" <?if($data['mb_8']=='3')echo"selected";?>>엘레강스</option>
				<option value="4" <?if($data['mb_8']=='4')echo"selected";?>>유니크</option>
				<option value="5" <?if($data['mb_8']=='5')echo"selected";?>>러블리</option>
			</select>
			<label for="mb_password_re">드레스 상담자</label>
			<select class="form-control" id="mb_9" name="mb_9" >
				<option value=''>직원선택</option>
				<? 
				$query = mysql_query("select mb_id,mb_name from g4_member where mb_level !=1  AND  mb_2 != '11' and mb_id != 'admin' and mb_2 in ('1','2') ORDER BY mb_name ASC");
				while($row = mysql_fetch_array($query)){		
				?>
				<option value="<?=$row['mb_id']?>" <?if($data['mb_9']==$row['mb_id'])echo"selected";?>><?=$row['mb_name']?></option>
				<? } ?>
			</select>		
		</div>
	</div>
	<p style="text-align:center;">
		<button type="submit" class="ui-btn ui-btn-b ui-corner-all"  id="btn_submit" >가입하기</button><!-- onclick="fwrite_submit()" -->
		<button type="button" class="btn btn-sm btn-default" id="btn_submit"onclick="location.href='../../'">취 소</button>
	</p>
</form>
</div>


<script>

$("#reg_mb_id").keyup(function(event){
	var keyID = (event.which) ? event.which : event.keyCode;
	if ( (keyID >= 48 && keyID <= 57) || (keyID >= 96 && keyID <= 105) || keyID == 8 || keyID == 46 || keyID == 37 || keyID == 39  || keyID == 9) {
		
	}else{
		$(this).val(NumberUtil.onlyNumber($(this).val()));
	}
}).blur(function(){
	if(commonUtil.validateTel($(this).val())){
		// 전화번호일 경우에
		reg_mb_id_check();
	}else{
		$("#msg_mb_id").html('전화번호 형식이 올바르지 않습니다.').css('color', 'red');;
	}
});
 function fwrite_submit(f){

 // 회원아이디 검사

	
    if (f.w.value == "") {		
		reg_mb_id_check();

        if (document.getElementById('mb_id_enabled').value!='000') {
            alert('회원아이디를 입력하지 않았거나 입력에 오류가 있습니다.');
            document.getElementById('reg_mb_id').select();
            return false;
        }
		if(!commonUtil.validateTel($("#reg_mb_id").val())){
			alert('전화번호 형식이 올바르지 않습니다.');
			return false;
		}
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




	if(f.mb_3.value=='0'){
	alert('업체는 필수입니다.');
	 f.mb_3.focus();
	return false;
	}



	if(f.mb_name.value==''){
	alert('이름은 필수입니다.');
	 f.mb_name.focus();
	return false;
	}
  if (f.value) {
        if (f.mb_password.value.length < 3) {
            alert('패스워드를 3글자 이상 입력하십시오.');
            f.mb_password.focus();
            return false;
        }
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



 if(confirm("작성 하신 정보로 정말 가입하시겠습니까?"))
 {
		f.action = './register_update_server.php';
		document.frm.submit();
  }else{ return false; } 

}




//------------------------------------------------------------------> 카테고리2로딩
function getCompany(id) {

url = './ajax_get_company.php?co_id=' + id;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		cache:false,
		async:false,
		success:function(response) {
			var success = (response.flag == 'succ');
			var message = response.message;
			var new_id = response.id;
			//데이타 로딩
			if(success) {
				var cell = response.rows;
			
		
			if(cell.co_condition ==1){ 
				alert('선택하신 업체는 귀사와 상품 거래를 진행할 수 없는 업체 입니다.\n 스케쥴 홀딩시 유념부탁드립니다.');
			
				$('#msg').html('선택하신 업체는 귀사와 상품 거래를 진행할 수 없는 업체 입니다.\n 스케쥴 홀딩시 유념부탁드립니다.');
				
				return false;
			
			}

			//	


			} else {
				alert('fail to load data');
			}
		}
	});
}



</script>






<? 
include_once("./foot.php");
?>
