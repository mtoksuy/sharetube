/*************************
デバッグ変数コンストラクタ
*************************/

var p        = console.log;
var print    = console.log;
var var_dump = console.dir;
var trace    = console.trace;
var time     = console.time;
var count    = console.count;

/***********************
自分自身のHTMLを取得する
***********************/
(function($) {
	$.fn.selfHtml = function(options) {
		if($(this).get(0)) {
			return $(this).get(0).outerHTML;
		}
	}
})(jQuery);

//----------------
//ビトウィーンHTML
//----------------
var item_add_between_html = ('<div class="item_add_between">\
	<div class="item_add_between_content">\
		<span class="typcn typcn-plus"></span>追加\
	</div>\
	<div class="dashed"> </div>\
</div>');
//----------------
//読み込み後の処理
//----------------
$(function() {
/********************************
アイテム テキスト追加フォーム生成
********************************/
$('.item_add_content_list_text').on('click', function(event) {
	$('.matome').find('.matome_content').prepend('<div class="text_add">\
									<div class="text_add_content">\
										<textarea placeholder="テキストを入力"></textarea>\
										<div class="text_add_content_button clearfix">\
											<div class="text_add_content_button_left">\
												<div class="text_add_content_submit">保存</div>\
											</div>\
											<div class="text_add_content_button_right">\
											<div class="text_add_content_cancel">キャンセル</div>\
											</div>\
										</div>\
									</div> <!-- text_add_content -->\
								</div> <!-- text_add -->');
});
/****************
テキスト追加 保存
****************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var text_add = $(this).parents('.text_add');
		// テキスト抽出
		var text       = text_add.find("textarea").val();
		// クラスネーム取得
		var class_name = $(this).parents('.text_add').next().attr('class');
		// テキスト追加
		$(this).parents('.text_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_text">\
		<pre>'+text+'</pre>\
	</div>\
</div>');
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.text_add').before(item_add_between_html);
		}
		// 自要素削除
		text_add.remove();
	}
}, '.text_add_content_submit');
/**********************
テキスト追加 キャンセル
**********************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val = $(this).attr('data-val');
		// 元データがない場合
		if(data_val == null) {
			// 親を指定して取得
			var text_add = $(this).parents('.text_add');
			// 自要素削除
			text_add.remove();
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var text_add = $(this).parents('.text_add');
				// テキスト追加
				$(this).parents('.text_add').before('<div class="matome_content_block">\
				<div class="matome_content_block_text">\
				<pre>'+data_val+'</pre>\
				</div>\
				</div>');
				// 自要素削除
				text_add.remove();
			}
	},
}, '.text_add_content_cancel');







/******************************
アイテム 見出し追加フォーム生成 
******************************/
$('.item_add_content_list_title').on('click', function(event) {
	$('.matome').find('.matome_content').prepend('<div class="title_add">\
	<div class="title_add_content">\
		<textarea placeholder="テキストを入力"></textarea>\
		<div class="title_add_content_button clearfix">\
			<div class="title_add_content_button_left">\
				<div class="title_add_content_submit">保存</div>\
			</div>\
			<div class="title_add_content_button_right">\
				<div class="title_add_content_cancel">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- title_add_content -->\
</div> <!-- title_add -->');
});
/*******************************************
アイテム ビトウィーン 見出し追加フォーム生成 
*******************************************/
$('.matome').on( {
	'click' : function(event) {
		var item_between_add = $(this).parents('.item_between_add');
//		p('は？');
		$(this).parents('.item_between_add').before('<div class="title_add">\
		<div class="title_add_content">\
			<textarea placeholder="テキストを入力"></textarea>\
			<div class="title_add_content_button clearfix">\
				<div class="title_add_content_button_left">\
					<div class="title_add_content_submit">保存</div>\
				</div>\
				<div class="title_add_content_button_right">\
					<div class="title_add_content_cancel">キャンセル</div>\
				</div>\
			</div>\
		</div> <!-- title_add_content -->\
	</div> <!-- title_add -->');
	item_between_add.remove();

	}
}, '.item_between_add_content_list_title');
/**************
見出し追加 保存
**************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var title_add = $(this).parents('.title_add');
		// 見出し抽出
		var title     = title_add.find("textarea").val();
		// クラスネーム取得
		var class_name = $(this).parents('.title_add').next().attr('class');
		// 見出し追加
		$(this).parents('.title_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_title">\
		<h2 class="heading_5">'+title+'</h2>\
	</div>\
</div>');
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.title_add').before(item_add_between_html);
		}
		// 自要素削除
		title_add.remove();
	}
}, '.title_add_content_submit');
/********************
見出し追加 キャンセル
********************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val = $(this).attr('data-val');
		// 元データがない場合
		if(data_val == null) {
			// 親を指定して取得
			var title_add = $(this).parents('.title_add');
			// 自要素削除
			title_add.remove();
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var title_add = $(this).parents('.title_add');
				// 見出し追加
				$(this).parents('.title_add').before('<div class="matome_content_block">\
			<div class="matome_content_block_title">\
				<h2 class="heading_5">'+data_val+'</h2>\
			</div>\
		</div>');
				// 自要素削除
				title_add.remove();
			}
	},
}, '.title_add_content_cancel');

/****************************
アイテム 引用追加フォーム生成
****************************/
$('.item_add_content_list_quote').on('click', function(event) {
	$('.matome').find('.matome_content').prepend('<div class="quote_add">\
	<div class="quote_add_content">\
		<textarea class="quote_add_content_quote" placeholder="引用を入力"></textarea>\
		<input type="text" class="quote_add_content_url" value="" placeholder="引用の出典元URLを入力(ウェブページの場合)">\
		<input type="text" class="quote_add_content_title" value="" placeholder="引用の出典を入力">\
		<textarea class="quote_add_content_word" placeholder="引用の紹介コメントを入力"></textarea>\
		<div class="quote_add_content_button clearfix">\
			<div class="quote_add_content_button_left">\
				<div class="quote_add_content_submit">保存</div>\
			</div>\
			<div class="quote_add_content_button_right">\
				<div class="quote_add_content_cancel">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- quote_add_content -->\
</div> <!-- quote_add -->');
});
/*************************************
引用追加 チェックURLのタイトル自動取得
*************************************/
$('.matome').on( {
	'change': function() {
		var val    = $(this).val();
		var j_this = $(this);
		var re     = /https|http/;
		var test = val.match(re);
		// 正しいURLか検査
		if(test) {
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/urltitleget/',
				data: {
					url: val,
				},
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					// チェック判別
					if(data['check'] == true) {
						j_this.next().val(data['title']);
					}
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			});
		}  // if(test) {
	},
	'keypress': function() {

	}
}, '.quote_add_content_url');

