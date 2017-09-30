<?php
/*
* Ajax パスワードをリアルタイムでチェック コントローラー
* 
* 
* 
*/
class Controller_Ajax_Signup_Passwordcheck extends Controller {
	// アクション
	public function action_index() {
		// ポスト取得
		$post = Library_Security_Basis::post_security();
		// 新規登録パスワードチェック
		$user_password_check = Model_Signup_Basis::password_check($post);

		// データセット
		$json_data = array(
			'password'       => $post['password'],
			'password_check' => $user_password_check,
		);
		return json_encode($json_data);
	}
}
