<?
	include_once("./_common.php");



	include_once("./head.php");

?>


	<?
		include_once("./nav.php");
	?>

    <div class="container-fluid">
	<?
		include_once("./sidebar.php");
	?>
<link href='./calendar/fullcalendar.min.css' rel='stylesheet' />
<link href='./calendar/fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='./calendar/js/moment.min.js'></script>
<script src='./calendar/js/jquery.min.js'></script>
<script src='./calendar/js/fullcalendar.min.js'></script>
    <div class="main">



	<div class="page-header">
		<h1>CALENDAR PAGE</h1>
	</div>



<script>

  $(document).ready(function() {

    $('#calendar').fullCalendar({
      defaultDate: '2018-03-12',
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day EventTEST',
          start: '2018-03-01'
        },
        {
          title: 'Long Event123',
          start: '2018-03-07',
          end: '2018-03-10'
        },
        {
          id: 999,
          title: 'Repeating Event456',
          start: '2018-03-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event<======1=========',
          start: '2018-03-16T16:00:00'
        },
        {
          title: 'Conferencefc-event-container<=======2========',
          start: '2018-03-11',
          end: '2018-03-13'
        },
        {
          title: 'Meeting<====3===========',
          start: '2018-03-12T10:30:00',
          end: '2018-03-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2018-03-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2018-03-12T14:30:00'
        },
        {
          title: 'Happy Hour<====a===========',
          start: '2018-03-12T17:30:00'
        },
        {
          title: 'Dinner<========b=======',
          start: '2018-03-12T20:00:00'
        },
        {
          title: 'Birthday Party<======c=========',
          start: '2018-03-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2018-03-28'
        }
      ]
    });

  });

</script>


<div id='calendar'></div>


	</div>








<?
	include_once("./footer.php");
?>


<?
	include_once("./tail.php");
?>
