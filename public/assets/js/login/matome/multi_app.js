//----------------
//読み込み後の処理
//----------------
$(function() {
	/********************
	multi_appフォームHTML
	********************/
	function multi_app_form_html(between) {
		// ヴィトウィーン検査
		if(between == null) {
			var data_between = '';
		}
			else {
				var data_between = 'data-between="'+between+'"';
			}
		// 見出しフォームHTML
		var multi_app_form_html = ('<div class="multi_app_add">\
	<div class="multi_app_add_content">\
		<div class="multi_app_add_content_check_box clearfix">\
			<span class="red">*</span><input type="text" class="multi_app_add_content_url" value="" placeholder="追加するiTunesAppのURLを入力">\
			<input type="text" class="multi_app_add_content_url googlepalay_app_url" value="" placeholder="追加するGooglePlayAppのURLを入力">\
		</div>\
		<div class="multi_app_add_content_button clearfix">\
			<div class="multi_app_add_content_button_left">\
				<div class="multi_app_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="multi_app_add_content_button_right">\
				<div class="multi_app_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- multi_app_add_content -->\
</div> <!-- multi_app_add -->');
		return multi_app_form_html;
	}
	/*********
	リンクHTML
	*********/
	function multi_app_html_2(multi_app_html) {
		// リンクHTML
		var multi_app_html_2 = 
			'<div class="matome_content_block">\
				'+ multi_app_html+'\
			</div>';
		return multi_app_html_2;
	}
/******************************
アイテム リンク追加フォーム生成
******************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(multi_app_form_html());
	}
}, '.item_add_content_list_multi_app');
/*******************************************
アイテム ビトウィーン リンク追加フォーム生成 
*******************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(multi_app_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_multi_app');
/*****************
リンクHTML作成関数
*****************/
function multi_app_html_create(multi_app_add) {
		// url取得
		var multi_app_url       = multi_app_add.find('.multi_app_add_content_url').val();
		var googlepalay_app_url = multi_app_add.find('.googlepalay_app_url').val();
		var multi_app_check     = true;
		var description_check   = 0;

		var re       = /https|http/;
		var test     = multi_app_url.match(re);
		if(test) {
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/itunesapphtmlcreate/',
				data: {
					itunes_app_url      : multi_app_url,
					googlepalay_app_url : googlepalay_app_url,
					multi_app_check     : multi_app_check,
					description_check   : description_check,
				},
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					// 追加
					multi_app_add.find('.multi_app_add_content_check_box').before(data['multi_app_html']);
					// box削除
					multi_app_add.find('.multi_app_add_content_check_box').remove();
					// box削除
//					multi_app_add.find('.multi_app_add_content_check_box_description').remove();
					// 紹介コメント入力textarea追加
					multi_app_add.find('.multi_app_add_content_button').before('<textarea class="multi_app_add_content_word" placeholder="multi_appの紹介コメントを入力"></textarea>');
					// check追加
					multi_app_add.find('.multi_app_add_content_submit').attr( {
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
		var multi_app_add = $(this).parents('.multi_app_add');
		multi_app_html_create(multi_app_add);
	}
}, '.multi_app_add_content_check');
/**********
リンク 保存
**********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var multi_app_add   = $(this).parents('.multi_app_add');
		var check           = multi_app_add.find('.multi_app_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// 紹介コメント事前挿入
			multi_app_html_word = multi_app_add.find('.multi_app_add_content_word').val();
			multi_app_add.find('.matome_content_block_multi_app_content').after(
				'<div class="matome_content_block_multi_app_word">\
				<pre>'+multi_app_html_word+'</pre>\
				</div>');
			// コンテンツ抽出
			multi_app_html      = multi_app_add.find('.matome_content_block_multi_app').selfHtml();

//p(multi_app_html);

			// クラスネーム取得
			var class_name = $(this).parents('.multi_app_add').next().attr('class');
			// ビトウィーン取得
			var data_between = $(this).attr('data-between');
			// ヴィトウィーンからの追加の場合
			if(data_between) {
				// ヴィトウィーン追加
				$(this).parents('.multi_app_add').before(item_add_between_html);
			}
			// 追加
			$(this).parents('.multi_app_add').before(multi_app_html_2(multi_app_html));
			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.multi_app_add').before(item_add_between_html);
			}
			// 自要素削除
			multi_app_add.remove();
		}
			else {
				multi_app_html_create(multi_app_add);
			}
	}
}, '.multi_app_add_content_submit');
/**********
リンク 削除
**********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var multi_app_add = $(this).parents('.multi_app_add');

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
				multi_app_add.remove();
			}
				else {
					// ビトウィーン追加
					multi_app_add.before(item_add_between_html);
					// 自要素削除
					multi_app_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 紹介コメント事前挿入
				multi_app_html_word = multi_app_add.find('.multi_app_add_content_cancel').attr('data-word');
				multi_app_add.find('.matome_content_block_multi_app_content').after(
					'<div class="matome_content_block_multi_app_word">\
					<pre>'+multi_app_html_word+'</pre>\
					</div>');
				// コンテンツ抽出
				multi_app_html      = multi_app_add.find('.matome_content_block_multi_app').selfHtml();

				// 元に戻す
				$(this).parents('.multi_app_add').before(multi_app_html_2(multi_app_html));
				// 自要素削除
				multi_app_add.remove();
			}
	}
}, '.multi_app_add_content_cancel');
});