<?php
include_once('./_common.php');

if (!$is_member)
    alert('회원만 이용하실 수 있습니다.');

$me_id = (int)$_REQUEST['me_id'];

$g5[memo_table] = 'psj_memo';

if ($kind == 'recv')
{
    $t = '받은';
    $unkind = 'send';

    $sql = " update {$g5['memo_table']}
                set me_read_datetime = '".G5_TIME_YMDHIS."'
                where me_id = '$me_id'
                and me_recv_mb_id = '{$member['mb_id']}'
                and me_read_datetime = '0000-00-00 00:00:00' ";
    sql_query($sql);
}
else if ($kind == 'send')
{
    $t = '보낸';
    $unkind = 'recv';
}
else
{
    alert($kind.' 값을 넘겨주세요.');
}

$g5['title'] = $t.' 쪽지 보기';
//include_once(G5_PATH.'/head.sub.php');
include_once("../head.erd.php");

$sql = " select * from {$g5['memo_table']}
            where me_id = '$me_id'
            and me_{$kind}_mb_id = '{$member['mb_id']}' ";
$memo = sql_fetch($sql);

// 이전 쪽지
$sql = " select * from {$g5['memo_table']}
            where me_id > '{$me_id}'
            and me_{$kind}_mb_id = '{$member['mb_id']}'
            order by me_id asc
            limit 1 ";
$prev = sql_fetch($sql);
if ($prev['me_id'])
    $prev_link = './memo_view.php?kind='.$kind.'&amp;me_id='.$prev['me_id'];
else
    //$prev_link = 'javascript:alert(\'쪽지의 처음입니다.\');';
    $prev_link = '';


// 다음 쪽지
$sql = " select * from {$g5[memo_table]}
            where me_id < '{$me_id}'
            and me_{$kind}_mb_id = '{$member[mb_id]}'
            order by me_id desc
            limit 1 ";
$next = sql_fetch($sql);
if ($next['me_id'])
    $next_link = './memo_view.php?kind='.$kind.'&amp;me_id='.$next['me_id'];
else
    //$next_link = 'javascript:alert(\'쪽지의 마지막입니다.\');';
    $next_link = '';

$mb = get_member($memo['me_'.$unkind.'_mb_id']);

$list_link = './memo.php?kind='.$kind;

if(isset($page) && $page){
    $prev_link .= '&amp;page='.(int) $page;
    $next_link .= '&amp;page='.(int) $page;
    $list_link .= '&amp;page='.(int) $page;
}
?>

<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$nick = get_sideview($mb['mb_id'], $mb['mb_nick'], $mb['mb_email'], $mb['mb_homepage']);
if($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
}
else {
    $kind_str = "받는";
    $kind_date = "보낸";
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<link rel="stylesheet" href="/css/g5.theme.basic.default.css?ver=171222">
<link rel="stylesheet" href="/css/g5.skin.member.basic.style.css?ver=171222">
<!-- 쪽지보기 시작 { -->
<div id="memo_view" class="new_win">
    <h1 id="win_title"><i class="fa fa-envelope-o" aria-hidden="true"></i> <?php echo $g5['title'] ?></h1>
    <div class="new_win_con">
        <!-- 쪽지함 선택 시작 { -->
        <ul class="win_ul">
            <li class="<?php if ($kind == 'recv') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="<?php if ($kind == 'send') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li><a href="./memo_form.php">쪽지쓰기</a></li>
        </ul>
        <!-- } 쪽지함 선택 끝 -->

        <article id="memo_view_contents">
            <header>
                <h2>쪽지 내용</h2>
            </header>
            <ul id="memo_view_ul">
                <li class="memo_view_li memo_view_name">
                    <span class="memo_view_subj"><?php echo $kind_str ?>사람</span>
                    <strong><?php echo $nick ?></strong>
                </li>
                <li class="memo_view_li memo_view_date">
                    <span class="sound_only"><?php echo $kind_date ?>시간</span>
                    <strong><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $memo['me_send_datetime'] ?></strong>
                </li>
            </ul>
            <p>
                <?php echo conv_content($memo['me_memo'], 0) ?>
            </p>
        </article>


        <div class="win_btn">
            <?php if($prev_link) {  ?>
            <a href="<?php echo $prev_link ?>" class="btn btn_b01"><i class="fa fa-angle-left" aria-hidden="true"></i> 이전쪽지</a>
            <?php }  ?>
            <?php if($next_link) {  ?>
            <a href="<?php echo $next_link ?>" class="btn btn_b01">다음쪽지 <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            <?php }  ?>

            <a href="<?php echo $list_link ?>" class="btn btn_b01"><i class="fa fa-list" aria-hidden="true"></i> 목록</a>
            <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
            <?php if ($kind == 'recv') {  ?><a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="btn btn_b02">답장</a><?php }  ?>
        </div>
    </div>
</div>
<!-- } 쪽지보기 끝 -->

<?
include_once("../tail.sub.php");
?>
