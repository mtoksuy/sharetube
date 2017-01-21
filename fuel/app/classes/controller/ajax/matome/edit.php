<?php
/*
* Ajax まとめ エディットコントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Edit extends Controller {
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
			$post["draft"]            = false;
			$post["edit"]             = 'true';
			$post["matome_frg"]       = 1;
			$post["sub_text"]         = $_POST["matome_html"];
			$post["title"]            = $_POST["matome_title"];
			$post["tag"]              = $_POST["matome_tag"];
			$post["category"]         = $_POST["matome_category"];
			$post["random_key"]       = $_POST["matome_thumbnail_data"];
			$post["edit_primary_id"]  = $_POST["matome_edit_primary_id"];
			$post["sp_thumbnail"]     = 1;
		}
			//----
			//編集
			//----
			if($post == true) {
					// 編集されたら
					if($post["edit"]) {
						// サムネイルがあったら投稿する
						if($post["random_key"]) {
								// 記事データ取得
								$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
								// 既存記事データ取得
								$article_data_array = Model_Info_Basis::article_data_get($post['edit_primary_id']);

								// エディットなので数字を戻す
								$article_create_data_array["link"] = $post["edit_primary_id"];
								// サムネイルの名前取得
								$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
								// 緊急策 松岡
								$random_key_year = (int)substr($image_path, 0, 4);

								// ランダムキーサムネイルパス
								$article_create_data_array["thumbnail_image"] = $image_path;
								// 作成する年(大事)
								$article_create_data_array['article_year_time'] = (int)substr($article_data_array['create_time'], 0, 4);
								// 作成場所
								$create_dir = PATH.'assets/img/draft/article/'.$random_key_year.'/';

								// サムネイル作成
								Model_Login_Post_Basis::thumbnail_create($create_dir, $image_path);
								// サムネイルコピー
								Model_Login_Post_Basis::draft_thumbnail_copy($article_create_data_array, $random_key_year);

								// 拡張子取得
								$extends = str_replace($article_create_data_array["random_key"], "", $article_create_data_array["thumbnail_image"]);
								// 記事ナンバーを付ける
								$thumbnail_name = $article_create_data_array["link"].$extends;
								// サムネイル保管場所変更
								$article_create_data_array["thumbnail_image"] = $thumbnail_name;
								// まとめ記事編集
								Model_Login_List_Edit_Basis::matome_article_edit($article_create_data_array);
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
			'POST'                  => $post,
			'login_check'           => $login_check,
			'matome_html'           => $_POST["matome_html"],
			'matome_title'          => $_POST["matome_title"],
			'matome_tag'            => $_POST["matome_tag"],
			'matome_category'       => $_POST["matome_category"],
			'matome_thumbnail_data' => $_POST["matome_thumbnail_data"],
		);
		return json_encode($json_data);
	}
}