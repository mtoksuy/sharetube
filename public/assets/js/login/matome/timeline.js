//----------------
//読み込み後の処理
//----------------
$(function() {
/***********************
タイムラインフォームHTML
***********************/
function timeline_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 見出しフォームHTML
	var timeline_form_html = ('<div class="timeline_add">\
	<div class="timeline_add_content">\
		<textarea placeholder="タイムラインを入力"><time>年月日</time>\
\n\
<content></content>\
\n\
\n\
<time>年月日</time>\
\n\
<content></content>\
</textarea>\
		<div class="timeline_add_content_button clearfix">\
			<div class="timeline_add_content_button_left">\
				<div class="timeline_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="timeline_add_content_button_right">\
			<div class="timeline_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- timeline_add_content -->\
</div> <!-- timeline_add -->');
	return timeline_form_html;
}
/***************
タイムラインHTML
***************/
function timeline_html(time_array, content_array) {
	timeline_length = time_array.length;
	var li_html = '';
	for(var i=0;i<timeline_length;i++) {
		time_array[i]    = time_array[i].replace(/<time>/, '');
		time_array[i]    = time_array[i].replace(/<\/time>/, '');
		content_array[i] = content_array[i].replace(/<content>/, '');
		content_array[i] = content_array[i].replace(/<\/content>/, '');
		li_html = li_html+
		'<li class="clearfix">\
			<dl>\
				<dt><pre>'+time_array[i]+'</pre></dt>\
				<dd><pre>'+content_array[i]+'</pre></dd>\
			</dl>\
		</li>';
	}
	// タイムラインHTML
	var timeline_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_timeline">\
		<ol>\
			'+li_html+'\
		</ol>\
	</div>\
</div>');
	return timeline_html;
}
/************************************
アイテム タイムライン追加フォーム生成
************************************/
$('.item_add').on( {
	'click': function() {
		$('.matome').find('.matome_content').prepend(timeline_form_html());
	}
}, '.item_add_content_list_timeline');

/*************************************************
アイテム ビトウィーン タイムライン追加フォーム生成 
*************************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(timeline_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_timeline');
/********************
タイムライン追加 保存
********************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var timeline_add = $(this).parents('.timeline_add');
		// タイムライン抽出
		var timeline       = timeline_add.find("textarea").val();
		// array抽出
		time_array    = timeline.match(/<time>[\s\S]*?<\/time>/g);
		content_array = timeline.match(/<content>[\s\S]*?<\/content>/g);
		// クラスネーム取得
		var class_name = $(this).parents('.timeline_add').next().attr('class');
		// ビトウィーン取得
		var data_between = $(this).attr('data-between');

		// ヴィトウィーンからの追加の場合
		if(data_between) {
			// ヴィトウィーン追加
			$(this).parents('.timeline_add').before(item_add_between_html);
		}
		// タイムライン追加
		$(this).parents('.timeline_add').before(timeline_html(time_array, content_array));
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.timeline_add').before(item_add_between_html);
		}
		// 自要素削除
		timeline_add.remove();
	}
}, '.timeline_add_content_submit');
/**************************
タイムライン追加 キャンセル
**************************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_check   = $(this).attr('data-check');
		var data_between = $(this).attr('data-between');
		// 親を指定して取得
		var timeline_add = $(this).parents('.timeline_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_check == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				timeline_add.remove();
			}
				else {
					// ビトウィーン追加
					timeline_add.before(item_add_between_html);
					// 自要素削除
					timeline_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var timeline_add = $(this).parents('.timeline_add');
				// タイムライン抽出
				var timeline = timeline_add.find("textarea").val();
				// array抽出
				time_array    = timeline.match(/<time>[\s\S]*?<\/time>/g);
				content_array = timeline.match(/<content>[\s\S]*?<\/content>/g);
				timline_html  = timeline_html(time_array, content_array);
				// <、>をエンティティを戻す
				timline_html = text_entity_return(timline_html);
				// タイムライン追加
					$(this).parents('.timeline_add').before(timline_html);
				// 自要素削除
				timeline_add.remove();
			}
	},
}, '.timeline_add_content_cancel');
});