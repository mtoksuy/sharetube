//----------------
//読み込み後の処理
//----------------
$(function() {
/***************
動画フォームHTML
***************/
function video_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 動画フォームHTML
	var video_form_html = ('<div class="video_add">\
	<div class="video_add_content">\
		<div class="video_add_content_video_icon">\
			<span class="typcn typcn-video-outline"></span>\
		</div>\
		<div class="video_add_content_check_box clearfix">\
			<input type="text" class="video_add_content_code" value="" placeholder="追加する動画の埋め込みコードを入力">\
			<div class="video_add_content_check">チェック</div>\
		</div>\
		<textarea class="video_add_content_word" placeholder="動画の紹介コメントを入力"></textarea>\
		<div class="video_add_content_button clearfix">\
			<div class="video_add_content_button_left">\
				<div class="video_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="video_add_content_button_right">\
				<div class="video_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- video_add_content -->\
</div> <!-- video_add -->');
	return video_form_html;
}
/*******
動画HTML
*******/
function video_html_2(video_html, word) {
	// 動画HTML
	var video_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_video">\
		'+video_html+'\
		<pre class="author_word">'+word+'</pre>\
	</div>\
</div>');
	return video_html;
}
/****************************
アイテム 動画追加フォーム生成
****************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(video_form_html());
	}
}, '.item_add_content_list_video');
/*****************************************
アイテム ビトウィーン 動画追加フォーム生成 
*****************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(video_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_video');
//------------------
//ビデオHTML作成関数
//------------------
function video_html_create(video_add) {
		var val	= video_add.find('.video_add_content_code').val();
		var pattern     = /<iframe(.+?)src="(.+?)".+?<\/iframe>/;
		var video_array = val.match(pattern);
		// 埋め込みコードが正しい場合
		if(video_array) {
			video_add.find('.video_add_content_video_icon').after('<figure class="video">\
	'+video_array[0]+'\
</figure>');
			// チェック紐付け
			video_add.find('.video_add_content_submit').attr( {
				'data-check':video_array[1]
			});
			// 削除
			video_add.find('.video_add_content_video_icon').remove();
			video_add.find('.video_add_content_check_box').remove();
		}
			// 埋め込みコードが正しくない場合
			else {
				alert('埋め込みコードが正しくありません');
			}
}
/****************
動画追加 チェック
****************/
$('.matome').on( {
	'click': function(event) {
		var video_add = $(this).parents('.video_add');
		video_html_create(video_add);
	}
}, '.video_add_content_check');
/************
動画追加 保存
************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var video_add = $(this).parents('.video_add');
		var check       = video_add.find('.video_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// コンテンツ抽出
			var video_html  = video_add.find('.video').selfHtml();
			var word        = video_add.find('.video_add_content_word').val();
			// クラスネーム取得
			var class_name = $(this).parents('.video_add').next().attr('class');
			// ビトウィーン取得
			var data_between = $(this).attr('data-between');
			// ヴィトウィーンからの追加の場合
			if(data_between) {
				// ヴィトウィーン追加
				$(this).parents('.video_add').before(item_add_between_html);
			}
			// 動画追加
			$(this).parents('.video_add').before(video_html_2(video_html, word));
			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.video_add').before(item_add_between_html);
			}
			// 自要素削除
			video_add.remove();
		}
			else {
				video_html_create(video_add);
			}
	}
}, '.video_add_content_submit');
/******************
動画追加 キャンセル
******************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var video_add = $(this).parents('.video_add');
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
				video_add.remove();
			}
				else {
					// ビトウィーン追加
					video_add.before(item_add_between_html);
					// 自要素削除
					video_add.remove();
				}
		}
			// 元データがある場合
			else {
				// コンテンツ抽出
				var video_html  = video_add.find('.video').selfHtml();
				var word        = video_add.find('.video_add_content_word').val();
				// 動画追加
				$(this).parents('.video_add').before(video_html_2(video_html, word)); 
				// 自要素削除
				video_add.remove();
			}
	},
}, '.video_add_content_cancel');
});