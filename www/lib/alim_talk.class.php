<?
@include_once($Dir."alimtalk/config.php");
class ALIM_TALK{

    public $jsonData = array();					// 요청 데이터 배열
    public $jsonDecodeData = array();		// 요청 데이터 배열
    public $ataContents = array();				// 치환된 본문 내용
    public $ataDbFlag = true;
    /*
        #{브랜드} : #{brand_name}
        #{고객명} : #{order_name}
        #{상품코드} : #{product_code}
        #{실결제금액} : #{order_price}
        #{가상계좌번호} : #{virtual_number}
        #{은행명} : #{bank_name}
        #{입금자명} : #{deposit_name}
        #{입금액} : #{deposit_price}
        #{주문조회 url} : #{order_url}
        #{배송지 주소1+주소2} : #{deli_address}
        #{색상} : #{color_str}
        #{사이즈} : #{size_str}
        #{수량} : #{quantity}
        #{운송장번호} : #{deli_code}
        #{구매확정 url} : #{confirm_url}
        #{play store url} : #{play_store_url}
        #{ios app store url} : #{app_store_url}

        #{픽업매장명} : #{pickup_store}
        #{픽업매장연락처} : #{pickup_tel}
        #{픽업매장주소} : #{pickup_address}
        #{픽업일자} : #{pickup_date}

        #{매장명} : #{store_name}

        #{예약매장명} : #{reserve_store}
        #{예약매장연락처} : #{reserve_tel}
        #{예약매장주소} : #{reserve_address}
        #{수령일자} : #{reserve_date}
    */

    function ALIM_TALK(){
        $this->jsonData = "";
        $this->jsonDecodeData = "";
    }

    function makeJsonDecodeData(){
        $this->jsonDecodeData = json_decode($this->jsonData);
    }

