<?php
/*
* 
* 記事HTML関連クラス
* 
* 
* 
*/

class Model_Article_Html extends Model {
	//----------------
	//記事一覧HTML生成
	//----------------
	public static function list_html_create($list_query, $article_type = 'article') {
		// 変数
		$article_list_html_array = array();
		$article_list_html       = '';
		$i                       = 0;

		// 記事一覧HTML生成
		foreach($list_query as $key => $value) {
			// 記事データ取得
			$article_author       = $value["sharetube_id"];
			$unix_time            = strtotime($value["create_time"]);
			$local_time           = date('Y-m-d', $unix_time);
			$local_japanese_time  = date('Y年m月d日', $unix_time);
			$article_year_time    = date('Y', $unix_time);
			// エンティティを戻す
			$title        = htmlspecialchars_decode($value["title"], ENT_NOQUOTES);
			// カテゴリー情報取得
			$category_info_array = Model_Info_Basis::category_info_get($value["category"]);
			// ターゲット画像
			$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/detail/'.$value["thumbnail_image"]);
			// コピー元画像のファイルサイズを取得
			list($image_w, $image_h) = getimagesize($targetImage);
			// シェアボタンでエンコードして使う
			$encode_link           = (''.HTTP.''.$article_type.'/'.$value["link"].'/');
			// ソーシャルシェアボタンHTMl生成
			$social_share_html = Model_Article_Html::social_share_html_create($encode_link, $value, $article_type);
			// 記事一覧HTMLarry生成
			$article_list_html_array[$i] = ('
				<article class="article_list" data-article_number="'.$value["primary_id"].'">
					<div class="article_list_contents clearfix">
						<a href="'.HTTP.''.$article_type.'/'.$value["link"].'/">
							<h1>'.$title.'</h1>
						</a>
						<time datetime="'.$local_time.'" pubdate="pubdate">'.$local_japanese_time.'</time>
						<figure class="video clearfix">
							<div class="category_band '.$category_info_array["category_color"].'">'.$value["category"].'</div>
							'.$value["contents"].'
						</figure>
					</div>
						'.$social_share_html.'
				</article>');
			$i++;
		}
		// 記事一覧HTML合体
		foreach($article_list_html_array as $key => $value) {
			$article_list_html .= $value;
		}
		return $article_list_html;
	}
	//---------------------
	//itype記事一覧HTML生成
	//---------------------
	public static function itype_list_html_create($list_query, $article_type = 'article') {
		// 変数
		$article_list_html_array = array();
		$article_list_html       = '';
		$i                       = 0;

		// 記事一覧HTML生成
		foreach($list_query as $key => $value) {
			// 記事データ取得
			$article_author       = $value["sharetube_id"];
			$unix_time            = strtotime($value["create_time"]);
			$local_time           = date('Y-m-d', $unix_time);
			$local_japanese_time  = date('Y年m月d日', $unix_time);
			$article_year_time    = date('Y', $unix_time);

			// Sharetubeのユーザーデータ取得
			$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($article_author);

			// 改行を消す&タブ削除
			$article_contests = str_replace(array("\r\n", "\r", "\n", "\t"), '', $value["sub_text"].$value["text"]);
			// HTMLタグを取り除く
			$article_contests = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/', '', $article_contests);
			// 追加を取り除く
			$article_contests = preg_replace('/追加/', '', $article_contests);
//		var_dump($article_contests);
	
			// 本文を168文字に丸める
			$summary_contents = mb_strimwidth($article_contests, 0, 168, "...", 'utf8');
			// タイトルのエンティティを戻す
			$title        = htmlspecialchars_decode($value["title"], ENT_NOQUOTES);
			// タイトルを82文字に丸める
			$title = mb_strimwidth($title, 0, 82, "...", 'utf8');

			// カテゴリー情報取得
			$category_info_array = Model_Info_Basis::category_info_get($value["category"]);
			// ターゲット画像
			$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/square_120px/'.$value["thumbnail_image"]);
			// コピー元画像のファイルサイズを取得
			list($image_w, $image_h) = getimagesize($targetImage);
				$image_reito = ($image_h / $image_w);
				$new_image_h = (int)(200 * $image_reito);
			// シェアボタンでエンコードして使う
			$encode_link           = (''.HTTP.''.$article_type.'/'.$value["link"].'/');
			// ソーシャルシェアボタンHTMl生成
			$social_share_html = Model_Article_Html::social_share_html_create($encode_link, $value, $article_type);
			// 記事一覧HTMLarry生成
			$article_list_html_array[$i] = ('
					<li class="o_8">
						<article data-article_number="'.$value["primary_id"].'" data-article_year="'.$article_year_time.'">
							<a class="clearfix" href="'.HTTP.''.$article_type.'/'.$value["link"].'/">
								<div class="card_article_contents clearfix">
									<h1>'.$title.'</h1>
									<div class="card_article_contents_summary">'.$summary_contents.'</div>
									<div class="card_article_contents_author">'.$sharetube_user_data_array['name'].'さん</div>
									<div class="card_article_contents_time">'.$local_time.'</div>
								</div>
								<figure>
									<img class="" src="'.HTTP.'assets/img/'.$article_type.'/'.$article_year_time.'/square_120px/'.$value["thumbnail_image"].'" width="200" height="'.$new_image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
								</figure>
								<div class="category_band '.$category_info_array["category_color"].'">'.$value["category"].'</div>
							</a>
						</article>
					</li>');
			$i++;
		}
		// 記事一覧HTML合体
		foreach($article_list_html_array as $key => $value) {
			$article_list_html .= $value;
		}
		// 空なら空で返す
		if(!$article_list_html == '') {
			$article_list_html = ('
				<div class="card_article">
					<div class="card_article_content">
	<!--
						<div class="card_article_header">
							新着記事
						</div>
	-->
						<ul class="clearfix">
							'.$article_list_html.'
						</ul>
					</div>
				</div>');
		}
		return $article_list_html;
	}
	//--------------
	//記事のHTML生成
	//--------------
	static function article_html_create($article_res, $article_type = 'article', $preview_frg = false) {
//		var_dump($preview_frg);
		// 変数
		$article_data_array = '';
		// モバイルからのアクセスなのかどうかを調べる
		$user_is_mobil = Model_Info_Basis::mobil_is_access_check();
		// モバイル専用の広告を差し込む（モバイルでなかったら何も差し込まない）
		$amoad_html = Model_Article_Html::mobil_article_amoad($user_is_mobil, 0, 15, 15);
		// 広告配信
		$detect  = Model_info_Basis::mobile_detect_create();
		$ad_html = Model_Ad_Html::ad_html_create($detect, 'geniee','レクタングル');
		// Fluct広告
		$ad_middle_left_html   = Model_Ad_Html::fluct_ad_html_create($detect, 'ミドル左', 'ミドル_1');
		$ad_middle_right_html  = Model_Ad_Html::fluct_ad_html_create($detect, 'ミドル右', 'none');
		$ad_article_under_html = Model_Ad_Html::fluct_ad_html_create($detect, '記事下', 'ミドル_2');

		// 記事内トップ広告分け
		if($detect->isMobile()) {
			$article_top_ad_html = '<div class="m_t_15 m_b_15 text_center">
				'.$ad_middle_left_html.'
			</div>';
		}
			else if($detect->isTablet()) {

			}
				else {
					$article_top_ad_html = 
						'<div class="m_t_15 m_b_30 text_center clearfix">
								<div style="float: left; margin: 0 30px 0 17px;">
									'.$ad_middle_left_html.'
								</div>
								<div style="float: left;">
									'.$ad_middle_right_html.'
								</div>
						</div>';
				}
		// 記事内ボトム広告分け
		if($detect->isMobile()) {
			$article_under_ad_html = '<div class="m_t_30 m_b_30 text_center">
				'.$ad_article_under_html.'
			</div>';
		}
			else if($detect->isTablet()) {

			}
				else {
					$article_under_ad_html = '
						<div class="m_t_30 m_b_30 text_center clearfix">
							<div style="float: left; margin: 0 30px 0 17px;">

<script type="text/javascript"><!--
amazon_ad_tag = "sharetube-22"; amazon_ad_width = "300"; amazon_ad_height = "250"; amazon_ad_link_target = "new"; amazon_ad_border = "hide";//--></script>
<script type="text/javascript" src="http://ir-jp.amazon-adsystem.com/s/ads.js"></script>

							</div>
							<div style="float: left;">
								'.$ad_article_under_html.'
							</div>
						</div>';
				}
		// PCユーザーのみキュレーター募集をかける
		if($detect->isMobile()) {

		}
			else if($detect->isTablet()) {

			}
				else {
					$curator_recruitment_html = '<div class="curator_recruitment o_8">
<a href="http://sharetube.jp/curatorrecruitment/" target="blank">
		<div  class="curator_recruitment_content">
			<h3><span class="typcn typcn-pencil"></span>
				Sharetubeはキュレーター募集をしています
			</h3>
			<p class="m_0">業界No.1のインセンティブ、誰でも簡単にまとめれる「まとめツール」があります。</p>
			<p class="m_0">好きな情報をまとめて情報発信したい方、お小遣い稼ぎしたい方</p>
			<p class="m_0">まとめを作成してみませんか？</p>	
		</div>
	</a>
	</div>';
					$curator_recruitment_html = '';
				}
		// 記事HTML生成
		foreach($article_res as $key => $value) {
			// 記事のprimary_id取得
			$article_primary_id   = $value["primary_id"];
			// 記事作成者取得
			$article_author       = $value["sharetube_id"];
			// 記事作成者データ取得
			$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($value["sharetube_id"]);

			// 記事作成時間取得
			$creation_time        = $value["create_time"];
			$unix_time            = strtotime($value["create_time"]);
			$year_time            = date('Y', $unix_time);
			$local_time           = date('Y-m-d', $unix_time);
			$local_japanese_time  = date('Y年m月d日', $unix_time);
			$article_year_time    = date('Y', $unix_time);
			// 記事タイトル取得 // エンティティを戻す
			$article_title        = htmlspecialchars_decode($value["title"], ENT_NOQUOTES); // ダブルクォート、シングルクォートの両方をそのままにします。
			// 記事動画取得
			$article_value        = $value["contents"];
			// 記事HTMLテキスト取得
			$article_contents     = $value["sub_text"].$value["text"];
			// リンク取得
			$article_link         = $value["link"];
			// オリジナルタイトル取得
			$original             = $value["original"];
			// 記事サムネイルネーム取得
			$article_thumbnail_image = $value["thumbnail_image"];
			// カテゴリー情報取得
			$category_info_array = Model_Info_Basis::category_info_get($value["category"]);
			// コンテンツHTML生成
			$contents_html = Model_Article_Html::contents_html_create($value, $category_info_array);
			// サムネイルHTML生成
			$thumbnail_html = Model_Article_Html::thumbnail_html_create($value, $year_time, $preview_frg);
			// アーティクルボトムライクボックスHTML生成
			$article_bottom_like_box_html = Model_Article_Html::article_bottom_like_box_html_create($value, $year_time, $preview_frg);

			// タグHTML生成
			list($tag_array, $tag_html) = Model_Article_Html::article_tag_html_create($value["tag"], 3600);
//			var_dump($tag_array);
//			var_dump($tag_html);
			// オリジナルHTML生成
			$original_html = Model_Article_Html::original_html_create($original);
			// 筆者HTML生成
			$author_html = Model_Article_Html::author_html_create($sharetube_user_data_array);
			// ソーシャルシェアボタンリストHTML生成
			$social_share_share_button_html = Model_Article_Html::social_share_share_button_html_create($value, $article_type);
			
//			var_dump($sharetube_user_data_array);

			// シェアボタンでエンコードして使う
			$encode_link           = (''.HTTP.''.$article_type.'/'.$value["link"].'/');
			// ソーシャルシェアボタンHTMl生成
			$social_share_html     = Model_Article_Html::social_share_html_create($encode_link, $value, $article_type);
			$social_array          = array('twitter','facebook');
			$social_share_uri_scheme_html = Model_Article_Html::social_share_uri_scheme_html_create($encode_link, $value,$social_array, 'right');

			// Facebokページをいいね!するように促すHTML生成
			$facebook_like_please_html = Model_Article_Html::facebook_like_please_html_create();
			// 筆者のプロフィールHTML生成
			$author_profile_html = Model_Article_Html::author_profile_html_create($sharetube_user_data_array);

			$related_data_array = array(
				'article_primary_id'      => (int)$article_primary_id,
				'tag_array'               => $tag_array,
			);

//			var_dump($related_data_array);
			// 関連記事データ取得
			list($related_res, $related_count) = Model_Article_Basis::article_related_get($related_data_array, 'article');
			// 関連記事HTML生成
			$related_html                      = Model_Article_Html::article_inside_related_html_create($related_res, $related_count);
//		var_dump($related_html);

			// 前の記事、次の記事HTML生成
			$detail_press_bottom_html = Model_Article_Html::article_previous_next_html_create($article_primary_id, $article_type);

			// まとめ記事の場合(重要)
			if($value["matome_frg"] == 1) {
				// まとめコンテンツリストHTML取得
				$value["sub_text"] = Model_Login_Matome_Preview_Basis::matome_content_block_list_html_get($value["sub_text"]);
			}
			// 記事HTML生成
			$article_html = ('
				<article class="article_list" data-article_number="'.$value["primary_id"].'" data-article_year="'.$year_time.'">
					<div class="article_list_contents">
						<a href="'.HTTP.''.$article_type.'/'.$value["link"].'/">
							<h1>'.$value["title"].'</h1>
						</a>
						'.$tag_html.'
						'.$original_html.'
						'.$author_html.'
						<div class="release_date_time">
							<span class="typcn typcn-watch"></span><span>Release Date：</span><time datetime="'.$local_time.'" pubdate="pubdate">'.$local_japanese_time.'</time>
						</div>
						'.$social_share_share_button_html.'
						'.$thumbnail_html.'
						'.$article_top_ad_html.'
						<div class="article_list_contents_sub_text">
							'.$curator_recruitment_html.'
							'.$value["sub_text"].'
						</div>
							'.$contents_html.'
							'.$value["text"].'
					</div>
					<!-- シェアボタン -->
					'.$social_share_uri_scheme_html.'
					<!-- Facebookライクボックス -->
					'.$article_bottom_like_box_html.'
					<!-- 広告配信 -->
					'.$article_under_ad_html.'
					<!-- 宣伝 -->
					'.$facebook_like_please_html.'
					<!-- キュレータープロフィール -->
					'.$author_profile_html.'
					'.$related_html.'
					'.$detail_press_bottom_html.'
				</article>
');
			// article_data_array
			$article_data_array = array(
				'article_primary_id'      => (int)$article_primary_id,
				'article_html'            => $article_html, 
				'article_title'           => $article_title, 
				'article_value'           => $article_value, 
				'article_contents'        => $article_contents,
				'article_link'            => $article_link, 
				'article_year_time'       => $article_year_time, 
				'article_thumbnail_image' => $article_thumbnail_image, 
				'tag_array'               => $tag_array,
				'social_share_html'       => $social_share_html,
			);
		}
		return $article_data_array;
	}  // function article_html_create() {
	//------------------
	//コンテンツHTML生成
	//------------------
	static function contents_html_create($value, $category_info_array) {
		if($value["contents"] == '') {
//			$contents_html = ('<img class="article_thumbnail_image" width="640" height="400" title="'.$title.'" alt="'.$title.'" src="'.HTTP.'assets/img/article/'.$year_time.'/facebook_ogp/'.$article_thumbnail_image.'">');
			$contents_html = '';
		}
			else {
				$contents_html = 
					'<figure class="video">
						<div class="category_band '.$category_info_array["category_color"].'">
							'.$category_info_array["category_name"].'
						</div>
						'.$value["contents"].'
					</figure>';
			}
		return $contents_html;
	}
	//------------------
	//サムネイルHTML生成
	//------------------
	static function thumbnail_html_create($value, $year_time, $preview_frg) {
//		var_dump($value);
		switch($preview_frg) {
			case false:
				$draft = '';
			break;
			case true:
				$draft = 'draft/';
			break;
			default:

			break;
		}
			$thumbnail_html = ('
				<div class="article_thumbnail">
					<img class="great_image_100 m_b_15" width="640" height="400" title="'.$value["title"].'" alt="'.$value["title"].'" src="'.HTTP.'assets/img/'.$draft.'article/'.$year_time.'/facebook_ogp_half/'.$value["thumbnail_image"].'">
				</div>');
		return $thumbnail_html;
	}
	//------------
	//タグHTML生成
	//------------
	static function article_tag_html_create($tag, $cached = 900) {
		// テーマarray生成
		$theme_array = Model_Theme_Basis::theme_array_create($tag);
		$tag_li = '';
		// タグありとなしの場合
		switch($tag) {
			case '':
				$tag_li = '';
			break;
			default:
				foreach($theme_array as $key => $value) {
					// テーマres取得
					$theme_res = Model_Theme_Basis::tag_name_in_theme_res_get($value, $cached);
					foreach($theme_res as $theme_key => $theme_value) {
						// テーマ一覧HTML生成
						list($theme_list_html, $theme_article_data_array) = Model_Theme_Html::theme_list_html_create($theme_res, 1, 0);
						// テーマカウント数res取得
						$theme_count_res = Model_Theme_Basis::theme_count_res_get($theme_value['theme_name'], $cached);
						foreach($theme_count_res as $theme_count_key => $theme_count_value) {
							$tag_li .= 
								'<li><a href="'.HTTP.'theme/'.$theme_value['primary_id'].'/"><span class="typcn typcn-folder"></span>'.$theme_value['theme_name'].'('.$theme_article_data_array['list_num'].')</a></li>';
						}
					}
				}
			break;
		}
		// タグHTML生成
		$tag_html = ('
			<div class="tag">
<!--
				<span class="typcn typcn-tags clearfix"></span>
				<span class="typcn typcn-pin-outline"></span>
				<span class="typcn typcn-attachment-outline"></span>
-->
				<span class="typcn typcn-document-add clearfix"></span>
				<ul class="clearfix">
					<li>Theme To：</li>
						'.$tag_li.
				'</ul>
			</div>');
		return array($theme_array, $tag_html);
	}
	//------------------
	//オリジナルHTML生成
	//------------------
	static function original_html_create($original) {
		$original_html = '';
		if(!$original == '') {
			$original_html = ('
				<div class="original">
					<dl>
						<dt>Original：</dt>
						<dd>
							<h2>'.$original.'</h2>
						</dd>
					</dl>
				</div>');
		}
		return $original_html;
	}
	//------------
	//筆者HTML生成
	//------------
	static function author_html_create($sharetube_user_data_array) {
//		var_dump($value["sharetube_id"]);
//		var_dump($sharetube_user_data_array);
		$author_html = 
			'<a href="'.HTTP.'channel/'.$sharetube_user_data_array["sharetube_id"].'/">
				<img width="20" height="20" title="'.$sharetube_user_data_array["name"].'" alt="'.$sharetube_user_data_array["name"].'" src="'.HTTP.'assets/img/creators/icon_32px/'.$sharetube_user_data_array["profile_icon"].'">'.$sharetube_user_data_array["name"].'</a>';
			$author_html = 
				'<div class="author">
					<span class="typcn typcn-pencil"></span>
					<dl>
						<dt>Author：</dt>
						<dd>
							<span>'.$author_html.'</span>
						</dd>
					</dl>
				</div>';
		return $author_html;
	}
	//------------------------------------
	//ソーシャルシェアボタンリストHTML生成
	//------------------------------------
	static function social_share_share_button_html_create($value, $article_type) {
		$social_share_share_button_html = 
		'<div class="social_button_list clearfix">
			<ul>
				<li class="facebook_button">
					<!-- facebookボタン -->
					<div class="fb-share-button" data-href="'.HTTP.''.$article_type.'/'.$value["link"].'/" data-type="button"></div>
				</li>
				<li class="twitter_button">
					<!-- twitterボタン -->
					<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja" data-count="none">ツイート</a>
				</li>
				<li class="hatena_button">
					<!-- はてなボタン -->
					<a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="standard-noballoon" data-hatena-bookmark-lang="ja" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
				</li>
				<li class="pocket_button">
					<!-- ポケットボタン -->
					<a data-pocket-label="pocket" data-pocket-count="none" class="pocket-btn" data-lang="en"></a>
				</li>
<!--
				<li class="google_plus_button">
					<div class="g-plus" data-action="share" data-annotation="none" data-height="24" data-href="'.HTTP.''.$article_type.'/'.$value["link"].'"></div>
				</li>
-->

<!--
				<li class="line_button">
					<span>
						<script type="text/javascript" src="//media.line.me/js/line-button.js?v=20140411"></script>
						<script type="text/javascript">
						new media_line_me.LineButton({"pc":false,"lang":"ja","type":"a"});
						</script>
					</span>
				</li>
-->
			</ul>
		</div>';
		return $social_share_share_button_html;
	}
	//-------------------
	//snsのリンクhtml生成
	//-------------------
	public static function sns_account_list_html_crete($sharetube_user_data_array) {
		// account_list_html生成
		if($sharetube_user_data_array["twitter_id"] | $sharetube_user_data_array["facebook_id"]) {
			$twitter_li        = '';
			$facebook_li       = '';
			$account_list_html = '';
			if($sharetube_user_data_array["twitter_id"]) {
				$twitter_li = '<li class="account_list_twitter"><a target="_blank" href="https://twitter.com/'.$sharetube_user_data_array["twitter_id"].'"><img width="120" height="120" src="http://sharetube.jp/assets/img/library/Picons%20Social/PNG/128/social-003_twitter_white.png" alt="" title=""></a></li>';
			}
			if($sharetube_user_data_array["facebook_id"]) {
				$facebook_li = '<li class="account_list_facebook"><a target="_blank" href="https://www.facebook.com/'.$sharetube_user_data_array["facebook_id"].'"><img width="120" height="120" src="http://sharetube.jp/assets/img/library/Picons%20Social/PNG/128/social-006_facebook_white.png" alt="" title=""></a></li>';
			}
				$account_list_html = '
					<div class="account_list clearfix">
						<ul>
							'.$twitter_li.'
							'.$facebook_li.'
						</ul>
					</div>';
		} // if($sharetube_user_data_array["twitter_id"] | $sharetube_user_data_array["facebook_id"]) {
		return $account_list_html;
	}
	//------------------------
	//筆者プロフィールHTML生成
	//------------------------
	static function author_profile_html_create($sharetube_user_data_array) {
//		var_dump($sharetube_user_data_array);
		// snsのリンクhtml生成
		$account_list_html = Model_Article_Html::sns_account_list_html_crete($sharetube_user_data_array);
		// 筆者プロフィールHTML生成
		$author_profile_html = 
			'<!-- author_profile -->
			<div class="author_profile clearfix">
				<h5>著者プロフィール</h5>
				<!-- author_profile_icon -->
				<span class="author_profile_icon">
						<img width="128" height="128" src="'.HTTP.'assets/img/creators/icon/'.$sharetube_user_data_array["profile_icon"].'" alt="'.$sharetube_user_data_array["name"].'" title="'.$sharetube_user_data_array["name"].'">
				</span> <!-- author_profile_icon -->
				<!-- author_profile_contents -->
				<div class="author_profile_contents">
					<div class="author_profile_name">
						'.$sharetube_user_data_array["name"].'
					</div>
					<p>'.$sharetube_user_data_array["profile_contents"].'</p>
						'.$account_list_html.'
				</div> <!-- author_profile_contents -->
			</div> <!-- author_profile -->';
		return $author_profile_html;
	}
	//-----------------------------
	//card形式に挿入するli HTML生成
	//-----------------------------
	static function article_card_li_html_create($value, $card_li, $article_type) {
//				var_dump($card_li);

		// 記事作成時間取得
		$creation_time       = $value["create_time"];
		$unix_time           = strtotime($value["create_time"]);
		$year_time           = date('Y', $unix_time);
		$local_time          = date('Y-m-d', $unix_time);
		$local_japanese_time = date('Y年m月d日', $unix_time);
		$article_year_time   = date('Y', $unix_time);
		// カテゴリー情報取得
		$category_info_array = Model_Info_Basis::category_info_get($value["category"]);
		// ターゲット画像
		$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/facebook_ogp_half_half/'.$value["thumbnail_image"]);
		// コピー元画像のファイルサイズを取得
		list($image_w, $image_h) = getimagesize($targetImage);
			$image_reito = ($image_h / $image_w);
			$new_image_h = (int)(200 * $image_reito);
			// タイトルのエンティティを戻す
			$title        = htmlspecialchars_decode($value["title"], ENT_NOQUOTES);
			// タイトルを82文字に丸める
			$title = mb_strimwidth($title, 0, 74, "...", 'utf8');




//				var_dump($value["primary_id"]);

			$card_li .= ('
				<li class="o_8">
					<article>
						<div class="category_band '.$category_info_array["category_color"].'">'.$value["category"].'</div>													<a href="'.HTTP.''.$article_type.'/'.$value["link"].'/">
							<div class="inner clearfix">
								<img class="" src="'.HTTP.'assets/img/'.$article_type.'/'.$article_year_time.'/facebook_ogp_half_half/'.$value["thumbnail_image"].'" width="200" height="'.$new_image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
								<div class="shuffle_article_contents_title clearfix">
									<span>'.$title.'</span>
								</div>
							</div>
						</a>
					</article>
				</li>');
			return $card_li;
	}
	//----------------------
	//記事内関連記事HTML生成
	//-----------------------
	static function article_inside_related_html_create($related_res, $related_count, $article_type = 'article') {
		// 使用する変数
		$card_li      = '';
		$related_html = '';
		// 回す
		foreach($related_res as $key => $value) {
			// countの分のみ回す
			if($related_count > 0) {
				$card_li = Model_Article_Html::article_card_li_html_create($value, $card_li, $article_type);
				$related_count--;
			}
		} // foreach($related_res as $key => $value) {
		if($card_li) {
			// 合体
			$related_html = ('
				<nav class="article_inside_related_article">
					<div class="article_inside_related_article_content">
						<div class="article_inside_related_article_header">
							<span>関連記事</span>
							<span class="article_inside_related_article_header_line"> </span>
						</div>
						<ul class="clearfix">
							'.$card_li.'
						</ul>
					</div>
				</nav>');
		}
			else {
				// margi-bottom 30px適応するため
				$related_html = ('
					<nav class="article_inside_related_article">
						<div class="article_inside_related_article_content">

						</div>
					</nav>');
			}
//			var_dump($related_html);
		return $related_html;
	}
	//----------------
	//関連記事HTML生成
	//----------------
	static function article_related_html_create($related_res, $related_count, $article_type = 'article') {
		// 使用する変数
		$card_li      = '';
		$related_html = '';
		// 回す
		foreach($related_res as $key => $value) {
			// countの分のみ回す
			if($related_count > 0) {
				$card_li = Model_Article_Html::article_card_li_html_create($value, $card_li, $article_type);
				$related_count--;
			}
		} // foreach($related_res as $key => $value) {
		// 合体
		$related_html = ('
			<nav class="shuffle_article">
				<div class="shuffle_article_content">
					<div class="shuffle_article_header">
						<span>関連記事</span>
						<span class="shuffle_article_header_line"> </span>
					</div>
					<ul class="clearfix">
						'.$card_li.'
					</ul>
				</div>
			</nav>');
//			var_dump($related_html);
		return $related_html;
	}
	//----------------------
	//シャッフル記事HTML生成
	//----------------------
	static function article_shuffle_html_create($shuffle_res, $article_type = 'article') {
		// 使用する変数
		$card_li      = '';
		$shuffle_html = '';
		// html生成
		foreach($shuffle_res as $key => $value) {
			$card_li = Model_Article_Html::article_card_li_html_create($value, $card_li, $article_type);
		}
		$shuffle_html = ('
			<nav class="shuffle_article">
				<div class="shuffle_article_content">
					<div class="shuffle_article_header">
						<span>Shuffle記事</span>
						<span class="shuffle_article_header_line"> </span>
					</div>
					<ul class="clearfix">
						'.$card_li.'
					</ul>
				</div>
			</nav>');
		return $shuffle_html;
	}
	//----------------------------
	//シャッフルボタン記事link生成
	//----------------------------
	static function article_shuffle_button_link_create($shuffle_res) {
		foreach($shuffle_res as $key => $value) {
			$shuffle_article_link = $value["link"];
		}
		$shuffle_article_link = HTTP.'article/'.$shuffle_article_link.'/';
		return $shuffle_article_link;
	}
	//----------------
	//人気記事HTML生成
	//----------------
	static function article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, $article_type = 'article') {
		// 使用する変数
		$card_1_li      = '';
		$card_7_li      = '';
		$card_30_li      = '';
		$popular_html = '';
		// 今日
		foreach($article_access_1_res as $key => $value) {
			$card_1_li = Model_Article_Html::article_card_li_html_create($value, $card_1_li, $article_type);
		}
		// 一週間
		foreach($article_access_7_res as $key => $value) {
			$card_7_li = Model_Article_Html::article_card_li_html_create($value, $card_7_li, $article_type);
		}
		// 一ヶ月
		foreach($article_access_30_res as $key => $value) {
			$card_30_li = Model_Article_Html::article_card_li_html_create($value, $card_30_li, $article_type);
		}



		$popular_html = ('
			<nav class="shuffle_article">
				<div class="shuffle_article_content">
					<div class="shuffle_article_header">
						<span>人気記事</span>
						<div class="article_access_popular">
							<span class="article_access_popular_button push" data-article_access_popular_class="article_access_popular_today">今日</span>
							<span class="article_access_popular_button" data-article_access_popular_class="article_access_popular_week">一週間</span>
							<span class="article_access_popular_button" data-article_access_popular_class="article_access_popular_month">一ヶ月</span>
						</div>
						<span class="shuffle_article_header_line"> </span>
					</div>
					<ul class="article_access_popular_today clearfix">
						'.$card_1_li.'
					</ul>
					<ul class="article_access_popular_week clearfix">
						'.$card_7_li.'
					</ul>
					<ul class="article_access_popular_month clearfix">
						'.$card_30_li.'
					</ul>
				</div>
			</nav>');
		return $popular_html;
	}
	//--------------------------
	//前の記事、次の記事HTML生成
	//--------------------------
	static function article_previous_next_html_create($article_primary_id , $article_type) {
		// 変数
		$preview_html = '';
		$next_html    = '';
		// 前の記事、次の記事データ取得
		$article_previous_next_res_array = Model_Article_Basis::article_previous_next_get($article_primary_id , $article_type);
		// 前の記事HTML生成
		foreach($article_previous_next_res_array["previous"] as $key => $value) {
			$preview_html = ('<div class="previous"><a href="'.HTTP.''.$article_type.'/'.$value["link"].'/">
				<span class="typcn typcn-arrow-left"></span>
'.$value["title"].'</a></div>');
		}
		// 次の記事HTML生成
		foreach($article_previous_next_res_array["next"] as $key => $value) {
			$next_html = ('<div class="next"><a href="'.HTTP.''.$article_type.'/'.$value["link"].'/">'.$value["title"].'
<span class="typcn typcn-arrow-right"></span>
</a></div>');
		}
		// 関連記事、前の記事、次の記事HTML生成
		$detail_article_bottom_html = 
			('<div class="previous_next">
				'.$preview_html.$next_html.'
			</div>');
		return $detail_article_bottom_html;
	}
	//---------------
	//記事ogpHTML生成
	//---------------
	static function article_meta_html_create($article_data_array, $description_length = 168, $article_type = 'article') {
//		var_dump($article_data_array);
		if(! is_int($description_length)) {
			$description_length = 168;
		}
		// 記事概要取得
		$summary_contents = Model_Article_Html::meta_description_html_create($article_data_array, $description_length);
//		var_dump($summary_contents);
    $meta_html = ('
			<!-- Twitter -->
			<meta name="twitter:card" content="photo"> <!-- カードの種類 -->
			<meta name="twitter:site" content="@'.TWITTER_ID.'"> <!-- サイトのtwitterアカウント -->
			<meta name="twitter:creator" content="@'.TWITTER_ID.'"> <!-- 制作者ないし投稿者 -->
			<meta name="twitter:url" content="'.HTTP.''.$article_type.'/'.$article_data_array["article_link"].'/'.'"> <!-- コンテンツのURL -->
			<meta name="twitter:title" content="'.$article_data_array["article_title"].'"> <!-- コンテンツのタイトル(70文字以内) -->
			<meta name="twitter:description" content="'.$summary_contents.'"> <!-- コンテンツの概要(200文字以内) -->
			<meta name="twitter:image" content="'.HTTP.'assets/img/'.$article_type.'/'.$article_data_array["article_year_time"].'/facebook_ogp_half/'.$article_data_array["article_thumbnail_image"].'"> <!-- サムネイル 600px x 315px -->


			<!-- ogp -->
			<meta property="og:site_name" content="'.TITLE.'"> <!-- サイト名 -->
			<meta property="og:url" content="'.HTTP.''.$article_type.'/'.$article_data_array["article_link"].'/'.'"> <!-- コンテンツのURL -->
			<meta property="og:title" content="'.$article_data_array["article_title"].'"> <!-- 記事タイトル -->
			<meta property="og:type" content="article"> <!-- タイプ -->
			<meta property="og:image" content="'.HTTP.'assets/img/'.$article_type.'/'.$article_data_array["article_year_time"].'/facebook_ogp/'.$article_data_array["article_thumbnail_image"].'"> <!-- サムネイル 1200px x 630px -->
			<meta property="og:description" content="'.$summary_contents.'"> <!-- コンテンツの概要 -->
			<meta property="fb:admins" content="100001768077299"> <!-- facebookユーザーID -->
		');
		return $meta_html;
	}
	//----------------
	//メタ概要HTML生成
	//----------------
	static function meta_description_html_create($article_data_array, $description_length) {
		// 改行&タブを消す
		$article_contests = str_replace(array("\r\n","\r","\n","\t"), '', $article_data_array["article_contents"]);
		// HTMLタグを取り除く
		$article_contests = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/', '', $article_contests);
		// 本文を512文字に丸める
		$summary_contents = mb_strimwidth($article_contests, 0, $description_length, "...", 'utf8');
//		var_dump($strimwidth_contents);
		return $summary_contents;
	}
	//------------------------------
	//ソーシャルシェアボタンHTMl生成
	//------------------------------
	public static function social_share_html_create($encode_link, $value, $article_type) {
		switch($article_type) {
			case 'article':
				$vine_url = '';
				// viaとは@ShareTube_jpさんから を表示させるメソッド?
				$via      = '&amp;via='.TWITTER_ID.'';
				$via      = '';
			break;
			case 'vine':
				// srcの中取得する
				$pattern = '/src=\"(.*?)\"/';
				// VineURL取得
				preg_match($pattern, $value["contents"], $matches_array);
				// 削除する文言
				$del_array = array('embed/simple', 'embed/postcard');
				// 置換(VineURL取得)
				$vine_url = str_replace($del_array, "", $matches_array[1]);
//				$vine_url = ' '.$vine_url;
				$via = '';
			break;
			default :

			break;
		}
		// Twitterでteetの為に変換する(encodeするから一度decodeして戻す)
		$value["title"] = htmlspecialchars_decode($value["title"], ENT_QUOTES);

		// article
		if($article_type == 'article') {
//			print_r($value["title"]);
//	var_dump($encode_link);
		$social_share_html = ('
					<div class="social_share clearfix">
						<!-- Facebookシェア -->
						<a class="fb_color o_8" target="_blank" href="http://www.facebook.com/share.php?u='.$encode_link.'" onClick="window.open(this.href, '."'".'sharing_window'."'".', '."'".'width=540, height=380, left=150, top=150, menubar=no, toolbar=no, scrollbars=no, resizable=no'."'".'); return false;">Facebookでシェア</a>

						<!-- Twitterシェア(わざと記述間違いをする js) -->
						<a class="tw_color o_8" href="http://twitter.com/intent/tweet?url='.urlencode($encode_link).'&amp;text='.urlencode($value["title"].$vine_url).$via.'&amp;related='.TWITTER_ID.'"
      onClick="window.open(encodeURI(decodeURI(this.href)),
      '."'".'tweetwindow'."'".',
      '."'".'height=300, width=600, personalbar=0, toolbar=0, scrollbars=1, resizable=1'."'".',
      ); return false;">
			Twitterでつぶやく</a>

			<!-- Google+シェア -->
<!--
			<a class="g_plus_color o_8" href="https://plus.google.com/share?url='.$encode_link.'" onclick="window.open(this.href, '."'".''."'".', '."'".'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600,left=150,top=150'."'".');return false;">
			Google+で共有
			</a>
-->
					</div><!--
					<p class="message">コメントとともにシェアしよう</p>-->');
		}
			// Vine
			else {
		$social_share_html = ('
					<div class="social_share clearfix">
						<!-- Facebookシェア -->
						<a class="fb_color o_8" target="_blank" href="http://www.facebook.com/share.php?u='.$encode_link.'" onclick="window.open(this.href, '."'".'sharing_window'."'".', '."'".'width=540, height=380, left=150, top=150, menubar=no, toolbar=no, scrollbars=no, resizable=no'."'".'); return false;">Facebookでシェア</a>

						<!-- Twitterシェア(わざと記述間違いをする js) -->
						<a class="tw_color o_8" href="http://twitter.com/intent/tweet?url=&amp;text='.urlencode($value["title"].' '.$encode_link.' '.$vine_url).$via.'&amp;related='.TWITTER_ID.'"
      onClick="window.open(encodeURI(decodeURI(this.href)),
      '."'".'tweetwindow'."'".',
      '."'".'height=300, width=600, personalbar=0, toolbar=0, scrollbars=1, resizable=1'."'".',
      ); return false;">
			Twitterでシェア</a>
					</div>
					<p class="message">コメントとともにシェアしよう</p>');
			}
		return $social_share_html;
	}
	//--------------------------------------------
	//URI Scheme式のソーシャルシェアボタンHTMl生成
	//--------------------------------------------
	public static function social_share_uri_scheme_html_create($encode_link, $value, $social_array = array('twitter','facebook'), $position = 'left') {
		// Twitterでteetの為に変換する(encodeするから一度decodeして戻す)
		$value["title"] = htmlspecialchars_decode($value["title"], ENT_QUOTES);



/*
border-bottom: 2px dotted #888;
*/
		// positionによるmargin指定
		if($position == 'left') {
			$twitter_margin = ' margin: 0px 15px 0 0px;';
			$facebook_margin = ' margin: 0;';
		}
			else {
				$twitter_margin = ' margin: 0;';
				$facebook_margin = ' margin: 0px 15px 0 0px;';
			}
		// twitter
		$twitter_social_share_btn_html = 
			'<!-- Twitterシェア(わざと記述間違いをする js) -->
			<a class="tw_color o_8" style="float: '.$position.';'.$twitter_margin.'" href="http://twitter.com/intent/tweet?url='.urlencode($encode_link).'&amp;text='.urlencode($value["title"].$vine_url).$via.'&amp;related='.TWITTER_ID.'"
	onClick="window.open(encodeURI(decodeURI(this.href)),
	'."'".'tweetwindow'."'".',
	'."'".'height=300, width=600, personalbar=0, toolbar=0, scrollbars=1, resizable=1'."'".',
	); return false;">
				<div class="social_share_uri_scheme_left_block">
					<span class="typcn typcn-social-twitter clearfix"></span>
				</div>
				<div class="social_share_uri_scheme_right_block">
					ツイート
				</div>
			</a>';
		// facebook
		$facebook_social_share_btn_html = 
			'<!-- Facebookシェア -->
				<a class="fb_color o_8 clearfix" style="float: '.$position.';'.$facebook_margin.'" target="_blank" href="http://www.facebook.com/share.php?u='.$encode_link.'" onClick="window.open(this.href, '."'".'sharing_window'."'".', '."'".'width=540, height=380, left=150, top=150, menubar=no, toolbar=no, scrollbars=no, resizable=no'."'".'); return false;">
					<div class="social_share_uri_scheme_left_block">
						<span class="typcn typcn-social-facebook clearfix"></span>
					</div>
					<div class="social_share_uri_scheme_right_block">
						シェア
					</div>	
				</a>';
		// google+
		$google_social_share_btn_html = 
			'<!-- Google+シェア -->
			<!--
						<a class="g_plus_color o_8" href="https://plus.google.com/share?url='.$encode_link.'" onclick="window.open(this.href, '."'".''."'".', '."'".'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600,left=150,top=150'."'".');return false;">
						Google+で共有
						</a>
			-->';
		// $social_share_btn_html_array
		$social_share_btn_html_array = array(
			'twitter' => $twitter_social_share_btn_html,
			'facebook'=> $facebook_social_share_btn_html,
		);
		// HTMLを繋げる
		foreach($social_array as $key => $value) {
			$social_share_btn_html_array_html .= $social_share_btn_html_array[$value];
		}
		// 一つにまとめる
		$social_share_html = ('
			<div class="social_share_uri_scheme clearfix">
				'.$social_share_btn_html_array_html.'
			</div>');
		return $social_share_html;
	}

	//--------------------------
	//スマホ用サムネイルHTML生成
	//--------------------------
	static function sp_thumbnail_html_create($article_res) {
		$sp_thumbnail_html = '';
		$article_type = 'article';
		foreach($article_res as $key => $value) {
			// 審査
			if((int)$value["sp_thumbnail"] === 1) {
				// 記事作成時間取得
				$creation_time       = $value["create_time"];
				$unix_time           = strtotime($value["create_time"]);
				$year_time           = date('Y', $unix_time);
				$local_time          = date('Y-m-d', $unix_time);
				$local_japanese_time = date('Y年m月d日', $unix_time);
				$article_year_time   = date('Y', $unix_time);
				// ターゲット画像
				$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/facebook_ogp_half/'.$value["thumbnail_image"]);
				// コピー元画像のファイルサイズを取得
				list($image_w, $image_h) = getimagesize($targetImage);
					$image_reito = ($image_h / $image_w);
					$new_image_h = (int)(320 * $image_reito);
				$sp_thumbnail_html = ('
					<div class="sp_thumbnail">
						<img class="" src="'.HTTP.'assets/img/'.$article_type.'/'.$article_year_time.'/facebook_ogp_half/'.$value["thumbnail_image"].'" width="320" height="'.$new_image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
					</div>');
			}
		}
		return $sp_thumbnail_html;
	}
	//--------------------------------------------
	//Facebokページをいいね!するように促すHTML生成
	//--------------------------------------------
	static function facebook_like_please_html_create() {
		$facebook_like_please_html = '
			<div class="facebook_like_please clearfix">
				<p class="m_0"><img src="'.Uri::base().'assets/img/logo/logo_27.png" width="136" height="52" alt="シェアチューブ" title="シェアチューブ" style="margin: -7px 5px -8px 0;">をフォローする</p>



				<div class="facebook_like_please_left">
<!--
					<div class="facebook_like_please_facebook_like_button">
						<div class="fb-like" data-href="https://www.facebook.com/pages/Sharetube/621756284545794" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div>
					</div>
					<p><a target="blank" href="http://cloud.feedly.com/#subscription%2Ffeed%2Fhttp%3A%2F%2Fsharetube.jp%2Ffeed.xml"><img width="71" height="28" alt="follow us in feedly" src="http://s3.feedly.com/img/follows/feedly-follow-rectangle-flat-medium_2x.png" id="feedlyFollow"></a></p>
					<p class="m_0"><a href="https://twitter.com/Sharetube_jp" class="twitter-follow-button" data-show-count="false" data-lang="ja">@Sharetube_jpさんをフォロー</a></p>
					<p style="font-size: 67%;">Sharetubeの最新情報をお届けします</p>
-->




<div class="new_sns_follow">
	<div class="new_sns_follow_twitter">
		<a class="twitter" href="https://twitter.com/intent/follow?screen_name=Sharetube_jp" onclick="window.open(this.href, '."'".'TwitterFollowWindow'."'".', '."'".'width=550, height=507, menubar=no, toolbar=no, scrollbars=yes'."'".'); return false;" target="_blank">
			<div class="clearfix">
				<div class="new_sns_follow_twitter_icon"><span class="typcn typcn-social-twitter"></span></div>
				<div class="new_sns_follow_twitter_button">FOLLOW</div>
			</div>
		</a>
	</div>







	<div class="new_sns_follow_facebook">
  	<a class="facebook" href="https://www.facebook.com/pages/Sharetube/621756284545794" target="_blank">
			<div class="clearfix">
				<div class="new_sns_follow_facebook_icon"><span class="typcn typcn-social-facebook"></span></div>
				<div class="new_sns_follow_facebook_button">FOLLOW</div>
			</div>
		</a>
	</div>
</div>
<p style="font-size: 60%; margin: 5px 0 0;">Sharetubeの最新情報をお届けします</p>








				</div><!-- facebook_like_please_left -->
				<div class="facebook_like_please_right">
					<div class="facebook_like_please_right_character">
						<img width="79" height="99" src="'.HTTP.'assets/img/character/character_4.png" alt="お名前募集中です" title="お名前募集中です">
					</div>
				</div>
			</div>
		';
		return $facebook_like_please_html;
	}
//			$facebook_like_please_html = Model_Article_Html::facebook_like_please_html_create();
	//--------------------------------------------------------------------
	//モバイル専用の広告を差し込む（モバイルでなかったら何も差し込まない）
	//--------------------------------------------------------------------
	static function mobil_article_amoad($user_is_mobil, $amoad_num = 0, $top_margin = 0, $botoom_margin = 0) {
		$amoad_script = '';
		$amoad_html = '';
		switch($amoad_num) {
			case 0:
			$amoad_script = '<!-- AMoAd Zone: [インライン_動画メディア_中面ミドル_300×250_Sharetube] -->
					<div class="amoad_frame sid_62056d310111552c38803fb7dada336ea0e88209a4566676d7e16eb9701096d5 container_div color_#0000CC-#444444-#FFFFFF-#0000FF-#009900 sp"></div>
					<script src="http://j.amoad.com/js/aa.js" type="text/javascript" charset="utf-8"></script>';
				break;
			case 1:
			$amoad_script = '<!-- AMoAd Zone: [サイドバー_インライン_動画メディア_中面ミドル_300×250_Sharetube ] -->
					<div class="amoad_frame sid_62056d310111552c38803fb7dada336eecb7093b2ffeb1a91ea409dec8ab1178 container_div color_#0000CC-#444444-#FFFFFF-#0000FF-#009900 sp"></div>
					<script src="http://j.amoad.com/js/aa.js" type="text/javascript" charset="utf-8"></script>';
				break;
			default:
			break;
		}
		if ($user_is_mobil == true) {
			$amoad_html = ('
				<div class="m_t_'.$top_margin.' m_b_'.$botoom_margin.'">
					'.$amoad_script.'
				</div>');
		}
		return $amoad_html;
	}
	//----------------------------------------
	//アーティクルボトムライクボックスHTML生成
	//----------------------------------------
	public static function article_bottom_like_box_html_create($value, $year_time, $preview_frg) {
		switch($preview_frg) {
			case false:
				$draft = '';
			break;
			case true:
				$draft = 'draft/';
			break;
			default:

			break;
		}
		$article_bottom_like_box_html = '
		<div class="article_bottom_like_box">
			<div class="article_bottom_like_box_contents clearfix">
				<div class="article_bottom_like_box_contents_left">
					<div class="article_bottom_like_box_contents_left_thumbnail">
						<img width="640" height="400" src="'.HTTP.'assets/img/'.$draft.'article/'.$year_time.'/facebook_ogp_half/'.$value["thumbnail_image"].'">
					</div>
				</div> <!-- article_bottom_like_box_contents_left -->
				<div class="article_bottom_like_box_contents_right">
					<div class="article_bottom_like_box_contents_right_text">
						<p>この記事が気に入ったら</p>
						<p>いいね！しよう</p>
					</div>
					<div class="article_bottom_like_box_contents_right_button">
						<div class="fb-like" data-href="https://www.facebook.com/pages/Sharetube/621756284545794" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
					</div>
					<div class="article_bottom_like_box_contents_right_foot">
						<p>Sharetubeの最新記事をお届けします</p>
					</div>
				</div> <!-- article_bottom_like_box_contents_right -->
			</div> <!-- article_bottom_like_box_contents -->
		</div> <!-- article_bottom_like_box -->';
		return $article_bottom_like_box_html;
	}
	//---------------------------------
	//flickity ピックアップ記事HTML生成
	//---------------------------------
	Public static function flickity_pickup_html_create($pickup_res) {
		foreach($pickup_res as $key_1 => $value_1) {
			foreach($pickup_res[$key_1] as $key_2 => $value_2) {
				// 記事データ取得
				$article_author       = $value_2["sharetube_id"];
				$unix_time            = strtotime($value_2["create_time"]);
				$local_time           = date('Y-m-d', $unix_time);
				$local_japanese_time  = date('Y年m月d日', $unix_time);
				$article_year_time    = date('Y', $unix_time);
	
				// エンティティを戻す
				$title        = htmlspecialchars_decode($value_2["title"], ENT_NOQUOTES);
				// タイトルを文字に丸める
				$title = mb_strimwidth($title, 0, 40, "...", 'utf8');


				// カテゴリー情報取得
				$category_info_array = Model_Info_Basis::category_info_get($value_2["category"]);
				// ターゲット画像
				$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/facebook_ogp/'.$value_2["thumbnail_image"]);
				// コピー元画像のファイルサイズを取得
				list($image_w, $image_h) = getimagesize($targetImage);
					$image_reito = ($image_h / $image_w);
					$new_image_h = (int)(200 * $image_reito);
				$cell_html .= 
					'<div class="gallery-cell">
						<div class="gallery-cell_contents">
							<article class="o_8">
								<a href="'.HTTP.'article/'.$value_2["link"].'/" class="clearfix">
									<figure>
										<img width="'.$image_w.'" height="'.$image_w.'" alt="'.$title.'" title="'.$title.'" src="'.HTTP.'assets/img/article/'.$article_year_time.'/facebook_ogp_half/'.$value_2["thumbnail_image"].'">


									</figure>
									<div class="gallery-cell_summary clearfix">
										<h1>'.$title.'</h1>
										<div class="gallery-cell_summary_time">'.$local_time.'</div>
									</div>
								</a>
							</article>
						</div>
					</div>';
			}
		}
		// 合体
		$pickup_html = 
		'<div class="main_gallery">
			'.$cell_html.'
		</div>';
		// 追加合体
		$pickup_html = 
		'<div class="main_gallery_title">
			<span class="typcn typcn-star-outline"></span><span>ピックアップ</span>
		</div>
		'.$pickup_html.'
		<div class="main_gallery_title">
			<span class="typcn typcn-document-text"></span><span>新着まとめ</span>
		</div>';
		return $pickup_html;
	}
	//-----------------------------------
	//flexslider ピックアップ記事HTML生成
	//-----------------------------------
	Public static function flexslider_pickup_html_create($pickup_res) {
		foreach($pickup_res as $key_1 => $value_1) {
			foreach($pickup_res[$key_1] as $key_2 => $value_2) {
				// 記事データ取得
				$article_author       = $value_2["sharetube_id"];
				$unix_time            = strtotime($value_2["create_time"]);
				$local_time           = date('Y-m-d', $unix_time);
				$local_japanese_time  = date('Y年m月d日', $unix_time);
				$article_year_time    = date('Y', $unix_time);
	
				// エンティティを戻す
				$title        = htmlspecialchars_decode($value_2["title"], ENT_NOQUOTES);
				// タイトルを文字に丸める
				$title = mb_strimwidth($title, 0, 40, "...", 'utf8');


				// カテゴリー情報取得
				$category_info_array = Model_Info_Basis::category_info_get($value_2["category"]);
				// ターゲット画像
				$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/facebook_ogp/'.$value_2["thumbnail_image"]);
				// コピー元画像のファイルサイズを取得
				list($image_w, $image_h) = getimagesize($targetImage);
					$image_reito = ($image_h / $image_w);
					$new_image_h = (int)(200 * $image_reito);
				$cell_html .= 
					'<li>
								<a href="'.HTTP.'article/'.$value_2["link"].'/" class="clearfix">
									<figure>
										<img width="'.$image_w.'" height="'.$image_w.'" alt="'.$title.'" title="'.$title.'" src="'.HTTP.'assets/img/article/'.$article_year_time.'/facebook_ogp_half/'.$value_2["thumbnail_image"].'">
									</figure>
									<div class="gallery-cell_summary clearfix">
										<h1>'.$title.'</h1>
										<div class="gallery-cell_summary_time">'.$local_time.'</div>
									</div>
								</a>
							</li>';
			}
		}
		// 合体
		$pickup_html = 
			'<div class="flexslider">
				<ul class="slides">
					'.$cell_html.'
				</ul>
			</div>';
		// 追加合体
		$pickup_html = 
		'<div class="main_gallery_title">
			<span class="typcn typcn-star-outline"></span><span>ピックアップ</span>
		</div>
		'.$pickup_html.'
		<div class="main_gallery_title">
			<span class="typcn typcn-document-text"></span><span>新着まとめ</span>
		</div>';
		return $pickup_html;
	}
	//----------------------
	//注目まとめ一覧HTML生成
	//----------------------
	public static function recommend_article_list_html_create($recommend_article_array, $article_type = 'article') {
		foreach($recommend_article_array as $key => $value) {
			// 記事データ取得
			$article_author       = $value["sharetube_id"];
			$unix_time            = strtotime($value["create_time"]);
			$local_time           = date('Y-m-d', $unix_time);
			$local_japanese_time  = date('Y年m月d日', $unix_time);
			$article_year_time    = date('Y', $unix_time);

			// Sharetubeのユーザーデータ取得
			$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($article_author);

			// 改行を消す&タブ削除
			$article_contests = str_replace(array("\r\n", "\r", "\n", "\t"), '', $value["sub_text"].$value["text"]);
			// HTMLタグを取り除く
			$article_contests = preg_replace('/<("[^"]*"|\'[^\']*\'|[^\'">])*>/', '', $article_contests);
			// 追加を取り除く
			$article_contests = preg_replace('/追加/', '', $article_contests);
			// 本文を168文字に丸める
			$summary_contents = mb_strimwidth($article_contests, 0, 168, "...", 'utf8');
			// エンティティを戻す
			$title        = htmlspecialchars_decode($value["title"], ENT_NOQUOTES);
			// タイトルを82文字に丸める
			$title = mb_strimwidth($title, 0, 82, "...", 'utf8');

			// カテゴリー情報取得
			$category_info_array = Model_Info_Basis::category_info_get($value["category"]);
			// ターゲット画像
			$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/square_120px/'.$value["thumbnail_image"]);
			// コピー元画像のファイルサイズを取得
			list($image_w, $image_h) = getimagesize($targetImage);
				$image_reito = ($image_h / $image_w);
				$new_image_h = (int)(200 * $image_reito);
			 $recommend_article_li .=
			 '<li class="o_8">
				<article>
					<a href="'.HTTP.'article/'.$value['link'].'/" class="clearfix">
						<div class="card_article_contents clearfix">
							<h1>'.$title.'</h1>
							<div class="card_article_contents_summary">'.$summary_contents.'</div>
							<div class="card_article_contents_author">'.$sharetube_user_data_array['name'].'さん</div>
							<div class="card_article_contents_time">'.$local_time.'</div>
						</div>
						<figure>
							<img class="" src="'.HTTP.'assets/img/'.$article_type.'/'.$article_year_time.'/square_120px/'.$value["thumbnail_image"].'" width="200" height="'.$new_image_h.'" title="'.$value["title"].'" alt="'.$value["title"].'">
						</figure>
						<div class="category_band '.$category_info_array["category_color"].'">'.$value["category"].'</div>
					</a>
				</article>
			</li>';
		}
		// 合体
		$recommend_article_html = 
			'<div class="card_article">
				<div class="card_article_content">
					<div class="card_article_header">
						<span class="typcn typcn-document-text"></span><span>注目まとめ</span>
					</div>
					<ul class="clearfix">
						'.$recommend_article_li.'
					</ul>
				</div>
			</div>';
		return $recommend_article_html;
	}
	//------------------------------
	//注目まとめのページングHTML生成
	//------------------------------
	public static function recommend_article_paging_html_create($recommend_article_paging_data_array) {
//		var_dump($recommend_article_paging_data_array);
/*
	array(4) { ["last_num"]=> int(922) ["list_num"]=> int(10) ["paging_num"]=> int(1) ["max_paging_num"]=> int(93) } 
*/

//var_dump($recommend_article_paging_data_array);
// prev作成
if($recommend_article_paging_data_array['max_paging_num'] >= 2 && $recommend_article_paging_data_array['paging_num'] >= 2) {
	$prev_num = $recommend_article_paging_data_array['paging_num']-1;
	$paging_prev_li = '<li class="sp_left"><a href="'.HTTP.'recommendarticle/'.$prev_num.'/">Prev</a></li>';
}
// next作成
if($recommend_article_paging_data_array['paging_num'] < $recommend_article_paging_data_array['max_paging_num']) {
	$next_num = $recommend_article_paging_data_array['paging_num']+1;
	$paging_next_li = '<li class="sp_right"><a href="'.HTTP.'recommendarticle/'.$next_num.'/">Next</a></li>';
}
// チェック
if(($recommend_article_paging_data_array['paging_num'] - 5) > 0) { $left_check = true; } else {$left_check = false; }
// チェック
if(($recommend_article_paging_data_array['paging_num'] + 5) <= $recommend_article_paging_data_array['max_paging_num']) { $right_check = true; } else {$right_check = false; }
/*
<div class="recommend_article_paging">
	<div class="recommend_article_paging_inner">
		<ul class="clearfix">
			<li><a href="http://programmerbox.com/1/">Prev</a></li>
			<li><a href="http://programmerbox.com/1/">1</a></li>
			<li><span>2</span></li>
			<li><a href="http://programmerbox.com/3/">3</a></li>
			<li><a href="http://programmerbox.com/4/">4</a></li>
			<li><a href="http://programmerbox.com/5/">5</a></li>
			<li><a href="http://programmerbox.com/3/">6</a></li>
			<li><a href="http://programmerbox.com/4/">7</a></li>
			<li><a href="http://programmerbox.com/5/">8</a></li>
			<li><a href="http://programmerbox.com/5/">9</a></li>
			<li><a href="http://programmerbox.com/5/">10</a></li>

			<li><a href="http://programmerbox.com/3/">Next</a></li>
		</ul>
	</div>
</div>
*/


/*
	array(4) { ["last_num"]=> int(922) ["list_num"]=> int(10) ["paging_num"]=> int(1) ["max_paging_num"]=> int(93) } 
*/
// 1 2 3 4 5 6 7 8 9 10 11 12 13 14 15


$left_brink_num = $recommend_article_paging_data_array['paging_num'] - 1;
//$left_brink_num = 3 - 1;
$right_brink_num = $recommend_article_paging_data_array['max_paging_num'] - $recommend_article_paging_data_array['paging_num'];
//$right_brink_num = $recommend_article_paging_data_array['max_paging_num'] - 90;

$starting_point = 0;
$end_point  = 0;
/////////////
// 起点と終点
/////////////
if($left_check) {
	$starting_point = $recommend_article_paging_data_array['paging_num'] - 5;
}
	else {
		$starting_point = $recommend_article_paging_data_array['paging_num'] - $left_brink_num;
	}
if($right_check) {
	$end_point = ($starting_point + 9);
	if($recommend_article_paging_data_array['max_paging_num'] < $end_point) {
		$end_point = $recommend_article_paging_data_array['max_paging_num'];
	}
}
	else {
		$end_point = $recommend_article_paging_data_array['paging_num'] + $right_brink_num;
	}
/*
pre_var_dump($left_brink_num);
pre_var_dump($right_brink_num);
$max_id = $recommend_article_paging_data_array['paging_num']+$right_brink_num;
pre_var_dump($max_id);
pre_var_dump($left_check);
pre_var_dump($right_check);
pre_var_dump($starting_point);
pre_var_dump($end_point);
*/



/*



var_dump($left_check);
var_dump($right_check);
var_dump($left_brink_num);
var_dump($right_brink_num);

echo('<br><br>');

var_dump($starting_point);
var_dump($end_point);
*/

		for($starting_point = $starting_point; $starting_point <= $end_point; $starting_point++) {
			if($starting_point == $recommend_article_paging_data_array['paging_num']) {
				$paging_li_html .= '<li class="sp_hidden"><span>'.$starting_point.'</span></li>';
			}
				else {
					$paging_li_html .= '<li class="sp_hidden"><a href="'.HTTP.'recommendarticle/'.$starting_point.'/">'.$starting_point.'</a></li>';
				}
		}
	$paging_html = 
		'<div class="recommend_article_paging">
			<div class="recommend_article_paging_inner">
				<ul class="clearfix">
					'.$paging_prev_li.'
					'.$paging_li_html.'
					'.$paging_next_li.'
				</ul>
			</div>
		</div>';
		return $paging_html;
	}
















































	//------------------------
	//アプリ用記事一覧HTML生成
	//------------------------
	public static function app_list_html_create($list_query, $article_type = 'article') {
		// 変数
		$article_list_html_array = array();
		$article_list_html       = '';
		$i                       = 0;

		// 記事一覧HTML生成
		foreach($list_query as $key => $value) {
			// 記事データ取得
			$article_author       = $value["sharetube_id"];
			$unix_time            = strtotime($value["update_time"]);
			$local_time           = date('Y-m-d', $unix_time);
			$local_japanese_time  = date('Y年m月d日', $unix_time);
			$article_year_time    = date('Y', $unix_time);
			// エンティティを戻す
			$title        = htmlspecialchars_decode($value["title"], ENT_NOQUOTES);
			// カテゴリー情報取得
			$category_info_array = Model_Info_Basis::category_info_get($value["category"]);
			// ターゲット画像
			$targetImage = (PATH.'assets/img/'.$article_type.'/'.$article_year_time.'/detail/'.$value["thumbnail_image"]);
			// コピー元画像のファイルサイズを取得
			list($image_w, $image_h) = getimagesize($targetImage);
			// シェアボタンでエンコードして使う
			$encode_link           = (''.HTTP.''.$article_type.'/'.$value["link"].'/');
			// ソーシャルシェアボタンHTMl生成
			$social_share_html = Model_Article_Html::app_social_share_html_create($encode_link, $value, $article_type);
			// 記事一覧HTMLarry生成
			$article_list_html_array[$i] = ('
				<article class="article_list" data-article_number="'.$value["primary_id"].'">
					<div class="article_list_contents clearfix">
							<h1>'.$title.'</h1>
						<time datetime="'.$local_time.'" pubdate="pubdate">'.$local_japanese_time.'</time>
						<figure class="video clearfix">
							<div class="category_band '.$category_info_array["category_color"].'">'.$value["category"].'</div>
							'.$value["contents"].'
						</figure>
					</div>
						'.$social_share_html.'
				</article>');
			$i++;
		}
		// 記事一覧HTML合体
		foreach($article_list_html_array as $key => $value) {
			$article_list_html .= $value;
		}
		return $article_list_html;
	}
	//--------------------------------------
	//アプリ用ソーシャルシェアボタンHTMl生成
	//--------------------------------------
	public static function app_social_share_html_create($encode_link, $value, $article_type) {
		switch($article_type) {
			case 'article':
				$vine_url = '';
				$via      = '&amp;via='.TWITTER_ID.'';
			break;
			case 'vine':
				// srcの中取得する
				$pattern = '/src=\"(.*?)\"/';
				// VineURL取得
				preg_match($pattern, $value["contents"], $matches_array);
				// 削除する文言
				$del_array = array('embed/simple', 'embed/postcard');
				// 置換(VineURL取得)
				$vine_url = str_replace($del_array, "", $matches_array[1]);
//				$vine_url = ' '.$vine_url;
				$via = '';
			break;
			default :

			break;
		}
		// Twitterでteetの為に変換する
		$value["title"] = htmlspecialchars_decode($value["title"], ENT_COMPAT);

		// article
		if($article_type == 'article') {
//			print_r($value["title"]);
		$social_share_html = ('
					<div class="social_share clearfix">
						<!-- Facebookシェア -->
						<a class="fb_color o_8" target="_blank" href="http://sharetube.jp/?sharetube=YES&amp;socialtag=2&amp;title='.urlencode($value["title"]).'&amp;url='.$encode_link.'&amp;end=">Facebookでシェア</a>

						<!-- Twitterシェア(わざと記述間違いをする js) -->
						<a class="tw_color o_8" href="http://sharetube.jp/?sharetube=YES&amp;socialtag=1&amp;title='.urlencode($value["title"]).'&amp;url='.$encode_link.'&amp;end=">
			Twitterでシェア</a>
					</div>
					<p class="message">コメントとともにシェアしよう</p>');

/*
						<a class="fb_color o_8" target="_blank" href="http://sharetube.jp/?sharetube=YES&amp;socialtag=2&amp;title=世界を騒然とさせた アマゾンの本気 の動画がついに公開！ トラックに詰まれた巨大ダンボールの中身は一体なんだ！？&amp;url=http://sharetube.jp/article/68/&amp;end=">Facebookでシェア</a>
<?php //echo urlencode("世界を騒然とさせた アマゾンの本気 の動画がついに公開！ トラックに詰まれた巨大ダンボールの中身は一体なんだ！？"); ?>
						<!-- Twitterシェア(わざと記述間違いをする js) -->
						<a class="tw_color o_8" href="http://sharetube.jp/?sharetube=YES&amp;socialtag=1&amp;title=世界を騒然とさせた アマゾンの本気 の動画がついに公開！ トラックに詰まれた巨大ダンボールの中身は一体なんだ！？&amp;url=http://sharetube.jp/article/68/&amp;end=">Twitterでシェア</a>
*/

		}
			// Vine
			else {
		$social_share_html = ('
					<div class="social_share clearfix">
						<!-- Facebookシェア -->
						<a class="fb_color o_8" target="_blank" href="http://sharetube.jp/?sharetube=YES&amp;socialtag=2&amp;title='.urlencode($value["title"]).'&amp;url='.$encode_link.'&amp;end=">Facebookでシェア</a>

						<!-- Twitterシェア(わざと記述間違いをする js) -->
						<a class="tw_color o_8" href="http://sharetube.jp/?sharetube=YES&amp;socialtag=1&amp;title='.urlencode($value["title"]).'&amp;url='.$encode_link.'&amp;end=">
			Twitterでシェア</a>
					</div>
					<p class="message">コメントとともにシェアしよう</p>');
			}
		return $social_share_html;
	}
}