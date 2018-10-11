<? 
include_once("./_common.php");


	$home_active = 'active';

	if($member[mb_id]){
			$data = sql_fetch("select * from psj_member where mb_id = '$member[mb_id]'");
			//$data2 = sql_fetch("select co_id,co_name from cc_company where co_id = '$data[mb_3]'");
	
	}


	//print_r($data);

include_once("./head.php");
?>

<div data-role="page" id="my_info2">
  <div data-role="header">
      <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a>
   <h1><a href="./" class='menu'>HANSABU GYM</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>

<? 
include_once("./navbar.php");
?>

<div data-role="main" class="ui-content" >
    <h2>MEMBER INFO</h2>

<form name="frm" method="post" action=""  onsubmit="return fwrite_submit(this);" />
<input type="hidden"  name="mb_no" value="<?=$data['mb_no']?>" />

  <div class="ui-field-contain">
    <label for="name">회원명:</label>
    <input type="text"  id="mb_name" name="mb_name" value="<?=$data['mb_name']?>" placeholder="회원명">
    </div>
    
 <!-- <div class="ui-field-contain">
        <label for="fullname">업체명</label>
  
		<table border=0 width="100%">
			<tr>
			<td>
			<input type="hidden" name="mb_3" id="mb_3" value="<?=$data2['co_id']?>" >     
			<input type="text" name="co_name" id="co_name" value="<?=$data2['co_name']?>" >   
			</td>
			<td>
			 <a href="#phonebook" data-rel="dialog" class="ui-btn ui-corner-all ui-shadow ui-btn-inline"  >검색</a>
			</td>
			</tr>
		</table>

      </div> -->

  <div class="ui-field-contain">
    <label for="date">생년월일:</label>
    <input type="date"id="mb_birth" name="mb_birth" value="<?=$data['mb_birth']?>"/>
  </div>
  
 <div class="ui-field-contain">
        <label for="fullname">핸드폰:</label>
        <input type="text" name="mb_hp" id="mb_hp" value="<?=$data['mb_hp']?>" >       
 
      </div>

 <div class="ui-field-contain">    
        <label for="bday">Email:</label>
        <input type="text" name="mb_email" id="mb_email" value="<?=$data['mb_email']?>" />

      </div>

 <div class="ui-field-contain">
        <label for="email">블로그:</label>
        <input type="text" name="mb_homepage" id="mb_homepage" placeholder="blog" value="<?=$data['mb_homepage']?>">
      </div>


 <div class="ui-field-contain">
        <label for="mb_id">아이디</label>
        <input type="text" name="mb_id_tmp" id="mb_id_tmp" value="<?=$data['mb_id']?>" style="color:#0000ff" readonly>       
        <label for="mb_password">비밀번호:</label>
        <input type="text"  name="mb_password"  id=""  placeholder="비밀번호">
        <label for="mb_password_re">비밀번호확인:</label>
        <input type="text" id="" name="mb_password_re"  placeholder="비번확인.">
      </div>

<!-- 
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
 -->

<p style="text-align:center;">
 <button type="submit" class="ui-btn ui-btn-b ui-corner-all"  id="btn_submit" >정보 저장</button>
</p>

</form>
</div>

<!-- 

  <div data-role="footer" data-position="fixed">
  <h1>루체라운지TEL)02-515-6800</h1>
  </div>
	
	
 <div data-role="panel" id="myPanel"> 
	  <h2>MEMBER SHIP</h2>
		<ul data-role="listview" data-inset="true">
		  <li><a href="./photo_hold.php">잔여타임 프로모션</a></li>
		  <li><a href="./photo_regist.php">촬영스케쥴 홀딩</a></li>
		  <li><a href="./mileage.php">마일리지</a></li>  
		  <li><a href="./my_info_f.php">내 정보</a></li>  
		  <li><a href="./logout.php">로그아웃</a></li>
		</ul>
	  </div> 
  </div> 

<div data-role="page" id="phonebook">
  <div data-role="header">
  <h1>업체목록검색</h1>
  <a href="#pageone" data-role="button" class="ui-btn-right" data-icon="back"  data-rel="back">Go Back</a>
  </div>

 <div data-role="main" class="ui-content">
  
	<table border=0 width="100%">
		<tr>
		<td>
			<input type="text" name="" id="keyword" placeholder="업체명" value="">	
		</td>
		<td> <a href="#search" data-role="button"  onclick="getCompanyData()">조회</a></td>
		</tr>
	</table>
   <div id="co_list" style="border:0px solid red; width:300px;"></div> 
  </div>
</div> 
</div> 



 -->

<script>





// # 대분류터로딩------------------------------------------------#
function getCompanyData() {

	var keyword = $("#keyword").val();

	if(keyword==''){
	alert('업체명을 입력하세요')
	return false;
	}
	
	url = './ajax_company_data.php?keyword='+keyword;
	$.ajax({
		url:url,
		type:'POST',
		dataType:'json',
		cache:false,
		async:false,
		success:function(response) {
		
			var message = response.message;		
			var new_id = response.id;

		//	var cell = response.flag;

		if(message=='nodata'){
		
		var cs_table = $('#co_list');
		cs_table.find('.cs_row').remove();

		alert('검색 결과가 없습니다.');
			return false;
		}

			var cell = response.rows;	
			
			var cs_table = $('#co_list');
			cs_table.find('.cs_row').remove();


				if(cell.length < 1){
					cs_table.append("<ul ><li colspan='4'>정보가 없습니다.</li></ul>");
				} else {
				
					for(var i = 0; i < cell.length ; i++ ) {
						cs_table.append(getComRow(cell[i]));
		
					}
				}

		} 
	});
}

function getComRow(cell) {

	if(!cell) return "<ul class=cs_row><li colspan='3'>정보가 없습니다.</li></ul>";
	
	var cell_text = "<ul class=cs_row style='border:0px solid;red;width:280px;font-weight:bold;'>"
				
					+"	<li style='float:left;width:200px;display:inline;padding:5px'>"+cell.co_name2+"</li>"
					+"	<li style='float:left;display:inline;'><a href='#pa' data-role='button'  data-rel='back'  onclick=\"getCompany('"+cell.co_id+"','"+cell.co_name2+"')\">선택</a></li>"
					+"</ul>";
	return cell_text;
}
//	+"	<li style='float:left;width:80px;display:inline;'>"+cell.co_id+"</li>"


function getCompany(id,name) {

		$('#mb_3').val(id);
		$('#co_name').val(name)

		var cs_table = $('#co_list');
		cs_table.find('.cs_row').remove();

}





 function fwrite_submit(f){


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


 if(confirm("플래너 정보를 정말 수정하시겠습니까?"))
 {
		f.action = './my_info_server.php';
		//document.frm.submit();
  }else{ return false; } 

}


$(document).ready(function() { 

	});



</script>


<!-- </body>
</html>
 -->

<? 
	include_once("./foot.php");
?>