    function makeAlimTalkSearchData($ordercode, $template, $idx = "", $oc_no = ""){
        GLOBAL $pg_code, $alimConf;
        /*
        주문 리스트에 있는 조건 가져와서 사용
        tblorderproduct a join tblorderinfo b

        oi_step1 = "0" > 주문접수
        oi_step1 = "1" > 결제완료
        oi_step1 = "2" > 배송준비중
        oi_step1 = "3" > 배송중
        oi_step1 = "4" > 배송완료
        oi_step1 = "44" > 입금전취소완료
        oi_step1 = "67" > 교환신청
        oi_step1 = "61" > 교환접수
        oi_step1 = "62" > 교환완료
        oi_step1 = "68" > 반품신청
        oi_step1 = "63" > 반품접수
        oi_step1 = "64" > 반품완료
        oi_step1 = "65" > 환불접수
        oi_step1 = "66" > 환불완료

        OR

        if(count($oi_type_arr)) {
            foreach($oi_type_arr as $k => $v) {
                switch($v) {
                    case 44 : $subWhere[] = " (b.oi_step1 = 0 And b.oi_step2 = 44) "; break;    //입금전취소완료
                    case 67 : $subWhere[] = " (a.redelivery_type = 'G' And a.op_step = 40) "; break;   //교환신청
                    case 61 : $subWhere[] = " (a.redelivery_type = 'G' And a.op_step = 41) "; break;   //교환접수
                    case 62 : $subWhere[] = " (a.redelivery_type = 'G' And a.op_step = 44) "; break;   //교환완료
                    case 68 : $subWhere[] = " (a.redelivery_type = 'Y' and b.oi_step1 in (2,3,4) And (coalesce(a.opt1_change, '') = '' And coalesce(a.opt2_change, '') = '') And a.op_step = 40) "; break;    //반품신청
                    case 63 : $subWhere[] = " (a.redelivery_type = 'Y' and b.oi_step1 in (2,3,4) And (coalesce(a.opt1_change, '') = '' And coalesce(a.opt2_change, '') = '') And a.op_step = 41) "; break;    //반품접수
                    case 64 : $subWhere[] = " (a.redelivery_type = 'Y' and b.oi_step1 in (2,3,4) And a.op_step = 42) "; break;   //반품완료(배송중 이상이면서 환불접수단계)
                    case 65 : $subWhere[] = " (a.redelivery_type != 'G' and b.bank_date is not null And ((b.oi_step1 in (1,2) and a.op_step = 41) OR a.op_step = 42) And ((coalesce(a.opt1_change, '') = '' And coalesce(a.opt2_change, '') = '')))"; break;  //환불접수
                    case 66 : $subWhere[] = " (a.redelivery_type != 'G' and b.oi_step1 > 0 And a.op_step = 44 And ((coalesce(a.opt1_change, '') = '' And coalesce(a.opt2_change, '') = ''))) "; break;  //환불완료
                }
            }
        }
        */

        $delicomlist=array();
        $sql="SELECT * FROM tbldelicompany ORDER BY company_name ";
        $result=pmysql_query($sql,get_db_conn());
        while($row=pmysql_fetch_object($result)) {
            $delicomlist[]=$row;
        }
        pmysql_free_result($result);



        switch($template) {
            case 'WEB01' :
                //주문접수
                $subWhere[] = " a.op_step = 0";
            break;
            case 'WEB02' :
                //가상계좌 결제완료 BOQ
                $subWhere[] = "(b.paymethod = 'B".$pg_code."' OR b.paymethod = 'O".$pg_code."' OR b.paymethod = 'Q".$pg_code."') AND a.op_step = 1";
            break;
            case 'WEB03' :
                //신용카드 결제완료
                $subWhere[] = "(b.paymethod = 'C".$pg_code."' OR b.paymethod = 'V".$pg_code."') AND a.op_step = 1";
            break;
            /*
            case 2 :
                //배송준비중
                $subWhere[] = " a.op_step = 2";
            break;
            */
            case 'WEB04' :
                //배송중
                $subWhere[] = " a.op_step = 3";
            break;
            case 'WEB05' :
                //배송완료
                $subWhere[] = " a.op_step = 4";
            break;

            case 'WEB06' :
                //배송 전 취소접수
                $subWhere[] = " (b.oi_step1 = '1' AND (coalesce(a.opt1_change, '') = '' AND coalesce(a.opt2_change, '') = '') AND a.op_step = 41) ";
            break;
            /*
            case 67 :
                 //교환신청
                $subWhere[] = " (b.oi_step1 = 67)";
                $subWhere[] = " (a.redelivery_type = 'G' And a.op_step = 40) ";
            break;
            case 61 :
                //교환접수
                $subWhere[] = " (a.redelivery_type = 'G' And a.op_step = 41) ";
            break;
            case 62 :
                //교환완료
                $subWhere[] = " (a.redelivery_type = 'G' And a.op_step = 44) ";
            break;
            */
            case 'WEB07' :
                //반품신청
                $subWhere[] = " (a.redelivery_type = 'Y' and b.oi_step1 in (2,3,4) And (coalesce(a.opt1_change, '') = '' And coalesce(a.opt2_change, '') = '') And a.op_step = 40) ";
            break;
            case 'WEB08' :
                //반품접수
                $subWhere[] = " (a.redelivery_type = 'Y' and b.oi_step1 in (2,3,4) And (coalesce(a.opt1_change, '') = '' And coalesce(a.opt2_change, '') = '') And a.op_step = 41) ";
            break;
            /*
            case 64 :
                //반품완료(배송중 이상이면서 환불접수단계)
                $subWhere[] = " (a.redelivery_type = 'Y' and b.oi_step1 in (2,3,4) And a.op_step = 42) ";
            break;
            */
            case 'WEB09' :
                //환불접수
                $subWhere[] = " (a.redelivery_type != 'G' and b.bank_date is not null And ((b.oi_step1 in (1,2) and a.op_step = 41) OR a.op_step = 42) And ((coalesce(a.opt1_change, '') = '' And coalesce(a.opt2_change, '') = '')))";
            break;
            case 'WEB10' :
                //환불완료
                $subWhere[] = " (a.redelivery_type != 'G' and b.oi_step1 > 0 And a.op_step = 44 And ((coalesce(a.opt1_change, '') = '' And coalesce(a.opt2_change, '') = ''))) ";
            break;
        }

        $idx_arr = explode("|", $idx);
        if($idx){
            $subWhere[] = " a.idx in ('".implode("','", $idx_arr)."')";
        }

        if($oc_no){
            $subWhere[] = " a.oc_no='".$oc_no."' ";
        }


        if(count($subWhere)) {
            $sub = " AND (".implode(" AND ", $subWhere)." ) ";
        }

        # 브랜드
        $arrayBrandName = array(
            "M"=>array(
                "A"=>"브루노바피",
                "D"=>"데일리스트",
                "I"=>"인디안",
                "E"=>"두아니",
                "G"=>"헤리토리골프"),
            "V"=>"올리비아로렌",
            "C"=>"센터폴",
            "T"=>"트레몰로",
            "N"=>"NII",
            "K"=>"크리스크리스티");

        if($ordercode && $template){

            $orderSql = "
                                    SELECT
                                        b.pay_data, b.receiver_addr, a.vender, v.brandname, a.ordercode, a.productcode, a.productname, a.opt1_name, a.opt2_name, a.quantity, a.price, a.company_code, a.style,a.color,a.standard,
                                        a.option_price, a.deli_com, a.deli_num, a.deli_date, a.deli_price,
                                        a.coupon_price, a.use_point, a.use_s_point, a.op_step, a.opt1_change, a.opt2_change, a.oc_no, a.date, a.idx,
                                        b.id, b.sender_name, b.sender_tel, b.paymethod, b.oi_step1, b.oi_step2, a.redelivery_type, b.is_mobile, a.delivery_type, a.reservation_date, a.store_code, a.auction_seq,
                                        REPLACE(REPLACE(opt1_name, CHR(10), ''), CHR(13), '') option_str1, REPLACE(REPLACE(opt2_name, CHR(10), ''), CHR(13), '') option_str2, a.auction_seq
                                    FROM
                                        tblorderproduct a
                                        JOIN tblorderinfo b ON a.ordercode = b.ordercode
                                        LEFT JOIN tblproductbrand v ON a.vender = v.vender
                                    WHERE b.ordercode ='".$ordercode."' ".$sub." ORDER BY a.vender, a.idx";
            backup_save_sql( $orderSql );
            $orderResult=pmysql_query($orderSql, get_db_conn());
            $count = 0;
            $orderPriceTotal = 0;
            while($orderRow=pmysql_fetch_object($orderResult)) {
                list($style, $color, $brand_zone, $on_brand, $brand)=pmysql_fetch("SELECT style, color, brand_zone, on_brand, brand FROM tblproduct WHERE productcode='".$orderRow->productcode."'");
                if($orderRow->company_code != '99'){
                    $orderRow->order_product1 = $style.$color;
                }else{
                    if($orderRow->auction_seq > 0){
                        list($auction_name)=pmysql_fetch("SELECT auction_name FROM tblauctioninfo WHERE auction_seq='".$orderRow->auction_seq."'");
                        $orderRow->order_product1 = $auction_name;
                    }else{
                        $orderRow->order_product1 = $orderRow->productname;
                    }
                }

                $arrOption = $this->getOrderOptions($orderRow);
                $orderRow->order_product2 = implode(" / ", $arrOption);
                $orderRow->order_count = $count;


                $orderRow->order_name = $orderRow->sender_name;
                $orderPriceTotal += (($orderRow->price+$orderRow->option_price)*$orderRow->quantity)-$orderRow->coupon_price-$orderRow->use_point-$orderRow->use_s_point+$orderRow->deli_price;

                $orderRow->deli_address = str_replace("\n", " ", $orderRow->receiver_addr);
                $orderRow->order_url = "http://".$_SERVER['HTTP_HOST']."/m/mypage_orderlist_view.php?ordercode=".$orderRow->ordercode;

                $arrPayData = explode(" ", $orderRow->pay_data);
                $orderRow->bank_name = $arrPayData[0];
                $orderRow->virtual_number = $arrPayData[1];


                if($orderRow->auction_seq > 0){
                    $orderRow->brand_name = "[경매상품]";
                }else{
                    if($orderRow->company_code != '99'){
                        $brand_name = '';
                        foreach((array)$arrayBrandName as $bKey => $bVal){
                            if($brand_zone == 'M'){
                                $brand_name = $arrayBrandName[$brand_zone][$on_brand]; break;
                            }else{
                                $brand_name = $arrayBrandName[$brand_zone]; break;
                            }
                        }
                        $orderRow->brand_name = "[".$brand_name."]";
                    }else{
                        $orderRow->brand_name = "[".brand_name( $brand )."]";
                    }
                }

                $product_name = explode('] ', $orderRow->productname);
                $orderRow->product_code = $product_name[1] ? $product_name[1] : $orderRow->productname;


                $orderRow->quantity = $orderRow->quantity;
                $orderRow->option_str = implode(" / ", $arrOption);

                if(!$orderRow->deli_code) $orderRow->deli_code = $orderRow->deli_num;
                #$orderRow->confirm_url = "주문 확정 URL";
                #주문 상세로 연결
                $orderRow->confirm_url = "http://".$_SERVER['HTTP_HOST']."/m/mypage_orderlist_view.php?ordercode=".$orderRow->ordercode;
                $orderRow->play_store_url = "https://play.google.com/store/apps/details?id=com.sejung.android";
                $orderRow->app_store_url = "https://itunes.apple.com/kr/app/hook-sejung-deohug-o2o-syopingmol/id1153471571";

                $arrListOrder[$orderRow->ordercode] = $orderRow;

                $count++;
            }


            $arraySendOrder = array("template"=>$template);

            if($count > 0){
                foreach($arrListOrder as $key => $row) {
                    $order_product = $row->order_product1." (".$row->order_product2.")";
                    if($row->order_count > 0){
                        $order_product .= " 외 ".number_format($row->order_count)."건";
                    }else{
                    }
                    $arraySendOrder['ordercode'] = $row->ordercode;																			# 주문번호
                    $arraySendOrder['order_name'] = $row->order_name;																		# 주문자
                    $arraySendOrder['order_product'] = $order_product;																		# 상품
                    $arraySendOrder['order_price'] = number_format($orderPriceTotal);												# 결제 금액
                    $arraySendOrder['deli_address'] = $row->deli_address;																	# 배송지
                    $arraySendOrder['order_url'] = $row->order_url;
                    $shortUrlOrder = $this->getShortURL($arraySendOrder['order_url']);
                    $arraySendOrder['order_url'] = $shortUrlOrder ? $shortUrlOrder : $arraySendOrder['order_url'];		# 주문 내역 주소

                    $arraySendOrder['brand_name'] = $row->brand_name;																	# 브랜드 명
                    #$arraySendOrder['brand_name'] = "";																								# 브랜드 명 - 상품명에 브랜드명이 존재 하여 빈값
                    $arraySendOrder['deposit_price'] = number_format($orderPriceTotal);												# 입금금액
                    $arraySendOrder['virtual_number'] = $row->virtual_number;															# 입금계좌
                    $arraySendOrder['bank_name'] = $row->bank_name;																		# 입금은행
                    $arraySendOrder['cellphone'] = $row->sender_tel;																			# 입금은행

                    $arraySendOrder['quantity'] = $row->quantity;																					# 수량
                    $arraySendOrder['product_code'] = $row->product_code;																# 상품 코드 (명)
                    if($row->order_count > 0){
                        $arraySendOrder['product_code'] .= " 외 ".number_format($row->order_count)."건";
                    }else{
                    }
                    $arraySendOrder['option_str'] = $row->option_str;


                    for($yy=0;$yy<count($delicomlist);$yy++) {
                        if($row->deli_com>0 && $row->deli_com==$delicomlist[$yy]->code) {
                            $deli_url = $delicomlist[$yy]->deli_url;
                            $trans_num = $delicomlist[$yy]->trans_num;
                            $company_name = $delicomlist[$yy]->company_name;
                        }
                    }
                    $arraySendOrder['deli_code'] = $deli_url.$row->deli_code;
                    $shortUrl = $this->getShortURL($arraySendOrder['deli_code']);
                    $arraySendOrder['deli_code'] = $shortUrl ? $shortUrl : $arraySendOrder['deli_code'];						# 배송 코드


                    /*
                    $arraySendOrder['play_store_url'] = $row->play_store_url;
                    $shortUrlAndroid = $this->getShortURL($arraySendOrder['play_store_url']);
                    $arraySendOrder['play_store_url'] = $shortUrlAndroid ? $shortUrlAndroid : $arraySendOrder['play_store_url'];
                    $arraySendOrder['play_store_url'] = "[ ".$arraySendOrder['play_store_url']." ]";								# 플레이스토어 주소

                    $arraySendOrder['app_store_url'] = $row->app_store_url;
                    $shortUrlApple = $this->getShortURL($arraySendOrder['app_store_url']);
                    $arraySendOrder['app_store_url'] = $shortUrlApple ? $shortUrlApple : $arraySendOrder['app_store_url'];
                    $arraySendOrder['app_store_url'] = "[ ".$arraySendOrder['app_store_url']." ]";								# 앱스토어 주소
                    */


                    $arraySendOrder['confirm_url'] = $row->confirm_url;
                    $shortUrlConfirm = $this->getShortURL($arraySendOrder['confirm_url']);
                    $arraySendOrder['confirm_url'] = $shortUrlConfirm ? $shortUrlConfirm : $arraySendOrder['confirm_url'];
                    $arraySendOrder['confirm_url'] = "[ ".$arraySendOrder['confirm_url']." ]";										# 주문 확정 URL
                }
                $json = json_encode($arraySendOrder);

                $this->jsonData = $json;

                $this->makeJsonDecodeData();
                $this->makeAlimTalkMsg();

            }else{
                $this->ataDbFlag = "none";
            }
        }else{
            $this->ataDbFlag = "none";
        }
    }

