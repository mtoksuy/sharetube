<?php
/*
* Rootコントローラー
*
* トップページとカテゴリをコントロール。
*
*/
class Controller_Root extends Controller_Basic_Template {
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	// 基本アクション
	public function action_index() {


/*
// allタグ取得
$all_tag_res = DB::query("
	SELECT tag 
	FROM article 
	WHERE del = 0
	ORDER BY article.primary_id ASC")->execute();
$i = 0;

// テーマ登録
foreach($all_tag_res as $key => $value) {
//	pre_var_dump($value);
	// tag_array取得
	list($tag_array, $tag_html) = Model_Article_Html::article_tag_html_create($value['tag']);
	// 検査
	foreach($tag_array as $tag_key => $tag_value) {
		$tag_check_res = DB::query("
			SELECT *
			FROM theme
			WHERE theme_name = '".$tag_value."'
			AND del = 0")->execute();
		$theme_check = false;
		// すでにあったらtrue
		foreach($tag_check_res as $tag_check_key => $tag_check_value) {
			$theme_check = true;
		}
		// なかったらテーマ登録
		if(!$theme_check) {
			$tag_insert_res = DB::query("
				INSERT INTO
				theme (
					theme_name,
					theme_link_name,
					theme_summary
				)	
				VALUES (
					'".$tag_value."',
					'',
					''
				)
			")->execute();
			// create62Hash
			$tag_link_name = Model_Login_Twitterscraping_Basis::create62Hash($tag_insert_res[0]);
			// 
			DB::query("
				UPDATE theme
				SET theme_link_name = '".$tag_link_name."'
				WHERE primary_id = '".$tag_insert_res[0]."'")->execute();
		}
	}
}
*/











		// セグメント情報取得
		$segment_info_get_array = Model_Info_Basis::segment_info_get();
//pre_var_dump($segment_info_get_array);
		// タイトルセット
		$this->basic_template->view_data["title"] = $segment_info_get_array["title_segment"].TITLE;
		// CSSセット
		$this->basic_template->view_data["external_css"] = View::forge('root/externalcss');

		// トップのみ
		if($segment_info_get_array["top_judgment"] == true) {
			$this->basic_template->view_data["meta"]         = View::forge('root/meta');
			$this->basic_template->view_data["script"]       = View::forge('root/script');
			// ピックアップデータ取得
			$pickup_res  = Model_Article_Basis::pickup_get(array(1833,1832,1820,1684,1447,1342,1436,1417,1378,1269));
			// flickityピックアップHTML生成
//		$pickup_html = Model_Article_Html::flickity_pickup_html_create($pickup_res);
			// flexsliderピックアップHTML生成
//			$pickup_html = Model_Article_Html::flexslider_pickup_html_create($pickup_res);

		$pickup_html = 
			'<div class="main_gallery_title">
				<span class="typcn typcn-document-text"></span><span>新着まとめ</span>
			</div>';
		// 注目まとめ一覧データ取得
		$recommend_article_array = Model_Article_Basis::recommend_article_list_get(10,1);
//var_dump($recommend_article_array);
		// 注目まとめ一覧HTML生成
		$recommend_article_html = Model_Article_Html::recommend_article_list_html_create($recommend_article_array);


/*
$recommend_article_html = $recommend_article_html.'
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
</div>';
*/


		// 注目まとめページングデータ取得
		$recommend_article_paging_data_array = Model_Article_Basis::recommend_article_paging_data_get(10, 1);
		// 注目まとめページングHTML生成
		$paging_html = Model_Article_Html::recommend_article_paging_html_create($recommend_article_paging_data_array);
		$recommend_article_html = $recommend_article_html.$paging_html;
		}
			else {
				$pickup_html = '';
			}
		// sp_thumbnailデータセット
		$this->basic_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		));
		// 記事一覧データ取得
		$list_query        = Model_Article_Basis::list_get($segment_info_get_array, 10);
		// 記事一覧HTML生成
		$article_list_html = Model_Article_Html::itype_list_html_create($list_query);

		// コンテンツデータセット
		$this->basic_template->view_data["content"]->set('content_data', array(
			'recommend_html' => $recommend_article_html,
			'pickup_html'  => $pickup_html,
			'content_html' => $article_list_html,
		), false);

		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,10);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,10);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,10);
		$popular_html          = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');

		// シャッフル記事データ取得 
//		$shuffle_res = Model_Article_Basis::article_shuffle_get(0, 'article', 4);
		// シャッフル記事HTML生成
//		$shuffle_html = Model_Article_Html::article_shuffle_html_create($shuffle_res, 'article');
//		var_dump($shuffle_html);

		// シャッフル記事データ取得(シャッフルボタン)
		$shuffle_res = Model_Article_Basis::article_shuffle_get(0, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->basic_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);
		// サイドバーコンテンツセット
		$this->basic_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => $popular_html,
			'related_html' => '',
			'shuffle_html' => '',
		),false);

		// フッター変更
		$this->basic_template->view_data["footer"] = View::forge('root/footer');
	}
}
