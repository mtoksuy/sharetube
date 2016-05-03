//----------------
//読み込み後の処理
//----------------
$(function() {
/***************
引用フォームHTML
***************/
function quote_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 見出しフォームHTML
	var quote_form_html = ('<div class="quote_add">\
	<div class="quote_add_content">\
		<textarea class="quote_add_content_quote" placeholder="引用を入力"></textarea>\
		<input type="text" class="quote_add_content_url" value="" placeholder="引用の出典元URLを入力(ウェブページの場合)フォーカスを外すと自動でタイトルが入力されます">\
		<input type="text" class="quote_add_content_title" value="" placeholder="引用の出典を入力">\
		<textarea class="quote_add_content_word" placeholder="引用の紹介コメントを入力"></textarea>\
		<div class="quote_add_content_button clearfix">\
			<div class="quote_add_content_button_left">\
				<div class="quote_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="quote_add_content_button_right">\
				<div class="quote_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- quote_add_content -->\
</div> <!-- quote_add -->');
	return quote_form_html;
}
/******
引用HTML
*******/
function quote_html(quote, url, title, word) {
// urlなしでタイトルだけあった場合
if(url  == '' && title) {
		quote_link_title = '<p class="blockquote_font text_right m_b_0">出典:<cite>'+title+'</cite></p>';	
}
	else {
		quote_link_title = '<p class="blockquote_font text_right m_b_0">出典:<cite><a href="'+url+'" target="_blank">'+title+'</a></cite></p>';	
	}
	// 見出しHTML
	var quote_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_quote">\
		<pre>'+quote+'</pre>\
 		'+quote_link_title+'\
	<pre class="author_word">'+word+'</pre>\
	</div>\
</div>');
	return quote_html;
}

/****************************
アイテム 引用追加フォーム生成
****************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(quote_form_html());
	}
}, '.item_add_content_list_quote');
/*****************************************
アイテム ビトウィーン 引用追加フォーム生成 
******************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(quote_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_quote');
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
		// ビトウィーン取得
		var data_between = $(this).attr('data-between');
		// ヴィトウィーンからの追加の場合
		if(data_between) {
			// ヴィトウィーン追加
			$(this).parents('.quote_add').before(item_add_between_html);
		}
		// 引用追加
		$(this).parents('.quote_add').before(quote_html(quote, url, title, word));
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
		// 親を指定して取得
		var quote_add = $(this).parents('.quote_add');
		// 元データ取得
		var data_val = $(this).attr('data-val');
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
				quote_add.remove();
			}
				else {
					// ビトウィーン追加
					quote_add.before(item_add_between_html);
					// 自要素削除
					quote_add.remove();
				}
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
				$(this).parents('.quote_add').before(quote_html(quote, url, title, word));
				// 自要素削除
				quote_add.remove();
			}
	},
}, '.quote_add_content_cancel');
});