<?

	//define('G5_MYSQL_HOST', 'localhost');
	//define('G5_MYSQL_USER', 'commercelab');
	//define('G5_MYSQL_PASSWORD', 'comm2017&');
	//define('G5_MYSQL_DB', 'commercelab');
	define('G5_MYSQL_SET_MODE', false);

	// MySQLi 사용여부를 설정합니다.
	define('G5_MYSQLI_USE', true);

	// mysql connect resource $g5 배열에 저장 - 명랑폐인님 제안
	define('G5_DISPLAY_SQL_ERROR', TRUE);


	define('G5_DOMAIN', '');
	define('G5_HTTPS_DOMAIN', '');
	// URL 은 브라우저상에서의 경로 (도메인으로 부터의)
	if (G5_DOMAIN) {
	    define('G5_URL', G5_DOMAIN);
	} else {
	    if (isset($g5_path['url']))
	        define('G5_URL', $g5_path['url']);
	    else
	        define('G5_URL', '');
	}

	if (isset($g5_path['path'])) {
	    define('G5_PATH', $g5_path['path']);
	} else {
	    define('G5_PATH', '');
	}


	define('G5_LIB_DIR',        'lib');
	define('G5_BBS_DIR',        'bbs');
	define('G5_DATA_DIR',       'data');
	define('G5_SESSION_DIR',    'session');
	define('G5_BOARD_URL',       'board');

	define('G5_BBS_URL',        G5_URL.'/'.G5_BBS_DIR);
	define('G5_DATA_URL',       G5_URL.'/'.G5_DATA_DIR);
	define('G5_IMG_URL',        G5_URL.'/'.G5_IMG_DIR);
	define('G5_JS_URL',         G5_URL.'/'.G5_JS_DIR);
	define('G5_SKIN_URL',       G5_URL.'/'.G5_SKIN_DIR);
	define('G5_SESSION_PATH',   G5_DATA_PATH.'/'.G5_SESSION_DIR);

	define('G5_ESCAPE_FUNCTION', 'sql_escape_string');

	// 페이지 헤더 인코딩 설정
	@header("Content-Type: text/html; charset=utf-8");






?>