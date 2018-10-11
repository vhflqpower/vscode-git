<?
	include_once("./_common.php");
// echo "한글"로 출력하지 않는 이유는 Ajax 는 euc_kr 에서 한글을 제대로 인식하지 못하기 때문
// 여기에서 영문으로 echo 하여 Request 된 값을 Javascript 에서 한글로 메세지를 출력함



if (trim($reg_mb_email)=='') {
    echo "110"; // 입력이 없습니다.
} else if (!preg_match("/^([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)$/", $reg_mb_email)) {
    echo "120"; // E-mail 주소 형식에 맞지 않음
} else {
    $row = sql_fetch(" select count(*) as cnt from psj_member where mb_id <> '$reg_mb_id' and mb_email = '$reg_mb_email' ");
    if ($row[cnt]) {
        echo "130"; // 이미 존재하는 회원아이디
    } else {
        //if (preg_match("/[\,]?{$reg_mb_email}\,/i", $config[cf_prohibit_id].","))   $config[cf_prohibit_id]
        if (preg_match("/[\,]?{$reg_mb_email}/i",'admin'))
            echo "140"; // 예약어로 금지된 회원아이디
        else
            echo "000"; // 정상
    }
}




?>
