<?php
include_once('./_common.php');

//include_once('/lib/register.lib.php');

$reg_mb_email = trim($_POST['reg_mb_email']);
$mb_id    = trim($_POST['reg_mb_id']);


set_session('ss_check_mb_email', '');

if ($msg = empty_mb_email($reg_mb_email))die($msg);
if ($msg = valid_mb_email($reg_mb_email))die($msg);
if ($msg = prohibit_mb_email($reg_mb_email))die($msg);
if ($msg = exist_mb_email($reg_mb_email, $mb_id))die($msg);
set_session('ss_check_mb_email', $reg_mb_email);

	
function valid_mb_email($reg_mb_email)
{
    if (!preg_match("/([0-9a-zA-Z_-]+)@([0-9a-zA-Z_-]+)\.([0-9a-zA-Z_-]+)/", $reg_mb_email))
	echo "110"; // 형식에 맞지 않습니다
}

function empty_mb_email($reg_mb_email)
{
    if (!trim($reg_mb_email))
	echo "120"; // 이메일을 입력해주세요
}

function exist_mb_email($reg_mb_email)
{
    $row = sql_fetch("select count(*) as cnt from psj_member where mb_email = '$reg_mb_email'");
    if ($row['cnt'] > 0)
	echo "130"; // 이미 사용중인 이메일
}

function prohibit_mb_email($reg_mb_email)
{
    list($id, $domain) = explode("@", $reg_mb_email);
 
	$tmp_emails = 'abc.com'; //$config['cf_prohibit_email'];

	$email_domains = explode("\n", trim($tmp_emails));
    $email_domains = array_map('trim', $email_domains);
    $email_domains = array_map('strtolower', $email_domains);
	$email_domain = strtolower($domain);

    if (in_array($email_domain, $email_domains))
	echo "140"; // 금지 메일 도메인 검사
}
	echo "000";


?>