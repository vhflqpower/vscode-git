<?php
define('G5_CAPTCHA', true);
include_once('../common.php');

//include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$g5['board_new_table'] = 'psj_board_new';
$g5['board_table']  = 'psj_board_config';
$write_table = 'psj_board';

// 토큰체크

/*
$comment_token = trim(get_session('ss_comment_token'));
set_session('ss_comment_token', '');
if(!trim($_POST['token']) || !$comment_token || $comment_token != $_POST['token'])
    alert('올바른 방법으로 이용해 주십시오.');
*/


// 090710
if (substr_count($wr_content, "&#") > 50) {
    alert('내용에 올바르지 않은 코드가 다수 포함되어 있습니다.');
    exit;
}



$w = $_POST["w"];
$wr_name  = trim($_POST['wr_name']);
$wr_email = '';
if (!empty($_POST['wr_email']))
    $wr_email = get_email_address(trim($_POST['wr_email']));

// 비회원의 경우 이름이 누락되는 경우가 있음
if ($is_guest) {
    if ($wr_name == '')
        alert('이름은 필히 입력하셔야 합니다.');
    if(!chk_captcha())
        alert('자동등록방지 숫자가 틀렸습니다.');
}

/*
if ($w == "c" || $w == "cu") {
    if ($member['mb_level'] < $board['bo_comment_level'])
        alert('댓글을 쓸 권한이 없습니다.');
}
else
    alert('w 값이 제대로 넘어오지 않았습니다.');
*/


// 세션의 시간 검사
// 4.00.15 - 댓글 수정시 연속 게시물 등록 메시지로 인한 오류 수정
/*
if ($w == 'c' && $_SESSION['ss_datetime'] >= (G5_SERVER_TIME - $config['cf_delay_sec']) && !$is_admin)
    alert('너무 빠른 시간내에 게시물을 연속해서 올릴 수 없습니다.');
*/

//  set_session('ss_datetime', G5_SERVER_TIME);

$wr = get_write($write_table, $wr_id);
if (empty($wr['wr_id']))
    alert("글이 존재하지 않습니다.\\n글이 삭제되었거나 이동하였을 수 있습니다.");


/*
if ($is_member)
{
    $mb_id = $member['mb_id'];
    # 4.00.13 - 실명 사용일때 댓글에 닉네임으로 입력되던 오류를 수정
    $wr_name = addslashes(clean_xss_tags($board['bo_use_name'] ? $member['mb_name'] : $member['mb_nick']));
    $wr_password = $member['mb_password'];
    $wr_email = addslashes($member['mb_email']);
    $wr_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
}
else
{
    $mb_id = '';
    $wr_password = get_encrypt_string($wr_password);
}
*/



if ($w == 'c') // 댓글 입력
{



    // 댓글 답변
    if ($comment_id)
    {
        $sql = " select wr_id, wr_parent, wr_comment, wr_comment_reply from $write_table
                    where wr_id = '$comment_id' ";
        $reply_array = sql_fetch($sql);
        if (!$reply_array['wr_id'])
            alert('답변할 댓글이 없습니다.\\n\\n답변하는 동안 댓글이 삭제되었을 수 있습니다.');

        if($wr['wr_parent'] != $reply_array['wr_parent'])
            alert('댓글을 등록할 수 없습니다.');

        $tmp_comment = $reply_array['wr_comment'];

        if (strlen($reply_array['wr_comment_reply']) == 5)
            alert('더 이상 답변하실 수 없습니다.\\n\\n답변은 5단계 까지만 가능합니다.');

        $reply_len = strlen($reply_array['wr_comment_reply']) + 1;
        if ($board['bo_reply_order']) {
            $begin_reply_char = 'A';
            $end_reply_char = 'Z';
            $reply_number = +1;
            $sql = " select MAX(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply
                        from $write_table
                        where wr_parent = '$wr_id'
                        and wr_comment = '$tmp_comment'
                        and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";
        }
        else
        {
            $begin_reply_char = 'Z';
            $end_reply_char = 'A';
            $reply_number = -1;
            $sql = " select MIN(SUBSTRING(wr_comment_reply, $reply_len, 1)) as reply
                        from $write_table
                        where wr_parent = '$wr_id'
                        and wr_comment = '$tmp_comment'
                        and SUBSTRING(wr_comment_reply, $reply_len, 1) <> '' ";
        }
        if ($reply_array['wr_comment_reply'])
            $sql .= " and wr_comment_reply like '{$reply_array['wr_comment_reply']}%' ";
        $row = sql_fetch($sql);

        if (!$row['reply'])
            $reply_char = $begin_reply_char;
        else if ($row['reply'] == $end_reply_char) // A~Z은 26 입니다.
            alert('더 이상 답변하실 수 없습니다.\\n\\n답변은 26개 까지만 가능합니다.');
        else
            $reply_char = chr(ord($row['reply']) + $reply_number);

        $tmp_comment_reply = $reply_array['wr_comment_reply'] . $reply_char;
    }
    else
    {
        $sql = " select max(wr_comment) as max_comment from $write_table
                    where wr_parent = '$wr_id' and wr_is_comment = 1 ";
        $row = sql_fetch($sql);
        //$row[max_comment] -= 1;
        $row['max_comment'] += 1;
        $tmp_comment = $row['max_comment'];
        $tmp_comment_reply = '';
    }

   // $wr_subject = get_text(stripslashes($wr['wr_subject']));

    $sql = " insert into $write_table
                set ca_name = '{$wr['ca_name']}',
                     wr_option = '$wr_secret',
                     wr_num = '{$wr['wr_num']}',
                     wr_reply = '',
                     wr_parent = '$wr_id',
                     wr_is_comment = 1,
                     wr_comment = '$tmp_comment',
                     wr_comment_reply = '$tmp_comment_reply',
                     wr_subject = '',
                     wr_content = '$wr_content',
                     mb_id = '$mb_id',
                     wr_password = '$wr_password',
                     wr_name = '$wr_name',
                     wr_email = '$wr_email',
                     wr_homepage = '$wr_homepage',
                     wr_datetime = Now(),
                     wr_last = '',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}' ";
    sql_query($sql);

    $comment_id = sql_insert_id();

    // 원글에 댓글수 증가 & 마지막 시간 반영
    sql_query(" update $write_table set wr_comment = wr_comment + 1, wr_last = Now() where wr_id = '$wr_id' ");
    # 새글 INSERT
    sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '$bo_table', '$comment_id', '$wr_id', Now(), '{$member['mb_id']}' ) ");
    // 댓글 1 증가
    sql_query(" update {$g5['board_table']} set bo_count_comment = bo_count_comment + 1 where bo_table = '$bo_table' ");

    // 포인트 부여

