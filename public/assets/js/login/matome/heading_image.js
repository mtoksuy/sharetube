//----------------
//読み込み後の処理
//----------------
$(function() {
	/*************************
	見出し画像追加フォームHTML	
	*************************/
	function heading_image_form_html(between) {
		// ヴィトウィーン検査
		if(between == null) {
			var data_between = '';
		}
			else {
				var data_between = 'data-between="'+between+'"';
			}
		// 見出し画像追加フォームHTML
		var video_form_html = ('<div class="heading_image_add clearfix">\
	<div class="heading_image_add_content">\
		<div class="heading_image_add_content_left">\
			<span class="typcn typcn-image-outline"></span>\
		</div>\
		<div class="heading_image_add_content_right clearfix">\
			<div class="upload_button">\
				<input class="heading_image_add_content_file" type="file" name="file[]">\
			</div>\
		</div>\
		<div class="heading_image_add_content_button clearfix">\
			<div class="heading_image_add_content_button_left">\
				<div class="heading_image_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="heading_image_add_content_button_right">\
				<div class="heading_image_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- heading_image_add_content -->\
</div> <!-- heading_image_add -->');
		return video_form_html;
	}
	/*****************
	見出し画像HTML生成
	*****************/
	function heading_image_html_create(image_url) {
		// 画像HTML
		var heading_image_html = ('<div class="matome_content_block">\
	<div class="matome_content_block_heading_image">\
		<div class="great_image_set_100">\
			<p class="m_0">\
				<a target="_blank" href="'+image_url+'">\
					<img width="640" height="400" src="'+image_url+'">\
				</a>\
			</p>\
		</div>\
	</div>\
</div>');
		return heading_image_html;
	}
/****************************
アイテム 画像追加フォーム生成
****************************/
$('.item_add').on( {
	'click':function() {
//		p('aaaaaa');
		$('.matome').find('.matome_content').prepend(heading_image_form_html());
	}
}, '.item_add_content_list_heading_image');
/*****************************************
アイテム ビトウィーン 画像追加フォーム生成 
*****************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(heading_image_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_heading_image');
/************************
アイテム 画像アップロード
************************/
$('.matome').on( {
	'change' : function() {
		 var heading_image_add = $(this).parents('.heading_image_add');
		// 画像データを挿入するarray
		var heading_image_array = [];
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
					heading_image_array.push(data["image_url"]);
					// アップロードボタン削除
					heading_image_add.find('.upload_button').remove();
					// css再設定
					heading_image_add.find('.heading_image_add_content_left').css( {
						'height': 'auto'
					});
					// 画像HTML表示
					heading_image_add.find('.heading_image_add_content_left').html('<div class="great_image_set_100">\
	<p class="m_0">\
		<img width="640" height="400" src="'+heading_image_array[0]+'">\
	</p>\
</div>');
				// チェック属性追加
				heading_image_add.find('.heading_image_add_content_submit').attr( {
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
}, '.heading_image_add_content_file');
/************
画像追加 保存
************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var heading_image_add = $(this).parents('.heading_image_add');
		var check             = heading_image_add.find('.heading_image_add_content_submit').attr('data-check');
		// チェック
		if(check) {
			// コンテンツ抽出
			var heading_image_html = heading_image_add.find('.heading_image_add_content_left').html();
			var image_url          = heading_image_add.find('.great_image_set_100 p img').attr('src');
			// クラスネーム取得
			var class_name = $(this).parents('.heading_image_add').next().attr('class');
			// ビトウィーン取得
			var data_between = $(this).attr('data-between');
			// ヴィトウィーンからの追加の場合
			if(data_between) {
				// ヴィトウィーン追加
				$(this).parents('.heading_image_add').before(item_add_between_html);
			}
			// 画像追加
			$(this).parents('.heading_image_add').before(heading_image_html_create(image_url));

			if(class_name != 'item_add_between') {
				// ヴィトウィーン追加
				$(this).parents('.heading_image_add').before(item_add_between_html);
			}
			// 自要素削除
			heading_image_add.remove();
		}
			else {
				alert('画像ファイルを選択してください');
			}
	}
}, '.heading_image_add_content_submit');
/******************
画像追加 キャンセル
******************/
$('.matome').on( {
	'click': function(event) {
		// 親を指定して取得
		var heading_image_add = $(this).parents('.heading_image_add');
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
				heading_image_add.remove();
			}
				else {
					// ビトウィーン追加
					heading_image_add.before(item_add_between_html);
					// 自要素削除
					heading_image_add.remove();
				}
		}
			// 元データがある場合
			else {
				// コンテンツ抽出
				var heading_image_html = heading_image_add.find('.heading_image_add_content_left').html();
				var image_url  = heading_image_add.find('.great_image_set_100 p a').attr('href');
				var title      = heading_image_add.find('.heading_image_add_content_title').val();
				var word       = heading_image_add.find('.heading_image_add_content_word').val();

				// 画像追加
				$(this).parents('.heading_image_add').before(heading_image_html_create(image_url, title, word)); 
				// 自要素削除
				heading_image_add.remove();
			}
	},
}, '.heading_image_add_content_cancel');
});