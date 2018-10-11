$(function() {
	// 더보기 클릭시 상품 리스트 불러옴.
	var pageCount = 0;
	$(document).on('click', '.moreView', function(){
		$.ajax({
			type: "GET",
			url: "/app/wish_product_list.php",
			data: "page=" + pageCount + "&mode=" + $("input[name='page_mode']").val() + "&f_id=" + $("input[name='page_mem_id']").val() + "&depth=" + $("input[name='friend_depth']").val() + "&band_no=" + $("input[name='band_no']").val() + "&reff_level=" + $("input[name='reff_level']").val(),
			beforeSend: function () {
				// 로딩 이미지 출력
				$(".loadingProcessBtn").trigger("click");
			}
		}).done(function ( html ) {
			// 로딩 이미지 제거
			$(".loadingProcessCancel").trigger("click");
			if(html){
				$(".productListArea").append(html);
				pageCount++;
			}else{
				//alert("불러 올 상품이 없습니다.");
				$(".moreView").remove();
			}

			// 방문자일 경우 댓글이나 좋아요 등등 숨김.
			if($("input[name='visitor']").val() > 0){
				$(".replyAreaLayerNoShowVisitor").remove();
				$(".contentsAreaLayerNoShowVisitor").show();
			}
			if($("input[name='visitor']").val() > 0 && $("input[name='band_type']").val() == '2'){
				$(".productAreaLayerNoShowVisitor").remove();
				$(".productAreaLayerNoShowVisitor").remove();
			}
		});

	});
	$(".moreView").trigger("click");




	// 상품 목록 삭제
	$(document).on('click', '.deleteWish', function(){

		var page_mem_id = $("input[name='page_mem_id']").val();
		var wish_idx = $(this).data('wish_idx');
		var obj = $(this);
		if(confirm("삭제 하겠습니까?")){
			$.ajax({
				type	: "GET",
				url	: "/app/wish.ajax.php",
				data	: { mode : 'delete', friend : page_mem_id, wish_idx : wish_idx },
			}).done(function ( result ) {
				if(result == 'SUCC'){
					// 성공시 처리
					$(obj).parents('.lst-card-wide').remove();

				}else{
					alert("삭제가 실패했습니다.");
				}
			});
		}

	});


	// 좋아요 ( 하트 )
	$(document).on('click', '.likeAction', function(){
		var page_mem_id = $("input[name='page_mem_id']").val();
		var wish_idx = $(this).data('wish_idx');
		var obj = $(this);

		$.ajax({
			type	: "GET",
			url	: "/app/wish.ajax.php",
			data	: { mode : 'like', friend : page_mem_id, wish_idx : wish_idx },
			dataType:"json"
		}).done(function ( json ) {
			if(json.res == 'SUCC'){

				// 성공시 처리
				if(json.flag == 'ins'){
					$(obj).addClass('active');
				}else{
					$(obj).removeClass('active');
				}

				$(obj).next().find('.likeTotal').html(json.total);

			}else{
				alert("좋아요 처리가 실패했습니다.");
			}
		});
	});

	// 좋아요 상세
	$(document).on('click', '.likeTotal', function(){
        var page_mem_id = $("input[name='page_mem_id']").val();
   		var wish_idx = $(this).data('wish_idx');
		document.location.href = '/app/like_friend.php?f_id='+page_mem_id+'&wish_idx='+wish_idx;
	});

	// 댓글 목록 열기
	$(document).on('click', '.viewReply', function(){
		$(this).parent().next().slideToggle();
	});

	// 댓글에 댓글 열기
	$(document).on('click', '.viewReply2Depth', function(){
		$(this).parent().parent().next().toggle();
	});

	// 댓글 팝업 오픈시 동시에 처리되는 내용
	$(document).on('click', '.replyRegLayerOpen', function(){
		var page_mem_id = $("input[name='page_mem_id']").val();
		var wish_idx = $(this).data('wish_idx');
		var productname = $(this).data('productname');

		$(".replyContents").val("");
		$(".replyTitle").html(productname);
		$(".replyWishIdx").val(wish_idx);
	});

	// 댓글 등록
	$(document).on('click', '.sendReply, .sendReply2Depth', function(){
		var page_mem_id = $("input[name='page_mem_id']").val();
		var wish_idx = "";
		var contents = "";
		var reply_no = "";
		if($(this).hasClass('sendReply')){
			// 댓글 작성시 wish_idx
			wish_idx = $(".replyWishIdx").val();
			contents = $(".replyContents").val();
		}else if($(this).hasClass('sendReply2Depth')){
			// 댓글에 리플 작성시 wish_idx
			wish_idx = $(this).data('wish_idx');
			contents = $(this).parent().find('.replyContents2Depth').val();
			reply_no = $(this).data('no');
		}

		var obj = $(this);

		$.ajax({
			type	: "POST",
			url	: "/app/wish.ajax.php",
			data	: { mode : 'reply', friend : page_mem_id, wish_idx : wish_idx, contents : contents, reply_no : reply_no }
		}).done(function ( result ) {
			if(result == 'SUCC'){
				// 리플 카운트의 콤마 제거
				var replyCount = parseInt($(".replyCountLayer" + wish_idx).html().replace(/[^\d]+/g, ''), 10);
				$(".replyCountLayer" + wish_idx).html(replyCount+1);
				$(".replyListLayer" + wish_idx).load("/app/wish_reply_list.php?wish_idx=" + wish_idx + "&reply_id=" + page_mem_id);
			}else{
				alert("댓글 등록에 실패했습니다.");
			}
		});
	});


	// 댓글 삭제
	$(document).on('click', '.replyDel', function(){

		if(confirm("삭제 하시겠습니까?")){
			var reply_no = $(this).data('reply_no');
			var wish_idx = $(this).data('wish_idx');
			var page_mem_id = $("input[name='page_mem_id']").val();
			$.ajax({
				type	: "POST",
				url	: "/app/wish.ajax.php",
				data	: { mode : 'reply_del', no : reply_no }
			}).done(function ( result ) {
				if(result == 'SUCC'){
					// 리플 카운트의 콤마 제거
					var replyCount = parseInt($(".replyCountLayer" + wish_idx).html().replace(/[^\d]+/g, ''), 10);
					$(".replyCountLayer" + wish_idx).html(replyCount-1);
					$(".replyListLayer" + wish_idx).load("/app/wish_reply_list.php?wish_idx=" + wish_idx + "&reply_id=" + page_mem_id);
				}else{
					alert("댓글 삭제가 실패했습니다.");
				}
			});
		}

	});



	// Wish 상품의 공개 범위 설정
	$(document).on('click', '.changeRelatedMy', function(){
		var wish_idx = $(this).find('.color-sky').data('wish_idx');
		var open_depth = $(this).find('.color-sky').data('open_depth');

		$(".selectDepthChangeMy").removeClass('icon-choice');
		$(".selectDepthChangeMy").each(function(){
			if($(this).data('value') == open_depth){
				$(this).addClass("icon-choice");
			}
		})

		$(".changeRelatedMyWishIdx").val(wish_idx);
	});

	$(document).on('click', '.selectDepthChangeMy', function(){
		var wish_idx = $(".changeRelatedMyWishIdx").val();
		var open_depth = $(this).data('value');
		var obj = $(".changeOpenDepthStrLayer" + wish_idx);

		$(".selectDepthChangeMy").removeClass('icon-choice');
		$(this).addClass("icon-choice");

		$.ajax({
			type	: "GET",
			url	: "./wishlist.ajax.php",
			data	: { mode : 'depth_my', wish_idx : wish_idx, depth : open_depth },
			dataType:"json"
		}).done(function ( json ) {
			console.log(json);
			if(json.res == 'SUCC'){
				// 성공시 처리
				$(obj).html(json.msg);
				$(obj).data('open_depth', json.open_depth);
			}else{
				alert("공개 설정 변경이 실패했습니다.");
			}
		});
	});

	$(document).on('click', '.copyWishProduct', function(){
		if(confirm("해당 상품을 My Wish에 추가 하시겠습니까?")){
			var wish_idx = $(this).data('wish_idx');
            var f_id = $('#f_id').val();
			$.ajax({
				method : 'POST',
				url : '/m/ajax.find.php',
				data	: { mode : 'address', band_no : 0 },
				async : false,
			}).done( function( result ) {
                addWish = true;
				if(result != "SUCC"){
					addWish = false;
					inputAddressPage = "/app/member_join_step3.php?mode=upd_adr&chUrl="+encodeURI("/app/wish_friend_detail.php?f_id="+f_id);
				}
            });
            if(addWish) {            
                $.ajax({
                    type	: "GET",
                    url	: "/app/wish.ajax.php",
                    data	: { mode : 'copy', wish_idx : wish_idx },
                }).done(function ( result ) {
                    if(result == 'SUCC'){
                     
						alert("해당 상품을 My Wish에 추가 하였습니다.\n 마이위시 직접 담기 10 포인트가 적립됩니다");

						// lyrOpen('#popPoint-reg', 'modal');

                    }else if(result == 'DUPL'){
                        alert("이미 존재하는 상품입니다.");
                    }else{
                        alert("추가 처리가 실패했습니다.");
                    }
                });
            } else {
                alert("배송지 정보를 입력하지 않은 회원입니다.\r입력 페이지로 이동합니다.");
                location.href = inputAddressPage;            
            }
		}
	});



	$(document).on('click', ".global_reserve_name_view", function(){
		$(".global_reserve_name_view").prop("checked", false);
		$(this).prop("checked", true);
	});

	// 사줄게 등록
	$(document).on('click', '.reserveThisItem', function(){
		var wish_idx = $(this).data('wish_idx');
		var productcode = $(this).data('productcode');
		if(!$(this).find('.btnStyleReserve' + wish_idx).hasClass('disabled')){
			$(".global_reserve_productcode").val(productcode);
			$(".global_wish_idx").val(wish_idx);
			$(".reserveThisItemFakeClick").trigger("click");
		}
	});


	// 사줄게 등록
	$(document).on('click', '.btnReserveBoxSubmit', function(){
		if(confirm("사줄게로 등록 하시겠습니까?")){
			var wish_idx = $(".global_wish_idx").val();
			var productcode = $(".global_reserve_productcode").val();

			var reserve_date = $(".global_reserve_year").val() + "-" + $(".global_reserve_month").val() + "-" + $(".global_reserve_day").val();
			var reserve_open = $(".global_reserve_name_view:checked").val();
            var date = new Date();
            var utc = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toJSON().slice(0,10);
            if(utc>reserve_date) {
                alert("유효기간은 현시간부터 설정가능합니다");
                return true;
            } else {
                $.ajax({
                    type	: "GET",
                    url	: "./wishlist.ajax.php",
                    data	: { mode : 'reserve', wish_idx : wish_idx, productcode : productcode, reserve_date : reserve_date, reserve_open : reserve_open },
                }).done(function ( result ) {
                    if(result == 'SUCC'){
                        $(".btnStyleReserve" + wish_idx).addClass('disabled');
                        $(".btnStyleBuy" + wish_idx).removeClass('disabled');
                        $(".characterIndex"+wish_idx+" [class^=icon-character]").attr('class', 'icon-character3');
                    }else if(result == 'OTHER'){
                        alert("다른 회원이 등록했습니다.");
                    }else if(result == 'DUPL'){
                        alert("이미 등록한 상품입니다.");
                    }else{
                        alert("사줄게 등록이 실패했습니다.");
                    }            
                    location.reload();                                    
                });
            }
		}



		/*
		if(!$(this).hasClass('disabled')){
			if(confirm("사줄게로 등록 하시겠습니까?")){
				var wish_idx = $(this).data('wish_idx');
				var productcode = $(this).data('productcode');
				var obj = $(this).parent().parent();
				$.ajax({
					type	: "GET",
					url	: "./wishlist.ajax.php",
					data	: { mode : 'reserve', wish_idx : wish_idx, productcode : productcode },
				}).done(function ( result ) {
					if(result == 'SUCC'){
						$(obj).find('.buyThisItem').removeClass('disabled');
						$(obj).find('.reserveThisItem').addClass('disabled');
					}else if(result == 'OTHER'){
						alert("다른 회원이 등록했습니다.");
					}else if(result == 'DUPL'){
						alert("이미 등록한 상품입니다.");
					}else{
						alert("사줄게 등록이 실패했습니다.");
					}

				});
			}
		}*/
	});




	// 구매 등록
	$(document).on('click', '.buyThisItem', function(){
		if(!$(this).hasClass('disabled')){
			if(confirm("해당 상품을 주문 하시겠습니까?")){
				var wish_idx = $(this).data('wish_idx');
				var band_no = $(this).data('band_no');

				actionObj = {
					wish_idx : wish_idx,
					band_no : band_no,
					mode : 'app_order'
				};

				$.ajax({
					method : 'POST',
					url : '/front/confirm_basket_proc.php',
					data: actionObj,
					dataType : 'json'
				}).done( function( data ) {
					if( actionObj.mode == 'app_order' ){
						if( data.basketidx ){
							location.href = "/m/order.php?basketidxs=" + data.basketidx;
						} else {
							alert('장바구니 등록이 실패되었습니다.');
						}
					}
				});
			}
		}
	});

	// 가입 하기
	$(document).on('click', '.btnSubmitJoin', function(){
		if(confirm("해당 밴드에 가입 신청 하시겠습니까?")){
			$("input[name='request_str']").val($(".request_temp").val());
			$("#frmJoin").submit();
		}
	});
	$(document).on('click', '.joinFlagDirectBtn', function(){
		if(confirm("해당 밴드에 가입 하시겠습니까?")){
			$("#frmJoin").submit();
		}
	});

});
