//----------------
//読み込み後の処理
//----------------
$(function() {
/*****************
見出しフォームHTML
*****************/
function title_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 見出しフォームHTML
	var title_form_html = ('<div class="title_add">\
		<div class="title_add_content">\
			<textarea placeholder="テキストを入力"></textarea>\
			<div class="title_add_content_button clearfix">\
				<div class="title_add_content_button_left">\
					<div class="title_add_content_submit" '+data_between+'>保存</div>\
				</div>\
				<div class="title_add_content_button_right">\
					<div class="title_add_content_cancel" '+data_between+'>キャンセル</div>\
				</div>\
			</div>\
		</div> <!-- title_add_content -->\
	</div> <!-- title_add -->');
	return title_form_html;
}
/*********
見出しHTML
**********/
function title_html(title) {
	// 見出しHTML
	var title_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_title">\
		<h2 class="h2_heading_1">'+title+'</h2>\
	</div>\
</div>');
	return title_html;
}
/******************************
アイテム 見出し追加フォーム生成 
******************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(title_form_html());
	}
}, '.item_add_content_list_title');
/*******************************************
アイテム ビトウィーン 見出し追加フォーム生成 
*******************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(title_form_html(between));
		// 削除
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
		// ビトウィーン取得
		var data_between = $(this).attr('data-between');

		// ヴィトウィーンからの追加の場合
		if(data_between) {
			// ヴィトウィーン追加
			$(this).parents('.title_add').before(item_add_between_html);
		}
		// 見出し追加
		$(this).parents('.title_add').before(title_html(title));
		// ヴィトウィーンがなかった場合
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
		var data_val     = $(this).attr('data-val');
		var data_between = $(this).attr('data-between');
		// 親を指定して取得
		var title_add = $(this).parents('.title_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_val == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				title_add.remove();
			}
				else {
					// ビトウィーン追加
					title_add.before(item_add_between_html);
					// 自要素削除
					title_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var title_add = $(this).parents('.title_add');
				// 見出し追加
				$(this).parents('.title_add').before(title_html(data_val));
				// 自要素削除
				title_add.remove();
			}
	},
}, '.title_add_content_cancel');
});