/************
引用追加 保存
************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var quote_add = $(this).parents('.quote_add');
		// 引用抽出
		var quote = quote_add.find('.quote_add_content_quote').val();
		var url   = quote_add.find('.quote_add_content_url').val();
		var title = quote_add.find('.quote_add_content_title').val();
		var word  = quote_add.find('.quote_add_content_word').val();

		// クラスネーム取得
		var class_name = $(this).parents('.quote_add').next().attr('class');
		// 引用追加
		$(this).parents('.quote_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_quote">\
		<pre>'+quote+'</pre>\
		<p class="blockquote_font text_right m_b_0">出典:<cite><a href="'+url+'" target="_blank">'+title+'</a></cite></p>\
	<pre class="author_word">'+word+'</pre>\
	</div>\
</div>');
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.quote_add').before(item_add_between_html);
		}
		// 自要素削除
		quote_add.remove();
	}
}, '.quote_add_content_submit');
/******************
引用追加 キャンセル
******************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val = $(this).attr('data-val');
		// 元データがない場合
		if(data_val == null) {
			// 親を指定して取得
			var quote_add = $(this).parents('.quote_add');
			// 自要素削除
			quote_add.remove();
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var quote_add = $(this).parents('.quote_add');
				// 引用抽出
				var quote = quote_add.find('.quote_add_content_quote').val();
				var url   = quote_add.find('.quote_add_content_url').val();
				var title = quote_add.find('.quote_add_content_title').val();
				var word  = quote_add.find('.quote_add_content_word').val();
				// 引用追加
				$(this).parents('.quote_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_quote">\
		<pre>'+quote+'</pre>\
		<p class="blockquote_font text_right m_b_0">出典:<cite><a href="'+url+'" target="_blank">'+title+'</a></cite></p>\
	<pre class="author_word">'+word+'</pre>\
	</div>\
</div>');
				// 自要素削除
				quote_add.remove();
			}
	},
}, '.quote_add_content_cancel');


/*******************************
アイテム Twitter追加フォーム生成
*******************************/
$('.item_add_content_list_twitter').on('click', function(event) {
	$('.matome').find('.matome_content').prepend('<div class="twitter_add">\
	<div class="twitter_add_content">\
		<div class="twitter_add_content_check_box clearfix">\
			<input type="text" placeholder="追加するTweetのURLを入力" value="" class="twitter_add_content_url">\
			<div class="twitter_add_content_check">チェック</div>\
		</div>\
		<textarea placeholder="Tweetの紹介コメントを入力" class="twitter_add_content_word"></textarea>\
		<div class="twitter_add_content_button clearfix">\
			<div class="twitter_add_content_button_left">\
				<div class="twitter_add_content_submit">保存</div>\
			</div>\
			<div class="twitter_add_content_button_right">\
				<div class="twitter_add_content_cancel">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- twitter_add_content -->\
</div>	<!-- twitter_add -->');
});


