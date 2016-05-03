<?php 

/**
 * User関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_User_Basis extends Model {
	//----------------
	//ユーザー情報編集
	//----------------
	public static function user_data_edit($post) {
		// time関連取得
		$now_time           = time();
		$now_date           = date('Y-m-d h:i:s', $now_time);
		$res = DB::query("
			UPDATE user
				SET
					name                = '".$post["name"]."',
					management_site_url = '".$post["management_site_url"]."',
					profile_contents    = '".$post["profile_contents"]."',
					twitter_id          = '".$post["twitter_id"]."',
					facebook_id         = '".$post["facebook_id"]."',
					update_time         = '".$now_date."'
				WHERE
					 primary_id = ".(int)$_SESSION["primary_id"]."")->execute();
//					var_dump($res);
	}
	//--------------------
	//ユーザー銀行口座編集
	//--------------------
	public static function user_bank_edit($post) {
		// time関連取得
		$now_time           = time();
		$now_date           = date('Y-m-d h:i:s', $now_time);
		$res = DB::query("
			UPDATE user
				SET
					bank_name      = '".$post["bank_name"]."',
					account_holder = '".$post["account_holder"]."',
					account_type   = '".$post["account_type"]."',
					branch_code    = '".$post["branch_code"]."',
					account_number = '".$post["account_number"]."',
					update_time    = '".$now_date."'
				WHERE
					 primary_id = ".(int)$_SESSION["primary_id"]."")->execute();
//					var_dump($res);
	}
	//--------------------------
	//ユーザーアカウント設定編集
	//--------------------------
	public static function user_account_setup_edit($post) {
		$user_mail_delivery_ok = 0;
		if($post['user_mail_delivery_ok']) {
			$user_mail_delivery_ok = 1;
		}
			else {
				$user_mail_delivery_ok = 0;
			}
		DB::query("
			UPDATE user
				SET
					mail_delivery_ok = ".$user_mail_delivery_ok."
				WHERE 
					primary_id  = ".(int)$_SESSION["primary_id"]."")->execute();
	}
}