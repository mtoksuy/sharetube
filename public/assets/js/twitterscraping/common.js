/***************************************
2015年版JavaScriptユーザエージェント判別
https://w3g.jp/blog/js_browser_sniffing2015
***************************************/
var _ua = (function(u) {
	return {
	Tablet:(u.indexOf("windows") != -1 && u.indexOf("touch") != -1) || u.indexOf("ipad") != -1 || (u.indexOf("android") != -1 && u.indexOf("mobile") == -1) || (u.indexOf("firefox") != -1 && u.indexOf("tablet") != -1) || u.indexOf("kindle") != -1 || u.indexOf("silk") != -1 || u.indexOf("playbook") != -1,
	Mobile:(u.indexOf("windows") != -1 && u.indexOf("phone") != -1) || u.indexOf("iphone") != -1 || u.indexOf("ipod") != -1 || (u.indexOf("android") != -1 && u.indexOf("mobile") != -1) || (u.indexOf("firefox") != -1 && u.indexOf("mobile") != -1) || u.indexOf("blackberry") != -1
	}
})(window.navigator.userAgent.toLowerCase());

/*************************
デバッグ変数コンストラクタ
*************************/
/*
var p        = console.log;
var print    = console.log;
var var_dump = console.dir;
var trace    = console.trace;
var time     = console.time;
var count    = console.count;
*/

/*************
グローバル変数
*************/

/***********
http切り替え
***********/
if (location.host == 'localhost') {
	var http = 'http://localhost/sharetube/';
}
	else if (location.host == 'sharetube.jp') {
		var http = 'http://sharetube.jp/';
	}
		else if (location.host == 'www.sharetube.jp') {
			var http = 'http://sharetube.jp/';
		}
	//----------------
	//読み込み後の処理
	//----------------
	$(function() {
		//
		//
		//
	}); // $(function() {


