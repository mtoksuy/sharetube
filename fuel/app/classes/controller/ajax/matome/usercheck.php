<?php
/*
* Ajax まとめ ユーザーチェックコントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Usercheck extends Controller {
	// アクション
	public function action_index() {
		// セッションスタート
		session_start();
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			$sharetube_user_data = Model_Info_Basis::sharetube_user_data_get($_SESSION["sharetube_id"]);
		}

		header ("Content-Type: text/javascript; charset=utf-8");
		$json_data = array(
			'sharetube_user_data' => $sharetube_user_data,
		);
		return json_encode($json_data);
	}
}