<?php 
/**
 * Adminコントローラー
 * 
 * ユーザーにメールを送る機能
 * 
 * 
 */

 class Controller_Login_Admin_Mail extends Controller_Login_Template {
	 public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'メール｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/list/list'),
			);

			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'content_html' => View::forge('login/admin/mail/mail'),
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
