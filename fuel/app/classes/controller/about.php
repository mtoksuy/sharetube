<?php 
/**
 * Aboutコントローラー
 * 
 * 
 * 
 * 
 */

class Controller_About extends Controller_Basic_Template {
	// 親before実行
	public function before() {
		parent::before();
	}
	// アクション
	public function action_index() {
		// タイトルセット
		$this->basic_template->view_data["title"] = 'about | '.TITLE;
		// cssデータセット
		$this->basic_template->view_data["external_css"] = View::forge('permalink/about/externalcss');

		// html取得
		$about_html = View::forge('permalink/about');

		// sp_thumbnailデータセット
		$this->basic_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		));

		// コンテンツデータセット
		$this->basic_template->view_data["content"]->set('content_data', array(
			'content_html' => $about_html,
		), false);

		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,10);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,10);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,10);
		$popular_html       = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');

/*
		// シャッフル記事データ取得 
		$shuffle_res = Model_Article_Basis::article_shuffle_get(0, 'article', 4);
		// シャッフル記事HTML生成
		$shuffle_html = Model_Article_Html::article_shuffle_html_create($shuffle_res, 'article');
*/
		// シャッフル記事データ取得
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

		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->basic_template->view_data["footer"]->set('footer_data', array(
			'archive_html' => $archive_li_html,
		), false);

		// scriptデータセット
		$this->basic_template->view_data["script"] = View::forge('permalink/script');
	}
}