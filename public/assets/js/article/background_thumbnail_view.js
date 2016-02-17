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
	//----------------
	//読み込み後の処理
	//----------------
$(function() {
	//----------------------------
	//記事のバックに画像を表示する
	//----------------------------
	// 表示する場所の大きさを取得
	var article_list_contents_height = $('.article_list_contents').height();
//	p(article_list_contents_height);
	// ズレる余白を取得
	var main_padding_top                    = $('.main').css('padding-top').replace('px', '');
	var article_list_contents_margin_bottom = $('.article_list_contents').css('margin-bottom').replace('px', '');
	// intにキャストする
	main_padding_top                    = eval(main_padding_top);
	article_list_contents_margin_bottom = eval(article_list_contents_margin_bottom);
//	p('main_padding_top：'+main_padding_top);
//	p('article_list_contents_margin_bottom：'+article_list_contents_margin_bottom);
	// 微調整
	var adjust = -15;
	// ブラウザのサイズによって調整していく
	if($(window).width() <= 768) {
		var adjust = 8;
		main_padding_top = 8;
	}
		else if($(window).width() <= 480) {
			var adjust = 8;
			main_padding_top = 8;
		}
			else if($(window).width() <= 320) {
				var adjust = 8;
				main_padding_top = 8;
			}
	// 余白を合計する
	var shift = main_padding_top + article_list_contents_margin_bottom;
//	p(shift);
	// 記事のナンバーを取得
	article_number = $('.main_contents .article_list').attr('data-article_number');
	// 記事のアップされた年を取得
	article_year = $('.main_contents .article_list').attr('data-article_year');
	// デフォルト設定
	$('.article_list_contents_background').css( {
	background: 'url("'+ http +'/assets/img/article/'+article_year+'/facebook_ogp/'+article_number+'.jpg") no-repeat scroll center center / cover rgba(0, 0, 0, 0)',
	    height: adjust + shift + article_list_contents_height + "px",
	    width: $(window).width()+"px",
	});
// 2秒待機して数値を取得する
setTimeout(function() {
	var article_list_contents_height = $('.article_list_contents').height();
//	p(article_list_contents_height);
	// 再設定
	$('.article_list_contents_background').css( {
	background: 'url("'+ http +'/assets/img/article/'+article_year+'/facebook_ogp/'+article_number+'.jpg") no-repeat scroll center center / cover rgba(0, 0, 0, 0)',
	    height: adjust + shift + article_list_contents_height + "px",
	    width: $(window).width()+"px",
	});
}, 2000);
	//--------------------------
	//正しい数値を取得するテスト
	//--------------------------
	$('#header').click(function() {
		var article_list_contents_height = $('.article_list_contents').height();
//		p(article_list_contents_height);
	});
	//--------------------------------------
	//記事のバックに画像を表示する(リサイズ)
	//--------------------------------------
	$(window).resize(function() {
		// 表示する場所の大きさを取得
		var article_list_contents_height = $('.article_list_contents').height();
	//	p(article_list_contents_height);
		// ズレる余白を取得
		var main_padding_top                    = $('.main').css('padding-top').replace('px', '');
		var article_list_contents_margin_bottom = $('.article_list_contents').css('margin-bottom').replace('px', '');
		// intにキャストする
		main_padding_top                    = eval(main_padding_top);
		article_list_contents_margin_bottom = eval(article_list_contents_margin_bottom);
//		p('main_padding_top：'+main_padding_top);
//		p('article_list_contents_margin_bottom：'+article_list_contents_margin_bottom);
		// 微調整
		var adjust = -15;
		// ブラウザのサイズによって調整していく
		if($(window).width() <= 768) {
			var adjust = 8;
			main_padding_top = 8;
		}
			else if($(window).width() <= 480) {
				var adjust = 8;
				main_padding_top = 8;
			}
				else if($(window).width() <= 320) {
					var adjust = 8;
					main_padding_top = 8;
				}
		// 余白を合計する
		var shift = main_padding_top + article_list_contents_margin_bottom;
	//	p(shift);
		// 記事のナンバーを取得
		article_number = $('.main_contents .article_list').attr('data-article_number');
		// 記事のアップされた年を取得
		article_year = $('.main_contents .article_list').attr('data-article_year');
		// デフォルト設定
		$('.article_list_contents_background').css( {
		background: 'url("'+ http +'/assets/img/article/'+article_year+'/facebook_ogp/'+article_number+'.jpg") no-repeat scroll center center / cover rgba(0, 0, 0, 0)',
		    height: adjust + shift + article_list_contents_height + "px",
		    width: $(window).width()+"px",
		});
	});
	});