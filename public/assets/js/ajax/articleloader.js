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
			else if (location.host == 'hotreeder.com') {
				var http = 'http://hotreeder.com/';
			}

// 全置換：全ての文字列 org を dest に置き換える
String.prototype.replaceAll = function (org, dest) {
	return this.split(org).join(dest);
}
function replaceAll(expression, org, dest) {
    return expression.split(org).join(dest);
}
//----------------
//読み込み後の処理
//----------------
$(function() {
//
//
//
var scrollBottom     = '';
var fireflag         = true;
var article_number   = '';
//--------------------
//最後のセグメント取得
//--------------------
function category_segment_get() {
	var category_segment = '';
	var segment = location.pathname.split('/');
	var del_array = ["sharetube", ""];
	for(var i=0; i<segment.length; i++) {
		for(var ii=0; ii<del_array.length; ii++) {
			segment[i] = segment[i].replace(del_array[ii], '');
		}
	}
	for(var iii=0; iii<segment.length; iii++) {
	 if(segment[iii].length > 1) {
		 var category_segment = segment[iii];
	 }
	}
	return category_segment;
}
category_segment = category_segment_get();
//p(category_segment);
	//----
	//ajax
	//----
	$(window).scroll(function () {
		//----------------------
		//スクロール挙動確認表示
		//----------------------
		scrollBottom = $(window).scrollTop() + $(window).height();
		// テスト
/*
		$('.scroll_data_view').html('scrollTop：' + $(window).scrollTop() + '<br>' + 'height(html)：' + $('html').height() + '<br>' + 'height(window)：' + $(window).height() + '<br>' + 'scrollBottom：' + scrollBottom + '<br>' + '発火：' + ($('html').height() - scrollBottom));
*/
//		p($(window).scrollTop());
//		p($(window).height());
//		p($('html body').height());
		//--------------------
		//記事読み込みajax発火
		//--------------------
		if(($('html body').height() - scrollBottom)  <= 400) {
			// フラグが立っていたら本発火
			if(fireflag == true) {
				// 記事のナンバーを取得
				card_last_child = $('.main_contents').children('.card_article:last-child');
				li_last_child   = card_last_child.children('.card_article_content').children('ul').children('li:last-child');
				article_number = li_last_child.children('article').attr('data-article_number');
//				p(card_last_child);
//				p(li_last_child);
//				p(article_number);
				// フラグを折る
				fireflag = false;
				// ローディング表示
				ajax_loader_html = '<div class="ajax_loader"> </div>';
				$('.main_contents').append(ajax_loader_html);
				// ajax
				$.ajax({
					type: 'GET', 
					url: http + 'ajax/itypearticleloader/',
					data: {
						article_number:   article_number,
						category_segment: category_segment,
					},
					dataType: 'json',
					cache: false,
				  success: function(data) {
						// 1秒間止めてから作動
						setTimeout(function() {
							// ローディング削除
							$('.ajax_loader').remove();
							// 記事追加
							$('.main_contents').append(data["article_list_html"]);
							// 記事がある場合
							if(!data["article_list_html"] == '') {
								// フラグを立てる
								fireflag = true;
							}
								// ない場合
								else {
									// 文挿入
									ajax_loader_html = '<div class="ajax_error">ありがとう！ここが最終地点です。</div>';
									// 表示
									$('.main_contents').append(ajax_loader_html);									
								}
						}, 300);
				  },
					// エラー処理
				  error: function(data) {
//						p(data);
						// ローディング削除
						$('.ajax_loader').remove();
						// エラー文挿入
						ajax_loader_html = '<div class="ajax_error">読み込みエラーになってしまいました。</div>';
						// 表示
						$('.main_contents').append(ajax_loader_html);
				  },
				  complete: function(data) {
//						p(data);
				  }
				}); // $.ajax({
			} // if(fireflag == true) {
		} // if(($('html').height() - scrollBottom)  <= 120) {
	}); // $(window).scroll(function () {
}); // $(function() {
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

$(function() {
	//----------------------------------
	//slideshareスライドレスポンシブ表示
	//----------------------------------
	if($('.slideshare')) {
		if($(window).width() <= 320) {
			var w              = $('.detail_press').width();
			var y_w            = $('.slideshare iframe').attr('width');
			var y_h            = $('.slideshare iframe').attr('height');
			var ratio          = (y_h / y_w);
			var responsive_y_h = (ratio * w);
			$('.slideshare iframe').attr( {
				width: '100%',
				height: '234'});
		}
	}
	//-----------------------
	//youtubeレスポンシブ表示
	//-----------------------
	if($('.youtube')) {
		if($(window).width() <= 560) {			
			var w              = $('.detail_press').width();
			var y_w            = $('.youtube iframe').attr('width');
			var y_h            = $('.youtube iframe').attr('height');
			var ratio          = (y_h / y_w);
			var responsive_y_h = (ratio * w);
			// 変更
			$('.youtube iframe').attr( {
				width: '100%',
				height: responsive_y_h});
			// ウインドウがリサイズされたら
			$( window ).resize(function() {
				var w_r              = $('.detail_press').width();
				var responsive_y_h_r = (ratio * w_r);
				$('.youtube iframe').attr( {
					width: '100%',
					height: responsive_y_h_r});
			});
		}
	}
	});
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