<?
	include_once("./_common.php");



	include_once("./head.php");

?>


	<?
		include_once("./nav.php");
	?>

    <div class="container-fluid">
	<?
		include_once("./sidebar_mypage.php");
	?>
	<link href='./calendar/fullcalendar.min.css' rel='stylesheet' />
	<link href='./calendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
	<script src='./calendar/js/moment.min.js'></script>
	<script src='./calendar/js/jquery.min.js'></script>
	<script src='./calendar/js/fullcalendar.min.js'></script>
    <div class="main">



	<div class="page-header">
		<h1>스케쥴 PAGE</h1>
	</div>

<?php 
    // 쿼리문 실행 
    $sql = "";
    
    // 배열 처리 
    $arr = array('id'=>'1','title'=>'hello this is add data','start'=>'2018-03-02','end'=>'2018-03-03T16:00:00');
//	print_r2($arr);
?>

<script>

  $(document).ready(function(){

    $('#calendar').fullCalendar({
      defaultDate: '2018-03-12',
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: '1111',
          start: '2018-03-01',
          end: '2018-03-10'
        },
        {
          title: '222',
          start: '2018-03-07',
          end: '2018-03-10'
        },
        {
          id: 999,
          title: '333',
          start: '2018-03-09T16:00:00'
        },
        {
          id: 999,
          title: '4444',
          start: '2018-03-16T16:00:00'
        },
        {
          title: '5555',
          start: '2018-03-11',
          end: '2018-03-13'
        },
        {
          title: '6666666',
          start: '2018-03-12T10:30:00',
          end: '2018-03-12T12:30:00'
        },
        {
          title: 'abc',
          start: '2018-03-12T14:30:00',
          end: '2018-03-13T12:30:00'
        },
        {
          title: '<?=$arr[title]?>',
          start: '<?=$arr[start]?>',
          end: '<?=$arr[end]?>'
        }
      ]
    });

  });

</script>




<div id='calendar'></div>
<div style="height:70px;">
</div>

	</div><!-- main 끝 -->

<script>
$(document).ready(function() {

   $('#my_calendar').attr("class", "list-group-item active");


});
</script>

<?
	include_once("./footer.php");
?>


<?
	include_once("./tail.php");
?>
