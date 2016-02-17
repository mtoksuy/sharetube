<?php 
/**
 * 下書きを削除するコントローラー
 * 
 * 
 * 
 * 
 */

class Controller_Login_Admin_Draft_List_Delete extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
//		var_dump($method, $params);
		// セグメント審査と軽い記事審査
		if (!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$is_article = Model_Info_Basis::is_draft_article($method);
//			var_dump($is_article);
			// 下書きがある場合
			if($is_article) {
				return $this->action_index($method);
			}
				// エラー
				else {
					return $this->action_404();
				}
		}
			// エラー
			else {
				 return $this->action_404();
			}
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	// アクション
	public function action_index($method) {
		// 数字にキャスト
		$method = (int)$method;
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// 下書きを削除
			Model_Login_List_Draft_Basis::draft_article_delete($method);
			header('Location: '.HTTP.'login/admin/draft/list/');
			exit;
//			return $this->login_admin_template;
		}
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
	//------------
	//エラーページ
	//------------
	public function action_404() {

	}
}