/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// 언어 설정
	config.language = 'ko';

	// 에디터 높이 설정
	if(g5_is_mobile) {
		//--- 모바일 ---//
		config.height = '200px';
	} else {
		//--- PC ---//
		config.height = '300px';
	}

	// 글꼴관련
	config.font_names = '맑은 고딕;굴림;궁서;돋움;바탕;';

	// 글자크기 출력
	config.fontSize_sizes = '8pt;9pt;10pt;11pt;12pt;14pt;16pt;20pt;24pt;30pt;48pt;60pt;72pt;';

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'styles' },		
		{ name: 'paragraph',   groups: [ 'align', 'bidi', 'basicstyles','document' ] },
		{ name: 'insert' },
		{ name: 'basicstyles', groups: [ 'list', 'blocks' ] },
		{ name: 'links' }, 
		{ name: 'mode' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'about' }
	];

	// 미노출 기능버튼
	if(g5_is_mobile) {
		//--- 모바일 ---//
		config.removeButtons = 'Print,Cut,Copy,Paste,Subscript,Superscript,Anchor,Unlink,ShowBlocks,Undo,Redo,Smiley,Font,cleanup';
	} else {
		//--- PC ---//
		config.removeButtons = 'Print,Cut,Copy,Paste,Subscript,Superscript,Anchor,Unlink,ShowBlocks,Undo,Redo,Smiley,block,cleanup';
	}

	/* 이미지 업로드 관련 소스 */
	var up_url = "/upload.php?type=Images";
	if( typeof(g5_editor_url) != "undefined" )	{
		up_url = g5_editor_url + up_url;
	} else {
		up_url = "/plugin/editor/ckeditor4" + up_url;
	}
	// 에디터 구분
	if(typeof(editor_id) != "undefined" && editor_id != "") {
		up_url += "&editor_id="+editor_id;
	}
	// 업로드 경로 - editor_uri
	if(typeof(editor_uri) != "undefined" && editor_uri != "") {
		up_url += "&editor_uri="+editor_uri;
	}
	// 업로드 이미지용 토큰
	if( typeof(editor_form_name) != "undefined" && editor_form_name != "") {
		up_url += "&editor_form_name="+editor_form_name;
	}
    
	// 업로드 페이지 URL 선언
	config.filebrowserImageUploadUrl = up_url;

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';
	
	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

	//imgur ClientId
	config.imgurClientId = '이곳에 imgur 아이디를 입력하세요';
};
