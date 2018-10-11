<?
$app_path = ".."; // common.php 의 상대 경로
include_once("../common.php");


    if ($member[mb_level] < 2 && $member[mb_intercept_date] =='')
    {
        if ($member[mb_id])
            alert("글을 읽을 권한이 없습니다.", $g4[path]);
        else
            alert("접근 권한이 없습니다.\\n\\회원이시라면 관리자에게 문의해 보십시오.", "./login.php?wr_id=$wr_id{$qstr}&url=".urlencode("/admin/main.php"));
    }


        $sql_memo = " select count(*) as cnt from psj_memo where me_recv_mb_id = '{$member['mb_id']}' and me_read_datetime = '0000-00-00 00:00:00' ";
        $row_memo = sql_fetch($sql_memo);
        $memo_not_read = $row_memo['cnt'];
?>