/*********************
ajax_tweet_html_create
*********************/
function ajax_tweet_html_create(twitter_add) {
		// チェックボックス変数生成
		var check_box = twitter_add.find('.twitter_add_content_check_box');
		// TweetURL取得
		var Tweet_url = twitter_add.find('input').val();

		var re = /https|http/;
		var test = Tweet_url.match(re);

		// 正しいURLか検査
		if(test) {
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/twitterhtmlcreate/',
				data: {
					tweet_url: Tweet_url,
				},
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					// チェック判別
					if(data['check'] == true) {
						// Tweet一時表示
						check_box.next().before(data['tweet_html']);
						// Tweet追加フォーム削除(上部のみ)
						check_box.remove();
						// チェック属性追加
						twitter_add.find('.twitter_add_content_submit').attr( {
							'data-check': 'true'
						});
					}
						// ログ
						else {
							alert('既にTweetが削除されている、またはURLが間違っています');
						}
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			});
		}
			// ログ
			else {
				alert('正しいURLを入力してください');
			}
}
/*******************
Twitter追加 チェック
*******************/
$('.matome').on( {
	'click': function(event) {
		var twitter_add = $(this).parents('.twitter_add');
		ajax_tweet_html_create(twitter_add);
	}
}, '.twitter_add_content_check');