/*
    insert_point($member['mb_id'], $board['bo_comment_point'], "{$board['bo_subject']} {$wr_id}-{$comment_id} 댓글쓰기", $bo_table, $comment_id, '댓글');
*/



	// 메일발송
	########################

	########################


    // SNS 등록
    // include_once("./write_comment_update.sns.php");
    
	
	
/*	
	if($wr_facebook_user || $wr_twitter_user) {
        $sql = " update $write_table
                    set wr_facebook_user = '$wr_facebook_user',
                        wr_twitter_user  = '$wr_twitter_user'
                    where wr_id = '$comment_id' ";
        sql_query($sql);
    }
*/


}
else if ($w == 'cu') // 댓글 수정
{
    $sql = " select mb_id, wr_password, wr_comment, wr_comment_reply from $write_table
                where wr_id = '$comment_id' ";
    $comment = $reply_array = sql_fetch($sql);
    $tmp_comment = $reply_array['wr_comment'];

    $len = strlen($reply_array['wr_comment_reply']);
    if ($len < 0) $len = 0;
    $comment_reply = substr($reply_array['wr_comment_reply'], 0, $len);
    //print_r2($GLOBALS); exit;

    if ($is_admin == 'super') // 최고관리자 통과
        ;
    else if ($is_admin == 'group') { // 그룹관리자
        $mb = get_member($comment['mb_id']);
        if ($member['mb_id'] == $group['gr_admin']) { // 자신이 관리하는 그룹인가?
            if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                alert('그룹관리자의 권한보다 높은 회원의 댓글이므로 수정할 수 없습니다.');
        } else
            alert('자신이 관리하는 그룹의 게시판이 아니므로 댓글을 수정할 수 없습니다.');
    } else if ($is_admin == 'board') { // 게시판관리자이면
        $mb = get_member($comment['mb_id']);
        if ($member['mb_id'] == $board['bo_admin']) { // 자신이 관리하는 게시판인가?
            if ($member['mb_level'] >= $mb['mb_level']) // 자신의 레벨이 크거나 같다면 통과
                ;
            else
                alert('게시판관리자의 권한보다 높은 회원의 댓글이므로 수정할 수 없습니다.');
        } else
            alert('자신이 관리하는 게시판이 아니므로 댓글을 수정할 수 없습니다.');
    } else if ($member['mb_id']) {
        if ($member['mb_id'] != $comment['mb_id'])
            alert('자신의 글이 아니므로 수정할 수 없습니다.');
    } else {
        if($comment['wr_password'] != $wr_password)
            alert('댓글을 수정할 권한이 없습니다.');
    }

    $sql = " select count(*) as cnt from $write_table
                where wr_comment_reply like '$comment_reply%'
                and wr_id <> '$comment_id'
                and wr_parent = '$wr_id'
                and wr_comment = '$tmp_comment'
                and wr_is_comment = 1 ";
    $row = sql_fetch($sql);
    if ($row['cnt'] && !$is_admin)
        alert('이 댓글와 관련된 답변댓글이 존재하므로 수정 할 수 없습니다.');

    $sql_ip = "";
    if (!$is_admin)
        $sql_ip = " , wr_ip = '{$_SERVER['REMOTE_ADDR']}' ";

    $sql_secret = "";
    if ($wr_secret)
        $sql_secret = " , wr_option = '$wr_secret' ";

    $sql = " update $write_table
                set wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     wr_option = '$wr_option'
                     $sql_ip
                     $sql_secret
              where wr_id = '$comment_id' ";
    sql_query($sql);
}

// 사용자 코드 실행
//@include_once($board_skin_path.'/write_comment_update.skin.php');
//@include_once($board_skin_path.'/write_comment_update.tail.skin.php');

	// delete_cache_latest($bo_table);

goto_url('./view.php?bo_table='.$bo_table.'&wr_id='.$wr['wr_parent'].'&'.$qstr.'&amp;#c_'.$comment_id);
?>
