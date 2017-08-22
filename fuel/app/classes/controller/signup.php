<?php
/*
* サインアップコントローラー
* 
* 
* 
* 
*/

class Controller_Signup extends Controller_Signup_Template {
	// ルーター
	public function router($method, $params) {
		return $this->action_index($method);
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	// アクション
	public function action_index($method) {
		// タイトルセット
		$this->signup_template->view_data["title"] = '新規登録 | '.TITLE;
		// cssデータセット
		$this->signup_template->view_data["external_css"] = View::forge('signup/externalcss');
		$post  = Model_Security_Basis::post_security();

		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		// ログインしている場合
		if($login_check) {
			header('location: '.HTTP.'login/admin/');
			exit;
		}


		// ポストがある場合
		if($post) {
//			var_dump($post);
			// sharetube_idチェック
			$user_sharetube_id_check = Model_Signup_Basis::sharetube_id_check($post);
			// メールアドレスチェック
			$user_email_check        = Model_Signup_Basis::email_check($post);
			// パスワードをチェック
			$user_password_check     = Model_Signup_Basis::password_check($post);
			// sharetube_idがtrueの場合
			if($user_sharetube_id_check) {
				// emailがtrueの場合
				if($user_email_check) {
					// パスワードがtrueの場合
					if($user_password_check) {
						// ユーザー登録
						Model_Signup_Basis::user_signup($post);
					}
				}
			} // if($user_sharetube_id_check) {
		} // if($post) {
		///////////////
		// HTML関連制御
		///////////////
		if($user_sharetube_id_check === true && $user_password_check === true && $user_email_check === true) {
			// HTML持ってくる
			$signup_html = View::forge('signup/complete/complete');
		}
			else {
				// HTML持ってくる
				$signup_html = View::forge('signup/signup');
			}
		// コンテンツセット
		$this->signup_template->view_data["content"]->set('content_data', array(
			'content_html' => $signup_html,
		));
		// フォーム制御変数コンテンツセット
		$this->signup_template->view_data["content"]->content_data["content_html"]->set('sign_data', array(
			'user_sharetube_id_check' => $user_sharetube_id_check,
			'user_email_check'        => $user_email_check,
			'user_password_check'     => $user_password_check,
		));

		// シャッフル記事データ取得
		$shuffle_res = Model_Article_Basis::article_shuffle_get(1, 'article', 1);
		// シャッフルボタン記事link生成
		$shuffle_article_link = Model_Article_Html::article_shuffle_button_link_create($shuffle_res);
		// シャッフルボタン記事linkセット
		$this->signup_template->view_data["header"]->set('header_data', array(
			'shuffle_article_url' => $shuffle_article_link,
		), false);

		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);

		// アーカイブコンテンツセット
		$this->signup_template->view_data["footer"]->set('footer_data', array(
//			'archive_html' => $archive_li_html,
		), false);

	}
	//------------
	//エラーページ
	//------------
	public function action_404() {
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
			'article_html' => 'エラーページ',
		), false);

		// サイドバーコンテンツセット
		$this->permalink_template->view_data["sidebar"]->set('sidebar_data', array(
			'popular_html' => '',
			'related_html' => '',
			'shuffle_html' => '',
		),false);
	}
}
