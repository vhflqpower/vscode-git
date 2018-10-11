<?
// PHP error_reporting
error_reporting(E_ALL ^ E_NOTICE);

// 특수문자 필터링설정 (php.ini 의 magic_quotes_gpc 옵션값이 Off 인 경우 addslashes() 적용)
// SQL 쿼리 취약점 공격 보호를 위해
if (!get_magic_quotes_gpc()) {
	if (is_array($_GET)) {
		while(list($k, $v) = each($_GET)) {
			if (is_array($_GET[$k])) {
				while(list($k2, $v2) = each($_GET[$k])) {
					$_GET[$k][$k2] = addslashes($v2);
				}
				@reset($_GET[$k]);
			}
			else {
				$_GET[$k] = addslashes($v);
			}
		}
		@reset($_GET);
	}

	if (is_array($_POST)) {
		while(list($k, $v) = each($_POST)) {
			if (is_array($_POST[$k])) {
				while(list($k2, $v2) = each($_POST[$k])) {
					$_POST[$k][$k2] = addslashes($v2);
				}
				@reset($_POST[$k]);
			}
			else {
				$_POST[$k] = addslashes($v);
			}
		}
		@reset($_POST);
	}

	if (is_array($_COOKIE)) {
		while(list($k, $v) = each($_COOKIE)) {
			if (is_array($_COOKIE[$k])) {
				while(list($k2, $v2) = each($_COOKIE[$k])) {
					$_COOKIE[$k][$k2] = addslashes($v2);
				}
				@reset($_COOKIE[$k]);
			}
			else {
				$_COOKIE[$k] = addslashes($v);
			}
		}
		@reset($_COOKIE);
	}
}


//==========================================================================================================================
// XSS(Cross Site Scripting) 공격에 의한 데이터 검증 및 차단
//--------------------------------------------------------------------------------------------------------------------------
function xss_clean($data) 
{ 
    // If its empty there is no point cleaning it :\ 
    if(empty($data)) 
        return $data; 
         
    // Recursive loop for arrays 
    if(is_array($data)) 
    { 
        foreach($data as $key => $value) 
        { 
            $data[$key] = xss_clean($value); 
        } 
         
        return $data; 
    } 
     

    // Fix &entity\n; 
    $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data); 
    $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/', '$1;', $data); 
    $data = preg_replace('/(&#x*[0-9A-F]+);*/i', '$1;', $data); 

    if (function_exists("html_entity_decode"))
    {
        $data = html_entity_decode($data); 
    }
    else
    {
        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl = array_flip($trans_tbl);
        $data = strtr($data, $trans_tbl);
    }

    // Remove any attribute starting with "on" or xmlns 
    $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#i', '$1>', $data); 

    // Remove javascript: and vbscript: protocols 
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#i', '$1=$2nojavascript...', $data); 
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#i', '$1=$2novbscript...', $data); 
    $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#', '$1=$2nomozbinding...', $data); 

    // Only works in IE: <span style="width: expression(alert('Ping!'));"></span> 
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data); 
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data); 
    $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#i', '$1>', $data); 

    // Remove namespaced elements (we do not need them) 
    $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data); 

    do 
    { 
        // Remove really unwanted tags 
        $old_data = $data; 
        $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data); 
    } 
    while ($old_data !== $data); 
     
    return $data; 
} 

$_GET = xss_clean($_GET);


$ext_arr = array ('PHP_SELF', '_ENV', '_GET', '_POST', '_FILES', '_SERVER', '_COOKIE', '_SESSION', '_REQUEST',
                  'HTTP_ENV_VARS', 'HTTP_GET_VARS', 'HTTP_POST_VARS', 'HTTP_POST_FILES', 'HTTP_SERVER_VARS',
                  'HTTP_COOKIE_VARS', 'HTTP_SESSION_VARS', 'GLOBALS');
$ext_cnt = count($ext_arr);
for ($i=0; $i<$ext_cnt; $i++) {
    // GET, POST 로 선언된 전역변수가 있다면 unset() 시킴
    if (isset($_GET[$ext_arr[$i]])) unset($_GET[$ext_arr[$i]]);
    if (isset($_POST[$ext_arr[$i]])) unset($_POST[$ext_arr[$i]]);
}




ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

session_set_cookie_params(0, "/");
ini_set("session.cookie_domain", $g4['cookie_domain']);

@session_start();




