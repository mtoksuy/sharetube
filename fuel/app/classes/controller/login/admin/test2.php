<?php 
/**
 * Postコントローラー
 * 
 * 記事を投稿する機能
 * 
 * 
 */

class Controller_Login_Admin_Test2 extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {

			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'ポスト｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/test/bearertoken'),
			);
			return $this->login_admin_template;
		}
			// ログインしてなかったらトップに飛ぶ
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}