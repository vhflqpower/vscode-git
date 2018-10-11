<?
include_once("_common.php");


  $id = $_POST['id'];
  $oper = $_POST['oper'];

  $wr_date =   $_POST['request_date'];
  $br_id =  $_POST['br_id'];
  $sche_time =  $_POST['sche_time'];
  $photo_price =  $_POST['photo_price'];
  $cm_wname =  $_POST['cm_wname'];


  $co_id =  $member['mb_3'];

	$row = sql_fetch("select br_name from cc_brand where br_id = '$br_id'");
	$brand = $row['br_name'];

	$tmp_date = explode("-",$wr_date);
	$sche_date = $tmp_date[1].'월'.$tmp_date[2].'일';
	 $mb_id = $member['mb_id'];
	 $mb_name = $member['mb_name'];

	$sql = "INSERT INTO  `cc_planer_request` SET 
		br_id = '$br_id',
		wr_date = '$wr_date',
		wr_time = '$sche_time',
		wr_price = '$photo_price',
		mb_id = '$mb_id',
		mb_name = '$mb_name',
		st_regi_type = 3,
		wr_regdate = Now()";
	mysql_query($sql);


	$tmp_take = explode(":",$sche_time);


$cm_id = id_gen($seq='cm_no',$tb_name='cc_customer');

	$sql = "INSERT INTO  cc_customer  SET
			cm_id = '$cm_id',
			cm_wname = '$cm_wname'";
	 $result = mysql_query( $sql );


	$st_id = id_gen($seq='st_no',$tb_name='cc_photo');	
	$s_id = serial_gen($br_code,$colum='st_cs_serial',$tb_name='cc_photo'); 
	if($st_contract_status =='2')$SERIAL = "st_cs_serial = '$s_id',";

	$today = date("Y-m-d");

	$sql1 = "INSERT INTO  `cc_photo`  SET
			st_id = '$st_id',
			cm_id = '$cm_id',
			br_id = '$br_id',
			co_id = '$co_id',
			st_photo_type = '1',
			st_regi_type = '3',
			st_contract_status = '1',
			st_takepic_goto ='1',
			st_contract_date = '$today',
			rhs_takepic_date = '$wr_date',
			rhs_takepic_hour = '$tmp_take[0]',
			rhs_takepic_min = '$tmp_take[1]',
			rhs_planer_id = '$member[mb_id]',
			rhs_planer_hp = '$member[mb_hp]',
			rhs_etc   = '$rhs_etc',
			st_regdate = Now()";

	 $result = mysql_query( $sql1 );

// 브랜드  촬영일 촬영시간 
// 플래너
// 신부명은 잔여타임


	$data = sql_fetch("select manager1_hp from  cc_planer_promotion where po_id = 1");
	$manager1_hp = $data['manager1_hp'];
if($manager2_hp)$manager2Hp =','.$data['manager2_hp'];else $manager2Hp='';

	$snd_number='025156800';
    $rcv_number=$manager1_hp.','.$member['mb_hp'].$manager2Hp;
   // $sms_content= $mb_name.'플래너 촬영 스케쥴 홀딩 요청';

	$sms_content= $tmp_date[1].'월'.$tmp_date[2].'일'.$brand.'스튜디오'.$sche_time.'시 홀딩/ 24시간 이내 루체라운지 발주서 미확인시 취소';

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
	$userdefine = $sms_id;							//예약취소를 위해 넣어주는 구분자 정의값, 사용자 임의로 지정해주시면 됩니다.
																			//	영문으로 넣어주셔야 합니다. 사용자가 구분할 수 있는 값을 넣어주세요.
	$canclemode = "1";                //예약 취소 모드 1: 사용자정의값에 의한 삭제.  현제는 무조건 1을 넣어주시면 됩니다.

	include_once('../planer/nusoap_youiwe.php');

	$webService = "http://webservice.youiwe.co.kr/SMS.v.6/ServiceSMS.asmx?WSDL";

	$sms = new SMS($webService); //SMS 객체 생성


	/*즉시 전송으로 구성하실경우*/
	
	$sms_cont = iconv("euc-kr","utf-8",$sms_content);

	$result=$sms->SendSMS($sms_id,$sms_pwd,$snd_number,$rcv_number,$sms_content);// 5개의 인자로 함수를 호출합니다.

	$rcv_number = str_replace(",","",$rcv_number);
	$sms_content = iconv("EUC-KR","UTF-8",$sms_content);

if($result=='1'){
   $query = "INSERT INTO `cc_sms_log` SET sm_receive = '$rcv_number', sm_content = '$sms_content_log', sm_send_id = '$member[mb_id]', sm_regdate = Now()";
   mysql_query($query);
}



        $responce['flag'] = 'succ';
	    $responce['msg1'] = $sche_date.' '.$brand.' '.$sche_time.'시 스케쥴 예약 되었습니다.';
	    $responce['msg2'] = '루체라운지 발주서 미확인시 스케쥴은 자동적으로 취소됩니다.';


	echo json_encode($responce); 
	







?>
