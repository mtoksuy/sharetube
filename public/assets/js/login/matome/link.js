//----------------
//読み込み後の処理
//----------------
$(function() {
	/*****************
	リンクフォームHTML
	*****************/
	function link_form_html(between) {
		// ヴィトウィーン検査
		if(between == null) {
			var data_between = '';
		}
			else {
				var data_between = 'data-between="'+between+'"';
			}
		// 見出しフォームHTML
		var link_form_html = ('<div class="link_add">\
	<div class="link_add_content">\
		<div class="link_add_content_check_box clearfix">\
			<input type="text" class="link_add_content_url" value="" placeholder="追加するリンクのURLを入力">\
			<div class="link_add_content_check">チェック</div>\
		</div>\
		<div class="link_add_content_button clearfix">\
			<div class="link_add_content_button_left">\
				<div class="link_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="link_add_content_button_right">\
				<div class="link_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- link_add_content -->\
</div> <!-- link_add -->');
		return link_form_html;
	}
	/*********
	リンクHTML
	*********/
	function link_html(image_url, image_title, image_description, word) {
		var re                  = /sharetube/;
		var internal_link_check = image_url.match(re);
		if(internal_link_check) {
			var target_attr = '';
		}
			else {
				var target_attr = 'target="_blank"';
			}
		// リンクHTML
		var link_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_link">\
		<p class="matome_content_block_link_title">\
			<a href="'+image_url+'" '+target_attr+'>'+image_title+'</a>\
		</p>\
		<p class="matome_content_block_link_url">\
			<a href="'+image_url+'" '+target_attr+'>'+image_url+'</a>\
		</p>\
		<p class="matome_content_block_link_description">\
			'+image_description+'\
		</p>\
		<pre class="matome_content_block_link_word">'+word+'</pre>\
	</div>\
</div>');
		return link_html;
	}
/******************************
アイテム リンク追加フォーム生成
******************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(link_form_html());
	}
}, '.item_add_content_list_link');
/*******************************************
アイテム ビトウィーン リンク追加フォーム生成 
*******************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(link_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_link');
/*****************
リンクHTML作成関数
*****************/
function link_html_create(link_add) {
		// url取得
		var link_url = link_add.find('.link_add_content_url').val();
		var re       = /https|http/;
		var test     = link_url.match(re);
		if(test) {
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/linkdataget/',
				data: {
					url: link_url,
				},
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					var re                  = /sharetube/;
					var internal_link_check = data['url'].match(re);
					if(internal_link_check) {
						var target_attr = '';
					}
						else {
							var target_attr = 'target="_blank"';
						}
					// 追加
					link_add.find('.link_add_content_check_box').before('<div class="matome_content_block_link" style="margin:0;">\
		<p class="matome_content_block_link_title">\
			<a href="'+data["url"]+'" '+target_attr+'>'+data["title"]+'</a>\
		</p>\
		<p class="matome_content_block_link_url">\
			<a href="'+data["url"]+'" '+target_attr+'>'+data["url"]+'</a>\
		</p>\
		<p class="matome_content_block_link_description">\
			'+data["description"]+'\
</p>\
	</div>');

					// word追加
					link_add.find('.link_add_content_check_box').after('<textarea class="link_add_content_word" placeholder="リンクの紹介コメントを入力"></textarea>');
					// box削除
					link_add.find('.link_add_content_check_box').remove();
					// check追加
					link_add.find('.link_add_content_submit').attr( {
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
		var link_add = $(this).parents('.link_add');
		link_html_create(link_add);
	}
}, '.link_add_content_check');
/**********
リンク 保存
**********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var link_add  = $(this).parents('.link_add');
		var check     = link_add.find('.link_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// コンテンツ抽出
			var image_url         = link_add.find('.matome_content_block_link_title a').attr('href');
			var image_title       = link_add.find('.matome_content_block_link_title a').html();
			var image_description = link_add.find('.matome_content_block_link_description').html();
			var word              = link_add.find('.link_add_content_word').val();
			// ワード追加
			link_add.find('.matome_content_block_link_description').after('<pre class="matome_content_block_link_word">'+word+'</pre>');
			// クラスネーム取得
			var class_name = $(this).parents('.link_add').next().attr('class');
			// ビトウィーン取得
			var data_between = $(this).attr('data-between');
			// ヴィトウィーンからの追加の場合
			if(data_between) {
				// ヴィトウィーン追加
				$(this).parents('.link_add').before(item_add_between_html);
			}
			// 画像追加
			$(this).parents('.link_add').before(link_html(image_url, image_title, image_description, word));
			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.link_add').before(item_add_between_html);
			}
			// 自要素削除
			link_add.remove();
		}
			else {
				link_html_create(link_add);
			}
	}
}, '.link_add_content_submit');
/**********
リンク 削除
**********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var link_add = $(this).parents('.link_add');

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
				link_add.remove();
			}
				else {
					// ビトウィーン追加
					link_add.before(item_add_between_html);
					// 自要素削除
					link_add.remove();
				}
		}
			// 元データがある場合
			else {
				// コンテンツ抽出
				var image_url         = link_add.find('.matome_content_block_link_title a').attr('href');
				var image_title       = link_add.find('.matome_content_block_link_title a').html();
				var image_description = link_add.find('.matome_content_block_link_description').html();
				var word              = link_add.find('.link_add_content_word').val();
				// 元に戻す
				$(this).parents('.link_add').before(link_html(image_url, image_title, image_description, word));
				// 自要素削除
				link_add.remove();
			}
	}
}, '.link_add_content_cancel');
});