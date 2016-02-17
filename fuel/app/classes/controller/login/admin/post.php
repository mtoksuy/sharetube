<?php 
/**
 * Postコントローラー
 * 
 * 記事を投稿する機能
 * 
 * 
 */

class Controller_Login_Admin_Post extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// ポスト取得
			$post = Library_Security_Basis::post_security();
//			var_dump($post);
//			var_dump($_FILES);
			//----
			//投稿
			//----
			if($post == true) {
					// 投稿されたら
					if($post["submit"]) {
						// サムネイルがあったら投稿する
						if($post["random_key"]) {
//						var_dump($post);
							// 下書きをされていたら下書き削除
							if($post["draft_save"]) {
								// 下書き削除
								Model_Login_Post_Draft_Basis::draft_hide($post);
								if(!$post["thumbnail_create"]) {

								}
							}
							// 下書きがない状態で投稿
//							else {
								// 記事データ取得
								$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
								// サムネイルの名前取得
								$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
								$article_create_data_array["thumbnail_image"] = $image_path;
		//						var_dump($post);

								// 作成場所
								$create_dir = 'article/';
								// ディレクトリ作成
								Model_Dir_Basis::thumbnail_dir_create($create_dir, $article_create_data_array["article_year_time"]);
		
								// サムネイルの名前取得
								$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
								// 作成場所
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
								// rss作成
								Model_Login_Post_Basis::rss_create_2();
								// ディレクトリ配下のファイルを削除するディレクトリパス
//								$cache_db_path = INTERNAL_PATH.'fuel/app/cache/db/';
								// ディレクトリー内のファイルを全削除(cache削除)
//								Library_Dir_Basis::dir_file_all_del($cache_db_path);
								// ダッシュボードに戻る
								header('Location: '.HTTP.'login/admin/');
								exit;
//							}
						} // if($post["random_key"]) {
					} // if($post["submit"]) {

















						else if($post["preview"]) {
//							echo "aaaaaaaaaaaaaaaaaaaaaプレビュー";
						}
							//----------------------
							//下書きをクリックしたら
							//----------------------
							else if($post["draft"]) {
//								echo "aaaaaaaaaaaaaaaaaaaaa下書きとして保存";
//								var_dump($post);
								// 下書き二回目以降
								if($post["draft_save"]) {
									 // サムネイルが選択されていたら
									if($post["random_key"]) {
//										echo "aaaaaaaaaaaaaaaaaaaaa下書き random_key";
//										var_dump($post["thumbnail_create"]);
										if(!$post["thumbnail_create"]) {
											// サムネイルの名前取得
											$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
											$create_dir = PATH.'assets/img/draft/article/'.date("Y").'/';
//												var_dump($year_dir);
											// サムネイル作成
											Model_Login_Post_Basis::thumbnail_create($create_dir, $image_path);
											$post["thumbnail_create"] = true;
										} // if(!$post["thumbnail_create"]) {
										// サムネイルの名前取得
										$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
									} // if($post["random_key"]) {
									// 記事作成データ取得
									$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
									$article_create_data_array["thumbnail_image"] = $image_path;
//									var_dump('aaaaaaaaaaaaaaaaaaaaaaaa'.$image_path);
//									var_dump($article_create_data_array);
									// 下書きを上書きする
									 Model_Login_Post_Draft_Basis::article_draft_update($article_create_data_array);
								} // if($post["draft_save"]) {
									// 下書き保存（初回）
									else {
//										var_dump($post);
										if($post["random_key"]) {
											// サムネイルの名前取得
											$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
											$create_dir = PATH.'assets/img/draft/article/'.date("Y").'/';
//											var_dump($year_dir);
											// サムネイル作成
											Model_Login_Post_Basis::thumbnail_create($create_dir, $image_path);
											$post["thumbnail_create"] = true;
										}
										// 記事作成データ取得
										$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
										$article_create_data_array["thumbnail_image"] = $image_path;
//										var_dump($article_create_data_array);
										// 記事下書き保存
										$draft_primary_id = Model_Login_Post_Draft_Basis::article_draft_save($article_create_data_array);
										$post["draft_primary_id"] = $draft_primary_id;
//										var_dump($post);
									}
							}
			}
			//------------------------
			//viewテンプレート読み込み
			//------------------------
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'ポスト｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/post/post'),
			);
			//  postセット
			$this->login_admin_template->view_data["content"]->set('post_data', array(
				'post' => $post,
			),false);
			return $this->login_admin_template;
		}
			// ログインしてなかったらトップに飛ぶ
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}