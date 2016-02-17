<?php
/*
* 検索コントローラー
* 
* 
* 
* 
*/

class Controller_Search extends Controller_Article_Template {
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	// 基本アクション
	public function action_index() {
			// ポスト取得
			$post = Library_Security_Basis::post_security();
			if(!$post["search"] == '') {
//				var_dump($post);
				// サーチデータ取得
				$search_res = Model_Search_Basis::search_get($post["search"]);
				// サーチHTML生成
				$search_html = Model_Search_Html::search_html_create($search_res);
			}
				else {
					$search_html = '';
				}
			if($search_html == '') {
					$search_html = '
						<div class="" style="color: rgb(96, 96, 96); display: block; width: 600px; max-width: 100%;">
						がんばって検索しましたが、該当する記事がありませんでした。                     
						</div>';
			}
		// タイトルセット
		$this->article_template->view_data["title"] = 'search | '.TITLE;
		$this->article_template->view_data["external_css"] = View::forge('basic/externalcss');

		// sp_thumbnailデータセット
		$this->article_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		), false);

		// 記事メタセット
		$this->article_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '',
		), false);
		// コンテンツデータセット
		$this->article_template->view_data["content"]->set('content_data', array(
			'article_html' => $search_html,
		), false);
		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,8);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,8);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,8);
		$popular_html       = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');

		// シャッフル記事データ取得 
		$shuffle_res = Model_Article_Basis::article_shuffle_get(0, 'article', 4);
		// シャッフル記事HTML生成
		$shuffle_html = Model_Article_Html::article_shuffle_html_create($shuffle_res, 'article');

		// サイドバーコンテンツセット
		$this->article_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => $popular_html,
			'related_html' => '',
			'shuffle_html' => $shuffle_html,
		),false);

		// 追加コンテンツ コンテンツセット
		$this->article_template->view_data["plus_add"] = '';
	}
}