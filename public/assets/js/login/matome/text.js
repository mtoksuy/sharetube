//----------------
//読み込み後の処理
//----------------
$(function() {
/*******************
テキストフォームHTML
********************/
function text_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 見出しフォームHTML
	var text_form_html = ('<div class="text_add">\
	<div class="text_add_content">\
		<textarea placeholder="テキストを入力"></textarea>\
		<div class="text_add_content_button clearfix">\
			<div class="text_add_content_button_left">\
				<div class="text_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="text_add_content_button_right">\
			<div class="text_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- text_add_content -->\
</div> <!-- text_add -->');
	return text_form_html;
}
/***********
テキストHTML
***********/
function text_html(text) {
	// 見出しHTML
	var text_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_text">\
		<pre>'+text+'</pre>\
	</div>\
</div>');
	return text_html;
}
/********************************
アイテム テキスト追加フォーム生成
********************************/
$('.item_add').on( {
	'click': function() {
		$('.matome').find('.matome_content').prepend(text_form_html());
	}
}, '.item_add_content_list_text');
/*********************************************
アイテム ビトウィーン テキスト追加フォーム生成 
*********************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(text_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_text');
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
		// ビトウィーン取得
		var data_between = $(this).attr('data-between');

		// ヴィトウィーンからの追加の場合
		if(data_between) {
			// ヴィトウィーン追加
			$(this).parents('.text_add').before(item_add_between_html);
		}
		// テキスト追加
		$(this).parents('.text_add').before(text_html(text));
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
		var data_val     = $(this).attr('data-val');
		var data_between = $(this).attr('data-between');
		// 親を指定して取得
		var text_add = $(this).parents('.text_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_val == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				text_add.remove();
			}
				else {
					// ビトウィーン追加
					text_add.before(item_add_between_html);
					// 自要素削除
					text_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var text_add = $(this).parents('.text_add');
				// <、>をエンティティを戻す
				var val = text_html(data_val).replace(/&lt;/g,"<");
				var val = val.replace(/&gt;/g,">");
				var val = val.replace(/&quot;/g,'"');
				var val = val.replace(/&#39;/g,"'");
				// テキスト追加
//				$(this).parents('.text_add').before(text_html(data_val));
					$(this).parents('.text_add').before(val);
				// 自要素削除
				text_add.remove();
			}
	},
}, '.text_add_content_cancel');
});