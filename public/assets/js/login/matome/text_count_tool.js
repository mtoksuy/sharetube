	//----------------------
	//カウント文字数変更関数
	//----------------------
	function text_count_tool_change() {
		setTimeout(function() {
			matome_content_block = $('.matome_content_block');
			// 変数
			count_text = '';
			// ぶん回し
			matome_content_block.each(function(index, element) {
				// クラスネーム取得(重要)
				element_class_name = $(this).children().attr('class');
				///////////////
				// リンクの場合
				///////////////
				if(element_class_name == 'matome_content_block_link') {
					link_author_text = $(this).find('.matome_content_block_link .matome_content_block_link_word').html();
					count_text = count_text+link_author_text; 
				}
				/////////////
				// 画像の場合
				/////////////
				if(element_class_name == 'matome_content_block_image') {
					image_h3_text  = $(this).find('.matome_content_block_image .article_content_right h3').html();
					image_pre_text = $(this).find('.matome_content_block_image .article_content_right pre').html();
					count_text = count_text+image_h3_text; 
					count_text = count_text+image_pre_text; 
				}
				/////////////
				// 動画の場合
				/////////////
				if(element_class_name == 'matome_content_block_video') {
					video_author_text = $(this).find('.matome_content_block_video .author_word').html();
					count_text = count_text+video_author_text; 
				}
				/////////////
				// 引用の場合
				/////////////
				if(element_class_name == 'matome_content_block_quote') {
					quote_text        = $(this).find('.matome_content_block_quote pre').html();
					quote_author_text = $(this).find('.matome_content_block_quote .author_word').html();
					count_text = count_text+quote_text; 
					count_text = count_text+quote_author_text; 
				}
				////////////////
				// Twitterの場合
				////////////////
				if(element_class_name == 'matome_content_block_twitter') {
					twitter_text        = $(this).find('.matome_content_block_twitter .tweet .tweet_content .tweet_content_text').text();
					twitter_author_text = $(this).find('.matome_content_block_twitter .author_word').html();
					count_text = count_text+twitter_text; 
					count_text = count_text+twitter_author_text; 
				}
				/////////////////
				// テキストの場合
				/////////////////
				if(element_class_name == 'matome_content_block_text') {
					text_text        = $(this).find('.matome_content_block_text pre').html();
					count_text = count_text+text_text; 
				}
				///////////////
				// 見出しの場合
				///////////////
				if(element_class_name == 'matome_content_block_title') {
					title_text        = $(this).find('.matome_content_block_title h2').html();
					count_text = count_text+title_text; 
				}
				/////////////////
				// 吹き出しの場合
				/////////////////
				if(element_class_name == 'matome_content_block_ballon') {
					ballon_text        = $(this).find('.matome_content_block_ballon pre').html();
					count_text = count_text+ballon_text; 
				}
				/////////////
				// 囲みの場合
				/////////////
				if(element_class_name == 'matome_content_block_enclosed') {
					enclosed_text        = $(this).find('.matome_content_block_enclosed pre').html();
					count_text = count_text+enclosed_text; 
				}
				/////////////////////
				// タイムラインの場合
				/////////////////////
				if(element_class_name == 'matome_content_block_timeline') {
					timeline_text        = $(this).find('.matome_content_block_timeline ol').text();
					count_text = count_text+timeline_text; 
				}
				///////////////////
				// iTunes_Appの場合
				///////////////////
				if(element_class_name == 'matome_content_block_itunes_app') {
					itunes_app_author_text = $(this).find('.matome_content_block_itunes_app .matome_content_block_itunes_app_word').html();
					count_text = count_text+itunes_app_author_text; 
				}
				///////////////////////
				// Amazonレビューの場合
				///////////////////////
				if(element_class_name == 'matome_content_block_amazon_review') {
					amazon_review_text = $(this).find('.matome_content_block_amazon_review ol').text();
					count_text = count_text+amazon_review_text; 
				}
				///////////////
				// コードの場合
				///////////////
				if(element_class_name == 'matome_content_block_code') {
					code_text = $(this).find('.matome_content_block_code pre code').text();
					count_text = count_text+code_text; 
				}
			}); // matome_content_block.each(function(index, element) {

			// 改行・タブを削除
			count_text = count_text.replace(/\r\n|\r|\n|\t/g, '');
			// カウント文字適応
			$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .count').html(count_text.length+'文字');

			if(count_text.length < 1000) {
				$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').text('低');
				$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').css( {
					'color' : '#4040df',
					'font-size'   : '100%',
				});
			}
				else if(count_text.length < 3000) {
					$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').text('中');
					$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').css( {
						'color' : '#00bf6f',
						'font-size'   : '110%',
					});
				}
					else if(count_text.length < 8000) {
						$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').text('高');
						$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').css( {
							'color' : '#ff3030',
							'font-size'   : '120%',
						});
					}
						else if(count_text.length < 12000) {
							$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').text('最高');
							$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').css( {
								'color' : '#ff0000',
								'font-size'   : '130%',
								'line-height' : '30%',
							});
						}
							else if(count_text.length < 15000) {
								$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').text('超絶');
								$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').css( {
									'color' : '#ef30ef',
									'font-size'   : '150%',
									'line-height' : '30%',
								});
							}
								else if(count_text.length < 20000) {
									$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').text('超絶');
									$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').css( {
										'color' : '#ef30ef',
										'font-size'   : '180%',
										'line-height' : '30%',
									});
								}
								else if(count_text.length > 20000) {
									$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').text('神');
									$('.text_count_tool').find('.text_count_tool_inner .text_count_tool_inner_count .rank').css( {
										'color'       : '#ffcd10',
										'font-size'   : '300%',
										'line-height' : '30%',
									});
								}
/**
低   1000以下
中   3000以下
高   8000以下
最高 120000以下
超絶 150000以下
神   200000以上
まとめ作成ツールにまとめの文字数カウンターを設置する
**/

		}, 500); // setTimeout(function() {
	}







//----------------
//読み込み後の処理
//----------------
$(function() {
	//----------------------
	//現在のまとめ文字数表示
	//----------------------
	$('.matome').on( {
		'change' : function() {
			// カウント文字数変更関数
			text_count_tool_change();
		} // 'change' : function() {
	}, '.matome_content');



//----------------
//ブラウザの大きさ
//----------------
$(window).width();
$(window).height();
//----------------------
//スクロールしている数値
//----------------------
$(window).scrollTop();
//------------
//一番底の数値
//------------
$('html').height();
});



/*******************
HTML読み込み後に処理
*******************/
$(window).load(function(){
	// カウント文字数変更関数
	text_count_tool_change();
});

