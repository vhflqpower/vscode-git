<?
include_once("_common.php");




	if($oper=='add'){



	$row = sql_fetch("select (count)as cnt from psj_menu_config where me_code='$me_code'");

	if($row[cnt] > 0)alert('이미 존재하는 메뉴입니다.');

	$query ="insert into psj_menu_config set
			
			me_code = '$me_code',
			me_subject = '$me_subject',
			me_sort ='$me_sort'
			
			";
		sql_query($query);


		goto_url("./menu_list.php&part=menu");
	}
	

	if($oper=='edit'){


	$query ="update psj_menu_config set
			me_subject = '$me_subject',
			me_list_level = '$me_list_level',
			me_sort ='$me_sort'

			where me_code = '$me_code'";
		sql_query($query);


		goto_url("./menu_write.php?me_code=$me_code&part=menu");
	}
	
	
	
	
	
	if($oper=='del'){


	$query ="delete from psj_board_config

			where me_code = '$me_code'";
	

		//sql_query($query);


		goto_url("./menu_list.php?&part=menu");
	}














?>