/*******************
HTML読み込み後に処理
*******************/
$(window).load(function(){
	var tweet_obj                = $('.tweet');
	var array                    = [];
	var image_width_array        = [];
	var image_height_array       = [];
	var tweet_image_media_i      = 0;
	var tweet_image_media_height = 0;
	var image_remainder_number   = 0;
	var tweet_content_padding_left_number = parseInt($('.tweet_content').css('padding-left'));

	// 重要
	var content_width                     = $('.article_list_contents').width();
	// こっちでも大丈夫かも
	var content_width                     = $('.tweet').width();
	var tweetscraping_width = content_width - tweet_content_padding_left_number;
//	p(content_width);
//	p(tweetscraping_width * 0.3);

/*
	// 横幅指定
	$('.image_media_2').css( {
		width: tweetscraping_width+'px'
	});
*/
	/////////////////////
	// tweetscraping each
	/////////////////////
	tweet_obj.each(function(i, elem) {
		// 画像each
		$(this).find('.tweet_image_media img').each(function(i, elem) {
/*
			image_width_array[i]  = $(this).attr('width');
			image_height_array[i] = $(this).attr('height');
*/
			image_width_array[i]  = $(this).width();
			image_height_array[i] = $(this).height();

/*
			p(image_width_array);
			p(image_height_array);
*/
			tweet_image_media_i++;
		});
		/////////////
		// 同じ大きさ
		/////////////
		if(image_height_array[0] == image_height_array[1]) {
			// 同じ大きさ > (tweetscraping_width * 0.3)より大きいか精査
			if((tweetscraping_width * 0.3) < image_height_array[1] || (tweetscraping_width * 0.3) == image_height_array[1]) {
				tweet_image_media_height = (tweetscraping_width * 0.3);
			}
				// 同じ大きさ > (tweetscraping_width * 0.3)より小さいか精査
				else if((tweetscraping_width * 0.3) > image_height_array[1]) {
					tweet_image_media_height = image_height_array[1];
				}
		}
			/////////////
			// 右が大きい
			/////////////
			else if(image_height_array[0] < image_height_array[1]) {
//				p('右が大きい');
					// 同じ大きさ > (tweetscraping_width * 0.3)より大きいか精査
					if((tweetscraping_width * 0.3) < image_height_array[0] || (tweetscraping_width * 0.3) == image_height_array[0]) {
						tweet_image_media_height = (tweetscraping_width * 0.3);
					}
						// 同じ大きさ > (tweetscraping_width * 0.3)より小さいか精査
						else if((tweetscraping_width * 0.3) > image_height_array[0]) {
							tweet_image_media_height = image_height_array[0];
						}
			}
				/////////////
				// 左が大きい
				/////////////
				else {
//					p('左が大きい');
					// 同じ大きさ > (tweetscraping_width * 0.3)より大きいか精査
					if((tweetscraping_width * 0.3) < image_height_array[1] || (tweetscraping_width * 0.3) == image_height_array[1]) {
						tweet_image_media_height = (tweetscraping_width * 0.3);
					}
						// 同じ大きさ > (tweetscraping_width * 0.3)より小さいか精査
						else if((tweetscraping_width * 0.3) > image_height_array[1]) {
							tweet_image_media_height = image_height_array[1];
						}
				}
		//////////////
		//縦幅最終調整
		//////////////
		// 画像each
		$(this).find('.tweet_image_media img').each(function(i, elem) {
			// 余り計算
			image_remainder_number = ($(this).height() - tweet_image_media_height) / 2;
			if(image_remainder_number < 0) {
				image_remainder_number = 0;
			}
			// img調整
			$(this).css( {
				position: 'relative', 
				top:-+image_remainder_number+'px'
			});
		});
		///////////////////
		//画像1枚の挙動直し
		///////////////////
		$('.image_media_1 img').css( {
				position: 'static', 
				top:'0px'
		});
		//////////////
		//縦幅最終調整
		//////////////
		$(this).find('.image_media_2_top').css( {
			height: tweet_image_media_height+ 'px'
		});

		$(this).find('.image_media_4_top').css( {
			height: tweet_image_media_height+ 'px'
		});

		$(this).find('.image_media_4_bottom').css( {
			height: tweet_image_media_height+ 'px'
		});

		//////////////
		//縦幅最終調整
		//////////////
		image_width_array  = [];
		image_height_array = [];
	}); // tweet_obj.each(function(i, elem) {
});


