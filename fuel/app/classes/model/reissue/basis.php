<?php 
/*
* 
* パスワード再設定 Basis関連クラス
* 
* 
* 
*/

class Model_Reissue_Basis extends Model {
	//------------
	//ハッシュ発行
	//------------
	public static function reissue_hash_issue($post) {
		$mail_address = $post['mail_address'];
		// 正しいメールアドレスかどうか調べる関数
		$user_email_check = Library_Validateemail_Basis::validate_email($mail_address);
		// メールアドレスが正しかったら
		if($user_email_check) {
			$user_check = false;
			// ユーザーチェック
			$user_res = DB::query("
				SELECT *
				FROM user
				WHERE email = '".$mail_address."'")->execute();
			foreach($user_res as $key => $value) {
				$sharetube_id = $value['sharetube_id'];
				$user_check   = true;
			}
			// ユーザーが存在していたら
			if($user_check) {
				// ハッシュ生成
				$hash = password_hash($mail_address, PASSWORD_DEFAULT);
				// reissue登録
				DB::query("
					INSERT INTO
					reissue (
					sharetube_id,
					email,
					hash
					)
					VALUES (
					'".$sharetube_id."',
					'".$mail_address."',
					'".$hash."')")->execute();
				// 再パスワード発行の手順と本人確認のためにメール送信
				Model_Mail_Basis::reissue_authentic_check_mail($mail_address, $hash);
			}
		} // if($user_email_check) {
		return array($mail_address, $user_email_check, $user_check);
	}
	//-------------------------
	//ハッシュでreissue_res取得
	//-------------------------
	public static function hash_is_reissue_res_get($get) {
		$reissue_res = DB::query("
			SELECT *
			FROM reissue 
			WHERE hash = '".$get['hash']."'")->execute();
		return $reissue_res;
	}
	//-----------------------------
	//ハッシュでreissueアップデート
	//-----------------------------
	public static function hash_is_reissue_update($reissue_res) {
		$reissue_check = false;
		$reissue_array = array();
		foreach($reissue_res as $key => $value) {
			$reissue_check = true;
			$reissue_array['primary_id']      = $value['primary_id'];
			$reissue_array['sharetube_id']    = $value['sharetube_id'];
			$reissue_array['email']           = $value['email'];
			$reissue_array['hash']            = $value['hash'];
			$reissue_array['authentic_check'] = $value['authentic_check'];
			$reissue_array['change_check']    = $value['change_check'];
			$reissue_array['authentic_time']  = $value['authentic_time'];
			$reissue_array['create_time']     = $value['create_time'];
			// 現在の時間表記を取得
			$now_date = Model_Info_Basis::now_date_get();
			// 更新
			DB::query("
				UPDATE reissue
				SET authentic_check = 1,
				authentic_time = '".$now_date."'
				WHERE primary_id = ".$reissue_array['primary_id']."")->execute();
			}
		return array($reissue_check, $reissue_array);
	}
	//-------------------------
	//ユーザーのパスワードを変更
	//-------------------------
	public static function user_password_change($post) {
		// 更新
		DB::query("
			UPDATE user
			SET password = '".md5($post['new_password'])."'
			WHERE sharetube_id = '".$reissue_array['sharetube_id']."'
		")->execute();
		// 更新
		DB::query("
			UPDATE reissue
			SET change_check = 1
			WHERE primary_id = ".$reissue_array['primary_id']."")->execute();
	}












}