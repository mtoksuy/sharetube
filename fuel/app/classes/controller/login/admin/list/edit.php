<?php 
/**
 * Postコントローラー
 * 
 * 記事を投稿する機能
 * 
 * 
 */

class Controller_Login_Admin_List_Edit extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
//		var_dump($method, $params);
		// セグメント審査と軽い記事審査
		if (!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$is_article = Model_Info_Basis::is_article($method);
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
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// ポスト取得
			$post = Library_Security_Basis::post_security();
			if($post == true) {
//				var_dump($post);
				// 記事編集
				Model_Login_List_Edit_Basis::article_edit($post);
				// ディレクトリ配下のファイルを削除するディレクトリパス
//				$cache_db_path = INTERNAL_PATH.'fuel/app/cache/db/';
				// ディレクトリー内のファイルを全削除(cache削除)
//				Library_Dir_Basis::dir_file_all_del($cache_db_path);
				header ('location: '.HTTP.'login/admin/list/');
				exit();
			}




			// 記事データ取得
			$article_data_get_res = Model_Login_List_Edit_Basis::article_data_get((int)$method);
			// 
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'リスト｜ポスト｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/list/edit/edit'),
			);
			// コンテンツ挿入
			foreach($article_data_get_res as $key => $value) {
				$this->login_admin_template->view_data["content"]->set('edit_data',array(
					'primary_id'   => $value["primary_id"],
					'category'     => $value["category"],
					'title'        => $value["title"],
					'sub_text'     => $value["sub_text"],
					'contents'     => $value["contents"],
					'text'         => $value["text"],
					'tag'          => $value["tag"],
					'original'     => $value["original"],
					'sp_thumbnail' => (int)$value["sp_thumbnail"],
					'del'          => $value["del"],
				),false);				
			}
			return $this->login_admin_template;
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