<?php

if (!$board['bo_table']) {
   alert('존재하지 않는 게시판입니다.', G5_URL);
}

check_device($board['bo_device']);

if (isset($write['wr_is_comment']) && $write['wr_is_comment']) {
    goto_url('./board.php?bo_table='.$bo_table.'&amp;wr_id='.$write['wr_parent'].'#c_'.$wr_id);
}

if (!$bo_table) {
    $msg = "bo_table 값이 넘어오지 않았습니다.\\n\\nboard.php?bo_table=code 와 같은 방식으로 넘겨 주세요.";
    alert($msg);
}

// wr_id 값이 있으면 글읽기
if (isset($wr_id) && $wr_id) {
    // 글이 없을 경우 해당 게시판 목록으로 이동
    if (!$write['wr_id']) {
        $msg = '글이 존재하지 않습니다.\\n\\n글이 삭제되었거나 이동된 경우입니다.';
        alert($msg, './board.php?bo_table='.$bo_table);
    }

}
    // 로그인된 회원의 권한이 설정된 읽기 권한보다 작다면
    if ($member['mb_level'] < $board['bo_read_level']) {
        if ($is_member)
            alert('글을 읽을 권한이 없습니다.', G5_URL);
        else
          //  alert('글을 읽을 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', './login.php?wr_id='.$wr_id.$qstr.'&amp;url='.urlencode(G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.$qstr));
    
		 alert('글을 읽을 권한이 없습니다.\\n\\n회원이시라면 로그인 후 이용해 보십시오.', '/login/login.php');	
	
	}

  
?>
