<?
// 빈값 버그 방지
$cf[''] = "";
$cf['charset']		= "utf-8";
$cf['charset_str']	= str_replace("-", "", $cf['charset']);

//echo $cf[''].'<br>';
//echo $cf['charset'].'<br>';
//echo $cf['charset_str'].'<br>';

// 경로 설정
$cf['path']		= $_SERVER['DOCUMENT_ROOT']; // 로컬 루트경로
$cf['url']		= "http://" . $_SERVER['HTTP_HOST']; // HTTP URL
$cf['http']		= $cf['url']; // $cf['url'] alias
$cf['user_ip']	= $_SERVER['REMOTE_ADDR']; // 접속 IP


	$arr_pay_type[1] = "현금";
	$arr_pay_type[2] = "카드";

//	$arr_mb_type[1][]


//echo $cf['path'].'<br>';
//echo $cf['url'].'<br>';
//echo $cf['http'].'<br>';
//echo $cf['user_ip'].'<br>';

// 서버시간 설정
// 서버의 시간과 실제 사용하는 시간이 틀린 경우 time() 값에 +,- 로 수정
// 하루는 86400 초. 1시간은 3600초
/*$cf['time_stamp']	= time();
$cf['time_ymd']		= date("Y-m-d", $cf['time_stamp']);
$cf['time_his']		= date("H:i:s", $cf['time_stamp']);
$cf['time_ymdhis']	= date("Y-m-d H:i:s", $cf['time_stamp']);
*/
?>