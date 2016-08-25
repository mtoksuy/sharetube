<?php 

/**
 * インセンティブ関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Incentive_Basis extends Model {
	//--------------------------
	//インセンティブのデータ取得
	//--------------------------
	public static function incentive_data_get() {
		$incentive_data_array = array();
		$incentive_res = DB::query("
			SELECT *
			FROM incentive")->execute();
		foreach($incentive_res as $key => $value) {
			$incentive_data_array["rate"] = (float)$value["rate"];
		}
		// 個別指定 photo2016essayさん
		/*
		Sharetubeアナリティクス：1026pv
		アナリティクス；637pv
		変動率：0.6208577
		
		稼ぎ：0.13円
		通常レート：0.091円
		変動率レート：0.05649805円

		1036
		606
		0.58494208
		変動率レート：0.053144円
--------------------------

		Sharetubeアナリティクス：669pv
		アナリティクス；342pv
		変動率：0.51121076
		稼ぎ：0.13円
		通常レート：0.091円
		変動率レート：0.04652011円
		*/

/*

新基準
		Sharetubeアナリティクス：669pv
		アナリティクス；342pv
		変動率：0.51121076
		稼ぎ：0.11円
		通常レート：0.071円
		変動率レート：0.02652011円
		*/

		if($_SESSION["sharetube_id"] == 'photo2016essay') {
			$incentive_data_array["rate"] = (float)'0.04652011';
		}
		return $incentive_data_array;
	}
	//----------------------------------
	//支払済みインセンティブレポート取得
	//----------------------------------
	public static function incentive_paid_report_get($sharetube_id) {
		$incentive_paid_report_res = DB::query("
			SELECT * 
			FROM incentive_paid_report 
			WHERE sharetube_id = '".$sharetube_id."'")->execute();
		return $incentive_paid_report_res;
	}
	//--------------------------------
	//インセンティブ支払いチケット取得
	//--------------------------------
	public static function incentive_paid_ticket_get($sharetube_id) {
		$incentive_paid_ticket_res = DB::query("
			SELECT * 
			FROM incentive_paid_ticket 
			WHERE sharetube_id = '".$sharetube_id."'
			AND complete = 0")->execute();
		return $incentive_paid_ticket_res;
	}	
	//--------------------------------
	//インセンティブ支払いチケット発行
	//--------------------------------
	public static function incentive_paid_ticket_issue($sharetube_user_data_array, $incentive_data_array) {	
		$pay_money_int  = (int)($incentive_data_array["rate"]*$sharetube_user_data_array["pay_pv"]);
		$incentive_ticket_query = DB::query("
			INSERT INTO 
				incentive_paid_ticket (
					sharetube_id, 
					pay_money,
					pay_pv, 
					rate
				)
				VALUES (
				'".$sharetube_user_data_array["sharetube_id"]."',
				".$pay_money_int.",
				".$sharetube_user_data_array["pay_pv"].",
				'".$incentive_data_array["rate"]."'
				)
		")->execute();
		$incentive_ticket_number = $incentive_ticket_query[0];
		// pay_pvを0にする
		DB::query("
			UPDATE user
				SET
					pay_pv = 0
				WHERE primary_id = ".$sharetube_user_data_array["primary_id"]."")->execute();
		return $incentive_ticket_number;
	}
	//----------------------------
	//インセンティブチケット全取得
	//----------------------------
	public static function incentive_paid_ticket_all_get() {
		$incentive_paid_ticket_all_res = DB::query("
			SELECT * 
			FROM incentive_paid_ticket 
			WHERE complete = 0")->execute();
		return $incentive_paid_ticket_all_res;
	}
	//--------------------------
	//支払いチケットコンプリート
	//--------------------------
	public static function incentive_ticket_complete($ticket_primary_id) {
		$$incentive_paid_ticket_check = false;
		$incentive_paid_ticket_array = array();
		// completeが0なのか調べる
		$incentive_paid_ticket_res = DB::query("
			SELECT *
			FROM incentive_paid_ticket
			WHERE primary_id = ".$ticket_primary_id."
			AND complete = 0")->execute();
		foreach($incentive_paid_ticket_res as $key => $value) {
			$incentive_paid_ticket_check = true;
			$incentive_paid_ticket_array["primary_id"]   = (int)$value["primary_id"];
			$incentive_paid_ticket_array["sharetube_id"] = $value["sharetube_id"];
			$incentive_paid_ticket_array["pay_money"]    = (int)$value["pay_money"];
			$incentive_paid_ticket_array["pay_pv"]       = (int)$value["pay_pv"];
			$incentive_paid_ticket_array["rate"]         = $value["rate"];
		}
//		var_dump($incentive_paid_ticket_array);
		// チケットが存在(complete:0)していた場合
		if($incentive_paid_ticket_check) {
			// completeを1にする
			DB::query("
				UPDATE incentive_paid_ticket 
					SET complete = 1
					WHERE primary_id = ".$ticket_primary_id."")->execute();
			// コンプリートしたチケットをレポートに追加する
			DB::query("
				INSERT INTO
					incentive_paid_report (
						ticket_id,
						sharetube_id,
						paid_money, 
						pay_pv, 
						rate
					)
					VALUES (
						".$incentive_paid_ticket_array["primary_id"].",	
						'".$incentive_paid_ticket_array["sharetube_id"]."',	
						".$incentive_paid_ticket_array["pay_money"].",	
						".$incentive_paid_ticket_array["pay_pv"].",	
						'".$incentive_paid_ticket_array["rate"]."'	
					)")->execute();

			header('Location: '.HTTP.'login/admin/incentiveticket/');
			exit;
		} // if($incentive_paid_ticket_check) {
	}











}
