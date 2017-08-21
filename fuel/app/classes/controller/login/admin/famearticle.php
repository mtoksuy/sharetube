<?php 
/**
 * Adminコントローラー
 * 
 * 殿堂まとめを追加する機能
 * 
 * 
 */

 class Controller_Login_Admin_Famearticle extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
		$params = $params[0];
		$mail_array_data = array();
		// メール送信画面表示
		if($method == 'index') {
			return $this->action_index();
		}
			else if($method == 'submit') {
				return $this->action_submit();
			}
	}
	////////////////
	//通常アクション
	////////////////
	public function action_index() {
	// ログインチェック
	$login_check = Model_Login_Basis::login_check();
	if($login_check) {
		// viewテンプレート読み込み
		$this->login_admin_template            = View::forge('login/admin/template');
		$this->login_admin_template->view_data = array(
			'title'   => '殿堂まとめ追加｜ポスト｜アドミン｜ログイン|'.TITLE,
			'content' => View::forge('login/admin/list/list'),
		);
		// コンテンツ挿入
		$this->login_admin_template->view_data["content"]->set('content_data',array(
			'content_html' => View::forge('login/admin/famearticle/famearticle'),
		),false);
		return $this->login_admin_template;
	}
		// ログインしていない場合
		else {
			header('Location: '.HTTP.'');
			exit;
		}
	}
	//////////////////
	//Submitアクション
	//////////////////
	public function action_submit() {
	// ログインチェック
	$login_check = Model_Login_Basis::login_check();
	if($login_check) {
		// viewテンプレート読み込み
		$this->login_admin_template            = View::forge('login/admin/template');
		$this->login_admin_template->view_data = array(
			'title'   => '殿堂まとめ追加｜ポスト｜アドミン｜ログイン|'.TITLE,
			'content' => View::forge('login/admin/list/list'),
		);
		// セキュリティーポスト取得
		$post = Library_Security_Basis::post_security();
		if($post) {
			$fame_article_list = $post['fame_article_list'];
			// 殿堂まとめ追加するためのarray生成
			$fame_article_list_array = Model_Login_Recommendarticle_Basis::recommend_article_array_get($fame_article_list);
			// 殿堂まとめ登録
			Model_Login_Famearticle_Basis::fame_article_array_register($fame_article_list_array);
			header('location: '.HTTP.'login/admin/');
			exit;
		}
		// コンテンツ挿入
		$this->login_admin_template->view_data["content"]->set('content_data',array(
			'content_html' => '殿堂まとめ追加いたしました。',
		),false);
		return $this->login_admin_template;
	}
		// ログインしていない場合
		else {
			header('Location: '.HTTP.'');
			exit;
		}

	}





}
