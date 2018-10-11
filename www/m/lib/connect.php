<?
// DB접속정보
$db_host = "localhost"; // DB Host
$db_user = "crossfit";  // DB ID
$db_passwd = "crossfit2016"; // DB PW
$db_name = "crossfit"; 	// DB Name
	
// DB 접속
$connect = @mysql_connect($db_host, $db_user, $db_passwd);
$db_select = @mysql_select_db($db_name, $connect);
if (!$db_select) die("DB CONNECT ERROR");

mysql_query("set names 'utf8'"); 

// 페이지 헤더 인코딩 설정
@header("Content-Type: text/html; charset=utf-8");
?>