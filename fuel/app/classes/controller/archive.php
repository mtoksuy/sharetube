<?php
/*
* アーカイブコントローラー
* 
* 
* 
* 
*/

class Controller_Archive extends Controller_Article_Template {
	// ルーター
	public function router($method, $params) {
//		var_dump($method);
//		var_dump($params);
	// アーカイブトップ
	if($method  == 'index') {
		return $this->action_index();
	}
		// セグメント審査＆記事審査
		else if (preg_match('/^[0-9]+$/', $params[0], $params_array)  && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$year  = $method;
			$month = $params["0"];
			$is_archiva_article = Model_Info_Basis::is_archiva_article($year, $month);
			if($is_archiva_article) {
				$this->action_detail($method, $params);
			}
				else {
//			var_dump($is_archiva_article);
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
	// アクションインデックス
	public function action_index() {
		// アーカイブタイトルセット
		$this->article_template->view_data["title"] = 'アーカイブ｜'.TITLE;
		// アーカイブcssセット
		$this->article_template->view_data['external_css'] = View::forge('archive/externalcss');

		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// 合体
		$archive_html = 
			'<div class="archive_card">
				<div class="archive_card_content">
					<div class="card_article_header">
						<span class="typcn typcn-document-text"></span><span>アーカイブ</span>
					</div>
					<ul class="clearfix">
						'.$archive_li_html.'
					</ul>
				</div>
			</div>';
		// コンテンツデータセット
		$this->article_template->view_data["content"]->set('content_data', array(
			'article_html' => $archive_html,
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
		$this->article_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// サイドバーコンテンツセット
		$this->article_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => $popular_html,
			'related_html' => '',
			'shuffle_html' => $shuffle_html,
		),false);


/*
		// アーカイブコンテンツセット
		$this->article_template->view_data["footer"]->set('footer_data', array(
			'archive_html' => $archive_li_html,
		), false);
*/
	}
	// アクションディテール
	public function action_detail($method, $params) {
		$year  = $method;
		$month = $params["0"];
//		var_dump($month);
		// アーカイブタイトルセット
		$this->article_template->view_data["title"] = $year.'年'.$month.'月｜アーカイブ｜'.TITLE;

		// アーカイブ記事一覧データ取得
		$list_query = Model_Archive_Basis::archive_article_list_get($year, $month, 300);
		// アーカイブ記事一覧HTML生成
		$article_list_html = Model_Article_Html::itype_list_html_create($list_query);
		// コンテンツデータセット
		$this->article_template->view_data["content"]->set('content_data', array(
			'article_html' => $article_list_html,
		), false);


		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,8);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,8);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,8);
		$popular_html       = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');

		// シャッフル記事データ取得 
		$shuffle_res = Model_Article_Basis::article_shuffle_get($method, 'article', 4);
		// シャッフル記事HTML生成
		$shuffle_html = Model_Article_Html::article_shuffle_html_create($shuffle_res, 'article');
		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get($method, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->article_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// サイドバーコンテンツセット
		$this->article_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => $popular_html,
			'related_html' => '',
			'shuffle_html' => $shuffle_html,
		),false);


		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->article_template->view_data["footer"]->set('footer_data', array(
//			'archive_html' => $archive_li_html,
		), false);
	}
	//------------
	//エラーページ
	//------------
	public function action_404() {
		// 記事メタセット
		$this->article_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => '<meta name="robots" content="noindex">',
		), false);

		// sp_thumbnailデータセット
		$this->article_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html' => '',
		), false);

		// 記事コンテンツセット
		$this->article_template->view_data["content"]->set('content_data', array(
			'article_html' => 'エラーページ',
		), false);

		// サイドバーコンテンツセット
		$this->article_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => '',
			'related_html' => '',
			'shuffle_html' => '',
		),false);
	}
}
