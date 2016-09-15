<?php
/*
* Ajax まとめ 下書きコントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Draft extends Controller {
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
			$post["sub_text"]         = $_POST["matome_html"];
			$post["title"]            = $_POST["matome_title"];
			$post["tag"]              = $_POST["matome_tag"];
			$post["category"]         = $_POST["matome_category"];
			$post["random_key"]       = $_POST["matome_thumbnail_data"];
			$post["draft_save"]       = $_POST["matome_draft_save"];
			$post["draft_primary_id"] = $_POST["matome_draft_primary_id"];
			$post["sp_thumbnail"]     = 1;

		}
//----------------------
//下書きをクリックしたら
//----------------------
if($post["draft"]) {
	// 下書き二回目以降
	if($post["draft_save"]) {
		 // サムネイルが選択されていたら
		if($post["random_key"]) {
			// サムネイルの名前取得
			$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
			$create_dir = PATH.'assets/img/draft/article/'.date("Y").'/';
			// サムネイル作成
			Model_Login_Post_Basis::thumbnail_create($create_dir, $image_path);
			// サムネイルの名前取得
			$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
		} // if($post["random_key"]) {
		// 記事作成データ取得
		$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
//var_dump($post);
//var_dump($article_create_data_array);
		$article_create_data_array["thumbnail_image"] = $image_path;
		// 下書きを上書きする
		 Model_Login_Post_Draft_Basis::article_draft_update($article_create_data_array);
		// テーマエントリー
		Model_Login_Matome_Theme_Basis::theme_entry($article_create_data_array);
	} // if($post["draft_save"]) {
	////////////////////
	// 下書き保存（初回）
	////////////////////
	else {
		// サムネイルがある場合
		if($post["random_key"]) {
			// サムネイルの名前取得
			$image_path = Model_Login_Post_Draft_Basis::thumbnail_name_get($post["random_key"]);
			$create_dir = PATH.'assets/img/draft/article/'.date("Y").'/';

			// サムネイル作成
			Model_Login_Post_Basis::thumbnail_create($create_dir, $image_path);
		} // if($post["random_key"]) {
		// 記事作成データ取得
		$article_create_data_array = Model_Login_Post_Basis::article_create_data_get($post);
		$article_create_data_array["thumbnail_image"] = $image_path;

		// 記事下書き保存
		$draft_primary_id = Model_Login_Post_Draft_Basis::article_draft_save($article_create_data_array, true);
		// テーマエントリー
		Model_Login_Matome_Theme_Basis::theme_entry($article_create_data_array);

		$post["draft_primary_id"] = $draft_primary_id;
		// 初回足跡つけ
		$post["draft_save"] = true;
	} // else {
} // if($post["draft"]) {
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