<?php 

/**
 * Sharetube全ユーザーにメールを送る関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Mail_Basis extends Model {
	//------------------------------------------------
	//メール配信許可があるsharetubeユーザーのresを取得
	//------------------------------------------------
	public static function mail_delivery_ok_sharetube_id_uses_data_res_get() {
		$mail_delivery_ok_sharetube_id_uses_data_res = DB::query("
			SELECT *
			FROM user
			WHERE mail_delivery_ok = 1")->execute();
		return $mail_delivery_ok_sharetube_id_uses_data_res;
	}
}
