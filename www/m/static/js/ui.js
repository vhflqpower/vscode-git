var $window = $(window),
$doc = $(document);


// Scroll move
function scrollMove(t,h) {
	'use strict';
	if(h==undefined) h=0;
	var o = jQuery('html, body');
	o.animate({
		scrollTop:$(t).offset().top-h
	},500);
}

// layer open
function lyrOpen(obj, o){
	'use strict';
	var $body =  $('body'), $wrap = $('#wrap');
	$body.append('<div class="dim"></div>');
	var a = -$window.scrollTop();
	$body.addClass('lyr-open');
	//$wrap.css('top', a);
	setTimeout(function  () {
		$(obj).show(0,function(){
			$body.addClass(o+'-open');
		});
	},50)
}

// layer Close
function lyrClose(obj, o, time){
	'use strict';
	var $body =  $('body'), $wrap = $('#wrap');
	$body.removeClass(o+'-open').find('.dim').remove();
	var originScroll = -$wrap.position().top;
	setTimeout(function(){
		$(obj).hide();
		$body.removeClass('lyr-open');
		//$window.scrollTop(originScroll);
		$wrap.removeAttr('style');
		if($(".nameChange").length > 0){
			$(".nameChange").find("input[name='friend_name']").val('');
			$(".nameChange").hide();
		}
		if($(".relatedChange").length > 0){
			$(".relatedChange").hide();
		}

		if($(".copyUrlLayer").length > 0){
			$(".copyUrlLayer").hide();
		}

	},time);
}

function createBlob (data, type) {
    try {
      return new Blob([data], {type: type})
    } catch (e) {
      var BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder ||
      window.MozBlobBuilder || window.MSBlobBuilder
      var builder = new BlobBuilder()
      builder.append(data.buffer || data)
      return builder.getBlob(type)
    }
}

function setBase64(thumb, base64Obj, mimeType, base64Val){
	$("#"+thumb).css("background", "url('data:" + mimeType + ';base64,' + base64Val+"') center no-repeat").css("background-size", "contain");
	$("#"+base64Obj).attr("value", base64Val);
	$("#"+base64Obj+"1").attr("value", mimeType);
}

$(function  () {
	'use strict';
	var target, tgClass;
	//layer
	$doc.on('click', '.btn-lyr-open, .btn-lyr-close' , function  () {
		target = $(this).attr('data-target') || $(this).attr('href');
		tgClass = target.substr(1);
		if ($(this).hasClass('btn-lyr-open')) {
			$('.btn-lyr-close').show();
			lyrOpen(target, tgClass);
		}else {
			$('.btn-lyr-close').hide();
			lyrClose(target, tgClass, 500);
		}
		return false;
	});

	$doc.on('click', '[data-toggle=modal]' ,function  () {
		target = $(this).attr('data-target') || $(this).attr('href') || '.modal';
		tgClass = 'modal';
		if (!$(this).parents('div').hasClass('modal')) {
			lyrOpen(target, tgClass);
		}else {
			lyrClose(target, tgClass, 0);
		}
		return false;
	});

	$('body').click(function(event){
		if ($(event.target).hasClass('modal')) lyrClose('.modal', 'modal', 0);
	});

	//collapse
	$('[data-toggle=collapse]').on('click',function  () {
		$(this).parents('.collapse').toggleClass('open');
		return false;
	});

	//button
	$('[data-toggle=button]').on('click',function  () {
		$(this).toggleClass('active');
		return false;
	});

	//TOP10
	$('#top10_cateOpen').click(function(){
		$('.total-category').fadeIn();
	});
	$('#top10_cateClose').click(function(){
		$('.total-category').fadeOut();
	});

	//GNB 검색창
	$('#gnb-srch-open').click(function(){
		$('.srch-box').fadeIn();
	})
	$('#gnb-srch-close').click(function(){
		$('.srch-box').fadeOut();
	})

	//gnb
	$('#mGnb a[data-toggle]').click(function(){
		$(this).toggleClass('open').next().slideToggle(250);
		return false;
	});



	// 이미지 미리보기
	$(document).on("change", ".imgUpPreview",function(e){
		var object = $(this);
		if (this.files && this.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$(object).parent().css("background", "url('"+e.target.result+"') center no-repeat").css("background-size", "contain");
			}

			reader.readAsDataURL(this.files[0]);
		}
	});



	// APP 이미지 미리보기
	$( document ).delegate(".imgUpPreview", "click", function () {
		var isKitkat = window.navigator.userAgent.search( "Android 4.4") > -1 ? true : false;

		var mobile = (/iphone|ipad|ipod|android/i.test(navigator.userAgent.toLowerCase()));

		if (mobile) {
			var userAgent = navigator.userAgent.toLowerCase();
			if (userAgent.search("android") > -1){
				//if ( isKitkat ) {
					window.Android.open("", "icon-upload-basic", "input_upload_sample_base64_1");
				//}
			} else if ((userAgent.search("iphone") > -1) || (userAgent.search("ipod") > -1) || (userAgent.search("ipad") > -1)){
                if(confirm('카메라로 촬영하시겠습니까?')) {
                    document.location = "js://openCamera/icon-upload-basic/input_upload_sample_base64_1";
                } else {
                    document.location = "js://openPhoto/icon-upload-basic/input_upload_sample_base64_1";
                }
            }
		}
	});
    
	// 이미지 미리보기
	$(document).on("change", ".input_upload_sample_base64_1",function(e){
        var imageUrlJPEG = 'data:'+$('#input_upload_sample_base64_11').val()+';base64,'+$('#input_upload_sample_base64_1').val();
        var blobJPEG = canCreateBlob && window.dataURLtoBlob(imageUrlJPEG)
        loadImage(
            blobJPEG,
            function (canvas) {
                var data = canvas.toDataURL();
                $('#icon-upload-basic').css("background", "url('"+data+"') center no-repeat").css("background-size", "contain");
                $('#input_upload_sample_base64_1').val(data);
            },
            {maxWidth: 600, canvas:true, orientation: false} // Options
        );
	});
    

	// 이미지 미리보기
	$(document).on("change", ".imgUpPreview2",function(e){

        var object = $(this);
        loadImage(
            this.files[0],
            function (canvas) {
                var data = canvas.toDataURL();
                $(object).parent().css("background", "url('"+data+"') center no-repeat").css("background-size", "contain");
                $('#input_upload_sample_base64_1').val(data);
            },
            {maxWidth: 600, canvas:true, orientation: false} // Options
        );
	});


	// APP 이미지 미리보기
	$( document ).delegate(".imgUpPreview2", "click", function () {
		var isKitkat = window.navigator.userAgent.search( "Android 4.4") > -1 ? true : false;

		var mobile = (/iphone|ipad|ipod|android/i.test(navigator.userAgent.toLowerCase()));

		if (mobile) {
			var userAgent = navigator.userAgent.toLowerCase();
			if (userAgent.search("android") > -1){
				//if ( isKitkat ) {
					window.Android.open("", "icon-upload-basic", "input_upload_sample_base64_1");
				//}
			} else if ((userAgent.search("iphone") > -1) || (userAgent.search("ipod") > -1) || (userAgent.search("ipad") > -1)){
                if(confirm('카메라로 촬영하시겠습니까?')) {
                    document.location = "js://openCamera/icon-upload-basic/input_upload_sample_base64_1";
                } else {
                    document.location = "js://openPhoto/icon-upload-basic/input_upload_sample_base64_1";
                }
            }
		}
	});
    
});

