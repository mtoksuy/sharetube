//----------------
//読み込み後の処理
//----------------
$(function() {
/*******************
コードフォームHTML
********************/
function code_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 見出しフォームHTML
	var code_form_html = ('<div class="code_add">\
	<div class="code_add_content">\
		<textarea placeholder="コードを入力"></textarea>\
		<div class="code_add_content_button clearfix">\
			<div class="code_add_content_button_left">\
				<div class="code_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="code_add_content_button_right">\
			<div class="code_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- code_add_content -->\
</div> <!-- code_add -->');
	return code_form_html;
}
/***********
コードHTML
***********/
function code_html(code) {
	// 見出しHTML
	var code_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_code">\
		<pre><code>'+code+'</code></pre>\
	</div>\
</div>');
	return code_html;
}
/********************************
アイテム コード追加フォーム生成
********************************/
$('.item_add').on( {
	'click': function() {
		$('.matome').find('.matome_content').prepend(code_form_html());
	}
}, '.item_add_content_list_code');
/*********************************************
アイテム ビトウィーン コード追加フォーム生成 
*********************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(code_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_code');
/****************
コード追加 保存
****************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var code_add = $(this).parents('.code_add');
		// コード抽出
		var code       = code_add.find("textarea").val();
		// エンティティー化
		code = text_entity_conversion(code);

		// クラスネーム取得
		var class_name = $(this).parents('.code_add').next().attr('class');
		// ビトウィーン取得
		var data_between = $(this).attr('data-between');

		// ヴィトウィーンからの追加の場合
		if(data_between) {
			// ヴィトウィーン追加
			$(this).parents('.code_add').before(item_add_between_html);
		}
		// コード追加
		$(this).parents('.code_add').before(code_html(code));
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.code_add').before(item_add_between_html);
		}
		// 自要素削除
		code_add.remove();
	}
}, '.code_add_content_submit');
/**********************
コード追加 キャンセル
**********************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val     = $(this).attr('data-val');
		var data_between = $(this).attr('data-between');
		// 親を指定して取得
		var code_add = $(this).parents('.code_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_val == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				code_add.remove();
			}
				else {
					// ビトウィーン追加
					code_add.before(item_add_between_html);
					// 自要素削除
					code_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var code_add = $(this).parents('.code_add');
				// エンティティーにする
				val = text_entity_conversion(data_val);
				// コード追加
				$(this).parents('.code_add').before(code_html(val));
//					$(this).parents('.code_add').before(val);
				// 自要素削除
				code_add.remove();
			}
	},
}, '.code_add_content_cancel');
});