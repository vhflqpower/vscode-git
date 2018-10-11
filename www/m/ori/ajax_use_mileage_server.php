<?
include_once("_common.php");


  $id = $_POST['id'];
  $type = $_POST['type'];


	$snd_number='025156800';
  //$rcv_number= '010-3789-8540'; 
    $rcv_number= '010-6414-9554';     // 김지선차장


	if($type==1){
		$sms_content = $member['mb_hp'].' '.$member['mb_name']. '플래너 백화점 상품권';

	}else{
		$sms_content = $member['mb_hp'].' '.$member['mb_name']. '마일리지 차감';
	}


	$callback = $_POST['callback'];

	$snd_number= $snd_number;  //보내는 사람 번호를 받음
	$reserve_date=$_POST["reserve_date"];	//예약 일자를 받음
	$reserve_time=$_POST["reserve_time"];		//예약 시간을 받음

	$sms_content_log = $sms_content;

	/******고객님 접속 정보************/
	$sms_id="lucestudio";         
	$sms_pwd="fncp68006704";      
	/**********************************/
	$callbackURL = "www.youiwe.co.kr";
	$userdefine = $sms_id;							
																			
	$canclemode = "1";    

	include_once('../planer/nusoap_youiwe.php');

	$webService = "http://webservice.youiwe.co.kr/SMS.v.6/ServiceSMS.asmx?WSDL";

	$sms = new SMS($webService);


	/*즉시 전송으로 구성하실경우*/
	
	$sms_cont = iconv("euc-kr","utf-8",$sms_content);

	$result=$sms->SendSMS($sms_id,$sms_pwd,$snd_number,$rcv_number,$sms_content);// 5개의 인자로 함수를 호출합니다.

	$rcv_number = str_replace(",","",$rcv_number);
	$sms_content = iconv("EUC-KR","UTF-8",$sms_content);

	if($result=='1'){
   
	}


        $responce['flag'] = 'succ';
	    $responce['msg1'] = '마일리지가 정상 사용되었습니다. 담당자를 통해 지급 드리겠습니다.';


	echo json_encode($responce); 
	







?>
