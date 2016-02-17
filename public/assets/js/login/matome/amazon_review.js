//----------------
//読み込み後の処理
//----------------
$(function() {
/***********************
アマゾンレビューフォームHTML
***********************/
function amazon_review_form_html(between) {
	// ヴィトウィーン検査
	if(between == null) {
		var data_between = '';
	}
		else {
			var data_between = 'data-between="'+between+'"';
		}
	// 見出しフォームHTML
	var amazon_review_form_html = ('<div class="amazon_review_add">\
	<div class="amazon_review_add_content">\
		<textarea placeholder="アマゾンレビューを入力"></textarea>\
		<div class="amazon_review_add_content_button clearfix">\
			<div class="amazon_review_add_content_button_left">\
				<div class="amazon_review_add_content_submit" '+data_between+'>保存</div>\
			</div>\
			<div class="amazon_review_add_content_button_right">\
			<div class="amazon_review_add_content_cancel" '+data_between+'>キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- amazon_review_add_content -->\
</div> <!-- amazon_review_add -->');
	return amazon_review_form_html;
}
/*******************
アマゾンレビューHTML
*******************/
function amazon_review_html_create(amazon_review_data_object_array) {
/*
	p(amazon_review_data_object_array);
	p(amazon_review_data_object_array.length);
*/
	amazon_review_html = '';
	array_length = amazon_review_data_object_array.length;
	// amazon_review_htmlを生成
	for(i = 0; array_length > i; i++) {
//		rating_number = parseInt(amazon_review_data_object_array[i]['rating'].match(/(1).0/));
		rating_number_array = amazon_review_data_object_array[i]['rating'].match(/([0-9]{1}).0/);
		// レーティング数取得
		rating_number = parseInt(rating_number_array[1]);
		rating_i = 5;
		rating_html = '';
		//////////////////////
		//レーティングHTML生成
		//////////////////////
		while(rating_i > 0) {
			rating_i--;
			rating_number--;
			if(rating_number >= 0) {
				rating_html = rating_html+'<span class="typcn typcn-star"></span>\n';
			}
				else {
					rating_html = rating_html+'<span class="typcn typcn-star-outline"></span>\n';
				}
		} // while($rating_i > 0) {
		// 完成
		rating_html = 
			'<div class="matome_content_block_amazon_review_rating">\n\
				'+rating_html+'\
			</div>';
		//////////////////
		//タイトルHTML生成
		//////////////////
		title_html = 
			'<div class="matome_content_block_amazon_review_title">\
				'+amazon_review_data_object_array[i]['title']+'\
			</div>';
		////////////////
		//投稿者HTML生成
		////////////////
		contributor_html = 
			'<span class="matome_content_block_amazon_review_contributor">\
				投稿者：'+amazon_review_data_object_array[i]['contributor']+'\
			</span>';
		////////////////
		//投稿日HTML生成
		////////////////
		post_time_html = 
			'<span class="matome_content_block_amazon_review_post_time">\
				投稿日：'+amazon_review_data_object_array[i]['post_time']+'\
			</span>';
		////////////////////
		//コンテンツHTML生成
		////////////////////
		content_html = 
			'<div class="matome_content_block_amazon_review_content">\
			<pre>'+amazon_review_data_object_array[i]['content']+'</pre>\
		</div>';
		//////
		//結合
		//////
		var amazon_review_html = 
			amazon_review_html+
				'<li>\
					'+rating_html+'\
					'+title_html+'\
					'+contributor_html+'\
					'+post_time_html+'\
					'+content_html+'\
				</li>';
		// 初期化
		rating_html = '';
	}
	//////
	//完成
	//////
	amazon_review_html = 
		'<div class="matome_content_block">\
			<div class="matome_content_block_amazon_review">\
				<ol>\
					'+amazon_review_html+'\
				</ol>\
			</div>\
		</div>';
	return amazon_review_html;
}
/****************************************
アイテム アマゾンレビュー追加フォーム生成
****************************************/
$('.item_add').on( {
	'click': function() {
		$('.matome').find('.matome_content').prepend(amazon_review_form_html());
	}
}, '.item_add_content_list_amazon_review');

/*****************************************************
アイテム ビトウィーン アマゾンレビュー追加フォーム生成 
*****************************************************/
$('.matome').on( {
	'click' : function(event) {
		// アド取得
		var item_between_add = $(this).parents('.item_between_add');
		var between = 'true';
		// 追加
		$(this).parents('.item_between_add').before(amazon_review_form_html(between));
		// 削除
		item_between_add.remove();
	}
}, '.item_between_add_content_list_amazon_review');
/*************************
アマゾンレビューデータ取得
*************************/
function amazon_review_data_object_array_get(amazon_review) {
	// 改行を幻の改行にする
	var amazon_review = amazon_review.replace(/\n/g, '幻の改行');
	// Amazonで購入を削除
	var amazon_review = amazon_review.replace(/Amazonで購入幻の改行/g, '');
	// 正しいレビューが出現する回数を取得
	amazon_review_array = amazon_review.match(/5つ星のう(.+?)[0-5]{1}.0/g);
	// レビューがある場合
	if(amazon_review_array) {
		// データ挿入array
		amazon_review_data_object_array = [];
		// レビュー数取得
		review_count   = amazon_review_array.length;
		review_count_2 = review_count;
		//////////////////////
		// レビューが1つの場合
		//////////////////////
		if(review_count == 1) {
			// レーティング取得
			amazon_review_rating = amazon_review_array[0];
			// タイトル取得
			pattern = ''+amazon_review_rating+'(.+?)幻の改行';
			regexp = new RegExp(pattern);
			amazon_review_title_array = amazon_review.match(regexp);
			amazon_review_title       = amazon_review_title_array[1];
			// 投稿者取得
			amazon_post_array = amazon_review.match(/投稿者(.+?)([0-9]{4}年[0-9]{1,2}月[0-9]{1,2}日|投稿日.[0-9]{4}\/[0-9]{1,2}\/[0-9]{1,2})幻の改行/);
			amazon_review_contributor = amazon_post_array[1];
			// 投稿日取得
			amazon_review_post_time   = amazon_post_array[2];

			// レビュー内容取得
			amazon_review_content = amazon_review.replace(amazon_review_rating+amazon_review_title+'幻の改行'+'投稿者'+amazon_review_contributor+amazon_review_post_time+'幻の改行', '');

			// 2015/11/16形式の場合年月日形式に変更する
			amazon_review_post_time   = amazon_review_post_time.replace(/投稿日 /,'');
			amazon_review_post_time   = amazon_review_post_time.replace(/([0-9]{4})\//,'$1年');
			amazon_review_post_time   = amazon_review_post_time.replace(/\/([0-9]{1,2})/,'月$1日');

			// アマゾンレビューデータarray生成
			 amazon_review_data_object_array[0] = {
				'rating'      : amazon_review_rating,
				'title'       : amazon_review_title,
				'contributor' : amazon_review_contributor,
				'post_time'   : amazon_review_post_time,
				'content'     : amazon_review_content,
			};
//				p(amazon_review_data_object_array);
		}
			///////////////////////
			// レビューが複数の場合
			///////////////////////
			else {
//					for(review_count = amazon_review_array.length; review_count > 0; review_count--) {
				for(i = 0; review_count > i; i++) {
					review_count_2--;
					// ラスト
					if(review_count_2 == 0) {
						amazon_review_array = amazon_review.match(/5つ星のう(.+?)[0-5]{1}.0/);
						// レーティング取得
						amazon_review_rating = amazon_review_array[0];
						// タイトル取得
						pattern = ''+amazon_review_rating+'(.+?)幻の改行';
						regexp = new RegExp(pattern);
						amazon_review_title_array = amazon_review.match(regexp);
						amazon_review_title       = amazon_review_title_array[1];
						// 投稿者取得
						amazon_post_array = amazon_review.match(/投稿者(.+?)([0-9]{4}年[0-9]{1,2}月[0-9]{1,2}日|投稿日.[0-9]{4}\/[0-9]{1,2}\/[0-9]{1,2})幻の改行/);
						amazon_review_contributor = amazon_post_array[1];
						// 投稿日取得
						amazon_review_post_time   = amazon_post_array[2];
			
						// レビュー内容取得
						amazon_review_content = amazon_review.replace(amazon_review_rating+amazon_review_title+'幻の改行'+'投稿者'+amazon_review_contributor+amazon_review_post_time+'幻の改行', '');
			
						// 2015/11/16形式の場合年月日形式に変更する
						amazon_review_post_time   = amazon_review_post_time.replace(/投稿日 /,'');
						amazon_review_post_time   = amazon_review_post_time.replace(/([0-9]{4})\//,'$1年');
						amazon_review_post_time   = amazon_review_post_time.replace(/\/([0-9]{1,2})/,'月$1日');
			
						// アマゾンレビューデータarray生成
						 amazon_review_data_object_array[i] = {
							'rating'      : amazon_review_rating,
							'title'       : amazon_review_title,
							'contributor' : amazon_review_contributor,
							'post_time'   : amazon_review_post_time,
							'content'     : amazon_review_content,
						};
					}
						else {
							amazon_review_array = amazon_review.match(/5つ星のう(.+?)[0-5]{1}.0/);
							// レーティング取得
							amazon_review_rating = amazon_review_array[0];
							// タイトル取得
							pattern = ''+amazon_review_rating+'(.+?)幻の改行';
							regexp = new RegExp(pattern);
							amazon_review_title_array = amazon_review.match(regexp);
							amazon_review_title = amazon_review_title_array[1];
							// 投稿者取得
							amazon_post_array = amazon_review.match(/投稿者(.+?)([0-9]{4}年[0-9]{1,2}月[0-9]{1,2}日|投稿日.[0-9]{4}\/[0-9]{1,2}\/[0-9]{1,2})幻の改行/);
							amazon_review_contributor = amazon_post_array[1];
							// 投稿日取得
							amazon_review_post_time   = amazon_post_array[2];
							// レビュー内容取得
							pattern = ''+amazon_review_rating+amazon_review_title+'幻の改行'+'投稿者'+amazon_review_contributor+amazon_review_post_time+'幻の改行'+'(.+?)'+'5つ星のう(.+?)[0-5]{1}.0';
							regexp = new RegExp(pattern);
							amazon_review_content_array = amazon_review.match(regexp);
							amazon_review_content = amazon_review_content_array[1];
							// レビュー削除
							pattern = ''+amazon_review_rating+amazon_review_title+'幻の改行'+'投稿者'+amazon_review_contributor+amazon_review_post_time+'幻の改行'+amazon_review_content;
							amazon_review = amazon_review.replace(pattern, '');

							// 2015/11/16形式の場合年月日形式に変更する
							amazon_review_post_time   = amazon_review_post_time.replace(/投稿日 /,'');
							amazon_review_post_time   = amazon_review_post_time.replace(/([0-9]{4})\//,'$1年');
							amazon_review_post_time   = amazon_review_post_time.replace(/\/([0-9]{1,2})/,'月$1日');

							// アマゾンレビューデータarray生成
							amazon_review_data_object_array[i] = {
								'rating'      : amazon_review_rating,
								'title'       : amazon_review_title,
								'contributor' : amazon_review_contributor,
								'post_time'   : amazon_review_post_time,
								'content'     : amazon_review_content,
							};
						} // else {
				} // for(i = 0; review_count > i; i++) {
			} // else {
	} // if(amazon_review_array) {
	//////////////
	//改行系を修復
	//////////////
	for(i = 0; amazon_review_data_object_array.length > i; i++) {
		n_check = amazon_review_data_object_array[i]['content'].match(/幻の改行$/);
		// 文末改行チェック
		if(n_check) {
			// 文末改行削除
			amazon_review_data_object_array[i]['content'] = amazon_review_data_object_array[i]['content'].replace(/(幻の改行){1,}$/, '');
		}
		// 幻の改行を改行に戻す
			amazon_review_data_object_array[i]['content'] = amazon_review_data_object_array[i]['content'].replace(/幻の改行/g, '\n');
	}
	return amazon_review_data_object_array;
}
/************************
アマゾンレビュー追加 保存
************************/
$('.matome').on({
	'click': function(event) {
		// 親を指定して取得
		var amazon_review_add = $(this).parents('.amazon_review_add');
		// アマゾンレビュー抽出
		var amazon_review       = amazon_review_add.find("textarea").val();
		// アマゾンレビューデータ取得
		amazon_review_data_object_array = amazon_review_data_object_array_get(amazon_review);

		// クラスネーム取得
		var class_name = $(this).parents('.amazon_review_add').next().attr('class');
		// ビトウィーン取得
		var data_between = $(this).attr('data-between');

		// ヴィトウィーンからの追加の場合
		if(data_between) {
			// ヴィトウィーン追加
			$(this).parents('.amazon_review_add').before(item_add_between_html);
		}
		// アマゾンレビュー追加
		$(this).parents('.amazon_review_add').before(amazon_review_html_create(amazon_review_data_object_array));
		if(class_name != 'item_add_between') {
			// ヴィトウィーン追加
			$(this).parents('.amazon_review_add').before(item_add_between_html);
		}
		// 自要素削除
		amazon_review_add.remove();
	}
}, '.amazon_review_add_content_submit');
/******************************
アマゾンレビュー追加 キャンセル
******************************/
$('.matome').on( {
	'click': function(event) {
		// 元データ取得
		var data_check   = $(this).attr('data-check');
		var data_between = $(this).attr('data-between');
		// 親を指定して取得
		var amazon_review_add = $(this).parents('.amazon_review_add');
		/////////////////////
		// 元データがない場合
		/////////////////////
		if(data_check == null) {
			////////////////////////
			//data_betweenからの場合
			////////////////////////
			if(data_between == null) {
				// 自要素削除
				amazon_review_add.remove();
			}
				else {
					// ビトウィーン追加
					amazon_review_add.before(item_add_between_html);
					// 自要素削除
					amazon_review_add.remove();
				}
		}
			// 元データがある場合
			else {
				// 親を指定して取得
				var amazon_review_add = $(this).parents('.amazon_review_add');
				// アマゾンレビュー抽出
				var amazon_review = amazon_review_add.find("textarea").val();
				// アマゾンレビューデータ取得
				amazon_review_data_object_array = amazon_review_data_object_array_get(amazon_review);
				// アマゾンレビューHTML生成
				amazon_review_html  = amazon_review_html_create(amazon_review_data_object_array);
				// <、>をエンティティを戻す
				amazon_review_html = text_entity_return(amazon_review_html);
				// アマゾンレビュー追加
					$(this).parents('.amazon_review_add').before(amazon_review_html);
				// 自要素削除
				amazon_review_add.remove();
			}
	},
}, '.amazon_review_add_content_cancel');
});