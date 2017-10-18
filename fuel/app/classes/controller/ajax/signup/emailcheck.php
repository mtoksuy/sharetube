<?php
/*
* Ajax メールアドレスをリアルタイムでチェック コントローラー
* 
* 
* 
*/
class Controller_Ajax_Signup_Emailcheck extends Controller {
	// アクション
	public function action_index() {
		// ポスト取得
		$post = Library_Security_Basis::post_security();
		// 新規登録メールアドレスチェック
		$user_email_check = Model_Signup_Basis::email_check($post);

		// データセット
		$json_data = array(
			'email'       => $post['email'],
			'email_check' => $user_email_check,
		);
		return json_encode($json_data);
	}
}
