/**
 * Copyright (c) Seok Kyun. Choi. 최석균
 * GNU Lesser General Public License
 * http://www.gnu.org/licenses/lgpl.html
 *
 * http://syaku.tistory.com
 */

(function(jQuery) {

$.extend(true,$.syakuFileUpload , { 


  editor_file_input : function(swfu,editor) {
		
    if (editor.mode != 'wysiwyg') { alert('텍스트(소스) 모드에서는 사용할 수 없습니다.'); return false; }

    try {
      var ele_file = swfu.settings.ele_file;
      var file_upload_multi = swfu.settings.file_upload_multi;
      var tag = "";

      if (file_upload_multi) {

        jQuery(ele_file + ' option:selected').each(function(i){
          var file_info = eval("(" + $(this).val() + ")");
          var idx = $(this).index();
          tag += jQuery.syakuFileUpload.tag_view(swfu,file_info,idx);
        });

      } else {
        var value = jQuery(ele_file).val();
        var file_info = eval("(" + value + ")");
        tag = jQuery.syakuFileUpload.tag_view(swfu,file_info);
      }

      editor.insertHtml(tag);
      editor.updateElement();

    } catch (e) { }
  } , 

  editor_file_remove : function(swfu,editor) {
    try {

      var ele_file = swfu.settings.ele_file;
      var file_upload_multi = swfu.settings.file_upload_multi;
      var tag = jQuery("<div>" + editor.getData() + "</div>");

      if (file_upload_multi) {
        $(ele_file + ' option:selected').each(function(i){
          var idx = $(this).index();
          jQuery('.syaku_' + idx,tag).remove();
        });
      } else {
        jQuery('.syaku',tag).remove();
      }

      editor.setData(tag.html());
      editor.updateElement();

    } catch (e) { }

  }

} );

})(jQuery);