// extract() - PHP 4.1.0 부터 지원됨
// php.ini 의 register_globals=off 일 경우 register_globals=on 처럼 사용하기 위함
@extract($_GET);
@extract($_POST);
@extract($_SERVER);
@extract($_SESSION);
@extract($_COOKIE);
@extract($_REQUEST);
@extract($_FILES);
@extract($_ENV);


$config = array();
$member = array();
$board  = array();
$group  = array();




// 기본 변수 초기화
//$cf[''] = "";
//$cf['charset']		= "utf-8";
//$cf['charset_str']	= str_replace("-", "", $cf['charset']);
//$cf['url']		= "http://" . $_SERVER['HTTP_HOST']; // HTTP URL
//$cf['http']		= $cf['url']; // $cf['url'] alias
//$cf['user_ip']	= $_SERVER['REMOTE_ADDR']; // 접속 IP
//$cf	= array();			// config.php 의 기본 설정


/*
if (!$cr_path || preg_match("/:\/\//", $cr_path))
    die("<meta http-equiv='content-type' content='text/html; charset=$cr[charset]'><script type='text/javascript'> alert('잘못된 방법으로 변수가 정의되었습니다.'); </script>");

*/
@$app['path'] = $app_path;
// 경로의 오류를 없애기 위해 $g4_path 변수는 해제
unset($app_path);


// 공통파일 인클루드
$app_dir = "/hansabu";
$app_root = $_SERVER['DOCUMENT_ROOT']."/hansabu";	// 로컬 루트경로
include_once($app_root."/lib/config.php");		// 기본 설정 파일
include_once($app_root."/lib/connect.php");		// DB 컨넥션 파일

//$cr = array();
//$cr['path'] = "/crossfit";


// 게시판 설정 정보

$write_table = "";
if (isset($bo_table)) {
    $board = sql_fetch(" select * from psj_board_config where bo_table = '$bo_table' ");
    if ($board['bo_table']) {
        $gr_id = $board['gr_id'];
     
	   //$write_table = $g4['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
       
		$write_table ='psj_board';

        if ($wr_id)
            $write = sql_fetch(" select * from $write_table where wr_id = '$wr_id' ");
    }
}

/*
if (isset($gr_id))
    $group = sql_fetch(" select * from {$g4['group_table']} where gr_id = '$gr_id' ");
*/





// 분류 옵션을 얻음
// 4.00 에서는 카테고리 테이블을 없애고 보드테이블에 있는 내용으로 대체
function get_category_option($bo_table='',$default,$rowdata='')
{
    global $g4, $board;



    $arr = explode("|", $board[bo_category_list]); // 구분자가 , 로 되어 있음

	$str = "";
	$str .= "<option value=''>$default</option>\n";
    for ($i=0; $i<count($arr); $i++){
        if (trim($arr[$i])){
    
			$val = explode(":",$arr[$i]);

			if($rowdata == $val[0])$checked ='selected'; else $checked ='';
	
			$str .= "<option value='$val[0]' $checked>$val[1]</option>\n";
		}

	}

    return $str;
}




function get_paging($write_pages, $cur_page, $total_page, $url, $add="")
{
    $str = "";
    if ($cur_page > 1) {
        $str .= "<li><a href='" . $url . "1{$add}'>처음</a></li>";
    }
    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;
    if ($end_page >= $total_page) $end_page = $total_page;
    if ($start_page > 1) $str .= "<li><a href='" . $url . ($start_page-1) . "{$add}'>이전</a></li>";
    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= "<li><a href='$url$k{$add}'>$k</a></li>";
            else
                $str .= "<li class='active'><a href='#'>$k<span class='sr-only'>(current)</span></a></li>";
        }
    }
    if ($total_page > $end_page) $str .= "<li><a href='" . $url . ($end_page+1) . "{$add}'>다음</a></li>";
    if ($cur_page < $total_page) {
        $str .= "<li><a href='$url$total_page{$add}'>맨끝</a></li>";
    }
    $str .= "";
    return $str;
}



// 변수 또는 배열의 이름과 값을 얻어냄. print_r() 함수의 변형
function print_r2($var)
{
    ob_start();
    print_r($var);
    $str = ob_get_contents();
    ob_end_clean();
    $str = preg_replace("/ /", "&nbsp;", $str);
    echo nl2br("<span style='font-family:Tahoma, 굴림; font-size:9pt;'>$str</span>");
}


// 메타태그를 이용한 URL 이동
// header("location:URL") 을 대체
function goto_url($url)
{
    echo "<script type='text/javascript'> location.replace('$url'); </script>";
    exit;
}



