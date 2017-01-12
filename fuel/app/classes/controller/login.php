<?php 
/**
 * ログインを操作するコントローラー
 * 
 * ログイン機能
 * 
 * 
 */

class Controller_Login extends Controller_Login_Template {
	// アクション
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();


		// ログインしている場合
		if($login_check) {
			header('location: '.HTTP.'login/admin/');
			exit;
		}
			// ログインしていない場合
			else {
				// ポスト取得
				$post = Library_Security_Basis::post_security();
				$lohin_message = '';
				// ログインを試す
				if($post == true) {
					$lohin_message = Model_Login_Basis::login($post);
				}
				// ビュー
				$admin_html = View::forge('login/login');
				$admin_html->set('content_data',array(
					'login_message' => $lohin_message,
				), false);
				return $admin_html;
		}
	}
}