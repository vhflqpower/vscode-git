<div data-role="header">
  <nav data-role="navbar">
    <ul>
      <!-- <li><a href="./index.php"  data-icon="home">Home</a></li> -->
	  <? if($member['mb_id']){ ?>
       <li class="active"><a href="./attendent_add.php" data-icon="calendar">공지사항</a></li> 
	  <!-- <li><a href="./notice_list.php"  data-icon="grid" >정보내역</a></li> -->
	  <li><a href="./notice_list.php" id="notice_list_link"  data-icon="grid" >정보게시판</a></li><!-- onclick="changePage()" -->
      <li><a href="./attendent_calendar.php" data-icon="search">출석내역</a></li>
     <? }else{ ?>
       <li class="active"><a href="#1" data-icon="calendar"  onclick="alert('준비중입니다.');">수업예약</a></li> 
	  <li><a href="#1"  data-icon="grid"  onclick="alert('준비중입니다.')">공지사항</a></li>
      <li><a href="#1" data-icon="search"  onclick="alert('준비중입니다.')return false;">출석내역</a></li>	
     <? } ?>	
	</ul>
  </nav>
  </div>
  
