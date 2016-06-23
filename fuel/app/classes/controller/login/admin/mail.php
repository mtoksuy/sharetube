<?php 
/**
 * Adminコントローラー
 * 
 * ユーザーにメールを送る機能
 * 
 * 
 */

 class Controller_Login_Admin_Mail extends Controller_Login_Template {
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
	//////////////////////////
	//メール送信画面アクション
	//////////////////////////
	 public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// マスターだけ操作可能
			if($_SESSION["sharetube_id"] == 'mtoksuy') {
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
		} // if($login_check) {
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	 }
	//////////////////////////
	//メール送信画面アクション
	//////////////////////////
	 public function action_submit() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'サブミット|メール｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/list/list'),
			);

			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'content_html' => 'Sharetube全ユーザーにメールを送信致しました。',
			),false);
			// ポスト取得
			$post = Library_Security_Basis::post_security();
			// メール配信許可があるsharetubeユーザーのresを取得
			$mail_delivery_ok_sharetube_id_uses_data_res = Model_Login_Mail_Basis::mail_delivery_ok_sharetube_id_uses_data_res_get();
			// メール送信許可があるSharetubeユーザーにメール送信
			Model_Mail_Basis::mail_delivery_ok_sharetube_id_uses_mail_send($post, $mail_delivery_ok_sharetube_id_uses_data_res);

			return $this->login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	 }
}
