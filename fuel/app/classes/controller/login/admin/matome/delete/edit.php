<?php 
/**
 * 削除済み記事を編集するコントローラー
 * 
 * 
 * 
 * 
 */

class Controller_Login_Admin_Matome_Delete_Edit extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
//		var_dump($method, $params);
		// セグメント審査と軽い記事審査
		if (!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			// 削除された記事かあるかどうかを検査する
			$is_delete_article = Model_Info_Basis::is_delete_article($method);
//			var_dump($is_delete_article);
			// 削除された記事がある場合
			if($is_delete_article) {
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
	/////////////////////////
	// アクションインデックス
	/////////////////////////
	public function action_index($method) {
		$matome_number = (int)$method;

		// 記事データ取得
		$article_data_get_res = Model_Login_Matome_Delete_Edit_Basis::delete_article_data_get($matome_number);
		$article_array_data = array();
		// $article_array_data生成
		foreach($article_data_get_res as $key => $value) {
			$article_array_data["primary_id"]            = $value["primary_id"];
			$article_array_data["sharetube_id"]          = $value["sharetube_id"];
			$article_array_data["category"]              = $value["category"];
			$article_array_data["title"]                 = $value["title"];
			$article_array_data["sub_text"]              = $value["sub_text"];
			$article_array_data["tag"]                   = $value["tag"];
			$article_array_data["thumbnail_image"]       = $value["thumbnail_image"];
			$article_array_data["thumbnail_quote_url"]   = $value["thumbnail_quote_url"];
			$article_array_data["thumbnail_quote_title"] = $value["thumbnail_quote_title"];
			$article_array_data["random_key"]            = $value["random_key"];
			$article_array_data["delete_edit"]           = true;
		}


/*


◯ビュー
login/admin/matome/delete/list/


編集
http://localhost/sharetube/login/admin/matome/delete/edit/6767/
edit

次にやるべき事
delete編集フラグを追加して
編集htmlに渡して
申請するをプラスする



イマココ
確認
http://localhost/sharetube/login/admin/matome/delete/preview/?p=6767/
preview

本当の削除
http://localhost/sharetube/login/admin/matome/delete/delete/6767/
delete
*/


		$login_check = Model_Login_Basis::login_check();
		// ログインチェック
		if($login_check) {
			// 書いた人チェック
			if($article_array_data["sharetube_id"] == $_SESSION["sharetube_id"] || $_SESSION["sharetube_id"] == 'mtoksuy') {
				//------------------------
				//viewテンプレート読み込み
				//------------------------
				$this->login_admin_template            = View::forge('login/admin/matome/template');
				$this->login_admin_template->view_data = array(
					'title'   => 'まとめ再編集｜アドミン｜ログイン|'.TITLE,
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
	}
	//------------
	//エラーページ
	//------------
	public function action_404() {
		// 記事メタセット
//		$this->article_template->view_data["meta"]->set('meta_data', array(
//			'meta_html' => '<meta name="robots" content="noindex">',
//		), false);
		// 記事コンテンツセット
//		$this->article_template->view_data["content"]->set('content_data', array(
//			'article_html' => 'エラーページ',
//		), false);
	}
}