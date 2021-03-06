<?php

	include_once('_common.php');


	/*-----------------------------------------------------------
	
		$strToCall		: 수신번호(번호1;번호2;번호3)
		$strCallBack	: 발신번호(15880055)
		$strMsg			: 전송메시지(1~2,000)
		$reqFlag			: 즉시전송(0), 예약전송(1)
		$strDate			: 예약전송 시간(예:201505131540)
		
		$register_uid			: 전송자(등록자) 고유번호
		$smsi_etc1 ~ 4		: 기타정보1~4 (INT타입)
		$smsi_etc5 ~ 9		: 기타정보5~9 (CHAR타입)
		$smsi_etc10				: 기타정보10 (INT타입)
	
	----------------------------------------------------------- */
	
	@include_once "../lib/sms.class.php";
	

	$ids = $_POST[ids];
	$en_id = $_POST[en_id];


	if($mode=='come'){  // 다가올 상품

		$tt_mb_hp = '';
		for ($i=0; $i < count($ids); $i++) {
			$en_id = $ids[$i];	
			$row = sql_fetch("select 
									a.gd_id,
									b.mb_hp 
								from
									
									tt_come_goods_sms a, tt_member b
								where 
									a.mb_id = b.mb_id
									and a.sm_id = '$en_id'
									");
			$tt_mb_hp  .= $row[mb_hp].",";

			$row_goods_id =  $row[gd_id]; 	
		}

	}else{

		$tt_mb_hp = '';
		for ($i=0; $i < count($ids); $i++) {
			$en_id = $ids[$i];	
			$row = sql_fetch("select 
									a.gd_id,
									b.mb_hp 
								from
									
									tt_goods_encore a, tt_member b
								where 
									a.mb_id = b.mb_id
									and a.en_id = '$en_id'
									");
			$tt_mb_hp  .= $row[mb_hp].",";
			$row_goods_id =  $row[gd_id];
		}


	}



	$row = sql_fetch("select gd_name from tt_goods where gd_no = '$row_goods_id'");




	if($_POST[exe] == "Y")
	{
		$strCallBack = "023133310";
		$strToCall = $tt_mb_hp;// $_POST[mb_hp];

	if($mode=='come'){  // 다가올 상품
			$strMsg = "다가올 상품요청내역 (".$row[gd_name].")";
	}else{  // 마감된 상품 앵콜요청
			$strMsg = "앵콜요청내역 (".$row[gd_name].")";
	}


		//$strMsg = "앵콜요청내역".$row[gd_name];
		$reqFlag = 0;
		$strDate = null;
	}


	if( strlen($strToCall) >= 1 AND strlen($strCallBack) >= 1 AND  strlen($strMsg) >= 1 AND strlen($reqFlag) )
	{

		// SMS아이 서버
			$socket_host	= "121.254.253.172";
			$smsi_id	= "tagintag";				// SMS아이 회원가입하신 아이디(4~15자)
			$smsi_pw = "tit3133310";			// 패스워드(8~15자)

		// SMS 모듈 클래스 생성
			$SMS = new SMS;
			$SMS->SMS_Con($socket_host, $smsi_id, $smsi_pw);

		// 발신자, 메시지 내용, 예약날짜 변수 정의
			$strToCall = $strToCall;
			$strCallBack = $strCallBack;
			$strDate = $strDate;
			$strMsg = $strMsg2 = $strMsg;
			$strMsgLength = strlen(iconv('UTF-8','EUC-KR',$strMsg2));
			#echo "strMsgLength : ".$strMsgLength;exit;
			$sType = ( $strMsgLength >= 91)?"L":"S";
			$fld_sendtime = ($reqFlag == 1)?substr($strDate,0,4)."-".substr($strDate,4,2)."-".substr($strDate,6,2)." ".substr($strDate,8,2).":".substr($strDate,10,2).":00":null;
			$register_uid = ( strlen($register_uid) >= 1 )?$register_uid:0;
			$smsi_etc1 = ( strlen($smsi_etc1) >= 1 )?$smsi_etc1:0;
			$smsi_etc2 = ( strlen($smsi_etc2) >= 1 )?$smsi_etc2:0;
			$smsi_etc3 = ( strlen($smsi_etc3) >= 1 )?$smsi_etc3:0;
			$smsi_etc4 = ( strlen($smsi_etc4) >= 1 )?$smsi_etc4:0;

		// 발송하기위해 패킷을 정의합니다.
			$result = $SMS->Add($sType, $strToCall, $strCallBack, stripslashes($strMsg), $strDate);

		// 리턴값을 확인하는 부분
			if ($result) 
			{
				$result = $SMS->Send();		// 발송처리
	
				if ($result) 
				{
	
					$success = $fail = 0;
					
					foreach($SMS->Result as $result) 
					{
			
						list($phone,$err_msg) = explode(" : ",$result);
						$err_msg = trim($err_msg);
			
						if ($err_msg == "SUCC") 
						{
							$RE_OBJ[msg] = $phone." 으로 전송했습니다. (메시지 코드 : ".$err_msg.")<br>";
							$success++;
						} 
						else 
						{
							$RE_OBJ[msg] = $phone.'로 발송하는데 에러가 발생했습니다.<br>';
							switch ($err_msg) 
							{
								case 'ERR_NoXmsCompany':
									$RE_OBJ[msg] = "LMS 발송 권한이 없습니다. 고객센타로 문의해 주시기 바랍니다. (".$err_msg.")<br>";
								break;
								case 'ERR_DelCompany':
								$RE_OBJ[msg] = "삭제된 고객사 입니다. 고객센타로 문의해 주시기 바랍니다.(".$err_msg.")<br>";
								break;
								case 'ERR_NoSms_Blocking':
									$RE_OBJ[msg] = "수신거부 차단되었습니다.(".$err_msg.")<br>";
								break;
								case 'ERR_NoReq':
								$RE_OBJ[msg] = "예약설정이 올바르지 않습니다.(".$err_msg.")<br>";
								break;
								case 'ERR_NotSmsUse':
									$RE_OBJ[msg] = "SMS 발송 권한이 없습니다. 고객센타로 문의해 주시기 바랍니다.(".$err_msg.")<br>";
								break;
								case 'ERR_NotMmsUse':
									$RE_OBJ[msg] = "LMS 발송 권한이 없습니다. 고객센타로 문의해 주시기 바랍니다.(".$err_msg.")<br>";
								break;
								case 'ERR_NoPoint':
									$RE_OBJ[msg] = "충전 포인트가 부족합니다.(".$err_msg.")<br>";
								break;
								case 'Not_Auth':
									$RE_OBJ[msg] = "사용자 인증실패하였습니다.(".$err_msg.")<br>";
								break;
								default:
									$RE_OBJ[msg] = "알 수 없는 오류로 전송이 실패하였습니다.(".$err_msg.")<br>";
								break;
							}
							$fail++;
						}
					}
	
					//	echo number_format($success)." 건을 전송, ".number_format($fail)." 건 실패.<br>";
						$SMS->Init();		// 결과값 초기화
				}
				else 
				{
					$RE_OBJ[msg] ="에러: SMS 서버와 통신이 불안정합니다.";
					exit;
				}
			}
	}
	else
	{
		$RE_OBJ[msg] = "발송처리된게 없습니다.";
		exit;
	}


	// 파라미터
	//$_post = print_r($_POST, true);
	//$en_id = $_POST[en_id];






		for ($i=0; $i < count($ids); $i++) {
			$en_id = $ids[$i];	
		$sql = "
			UPDATE  tt_goods_encore  SET
				send_datetime = Now()
			WHERE en_id = '$en_id'";	
			$result = sql_query($sql);		

		}


		if( !$result ) {
			$RE_OBJ[msg] = "입력 실패 입니다";
			writeLog( "ajax_log", $_SERVER[PHP_SELF]." \n _post: $_post  \n $RE_OBJ[msg] \n sql: $sql  ");
			echo json_encode($RE_OBJ);
			exit;
		}

	$RE_OBJ['flag'] = 'succ';
	//writeLog( "ajax_log", $_SERVER[PHP_SELF]." \n 상품문의 \n $_post  \n $sql \n $query2   ");




	echo json_encode($RE_OBJ);

?>

