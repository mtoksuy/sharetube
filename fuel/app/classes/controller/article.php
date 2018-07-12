<?php
/*
* まとめコントローラー
* 
* 
* 
* 
*/

class Controller_Article extends Controller_Article_Template {
	// ルーター
	public function router($method, $params) {
		// intに戻す
		$method = (int)$method;
		// セグメント審査と軽い記事審査
		if (!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			// 記事があるかどうかを検査する
			$is_article = Model_Info_Basis::is_article($method);
//			var_dump($is_article);
			// 作成されたまとめ かつ削除されたまとめか調べる
			$is_article_delete = Model_Info_Basis::is_article_delete($method);
//			var_dump($is_article_delete);
			// 記事がある場合
			if($is_article) {
				return $this->action_index($method);
			}
				// エラー
				else {
					return $this->action_404($is_article_delete);
				}
		}
			// エラー
			else {
				$is_article_delete = false;
				return $this->action_404($is_article_delete);
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
		// intに戻す
		$method = (int)$method;
		// ユーザー情報取得
		$user_data_array = Model_Info_Basis::user_data_get();
		// 変数をエンティティ化する
		$user_data_array = Library_Security_Basis::variable_security_entity($user_data_array);
		// 記事データ取得
		$article_res = Model_Article_Basis::article_get('article', $method);

		// 一番ややこしい場所なのでまたトラブルがあるかもしれないので監視をする 2015.08.25 松岡
		// アクセスDB追加 & all_page_view & pay_pv をプラス & アクセスサマリー書き込み
		Model_Article_Basis::article_access_writing_and_all_page_view_plus($method, $user_data_array, $article_res);

		// スマホ用サムネイルHTML生成
		$sp_thumbnail_html = Model_Article_Html::sp_thumbnail_html_create($article_res);
		// サムネイル引用HTML生成
		$sp_thumbnail_quote_html = Model_Article_Html::thumbnail_quote_html_create('', true ,$article_res);
//var_dump($sp_thumbnail_quote_html);

		// sp_thumbnailデータセット
		$this->article_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
			'sp_thumbnail_html'       => $sp_thumbnail_html,
			'sp_thumbnail_quote_html' => $sp_thumbnail_quote_html,
		), false);

		// 記事のHTML生成
		$article_data_array = Model_Article_Html::article_html_create($article_res);
		// 記事のメタ生成
		$meta_html          = Model_Article_Html::article_meta_html_create($article_data_array, 168);
		// 記事メタセット
		$this->article_template->view_data["meta"]->set('meta_data', array(
			'meta_html' => $meta_html,
		), false);

		// 記事タイトルセット
		$this->article_template->view_data["title"] = $article_data_array["article_title"];

		// オールヘッダーアドHTML生成
		$all_header_ad_html = Model_Article_Html::all_header_ad_html_create();
		$all_header_ad_html = '';

		// ヘッダーSharetube宣伝セット
		$this->article_template->view_data['header']->set('content_data',array(
			'all_header_ad_html' => $all_header_ad_html,
		), false);

		// ナビゲーションセット
		$this->article_template->view_data['navigation']->set('content_data', array(
			'navigation_html' => '',
		), false);

		// 記事コンテンツセット
		$this->article_template->view_data["content"]->set('content_data', array(
			'article_html' => $article_data_array["article_html"],
		), false);

		// 人気記事HTML生成
		$article_access_1_res  = Model_Article_Basis::article_access_get(1,8);
		$article_access_7_res  = Model_Article_Basis::article_access_get(7,8);
		$article_access_30_res = Model_Article_Basis::article_access_get(30,8);
		$popular_html       = Model_Article_Html::article_popular_html_create($article_access_1_res, $article_access_7_res, $article_access_30_res, 'article');

		// 関連記事データ取得
//		list($related_res, $related_count) = Model_Article_Basis::article_related_get($article_data_array, 'article');
		// 関連記事HTML生成
//		$related_html                      = Model_Article_Html::article_related_html_create($related_res, $related_count);

		// シャッフル記事データ取得 
//		$shuffle_res = Model_Article_Basis::article_shuffle_get($method, 'article', 4);
		// シャッフル記事HTML生成
//		$shuffle_html = Model_Article_Html::article_shuffle_html_create($shuffle_res, 'article');
		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get($method, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->article_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// sharetube_id取得
		foreach($article_res as $key => $value) {
			$sharetube_id = $value["sharetube_id"];
		}
		// Sharetubeのユーザーデータ取得
		$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($sharetube_id);
		// Sharetubeユーザーの書いた記事数を取得
		$article_count = Model_Info_Basis::sharetube_user_article_count_get($sharetube_id);
		// profile_cardHTML生成
		$profile_card_html = Model_Channel_Html::profile_card_html_create($sharetube_user_data_array, $article_count);

		// PRまとめデータ取得
			$pr_res = Model_Article_Basis::article_pr_res_get(array(12277));
		// PRまとめHTML生成
		$pr_html = Model_Article_Html::article_inside_pr_html_create($pr_res, 'article');
		// サイドバーコンテンツセット
		$this->article_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html'      => $popular_html,
			'pr_html'           => $pr_html,
			'related_html'      => '',
			'shuffle_html'      => '',
			'profile_card_html' => $profile_card_html,
		),false);



		// まとめのテーマ取得
		$theme_list = Model_Article_Html::article_theme_get($article_res);
		// テーマHTML生成
		list($tag_array, $tag_html) = Model_Article_Html::article_tag_html_create($theme_list, 3600);
		// インタースティシャル広告判定
		$ad_article_interstitial_check = Model_Ad_Basis::interstitial_permission_theme_ad_html_get($tag_array, $ad_article_interstitial_html);
		// モバイルアドコンテンツセット
		$this->article_template->view_data["mobile_ad"]->set('content_data', array(
			'ad_article_interstitial_check' => $ad_article_interstitial_check,
		),false);

		// 追加コンテンツ コンテンツセット
		$this->article_template->view_data["plus_add"]->set('plus_add_data', array(
			'social_share_html' => $article_data_array["social_share_html"], 
		),false);

		// アーカイブデータ取得
//		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
//		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		// アーカイブコンテンツセット
		$this->article_template->view_data["footer"]->set('footer_data', array(
//			'archive_html' => $archive_li_html,
		), false);
	}
	//------------
	//エラーページ
	//------------
	public function action_404($is_article_delete) {
		if($is_article_delete) {
			$error_word = 'このまとめは作成者の操作により、または<a href="'.HTTP.'rule/rule/">利用規約</a>違反で運営から削除されました。<br><br><br><br><br><br><br>';
		}
			else {
				$error_word = 'エラーページ<br><br><br><br><br><br><br><br><br>';
			}
//		var_dump($this);
		// 404ステータスにする
	$this->response_status                                      = 404;
	$this->active_request->response->status                     = 404;
	$this->active_request->controller_instance->response_status = 404;
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
			'article_html' => $error_word,
		), false);

		// サイドバーコンテンツセット
		$this->article_template->view_data["sidebar"] = '';
		// スクリプトコンテンツセット
		$this->article_template->view_data["script"] = '';

	}
}
