$(function() {
	/************************
	 アイコン画像アップロード
	************************/
	$('.account_form').on( {
		'change' : function() {
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
					url: http+'ajax/userprofileedit/userprofileicon/',
					data: formData,
					dataType: 'json',
					cache: false,
					processData: false,
					contentType: false,
					// Ajax完了後の挙動
				  success: function(data) {
						// 変更後の画像表示
						$('.now_user_icon').attr('src',data["image_url"]);
				  },
				  error: function(data) {
	
				  },
				  complete: function(data) {
	
				  }
				}); // $.ajax( {
			} // for(var i = 0; i > files_length; i++) {
		}
	}, '#user_icon');
});