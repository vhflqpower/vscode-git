
    <nav class="navbar navbar-fixed-top navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">M.T.A</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <!-- <li class="active"><a href="/">Home</a></li> -->
			 <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">E러닝 <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
						  <li><a href="/board/view.php?bo_table=elern">HTML5/CSS3</a></li>
						  <li><a href="#">JS/JQUERY</a></li>
						  <li><a href="#">PHP</a></li>
						  <li><a href="#">Python</a></li>
						  <li><a href="#">CodeIgnater</a></li>
						  <li><a href="#">Laraval</a></li>
						  <li><a href="#">Java</a></li>
						  <li><a href="#">JSP</a></li>
						  <li><a href="#">Spring</a></li>
						  <!-- <li class="divider"></li> -->
						  <!-- <li class="dropdown-header">MYSQL</li> -->
						  <li><a href="#">DATABASE</a></li>
						</ul>
					</li>
            <li ><a href="#contact">메뉴얼</a></li>
            <li><a href="#contact">API</a></li>

			 <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">커뮤니티 <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
						  <li><a href="/board/list.php?bo_table=notice">공지사항</a></li>
						  <li><a href="#">사이트빌드</a></li>
						  <li><a href="#">제안하기</a></li>
			<? if($member['mb_id']=='psj007'){ ?>
						  <li><a href="/admin/">PMS</a></li>
			<? } ?>
						</ul>
					</li>
           

			<?if($member[mb_id]){?>
            <li><a href="../member/mypage_pw_check.php">마이페이지</a></li>
            <li><a href="../member/logout.php">로그아웃</a></li>
			<? }else{ ?>
            <li><a href="../member/login.php">로그인</a></li>
			<? }?>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
