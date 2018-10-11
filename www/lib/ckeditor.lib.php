<?php


	function editor_html($id, $content, $is_dhtml_editor=true)
	{
	    global $g5, $config;
	    static $js = true;

	    $editor_url = G5_EDITOR_URL.'/'.$config['cf_editor'];

	    $html = "";
	  //  $html .= "<span class=\"sound_only\">웹에디터 시작</span>";
	    if ($is_dhtml_editor)
	    //    $html .= '<script>document.write("<div class=\'cke_sc\'><button type=\'button\' class=\'btn_cke_sc\'>단축키 일람</button></div>");</script>';   20180911 psj 막음

	    if ($is_dhtml_editor && $js) {
	    //    $html .= "\n".'<script src="'.$editor_url.'/ckeditor.js"></script>';          20180911 psj 막음
	    //    $html .= "\n".'<script>var g5_editor_url = "'.$editor_url.'";</script>';      20180911 psj 막음
	    //    $html .= "\n".'<script src="'.$editor_url.'/config.js"></script>';        20180911 psj 막음
	        $js = false;
	    }

	    $ckeditor_class = $is_dhtml_editor ? "ckeditor" : "";
	    $html .= "\n<textarea id=\"$id\" name=\"$id\" class=\"$ckeditor_class\" maxlength=\"65536\">$content</textarea>";
	  //  $html .= "\n<span class=\"sound_only\">웹 에디터 끝</span>";
		
	    return $html;
	}


	// textarea 로 값을 넘긴다. javascript 반드시 필요
	function get_editor_js($id, $is_dhtml_editor=true)
	{
	    if ($is_dhtml_editor) {
	        return "var {$id}_editor_data = CKEDITOR.instances.{$id}.getData();\n";
	    } else {
	        return "var {$id}_editor = document.getElementById('{$id}');\n";
	    }
	}


	//  textarea 의 값이 비어 있는지 검사
	function chk_editor_js($id, $is_dhtml_editor=true)
	{
	    if ($is_dhtml_editor) {
	        return "if (!{$id}_editor_data) { alert(\"내용을 입력해 주십시오.\"); CKEDITOR.instances.{$id}.focus(); return false; }\nif (typeof(f.{$id})!=\"undefined\") f.{$id}.value = {$id}_editor_data;\n";
	    } else {
	        return "if (!{$id}_editor.value) { alert(\"내용을 입력해 주십시오.\"); {$id}_editor.focus(); return false; }\n";
	    }
	}


?>