<?php
/*
* Ajax まとめ サブミットコントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Submit extends Controller {
	// アクション
	public function action_index() {
		// セッションスタート
		session_start();
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// ポスト取得
			$post = Library_Security_Basis::post_security();
			// articleとmatomeの違いを吸収
			$post["article_type"]     = 'article';
			$post["draft"]            = 'true';
			$post["submit"]           = 'true';
			$post["matome_frg"]       = 1;
			$post["sub_text"]         = $_POST["matome_html"];
			$post["title"]            = $_POST["matome_title"];
			$post["tag"]              = $_POST["matome_tag"];
			$post["category"]         = $_POST["matome_category"];
			$post["random_key"]       = $_POST["matome_thumbnail_data"];
			$post["draft_save"]       = $_POST["matome_draft_save"];
			$post["draft_primary_id"] = $_POST["matome_draft_primary_id"];
			$post["sp_thumbnail"]     = 1;
		}
			//----
			//投稿
			//----
			if($post == true) {
					// 投稿されたら
					if($post["submit"]) {
						// サムネイルがあったら投稿する
						if($post["random_key"]) {
							// 下書きをされていたら下書き削除
							if($post["draft_save"]) {
								// 下書き削除
								Model_Login_Post_Draft_Basis::draft_hide($post);
							}
							// 記事データ取得
							$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
							// サムネイルの名前取得
							$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
							$article_create_data_array["thumbnail_image"] = $image_path;
							// 作成場所
							$create_dir = 'article/';
							// サムネイルディレクトリ自動生成
							Model_Dir_Basis::thumbnail_dir_create($create_dir, $article_create_data_array["article_year_time"]);
							// サムネイル作成場所
							$create_dir = PATH.'assets/img/draft/article/'.date("Y").'/';
							// サムネイル作成
							Model_Login_Post_Basis::thumbnail_create($create_dir, $image_path);
							// サムネイルコピー
							Model_Login_Post_Basis::draft_thumbnail_copy($article_create_data_array);
							// 拡張子取得
							$extends = str_replace($article_create_data_array["random_key"], "", $article_create_data_array["thumbnail_image"]);
							// 記事ナンバーを付ける
							$thumbnail_name = $article_create_data_array["link"].$extends;
							// サムネイル保管場所変更
							$article_create_data_array["thumbnail_image"] = $thumbnail_name;
							// 記事作成
							Model_Login_Post_Basis::article_create($article_create_data_array, true);
							// rss作成
							Model_Login_Post_Basis::rss_create_2();
							// テーマエントリー
							Model_Login_Matome_Theme_Basis::theme_entry($article_create_data_array);

							// ディレクトリ配下のファイルを削除するディレクトリパス
//								$cache_db_path = INTERNAL_PATH.'fuel/app/cache/db/';
							// ディレクトリー内のファイルを全削除(cache削除)
//								Library_Dir_Basis::dir_file_all_del($cache_db_path);
							// ダッシュボードに戻る
//								header('Location: '.HTTP.'login/admin/');
//								exit;
//							}
						} // if($post["random_key"]) {
					} // if($post["submit"]) {
				} // if($post[""]) {
		header ("Content-Type: text/javascript; charset=utf-8");
		$json_data = array(
			'article_create_data_array' => $article_create_data_array,
			'POST'                      => $post,
			'login_check'               => $login_check,
			'matome_html'               => $_POST["matome_html"],
			'matome_title'              => $_POST["matome_title"],
			'matome_tag'                => $_POST["matome_tag"],
			'matome_category'           => $_POST["matome_category"],
			'matome_thumbnail_data'     => $_POST["matome_thumbnail_data"],
		);
		return json_encode($json_data);
	}
}