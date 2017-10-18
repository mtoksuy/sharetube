<?php
/*
* Ajax Sharetube_idをリアルタイムでチェック コントローラー
* 
* 
* 
*/
class Controller_Ajax_Signup_Sharetubeidcheck extends Controller {
	// アクション
	public function action_index() {
		// ポスト取得
		$post = Library_Security_Basis::post_security();
		// 新規登録sharetube_idチェック
		$user_sharetube_id_check = Model_Signup_Basis::sharetube_id_check($post);
		// データセット
		$json_data = array(
			'sharetube_id'       => $post['sharetube_id'],
			'sharetube_id_check' => $user_sharetube_id_check,
		);
		return json_encode($json_data);
	}
}
