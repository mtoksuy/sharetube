<?php
/*
* Rootコントローラー
*
* トップページとカテゴリをコントロール。
*
*/
class Controller_Vine extends Controller_Vine_Template {
	public function router($method, $params) {
//		var_dump($method);
//		var_dump($params);
		// vineトップの場合
		if($method === 'index') {
			return $this->action_index();
		}
		// セグメント審査と軽い記事審査
		else if(!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$is_article = Model_Info_Basis::is_article($method, 'vine');
			// 記事がある場合
			if($is_article) {
				return $this->action_vine($method);
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
	//--------------
	//記事一覧ページ
	//--------------
	public function action_index() {
		// セグメント情報取得
		$segment_info_get_array = Model_Info_Basis::segment_info_get();


		$this->vine_template->view_data["script"] = View::forge('basic/script');
//		var_dump(View::forge('basic/script'));
		// タイトルセット
		$this->vine_template->view_data["title"] = VINE_TITLE;
		// 記事メタセット
		$this->vine_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => View::forge('vine/meta'),
		), false);

//		var_dump($segment_info_get_array);
		// 記事一覧データ取得
		$list_query        = Model_Article_Basis::list_get($segment_info_get_array, 3, null ,'vine');
		// 記事一覧HTML生成
		$article_list_html = Model_Article_Html::list_html_create($list_query, 'vine');
		// コンテンツデータセット
		$this->vine_template->view_data["content"]->set('content_data', array(
			'content_html' => $article_list_html,
		), false);
	}
	//--------------
	//詳細記事ページ
	//--------------
	public function action_vine($method) {
		// 記事のHTML生成
		$article_data_array = Model_Article_Html::article_html_create($method, 'vine', true);
		// 記事のメタ生成
		$meta_html          = Model_Article_Html::article_meta_html_create($article_data_array, 168, 'vine');
		// 記事メタセット
		$this->vine_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => $meta_html,
		), false);

		// 記事タイトルセット
		$this->vine_template->view_data["title"] = $article_data_array["article_title"];
		// 記事コンテンツセット
		$this->vine_template->view_data["content"]->set('content_data', array(
			'content_html' => $article_data_array["article_html"],
		), false);
	}
	//------------
	//エラーページ
	//------------
	public function action_404() {
		// 記事メタセット
		$this->vine_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '<meta name="robots" content="noindex">',
		), false);
		// 記事コンテンツセット
		$this->vine_template->view_data["content"]->set('content_data', array(
			'content_html' => 'エラーページ',
		), false);
	}

}
