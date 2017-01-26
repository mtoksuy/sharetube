//----------------
//読み込み後の処理
//----------------
$(function() {
	/***************
	目次フォームHTML
	***************/
	function contents_form_html(between) {
		// ヴィトウィーン検査
		if(between == null) {
			var data_between = '';
		}
			else {
				var data_between = 'data-between="'+between+'"';
			}

		// 目次li_HTML作成
		li_list = contents_li_html_create();
		// 目次フォームHTML
		var contents_form_html = ('<div class="contents_add">\
	<div class="contents_add_content">\
		<nav class="matome_content_block_contents clearfix">\
			<div class="matome_content_block_contents_title">\
				<span>目次</span>\
			</div>\
			<ul>\
				'+li_list+'\
			</ul>\
		</nav>\
		<div class="contents_add_content_button clearfix">\
			<div class="contents_add_content_button_left">\
				<div class="contents_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="contents_add_content_button_right">\
				<div class="contents_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- contents_add_content -->\
</div> <!-- contents_add -->');
		return contents_form_html;
	}
	/**************
	目次li_HTML作成
	**************/
	function contents_li_html_create() {
		// 使用変数
		previe_class_name = '';
		li_list           = '';
		h2_count          = 0;
		h3_count          = 0;
		h4_count          = 0;
		// クラスネーム精査
		$('.h2_heading_1, .h3_heading_1, .h4_heading_1').each( function(i, e) {
			// クラスネーム取得
			class_name = $(this).attr('class');
			// コンテンツ取得
			content    = $(this).html();

			// h2だった場合
			if(class_name.match(/h2/)) {
				// 数字を足す
				h2_count++;
				// 初期化
				h3_count = 0;
				h4_count = 0;

				li_list = li_list+'<li class="h2_contents">\
					<span class="matome_content_block_contents_number">'+h2_count+'.</span>\
					<span class="matome_content_block_contents_chapter">'+$(this).html()+'</span></li>';
			}
				// h3だった場合
				else if(class_name.match(/h3/)) {
					// 数字を足す
					h3_count++;
					// 初期化
					h4_count = 0;
	
					li_list = li_list+'<li class="h3_contents">\
						<span class="matome_content_block_contents_number">'+h2_count+'-'+h3_count+'.</span>\
						<span class="matome_content_block_contents_chapter">'+$(this).html()+'</span></li>';
				}
					// h4だった場合
					else if(class_name.match(/h4/)) {
						// 数字を足す
						h4_count++;
						li_list = li_list+'<li class="h4_contents">\
							<span class="matome_content_block_contents_number">'+h2_count+'-'+h3_count+'-'+h4_count+'.</span>\
							<span class="matome_content_block_contents_chapter">'+$(this).html()+'</span></li>';
					}
			// 1つ前のクラスネーム(重要)
			previe_class_name = class_name;
		});
		return li_list;
	}
	/***********
	目次HTML作成
	***********/
	function contents_html_create() {
		li_list = contents_li_html_create();
		// 目次フォームHTML
		var contents_html = ('<div class="matome_content_block">\
		<nav class="matome_content_block_contents clearfix">\
			<div class="matome_content_block_contents_title">\
				<span>目次</span>\
			</div>\
			<ul>\
				'+li_list+'\
			</ul>\
		</nav>\
</div>');
		return contents_html;
	}
/****************************
アイテム 目次追加フォーム生成
****************************/
$('.item_add').on( {
	'click':function() {
		$('.matome').find('.matome_content').prepend(contents_form_html());
	}
}, '.item_add_content_list_contents');
/********
目次 保存
********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var contents_add  = $(this).parents('.contents_add');
		// クラスネーム取得
		var class_name = $(this).parents('.contents_add').next().attr('class');
		// 目次HTML作成
		contents_html = contents_html_create();
		// 目次追加
		contents_add.before(contents_html);
		// 次のクラスにヴィトウィーンがない場合
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.contents_add').before(item_add_between_html);
		}
		// 自要素削除
		contents_add.remove();
	}
}, '.contents_add_content_submit');
/********
目次 削除
********/
$('.matome').on( {
	'click' : function(event) {
		// 親を指定して取得
		var contents_add = $(this).parents('.contents_add');

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
				contents_add.remove();
			}
				else {
					// ビトウィーン追加
					contents_add.before(item_add_between_html);
					// 自要素削除
					contents_add.remove();
				}
		}
			// 元データがある場合
			else {
				// コンテンツ抽出
				var image_url         = contents_add.find('.matome_content_block_contents_title a').attr('href');
				var image_title       = contents_add.find('.matome_content_block_contents_title a').html();
				var image_description = contents_add.find('.matome_content_block_contents_description').html();
				var word              = contents_add.find('.contents_add_content_word').val();
				// 元に戻す
				$(this).parents('.contents_add').before(contents_html(image_url, image_title, image_description, word));
				// 自要素削除
				contents_add.remove();
			}
	}
}, '.contents_add_content_cancel');
});