// 경고메세지를 경고창으로
function alert($msg='', $url='')
{
	global $g4;

    if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';

	//header("Content-Type: text/html; charset=$g4[charset]");
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=$g4[charset]\">";
	echo "<script type='text/javascript'>alert('$msg');";
    if (!$url)
        echo "history.go(-1);";
    echo "</script>";
    if ($url)
        // 4.06.00 : 불여우의 경우 아래의 코드를 제대로 인식하지 못함
        //echo "<meta http-equiv='refresh' content='0;url=$url'>";
        goto_url($url);
    exit;
}


// 경고메세지 출력후 창을 닫음
function alert_close($msg)
{
	global $g4;

	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=$g4[charset]\">";
    echo "<script type='text/javascript'> alert('$msg'); window.close(); </script>";
    exit;
}






// 세션변수 생성
function set_session($session_name, $value)
{
    if (PHP_VERSION < '5.3.0')
        session_register($session_name);
    // PHP 버전별 차이를 없애기 위한 방법
    $$session_name = $_SESSION["$session_name"] = $value;
}


// 세션변수값 얻음
function get_session($session_name)
{
    return $_SESSION[$session_name];
}


// 쿠키변수 생성
function set_cookie($cookie_name, $value, $expire)
{
    global $g4;

    setcookie(md5($cookie_name), base64_encode($value), $g4[server_time] + $expire, '/', $g4[cookie_domain]);
}


// 쿠키변수값 얻음
function get_cookie($cookie_name)
{
    return base64_decode($_COOKIE[md5($cookie_name)]);
}



// 자동로그인 부분에서 첫로그인에 포인트 부여하던것을 로그인중일때로 변경하면서 코드도 대폭 수정하였습니다.
if ($_SESSION['ss_mb_id']) // 로그인중이라면
{
    $member = get_member($_SESSION['ss_mb_id']);

}


/*************************************************************************
**
**  SQL 관련 함수 모음
**
*************************************************************************/

// DB 연결
function sql_connect($host, $user, $pass)
{
    global $g4;

    return @mysql_connect($host, $user, $pass);
}


// DB 선택
function sql_select_db($db, $connect)
{
    global $g4;

    if (strtolower($g4['charset']) == 'utf-8') @mysql_query(" set names utf8 ");
    else if (strtolower($g4['charset']) == 'euc-kr') @mysql_query(" set names euckr ");
    return @mysql_select_db($db, $connect);
}


// mysql_query 와 mysql_error 를 한꺼번에 처리
function sql_query($sql, $error=TRUE)
{
    // Blind SQL Injection 취약점 해결
    $sql = trim($sql);
    // union의 사용을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*[^\'\"]union[^\'\"].*#i", "select 1", $sql);
    // `information_schema` DB로의 접근을 허락하지 않습니다.
    $sql = preg_replace("#^select.*from.*[^\'\"]`?information_schema`?[^\'\"].*#i", "select 1", $sql);

    if ($error)
        $result = @mysql_query($sql) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
    else
        $result = @mysql_query($sql);
    return $result;
}


// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=TRUE)
{
    $result = sql_query($sql, $error);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
    $row = sql_fetch_array($result);
    return $row;
}


// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result)
{
    $row = @mysql_fetch_assoc($result);
    return $row;
}


// $result에 대한 메모리(memory)에 있는 내용을 모두 제거한다.
// sql_free_result()는 결과로부터 얻은 질의 값이 커서 많은 메모리를 사용할 염려가 있을 때 사용된다.
// 단, 결과 값은 스크립트(script) 실행부가 종료되면서 메모리에서 자동적으로 지워진다.
function sql_free_result($result)
{
    return mysql_free_result($result);
}


function sql_password($value)
{
    // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
    // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
    $row = sql_fetch(" select password('$value') as pass ");
    return $row[pass];
}


// 게시판의 다음글 번호를 얻는다.
function get_next_num($table)
{
    // 가장 작은 번호를 얻어
    $sql = " select min(wr_num) as min_wr_num from $table ";
    $row = sql_fetch($sql);
    // 가장 작은 번호에 1을 빼서 넘겨줌
    return (int)($row[min_wr_num] - 1);
}






// 회원 정보를 얻는다.
function get_member($mb_id, $fields='*')
{
    global $g4;
    return sql_fetch(" select $fields from psj_member where mb_id = TRIM('$mb_id') ");
   //return sql_fetch(); // 부서명추가

}


