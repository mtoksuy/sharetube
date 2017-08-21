<?php
/*
* 殿堂まとめページングコントローラー
* 
* 
* 
* 
*/

class Controller_Famearticle extends Controller_Famearticle_Template {
	// ルーター
	public function router($method, $params) {
		// 新着トップ
		if($method == 'index') {
			return $this->action_index($method);
		}
		// セグメント審査と軽い審査
		else if(!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$method = (int)$method;
			// 1の場合トップページに遷移
			if($method == 1) { header('location:'.HTTP.'famearticle/'); exit; }
			$is_recommendarticle = Model_Info_Basis::is_recommendarticle($method);
			// ページングがある場合
			if($is_recommendarticle) {
				// メタセット
				$this->famearticle_template->view_data['meta'] = View::forge('noindex/meta');
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
				$this->famearticle_template->view_data['title'] = '殿堂まとめ | '.TITLE;
				$method = 1;
			break;
			// 新着ページング
			default :
				// タイトルセット
				$this->famearticle_template->view_data['title'] = ''.$method.' | 殿堂まとめ | '.TITLE;
				// intに戻す
				$method = (int)$method;
			break;
		}
		// ユーザー情報取得
		$user_data_array = Model_Info_Basis::user_data_get();
		// 変数をエンティティ化する
		$user_data_array = Library_Security_Basis::variable_security_entity($user_data_array);

		// 殿堂まとめ一覧データ取得
		$fame_article_array             = Model_Article_Basis::fame_article_list_get(20,$method);
		// 殿堂まとめ一覧HTML生成
		$fame_article_html              = Model_Article_Html::recommend_article_list_html_create($fame_article_array, 'article', '殿堂');
		// 殿堂まとめページングデータ取得
		$fame_article_paging_data_array = Model_Article_Basis::fame_article_paging_data_get(20, $method);
		// 殿堂まとめページングHTML生成
		$paging_html                    = Model_Article_Html::recommend_article_paging_html_create($fame_article_paging_data_array, 'famearticle');
		// ページングコンテンツセット
		$this->famearticle_template->view_data["content"]->set('content_data', array(
			'content_html' => $fame_article_html.$paging_html,
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
		$this->famearticle_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// サイドバーコンテンツセット
		$this->famearticle_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => $popular_html,
			'related_html' => '',
			'shuffle_html' => '',
		),false);

/*
		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->famearticle_template->view_data["footer"]->set('footer_data', array(
			'archive_html' => $archive_li_html,
		), false);
*/
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
		$this->famearticle_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '<meta name="robots" content="noindex">',
		), false);

		// sp_thumbnailデータセット
		$this->famearticle_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		), false);

		// 記事コンテンツセット
		$this->famearticle_template->view_data["content"]->set('content_data', array(
			'content_html' => 'エラーページ<br><br><br><br><br><br><br><br><br>',
		), false);

		// サイドバーコンテンツセット
		$this->famearticle_template->view_data["sidebar"] = '';
		// スクリプトコンテンツセット
		$this->famearticle_template->view_data["script"] = '';

	}
}
