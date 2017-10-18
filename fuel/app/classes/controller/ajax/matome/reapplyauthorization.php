<?php
/*
* Ajax まとめ 許可コントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Reapplyauthorization extends Controller {
	// アクション
	public function action_index() {
		// セッションスタート
		session_start();
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// ポスト取得
			$post = Library_Security_Basis::post_security();

			$post["article_type"]     = 'article';
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
			//--------
			//許可する
			//--------
			if($post == true) {
				// 削除済み記事データ取得
				$delete_article_data_array = Model_Login_Matome_Delete_Basis::delete_article_data_array_get($post['edit_primary_id']);
				// Sharetubeのユーザーデータ取得
				$sharetube_user_data_array = Model_Info_Basis::sharetube_user_data_get($delete_article_data_array['sharetube_id']);
				// 申請されたまとめを公開する
				Model_Login_Matome_Delete_Reapply_Basis::delete_article_reapply_authorization($delete_article_data_array);
				// 削除済み記事を許可した時に送るメール
				Model_Mail_Basis::delete_article_reapply_authorization_report($sharetube_user_data_array, $delete_article_data_array);




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