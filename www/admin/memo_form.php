<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

if ($is_guest)
    alert_close('회원만 이용하실 수 있습니다.');

if (!$member['mb_open'] && $is_admin != 'super' && $member['mb_id'] != $mb_id)
    alert_close("자신의 정보를 공개하지 않으면 다른분에게 쪽지를 보낼 수 없습니다. 정보공개 설정은 회원정보수정에서 하실 수 있습니다.");

$content = "";
// 탈퇴한 회원에게 쪽지 보낼 수 없음
if ($me_recv_mb_id)
{
    $mb = get_member($me_recv_mb_id);
    if (!$mb['mb_id'])
        alert_close('회원정보가 존재하지 않습니다.\\n\\n탈퇴하였을 수 있습니다.');

    if (!$mb['mb_open'] && $is_admin != 'super')
        alert_close('정보공개를 하지 않았습니다.');

    // 4.00.15
    $row = sql_fetch(" select me_memo from {$g5['memo_table']} where me_id = '{$me_id}' and (me_recv_mb_id = '{$member['mb_id']}' or me_send_mb_id = '{$member['mb_id']}') ");
    if ($row['me_memo'])
    {
        $content = "\n\n\n".' >'
                         ."\n".' >'
                         ."\n".' >'.str_replace("\n", "\n> ", get_text($row['me_memo'], 0))
                         ."\n".' >'
                         .' >';

    }
}

$g5['title'] = '쪽지 보내기';
//include_once(G5_PATH.'/head.sub.php');
include_once("../head.erd.php");

//$memo_action_url = G5_HTTPS_BBS_URL."/memo_form_update.php";
$memo_action_url = "./memo_form_update.php";

?>
<link rel="stylesheet" href="/css/g5.theme.basic.default.css?ver=171222">
<link rel="stylesheet" href="/css/g5.skin.member.basic.style.css?ver=171222">

<!-- 쪽지 보내기 시작 { -->
<div id="memo_write" class="new_win">
    <h1 id="win_title"><i class="fa fa-envelope-o" aria-hidden="true"></i> 쪽지 보내기</h1>
    <div class="new_win_con">
        <ul class="win_ul">
            <li><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li class="selected"><a href="./memo_form.php">쪽지쓰기</a></li>
        </ul>

        <form name="fmemoform" action="<?php echo $memo_action_url; ?>" onsubmit="return fmemoform_submit(this);" method="post" autocomplete="off">
        <div class="form_01">
            <h2 class="sound_only">쪽지쓰기</h2>
            <ul>
                <li>
                    <label for="me_recv_mb_id" class="sound_only">받는 회원아이디<strong>필수</strong></label>
                    
                    <input type="text" name="me_recv_mb_id" value="<?php echo $me_recv_mb_id ?>" id="me_recv_mb_id" required class="frm_input full_input required" size="47" placeholder="받는 회원아이디">
                    <span class="frm_info">여러 회원에게 보낼때는 컴마(,)로 구분하세요.</span>
                    <?php if ($config['cf_memo_send_point']) { ?>
                    <br ><span class="frm_info">쪽지 보낼때 회원당 <?php echo number_format($config['cf_memo_send_point']); ?>점의 포인트를 차감합니다.</span>
                    <?php } ?>
                </li>
                <li>
                    <label for="me_memo" class="sound_only">내용</label>
                    <textarea name="me_memo" id="me_memo" required class="required"><?php echo $content ?></textarea>
                </li>
                <li>
                    <span class="sound_only">자동등록방지</span>
                    
                    <?php echo captcha_html(); ?>
                    
                </li>
            </ul>
        </div>

        <div class="win_btn">
            <input type="submit" value="보내기" id="btn_submit" class="btn_submit">
            <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
        </div>
    </div>
    </form>
</div>

<script>
function fmemoform_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
<?
include_once(G5_PATH.'/tail.sub.php');
?>
