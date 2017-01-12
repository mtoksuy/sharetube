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
		<textarea placeholder="タイムラインを入力"><connection>2017年</connection>\
\n\
<pointline>10月10日</pointline>\
\n\
<title>タイトル</title>\
\n\
<content>テキスト</content>\
\n\
\n\
<connection></connection>\
\n\
<pointline></pointline>\
\n\
<title></title>\
\n\
<content></content>\
\n\
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
function timeline_html(connection_array, pointline_array, title_array, content_array) {
	pointline_length = pointline_array.length;
	var li_html = '';

/*
p(connection_array);
p(pointline_array);
p(title_array);
p(content_array);
*/

	for(var i=0;i<pointline_length;i++) {
		connection_array[i]    = connection_array[i].replace(/<connection>/, '');
		connection_array[i]    = connection_array[i].replace(/<\/connection>/, '');

		pointline_array[i]    = pointline_array[i].replace(/<pointline>/, '');
		pointline_array[i]    = pointline_array[i].replace(/<\/pointline>/, '');

		title_array[i]      = title_array[i].replace(/<title>/, '');
		title_array[i]      = title_array[i].replace(/<\/title>/, '');

		content_array[i]      = content_array[i].replace(/<content>/, '');
		content_array[i]      = content_array[i].replace(/<\/content>/, '');

		// タイトルがない場合
		if(title_array[i] == '') {
			li_html_h3 = '<h3 style="border:0; margin: 0; padding: 0;"></h3>';
		}
			else {
				li_html_h3 = '<h3>'+title_array[i]+'</h3>';
			}
		// li_html生成
		li_html = li_html+
			'<li class="connection clearfix">\
					<span>'+connection_array[i]+'</span>\
				</li>\
				<li class="pointline clearfix">\
					<dl>\
						<dt>\
							<pre>'+pointline_array[i]+'</pre>\
						</dt>\
						<dd>\
							'+li_html_h3+'\
							<pre>'+content_array[i]+'</pre>\
						</dd>\
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
//		time_array    = timeline.match(/<time>[\s\S]*?<\/time>/g);
		connection_array = timeline.match(/<connection>[\s\S]*?<\/connection>/g);
		pointline_array  = timeline.match(/<pointline>[\s\S]*?<\/pointline>/g);
		title_array      = timeline.match(/<title>[\s\S]*?<\/title>/g);
		content_array    = timeline.match(/<content>[\s\S]*?<\/content>/g);
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
		$(this).parents('.timeline_add').before(timeline_html(connection_array, pointline_array, title_array, content_array));
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
		var data_val     = $(this).attr('data-val');
		var data_between = $(this).attr('data-between');

		// 親を指定して取得
		var timeline_add = $(this).parents('.timeline_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_val == null) {
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
				// タイムライン抽出(使わないかも)
				var timeline = timeline_add.find("textarea").val();
				// <、>をエンティティを戻す
				data_val = text_entity_return(data_val);

				// array抽出
				connection_array = data_val.match(/<connection>[\s\S]*?<\/connection>/g);
				pointline_array  = data_val.match(/<pointline>[\s\S]*?<\/pointline>/g);
				title_array      = data_val.match(/<title>[\s\S]*?<\/title>/g);
				content_array    = data_val.match(/<content>[\s\S]*?<\/content>/g);
				// タイムラインHTML生成
				timline_html     = timeline_html(connection_array, pointline_array, title_array, content_array);
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