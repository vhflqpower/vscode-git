
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./main.php">M.T.A 엠티에이</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-left">
			 <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">PROJECT<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="./base_config.php">기본설정</a></li>
                </ul>
              </li>
			 <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">커뮤니티<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="./base_config.php">기본설정</a></li>
                </ul>
              </li>
			 <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">CONFIG <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="./base_config.php">기본설정</a></li>
                  <li><a href="./cash_list.php">회비내역</a></li>
                  <li><a href="./mileage_list.php">마일리지내역</a></li>
                  <li><a href="./login_list.php">로그인내역</a></li>
                  <li><a href="../login/logout.php">로그아웃</a></li>
                </ul>
              </li>
            <li><a href="/spt/" target="_blank">SPT</a>
			</li>
           <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">LINKS <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
	        <li><a href="http://gw.commercelab.co.kr/groupware/login.php?mode=logout" target="_blank">그룹웨어</a></li>                
	        <li><a href="http://cs.commercelab.co.kr/login_page.php?return=view.php%3Fid%3D1401" target="_blank" >맨티스</a></li>            
                  <li><a href="https://github.com/" target="_blank">GIT HUB(깃허브)</a></li>
                  <li><a href="" target="_blank">비즈톡(카카오)</a></li>
                  <li><a href="" target="_blank">PG사</a></li>
                  <li><a href="" target="_blank">택배사</a></li>
                  <li><a href="/erd/index.php?sub_mid=5&sub_sid=8" target="_blank">LINUX</a></li>
                  <li><a href="/erd/index.php?sub_mid=5&sub_sid=4" target="_blank">PHP</a></li>
                  <li><a href="/erd/index.php?sub_mid=5&sub_sid=5" target="_blank">JQUERY</a></li>
                </ul>
              </li>
          </ul>

              <!-- <div class="pull-right"> -->
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Welcome,<?=$member['mb_name']?>
					<span class='badge'><?=$memo_not_read?></span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="./memo.php" target="_blank" id="ol_after_memo" class="win_memo"><i class="icon-cog"></i>쪽지<span class='badge'><?=$memo_not_read?></span></a></li>
                            <li><a href="./mypage.php">MYPAGE</a></li>
                            <li class="divider"></li>
                            <li><a href="./logout.php"><i class="icon-off"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
              <!-- </div> -->


          <form class="navbar-form navbar-right" name="allsearch" method="POST" action="./board_list.php?part=board" target="_blank">
          <div id="hd" style=";">
		   <input type="text"  class="form-control" name="search_keyword" id="search_keyword" value="<?=$_GET['search_keyword']?>" placeholder="Search...">
           <!-- <button type="submit" class="btn btn-success" id="">검색</button> -->
		</div>
	</form>

        </div>
      </div>
    </nav>

<script>
$(document).ready(function() {

	// 오토컴플리트 (검색어 자동완성)
	$("#hd").on("keyup", "#search_keyword", function(){

		var stx = $(this).val(); /* 입력한 검색어 */

		$(this).autocomplete({

			source:function(request, response) {

				$.getJSON("./ajax_autocomplete_json.php", {
					/* _search_popular.php 파일로 넘길 변수값을 이곳에 작성하시면 됩니다. GET 으로 넘어갑니다. */
					/* 콤마로 구분하시면 되요 ex) sfl:"wr_subject", stx:stx, ........ */
					stx : stx
				}, response);
			},
			minLength:2, /*최소 검색 글자수*/
			delay: 150,  /* 검색어 입력후 표시되는 시간 - 숫자가 클수록 느리게 출력 */
			focus:function(event, ui) {
				/* 검색을 통하여 넘어온 값을 여기서 처리 */
				console.log(ui.item.value); /* 콘솔 확인용이므로 삭제하거나 주석처리 하여도 됩니다. */
			},



			close:function(event, ui) {

			}
		})
	});
	// 오토컴플리트 종료

});
</script>
