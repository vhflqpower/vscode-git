<?
	include_once("./_common.php");
// echo "한글"로 출력하지 않는 이유는 Ajax 는 euc_kr 에서 한글을 제대로 인식하지 못하기 때문
// 여기에서 영문으로 echo 하여 Request 된 값을 Javascript 에서 한글로 메세지를 출력함


if (!preg_match("/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/",$mb_email)) {
    echo "110"; // 유효하지 않은 회원아이디
} else if (strlen($mb_email) < 4) {
    echo "120"; // 3보다 작은 회원아이디
} else {

	//echo "select count(*) as cnt from $g4[member_table] where mb_cd = '$reg_mb_cd' ";

//$mb_email = rawurldecode($mb_email);


    $row = sql_fetch("select count(*) as cnt from psj_member where mb_email = '$mb_email' ");

    if ($row[cnt] > 0) {
        echo "130"; // 이미 존재하는 회원아이디
    } else {
            echo "000"; // 정상
    }
}
?>
