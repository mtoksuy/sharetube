//----------------
//読み込み後の処理
//----------------
$(function() {
	/*********************
	iTunes_AppフォームHTML
	*********************/
	function itunes_app_form_html(between) {
		// ヴィトウィーン検査
		if(between == null) {
			var data_between = '';
		}
			else {
				var data_between = 'data-between="'+between+'"';
			}
		// 見出しフォームHTML
		var itunes_app_form_html = ('<div class="itunes_app_add">\
	<div class="itunes_app_add_content">\
		<div class="itunes_app_add_content_check_box clearfix">\
			<input type="text" class="itunes_app_add_content_url" value="" placeholder="追加するiTunesAppのURLを入力">\
			<div class="itunes_app_add_content_check">チェック</div>\
		</div>\
		<div class="itunes_app_add_content_check_box_description">\
		<label for="description_check_box">概要を表示する</label>\
			<input type="checkbox" name="description_check_box" class="itunes_app_add_content_check_box_description_input" value="1" checked="checked">\
		</div>\
		<div class="itunes_app_add_content_button clearfix">\
			<div class="itunes_app_add_content_button_left">\
				<div class="itunes_app_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="itunes_app_add_content_button_right">\
				<div class="itunes_app_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- itunes_app_add_content -->\
</div> <!-- itunes_app_add -->');
		return itunes_app_form_html;
	}
	/*********
	リンクHTML
	*********/
	function itunes_app_html_2(itunes_app_html) {
		// リンクHTML
		var itunes_app_html_2 = 
			'<div class="matome_content_block">\
				'+ itunes_app_html+'\
			</div>';
		return itunes_app_html_2;
	}
/******************************
アイテム リンク追加フォーム生成
******************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(itunes_app_form_html());
	}
}, '.item_add_content_list_itunes_app');
/*******************************************
アイテム ビトウィーン リンク追加フォーム生成 
*******************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(itunes_app_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_itunes_app');
/*****************
リンクHTML作成関数
*****************/
function itunes_app_html_create(itunes_app_add) {
		// url取得
		var itunes_app_url    = itunes_app_add.find('.itunes_app_add_content_url').val();
		var description_check = itunes_app_add.find('.itunes_app_add_content_check_box_description_input').val();

		var re       = /https|http/;
		var test     = itunes_app_url.match(re);
		if(test) {
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/itunesapphtmlcreate/',
				data: {
					itunes_app_url: itunes_app_url,
					description_check: description_check,
				},
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					// 追加
					itunes_app_add.find('.itunes_app_add_content_check_box').before(data['itunes_app_html']);
					// box削除
					itunes_app_add.find('.itunes_app_add_content_check_box').remove();
					// box削除
					itunes_app_add.find('.itunes_app_add_content_check_box_description').remove();
					// 紹介コメント入力textarea追加
					itunes_app_add.find('.itunes_app_add_content_button').before('<textarea class="itunes_app_add_content_word" placeholder="iTunes_Appの紹介コメントを入力"></textarea>');

					// check追加
					itunes_app_add.find('.itunes_app_add_content_submit').attr( {
						'data-check' : 'true'
					});
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			});
		} // if(test) {
			else {
				alert('URLが正しくありません');
			}
}
/***********************
アイテム リンク チェック
***********************/
$('.matome').on( {
	'click' : function(event) {
		var itunes_app_add = $(this).parents('.itunes_app_add');
		itunes_app_html_create(itunes_app_add);
	}
}, '.itunes_app_add_content_check');
/**********
リンク 保存
**********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var itunes_app_add  = $(this).parents('.itunes_app_add');
		var check           = itunes_app_add.find('.itunes_app_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// 紹介コメント事前挿入
			itunes_app_html_word = itunes_app_add.find('.itunes_app_add_content_word').val();
			itunes_app_add.find('.matome_content_block_itunes_app_data_screenshots').after(
				'<div class="matome_content_block_itunes_app_word">\
				<pre>'+itunes_app_html_word+'</pre>\
				</div>');
			// コンテンツ抽出
			itunes_app_html      = itunes_app_add.find('.matome_content_block_itunes_app').selfHtml();

			// クラスネーム取得
			var class_name = $(this).parents('.itunes_app_add').next().attr('class');
			// ビトウィーン取得
			var data_between = $(this).attr('data-between');
			// ヴィトウィーンからの追加の場合
			if(data_between) {
				// ヴィトウィーン追加
				$(this).parents('.itunes_app_add').before(item_add_between_html);
			}
			// 追加
			$(this).parents('.itunes_app_add').before(itunes_app_html_2(itunes_app_html));
			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.itunes_app_add').before(item_add_between_html);
			}
			// 自要素削除
			itunes_app_add.remove();
		}
			else {
				itunes_app_html_create(itunes_app_add);
			}
	}
}, '.itunes_app_add_content_submit');
/**********
リンク 削除
**********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var itunes_app_add = $(this).parents('.itunes_app_add');

		// 元データ取得
		var data_check   = $(this).attr('data-check');
		var data_between = $(this).attr('data-between');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_check == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				itunes_app_add.remove();
			}
				else {
					// ビトウィーン追加
					itunes_app_add.before(item_add_between_html);
					// 自要素削除
					itunes_app_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 紹介コメント事前挿入
				itunes_app_html_word = itunes_app_add.find('.itunes_app_add_content_word').val();
				itunes_app_add.find('.matome_content_block_itunes_app_data_screenshots').after(
					'<div class="matome_content_block_itunes_app_word">\
					<pre>'+itunes_app_html_word+'</pre>\
					</div>');
				// コンテンツ抽出
				itunes_app_html      = itunes_app_add.find('.matome_content_block_itunes_app').selfHtml();

				// 元に戻す
				$(this).parents('.itunes_app_add').before(itunes_app_html_2(itunes_app_html));
				// 自要素削除
				itunes_app_add.remove();
			}
	}
}, '.itunes_app_add_content_cancel');
});