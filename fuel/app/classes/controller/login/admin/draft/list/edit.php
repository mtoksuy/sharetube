<?php 
/**
 * 下書きを編集するコントローラー
 * 
 * 
 * 
 * 
 */

class Controller_Login_Admin_Draft_List_Edit extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
//		var_dump($method, $params);
		// セグメント審査と軽い記事審査
		if (!$params && preg_match('/^[0-9]+$/', $method, $method_array)) {
			$is_article = Model_Info_Basis::is_draft_article($method);
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
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// ポスト取得
			$post = Library_Security_Basis::post_security();
			if($post == true) {
//				var_dump($post);
				// 下書きの場合
				if($post["draft"]) {
					if($post["random_key"]) {
						// サムネイル精査する為に下書きデータ取得
						$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
						$article_data_get_res = Model_Login_List_Draft_Basis::draft_article_data_get((int)$method);
						// ランダムキー取得
						foreach($article_data_get_res as $key => $value) {
							$random_key = $value["random_key"];
						}
						// サムネイル精査
						if(!preg_match("/".$post["random_key"]."/", $random_key)) {
							// サムネイルの名前取得
							$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
							$create_dir = PATH.'assets/img/draft/article/'.date("Y").'/';	
							// サムネイル作成
							Model_Login_Post_Basis::thumbnail_create($create_dir, $image_path);
							$post["thumbnail_create"] = true;
						} // if(!preg_match("/".$post["random_key"]."/", $random_key)) {
					} // if($post["random_key"]) {

					// サムネイルの名前取得
					$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
					// 記事作成データ取得
					$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
					$article_create_data_array["thumbnail_image"] = $image_path;
					$article_create_data_array["draft_primary_id"] = (int)$method;
//					var_dump($article_create_data_array);
					// 記事下書き保存
					$draft_primary_id = Model_Login_Post_Draft_Basis::article_draft_update($article_create_data_array);

				} // if($post["draft"]) {
				// 投稿の場合
				if($post["submit"]) {
					// 記事データ取得
					$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
					$article_create_data_array["draft_primary_id"] = (int)$method;
					// サムネイルの名前取得
					$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
					$article_create_data_array["thumbnail_image"] = $image_path;
//					var_dump($article_create_data_array);

					// 作成場所
					$create_dir = 'article/';
					// ディレクトリ作成
					Model_Dir_Basis::thumbnail_dir_create($create_dir, $article_create_data_array["article_year_time"]);

					// サムネイル作成場所
					$create_dir = PATH.'assets/img/draft/article/'.date("Y").'/';
					// サムネイル作成
					Model_Login_Post_Basis::thumbnail_create($create_dir, $image_path);
					// サムネイルコピー
					Model_Login_Post_Basis::draft_thumbnail_copy($article_create_data_array);
//								var_dump($article_create_data_array);
					// 拡張子取得
					$extends = str_replace($article_create_data_array["random_key"], "", $article_create_data_array["thumbnail_image"]);
					// 記事ナンバーを付ける
					$thumbnail_name = $article_create_data_array["link"].$extends;
					// サムネイル保管場所変更
					$article_create_data_array["thumbnail_image"] = $thumbnail_name;
					// 記事作成
					Model_Login_Post_Basis::article_create($article_create_data_array);
					// 下書き削除
					Model_Login_Post_Draft_Basis::draft_hide($article_create_data_array);
//					Model_Login_List_Draft_Edit_Basis::draft_delete($article_create_data_array);
					// rss作成
					Model_Login_Post_Basis::rss_create_2();
					// ディレクトリ配下のファイルを削除するディレクトリパス
//					$cache_db_path = INTERNAL_PATH.'fuel/app/cache/db/';
					// ディレクトリー内のファイルを全削除(cache削除)
//					Library_Dir_Basis::dir_file_all_del($cache_db_path);
					// ダッシュボードに戻る
					header('Location: '.HTTP.'login/admin/');
					exit;
				}
			} // if($post == true) {

			// 記事データ取得       Model_Login_List_Draft_Basis
			$article_data_get_res = Model_Login_List_Draft_Basis::draft_article_data_get((int)$method);
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => '編集｜下書き｜リスト｜ポスト｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/draft/list/edit/edit'),
			);
			// コンテンツ挿入
			foreach($article_data_get_res as $key => $value) {
				$this->login_admin_template->view_data["content"]->set('post_data',array(
					'primary_id'      => $value["primary_id"],
					'sheretube_id'    => $value["sharetube_id"],
					'category'        => $value["category"],
					'title'           => $value["title"],
					'sub_text'        => $value["sub_text"],
					'contents'        => $value["contents"],
					'text'            => $value["text"],
					'tag'             => $value["tag"],
					'original'        => $value["original"],
					'thumbnail_image' => $value["thumbnail_image"],
					'sp_thumbnail'    => (int)$value["sp_thumbnail"],
					'link'            => $value["link"],
					'random_key'      => $value["random_key"],
					'draft'           => $value["draft"],
					'del'             => $value["del"],
					'create_time'     => $value["create_time"],
					'update_time'     => $value["update_time"],
				),false);
//			var_dump($value);
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