    function makeAlimTalkMsg(){
        if($this->jsonDecodeData->template){

            $filename = realpath(dirname(__FILE__).'/')."/../alimtalk/template/".$this->jsonDecodeData->template.".php";
            $handle = fopen($filename, "r");
            $contents = fread($handle, filesize($filename));
            fclose($handle);

            // db로 변경 2017-02-10 유동혁
            /*
            $sql = "select code, message from ata_msg_talbe where code = '".$this->jsonDecodeData->template."' ";
            $res = pmysql_query( $sql, get_db_conn() );
            $row = pmysql_fetch_array( $res );
            $contents = $row['message'];
            pmysql_free_result( $res );
            */
            if( $contents ){
                foreach($this->jsonDecodeData as $kk => $vv){
                    if($kk == 'template') continue;
                    $contents = str_replace("#{".$kk."}", $vv, $contents);
                }
                $contents = str_replace("'", "''", $contents);
                $this->ataContents = $contents;
                //debug($contents);
                $this->insertAlimTalkMsg();
            } else {
                $this->ataDbFlag = "none";
            }
        }else{
            $this->ataDbFlag = "none";
        }
    }

    function insertAlimTalkMsg(){
        GLOBAL $alimConf;
        /*
            insert into ata_mmt_tran (mt_pr, date_client_req, subject, content, callback, service_type, broadcast_yn, msg_status, recipient_num, msg_type, sender_key, template_code )
            values(nextval('sq_ata_mmt_tran_01'), now(), ' ', 'Test Message 입니다', ' ', '3', 'N', '1', '1009', '10', 'aaaaa22222bbbbb33333c', 'A000_00');

            subject : ''
            content : content
            callback : ''
            service_type : '3' (3-카카오톡 알림톡)
            broadcast_yn : 'N' ( 사용안함  )
            msg_status : '1' ( 1-전송대기, 2-결과대기, 3-완료 )
            recipient_num : '01000000000' ( 수신자 전화번호 )
            msg_type : '1008' ( 1008-카카오톡 알림톡, 1009-카카오톡 친구톡 )
            sender_key : 'asdasdasd' ( 카카오톡 알림톡 발신 프로필키 )
            template_code : 'WEB01' ( 템플릿 코드 )
        */


        $sql = "INSERT INTO ata_mmt_tran
                        ( mt_pr, date_client_req, subject, content, callback, service_type, broadcast_yn, msg_status, recipient_num, msg_type, sender_key, template_code, ordercode )
                    VALUES
                        ( nextval('sq_ata_mmt_tran_01'), now(), ' ', '".$this->ataContents."', ' ', '3', 'N', '1', '".$this->jsonDecodeData->cellphone."', '1008', '".$alimConf['senderKey']."', '".$this->jsonDecodeData->template."', '".$this->jsonDecodeData->ordercode."')";
        backup_save_sql( $sql );
        pmysql_query( $sql, get_db_conn() );
        $this->ataDbFlag = "succ";
        if( pmysql_errno() ){
            $this->ataDbFlag = "fail";
        }
    }



