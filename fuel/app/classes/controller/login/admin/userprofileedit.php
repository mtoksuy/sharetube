<?php 
/**
 * ユーザープロフィールエディットコントローラー
 * 
 * ユーザーのプロフィールを編集するページ
 * 
 * 
 */

class Controller_Login_Admin_Userprofileedit extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'プロフィール編集｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/userprofileedit/userprofileedit'),
			);
			// ポスト取得
			$post  = Model_Security_Basis::post_security();
			if($post) {
				// ユーザー情報編集
				Model_Login_User_Basis::user_data_edit($post);
				$user_data_edit_complete_text = '編集完了しました！';
			}
				else {
					$user_data_edit_complete_text = '';
				}
			// Sharetubeのユーザーデータ取得
			$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($_SESSION["sharetube_id"], 0);

//			var_dump($sharetube_user_data_array);
			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'user_data'                   => $sharetube_user_data_array,
				'user_data_edit_complete_text'=> $user_data_edit_complete_text,
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