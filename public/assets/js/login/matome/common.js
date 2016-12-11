/*************************
デバッグ変数コンストラクタ
*************************/
/*
var p        = console.log;
var print    = console.log;
var var_dump = console.dir;
var trace    = console.trace;
var time     = console.time;
var count    = console.count;
*/
/***********************
自分自身のHTMLを取得する
***********************/
(function($) {
	$.fn.selfHtml = function(options) {
		if($(this).get(0)) {
			return $(this).get(0).outerHTML;
		}
	}
})(jQuery);
//----------------------------
//<、>をエンティティに変換する
//----------------------------
function text_entity_conversion(val) {
	var val = val.replace(/</g,"&lt;");
	var val = val.replace(/>/g,"&gt;");
	var val = val.replace(/"/g,"&quot;");
	var val = val.replace(/'/g,"&#39;");
	var val = val.replace(/\\/g,"&#x5c;");
	return val;

			/**************************************
			 特殊文字を HTML エンティティに変換一覧
				  '"' => '&quot;'
				  ''' => '&#39;'
				  '<' => '&lt;'
				  '>' => '&gt;'
				  '&' => '&amp;'
			    if ($0 == "&")  return '&amp;';
			    if ($0 == "\"") return '&quot;';
			    if ($0 == "'")  return '&#039;';
			    if ($0 == "<")  return '&lt;';
			    if ($0 == ">")  return '&gt;';
			 *************************************/
}
//------------------------
//<、>をエンティティを戻す
//------------------------
function text_entity_return(val) {
	var val = val.replace(/&lt;/g,"<");
	var val = val.replace(/&gt;/g,">");
	var val = val.replace(/&quot;/g,'"');
	var val = val.replace(/&#39;/g,"'");
	var val = val.replace(/&#x5c;/g,"\\");
	return val;
}

//----------------
//ビトウィーンHTML
//----------------
var item_add_between_html = ('<div class="item_add_between">\
	<div class="item_add_between_content">\
		<span class="typcn typcn-plus"></span>追加\
	</div>\
	<div class="dashed"> </div>\
</div>');
//----------------
//読み込み後の処理
//----------------
$(function() {
/*******************
textarea自動リサイズ
*******************/
$('.matome').on( {
	'keyup' : function(event) {
		event_textarea = $(this);
		event_textarea.autosize();
	}
}, 'textarea');
/*********************
matome_data_object生成
*********************/
function matome_data_object_create() {

	// 
	if($('.matome_draft_save').val()) {
		var matome_draft_save  = 'true';
	}
		else {
			var matome_draft_save  = '';
		}
	// 下書きpraimarykey取得
	if($('.matome_draft_primary_id').val()) {
		var matome_draft_primary_id  = $('.matome_draft_primary_id').val();
	}
		else {
			var matome_draft_primary_id  = '';
		}
	if($('.matome_edit_primary_id').val()) {
		var matome_edit_primary_id  = $('.matome_edit_primary_id').val();
	}
		else {
			var matome_edit_primary_id  = '';
		}
	// 下書き情報
	var matome_draft_save      = matome_draft_save;
	// 下書き情報(下書きプライマリーキー)
	var matome_draft_primary_id = matome_draft_primary_id;
	// 記事情報(編集プライマリーキー)
	var matome_edit_primary_id = matome_edit_primary_id;
	// コンテンツ取得
	var matome_html           = $('.matome_content').html();
	// タイトル取得
	var matome_title          = $('.matome_title').val();
	// タグ取得
	var matome_tag            = $('.matome_tag').val();
	// カテゴリー取得
	var matome_category       = $('.matome_category').val();
	// サムネイル情報取得
	var matome_thumbnail_data = $('#thumbnail_form input').val();

	var matome_data_object = {
		matome_draft_save       : matome_draft_save,
		matome_draft_primary_id : matome_draft_primary_id,
		matome_edit_primary_id  : matome_edit_primary_id,
		matome_html             : matome_html,
		matome_title            : matome_title,
		matome_tag              : matome_tag,
		matome_category         : matome_category,
		matome_thumbnail_data   : matome_thumbnail_data,
	};
//	p(matome_data_object);
	return matome_data_object;
}
function redirect_home() {
	// リダイレクト
  location.href= http+'login/admin/';
}
/**********
まとめ 投稿
**********/
$('.postboxs').on( {
	'click' : function(event) {
		// matome_data_object生成
		var matome_data_object = matome_data_object_create();
		// サムネイルがある場合
		if(matome_data_object["matome_thumbnail_data"]) {
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/submit/',
				data: matome_data_object,
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					//------------------------
					//下書きを保存しました表示
					//------------------------
					swal({
					  title: "投稿が完了いたしました",
					  text: "2秒後、ダッシュボードに移動します",
					  timer: 2000,
					  showConfirmButton: false
					});
					// 2.1秒後
					setTimeout(function() {
						// リダイレクト
					  location.href= http+'login/admin/';
					}, 2100);  // 全てのブラウザで動作
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			}); // $.ajax( {
		}
			// サムネイルがない場合
			else {
				swal({
				  title: "サムネイルを設定して下さい",
				  text: "メッセージは1秒後に消えます",
				  timer: 1200,
				  showConfirmButton: false
				});	
			}
    // eachにて繰り返し要素取得
    $(".matome_content_block").each( function() {
//        alert($(this).html());
    });
	}
}, '.matome_submit');
/************
まとめ 下書き
************/
$('.postboxs').on( {
	'click' : function(event) {
		var postbox_contents = $(this).parents('.postbox_contents');
		// matome_data_object生成
		var matome_data_object = matome_data_object_create();
//		p(matome_data_object);
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/draft/',
				data: matome_data_object,
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					/////////////////
					// 初下書きの場合
					/////////////////
					if(!$('.matome_draft_save').length) {
							// matome_draft_save追加
							$('.matome_submit').after('<input class="matome_draft_save" type="hidden" name="matome_draft_save" value="true">');
					}
					//////////////////////////////////////////
					// 初下書きの場合(matome_draft_primary_id)
					//////////////////////////////////////////
					if(!$('.matome_draft_primary_id').length) {
							// matome_draft_primary_id追加
							$('.matome_submit').after('<input class="matome_draft_primary_id" type="hidden" name="matome_draft_primary_id" value="'+data["POST"]["draft_primary_id"]+'">');
					}
/*
					p($('.preview_button'));
					p(data["POST"]["draft_primary_id"]);
					p($('.preview_button').attr('href'));
*/
					// プレビューのhref変更
					$('.preview_button').attr( {
						href : http+'login/admin/post/preview/?p='+data["POST"]["draft_primary_id"]+'/',
					});
					//------------------------
					//下書きを保存しました表示
					//------------------------
					swal({
					  title: "下書きを保存しました",
					  text: "メッセージは1秒後に消えます",
					  timer: 1200,
					  showConfirmButton: false
					});
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			}); // $.ajax( {
    // eachにて繰り返し要素取得(後で使うかも)
    $(".matome_content_block").each( function() {
//        alert($(this).html());
    });
	}
}, '.matome_draft');
/**********
まとめ 編集
**********/
$('.postboxs').on( {
	'click' : function(event) {
		// matome_data_object生成
		var matome_data_object = matome_data_object_create();
			// Ajaxを走らせる
			$.ajax( {
				type: 'POST', 
				url: http+'ajax/matome/edit/',
				data: matome_data_object,
				dataType: 'json',
				cache: false,
				// Ajax完了後の挙動
			  success: function(data) {
					//------------------------
					//下書きを保存しました表示
					//------------------------
					swal({
					  title: "編集が完了しました",
					  text: "メッセージは1秒後に消えます",
					  timer: 1200,
					  showConfirmButton: false
					});
			  },
			  error: function(data) {

			  },
			  complete: function(data) {

			  }
			}); // $.ajax( {
	}
}, '.matome_edit');





















/*******************************************************
コンテンツ編集バー表示・非表示(matome_content_blockにて)
*******************************************************/
$('.matome').on({
'mouseenter': function() {
	// クラスネーム取得
	var class_name = $(this).children().attr('class');
	// 制御変数
	var top_off    = '';
	var up_off     = '';
	var down_off   = '';
	var bottom_off = '';
	// 総個数と何番目かの変数
	var length      = $('.matome_content_block').length;
	var this_number = $('.matome_content_block').index($(this)) + 1;
// 一個の場合
if(length == 1) {
	var top_off    = ' off';
	var up_off     = ' off';
	var down_off   = ' off';
	var bottom_off = ' off';
}
	// 二個以上ある場合
	else if(length > 1) {
		// 一番上の場合
		if(this_number == 1) {
			var top_off    = ' off';
			var up_off     = ' off';
			var down_off   = '';
			var bottom_off = '';
		}
		// 一番下の場合
		if((length - this_number) == 0) {
			var top_off    = '';
			var up_off     = '';
			var down_off   = ' off';
			var bottom_off = ' off';
		}
	}
		// ツールバー表示
	$(this).append('<ul class="toolbar">\
		<li class="top'+top_off+'"><span class="typcn typcn-media-fast-forward"></span></li>\
		<li class="up'+up_off+'"><span class="typcn typcn-media-play"></span></li>\
		<li class="down'+down_off+'"><span class="typcn typcn-media-play"></span></li>\
		<li class="bottom'+bottom_off+'"><span class="typcn typcn-media-fast-forward"></span></li>\
	</ul>\
	<ul class="editbar">\
		<li class="edit" data-class-name="'+class_name+'"><span class="typcn typcn-pencil">修正</span></li>\
		<li class="delete"><span class="typcn typcn-trash">削除</span></li>\
	</ul>');
},
	// ツールバー非表示
  'mouseleave': function() {
		// ツールバー削除
		$(this).find('.toolbar').remove();
		$(this).find('.editbar').remove();
  }
}, '.matome_content_block');
/**************
ツールバー 修正
**************/
$('.matome').on( {
	'click': function() {
		var class_name = $(this).attr('data-class-name');
		switch(class_name) {
			/////////////////
			// テキストの場合
			/////////////////
			case 'matome_content_block_text':
			var val = $(this).parents('.matome_content_block').find('pre').html();
			// <、>をエンティティに変換する
			val = text_entity_conversion(val);

			$(this).parents('.matome_content_block').before('<div class="text_add">\
											<div class="text_add_content">\
												<textarea placeholder="テキストを入力">'+ val +'</textarea>\
												<div class="text_add_content_button clearfix">\
													<div class="text_add_content_button_left">\
														<div class="text_add_content_submit">保存</div>\
													</div>\
													<div class="text_add_content_button_right">\
													<div class="text_add_content_cancel" data-val="'+val+'">キャンセル</div>\
													</div>\
												</div>\
											</div> <!-- text_add_content -->\
										</div> <!-- text_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////
			// 見出しの場合
			///////////////
			case 'matome_content_block_title':
			var val = $(this).parents('.matome_content_block').find('.h2_heading_1').html();
			$(this).parents('.matome_content_block').before('<div class="title_add">\
	<div class="title_add_content">\
		<textarea placeholder="テキストを入力">'+val+'</textarea>\
		<div class="title_add_content_button clearfix">\
			<div class="title_add_content_button_left">\
				<div class="title_add_content_submit">保存</div>\
			</div>\
			<div class="title_add_content_button_right">\
				<div class="title_add_content_cancel" data-val="'+val+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- title_add_content -->\
</div> <!-- title_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////
			// 引用の場合
			/////////////
			case 'matome_content_block_quote':
				// 引用抽出
				var quote = $(this).parents('.matome_content_block').find('.matome_content_block_quote').find('pre').html();
				var url   = $(this).parents('.matome_content_block').find('.matome_content_block_quote').find('a').attr('href');
				var title = $(this).parents('.matome_content_block').find('.matome_content_block_quote').find('a').html();
				var word  = $(this).parents('.matome_content_block').find('.matome_content_block_quote').find('.author_word').html();
			// <、>をエンティティに変換する
			quote = text_entity_conversion(quote);

				$(this).parents('.matome_content_block').before('<div class="quote_add">\
	<div class="quote_add_content">\
		<textarea class="quote_add_content_quote" placeholder="引用を入力">'+quote+'</textarea>\
		<input type="text" class="quote_add_content_url" value="'+url+'" placeholder="引用の出典元URLを入力(ウェブページの場合)フォーカスを外すと自動でタイトルが入力されます">\
		<input type="text" class="quote_add_content_title" value="'+title+'" placeholder="引用の出典を入力">\
		<textarea class="quote_add_content_word" placeholder="引用の紹介コメントを入力">'+word+'</textarea>\
		<div class="quote_add_content_button clearfix">\
			<div class="quote_add_content_button_left">\
				<div class="quote_add_content_submit">保存</div>\
			</div>\
			<div class="quote_add_content_button_right">\
				<div class="quote_add_content_cancel" data-val="'+quote+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- quote_add_content -->\
</div> <!-- quote_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////
			// 見出しの場合 重複しています 修正する必要あり 2015.05.30 松岡
			///////////////
			case 'matome_content_block_title':
			var val = $(this).parents('.matome_content_block').find('.heading_5').html();
			$(this).parents('.matome_content_block').before('<div class="title_add">\
	<div class="title_add_content">\
		<textarea placeholder="テキストを入力">'+val+'</textarea>\
		<div class="title_add_content_button clearfix">\
			<div class="title_add_content_button_left">\
				<div class="title_add_content_submit">保存</div>\
			</div>\
			<div class="title_add_content_button_right">\
				<div class="title_add_content_cancel" data-val="'+val+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- title_add_content -->\
</div> <!-- title_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			////////////////
			// Twitterの場合
			////////////////
			case 'matome_content_block_twitter':
				// Tweet抽出
				var tweet_html = $(this).parents('.matome_content_block').find('.matome_content_block_twitter').find('.tweet').selfHtml();
				var word  = $(this).parents('.matome_content_block').find('.matome_content_block_twitter').find('.author_word').html();
				var check = true;
				$(this).parents('.matome_content_block').before('<div class="twitter_add">\
	<div class="twitter_add_content">\
			'+tweet_html+'\
		<textarea placeholder="Tweetの紹介コメントを入力" class="twitter_add_content_word">'+word+'</textarea>\
		<div class="twitter_add_content_button clearfix">\
			<div class="twitter_add_content_button_left">\
				<div class="twitter_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="twitter_add_content_button_right">\
				<div class="twitter_add_content_cancel" data-val="'+check+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- twitter_add_content -->\
</div>	<!-- twitter_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////
			// 動画の場合
			/////////////
			case  'matome_content_block_video':
				// video抽出
				var video_html = $(this).parents('.matome_content_block').find('.video').selfHtml();
				var word       = $(this).parents('.matome_content_block').find('.author_word').html();
				var check = true;
				$(this).parents('.matome_content_block').before('<div class="video_add">\
	<div class="video_add_content">\
			'+video_html+'\
		<textarea class="video_add_content_word" placeholder="動画の紹介コメントを入力">'+word+'</textarea>\
		<div class="video_add_content_button clearfix">\
			<div class="video_add_content_button_left">\
				<div class="video_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="video_add_content_button_right">\
				<div class="video_add_content_cancel" data-val="'+check+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- video_add_content -->\
</div> <!-- video_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////
			// 画像の場合
			/////////////
			case 'matome_content_block_image':
				// image抽出
				var image_url   = $(this).parents('.matome_content_block').find('.article_content_left p a').attr('href');
				var image_title = $(this).parents('.matome_content_block').find('.article_content_right h3').html();
				var image_word  = $(this).parents('.matome_content_block').find('.article_content_right pre').html();
				var image_title = $(this).parents('.matome_content_block').find('.article_content_right h3').html();
				var image_word  = $(this).parents('.matome_content_block').find('.article_content_right pre').html();
				var quote_url   = $(this).parents('.matome_content_block').find('.article_content_left .image_quote a').attr('href');
				var quote_title = $(this).parents('.matome_content_block').find('.article_content_left .image_quote a').html();
				var check = true;
				if(quote_url == undefined) {
					quote_url = '';
				}
				if(quote_title == undefined) {
					quote_title = '';
				}
				$(this).parents('.matome_content_block').before('<div class="image_add clearfix">\
	<div class="image_add_content">\
		<div class="image_add_content_left">\
			<div class="great_image_set_100">\
				<p class="m_0">\
					<a href="'+image_url+'" target="_blank">\
						<img width="640" height="400" title="'+image_title+'" alt="'+image_title+'" src="'+image_url+'" class="o_8">\
					</a>\
				</p>\
			</div>\
		</div>\
		<div class="image_add_content_right clearfix">\
			<input type="text" value="'+image_title+'" placeholder="画像のタイトルを入力" class="image_add_content_title">\
			<textarea placeholder="画像の紹介コメントを入力" class="image_add_content_word">'+image_word+'</textarea>\
			<input type="text" placeholder="引用の出典元URLを入力 フォーカスを外すと自動でタイトルが入力されます" value="'+quote_url+'" class="image_add_content_quote_url">\
			<input type="text" placeholder="引用の出典を入力" value="'+quote_title+'" class="image_add_content_quote_title">\
		</div>\
		<div class="image_add_content_button clearfix">\
			<div class="image_add_content_button_left">\
				<div class="image_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="image_add_content_button_right">\
				<div class="image_add_content_cancel" data-val="'+check+'">キャンセル</div>\
			</div>\
		</div>\
	</div>\
	<!-- image_add_content -->\
</div>');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////
			// リンクの場合
			///////////////
			case 'matome_content_block_link':
				// コンテンツ抽出
				var image_url   = $(this).parents('.matome_content_block').find('.matome_content_block_link_title a').attr('href');
				var image_title = $(this).parents('.matome_content_block').find('.matome_content_block_link_title a').html();
				var image_description = $(this).parents('.matome_content_block').find('.matome_content_block_link_description').html();
				var image_word = $(this).parents('.matome_content_block').find('.matome_content_block_link_word').html();
				var check = true;
				$(this).parents('.matome_content_block').before('<div class="link_add">\
	<div class="link_add_content">\
		<div class="matome_content_block_link" style="margin: 0;">\
			<p class="matome_content_block_link_title">\
				<a href="'+image_url+'" target="_blank">'+image_title+'</a>\
			</p>\
			<p class="matome_content_block_link_url">\
				<a href="'+image_url+'" target="_blank">'+image_url+'</a>\
			</p>\
			<p class="matome_content_block_link_description">\
				'+image_description+'\
			</p>\
		</div>\
		<textarea placeholder="リンクの紹介コメントを入力" class="link_add_content_word">'+image_word+'</textarea>\
		<div class="link_add_content_button clearfix">\
			<div class="link_add_content_button_left">\
				<div class="link_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="link_add_content_button_right">\
				<div class="link_add_content_cancel" data-val="'+check+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- link_add_content -->\
</div> <!-- link_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////
			// Amazonの場合
			///////////////
			case 'matome_content_block_amazon':
				// コンテンツ抽出
				var amazon_title      = $(this).parents('.matome_content_block').find('.amazon_link h3 a').html();
				var amazon_url        = $(this).parents('.matome_content_block').find('.amazon_link_detail a').attr('href');
				var amazon_imagelink  = $(this).parents('.matome_content_block').find('.amazon_link_image').html();
				var amazon_textlink   = $(this).parents('.matome_content_block').find('.amazon_link_text').html();

				// urlのみ取得
				amazon_textlink  = amazon_textlink.match(/href="(.+?)"/);
				amazon_textlink = amazon_textlink[1];

			// <、>をエンティティに変換する
				amazon_title     = text_entity_conversion(amazon_title);
				amazon_url       = text_entity_conversion(amazon_url);
				amazon_imagelink = text_entity_conversion(amazon_imagelink);
				amazon_textlink  = text_entity_conversion(amazon_textlink);

				var check = true;
				$(this).parents('.matome_content_block').before('<div class="amazon_add">\
			<div class="amazon_add_content">\
				<input type="text" placeholder="商品タイトルを入力" value="'+amazon_title+'" class="amazon_add_content_title">\
				<textarea placeholder="テキスト商品リンクHTMLを入力" class="amazon_add_content_textlink">'+amazon_textlink+'</textarea>\
				<textarea placeholder="画像商品リンクHTMLを入力" class="amazon_add_content_imagelink">'+amazon_imagelink+'</textarea>\
				<div class="amazon_add_content_button clearfix">\
					<div class="amazon_add_content_button_left">\
						<div class="amazon_add_content_submit" data-check="'+check+'">保存</div>\
					</div>\
					<div class="amazon_add_content_button_right">\
						<div class="amazon_add_content_cancel" data-check="'+check+'">キャンセル</div>\
					</div>\
				</div>\
			</div> <!-- amazon_add_content -->\
		</div>');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////////
			// timelineの場合
			/////////////////
			case 'matome_content_block_timeline':
				// 使用するarray
				connection_array = [];
				pointline_array  = [];
				title_array      = [];
				content_array    = [];
				// コンテンツ抽出
				var timeline_li      = $(this).parents('.matome_content_block').find('.matome_content_block_timeline li');
				// コンテンツ抽出
				timeline_li.each(function(count) {
					// コンテンツ選別
					if($(this).attr('class') == 'connection clearfix') {
						// データ取得
						connection_data    = $(this).find('span').html();
						// <、>をエンティティに変換する
						connection_data = text_entity_conversion(connection_data);
//						p(connection_data);
						// arrayにプッシュ
						connection_array.push(connection_data);
					}
						else {
							// データ取得
							pointline_data = $(this).find('dl dt pre').html();
							title_data     = $(this).find('dl dd h3').html();
							content_data   = $(this).find('dl dd pre').html();
							// <、>をエンティティに変換する
							pointline_data = text_entity_conversion(pointline_data);
							title_data     = text_entity_conversion(title_data);
							content_data   = text_entity_conversion(content_data);
/*
							p(pointline_data);
							p(title_data);
							p(content_data);
*/
							// arrayにプッシュ
							pointline_array.push(pointline_data);
							title_array.push(title_data);
							content_array.push(content_data);
						}
				}); // timeline_li.each(function(count) {
				timeline_length = content_array.length;
				var textarea_html = '';
				for(var i=0;i<timeline_length;i++) {
					textarea_html = textarea_html+'<connection>'+connection_array[i]+'</connection>'+'\n'+'<pointline>'+pointline_array[i]+'</pointline>'+'\n'+'<title>'+title_array[i]+'</title>'+'\n'+'<content>'+content_array[i]+'</content>\n\n';
				}
				var check = true;
				// <、>をエンティティに変換する
				textarea_html_val = text_entity_conversion(textarea_html);

				$(this).parents('.matome_content_block').before('<div class="timeline_add">\
	<div class="timeline_add_content">\
		<textarea placeholder="タイムラインを入力">\
'+textarea_html+'\
</textarea>\
		<div class="timeline_add_content_button clearfix">\
			<div class="timeline_add_content_button_left">\
				<div class="timeline_add_content_submit" data-check="'+check+'">保存</div>\
			</div>\
			<div class="timeline_add_content_button_right">\
			<div class="timeline_add_content_cancel" data-check="'+check+'" data-val="'+textarea_html_val+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- timeline_add_content -->\
</div> <!-- timeline_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////////
			// 見出し画像の場合
			///////////////////
			case 'matome_content_block_heading_image':
					//下書きを保存しました表示
					swal({
					  title: "見出し画像は編集できません",
					  text: "メッセージは1秒後に消えます",
					  timer: 1200,
					  showConfirmButton: false
					});
			break;

			///////////////
			// コードの場合
			///////////////
			case 'matome_content_block_code':
			var val = $(this).parents('.matome_content_block').find('code').html();
			val = text_entity_conversion(val);
			// エンティティーを戻す
			val_return = text_entity_return(val);
			$(this).parents('.matome_content_block').before('<div class="code_add">\
	<div class="code_add_content">\
		<textarea placeholder="コードを書く">'+val_return+'</textarea>\
		<div class="code_add_content_button clearfix">\
			<div class="code_add_content_button_left">\
				<div class="code_add_content_submit">保存</div>\
			</div>\
			<div class="code_add_content_button_right">\
			<div class="code_add_content_cancel" data-val="'+val+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- code_add_content -->\
</div> <!-- code_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			///////////////////
			// iTunes_Appの場合
			///////////////////
			case 'matome_content_block_itunes_app':
				// word抽出
				var matome_content_block_itunes_app_word = $(this).parents('.matome_content_block').find('.matome_content_block_itunes_app_word pre').html();
				// word削除
				$(this).parents('.matome_content_block').find('.matome_content_block_itunes_app_word').remove();
				// コンテンツ抽出
				var matome_content_block_itunes_app_html = $(this).parents('.matome_content_block').find('.matome_content_block_itunes_app').selfHtml();
				var check = true;

			$(this).parents('.matome_content_block').before('<div class="itunes_app_add">\
					<div class="itunes_app_add_content">\
						'+matome_content_block_itunes_app_html+'\
						<textarea class="itunes_app_add_content_word" placeholder="iTunes_Appの紹介コメントを入力">'+matome_content_block_itunes_app_word+'</textarea>\
						<div class="itunes_app_add_content_button clearfix">\
							<div class="itunes_app_add_content_button_left">\
								<div class="itunes_app_add_content_submit" data-check="'+check+'">保存</div>\
							</div>\
							<div class="itunes_app_add_content_button_right">\
								<div class="itunes_app_add_content_cancel" data-check="'+check+'">キャンセル</div>\
							</div>\
						</div>\
					</div> <!-- itunes_app_add_content -->\
				</div> <!-- itunes_app_add -->');
				$(this).parents('.matome_content_block').remove();
			break;

			///////////////
			// ballonの場合
			///////////////
			case 'matome_content_block_ballon':
			var val = $(this).parents('.matome_content_block').find('pre').html();
			// <、>をエンティティに変換する
			val = text_entity_conversion(val);

			$(this).parents('.matome_content_block').before('<div class="ballon_add">\
	<div class="ballon_add_content">\
		<textarea placeholder="吹き出しテキストを入力">'+ val +'</textarea>\
		<div class="ballon_add_content_button clearfix">\
			<div class="ballon_add_content_button_left">\
				<div class="ballon_add_content_submit">保存</div>\
			</div>\
			<div class="ballon_add_content_button_right">\
			<div class="ballon_add_content_cancel" data-val="'+val+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- ballon_add_content -->\
</div> <!-- ballon_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////////
			// enclosedの場合
			/////////////////
			case 'matome_content_block_enclosed':
			var val = $(this).parents('.matome_content_block').find('pre').html();
			// <、>をエンティティに変換する
			val = text_entity_conversion(val);

			$(this).parents('.matome_content_block').before('<div class="enclosed_add">\
	<div class="enclosed_add_content">\
		<textarea placeholder="囲みテキストを入力">'+ val +'</textarea>\
		<div class="enclosed_add_content_button clearfix">\
			<div class="enclosed_add_content_button_left">\
				<div class="enclosed_add_content_submit">保存</div>\
			</div>\
			<div class="enclosed_add_content_button_right">\
			<div class="enclosed_add_content_cancel" data-val="'+val+'">キャンセル</div>\
			</div>\
		</div>\
	</div> <!-- enclosed_add_content -->\
</div> <!-- enclosed_add -->');
				$(this).parents('.matome_content_block').remove();
			break;
			/////////////////////////
			// アマゾンレビューの場合
			/////////////////////////
			case 'matome_content_block_amazon_review':
				// アラート表示
				swal({
				  title: "Amazonレビューは現在のところ編集できません",
				  text: "メッセージは1秒後に消えます",
				  timer: 1200,
				  showConfirmButton: false
				});
			break;


		}  //switch(class_neme) {
		// 修正時にtextareaを広げる
		event_textarea = $('textarea');
		event_textarea.autosize();
	},
}, '.edit');
/*****************
アイテムリスト変更
*****************/
$('.item_add').on( {
	'click': function() {
		$('.item_add').html(
			'<div class="item_add_content clearfix">\
				<span class="item_add_content_title"><span class="typcn typcn-plus"></span>アイテムを追加</span>\
				<ul class="item_add_content_list">\
					<li class="item_add_content_list_ballon">吹き出し</li>\
					<li class="item_add_content_list_enclosed">囲み</li>\
					<li class="item_add_content_list_timeline">タイムライン</li>\
					<li class="item_add_content_list_heading_image">見出し画像</li>\
					<li class="item_add_content_list_itunes_app">iTunes_App</li>\
					<li class="item_add_content_list_change_2"><span class="typcn typcn-arrow-repeat"></span></li>\
				</ul>\
			</div> <!-- item_add_content -->');
	},
}, '.item_add_content_list_change');
/******************
アイテムリスト変更2
******************/
$('.item_add').on( {
	'click': function() {
		$('.item_add').html(
			'<div class="item_add_content clearfix">\
				<span class="item_add_content_title"><span class="typcn typcn-plus"></span>アイテムを追加</span>\
				<ul class="item_add_content_list">\
					<li class="item_add_content_list_amazon">Amazon</li>\
					<li class="item_add_content_list_amazon_review">Amazonレビュー</li>\
					<li class="item_add_content_list_code">コード</li>\
					<li class="item_add_content_list_change_3"><span class="typcn typcn-arrow-repeat"></span></li>\
				</ul>\
			</div> <!-- item_add_content -->');
	},
}, '.item_add_content_list_change_2');
/******************
アイテムリスト変更3
******************/
$('.item_add').on( {
	'click': function() {
		$('.item_add').html(
			'<div class="item_add_content clearfix">\
				<span class="item_add_content_title"><span class="typcn typcn-plus"></span>アイテムを追加</span>\
				<ul class="item_add_content_list">\
					<li class="item_add_content_list_link">リンク</li>\
					<li class="item_add_content_list_image">画像</li>\
					<li class="item_add_content_list_video">動画</li>\
					<li class="item_add_content_list_quote">引用</li>\
					<li class="item_add_content_list_twitter">Twitter</li>\
					<li class="item_add_content_list_text">テキスト</li>\
					<li class="item_add_content_list_title">見出し</li>\
					<li class="item_add_content_list_change"><span class="typcn typcn-arrow-repeat"></span></li>\
				</ul>\
			</div> <!-- item_add_content -->');
	},
}, '.item_add_content_list_change_3');




/**************
ツールバー 削除
**************/
$('.matome').on( {
	'click': function() {
		var class_name = $(this).parents('.matome_content_block').next().attr('class');
		if(class_name == 'item_add_between') {
			// ヴィトウィーン削除
			$(this).parents('.matome_content_block').next().remove();
		}
		// 削除
		$(this).parents('.matome_content_block').remove();
		// カウント文字数変更関数
		text_count_tool_change();
	},
}, '.delete');
/**********************
ツールバー 移動(一つ下)
**********************/
$('.matome').on( {
	'click' : function() {
		if(!$(this).hasClass('off')) {
			var item_add_between = $(this).parents('.matome_content_block').next();
			$(this).parents('.matome_content_block').next().next().next().after($(this).parents('.matome_content_block'));
			$(this).parents('.matome_content_block').after(item_add_between);
			var toolbar = $(this).parents('.matome_content_block').find('.toolbar');
			var editbar = $(this).parents('.matome_content_block').find('.editbar');
			toolbar.remove();
			editbar.remove();
		}
	},
}, '.down');
/**********************
ツールバー 移動(一つ上)
**********************/
$('.matome').on( {
	'click' : function() {
		if(!$(this).hasClass('off')) {
			var item_add_between = $(this).parents('.matome_content_block').next();
			$(this).parents('.matome_content_block').prev().prev().before($(this).parents('.matome_content_block'));
			$(this).parents('.matome_content_block').after(item_add_between);
			var toolbar = $(this).parents('.matome_content_block').find('.toolbar');
			var editbar = $(this).parents('.matome_content_block').find('.editbar');
			toolbar.remove();
			editbar.remove();
		}
	},
}, '.up');
/**********************
ツールバー 移動(一番上)
**********************/
$('.matome').on( {
	'click' : function() {
		if(!$(this).hasClass('off')) {
			var item_add_between = $(this).parents('.matome_content_block').next();
			$(this).parents('.matome_content').prepend(item_add_between);
			$(this).parents('.matome_content').prepend($(this).parents('.matome_content_block'));
			var toolbar = $(this).parents('.matome_content_block').find('.toolbar');
			var editbar = $(this).parents('.matome_content_block').find('.editbar');
			toolbar.remove();
			editbar.remove();
		}
	},
}, '.top');
/**********************
ツールバー 移動(一番下)
**********************/
$('.matome').on( {
	'click' : function() {
		if(!$(this).hasClass('off')) {
			var item_add_between = $(this).parents('.matome_content_block').next();
			$(this).parents('.matome_content').append($(this).parents('.matome_content_block'));
			$(this).parents('.matome_content').append(item_add_between);
			var toolbar = $(this).parents('.matome_content_block').find('.toolbar');
			var editbar = $(this).parents('.matome_content_block').find('.editbar');
			toolbar.remove();
			editbar.remove();
		}
	},
}, '.bottom');
/*********************
アイテム追加ツール生成
**********************/
$('.matome').on( {
	'click' : function() {
		$(this).parents('.item_add_between').before('<!-- item_between_add -->\
								<div class="item_between_add">\
									<div class="item_between_add_content clearfix">\
										<span class="item_between_add_content_title"><span class="typcn typcn-plus"></span>アイテムを追加</span>\
										<span class="item_between_add_content_cancel"><span class="typcn typcn-times"></span></span>\
										<span class="item_between_add_content_list_change"><span class="typcn typcn-arrow-repeat"></span></span>\
										<ul class="item_between_add_content_list">\
											<li class="item_between_add_content_list_link">リンク</li>\
											<li class="item_between_add_content_list_image">画像</li>\
											<li class="item_between_add_content_list_video">動画</li>\
											<li class="item_between_add_content_list_quote">引用</li>\
											<li class="item_between_add_content_list_twitter">Twitter</li>\
											<li class="item_between_add_content_list_text">テキスト</li>\
											<li class="item_between_add_content_list_title">見出し</li>\
										</ul>\
									</div> <!-- item_between_add_content -->\
								</div> <!-- item_between_add -->');
		$(this).parents('.item_add_between').remove();
	},
}, '.item_add_between_content');
/**********************
アイテム追加ツール変更1
**********************/
$('.matome').on( {
	'click': function() {
		$(this).parents('.item_between_add').html(
			'<div class="item_between_add_content clearfix">\
				<span class="item_between_add_content_title"><span class="typcn typcn-plus"></span>アイテムを追加</span>\
				<span class="item_between_add_content_cancel"><span class="typcn typcn-times"></span></span>\
				<span class="item_between_add_content_list_change_2"><span class="typcn typcn-arrow-repeat"></span></span>\
				<ul class="item_between_add_content_list">\
					<li class="item_between_add_content_list_ballon">吹き出し</li>\
					<li class="item_between_add_content_list_enclosed">囲み</li>\
					<li class="item_between_add_content_list_timeline">タイムライン</li>\
					<li class="item_between_add_content_list_heading_image">見出し画像</li>\
					<li class="item_between_add_content_list_itunes_app">iTunes_App</li>\
				</ul>\
			</div> <!-- item_between_add_content -->');
	}
}, '.item_between_add_content_list_change');
/**********************
アイテム追加ツール変更2
**********************/
$('.matome').on( {
	'click': function() {
		$(this).parents('.item_between_add').html(
			'<div class="item_between_add_content clearfix">\
				<span class="item_between_add_content_title"><span class="typcn typcn-plus"></span>アイテムを追加</span>\
				<span class="item_between_add_content_cancel"><span class="typcn typcn-times"></span></span>\
				<span class="item_between_add_content_list_change_3"><span class="typcn typcn-arrow-repeat"></span></span>\
				<ul class="item_between_add_content_list">\
					<li class="item_between_add_content_list_amazon">Amazon</li>\
					<li class="item_between_add_content_list_amazon_review">Amazonレビュー</li>\
					<li class="item_between_add_content_list_code">コード</li>\
				</ul>\
			</div> <!-- item_between_add_content -->');
	}
}, '.item_between_add_content_list_change_2');
/**********************
アイテム追加ツール変更3
**********************/
$('.matome').on( {
	'click': function() {
		$(this).parents('.item_between_add').html(
			'<div class="item_between_add_content clearfix">\
				<span class="item_between_add_content_title"><span class="typcn typcn-plus"></span>アイテムを追加</span>\
				<span class="item_between_add_content_cancel"><span class="typcn typcn-times"></span></span>\
				<span class="item_between_add_content_list_change"><span class="typcn typcn-arrow-repeat"></span></span>\
				<ul class="item_between_add_content_list">\
					<li class="item_between_add_content_list_link">リンク</li>\
					<li class="item_between_add_content_list_image">画像</li>\
					<li class="item_between_add_content_list_video">動画</li>\
					<li class="item_between_add_content_list_quote">引用</li>\
					<li class="item_between_add_content_list_twitter">Twitter</li>\
					<li class="item_between_add_content_list_text">テキスト</li>\
					<li class="item_between_add_content_list_title">見出し</li>\
				</ul>\
			</div> <!-- item_between_add_content -->');
	}
}, '.item_between_add_content_list_change_3');








/**********************
アイテム追加ツール 削除
**********************/
$('.matome').on( {
	'click' : function() {
		$(this).parents('.item_between_add').after(item_add_between_html);
		$(this).parents('.item_between_add').remove();
	}
}, '.item_between_add_content_cancel');



/*****************************************
iTunes_Appの概要を表示チェックボックス変更
*****************************************/
$('.matome').on( {
	'click': function() {
		value = $('.itunes_app_add_content_check_box_description_input').attr('value');
		if(value == 1) {
			$('.itunes_app_add_content_check_box_description_input').attr( {
				'value': 0
			});
		}
			else {
			$('.itunes_app_add_content_check_box_description_input').attr( {
				'value': 1
			});
			}
	}
},'.itunes_app_add_content_check_box_description_input');

});