    function getOrderOptions($groupOpRow){
        $returnVal = "";
        $opt_name	= "";
        if( strlen( trim( $groupOpRow->option_str1 ) ) > 0 ) {
            $opt1_name_arr	= explode("@#", $groupOpRow->option_str1);
            $opt2_name_arr	= explode(chr(30), $groupOpRow->option_str2);
            if($groupOpRow->company_code!='99') {
                $groupOpRow->option_str1=$opt1_name_arr[1];
                $groupOpRow->option_str2=$opt2_name_arr[1];
            }
            $s_cnt	= 0;
            for($s=0;$s < sizeof($opt1_name_arr);$s++) {
                if(($groupOpRow->company_code!='99' && $s==1)||$groupOpRow->company_code=='99') {
                    if ($opt2_name_arr[$s]) {
                        if ($s_cnt > 0) $opt_name .= " / ";
                        $opt_name .= $opt1_name_arr[$s] . ' : ' . $opt2_name_arr[$s];
                        $s_cnt++;
                    }
                }else{
                    if( $groupOpRow->company_code!='99' && $s==0 ){
                        $commonColor = common_color( array( 'color'=>$opt2_name_arr[$s] ) );
                        $opt2_name_arr[$s] = $commonColor;
                    }
                    $opt_name2= $opt1_name_arr[$s] . ' : ' . $opt2_name_arr[$s];
                }
            }
        }

        if( strlen( trim( $groupOpRow->text_opt_subject ) ) > 0 ) {
            $text_opt_subject_arr	= explode("@#", $groupOpRow->text_opt_subject);
            $text_opt_content_arr	= explode("@#", $groupOpRow->text_opt_content);

            for($s=0;$s < sizeof($text_opt_subject_arr);$s++) {
                if ($text_opt_content_arr[$s]) {
                    if ($opt_name != '') $opt_name .= " / ";
                    $opt_name .= $text_opt_subject_arr[$s] . ' : ' . $text_opt_content_arr[$s];
                }
            }
        }


        $opt_string = $opt_name;
        if($opt_name2) $opt_string .= " / ".$opt_name2;

        if($opt_name || $opt_name2){
            $returnVal = $opt_string;
        }


        $returnArray = array("opt1"=> $opt_name, "opt2"=>$opt_name2);

        $returnArray = array_filter($returnArray);

        return $returnArray;
    }


    function getShortURL($longURL) {
        # 통신 지연으로 인해 주석처리 2017-01-05 유동혁
        /*
        GLOBAL $alimConf;
        if($alimConf['googleShortUrlKEy']){
            $curlopt_url = "https://www.googleapis.com/urlshortener/v1/url?key=".$alimConf['googleShortUrlKEy'];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $curlopt_url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $jsonArray = array('longUrl' => $longURL);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonArray));
            $shortURL = curl_exec($ch);    curl_close($ch);
            $result_array = json_decode($shortURL, true);
            $shortURL = curl_exec($ch);
            curl_close($ch);

            return $result_array['id'];
        }else{
            return "";
        }
        */
        return $longURL;
    }


}
?>
