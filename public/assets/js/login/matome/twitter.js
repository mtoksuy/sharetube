//----------------
//読み込み後の処理
//----------------
$(function() {
/******************
TwitterフォームHTML
******************/
function twitter_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// TwitterフォームHTML
	var twitter_form_html = ('<div class="twitter_add">\
	<div class="twitter_add_content">\
		<div class="twitter_add_content_check_box clearfix">\
			<textarea class="twitter_add_content_url" placeholder="追加するTweetのURLを入力"></textarea>\
			<div class="twitter_add_content_check">チェック</div>\
		</div>\
		<textarea placeholder="Tweetの紹介コメントを入力" class="twitter_add_content_word"></textarea>\
		<div class="twitter_add_content_button clearfix">\
			<div class="twitter_add_content_button_left">\
				<div class="twitter_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="twitter_add_content_button_right">\
				<div class="twitter_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- twitter_add_content -->\
</div>	<!-- twitter_add -->');
	return twitter_form_html;
}
/**********
TwitterHTML
**********/
function twitter_html(tweet_html, word, item_add_between_html) {
	// 見出しHTML
	var twitter_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_twitter">\
		'+tweet_html+'\
		<pre class="author_word">'+word+'</pre>\
	</div>\
</div>'+item_add_between_html+'');
	return twitter_html;
}
/*******************************
アイテム Twitter追加フォーム生成
*******************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(twitter_form_html());
	}
}, '.item_add_content_list_twitter');
/********************************************
アイテム ビトウィーン Twitter追加フォーム生成 
********************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(twitter_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_twitter');
/*********************
ajax_tweet_html_create
*********************/
function ajax_tweet_html_create(twitter_add) {
		// チェックボックス変数生成
		var check_box = twitter_add.find('.twitter_add_content_check_box');
		// TweetURL取得
		var Tweet_url = twitter_add.find('.twitter_add_content_url').val();

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
			// tweetの数を取得
			tweet_length = twitter_add.find('.tweet').length;
			// 単一の場合
			if(tweet_length == 1) {
				// コンテンツ抽出
				var tweet_html  = twitter_add.find('.tweet').selfHtml();
				var word        = twitter_add.find('.twitter_add_content_word').val();
				// クラスネーム取得
				var class_name = $(this).parents('.twitter_add').next().attr('class');
				// ビトウィーン取得
				var data_between = $(this).attr('data-between');
				// ヴィトウィーンからの追加の場合
				if(data_between) {
					// ヴィトウィーン追加(上)
					$(this).parents('.twitter_add').before(item_add_between_html);
				}
				// Tweet追加
				$(this).parents('.twitter_add').before(twitter_html(tweet_html, word , ''));
				if(class_name != 'item_add_between') {
					// ヴィトウィーン追加(下)
					$(this).parents('.twitter_add').before(item_add_between_html);
				}
				// 自要素削除
				twitter_add.remove();
			}
				// 複数の場合
				else {
					// ビトウィーン取得
					var data_between = $(this).attr('data-between');
					// ヴィトウィーンからの追加の場合
					if(data_between) {
						// ヴィトウィーン追加(上)
						$(this).parents('.twitter_add').before(item_add_between_html);
					}
					// 複数のtweetを追加
					twitter_add.find('.tweet').each( function() {
						// コンテンツ抽出
						var tweet_html = $(this).selfHtml();
						var word       = twitter_add.find('.twitter_add_content_word').val();
						// Tweet追加(betweenも追加)
						 twitter_add.before(twitter_html(tweet_html, word, item_add_between_html));
					});
					// 自要素削除
					twitter_add.remove();
				}
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
		// 親を指定して取得
		var twitter_add = $(this).parents('.twitter_add');
		// 元データ取得
		var data_val     = $(this).attr('data-val');
		var data_between = $(this).attr('data-between');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_val == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				twitter_add.remove();
			}
				else {
					// ビトウィーン追加
					twitter_add.before(item_add_between_html);
					// 自要素削除
					twitter_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var twitter_add = $(this).parents('.twitter_add');
				// コンテンツ抽出
				var tweet_html  = twitter_add.find('.tweet').selfHtml();
				var word        = twitter_add.find('.twitter_add_content_word').val();
				// 追加
				$(this).parents('.twitter_add').before(twitter_html(tweet_html, word, ''));
				// 自要素削除
				twitter_add.remove();
			}
	},
}, '.twitter_add_content_cancel');
});