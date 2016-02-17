//----------------
//読み込み後の処理
//----------------
$(function() {
/*******************
吹き出しフォームHTML
********************/
function enclosed_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 吹き出しフォームHTML
	var enclosed_form_html = ('<div class="enclosed_add">\
	<div class="enclosed_add_content">\
		<textarea placeholder="囲みテキストを入力"></textarea>\
		<div class="enclosed_add_content_button clearfix">\
			<div class="enclosed_add_content_button_left">\
				<div class="enclosed_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="enclosed_add_content_button_right">\
			<div class="enclosed_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- enclosed_add_content -->\
</div> <!-- enclosed_add -->');
	return enclosed_form_html;
}
/***********
吹き出しHTML
***********/
function enclosed_html(enclosed) {
	// 見出しHTML
	var enclosed_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_enclosed">\
		<pre>'+enclosed+'</pre>\
	</div>\
</div>');
	return enclosed_html;
}
/********************************
アイテム 吹き出し追加フォーム生成
********************************/
$('.item_add').on( {
	'click': function() {
		$('.matome').find('.matome_content').prepend(enclosed_form_html());
	}
}, '.item_add_content_list_enclosed');
/*********************************************
アイテム ビトウィーン 吹き出し追加フォーム生成 
*********************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(enclosed_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_enclosed');
/****************
吹き出し追加 保存
****************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var enclosed_add = $(this).parents('.enclosed_add');
		// 吹き出し抽出
		var enclosed       = enclosed_add.find("textarea").val();
		// クラスネーム取得
		var class_name = $(this).parents('.enclosed_add').next().attr('class');
		// ビトウィーン取得
		var data_between = $(this).attr('data-between');

		// ヴィトウィーンからの追加の場合
		if(data_between) {
			// ヴィトウィーン追加
			$(this).parents('.enclosed_add').before(item_add_between_html);
		}
		// 吹き出し追加
		$(this).parents('.enclosed_add').before(enclosed_html(enclosed));
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.enclosed_add').before(item_add_between_html);
		}
		// 自要素削除
		enclosed_add.remove();
	}
}, '.enclosed_add_content_submit');
/**********************
吹き出し追加 キャンセル
**********************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val     = $(this).attr('data-val');
		var data_between = $(this).attr('data-between');
		// 親を指定して取得
		var enclosed_add = $(this).parents('.enclosed_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_val == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				enclosed_add.remove();
			}
				else {
					// ビトウィーン追加
					enclosed_add.before(item_add_between_html);
					// 自要素削除
					enclosed_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var enclosed_add = $(this).parents('.enclosed_add');
				// <、>をエンティティを戻す
				var val = enclosed_html(data_val).replace(/&lt;/g,"<");
				var val = val.replace(/&gt;/g,">");
				var val = val.replace(/&quot;/g,'"');
				var val = val.replace(/&#39;/g,"'");
				// 吹き出し追加
//				$(this).parents('.enclosed_add').before(enclosed_html(data_val));
					$(this).parents('.enclosed_add').before(val);
				// 自要素削除
				enclosed_add.remove();
			}
	},
}, '.enclosed_add_content_cancel');
});