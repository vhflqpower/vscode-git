<?
include_once("_common.php");



	if($oper=='add'){


	$query ="insert into psj_board_config set
			
			bo_table = '$bo_table',
			bo_subject = '$bo_subject',
			bo_skin = '$bo_skin'";
		sql_query($query);


	}else if($oper=='edit'){


	$query ="update psj_board_config set
			bo_subject = '$bo_subject',
			bo_skin = '$bo_skin',
			bo_use_multiupload = '$bo_use_multiupload',
			bo_cate_type = '$bo_cate_type'
			
			where bo_table = '$bo_table'";
		sql_query($query);



	}else if($oper=='del'){


	$query ="delete from psj_board_config

			where bo_table = '$bo_table'";
	

		//sql_query($query);


		goto_url("./bbs_list.php");
	}





		goto_url("./bbs_write.php?bo_table=$bo_table");








?>