<?php 
/**
 * Matomeコントローラー
 * 
 * 記事を投稿する機能
 * 
 * 
 */

class Controller_Login_Admin_Matome extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
		switch($method) {
			// 新規作成
			case 'index':
				return $this->action_index($method,$params[0]);
			break;
			// 下書き編集
			case 'draft':
//				var_dump($method);
//				var_dump($params);
				return $this->action_index($method,$params[0]);
			break;
			// 記事編集
			case 'edit':
				return $this->action_index($method,$params[0]);
			break;
		}
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	/////////////////////////
	// アクションインデックス
	/////////////////////////
	public function action_index($method, $params) {
		switch($method) {
			// 新規作成
			case 'index':
				$article_array_data = array();
				$article_array_data["sharetube_id"] = $_SESSION["sharetube_id"];
			break;
			// 下書き編集
			case 'draft':
				$matome_number = (int)$params;
				// 下書きデータ取得
				$article_data_get_res = Model_Login_List_Draft_Basis::draft_article_data_get($matome_number);
				$article_array_data = array();
				// $article_array_data生成
				foreach($article_data_get_res as $key => $value) {
					$article_array_data["primary_id"]      = $value["primary_id"];
					$article_array_data["sharetube_id"]    = $value["sharetube_id"];
					$article_array_data["category"]        = $value["category"];
					$article_array_data["title"]           = $value["title"];
					$article_array_data["sub_text"]        = $value["sub_text"];
					$article_array_data["tag"]             = $value["tag"];
					$article_array_data["thumbnail_image"] = $value["thumbnail_image"];
					$article_array_data["random_key"]      = $value["random_key"];
					$article_array_data["draft"]           = $value["draft"];
				}
			break;
			// 記事編集
			case 'edit':
				$matome_number = (int)$params;
				// 記事データ取得
				$article_data_get_res = Model_Login_List_Edit_Basis::article_data_get($matome_number);
				$article_array_data = array();
				// $article_array_data生成
				foreach($article_data_get_res as $key => $value) {
					$article_array_data["primary_id"]      = $value["primary_id"];
					$article_array_data["sharetube_id"]    = $value["sharetube_id"];
					$article_array_data["category"]        = $value["category"];
					$article_array_data["title"]           = $value["title"];
					$article_array_data["sub_text"]        = $value["sub_text"];
					$article_array_data["tag"]             = $value["tag"];
					$article_array_data["thumbnail_image"] = $value["thumbnail_image"];
					$article_array_data["random_key"]      = $value["random_key"];
					$article_array_data["edit"]            = true;
				}
			break;
		}
		$login_check = Model_Login_Basis::login_check();
		// ログインチェック
		if($login_check) {
			// 書いた人チェック
			if($article_array_data["sharetube_id"] == $_SESSION["sharetube_id"] || $_SESSION["sharetube_id"] == 'mtoksuy') {
				// ポスト取得
				$post = Library_Security_Basis::post_security();
				//------------------------
				//viewテンプレート読み込み
				//------------------------
				$this->login_admin_template            = View::forge('login/admin/matome/template');
				$this->login_admin_template->view_data = array(
					'title'   => 'まとめ作成｜アドミン｜ログイン|'.TITLE,
					'content' => View::forge('login/admin/matome/matome'),
				);
				//  postセット
				$this->login_admin_template->view_data["content"]->set('post_data', array(
					'post' => $article_array_data,
				),false);
				return $this->login_admin_template;
			}
				// 他のアカウントのまとめならadminに戻る
				else {
					header('Location: '.HTTP.'login/admin/');
					exit;
				}
		} // if($login_check) {
			// ログインしてなかったらトップに飛ぶ
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	} // public function action_index() {

}