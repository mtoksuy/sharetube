//----------------
//ランダムキー生成
//----------------
function random_key_create() {
var random_key = '';
for (var i = 0 ; i < 10 ; i++) {
  random_key = random_key + Math.floor(Math.random () * 10) + 1;
}
	return random_key;
}

var thumbnail_flg = false;
$(function () {
	//----------------------------------------
	//サムネイル自動アップロードするサブミット
	//----------------------------------------
	$("#file").change(function () {
		// ランダムキー生成
		random_key = random_key_create();
		//今日の日付データを変数hidukeに格納
		var now_day = new Date();
		//年・月・日・曜日を取得する
		var year      = now_day.getFullYear();
		var month     = now_day.getMonth()+1;
		var week      = now_day.getDay();
		var day       = now_day.getDate();
		var day_data  = '' + year + month + day;
		// ランダムキー日付追加
		var random_key = '' + day_data + random_key;
		// インプットにランダムキー追加
		$("#post_form").prepend('<input type="hidden" id="post_form_random_key" name="random_key" value="' + random_key + '">');
		$("#thumbnail_form").prepend('<input type="hidden" id="thumbnail_form_random_key" name="random_key" value="' + random_key + '">');
	/*
		p($('#title').prop('value'));
		p($('#title').prop('value'));
	*/
		$(this).closest("form").submit();
//		p($('#file'));

 var file = $(this).prop('files')[0];
// 画像以外は処理を停止
if (! file.type.match('image.*')) {
	$('#thumbnail_form').before();
	return;
}
//--------
//画像表示
//--------
var reader = new FileReader();
reader.onload = function() {
	var img_src = $('<img id="reader_image">').attr( {
		src:   reader.result,
		style: 'width: 100%; height: auto;',
	});
$('#thumbnail_form').before(img_src);
}
reader.readAsDataURL(file);

//		$('#thumbnail_form').before('<img src="'+ http +'assets/img/draft/article/'+year+'/'+random_key+'.jpg">');
		// フォーム非表示
		$('#thumbnail_form').css( {
			display: 'none',
		});
		// サムネイル削除ボタン生成
		$('#thumbnail_form').after('<span class="thumbnail_form_delete_button" title="削除ボタン">×</span>');

$('.thumbnail_form_delete_button').click(function() {
	thumbnail_form_delete_button_click();
});

		// ajax
/*
		$.ajax( {
			type: 'GET', 
			url: http + 'ajax/thumbnail/',
			data: {
				
			},
			dataType: 'json',
			cache: false,
		  success: function(data) {
				
		  },
			// エラー処理
		  error: function(data) {
				
		  },
		  complete: function(data) {

		  }
		}); // $.ajax({
*/
	});
//--------------------
//サムネイル削除ボタン
//--------------------
function thumbnail_form_delete_button_click() {
	// 表示している画像削除
	$('#reader_image').remove();
	// 削除ボタン削除
	$('.thumbnail_form_delete_button').remove();
		// フォーム表示
		$('#thumbnail_form').css( {
			display: 'block',
		});
//p($('#post_form_random_key'));
// ランダムキー削除
$('#post_form_random_key').remove();
// ランダムキー削除
$('#thumbnail_form_random_key').remove();
// サムネイル削除
$('#post_form_thumbnail_create').remove();
//p($('#post_form_random_key'));
}

/*
$('.thumbnail_form_delete_button').click(function() {
	p('クリック');
/*
$("#post_form").prepend('<input type="hidden" name="random_key" value="' + random_key + '">');
$("#thumbnail_form").prepend('<input type="hidden" name="random_key" value="' + random_key + '">');
<input type="hidden" value="1" name="thumbnail_create">

p($('#post_form_random_key'));
$('#post_form_random_key').remove();
p($('#post_form_random_key'));

});
*/
$('.thumbnail_form_delete_button').click(function() {
	thumbnail_form_delete_button_click();
});



//-----------------------
//
//-----------------------
/********************************
アイテム 吹き出し追加フォーム生成
********************************/
$('.article_list').on( {
	'click': function() {
		$('.matome').find('.matome_content').prepend(ballon_form_html());
	}
}, '.item_add_content_list_ballon');
////////////
//まとめ削除
////////////
$('.article_list').on( {
	'click' : function() {
		// 削除ページのurl取得
		delete_page = $(this).find('a').attr('data-href');
			swal({
				title: "本当に削除しますか？",
				text: "ユーザー権限では元に戻せない操作です",
				type: "warning",
				showCancelButton: true,
			  cancelButtonText: 'キャンセル',
				confirmButtonColor: "#DD6B55",
				confirmButtonColor: "#F05043",
				confirmButtonText: '削除する',
				closeOnConfirm: false },
					function() {
						swal("削除致しました。", "自動で画面遷移致します", "success");
						// 削除ページに画面遷移
						window.location.href = delete_page;
					}
			);
	} // 'click' : function() {
}, '.article_delete_button');






});
