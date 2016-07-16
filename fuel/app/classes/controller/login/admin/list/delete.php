<?php 
/**
 * 下書きを削除するコントローラー
 * 
 * 
 * 
 * 
 */

class Controller_Login_Admin_List_Delete extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
//		var_dump($method, $params);
		// セグメント審査と軽い記事審査
		if(!$params && preg_match('/^[0-9]+$/', (int)$method, $method_array)) {
//			var_dump($method_array);
			$is_article = Model_Info_Basis::is_article($method);
//			var_dump($is_article);
			// 記事がある場合
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
			// まとめデータ取得
			$article_data_array = Model_Info_Basis::article_data_get($method);
			// まとめを書いた本人・管理人なら削除
			if($_SESSION['sharetube_id'] == $article_data_array['sharetube_id'] || $_SESSION['sharetube_id'] == 'mtoksuy') {
				// まとめを削除
				Model_Login_List_Basis::article_delete($method);
				header('Location: '.HTTP.'login/admin/list/');
				exit;
			}
				else {
					header('Location: '.HTTP.'');
					exit;
				}
		} // if($login_check) {
			else {
				header('Location: '.HTTP.'');
				exit;
			}
//			return $this->login_admin_template;
	} // public function action_index($method) {
	//------------
	//エラーページ
	//------------
	public function action_404() {
			header('Location: '.HTTP.'login/admin/list/');
	}
}