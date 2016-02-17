<?php 

/**
 * ログイン関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Basis extends Model {
	//--------
	//ログイン
	//--------
	public static function login($post) {
		$query = DB::query("
			SELECT *
			FROM user
			WHERE	sharetube_id     = '".$post["login_user"]."'
			AND   password         = '".md5($post["login_pass"])."'

			OR    email            = '".$post["login_user"]."'
			AND   password         = '".md5($post["login_pass"])."'")->execute();

		foreach($query as $key => $value) {
			$_SESSION["primary_id"]          = $value["primary_id"];
			$_SESSION["sharetube_id"]        = $value["sharetube_id"];
			$_SESSION["email"]               = $value["email"];
			$_SESSION["name"]                = $value["name"];
			$_SESSION["management_site_url"] = $value["management_site_url"];
			$_SESSION["profile_contents"]    = $value["profile_contents"];
			$_SESSION["profile_icon"]        = $value["profile_icon"];
			$_SESSION["twitter_id"]          = $value["twitter_id"];
			$_SESSION["facebook_id"]         = $value["facebook_id"];
			$_SESSION["all_page_view"]       = $value["all_page_view"];
			$_SESSION["creation_time"]       = $value["creation_time"];
			$_SESSION["update_time"]         = $value["update_time"];
			// ユーザーがログインしたらお知らせのメールを送信する
			Model_Mail_Basis::login_account_report_mail($_SESSION);
			header('Location: '.HTTP.'login/admin/');
			exit;
		}
		// ログイン出来ない場合
		$lohin_message = 'ユーザー名かパスワードが間違っています。';
		return $lohin_message;
	}
	//----------------
	//ログインチェック
	//----------------
	public static function login_check() {
		// エラー表示設定()
		error_reporting(0);
		ini_set('display_errors', 1);

		$login_check = '';
		if($_SESSION["sharetube_id"]) {
			$login_check = true;
		}
			else {
				$login_check = false;
			}
		return $login_check;
	}
	//----------
	//ログアウト
	//----------
	public static function logout() {
		$_SESSION = array();
		session_destroy();
		header('location: '.HTTP.'');
		exit;
	}
}