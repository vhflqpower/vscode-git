// 카카오 링크설정
// //developers.kakao.com/sdk/js/kakao.min.js 필요
function KakaoInit( setData ){
    var snsData = {
        label       : encodeURIComponent( $('#link-label').val() ),
        imageTitle  : encodeURIComponent( $('#link-title').val() ),
        imageUrl    : $('#link-image').val(),
        imageWidth  : $('#link-image').data('width'),
        imageHeight : $('#link-image').data('height'),
        linkUrl     : encodeURIComponent( $('#link-url').val() )
    };

	//  /m/outline/footer_m.php 에 위치
    var kakaoKey = '3d3bab592ae44e51910d1d5da5703583';
    var target   = '#kakao-link';
    if( setData ){
        if( setData.snsData ){
            snsData = $.extend( snsData, setData.snsData );
        }
        if( snsData.key ){
            kakaoKey = setData.key;
        }
        if( snsData.target ){
            target = setData.target;
        }
    }
    Kakao.init( kakaoKey );
}

// snsLink 클릭시 popup
var winHandleSns;
function snsLinkPop( setData ){
    var elementTarget = $(this);

    // 대상 정보
    var eventButton = {
        facebook : 'facebook-link',
        insta  : 'insta-link',
        kakaotalk  : 'kakao-link',
        kakaostory  : 'kakao-story-link',
        band     : 'band-link'
    };
    var snsData = {
        label       : encodeURIComponent( $('#link-label').val() ),
        imageTitle  : encodeURIComponent( $('#link-title').val() ),
        imageUrl    : $('#link-image').val(),
        imageWidth  : $('#link-image').data('width'),
        imageHeight : $('#link-image').data('height'),
        linkUrl     : encodeURIComponent( $('#link-url').val() ),
        linkUrlNone     :  $('#link-url').val(),
        linkUrlKakaoNone     :  $('#link-kakao_url').val()
    };
    var urlPop = '';
    // data가 수정되면 바꿔준다 eventButton / snsData
	console.log(setData);
    if( setData ){
        if( setData.eventButton ){
            eventButton = $.extend( eventButton, setData.eventButton );
        }
        if( setData.snsData ){
            snsData = $.extend( snsData, setData.snsData );
        }
    }
    $.each( eventButton, function( i,  v ){
        var called = false;
        if( $( elementTarget ).attr( 'id' ) == v ){
            if( i === 'facebook' ){

                var userAgent = navigator.userAgent.toLowerCase();
                if (userAgent.search("android") > -1){
                    // 안드로이드
                    if(window.gifchu && window.gifchu.shareFacebook) {
                        window.gifchu.shareFacebook('http://gifchu.com/app/f.php?u='+snsData.linkUrl+'&t='+snsData.imageTitle+'&i='+snsData.imageUrl);
                        called = true;
                    }
                }else if ((userAgent.search("iphone") > -1) || (userAgent.search("ipod") > -1) || (userAgent.search("ipad") > -1)){
                    // 아이폰
                    //document.location = "js://getAddressInfo";
                }
                if(!called)
                FB.ui({
                    method: 'share',
                    display: 'iframe',
                    mobile_iframe: true,
                    href: 'http://gifchu.com/app/f.php?u='+snsData.linkUrl+'&t='+snsData.imageTitle+'&i='+snsData.imageUrl,
                    redirect_uri: 'http://gifchu.com/app/xx.php'
                  }, function(response){
                      //
                  });
/*
                FB.ui({
                    method: 'share_open_graph',
                    action_type: 'og.shares',
                    display: 'popup',
                    mobile_iframe: true,
                    redirect_uri: 'http://gifchu.com/app/f2.php',
                    action_properties: JSON.stringify({
                        object: {
                            'og:url': 'http://gifchu.com/app/f.php?link='+snsData.linkUrl,
                            'og:title': decodeURIComponent(snsData.imageTitle),
                            'og:description': '',
                            'og:image': snsData.imageUrl
                        }
                    })
                },
                function (response) {
                // Action after response
                });
*/
                //urlPop = "http://www.facebook.com/sharer.php?u=" + snsData.linkUrl;
            } else if( i === 'insta' ) {
                var userAgent = navigator.userAgent.toLowerCase();
                if (userAgent.search("android") > -1){
                    // 안드로이드
                    if(window.gifchu && window.gifchu.shareInsta) {
                        window.gifchu.shareInsta(snsData.imageTitle,snsData.imageUrl);
                        called = true;
                    }
                }else if ((userAgent.search("iphone") > -1) || (userAgent.search("ipod") > -1) || (userAgent.search("ipad") > -1)){
                    // 아이폰
                    //document.location = "js://getAddressInfo";
                }
            } else if( i === 'twitter' ) {
                urlPop = 'https://twitter.com/share?url=' +  snsData.linkUrl  + '&text=' + snsData.label + snsData.imageTitle;
            } else if( i === 'band' ) {
                urlPop = 'http://band.us/plugin/share?body=' + snsData.label + snsData.imageTitle + encodeURIComponent('\r\n') + snsData.linkUrlNone + '&route=' + snsData.linkUrl;
				//urlPop = 'http://band.us/plugin/share?body=' + snsData.imageTitle + '&route=' + snsData.linkUrl;
            } else if( i === 'kakaotalk' ) {
                Kakao.Link.sendDefault({
                    objectType: 'feed',
                    content: {
                      title: $('#link-label').val(),
                      description: decodeURIComponent(snsData.imageTitle),
                      imageUrl: snsData.imageUrl,
                      link: {
                        mobileWebUrl: '',
                        webUrl: '',
                        androidExecParams: 'link='+snsData.linkUrlKakaoNone,
                        iosExecParams: 'link='+snsData.linkUrlKakaoNone
                      }
                    },
                    buttons: [
                      {
                        title: '앱으로 보기',
                        link: {
                          mobileWebUrl: '',
                          webUrl: '',
                          androidExecParams: 'link='+snsData.linkUrlKakaoNone,
                          iosExecParams: 'link='+snsData.linkUrlKakaoNone
                        }
                      }
                    ]
                  });
/*
				Kakao.Link.sendTalkLink({
					label: $('#link-label').val() + '\r\n' + decodeURIComponent(snsData.imageTitle),
					image: {
						src: snsData.imageUrl,
						width: snsData.imageWidth,
						height: snsData.imageHeight
					},
					webButton: {
						text: $('#link-label').val() + "에서 열기",
						url: snsData.linkUrlKakaoNone
					}
                });
*/
            } else if( i === 'kakaostory' ) {
				Kakao.Story.share({
					url: decodeURIComponent(snsData.linkUrl),
					text: $('#link-title').val()
				});
            }
        }
    });
    if( urlPop ){
		if(winHandleSns){
			winHandleSns.close();
		}
        winHandleSns = window.open( urlPop, '_snsPop', "width=500, height=500, resizable=no" );
    }
}

$(function() {

	$(document).on('click', '.snsOpenLayer', function(){

		// link-title link-url
		$("#link-image").val($(this).data('image'));
		$("#link-title").val($(this).data('title'));
		$("#link-url").val($(this).data('url'));
		$("#link-kakao_url").val($(this).data('kakao_url'));
		$("#link-label").val($(this).data('label'));

	});

});