/***************
Twitter追加 保存
***************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var twitter_add = $(this).parents('.twitter_add');
		var check       = twitter_add.find('.twitter_add_content_submit').attr('data-check');

		// チェック
		if(check) {
			// コンテンツ抽出
			var tweet_html  = twitter_add.find('.tweet').selfHtml();
			var word        = twitter_add.find('.twitter_add_content_word').val();
			// クラスネーム取得
			var class_name = $(this).parents('.twitter_add').next().attr('class');
			// Tweet追加
			$(this).parents('.twitter_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_twitter">\
		'+tweet_html+'\
		<pre class="author_word">'+word+'</pre>\
	</div>\
</div>');
			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.twitter_add').before(item_add_between_html);
			}
			// 自要素削除
			twitter_add.remove();
		}
			else {
				ajax_tweet_html_create(twitter_add);
			}
	}
}, '.twitter_add_content_submit');

/*****************
Twitter キャンセル
*****************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val = $(this).attr('data-val');
		// 元データがない場合
		if(data_val == null) {
			// 親を指定して取得
			var twitter_add = $(this).parents('.twitter_add');
			// 自要素削除
			twitter_add.remove();
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var twitter_add = $(this).parents('.twitter_add');
				// コンテンツ抽出
				var tweet_html  = twitter_add.find('.tweet').selfHtml();
				var word        = twitter_add.find('.twitter_add_content_word').val();
				// 追加
				$(this).parents('.twitter_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_twitter">\
		'+tweet_html+'\
		<pre class="author_word">'+word+'</pre>\
	</div>\
</div>'); 
				// 自要素削除
				twitter_add.remove();
			}
	},
}, '.twitter_add_content_cancel');
/****************************
アイテム 動画追加フォーム生成
****************************/
$('.item_add_content_list_video').on('click', function(event) {
	$('.matome').find('.matome_content').prepend('<div class="video_add">\
	<div class="video_add_content">\
		<div class="video_add_content_video_icon">\
			<span class="typcn typcn-video-outline"></span>\
		</div>\
		<div class="video_add_content_check_box clearfix">\
			<input type="text" class="video_add_content_code" value="" placeholder="追加する動画の埋め込みコードを入力">\
			<div class="video_add_content_check">チェック</div>\
		</div>\
		<textarea class="video_add_content_word" placeholder="動画の紹介コメントを入力"></textarea>\
		<div class="video_add_content_button clearfix">\
			<div class="video_add_content_button_left">\
				<div class="video_add_content_submit">保存</div>\
			</div>\
			<div class="video_add_content_button_right">\
				<div class="video_add_content_cancel">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- video_add_content -->\
</div> <!-- video_add -->');
});
//------------------
//ビデオHTML作成関数
//------------------
function video_html_create(video_add) {
		var val	= video_add.find('.video_add_content_code').val();
		var pattern     = /<iframe .+?src="(.+?)".+?<\/iframe>/;
		var video_array = val.match(pattern);
		// 埋め込みコードが正しい場合
		if(video_array) {
			video_add.find('.video_add_content_video_icon').after('<figure class="video">\
	'+video_array[0]+'\
</figure>');
			// チェック紐付け
			video_add.find('.video_add_content_submit').attr( {
				'data-check':video_array[1]
			});
			// 削除
			video_add.find('.video_add_content_video_icon').remove();
			video_add.find('.video_add_content_check_box').remove();
		}
			// 埋め込みコードが正しくない場合
			else {
				alert('埋め込みコードが正しくありません');
			}
}
/****************
動画追加 チェック
****************/
$('.matome').on( {
	'click': function(event) {
		var video_add = $(this).parents('.video_add');
		video_html_create(video_add);
	}
}, '.video_add_content_check');
/************
動画追加 保存
************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var video_add = $(this).parents('.video_add');
		var check       = video_add.find('.video_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// コンテンツ抽出
			var video_html  = video_add.find('.video').selfHtml();
			var word        = video_add.find('.video_add_content_word').val();
			// クラスネーム取得
			var class_name = $(this).parents('.video_add').next().attr('class');
			// 動画追加
			$(this).parents('.video_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_video">\
		'+video_html+'\
		<pre class="author_word">'+word+'</pre>\
	</div>\
</div>');
			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.video_add').before(item_add_between_html);
			}
			// 自要素削除
			video_add.remove();
		}
			else {
				video_html_create(video_add);
			}
	}
}, '.video_add_content_submit');
/******************
動画追加 キャンセル
******************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val = $(this).attr('data-val');
		// 親を指定して取得
		var video_add = $(this).parents('.video_add');
		// 元データがない場合
		if(data_val == null) {
			// 自要素削除
			video_add.remove();
		}
			// 元データがある場合
			else {
				// コンテンツ抽出
				var video_html  = video_add.find('.video').selfHtml();
				var word        = video_add.find('.video_add_content_word').val();
				// 動画追加
				$(this).parents('.video_add').before('<div class="matome_content_block">\
		<div class="matome_content_block_video">\
			'+video_html+'\
			<pre class="author_word">'+word+'</pre>\
		</div>\
	</div>'); 
				// 自要素削除
				video_add.remove();
			}
	},
}, '.video_add_content_cancel');
/****************************
アイテム 画像追加フォーム生成
****************************/
$('.item_add_content_list_image').on('click', function(event) {
	$('.matome').find('.matome_content').prepend('<div class="image_add clearfix">\
	<div class="image_add_content">\
		<div class="image_add_content_left">\
			<span class="typcn typcn-image-outline"></span>\
		</div>\
		<div class="image_add_content_right clearfix">\
			<div class="upload_button">\
				<input class="image_add_content_file" type="file" name="file[]">\
			</div>\
		</div>\
		<div class="image_add_content_button clearfix">\
			<div class="image_add_content_button_left">\
				<div class="image_add_content_submit">保存</div>\
			</div>\
			<div class="image_add_content_button_right">\
				<div class="image_add_content_cancel">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- image_add_content -->\
</div> <!-- image_add -->');
});
/************************
アイテム 画像アップロード
************************/
$('.matome').on( {
	'change' : function() {
		 var image_add = $(this).parents('.image_add');
		// 画像データを挿入するarray
		var image_array = [];
		// 送信する画像ファイルス
		var files        = $(this).prop('files');
		// 画像の枚数取得
		var files_length = files.length;
		// 選択した画像分AJAXする
		for(var i = 0; i < files_length; i++) {
			// 送信フォーマットインスタンス
			var formData = new FormData();
			// 送信する画像
			var file     = $(this).prop('files')[i];
			// 設定
			formData.append('file', file);
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/imagefileupload/',
				data: formData,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				// Ajax完了後の挙動
			  success: function(data) {
					// 画像データ挿入
					image_array.push(data["image_url"]);
					// タイトル・紹介コメントHTML挿入
					image_add.find('.upload_button').after('<input type="text" class="image_add_content_title" placeholder="画像のタイトルを入力" value="">\
<textarea class="image_add_content_word" placeholder="画像の紹介コメントを入力"></textarea>');
					// アップロードボタン削除
					image_add.find('.upload_button').remove();
					// 画像HTML表示
					image_add.find('.image_add_content_left').html('<div class="great_image_set_100">\
	<p class="m_0">\
		<a target="_blank" href="'+image_array[0]+'">\
			<img width="640" height="400" class="o_8" src="'+image_array[0]+'" alt="" title="">\
		</a>\
	</p>\
</div>');
				// チェック属性追加
				image_add.find('.image_add_content_submit').attr( {
					'data-check': 'true'
				});
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			}); // $.ajax( {
		} // for(var i = 0; i > files_length; i++) {
	}
}, '.image_add_content_file');
/************
画像追加 保存
************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var image_add = $(this).parents('.image_add');
		var check     = image_add.find('.image_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// コンテンツ抽出
			var image_html = image_add.find('.image_add_content_left').html();
			var image_url  = image_add.find('.great_image_set_100 p a').attr('href');
			var title      = image_add.find('.image_add_content_title').val();
			var word       = image_add.find('.image_add_content_word').val();
			// クラスネーム取得
			var class_name = $(this).parents('.image_add').next().attr('class');
			// 画像追加
			$(this).parents('.image_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_image">\
		<div class="article_content_left_right clearfix">\
			<div class="article_content_left">\
				<div class="great_image_set_100">\
					<p class="m_0">\
						<a target="_blank" href="'+image_url+'">\
							<img width="640" height="400" class="o_8" src="'+image_url+'" alt="'+title+'" title="'+title+'">\
						</a>\
					</p>\
				</div>\
			</div>\
			<div class="article_content_right">\
				<h3>'+title+'</h3>\
				<pre>'+word+'</pre>\
			</div>\
		</div>\
	</div>\
</div>');

			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.image_add').before(item_add_between_html);
			}
			// 自要素削除
			image_add.remove();
		}
			else {
//				image_html_create(image_add);
			}
	}
}, '.image_add_content_submit');
/******************
画像追加 キャンセル
******************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val = $(this).attr('data-val');
		// 親を指定して取得
		var image_add = $(this).parents('.image_add');
		// 元データがない場合
		if(data_val == null) {
			// 自要素削除
			image_add.remove();
		}
			// 元データがある場合
			else {
				// コンテンツ抽出
				var image_html = image_add.find('.image_add_content_left').html();
				var image_url  = image_add.find('.great_image_set_100 p a').attr('href');
				var title      = image_add.find('.image_add_content_title').val();
				var word       = image_add.find('.image_add_content_word').val();
				p(image_add);

				// 画像追加
				$(this).parents('.image_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_image">\
		<div class="article_content_left_right clearfix">\
			<div class="article_content_left">\
				<div class="great_image_set_100">\
					<p class="m_0">\
						<a target="_blank" href="'+image_url+'">\
							<img width="640" height="400" class="o_8" src="'+image_url+'" alt="'+title+'" title="'+title+'">\
						</a>\
					</p>\
				</div>\
			</div>\
			<div class="article_content_right">\
				<h3>'+title+'</h3>\
				<pre>'+word+'</pre>\
			</div>\
		</div>\
	</div>\
</div>'); 
				// 自要素削除
				image_add.remove();
			}
	},
}, '.image_add_content_cancel');
/******************************
アイテム リンク追加フォーム生成
******************************/
$('.item_add_content_list_link').on('click', function(event) {
	$('.matome').find('.matome_content').prepend('<div class="link_add">\
	<div class="link_add_content">\
		<div class="link_add_content_check_box clearfix">\
			<input type="text" class="link_add_content_url" value="" placeholder="追加するリンクのURLを入力">\
			<div class="link_add_content_check">チェック</div>\
		</div>\
		<div class="link_add_content_button clearfix">\
			<div class="link_add_content_button_left">\
				<div class="link_add_content_submit">保存</div>\
			</div>\
			<div class="link_add_content_button_right">\
				<div class="link_add_content_cancel">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- link_add_content -->\
</div> <!-- link_add -->');
});
/*****************
リンクHTML作成関数
*****************/
function link_html_create(link_add) {
		// url取得
		var link_url = link_add.find('.link_add_content_url').val();
		var re       = /https|http/;
		var test     = link_url.match(re);
		if(test) {
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/linkdataget/',
				data: {
					url: link_url,
				},
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					// 追加
					link_add.find('.link_add_content_check_box').before('<div class="matome_content_block_link" style="margin:0;">\
		<p class="matome_content_block_link_title">\
			<a href="'+data["url"]+'" target="_blank">'+data["title"]+'</a>\
		</p>\
		<p class="matome_content_block_link_url">\
			<a href="'+data["url"]+'" target="_blank">'+data["url"]+'</a>\
		</p>\
		<p class="matome_content_block_link_description">\
			'+data["description"]+'\
</p>\
	</div>');

					// word追加
					link_add.find('.link_add_content_check_box').after('<textarea class="link_add_content_word" placeholder="リンクの紹介コメントを入力"></textarea>');
					// box削除
					link_add.find('.link_add_content_check_box').remove();
					// check追加
					link_add.find('.link_add_content_submit').attr( {
						'data-check' : 'true'
					});
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			});
		} // if(test) {
			else {
				alert('URLが正しくありません');
			}
}
/***********************
アイテム リンク チェック
***********************/
$('.matome').on( {
	'click' : function(event) {
		var link_add = $(this).parents('.link_add');
		link_html_create(link_add);
	}
}, '.link_add_content_check');
/**********
リンク 保存
**********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var link_add  = $(this).parents('.link_add');
		var check     = link_add.find('.link_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// コンテンツ抽出
			var image_url         = link_add.find('.matome_content_block_link_title a').attr('href');
			var image_title       = link_add.find('.matome_content_block_link_title a').html();
			var image_description = link_add.find('.matome_content_block_link_description').html();
			var word              = link_add.find('.link_add_content_word').val();
			// ワード追加
			link_add.find('.matome_content_block_link_description').after('<pre class="matome_content_block_link_word">'+word+'</pre>');
			// クラスネーム取得
			var class_name = $(this).parents('.link_add').next().attr('class');
			// 画像追加
			$(this).parents('.link_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_link">\
		<p class="matome_content_block_link_title">\
			<a href="'+image_url+'" target="_blank">'+image_title+'</a>\
		</p>\
		<p class="matome_content_block_link_url">\
			<a href="'+image_url+'" target="_blank">'+image_url+'</a>\
		</p>\
		<p class="matome_content_block_link_description">\
			'+image_description+'\
		</p>\
		<pre class="matome_content_block_link_word">'+word+'</pre>\
	</div>\
</div>');
			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.link_add').before(item_add_between_html);
			}
			// 自要素削除
			link_add.remove();
		}
			else {
				link_html_create(link_add);
			}
	}
}, '.link_add_content_submit');
/**********
リンク 削除
**********/
$('.matome').on( {
	'click' : function(event) {
		p('キャンセル');
		// 元データ取得
		var data_val = $(this).attr('data-val');

		// 親を指定して取得
		var link_add = $(this).parents('.link_add');
		p(data_val);
		p(link_add);

		// 元データがない場合
		if(data_val == null) {
			// 自要素削除
			link_add.remove();
		}
			// 元データがある場合
			else {
				// コンテンツ抽出
				var image_url         = link_add.find('.matome_content_block_link_title a').attr('href');
				var image_title       = link_add.find('.matome_content_block_link_title a').html();
				var image_description = link_add.find('.matome_content_block_link_description').html();
				var word              = link_add.find('.link_add_content_word').val();
				// 元に戻す
				$(this).parents('.link_add').before('<div class="matome_content_block">\
	<div class="matome_content_block_link">\
		<p class="matome_content_block_link_title">\
			<a href="'+image_url+'" target="_blank">'+image_title+'</a>\
		</p>\
		<p class="matome_content_block_link_url">\
			<a href="'+image_url+'" target="_blank">'+image_url+'</a>\
		</p>\
		<p class="matome_content_block_link_description">\
			'+image_description+'\
		</p>\
		<pre class="matome_content_block_link_word">'+word+'</pre>\
	</div>\
</div>'); 
				// 自要素削除
				link_add.remove();
			}














}
}, '.link_add_content_cancel');


