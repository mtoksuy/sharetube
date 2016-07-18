<?php
/*
* テーマコントローラー
* 
* 
* 
* 
*/

class Controller_Theme extends Controller_Theme_Template {
	// ルーター
	public function router($method, $params) {
		// セグメント審査と軽い記事審査
		if (!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$method = (int)$method;
			// テーマがあるかどうかを検査する
			$is_theme = Model_Info_Basis::is_theme($method);
			// 記事がある場合
			if($is_theme) {
				return $this->action_index($method);
			}
				// エラー
				else {
					return $this->action_404();
				}
		}
			// エラー
			else {
				 return $this->action_404();
			}
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	//----------
	//アクション
	//----------
	public function action_index($method) {
		// テーマres取得
		$theme_res = Model_Theme_Basis::theme_res_get($method);
		// テーマ一覧HTML生成
		$theme_list_html = Model_Theme_Html::theme_list_html_create($theme_res);
		// テーマのまとめ数HTML生成
		$theme_count_html = Model_Theme_Html::theme_count_html_create($theme_res);
		// コンテンツセット
		$this->theme_template->view_data["content"]->set('content_data', array(
			'theme_count_html' => $theme_count_html,
			'content_html' => $theme_list_html,
		), false);

		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get($method, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->theme_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// テーマデータHTML生成
		$theme_data_html = Model_Theme_Html::theme_data_html_create($theme_res);
		// サイドバーコンテンツセット
		$this->theme_template->view_data["sidebar"]->set('sidebar_data', array(
			'theme_data_html' => $theme_data_html,
		),false);


		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->theme_template->view_data["footer"]->set('footer_data', array(
			'archive_html' => $archive_li_html,
		), false);

	}
	//------------
	//エラーページ
	//------------
	public function action_404() {
//		var_dump($this);
		// 404ステータスにする
	$this->response_status                                      = 404;
	$this->active_request->response->status                     = 404;
	$this->active_request->controller_instance->response_status = 404;
		// 記事メタセット
		$this->theme_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '<meta name="robots" content="noindex">',
		), false);

		// sp_thumbnailデータセット
		$this->theme_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		), false);

		// 記事コンテンツセット
		$this->theme_template->view_data["content"]->set('content_data', array(
			'content_html' => 'エラーページ<br><br><br><br><br><br><br><br><br>',
		), false);

		// サイドバーコンテンツセット
		$this->theme_template->view_data["sidebar"] = '';
		// スクリプトコンテンツセット
		$this->theme_template->view_data["script"] = '';

	}
}