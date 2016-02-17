<?php 
/**
 * Postコントローラー
 * 
 * 下書き記事をリスト表示する機能
 * 
 * 
 */

class Controller_Login_Admin_Draft_List extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// 自分が書いた下書きを取得
			$draft_article_list_get_res = Model_Login_List_Draft_Basis::draft_article_list_get();
			// 下書き記事HTML生成
			$article_list_html = Model_Login_List_draft_Html::draft_article_list_html_create($draft_article_list_get_res);
//			var_dump('ffffffffffffffff'.$article_list_html);
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => '下書き ｜リスト｜ポスト｜アドミン｜ログイン|'.TITLE,
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