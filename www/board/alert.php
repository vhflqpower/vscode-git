<?php
global $lo_location;
global $lo_url;

include_once('./_common.php');

if($error) {
    $g5['title'] = "오류안내 페이지";
} else {
    $g5['title'] = "결과안내 페이지";
}

?>


<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php

    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">'.PHP_EOL;

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<title><?php echo  $g5['title']; ?></title>
<?php
if (defined('G5_IS_ADMIN')) {
    if(!defined('_THEME_PREVIEW_'))
        echo '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin.css?ver='.G5_CSS_VER.'">'.PHP_EOL;
} else {
    echo '<link rel="stylesheet" href="'.G5_CSS_URL.'/'.(G5_IS_MOBILE?'mobile':'default').'.css?ver='.G5_CSS_VER.'">'.PHP_EOL;
}
?>

</head>
<body>

<?
// 필수 입력입니다.
// 양쪽 공백 없애기
// 필수 (선택 혹은 입력)입니다.
// 전화번호 형식이 올바르지 않습니다. 하이픈(-)을 포함하여 입력하세요.
// 이메일주소 형식이 아닙니다.
// 한글이 아닙니다. (자음, 모음만 있는 한글은 처리하지 않습니다.)
// 한글이 아닙니다.
// 한글, 영문, 숫자가 아닙니다.
// 한글, 영문이 아닙니다.
// 숫자가 아닙니다.
// 영문이 아닙니다.
// 영문 또는 숫자가 아닙니다.
// 영문, 숫자, _ 가 아닙니다.
// 최소 글자 이상 입력하세요.
// 이미지 파일이 아닙니다..gif .jpg .png 파일만 가능합니다.
// 파일만 가능합니다.
// 공백이 없어야 합니다.

$msg2 = str_replace("\\n", "<br>", $msg);

$url = clean_xss_tags($url);
if (!$url) $url = clean_xss_tags($_SERVER['HTTP_REFERER']);

$url = preg_replace("/[\<\>\'\"\\\'\\\"\(\)]/", "", $url);

// url 체크
check_url_host($url);

if($error) {
    $header2 = "다음 항목에 오류가 있습니다.";
} else {
    $header2 = "다음 내용을 확인해 주세요.";
}
?>

<script>
alert("<?php echo strip_tags($msg); ?>");
//document.location.href = "<?php echo $url; ?>";
<?php if ($url) { ?>
document.location.replace("<?php echo str_replace('&amp;', '&', $url); ?>");
<?php } else { ?>
//alert('history.back();');
history.back();
<?php } ?>
</script>

<noscript>
<div id="validation_check">
    <h1><?php echo $header2 ?></h1>
    <p class="cbg">
        <?php echo $msg2 ?>
    </p>
    <?php if($post) { ?>
    <form method="post" action="<?php echo $url ?>">
    <?php
    foreach($_POST as $key => $value) {
        if(strlen($value) < 1)
            continue;

        if(preg_match("/pass|pwd|capt|url/", $key))
            continue;
    ?>
    <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value ?>">
    <?php
    }
    ?>
    <input type="submit" value="돌아가기">
    </form>
    <?php } else { ?>
    <div class="btn_confirm">
        <a href="<?php echo $url ?>">돌아가기</a>
    </div>
    <?php } ?>


</div>
</noscript>

</body>
</html>