<?php
/*
* キュレーターリストコントローラー
* 
* 
* 
* 
*/

class Controller_Curatorlist extends Controller_Permalink_Template {
	// ルーター
	public function router($method, $params) {
//		var_dump($method, $params);
		if($method == 'index') {
			$this->action_index();
		}
			else {
				$this->action_404();
			}
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	//----------
	//アクション
	//----------
	public function action_index() {
		// タイトルセット
		$this->permalink_template->view_data["title"] = 'キュレーター一覧 | '.TITLE;
		// CSSセット
		$this->permalink_template->view_data["external_css"] = View::forge('permalink/curatorlist/externalcss');

		$curator_list_res  = Model_Curatorlist_Basis::curatorlist_res_get();
		$curator_list_html = Model_Curatorlist_Html::curator_list_html_create($curator_list_res);

		// コンテンツデータセット
		$this->permalink_template->view_data["content"]->set('content_data', array(
			'content_html' => $curator_list_html
		), false);


		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,8);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,8);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,8);
		$popular_html       = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');

		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get(1, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->permalink_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// サイドバーコンテンツセット
		$this->permalink_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => $popular_html,
			'related_html' => '',
			'shuffle_html' => '',
		),false);


		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->permalink_template->view_data["footer"]->set('footer_data', array(
//			'archive_html' => $archive_li_html,
		), false);
	}
	//------------
	//エラーページ
	//------------
	public function action_404() {
		// 404ステータスにする
	$this->response_status                                      = 404;
	$this->active_request->response->status                     = 404;
	$this->active_request->controller_instance->response_status = 404;
		// 記事メタセット
		$this->permalink_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '<meta name="robots" content="noindex">',
		), false);

		// sp_thumbnailデータセット
		$this->permalink_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		), false);

		// 記事コンテンツセット
		$this->permalink_template->view_data["content"]->set('content_data', array(
			'content_html' => 'エラーページ<br><br><br><br><br><br><br><br><br>',
		), false);

		// サイドバーコンテンツセット
		$this->permalink_template->view_data["sidebar"] = '';
		// スクリプトコンテンツセット
		$this->permalink_template->view_data["script"] = '';

	}
}