// 회원 정보를 얻는다.
function get_m_member($mb_id, $fields='*')
{
    global $g4;
    return sql_fetch(" select $fields from psj_member where mb_id = TRIM('$mb_id') ");
   //return sql_fetch(); // 부서명추가

}



	function putJson($flag, $message = '' , $mode=true) {
		$out = ( is_array($flag) ) ? $flag : array('flag'=>$flag, 'message'=>$message);
		echo json_encode($out);
		if (true===$mode) die();
	}



// 자동로그인 부분에서 첫로그인에 포인트 부여하던것을 로그인중일때로 변경하면서 코드도 대폭 수정하였습니다.
if ($_SESSION['ss_mb_id']) // 로그인중이라면
{
    $member = get_member($_SESSION['ss_mb_id']);

}


// 글씨 자르기
	function str_cut($str, $len, $tail="..."){
		if(strlen($str) > $len){
			return mb_strcut($str, 0, $len, "UTF-8").$tail;
		}else{
			return mb_strcut($str, 0, $len, "UTF-8");
		}
	}








//  일련번호 자동생성 함수 
    # type = regest(입관)
function id_gen($type){
	$todate = substr(date("Ymd"),2,4);
	$row_p=sql_fetch("SELECT gen_no,regdate,gen_type FROM psj_gen_id where gen_type ='$type' ORDER BY gen_no DESC limit 1");

	$last_no = $row_p['gen_no'] + 1;
	$max = sprintf('%04d',$last_no);
	$id = $todate.sprintf('%04d',$last_no);

	$query_p = "INSERT INTO psj_gen_id set gen_type ='$type',regdate =Now(),gen_no = '$max'";

	 mysql_query($query_p);

	return $id;
}



//  코드번호 자동생성 함수 
    # type = regest(입관)
function  code_gen($part,$p_id,$pcode){

	if($part==1){

		$out_code =array();
		$row_pc = sql_fetch("SELECT code,sortno FROM psj_code where   part = '$part' ORDER BY sortno DESC limit 1");

		if(!$row_pc['code']){
		$out_code['code'] = 10000;
		$out_code['sortno']= 1;
		}else{
		$out_code['code'] =  $row_pc['code'] + 10000;
		$out_code['sortno'] =  $row_pc['sortno'] + 1;
		}

	}else{
	
		$row_pc = sql_fetch("SELECT code,sortno FROM psj_code where  part = '$part'  && p_id = '$p_id' ORDER BY sortno DESC limit 1");

		if(!$row_pc['code']){
		$out_code['code'] = $pcode + 100;
		$out_code['sortno']= 1;
		}else{
		$out_code['code'] =  $row_pc['code'] + 100;
		$out_code['sortno'] =  $row_pc['sortno'] + 1;
		}


	}


// 10100

	return $out_code;
}




	$arr_pay_type[1] = '현금';
	$arr_pay_type[2] = '카드';

	$arr_memo_type[1] = '일반';
	$arr_memo_type[2] = '상담';
	$arr_memo_type[3] = '결제';


# 수련실정보

/*
	$tmp_sql = mysql_query("select ho_id,hole_name from cf_hole_info ");
	$no = 0;
	while($tmp_row = mysql_fetch_array($tmp_sql)){
	$id = $tmp_row['ho_id'];
	$arr_hole[$id] = array($tmp_row['ho_id'],$tmp_row['hole_name']);
	$no++;
	}
*/

# 수업등록 COUNT

/*
	$tmp_sql = mysql_query("select cs_date,hole_code,count(*)as cnt from cf_class_info group by cs_date");
	$no = 0;
	while($tmp_row = mysql_fetch_array($tmp_sql)){
	
	$date = $tmp_row['cs_date'];
	$hcode = $tmp_row['hole_code'];
	
	$arr_class_cnt[$date][$hcode] = $tmp_row['cnt'];
	$no++;
	}

*/

# 수련실정보
/*
	$tmp_sql = mysql_query("select a.cs_date,a.hole_code,count(*)as cnt from cf_class_info a left  join cf_absent_info b on a.cs_id = b.class_id where 1  group by a.cs_date");
	$no = 0;
	while($tmp_row = mysql_fetch_array($tmp_sql)){
	
	$date = $tmp_row['cs_date'];
	$hcode = $tmp_row['hole_code'];
	
	$arr_ab_cnt[$date][$hcode] = $tmp_row['cnt'];
	$no++;
	}
*/
?>