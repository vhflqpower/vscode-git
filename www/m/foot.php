

  <div data-role="footer" data-position="fixed" >
  <h1>CopyRight M.T.A <!-- FAX)02-515-5196 -->
  </h1>
  </div>

 <div data-role="panel" id="myPanel"> 
  <h2>MEMBER SHIP</h2>
    <ul data-role="listview" data-inset="true">
      <li><a href="./attendent_add.php">수업등록</a></li>
      <li><a href="#1" onclick="alert('준비중..')">수업내역</a></li>
      <li><a href="./mileage.php">상담내역</a></li>  
      <li><a href="./my_info_f.php">내 정보</a></li>  
	<? if(!$member[mb_id]){ ?>
		  <li><a href="/">로그인</a></li>
		<? }else{ ?>  
		  <li><a href="./logout.php">로그아웃</a></li>
	<? } ?>	
		
	</ul>
  </div> 
  </div> 






</body>
</html>
