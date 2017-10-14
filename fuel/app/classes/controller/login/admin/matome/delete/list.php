<?php 
/**
 * 削除済み記事一覧コントローラー
 * 
 * 削除済み記事をリスト表示する機能
 * 
 * 
 */

class Controller_Login_Admin_Matome_Delete_List extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// 削除した記事を取得
			$delete_article_list_get_res = Model_Login_Matome_Delete_Basis::delete_article_list_get();
			// 削除記事HTML生成
			$delete_article_list_html = Model_Login_Matome_Delete_Html::delete_article_list_html_create($delete_article_list_get_res);

			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => '下書き｜リスト｜削除まとめ｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/list/list'),
			);
			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'content_html' => $delete_article_list_html,
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