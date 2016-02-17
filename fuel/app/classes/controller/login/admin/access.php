<?php 
/**
 * Adminコントローラー
 * 
 * アクセスランキングを表示する機能
 * 
 * 
 */

 class Controller_Login_Admin_Access extends Controller_Login_Template {
	 public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'リスト｜ポスト｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/list/list'),
			);
			// アクセスres取得
			$article_access_1_res = Model_Article_Basis::article_access_get(1, 200);
			// アクセスHTML生成
			$article_access_html = Model_Login_Access_Html::article_access_html_create($article_access_1_res);

			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'content_html' => $article_access_html,
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
