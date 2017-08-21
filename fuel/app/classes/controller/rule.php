<?php
/*
* 規約コントローラー
* 
* 
* 
* 
*/

class Controller_Rule extends Controller_Rule_Template {
	// ルーター
	public function router($method, $params) {
		// セグメント審査
		if($method == 'index') {
			return $this->action_index();
		}
			else if($method == 'rule') {
				return $this->action_rule();
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
	//----------------
	//トップアクション
	//----------------
	public function action_index() {
		// タイトルセット
		$this->rule_template->view_data['title'] = '利用規約｜'.TITLE;
		// コンテンツセット
		$this->rule_template->view_data['content']->set('content_data', array(
			'content_html' => View::forge('permalink/rule'),
		));

		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->rule_template->view_data["footer"]->set('footer_data', array(
//			'archive_html' => $archive_li_html,
		), false);
	}
	//--------------
	//詳細アクション
	//--------------
	public function action_rule() {
		// タイトルセット
		$this->rule_template->view_data['title'] = 'Sharetube利用規約｜'.TITLE;
		// コンテンツセット
		$this->rule_template->view_data['content']->set('content_data', array(
			'content_html' => View::forge('permalink/rule/rule'),
		));

		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get(1, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->rule_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->rule_template->view_data["footer"]->set('footer_data', array(
//			'archive_html' => $archive_li_html,
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
		$this->rule_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '<meta name="robots" content="noindex">',
		), false);

		// sp_thumbnailデータセット
		$this->rule_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		), false);

		// 記事コンテンツセット
		$this->rule_template->view_data["content"]->set('content_data', array(
			'content_html' => 'エラーページ<br><br><br><br><br><br><br><br><br>',
		), false);

		// サイドバーコンテンツセット
		$this->rule_template->view_data["sidebar"] = '';
		// スクリプトコンテンツセット
		$this->rule_template->view_data["script"] = '';

	}
}
