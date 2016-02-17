//----------------
//読み込み後の処理
//----------------
$(function() {
/*******************
吹き出しフォームHTML
********************/
function ballon_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 吹き出しフォームHTML
	var ballon_form_html = ('<div class="ballon_add">\
	<div class="ballon_add_content">\
		<textarea placeholder="吹き出しテキストを入力"></textarea>\
		<div class="ballon_add_content_button clearfix">\
			<div class="ballon_add_content_button_left">\
				<div class="ballon_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="ballon_add_content_button_right">\
			<div class="ballon_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- ballon_add_content -->\
</div> <!-- ballon_add -->');
	return ballon_form_html;
}
/***********
吹き出しHTML
***********/
function ballon_html(ballon) {
	// 見出しHTML
	var ballon_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_ballon">\
		<pre>'+ballon+'</pre>\
	</div>\
</div>');
	return ballon_html;
}
/********************************
アイテム 吹き出し追加フォーム生成
********************************/
$('.item_add').on( {
	'click': function() {
		$('.matome').find('.matome_content').prepend(ballon_form_html());
	}
}, '.item_add_content_list_ballon');
/*********************************************
アイテム ビトウィーン 吹き出し追加フォーム生成 
*********************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(ballon_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_ballon');
/****************
吹き出し追加 保存
****************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var ballon_add = $(this).parents('.ballon_add');
		// 吹き出し抽出
		var ballon       = ballon_add.find("textarea").val();
		// クラスネーム取得
		var class_name = $(this).parents('.ballon_add').next().attr('class');
		// ビトウィーン取得
		var data_between = $(this).attr('data-between');

		// ヴィトウィーンからの追加の場合
		if(data_between) {
			// ヴィトウィーン追加
			$(this).parents('.ballon_add').before(item_add_between_html);
		}
		// 吹き出し追加
		$(this).parents('.ballon_add').before(ballon_html(ballon));
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.ballon_add').before(item_add_between_html);
		}
		// 自要素削除
		ballon_add.remove();
	}
}, '.ballon_add_content_submit');
/**********************
吹き出し追加 キャンセル
**********************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val     = $(this).attr('data-val');
		var data_between = $(this).attr('data-between');
		// 親を指定して取得
		var ballon_add = $(this).parents('.ballon_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_val == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				ballon_add.remove();
			}
				else {
					// ビトウィーン追加
					ballon_add.before(item_add_between_html);
					// 自要素削除
					ballon_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var ballon_add = $(this).parents('.ballon_add');
				// <、>をエンティティを戻す
				var val = ballon_html(data_val).replace(/&lt;/g,"<");
				var val = val.replace(/&gt;/g,">");
				var val = val.replace(/&quot;/g,'"');
				var val = val.replace(/&#39;/g,"'");
				// 吹き出し追加
//				$(this).parents('.ballon_add').before(ballon_html(data_val));
					$(this).parents('.ballon_add').before(val);
				// 自要素削除
				ballon_add.remove();
			}
	},
}, '.ballon_add_content_cancel');
});