<?php 
/**
 * imageuploadコントローラー
 * 
 * 画像をアップロードする機能
 * 
 * 
 */

 class Controller_Login_Admin_Imageupload extends Controller_Login_Template {
	 public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$this->login_admin_template = View::forge('login/admin/template');
			// データセット
			$this->login_admin_template->view_data = array(
				'title'   => '画像アップロード ｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/list/list'),
				// 単純に呼び込むならこれでも良い
//				'content' => View::forge('login/admin/decoration/decoration'),
			);
			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'content_html' => View::forge('login/admin/imageupload/imageupload'),
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
