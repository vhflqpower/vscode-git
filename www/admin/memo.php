<?
include_once('./_common.php');
if ($is_guest)
    alert_close('회원만 이용하실 수 있습니다.');

set_session('ss_memo_delete_token', $token = uniqid(time()));

$g5['title'] = '내 쪽지함';
include_once(G5_PATH.'/head.sub.php');

$g5['memo_table'] = 'psj_message';

$kind = $kind ? clean_xss_tags(strip_tags($kind)) : 'recv';

if ($kind == 'recv')
    $unkind = 'send';
else if ($kind == 'send')
    $unkind = 'recv';
else
    alert(''.$kind .'값을 넘겨주세요.');

$sql = " select count(*) as cnt from {$g5['memo_table']} where me_{$kind}_mb_id = '{$member['mb_id']}' ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$total_page  = ceil($total_count / $config['cf_page_rows']);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ((int) $page - 1) * $config['cf_page_rows']; // 시작 열을 구함

if ($kind == 'recv')
{
    $kind_title = '받은';
    $recv_img = 'on';
    $send_img = 'off';
}
else
{
    $kind_title = '보낸';
    $recv_img = 'off';
    $send_img = 'on';
}

$list = array();

$sql = " select a.*, b.mb_id, b.mb_nick, b.mb_email, b.mb_homepage
            from {$g5['memo_table']} a
            left join {$g5['member_table']} b on (a.me_{$unkind}_mb_id = b.mb_id)
            where a.me_{$kind}_mb_id = '{$member['mb_id']}'
            order by a.me_id desc limit $from_record, {$config['cf_page_rows']} ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
{
    $list[$i] = $row;

    $mb_id = $row["me_{$unkind}_mb_id"];

    if ($row['mb_nick'])
        $mb_nick = $row['mb_nick'];
    else
        $mb_nick = '정보없음';

    $name = get_sideview($row['mb_id'], $row['mb_nick'], $row['mb_email'], $row['mb_homepage']);

    if (substr($row['me_read_datetime'],0,1) == 0)
        $read_datetime = '아직 읽지 않음';
    else
        $read_datetime = substr($row['me_read_datetime'],2,14);

    $send_datetime = substr($row['me_send_datetime'],2,14);

    $list[$i]['name'] = $name;
    $list[$i]['send_datetime'] = $send_datetime;
    $list[$i]['read_datetime'] = $read_datetime;
    $list[$i]['view_href'] = './memo_view.php?me_id='.$row['me_id'].'&amp;kind='.$kind.'&amp;page='.$page;
    $list[$i]['del_href'] = './memo_delete.php?me_id='.$row['me_id'].'&amp;token='.$token.'&amp;kind='.$kind;
}

$write_pages = get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "./memo.php?kind=$kind".$qstr."&amp;page=");


include_once("../head.erd.php");
?>
<link rel="stylesheet" href="/css/g5.theme.basic.default.css?ver=171222">
<!-- <link rel="stylesheet" href="http://g5.master36.com/skin/member/basic/style.css?ver=171222">
 -->
<!-- 쪽지 목록 시작 { -->
<div id="memo_list" class="new_win">
    <h1 id="win_title"><i class="fa fa-envelope-o" aria-hidden="true"></i>내쪽지함</h1>
    <div class="new_win_con">
        <ul class="win_ul">
            <li class="<? if ($kind == 'recv') {  ?>selected<? }  ?>"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="<? if ($kind == 'send') {  ?>selected<? }  ?>"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li><a href="./memo_form.php">쪽지쓰기</a></li>
        </ul>
        <div class="win_total">
            <span>
                전체 <? echo $kind_title ?>쪽지 <? echo $total_count ?>통<br>
            </span>
        </div>
        <div class="list_01">

            <ul>
            <? for ($i=0; $i<count($list); $i++) {  ?>
            <li>
                <span class="memo_name"><a href="<? echo $list[$i]['view_href'] ?>"><? echo $list[$i]['mb_nick'] ?></a></span>
                <span class="memo_datetime"><? echo $list[$i]['send_datetime'] ?> - <? echo $list[$i]['read_datetime'] ?> <a href="<? echo $list[$i]['del_href'] ?>" onclick="del(this.href); return false;" class="memo_del"><i class="fa fa-times-circle" aria-hidden="true"></i> <span class="sound_only">삭제</span></a></span>
            </li>
            <? }  ?>
            <? if ($i==0) { echo '<li class="empty_table">자료가 없습니다.</li>'; }  ?>
            </ul>
        </div>

        <!-- 페이지 -->
        <? echo $write_pages; ?>

        <p class="win_desc">
            쪽지 보관일수는 최장 <strong><? echo $config['cf_memo_del'] ?></strong>일 입니다.
        </p>

        <div class="win_btn">
            <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
        </div>
    </div>
</div>
<!-- } 쪽지 목록 끝 -->



<?
include_once("../tail.sub.php");
?>

