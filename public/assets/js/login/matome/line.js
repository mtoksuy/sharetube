//----------------
//読み込み後の処理
//----------------
$(function() {
	/***********
	罫線HTML作成
	***********/
	function line_html_create() {
		// 罫線HTML
		var line_html = ('<div class="matome_content_block">\
			<div class="matome_content_block_line">\
				<pre> </pre>\
			</div>\
		</div>');
		return line_html;
	}
	/****************************************
	アイテム 罫線追加生成(直でコンテンツ挿入)
	****************************************/
	$('.item_add').on( {
		'click':function() {
			// ヴィトウィーン追加
			$('.matome').find('.matome_content').prepend(item_add_between_html);
			// 罫線HTML追加
			$('.matome').find('.matome_content').prepend(line_html_create());
		}
	}, '.item_add_content_list_line');
	/********************************************
	アイテム 罫線追加ヴィトウィーンアドからの生成
	********************************************/
	$('.matome').on( {
		'click':function() {
			$(this).parents('.item_between_add').after(item_add_between_html);
			$(this).parents('.item_between_add').after(line_html_create());
			$(this).parents('.item_between_add').after(item_add_between_html);
			$(this).parents('.item_between_add').remove();
		}
	}, '.item_between_add_content_list_line');
});