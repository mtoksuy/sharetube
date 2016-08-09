

//$("input:not(:checked) + label").css("background-color", "yellow");
$(function() {


//------------
//画像リサイズ
//------------
function gallery_box_content_image_rsize(width, height) {
		$('.gallery_box_content img').css( {
			'height': height,
			'width': width,
			});						
/*
	if(width == height) {
		$('.gallery_box_content img').css( {
			'height': '100%',
			'width': '100%',
			});						
	}
		else if(width > height) {
			$('.gallery_box_content img').css( {
				'height': 'auto',
				'width': '100%',
				});						
		}
			else {
				$('.gallery_box_content img').css( {
					'height': '100%',
					'width': 'auto',
					});
			}
*/
/*

	if($(this).width() == $(this).height()) {
		$('.gallery_box_content img').css( {
			'height': '100%',
			'width': '100%',
			});						
	}
		else if($(this).width() > $(this).height()) {
			$('.gallery_box_content img').css( {
				'height': 'auto',
				'width': '100%',
				});						
		}
			else {
				$('.gallery_box_content img').css( {
					'height': '100%',
					'width': 'auto',
					});
*/
}
//--------------------
//リサイズする前の計算
//--------------------
function gallery_box_content_image_rsize_calculation(img) {
					var width  = img.width;  // 幅
					var height = img.height; // 高さ

					// モーダル画面の大きさ
					modal_width  = $('.gallery_box_content').width();  // 832
					modal_height = $('.gallery_box_content').height(); // 534

					var width  = img.width;  // 600
					var height = img.height; // 450
					// 比率
					w_ratio           = height/width;         // 0.75
					h_ratio           = width/height;         //1.333
					// 実際に割り当てた画像の大きさ
					view_image_width  = modal_height*h_ratio; // 712
					view_image_height = modal_width*w_ratio;  // 624
/*
					// 
					p(modal_width);
					p(modal_height);
					p(width);
					p(height);
					p(view_image_width);
					p(view_image_height);
*/

					// 画面が横の方が大きい場合
					if(modal_width > modal_height) {
//						p('おおきい');
						// 画像の縦の大きさがモーダルを超えている場合
						if(modal_height < view_image_height) {
//							p('縦こえとるよ');
							gallery_box_content_image_rsize(''+modal_height*h_ratio+'px', ''+modal_height+'px');
						}
						// 画像の縦の大きさがモーダルを超えている場合
						if(modal_width < view_image_width) {
//							p('横こえとるよ');
							gallery_box_content_image_rsize(''+modal_width+'px', ''+modal_width*w_ratio+'px');
						}
						// 画像の大きさがモーダルを超えている場合
						if(modal_width < view_image_width && modal_height < view_image_height) {
//							p('両方こえとるよ');
//							gallery_box_content_image_rsize(''+modal_height*h_ratio+'px', ''+modal_height+'px');
						}
					}
						// 画面が縦の方が大きい場合
						else {
//							p('ちいさい');
							// 画像の縦の大きさがモーダルを超えている場合
							if(modal_height < view_image_height) {
//								p('縦こえとるよ2');
								gallery_box_content_image_rsize(''+modal_height*h_ratio+'px', ''+modal_height+'px');
							}
							// 画像の縦の大きさがモーダルを超えている場合
							if(modal_width < view_image_width) {
//								p('横こえとるよ2');
								gallery_box_content_image_rsize(''+modal_width+'px', ''+modal_width*w_ratio+'px');
							}
							// 画像の大きさがモーダルを超えている場合
							if(modal_width < view_image_width && modal_height < view_image_height) {
//								p('両方こえとるよ2');
	//							gallery_box_content_image_rsize(''+modal_height*h_ratio+'px', ''+modal_height+'px');
							}

/*
							// 画像も横の方が大きい場合
							if(width < height) {
								// 画像の縦の大きさがモーダルを超えている場合
								if(modal_height < view_image_height) {
									p('こえとるよ2');
	
//									gallery_box_content_image_rsize(''+modal_height*h_ratio+'px', ''+modal_height+'px');
								}
							}
*/
						} // else {
}
	//---------------------
	//image_list_object生成
	//---------------------
	var article_list_contents_sub_text_img = $(".article_list_contents_sub_text img");
	var tweet_content_icon_img             = $(".article_list_contents_sub_text .tweet_content_icon img");
	var image_list_object = $();
//	var image_url_list    = '';
	// 画像抜き出し
	article_list_contents_sub_text_img.each( function(key, value) {
		tweet_content_icon_check = $(this).parents('.tweet_content_icon');
		amazon_link_image_check  = $(this).parents('.amazon_link_image');
		amazon_link_text_check   = $(this).parents('.amazon_link_text');
		gallery_cell_check       = $(this).parents('.gallery-cell');
		matome_content_block_itunes_app_icon_check = $(this).parents('.matome_content_block_itunes_app_icon');
		matome_content_block_itunes_app_data_badge_check = $(this).parents('.matome_content_block_itunes_app_data_badge');


		tweet_content_icon_check = tweet_content_icon_check.attr('class');
		amazon_link_image_check  = amazon_link_image_check.attr('class');
		amazon_link_text_check   = amazon_link_text_check.attr('class');
		gallery_cell_check       = gallery_cell_check.attr('class');
		matome_content_block_itunes_app_icon_check = matome_content_block_itunes_app_icon_check.attr('class');
		matome_content_block_itunes_app_data_badge_check = matome_content_block_itunes_app_data_badge_check.attr('class');


		if(tweet_content_icon_check) {

		}
			else if(amazon_link_image_check) {

			}
				else if(amazon_link_text_check) {
	
				}
					else if(gallery_cell_check) {
		
					}
					else if(matome_content_block_itunes_app_icon_check) {
		
					}
					else if(matome_content_block_itunes_app_data_badge_check) {
		
					}
						else {
							image_list_object = image_list_object.add($(this));
						}
	});
//p(image_list_object);


	//----------------
	//モーダル画面開く
	//----------------
	$('.article_list').on( {
		'click' : function(event) {
			tweet_content_icon_check = $(this).parents('.tweet_content_icon');
			amazon_link_image_check  = $(this).parents('.amazon_link_image');
			amazon_link_text_check   = $(this).parents('.amazon_link_text');
			gallery_cell_check       = $(this).parents('.gallery-cell');
			matome_content_block_itunes_app_icon_check = $(this).parents('.matome_content_block_itunes_app_icon');
			matome_content_block_itunes_app_data_badge_check = $(this).parents('.matome_content_block_itunes_app_data_badge');


			tweet_content_icon_check = tweet_content_icon_check.attr('class');
			amazon_link_image_check  = amazon_link_image_check.attr('class');
			amazon_link_text_check   = amazon_link_text_check.attr('class');
			gallery_cell_check       = gallery_cell_check.attr('class');
			matome_content_block_itunes_app_icon_check = matome_content_block_itunes_app_icon_check.attr('class');
			matome_content_block_itunes_app_data_badge_check = matome_content_block_itunes_app_data_badge_check.attr('class');

			if(tweet_content_icon_check) {
				return true;
			}
				else if(amazon_link_image_check) {
					return true;
				}
					else if(amazon_link_text_check) {
						return true;	
					}
						else if(gallery_cell_check) {
							return true;	
						}
						else if(matome_content_block_itunes_app_icon_check) {
							return true;	
						}
						else if(matome_content_block_itunes_app_data_badge_check) {
							return true;	
						}
				else {
					$('#wrapper').before('\
<div class="gallery_overlay">\
	<div class="gallery_box">\
		<div class="gallery_box_content">\
			<a class="main_a" href="'+$(this).attr('src')+'" target="_blank"><img class="great_image_100" src="'+$(this).attr('src')+'" width="640" height="400"></a>\
			<a class="sub_a" href="'+$(this).attr('src')+'" target="_blank">こちらから画像のみ表示できます。</a>\
			<div class="gallery_box_content_left">\
				<span class="typcn typcn-media-play-reverse-outline"></span>\
			</div>\
			<div class="gallery_box_content_right">\
				<span class="typcn typcn-media-play-outline"></span>\
			</div>\
			<div class="gallery_box_content_delete_button">×</div>\
		</div>\
	</div>\
</div>');
					var img = new Image();
					img.src = $(this).attr('src'); 
					// 画像リサイズ
					gallery_box_content_image_rsize_calculation(img);
					return false;
				} // else {
		} // 'click' : function(event) {
	}, '.article_list_contents_sub_text img');

	//--------------------------
	//モーダル画面レフトクリック
	//--------------------------
	$('html').on( {
		'click' : function(event) {
			now_src = $('.gallery_box_content img').attr('src');
			image_list_object_length = image_list_object.length;
			image_list_object.each( function(key, value) {
				if($(this).attr('src') == now_src) {
					now_number = key;
				}
			});
/*
			p(image_list_object.get(now_number-1));
			p(image_list_object.get(now_number-1).width);
			p(image_list_object.get(now_number-1).height);
*/
			image_list_object_length--;
				if(now_number == 0) {

				}
						else {
							$('.gallery_box_content a').remove();
							$('.gallery_box_content').prepend('<a href="'+image_list_object.get(now_number-1).src+'" target="_blank"><img class="great_image_100" src="'+image_list_object.get(now_number-1).src+'" width="640" height="400"></a><a class="sub_a" href="'+image_list_object.get(now_number-1).src+'" target="_blank">こちらから画像のみ表示できます。</a>');
							var img = new Image();
							img.src = image_list_object.get(now_number-1).src; 
							// 画像リサイズ
							gallery_box_content_image_rsize_calculation(img);
						}
		}
	}, '.gallery_box_content_left');
	//--------------------------
	//モーダル画面ライトクリック
	//--------------------------
	$('html').on( {
		'click' : function(event) {
			now_src = $('.gallery_box_content img').attr('src');
			image_list_object_length = image_list_object.length;
			image_list_object.each( function(key, value) {
				if($(this).attr('src') == now_src) {
					now_number = key;
				}
			});
			image_list_object_length--;
				if(now_number == image_list_object_length) {

				}
						else {
							$('.gallery_box_content a').remove();
							$('.gallery_box_content').prepend('<a href="'+image_list_object.get(now_number+1).src+'" target="_blank"><img class="great_image_100" src="'+image_list_object.get(now_number+1).src+'" width="640" height="400"></a><a class="sub_a" href="'+image_list_object.get(now_number+1).src+'" target="_blank">こちらから画像のみ表示できます。</a>');
							var img = new Image();
							img.src = image_list_object.get(now_number+1).src; 
							// 画像リサイズ
							gallery_box_content_image_rsize_calculation(img);
						}
		}
	}, '.gallery_box_content_right');















	//----------------
	//モーダル画面削除
	//----------------
	$('html').on( {
		'click' : function(event) {
			$('.gallery_overlay').remove();
		}
	}, '.gallery_box_content_delete_button');
	//----------------
	//モーダル画面削除
	//----------------
	$('html').on( {
		'click' : function(event) {
			$('.gallery_overlay').remove();
		}
	}, '.gallery_overlay');
	//----------------
	//モーダル画面削除
	//----------------
	$('html').on( {
		'click' : function(event) {
			$('.gallery_overlay').remove();
		}
	}, '.gallery_box');
	//----------------
	//モーダル画面削除
	//----------------
	$('html').on( {
		'click' : function(event) {
		event.stopPropagation();
		}
	}, '.gallery_box_content');


});
