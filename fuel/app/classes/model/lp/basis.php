<?php 
/*
* 
* lp基本クラス
* 
* 
* 
*/
class Model_Lp_Basis {
	//------------------------------------------------
	//lpからの登録されたことをわかるためにDBに登録する
	//------------------------------------------------
	public static function user_lp_signup_db_insert($post, $chkeck = 'top') {
		$now_time          = time();
		$now_date          = date('Y-m-d', $now_time);
		$create_date       = date('Y-m-d H:i:s', $now_time);
		$article_year_time = date('Y', $now_time);
		switch($chkeck) {
			case 'top':
				$lp_top_check_number    = 1;
				$lp_signup_check_number = 0;
				break;
			case 'signup':
				$lp_top_check_number    = 0;
				$lp_signup_check_number = 1;
				break;
			default:
		}
		// ユーザー登録
		DB::query("
			INSERT INTO lp (
			lp_top_check,
			lp_sign_up_check,
			sharetube_id)
			VALUES (
			".$lp_top_check_number.", 
			".$lp_signup_check_number.", 
			'".$post["sharetube_id"]."')")->execute();
	}
}