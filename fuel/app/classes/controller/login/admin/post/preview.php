<?php
/**
 * プレビューコントローラー
 * 
 * 下書きをプレビューする機能
 * 
 * 
 */

class Controller_Login_Admin_Post_Preview extends Controller_Login_Admin_Post_preview_Template {
	public function action_index() {
		session_start();
		$method = (int)$_GET["p"];
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check == 'd') {
			// 下書き記事取得
			$preview_article_res = Model_Login_Post_Preview_Basis::preview_article_get($method);
			// スマホ用サムネイルHTML生成
			$sp_thumbnail_html = Model_Article_Html::sp_thumbnail_html_create($preview_article_res);
			// sp_thumbnailデータセット
			$this->article_template->view_data["sp_thumbnail"]->set('sp_thumbnail_data', array(
				'sp_thumbnail_html' => $sp_thumbnail_html,
			), false);
//			pre_var_dump($preview_article_res);

			// 記事のHTML生成
			$article_data_array = Model_Article_Html::article_html_create($preview_article_res, 'article', true);
//			var_dump($article_data_array);

			// 記事のメタ生成
			$meta_html          = Model_Article_Html::article_meta_html_create($article_data_array, 168);
			// 記事メタセット
			$this->article_template->view_data["meta"]->set('meta_data', array(
				'meta_html' => '<meta name="robots" content="noindex">',
			), false);
	
			// 記事タイトルセット
			$this->article_template->view_data["title"] = $article_data_array["article_title"];
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
			list($related_res, $related_count) = Model_Article_Basis::article_related_get($article_data_array, 'article');
			// 関連記事HTML生成
			$related_html                      = Model_Article_Html::article_related_html_create($related_res, $related_count);
	
			// シャッフル記事データ取得 
			$shuffle_res = Model_Article_Basis::article_shuffle_get($method, 'article');
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
				'related_html' => $related_html,
				'shuffle_html' => $shuffle_html,
			),false);
	
			// 追加コンテンツ コンテンツセット
			$this->article_template->view_data["plus_add"]->set('plus_add_data', array(
				'social_share_html' => $article_data_array["social_share_html"], 
			),false);
		}
			// ログインしてなかったらトップに飛ぶ
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}