/*******************************************************
コンテンツ編集バー表示・非表示(matome_content_blockにて)
*******************************************************/
$('.matome').on({
'mouseenter': function() {
	// クラスネーム取得
	var class_name = $(this).children().attr('class');
	// 制御変数
	var top_off    = '';
	var up_off     = '';
	var down_off   = '';
	var bottom_off = '';
	// 総個数と何番目かの変数
	var length      = $('.matome_content_block').length;
	var this_number = $('.matome_content_block').index($(this)) + 1;
// 一個の場合
if(length == 1) {
	var top_off    = ' off';
	var up_off     = ' off';
	var down_off   = ' off';
	var bottom_off = ' off';
}
	// 二個以上ある場合
	else if(length > 1) {
		// 一番上の場合
		if(this_number == 1) {
			var top_off    = ' off';
			var up_off     = ' off';
			var down_off   = '';
			var bottom_off = '';
		}
		// 一番下の場合
		if((length - this_number) == 0) {
			var top_off    = '';
			var up_off     = '';
			var down_off   = ' off';
			var bottom_off = ' off';
		}
	}
		// ツールバー表示
	$(this).append('<ul class="toolbar">\
		<li class="top'+top_off+'"><span class="typcn typcn-media-fast-forward"></span></li>\
		<li class="up'+up_off+'"><span class="typcn typcn-media-play"></span></li>\
		<li class="down'+down_off+'"><span class="typcn typcn-media-play"></span></li>\
		<li class="bottom'+bottom_off+'"><span class="typcn typcn-media-fast-forward"></span></li>\
	</ul>\
	<ul class="editbar">\
		<li class="edit" data-class-name="'+class_name+'"><span class="typcn typcn-pencil">修正</span></li>\
		<li class="delete"><span class="typcn typcn-trash">削除</span></li>\
	</ul>');
},
	// ツールバー非表示
  'mouseleave': function() {
		// ツールバー削除
		$(this).find('.toolbar').remove();
		$(this).find('.editbar').remove();
  }
}, '.matome_content_block');
/**************
ツールバー 修正
**************/
$('.matome').on( {
	'click': function() {
		var class_name = $(this).attr('data-class-name');
		switch(class_name) {
			/////////////////
			// テキストの場合
			/////////////////
			case 'matome_content_block_text':
			var val = $(this).parents('.matome_content_block').find('pre').html();
			$(this).parents('.matome_content_block').before('<div class="text_add">\
											<div class="text_add_content">\
												<textarea placeholder="テキストを入力">'+ val +'</textarea>\
												<div class="text_add_content_button clearfix">\
													<div class="text_add_content_button_left">\
														<div class="text_add_content_submit">保存</div>\
													</div>\
													<div class="text_add_content_button_right">\
													<div class="text_add_content_cancel" data-val="'+val+'">キャンセル</div>\
													</div>\
												</div>\
											</div> <!-- text_add_content -->\
										</div> <!-- text_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////
			// 見出しの場合
			///////////////
			case 'matome_content_block_title':
			var val = $(this).parents('.matome_content_block').find('.heading_5').html();
			$(this).parents('.matome_content_block').before('<div class="title_add">\
	<div class="title_add_content">\
		<textarea placeholder="テキストを入力">'+val+'</textarea>\
		<div class="title_add_content_button clearfix">\
			<div class="title_add_content_button_left">\
				<div class="title_add_content_submit">保存</div>\
			</div>\
			<div class="title_add_content_button_right">\
				<div class="title_add_content_cancel" data-val="'+val+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- title_add_content -->\
</div> <!-- title_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////
			// 引用の場合
			/////////////
			case 'matome_content_block_quote':
				// 引用抽出
				var quote = $(this).parents('.matome_content_block').find('.matome_content_block_quote').find('pre').html();
				var url   = $(this).parents('.matome_content_block').find('.matome_content_block_quote').find('a').attr('href');
				var title = $(this).parents('.matome_content_block').find('.matome_content_block_quote').find('a').html();
				var word  = $(this).parents('.matome_content_block').find('.matome_content_block_quote').find('.author_word').html();
				$(this).parents('.matome_content_block').before('<div class="quote_add">\
	<div class="quote_add_content">\
		<textarea class="quote_add_content_quote" placeholder="引用を入力">'+quote+'</textarea>\
		<input type="text" class="quote_add_content_url" value="'+url+'" placeholder="引用の出典元URLを入力(ウェブページの場合)">\
		<input type="text" class="quote_add_content_title" value="'+title+'" placeholder="引用の出典を入力">\
		<textarea class="quote_add_content_word" placeholder="引用の紹介コメントを入力">'+word+'</textarea>\
		<div class="quote_add_content_button clearfix">\
			<div class="quote_add_content_button_left">\
				<div class="quote_add_content_submit">保存</div>\
			</div>\
			<div class="quote_add_content_button_right">\
				<div class="quote_add_content_cancel" data-val="'+quote+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- quote_add_content -->\
</div> <!-- quote_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////
			// 見出しの場合 重複しています 修正する必要あり 2015.05.30 松岡
			///////////////
			case 'matome_content_block_title':
			var val = $(this).parents('.matome_content_block').find('.heading_5').html();
			$(this).parents('.matome_content_block').before('<div class="title_add">\
	<div class="title_add_content">\
		<textarea placeholder="テキストを入力">'+val+'</textarea>\
		<div class="title_add_content_button clearfix">\
			<div class="title_add_content_button_left">\
				<div class="title_add_content_submit">保存</div>\
			</div>\
			<div class="title_add_content_button_right">\
				<div class="title_add_content_cancel" data-val="'+val+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- title_add_content -->\
</div> <!-- title_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			////////////////
			// Twitterの場合
			////////////////
			case 'matome_content_block_twitter':
				// Tweet抽出
				var tweet_html = $(this).parents('.matome_content_block').find('.matome_content_block_twitter').find('.tweet').selfHtml();
				var word  = $(this).parents('.matome_content_block').find('.matome_content_block_twitter').find('.author_word').html();
				var check = true;
				$(this).parents('.matome_content_block').before('<div class="twitter_add">\
	<div class="twitter_add_content">\
			'+tweet_html+'\
		<textarea placeholder="Tweetの紹介コメントを入力" class="twitter_add_content_word">'+word+'</textarea>\
		<div class="twitter_add_content_button clearfix">\
			<div class="twitter_add_content_button_left">\
				<div class="twitter_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="twitter_add_content_button_right">\
				<div class="twitter_add_content_cancel" data-val="'+check+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- twitter_add_content -->\
</div>	<!-- twitter_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////
			// 動画の場合
			/////////////
			case  'matome_content_block_video':
				// video抽出
				var video_html = $(this).parents('.matome_content_block').find('.video').selfHtml();
				var word       = $(this).parents('.matome_content_block').find('.author_word').html();
				var check = true;
				$(this).parents('.matome_content_block').before('<div class="video_add">\
	<div class="video_add_content">\
			'+video_html+'\
		<textarea class="video_add_content_word" placeholder="動画の紹介コメントを入力">'+word+'</textarea>\
		<div class="video_add_content_button clearfix">\
			<div class="video_add_content_button_left">\
				<div class="video_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="video_add_content_button_right">\
				<div class="video_add_content_cancel" data-val="'+check+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- video_add_content -->\
</div> <!-- video_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////
			// 画像の場合
			/////////////
			case 'matome_content_block_image':
				// image抽出
				var image_url   = $(this).parents('.matome_content_block').find('.article_content_left p a').attr('href');
				var image_title = $(this).parents('.matome_content_block').find('.article_content_right h3').html();
				var image_word  = $(this).parents('.matome_content_block').find('.article_content_right pre').html();
				var check = true;
				$(this).parents('.matome_content_block').before('<div class="image_add clearfix">\
	<div class="image_add_content">\
		<div class="image_add_content_left">\
			<div class="great_image_set_100">\
				<p class="m_0">\
					<a href="'+image_url+'" target="_blank">\
						<img width="640" height="400" title="'+image_title+'" alt="'+image_title+'" src="'+image_url+'" class="o_8">\
					</a>\
				</p>\
			</div>\
		</div>\
		<div class="image_add_content_right clearfix">\
			<input type="text" value="'+image_title+'" placeholder="画像のタイトルを入力" class="image_add_content_title">\
			<textarea placeholder="画像の紹介コメントを入力" class="image_add_content_word">'+image_word+'</textarea>\
		</div>\
		<div class="image_add_content_button clearfix">\
			<div class="image_add_content_button_left">\
				<div class="image_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="image_add_content_button_right">\
				<div class="image_add_content_cancel" data-val="'+check+'">キャンセル</div>\
			</div>\
		</div>\
	</div>\
	<!-- image_add_content -->\
</div>');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////
			// リンクの場合
			///////////////
			case 'matome_content_block_link':
				// コンテンツ抽出
				var image_url   = $(this).parents('.matome_content_block').find('.matome_content_block_link_title a').attr('href');
				var image_title = $(this).parents('.matome_content_block').find('.matome_content_block_link_title a').html();
				var image_description = $(this).parents('.matome_content_block').find('.matome_content_block_link_description').html();
				var image_word = $(this).parents('.matome_content_block').find('.matome_content_block_link_word').html();
				var check = true;
				$(this).parents('.matome_content_block').before('<div class="link_add">\
	<div class="link_add_content">\
		<div class="matome_content_block_link" style="margin: 0;">\
			<p class="matome_content_block_link_title">\
				<a href="'+image_url+'" target="_blank">'+image_title+'</a>\
			</p>\
			<p class="matome_content_block_link_url">\
				<a href="'+image_url+'" target="_blank">'+image_url+'</a>\
			</p>\
			<p class="matome_content_block_link_description">\
				'+image_description+'\
			</p>\
		</div>\
		<textarea placeholder="リンクの紹介コメントを入力" class="link_add_content_word">'+image_word+'</textarea>\
		<div class="link_add_content_button clearfix">\
			<div class="link_add_content_button_left">\
				<div class="link_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="link_add_content_button_right">\
				<div class="link_add_content_cancel" data-val="'+check+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- link_add_content -->\
</div> <!-- link_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
		}
	},
}, '.edit');
/**************
ツールバー 削除
**************/
$('.matome').on( {
	'click': function() {
		var class_name = $(this).parents('.matome_content_block').next().attr('class');
		if(class_name == 'item_add_between') {
			// ヴィトウィーン削除
			$(this).parents('.matome_content_block').next().remove();
		}
		// 削除
		$(this).parents('.matome_content_block').remove();
	},
}, '.delete');
/**********************
ツールバー 移動(一つ下)
**********************/
$('.matome').on( {
	'click' : function() {
		if(!$(this).hasClass('off')) {
			var item_add_between = $(this).parents('.matome_content_block').next();
			$(this).parents('.matome_content_block').next().next().next().after($(this).parents('.matome_content_block'));
			$(this).parents('.matome_content_block').after(item_add_between);
			var toolbar = $(this).parents('.matome_content_block').find('.toolbar');
			var editbar = $(this).parents('.matome_content_block').find('.editbar');
			toolbar.remove();
			editbar.remove();
		}
	},
}, '.down');
/**********************
ツールバー 移動(一つ上)
**********************/
$('.matome').on( {
	'click' : function() {
		if(!$(this).hasClass('off')) {
			var item_add_between = $(this).parents('.matome_content_block').next();
			$(this).parents('.matome_content_block').prev().prev().before($(this).parents('.matome_content_block'));
			$(this).parents('.matome_content_block').after(item_add_between);
			var toolbar = $(this).parents('.matome_content_block').find('.toolbar');
			var editbar = $(this).parents('.matome_content_block').find('.editbar');
			toolbar.remove();
			editbar.remove();
		}
	},
}, '.up');
/**********************
ツールバー 移動(一番上)
**********************/
$('.matome').on( {
	'click' : function() {
		if(!$(this).hasClass('off')) {
			var item_add_between = $(this).parents('.matome_content_block').next();
			$(this).parents('.matome_content').prepend(item_add_between);
			$(this).parents('.matome_content').prepend($(this).parents('.matome_content_block'));
			var toolbar = $(this).parents('.matome_content_block').find('.toolbar');
			var editbar = $(this).parents('.matome_content_block').find('.editbar');
			toolbar.remove();
			editbar.remove();
		}
	},
}, '.top');
/**********************
ツールバー 移動(一番下)
**********************/
$('.matome').on( {
	'click' : function() {
		if(!$(this).hasClass('off')) {
			var item_add_between = $(this).parents('.matome_content_block').next();
			$(this).parents('.matome_content').append($(this).parents('.matome_content_block'));
			$(this).parents('.matome_content').append(item_add_between);
			var toolbar = $(this).parents('.matome_content_block').find('.toolbar');
			var editbar = $(this).parents('.matome_content_block').find('.editbar');
			toolbar.remove();
			editbar.remove();
		}
	},
}, '.bottom');
/*********************
アイテム追加ツール生成
**********************/
$('.matome').on( {
	'click' : function() {
		$(this).parents('.item_add_between').before('<!-- item_between_add -->\
								<div class="item_between_add">\
									<div class="item_between_add_content clearfix">\
										<span class="item_between_add_content_title"><span class="typcn typcn-plus"></span>アイテムを追加</span>\
										<span class="item_between_add_content_cancel"><span class="typcn typcn-times"></span></span>\
										<ul class="item_between_add_content_list">\
											<li class="item_between_add_content_list_link">リンク</li>\
											<li class="item_between_add_content_list_img">画像</li>\
											<li class="item_between_add_content_list_video">動画</li>\
											<li class="item_between_add_content_list_quote">引用</li>\
											<li class="item_between_add_content_list_twitter">Twitter</li>\
											<li class="item_between_add_content_list_text">テキスト</li>\
											<li class="item_between_add_content_list_title">見出し</li>\
										</ul>\
									</div> <!-- item_between_add_content -->\
								</div> <!-- item_between_add -->');
		$(this).parents('.item_add_between').remove();
	},
}, '.item_add_between_content');
/**********************
アイテム追加ツール 削除
**********************/
$('.matome').on( {
	'click' : function() {
		$(this).parents('.item_between_add').after(item_add_between_html);
		$(this).parents('.item_between_add').remove();
	}
}, '.item_between_add_content_cancel');

});