//--------
//リサイズ
//--------
$(window).resize(function() {


	var tweet_obj                = $('.tweet');
	var array                    = [];
	var image_width_array        = [];
	var image_height_array       = [];
	var tweet_image_media_i      = 0;
	var tweet_image_media_height = 0;
	var image_remainder_number   = 0;
	var tweet_content_padding_left_number = parseInt($('.tweet_content').css('padding-left'));

	// 重要
	var content_width                     = $('.article_list_contents').width();
//	p(content_width);
	// こっちでも大丈夫かも
	var content_width                     = $('.tweet').width();
//	p(content_width);
	var tweetscraping_width = content_width - tweet_content_padding_left_number;
//	p(content_width);
//	p(tweetscraping_width * 0.3);

/*
	// 横幅指定
	$('.image_media_2').css( {
		width: tweetscraping_width+'px'
	});
*/
	/////////////////////
	// tweetscraping each
	/////////////////////
	tweet_obj.each(function(i, elem) {
		// 画像each
		$(this).find('.tweet_image_media img').each(function(i, elem) {
/*
			image_width_array[i]  = $(this).attr('width');
			image_height_array[i] = $(this).attr('height');
*/
			image_width_array[i]  = $(this).width();
			image_height_array[i] = $(this).height();

/*
			p(image_width_array);
			p(image_height_array);
*/
			tweet_image_media_i++;
		});
		/////////////
		// 同じ大きさ
		/////////////
		if(image_height_array[0] == image_height_array[1]) {
			// 同じ大きさ > (tweetscraping_width * 0.3)より大きいか精査
			if((tweetscraping_width * 0.3) < image_height_array[1] || (tweetscraping_width * 0.3) == image_height_array[1]) {
				tweet_image_media_height = (tweetscraping_width * 0.3);
			}
				// 同じ大きさ > (tweetscraping_width * 0.3)より小さいか精査
				else if((tweetscraping_width * 0.3) > image_height_array[1]) {
					tweet_image_media_height = image_height_array[1];
				}
		}
			/////////////
			// 右が大きい
			/////////////
			else if(image_height_array[0] < image_height_array[1]) {
//				p('右が大きい');
					// 同じ大きさ > (tweetscraping_width * 0.3)より大きいか精査
					if((tweetscraping_width * 0.3) < image_height_array[0] || (tweetscraping_width * 0.3) == image_height_array[0]) {
						tweet_image_media_height = (tweetscraping_width * 0.3);
					}
						// 同じ大きさ > (tweetscraping_width * 0.3)より小さいか精査
						else if((tweetscraping_width * 0.3) > image_height_array[0]) {
							tweet_image_media_height = image_height_array[0];
						}
			}
				/////////////
				// 左が大きい
				/////////////
				else {
//					p('左が大きい');
					// 同じ大きさ > (tweetscraping_width * 0.3)より大きいか精査
					if((tweetscraping_width * 0.3) < image_height_array[1] || (tweetscraping_width * 0.3) == image_height_array[1]) {
						tweet_image_media_height = (tweetscraping_width * 0.3);
					}
						// 同じ大きさ > (tweetscraping_width * 0.3)より小さいか精査
						else if((tweetscraping_width * 0.3) > image_height_array[1]) {
							tweet_image_media_height = image_height_array[1];
						}
				}
		//////////////
		//縦幅最終調整
		//////////////
		// 画像each
		$(this).find('.tweet_image_media img').each(function(i, elem) {
			// 余り計算
			image_remainder_number = ($(this).height() - tweet_image_media_height) / 2;
			if(image_remainder_number < 0) {
				image_remainder_number = 0;
			}
			// img調整
			$(this).css( {
				position: 'relative', 
				top:-+image_remainder_number+'px'
			});
		});
		///////////////////
		//画像1枚の挙動直し
		///////////////////
		$('.image_media_1 img').css( {
				position: 'static', 
				top:'0px'
		});
		//////////////
		//縦幅最終調整
		//////////////
		$(this).find('.image_media_2_top').css( {
			height: tweet_image_media_height+ 'px'
		});

		$(this).find('.image_media_4_top').css( {
			height: tweet_image_media_height+ 'px'
		});

		$(this).find('.image_media_4_bottom').css( {
			height: tweet_image_media_height+ 'px'
		});

		//////////////
		//縦幅最終調整
		//////////////
		image_width_array  = [];
		image_height_array = [];
	}); // tweet_obj.each(function(i, elem) {




});






/*
	var html = $('.article_inside_related_article .article_inside_related_article_content ul').children();
	$(html).each(function(i, elem) {
		var delete_number = parseInt($(this).css('padding-top'), 10) + parseInt($(this).css('padding-bottom'), 10);
		array.push(elem.clientHeight - delete_number - 9); // innerのpadding10pxを取り除いた 1少ないのは段落つけなくするため
	});
	// 配列の中の最大値を求める
	var max = Math.max.apply(null, array);
	$('.article_inside_related_article .article_inside_related_article_content ul li article a .inner').css( {
		height: max + 'px'
	});
*/







//------------------
//リサイズの時の参考
//------------------
/*
	$(window).resize(function() {
	    //ボックスサイズ
	    $("#modalbox").css({
	        top: ($(window).height() - $("#modalbox").outerHeight()) / 2,
	        left: ($(window).width() - $("#modalbox").outerWidth()) / 2
	    });
	});
*/

/*
//----------------
//ブラウザの大きさ
//----------------
$(window).width();
$(window).height();
//----------------------
//スクロールしている数値
//----------------------
$(window).scrollTop();
//------------
//一番底の数値
//------------
$('html').height()
*/