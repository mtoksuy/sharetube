//----------------
//読み込み後の処理
//----------------
$(function() {
/*****************
AmazonフォームHTML
******************/
function amazon_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 見出しフォームHTML
	var amazon_form_html = ('<div class="amazon_add">\
			<div class="amazon_add_content">\
				<input type="text" placeholder="商品タイトルを入力" value="" class="amazon_add_content_title">\
				<textarea placeholder="テキスト商品リンクHTMLを入力" class="amazon_add_content_textlink"></textarea>\
				<textarea placeholder="画像商品リンクHTMLを入力" class="amazon_add_content_imagelink"></textarea>\
				<div class="amazon_add_content_button clearfix">\
					<div class="amazon_add_content_button_left">\
						<div class="amazon_add_content_submit" '+data_between+'>保存</div>\
					</div>\
					<div class="amazon_add_content_button_right">\
						<div class="amazon_add_content_cancel" '+data_between+'>キャンセル</div>\
					</div>\
				</div>\
			</div> <!-- amazon_add_content -->\
		</div>');
	return amazon_form_html;
}
/***********
アマゾンHTML
***********/
function amazon_html(data, amazon_title, amazon_textlink, amazon_imagelink, amazon_link_detail_html) {
//p(data, amazon_title, amazon_textlink, amazon_imagelink, amazon_link_detail_html);
	// アマゾンHTML
	var amazon_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_amazon">\
		<div class="amazon_link clearfix">\
			<div class="amazon_link_image o_8">\
				'+ amazon_imagelink +'\
			</div>\
			<div class="amazon_link_right">\
				<div class="amazon_link_text">\
					<h3>'+ amazon_textlink +'</h3>\
				</div>\
				'+data['amazon_html']+'\
				'+amazon_link_detail_html+'\
			</div>\
		</div>\
	</div>\
</div>');
	return amazon_html;
}
/********************************
アイテム アマゾン追加フォーム生成
********************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(amazon_form_html());
	}
}, '.item_add_content_list_amazon');
/*********************************************
アイテム ビトウィーン アマゾン追加フォーム生成 
*********************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(amazon_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_amazon');

/**********************
ajax_amazon_html_create
**********************/
function ajax_amazon_html_create(amazon_add,amazon_url,amazon_title, amazon_textlink, amazon_imagelink, amazon_link_detail_html) {
	var re = /https|http/;
	var test = amazon_url.match(re);
	// 正しいURLか検査
	if(test) {
		// Ajaxを走らせる
		$.ajax( {
			type: 'POST', 
			url: http+'ajax/matome/amazonhtmlcreate/',
			data: {
				amazon_url: amazon_url,
			},
			dataType: 'json',
			cache: false,
			// Ajax完了後の挙動
		  success: function(data) {
				// チェック判別
				if(data['check'] == true) {
					var ajax_amazon_html = data['amazon_html'];
					// クラスネーム取得
					var class_name = amazon_add.next().attr('class');
					// ビトウィーン取得
					var data_between = amazon_add.find('.amazon_add_content_submit').attr('data-between');

					// ヴィトウィーンからの追加の場合
					if(data_between) {
						// ヴィトウィーン追加
						amazon_add.before(item_add_between_html);
					}
					// Amazon追加
					amazon_add.before(amazon_html(data, amazon_title, amazon_textlink, amazon_imagelink, amazon_link_detail_html));

					if(class_name != 'item_add_between') {
						// ヴィトウィーン追加
						amazon_add.before(item_add_between_html);
					}
					// 自要素削除
					amazon_add.remove();
				}
					// ログ
					else {
						alert('既に商品が削除されている、またはURLが間違っています');
					}
		  },
		  error: function(data) {

		  },
		  complete: function(data) {

		  }
		});
	}
		// ログ
		else {
			alert('正しいURLを入力してください');
		}
}
/****************
アマゾン追加 保存
****************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var amazon_add = $(this).parents('.amazon_add');

		// タイトル抽出
		var amazon_title     = amazon_add.find(".amazon_add_content_title").val();
		// 商品url抽出 (廃止) 2016.12.11 松岡
//		var amazon_url       = amazon_add.find('.amazon_add_content_url').val();
		// 商品url抽出
		var amazon_url       = amazon_add.find('.amazon_add_content_textlink').val();
		// テキストリンクHTML抽出
		var amazon_textlink  = amazon_add.find('.amazon_add_content_textlink').val();
		// 画像リンクHTML抽出
		var amazon_imagelink = amazon_add.find('.amazon_add_content_imagelink').val();

		// 文字列の先頭および末尾の連続する「半角空白・タブ文字・全角空白」を削除
		amazon_textlink = tab_space_delete(amazon_textlink);

		// target属性追加
		amazon_textlink = '<a href="'+amazon_textlink+'" rel="nofollow" target="_blank">'+amazon_title+'</a>';
		amazon_imagelink = amazon_imagelink.replace(/<a rel="nofollow"/, '<a rel="nofollow" target="_blank"');

		// SL(画像)の大きさを500にする
		amazon_imagelink = amazon_imagelink.replace(/SL([0-9]{3})/, 'SL500');

		// textlinkのval取得
		amazon_textlink_val = amazon_add.find('.amazon_add_content_textlink').val();
		// href取得
		amazon_textlink_val_href = amazon_textlink_val;

		// amazon_link_detail_html生成
		amazon_link_detail_html = '<span class="amazon_link_detail">\
		<a href="'+amazon_textlink_val_href+'" target="_blank">\
			<img src="http://sharetube.jp/assets/img/common/amazon_logo_10.png">\
			で詳細を見る</a>\
		</span>';
		// アマゾン
		ajax_amazon_html_create(amazon_add, amazon_url, amazon_title, amazon_textlink, amazon_imagelink, amazon_link_detail_html);
	}
}, '.amazon_add_content_submit');
/**********************
アマゾン追加 キャンセル
**********************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_val     = $(this).attr('data-check');
		var data_between = $(this).attr('data-between');
		// 親を指定して取得
		var amazon_add = $(this).parents('.amazon_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_val == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				amazon_add.remove();
			}
				else {
					// ビトウィーン追加
					amazon_add.before(item_add_between_html);
					// 自要素削除
					amazon_add.remove();
				}
		}
			// 元データがある場合
			else {

				// 親を指定して取得
				var amazon_add = $(this).parents('.amazon_add');
				var amazon_title     = amazon_add.find('.amazon_add_content_title').val();
				var amazon_url       = amazon_add.find('.amazon_add_content_textlink').val();
				var amazon_textlink  = amazon_add.find('.amazon_add_content_textlink').val();
				var amazon_imagelink = amazon_add.find('.amazon_add_content_imagelink').val();

				// <、>をエンティティを戻す
				amazon_title     = text_entity_return(amazon_title);
				amazon_textlink  = text_entity_return(amazon_textlink);
				amazon_imagelink = text_entity_return(amazon_imagelink);

				// textlinkのval取得
				amazon_textlink_val = amazon_add.find('.amazon_add_content_textlink').val();
				// target属性追加
				amazon_textlink = '<a href="'+amazon_textlink+'" rel="nofollow" target="_blank">'+amazon_title+'</a>';

				// href取得	
//				amazon_textlink_val_href = amazon_textlink_val.match(/href="(.+?)"/);
				// amazon_link_detail_html生成
				amazon_link_detail_html = '<span class="amazon_link_detail">\
				<a href="'+amazon_textlink_val+'" rel="nofollow" target="_blank">\
					<img src="http://localhost/sharetube/assets/img/common/amazon_logo_10.png">\
					で詳細を見る</a>\
				</span>';

//				var val = amazon_html(amazon_title, amazon_textlink, amazon_imagelink);
			// アマゾン
			ajax_amazon_html_create(amazon_add,amazon_url,amazon_title, amazon_textlink, amazon_imagelink, amazon_link_detail_html);

				// テキスト追加
//					$(this).parents('.amazon_add').before(val);
				// 自要素削除
//				amazon_add.remove();
			}
	},
}, '.amazon_add_content_cancel');
});