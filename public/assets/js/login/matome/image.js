//----------------
//読み込み後の処理
//----------------
$(function() {
	/*******************
	画像追加フォームHTML	
	*******************/
	function image_form_html(between) {
		// ヴィトウィーン検査
		if(between == null) {
			var data_between = '';
		}
			else {
				var data_between = 'data-between="'+between+'"';
			}
		// 動画フォームHTML
		var video_form_html = ('<div class="image_add clearfix">\
	<div class="image_add_content">\
		<div class="image_add_content_left">\
			<span class="typcn typcn-image-outline"></span>\
		</div>\
		<div class="image_add_content_right clearfix">\
			<div class="upload_button">\
				<input class="image_add_content_file" type="file" name="file[]">\
			</div>\
		</div>\
		<div class="image_add_content_button clearfix">\
			<div class="image_add_content_button_left">\
				<div class="image_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="image_add_content_button_right">\
				<div class="image_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- image_add_content -->\
</div> <!-- image_add -->');
		return video_form_html;
	}
	/*******
	画像HTML	
	*******/
	function image_html_2(image_url, title, word, quote_url, quote_tile) {
		if(quote_url && quote_tile) {
			var quote_html = 
				'<div class="image_quote">\
					<p class="blockquote_font text_right m_b_0">出典:<cite><a target="_blank" href="'+quote_url+'">'+quote_tile+'</a></cite></p>\
				</div>';
		}
			else {
				var quote_html = '';
			}
		// 画像HTML
		var image_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_image">\
		<div class="article_content_left_right clearfix">\
			<div class="article_content_left">\
				<div class="great_image_set_100">\
					<p class="m_0">\
						<a target="_blank" href="'+image_url+'">\
							<img width="640" height="400" class="o_8" src="'+image_url+'" alt="'+title+'" title="'+title+'">\
						</a>\
					</p>\
				</div>\
				'+quote_html+'\
			</div>\
			<div class="article_content_right">\
				<h3>'+title+'</h3>\
				<pre>'+word+'</pre>\
			</div>\
		</div>\
	</div>\
</div>');
		return image_html;
	}
/****************************
アイテム 画像追加フォーム生成
****************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(image_form_html());
	}
}, '.item_add_content_list_image');
/*****************************************
アイテム ビトウィーン 画像追加フォーム生成 
*****************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(image_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_image');
/************************
アイテム 画像アップロード
************************/
$('.matome').on( {
	'change' : function() {
		 var image_add = $(this).parents('.image_add');
		// 画像データを挿入するarray
		var image_array = [];
		// 送信する画像ファイルス
		var files        = $(this).prop('files');
		// 画像の枚数取得
		var files_length = files.length;
		// 選択した画像分AJAXする
		for(var i = 0; i < files_length; i++) {
			// 送信フォーマットインスタンス
			var formData = new FormData();
			// 送信する画像
			var file     = $(this).prop('files')[i];
			// 設定
			formData.append('file', file);
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/imagefileupload/',
				data: formData,
				dataType: 'json',
				cache: false,
				processData: false,
				contentType: false,
				// Ajax完了後の挙動
			  success: function(data) {
					// 画像データ挿入
					image_array.push(data["image_url"]);
					// タイトル・紹介コメントHTML挿入
					image_add.find('.upload_button').after('<input type="text" class="image_add_content_title" placeholder="画像のタイトルを入力" value="">\
						<textarea class="image_add_content_word" placeholder="画像の紹介コメントを入力"></textarea>\
						<input type="text" placeholder="引用の出典元URLを入力 フォーカスを外すと自動でタイトルが入力されます" value="" class="image_add_content_quote_url">\
						<input type="text" placeholder="引用の出典を入力" value="" class="image_add_content_quote_title">');
					// アップロードボタン削除
					image_add.find('.upload_button').remove();
					// 画像HTML表示
					image_add.find('.image_add_content_left').html('<div class="great_image_set_100">\
	<p class="m_0">\
		<a target="_blank" href="'+image_array[0]+'">\
			<img width="640" height="400" class="o_8" src="'+image_array[0]+'" alt="" title="">\
		</a>\
	</p>\
</div>');
				// チェック属性追加
				image_add.find('.image_add_content_submit').attr( {
					'data-check': 'true'
				});
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			}); // $.ajax( {
		} // for(var i = 0; i > files_length; i++) {
	}
}, '.image_add_content_file');
/****************************
アイテム 画像の引用元情報取得
****************************/
$('.matome').on( {
	'change' : function() {
		 var image_add = $(this).parents('.image_add');
		var val    = $(this).val();
		var j_this = $(this);
		var re     = /https|http/;
		var test = val.match(re);
		// 正しいURLか検査
		if(test) {
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/urltitleget/',
				data: {
					url: val,
				},
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					// チェック判別
					if(data['check'] == true) {
						j_this.next().val(data['title']);
					}
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			}); // $.ajax( {
		}
	}
}, '.image_add_content_quote_url');
/************
画像追加 保存
************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var image_add = $(this).parents('.image_add');
		var check     = image_add.find('.image_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// コンテンツ抽出
			var image_html = image_add.find('.image_add_content_left').html();
			var image_url  = image_add.find('.great_image_set_100 p a').attr('href');
			var title      = image_add.find('.image_add_content_title').val();
			var word       = image_add.find('.image_add_content_word').val();
			var quote_url  = image_add.find('.image_add_content_quote_url').val();
			var quote_tile = image_add.find('.image_add_content_quote_title').val();

			// クラスネーム取得
			var class_name = $(this).parents('.image_add').next().attr('class');
			// ビトウィーン取得
			var data_between = $(this).attr('data-between');
			// ヴィトウィーンからの追加の場合
			if(data_between) {
				// ヴィトウィーン追加
				$(this).parents('.image_add').before(item_add_between_html);
			}
			// 画像追加
			$(this).parents('.image_add').before(image_html_2(image_url, title, word, quote_url, quote_tile));

			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.image_add').before(item_add_between_html);
			}
			// 自要素削除
			image_add.remove();
		}
			else {
				alert('画像ファイルを選択してください');
			}
	}
}, '.image_add_content_submit');
/******************
画像追加 キャンセル
******************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var image_add = $(this).parents('.image_add');
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
				image_add.remove();
			}
				else {
					// ビトウィーン追加
					image_add.before(item_add_between_html);
					// 自要素削除
					image_add.remove();
				}
		}
			// 元データがある場合
			else {
				// コンテンツ抽出
				var image_html = image_add.find('.image_add_content_left').html();
				var image_url  = image_add.find('.great_image_set_100 p a').attr('href');
				var title      = image_add.find('.image_add_content_title').val();
				var word       = image_add.find('.image_add_content_word').val();

				// 画像追加
				$(this).parents('.image_add').before(image_html_2(image_url, title, word)); 
				// 自要素削除
				image_add.remove();
			}
	},
}, '.image_add_content_cancel');
});