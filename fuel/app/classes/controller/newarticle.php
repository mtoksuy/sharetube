<?php
/*
* 新着まとめページングコントローラー
* 
* 
* 
* 
*/

class Controller_Newarticle extends Controller_Recommendarticle_Template {
	// ルーター
	public function router($method, $params) {
		// 新着トップ
		if($method == 'index') {
			return $this->action_index($method);
		}
		// セグメント審査と軽い審査
		else if(!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$method = (int)$method;
			// 1の場合新着トップページに遷移
			if($method == 1) { header('location:'.HTTP.'newarticle/'); exit; }
			// 新着まとめのページングがあるか審査
			$is_newarticle = Model_Info_Basis::is_newarticle($method);
			// ページングがある場合
			if($is_newarticle) {
				// メタセット
				$this->recommendarticle_template->view_data['meta'] = View::forge('noindex/meta');
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
		switch($method) {
			// 新着トップ
			case 'index':
				// タイトルセット
				$this->recommendarticle_template->view_data['title'] = '新着まとめ | '.TITLE;
				$method = 1;
			break;
			// 新着ページング
			default :
				// タイトルセット
				$this->recommendarticle_template->view_data['title'] = ''.$method.' | 新着まとめ | '.TITLE;
				// intに戻す
				$method = (int)$method;
			break;
		}
		// ユーザー情報取得
		$user_data_array = Model_Info_Basis::user_data_get();
		// 変数をエンティティ化する
		$user_data_array = Library_Security_Basis::variable_security_entity($user_data_array);

		// 記事一覧データ取得
		$new_article_res        = Model_Article_Basis::new_article_list_get(20,$method);
		// 新着まとめ一覧HTML生成
		$new_article_html = Model_Article_Html::recommend_article_list_html_create($new_article_res, 'article', '新着');
		// 新着まとめページングデータ取得
		$new_article_paging_data_array = Model_Article_Basis::new_article_paging_data_get(20, $method);
		// 新着まとめページングHTML生成
		$paging_html = Model_Article_Html::recommend_article_paging_html_create($new_article_paging_data_array, 'newarticle');

		// ページングコンテンツセット
		$this->recommendarticle_template->view_data["content"]->set('content_data', array(
			'content_html' => $new_article_html.$paging_html,
		), false);

		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,8);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,8);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,8);
		$popular_html       = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');

		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get($method, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->recommendarticle_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// サイドバーコンテンツセット
		$this->recommendarticle_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => $popular_html,
			'related_html' => '',
			'shuffle_html' => '',
		),false);
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
		$this->recommendarticle_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '<meta name="robots" content="noindex">',
		), false);

		// sp_thumbnailデータセット
		$this->recommendarticle_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		), false);

		// 記事コンテンツセット
		$this->recommendarticle_template->view_data["content"]->set('content_data', array(
			'content_html' => 'エラーページ<br><br><br><br><br><br><br><br><br>',
		), false);

		// サイドバーコンテンツセット
		$this->recommendarticle_template->view_data["sidebar"] = '';
		// スクリプトコンテンツセット
		$this->recommendarticle_template->view_data["script"] = '';

	}
}
