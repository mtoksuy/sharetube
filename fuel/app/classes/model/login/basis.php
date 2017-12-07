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
			// セッション生成
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

			// クッキー生成(一ヶ月有効)
			setcookie('sharetube_id', $value["sharetube_id"], time() + 2592000, '/');
			setcookie('sharetube_login_key', md5($post["login_pass"]), time() + 2592000, '/');
			// ユーザーがログインしたらお知らせのメールを送信する
			Model_Mail_Basis::login_account_report_mail($_SESSION);
			// ログイン履歴登録
			Model_Login_Basis::login_history_record($_SESSION["sharetube_id"]);
			header('Location: '.HTTP.'login/admin/');
			exit;
		}
		// ログイン出来ない場合
		$lohin_message = 'ユーザー名かパスワードが間違っています。';
		return $lohin_message;
	}
	//----------------
	//クッキーログイン
	//----------------
	public static function cookie_login() {
		$login_check = false;
		$query = DB::query("
			SELECT *
			FROM user
			WHERE	sharetube_id     = '".$_COOKIE['sharetube_id']."'
			AND   password         = '".$_COOKIE['sharetube_login_key']."'

			OR    email            = '".$_COOKIE['sharetube_id']."'
			AND   password         = '".$_COOKIE['sharetube_login_key']."'")->execute();

		foreach($query as $key => $value) {
			// セッション生成
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
			// クッキー生成(一ヶ月有効)
			setcookie('sharetube_id', $value["sharetube_id"], time() + 2592000, '/');
			setcookie('sharetube_login_key', $_COOKIE['sharetube_login_key'], time() + 2592000, '/');
			// ユーザーがログインしたらお知らせのメールを送信する
			Model_Mail_Basis::login_account_report_mail($_SESSION);
			$login_check = true;
		}
			return $login_check;
	}
	//----------------
	//ログインチェック
	//----------------
	public static function login_check() {
		// エラー表示設定()
		error_reporting(0);
		ini_set('display_errors', 1);

		$login_check = '';
		// セッションがある場合
		if($_SESSION["sharetube_id"]) {
			$login_check = true;
		}
			// セッションがない場合
			else {
				$login_check = false;
				// クッキーがある場合
				if($_COOKIE['sharetube_id']) {
					// クッキーでログイン
					$login_check  = Model_Login_Basis::cookie_login();
				}
			}
		return $login_check;
	}
	//----------
	//ログアウト
	//----------
	public static function logout() {
		// セッション削除
		$_SESSION = array();
		session_destroy();
		// クッキー削除
		setcookie('sharetube_id', '', time()-10000, '/');
		setcookie('sharetube_login_key', '',time()-10000, '/');
		header('location: '.HTTP.'');
		exit;
	}
	//----------------------
	//ログイン履歴を記録する
	//----------------------
	public static function login_history_record($sharetube_id) {
		DB::query("
			INSERT INTO login_history (
				sharetube_id
			)
			VALUES (
				'".$sharetube_id."'
			)
		")->execute();
	}
}