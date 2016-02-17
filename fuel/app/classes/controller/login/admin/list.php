<?php 
/**
 * Postコントローラー
 * 
 * 記事リストを表示する機能
 * 
 * 
 */

class Controller_Login_Admin_List extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// 自分が書いた記事を取得
			$article_list_get_res = Model_Login_List_Basis::article_list_get();
//			var_dump($article_list_get_res);
			// リストHTML取得
			$article_list_html = Model_Login_List_Html::article_list_html_create($article_list_get_res);
//			var_dump('ffffffffffffffff'.$article_list_html);
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'リスト｜ポスト｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/list/list'),
			);
			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'content_html' => $article_list_html,
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