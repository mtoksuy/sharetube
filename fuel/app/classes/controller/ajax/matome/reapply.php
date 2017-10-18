<?php
/*
* Ajax まとめ 申請コントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Reapply extends Controller {
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
			$post["reapply"]          = 'true';
			$post["matome_frg"]       = 1;

			$post["edit_primary_id"]  = $_POST["matome_edit_primary_id"];
			$post["sub_text"]         = $_POST["matome_html"];
			$post["title"]            = $_POST["matome_title"];
			$post["tag"]              = $_POST["matome_tag"];
			$post["category"]         = $_POST["matome_category"];
			$post["random_key"]       = $_POST["matome_thumbnail_data"];
			$post["draft_save"]       = $_POST["matome_draft_save"];
			$post["draft_primary_id"] = $_POST["matome_draft_primary_id"];
			$post["sp_thumbnail"]     = 1;
			$post["thumbnail_quote_url"]   = $_POST["matome_thumbnail_quote_url"];
			$post["thumbnail_quote_title"] = $_POST["matome_thumbnail_quote_title"];
		}
			//----
			//申請
			//----
			if($post == true) {
					// 申請されたら
					if($post["reapply"]) {
						// サムネイルがあったら投稿する
						if($post["random_key"]) {
								// 記事データ取得
								$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
								// 削除済み記事データ取得
								$delete_article_data_array = Model_Info_Basis::delete_article_data_get($post['edit_primary_id']);

								// エディットなので数字を戻す
								$article_create_data_array["link"] = (int)$post["edit_primary_id"];
								// サムネイルの名前取得
								$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
								// 緊急策 松岡
								$random_key_year = (int)substr($image_path, 0, 4);
								// ランダムキーサムネイルパス
								$article_create_data_array["thumbnail_image"] = $image_path;

								// 作成する年(大事)
								$article_create_data_array['article_year_time'] = (int)substr($delete_article_data_array['create_time'], 0, 4);
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
								// Sharetubeのユーザーデータ取得
								$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($_SESSION['sharetube_id']);
								// 削除済み記事を申請した時に送られてくるメール
								Model_Mail_Basis::delete_article_reapply_report($sharetube_user_data_array, $article_create_data_array);
						} // if($post["random_key"]) {
					} // if($post["submit"]) {
				} // if($post == true) {

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