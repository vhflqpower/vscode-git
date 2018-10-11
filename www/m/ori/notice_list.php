<? 
include_once("./_common.php");


	//$tomonth = date('Y-m');
    $br_id = $_GET['br_id'];

		$time = time(); 
		$todate = date("d");

		if($_GET['Month']=='nextMonth'){

			$s_year = date("Y");

		if($todate==31)
			$s_month = date("m",strtotime("+29 day", $time));		
		else
			$s_month = date("m",strtotime("+1 month", $time));

			$btn_now = 'btn btn-default';
			$btn_next = 'btn btn-primary';
			$tomonth = $s_year.'-'.$s_month;

		}else{

			$s_year = date("Y");
			$s_month = date("m");

			$btn_now = 'btn btn-primary';
			$btn_next = 'btn btn-default';
			$tomonth = $s_year.'-'.$s_month;

		}


	//print_r($member);


			$d_month = date("m");
		if($todate==31)
			$nMon = date("m",strtotime("+29 day", $time));		
		else
			$nMon = date("m",strtotime("+1 month", $time));
			

		$query1 = "SELECT ab_date,count(*)as cnt FROM cf_absent WHERE  ab_date LIKE  '$tomonth%' and mb_cd ='$member[mb_id]'  group by ab_date";

		$dbresult1 = mysql_query($query1);
		$cnt = 0;
		while($row1 = mysql_fetch_array($dbresult1)){
			
			$wdate = $row1['ab_date'];
			$ARR_ABSENT_CNT[$wdate] = $row1['cnt'];	
		$cnt++;
		}


include_once("./head.php");
?>


<div data-role="page" id="notice_list">
  <div data-role="header">
      <a href="#myPanel" class="ui-btn ui-corner-all ui-shadow ui-icon-bars ui-btn-icon-left ">M</a>
   <h1><a href="./" class='menu'>HANSABU GYM</a></h1>
	<!-- <a href="./" class="ui-btn ui-corner-all ui-shadow ui-icon-home ui-btn-icon-right ">HOME</a> -->
  </div>


<? 
include_once("./navbar.php");
?>
<div data-role="main" class="ui-content">
    <h2 style="margin:0px;font-size:1.5em">공지사항</h2>


  <div class="ui-field-contain">

 <table data-role="table" id="table-column-toggle" data-mode="columntoggle" class="ui-responsive table-stroke">
	              <thead>
	                <tr>
	                  <th data-priority="2">Rank</th>
	                  <th>Movie Title</th>
	                  <th data-priority="3">Year</th>
	                  <th data-priority="1"><abbr title="Rotten Tomato Rating">Rating</abbr></th>
	                  <th data-priority="5">Reviews</th>
	                </tr>
	              </thead>
	              <tbody>
	                <tr>
	                  <th>1</th>
	                  <td><a href="http://en.wikipedia.org/wiki/Citizen_Kane" data-rel="external">Citizen Kane</a></td>
	                  <td><a href="notice_view.php"  data-transition="pop">1941</a></td>
	                  <td>100%</td>
	                  <td>74</td>
	                </tr>
	                <tr>
	                  <th>2</th>
	                  <td><a href="http://en.wikipedia.org/wiki/Casablanca_(film)" data-rel="external">Casablanca</a></td>
	                  <td>1942</td>
	                  <td>97%</td>
	                  <td>64</td>
	                </tr>
	                <tr>
	                  <th>3</th>
	                  <td><a href="http://en.wikipedia.org/wiki/The_Godfather" data-rel="external">The Godfather</a></td>
	                  <td>1972</td>
	                  <td>97%</td>
	                  <td>87</td>
	                </tr>
	                <tr>
	                  <th>4</th>
	                  <td><a href="http://en.wikipedia.org/wiki/Gone_with_the_Wind_(film)" data-rel="external">Gone with the Wind</a></td>
	                  <td>1939</td>
	                  <td>96%</td>
	                  <td>87</td>
	                </tr>
	                <tr>
	                  <th>5</th>
	                  <td><a href="http://en.wikipedia.org/wiki/Lawrence_of_Arabia_(film)" data-rel="external">Lawrence of Arabia</a></td>
	                  <td>1962</td>
	                  <td>94%</td>
	                  <td>87</td>
	                </tr>
	                <tr>
	                  <th>6</th>
	                  <td><a href="http://en.wikipedia.org/wiki/Dr._Strangelove" data-rel="external">Dr. Strangelove Or How I Learned to Stop Worrying and Love the Bomb</a></td>
	                  <td>1964</td>
	                  <td>92%</td>
	                  <td>74</td>
	                </tr>
	                <tr>
	                  <th>7</th>
	                  <td><a href="http://en.wikipedia.org/wiki/The_Graduate" data-rel="external">The Graduate</a></td>
	                  <td>1967</td>
	                  <td>91%</td>
	                  <td>122</td>
	                </tr>
	                <tr>
	                  <th>8</th>
	                  <td><a href="http://en.wikipedia.org/wiki/The_Wizard_of_Oz_(1939_film)" data-rel="external">The Wizard of Oz</a></td>
	                  <td>1939</td>
	                  <td>90%</td>
	                  <td>72</td>
	                </tr>
	                <tr>
	                  <th>9</th>
	                  <td><a href="http://en.wikipedia.org/wiki/Singin%27_in_the_Rain" data-rel="external">Singin' in the Rain</a></td>
	                  <td>1952</td>
	                  <td>89%</td>
	                  <td>85</td>
	                </tr>
	                <tr>
	                  <th>10</th>
	                  <td class="title"><a href="http://en.wikipedia.org/wiki/Inception" data-rel="external">Inception</a></td>
	                  <td>2010</td>
	                  <td>84%</td>
	                  <td>78</td>
	                </tr>
	              </tbody>
	            </table>


  </div>

  </div><!-- data-role="main" -->


<? 
include_once("./foot.php");

?>
