<?php 
/**
 * Adminコントローラー
 * 
 * 管理画面を操作する。
 * 
 * 
 */

class Controller_Login_Admin extends Controller_Login_template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		// ログインしている場合
		if($login_check) {
		// viewテンプレート読み込み
		$this->login_admin_template            = View::forge('login/admin/template');
		$this->login_admin_template->view_data = array(
			'title'   => 'アドミン｜ログイン|'.TITLE,
			'content' => View::forge('login/admin/admin'),
		);
//			$admin_login_html = View::forge('login/admin/admin');
			return $this->login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}