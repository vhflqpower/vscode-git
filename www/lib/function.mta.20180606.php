<?php

//  보드구분
	function select_gubun(){

		$sql = "select bo_table,bo_subject from psj_board_config";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)){

		$bo_table = $row['bo_table'];
		$arr_row[$bo_table] = $row['bo_subject'];
		}

		return $arr_row;

	}


//  정보그룹구분
	function select_info_group(){

		$sql = "select code,codename from psj_code where display_yn='Y' && part ='1' order by sort asc";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)){

		$code = $row['code'];

		$data=sql_fetch_array(sql_query("select count(*)as cnt from psj_board where bo_table='info' and wr_cat1='$code'"));

		$arr_row[$code] = array($row['codename'],$data['cnt']);
		}

		return $arr_row;

	}


//  정보구분
	function select_info_gubun($pcode){

		$sql = "select code,codename from psj_code where pcode='$pcode' && part ='2'";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)){

		$code = $row['code'];
		$data=sql_fetch_array(sql_query("select count(*)as cnt from psj_board where bo_table='info' and wr_cat1='$pcode' && wr_cat2 ='$code' "));

		$arr_row[$code] = array($row['codename'],$data['cnt']);
		}

		return $arr_row;

	}


//  업체코드
	function select_company(){

		$sql = "select co_id,co_name from psj_company";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)){
		$co_id = $row['co_id'];
		$arr_row[$co_id] = $row['co_name'];
		}
		return $arr_row;

	}

//  업체코드
	function get_company($co_id){
		$sql = "select co_name from psj_company where co_id ='$co_id'";
		$res = sql_query($sql);
		$row=sql_fetch_array($res);
		$co_name = $row['co_name'];
		return $co_name;

	}


//  업체코드
	function select_project(){

		$sql = "select pj_id,pj_subject from psj_project";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)){
		$co_id = $row['pj_id'];
		$arr_row[$co_id] = $row['pj_subject'];
		}
		return $arr_row;

	}



//  최신글
	function latest_notice($idx,$subject,$table,$where){

		$sql = "select $idx,$subject from $table where 1=1 $where";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)){
		
		$id = $row[$idx];
		$arr_row[$id] = $row[$subject];
		}
		return $arr_row;

	}


//  보드구분
	function select_member(){

		$sql = "select mb_id,mb_name from psj_member where mb_level > 1 and mb_status ='2'";
		$res = sql_query($sql);
		while($row=sql_fetch_array($res)){

		$id = $row['mb_id'];
		$arr_mb[$id] = $row['mb_name'];
		}

		return $arr_mb;

	}


	//  2018-05-02 14:05:23  =>  05.23
	function short_date($date){
		$tmp_date = explode(" ",$date);
		$lastdate = substr(str_replace("-",".",$tmp_date[0]),-5);
		return $lastdate;
	}




// 이슈트랙킹 상태
	$arr_is_status[1] = '<font color=#FF8000>접수중</font>';
	$arr_is_status[2] = '<font color=#0000ff>분석중</font>';
	$arr_is_status[3] = '<font color=#ff0000>처리중</font>';
	$arr_is_status[4] ='<font color=#ffa500>테스트중</font>';
	$arr_is_status[5] = '<font color=#00000>완료</font>';


// 메뉴 접근 구분 상태
	$arr_menu_part['L'] = '목록';
	$arr_menu_part['R'] = '보기';
	$arr_menu_part['W'] = '쓰기';
	$arr_menu_part['U'] = '수정';
	$arr_menu_part['D'] = '삭제';

	$arr_proc_status[1] = 'progress-bar-success progress-bar-striped';
	$arr_proc_status[2] = 'progress-bar-info progress-bar-striped';
	$arr_proc_status[3] = 'progress-bar-warning progress-bar-striped' ;
	$arr_proc_status[4] = 'progress-bar-danger progress-bar-striped';
	$arr_proc_status[5] = 'progress-bar-default progress-bar-striped';



// 프로젝트 진행 상태
	$arr_is_status[1] = '<font color=#FF8000>접수중</font>';
	$arr_is_status[2] = '<font color=#0000ff>분석중</font>';
	$arr_is_status[3] = '<font color=#ff0000>처리중</font>';
	$arr_is_status[4] ='<font color=#ffa500>테스트중</font>';
	$arr_is_status[5] = '<font color=#00000>완료</font>';

	$arr_pj_setp[1]='자료수집';
	$arr_pj_setp[2]='분석설계';
	$arr_pj_setp[3]='디자인';
	$arr_pj_setp[4]='퍼블리싱';
	$arr_pj_setp[5]='개발';
	$arr_pj_setp[6]='검수';


	$arr_status[1] = '<font color=#0000ff>접수중</font>';
	$arr_status[2] = '<font color=#ff0000>진행중</font>';
	$arr_status[3] = '<font color=#000>완료</font>';


?>