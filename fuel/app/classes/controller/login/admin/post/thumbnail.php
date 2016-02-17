<?php 
/**
 * サムネイルコントローラー
 * 
 * サムネイルをアップロードする機能
 * 
 * 
 */

class Controller_Login_Admin_Post_Thumbnail extends Controller_Login_Template {
	public function action_index() {
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// ポスト取得
			$post = Library_Security_Basis::post_security();
			var_dump($post);
			var_dump($_FILES);
			// ランダムキー取得
			$random_key = $post["random_key"];
			// サムネイル原本を一時的に保存
			$image_path = Model_Login_Post_Draft_Basis::thumbnail_original_create($random_key);
			// サムネイル原本db書き込み
			Model_Login_Post_Draft_Basis::thumbnail_data_save($random_key, $image_path);
			var_dump($image_path);
			?>
		<!-- jQueryプラグイン -->
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/jquery-1.9.1-min.js"></script>
		<script type="text/javascript" src="<?php echo HTTP; ?>assets/js/common/common.js"></script>
<script>
/*

*/
</script>
<?php
		}
		// ログインしてなかったらトップに飛ぶ
		else {
			header('Location: '.HTTP.'');
			exit;
		}
	}
}