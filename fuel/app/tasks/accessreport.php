<?php
namespace Fuel\Tasks;

use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;

// エラー回避
error_reporting(0);
ini_set('display_errors', 1);


/*******
独自関数
*******/
/**
 * ローカルと本番環境のpathを吸収
 */
// ローカル環境
//if($_SERVER["HTTP_HOST"] == 'localhost') {


// 
// defineは使いえないらしい
//



if(preg_match('/localhost/',$_SERVER["HTTP_HOST"])) {
	// デフォルト変数生成
	define('HTTP', 'http://localhost/sharetube/');
	define('PATH', '/Volumes/2016_ssd_media'.$_SERVER["DOCUMENT_ROOT"].'/sharetube/');
	define('INTERNAL_PATH', str_replace('sharetube/', '', PATH).'fuelphp/sharetube/');
	define('TITLE', 'Sharetube - シェアしたくなるコンテンツが集まる、集まる。');
	define('META_KEYWORDS', 'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ');
	define('META_DESCRIPTION', 'Sharetubeはシェアしたくなるコンテンツが集まる場所。情報をデザインしてオリジナルのコンテンツをアップロードして身近な人やインターネットの人たちと共有しましょう。');
	define('TWITTER_ID', 'ShareTube_jp');
}
	// 本番環境
	else {
		// デフォルト変数生成
		define('HTTP', 'http://sharetube.jp/');
		define('PATH', $_SERVER["DOCUMENT_ROOT"].'/');
		define('PATH', '/var/www/vhosts/cron/public/');
		define('INTERNAL_PATH', str_replace('public/', '', PATH));
		define('TITLE', 'Sharetube - シェアしたくなるコンテンツが集まる、集まる。');
		define('META_KEYWORDS', 'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ');
		define('META_DESCRIPTION', 'Sharetubeはシェアしたくなるコンテンツが集まる場所。情報をデザインしてオリジナルのコンテンツをアップロードして身近な人やインターネットの人たちと共有しましょう。');
		define('TWITTER_ID', 'ShareTube_jp');
	}







class Accessreport {
	//
	//
	//
	public static function run($speech = null) {
//		$article_data_array = \Model_Info_Basis::article_data_get(5000);
//		var_dump($article_data_array);
		$user_count_res = DB::query("
			SELECT COUNT(primary_id)
			FROM user")->execute();
		foreach($user_count_res as $key => $value) {
			// 最新のユーザーカウント取得
			$user_count = (int)$value['COUNT(primary_id)'];
		}
/*
700
42

1020分
17時間
7時から24時
*/
// 1020
$minute_time = (17*60);
// 5分仕様
$minute_time = ((15*60)/5);
// 5分間で回す回数
$do_num = $user_count / $minute_time;
// 切り上げ
$do_num = (int)ceil($do_num);

//$do_num = 50;
//var_dump($do_num);
/*
var_dump($user_count);
var_dump($minute_time);
var_dump($do_num);
*/

		$access_report_cron_res = DB::query("
			SELECT now_count
			FROM access_report_cron
			ORDER BY primary_id DESC
			LIMIT 0, 1")->execute();
			$now_count = 0;
		foreach($access_report_cron_res as $key => $value) {
			// 現在のカウント取得
			$now_count = (int)$value['now_count'];
		}
		// 超えている場合
		if($user_count < ($now_count+$do_num)) {
			$next_count = $user_count;
			$do_num     = ($user_count-$now_count);
		}
			// 超えていない場合
			else {
				$next_count = (int)$now_count+$do_num;
			} // else
/*
var_dump($do_num);     // 
var_dump($next_count); // 
var_dump($user_count); // 
echo '------------------------------';
var_dump($now_count);  // 
var_dump($do_num);     //
*/

$week_1_time = 604800;
//$week_1_time = 10;
			// 下に行く前に$user_countで走らせている日でのレコードがあるかないかを調べる なかったら走らせる
			$access_report_cron_check_res = DB::query("
				SELECT *
					FROM access_report_cron
					WHERE now_count = ".$user_count."
					AND create_time > '".date('Y-m-d')." 00:00:00'
					AND create_time < '".date('Y-m-d')." 23:59:59'")->execute();
//var_dump($access_report_cron_check_res);

			$access_report_cron_check = false;
			foreach($access_report_cron_check_res as $access_report_cron_check_key => $access_report_cron_check_value) {
				$access_report_cron_check = true;
			}
			if(!$access_report_cron_check) {
				$user_res = DB::query("
					SELECT * 
					FROM user
					LIMIT ".$now_count.", ".$do_num."")->execute();
				foreach($user_res as $user_key => $user_value) {
//					var_dump($user_value['sharetube_id']);
					$access_summary_res = DB::query("
						SELECT SUM(count)
						FROM access_summary
						WHERE sharetube_id = '".$user_value['sharetube_id']."'
						AND create_time > '".date('Y-m-d', (time() - $week_1_time))." 00:00:00'
						AND create_time < '2017-10-26 23:59:59'")->execute();
					foreach($access_summary_res as $access_summary_key => $access_summary_value) {
						// 削除されていないユーザーにメールを送る && メールを許可しているユーザー
						if($user_value['del'] == 0 && $user_value['mail_delivery_ok'] == 1) {
//							var_dump($access_summary_value['SUM(count)']);
							// NULLの場合
							if($access_summary_value['SUM(count)'] == NULL) {
								// アクセス1週間のレポート NULLの場合
								\Model_Mail_Basis::access_1week_null_report($user_value);
							}
								// アクセスがある場合
								else {
									// アクセス1週間のレポート NULLの場合
									\Model_Mail_Basis::access_1week_report($user_value, $access_summary_value['SUM(count)']);
								}
						}
						// access_report_cron書き込み
						$access_report_cronres = DB::query("
							INSERT INTO access_report_cron (
								now_count
							)
							VALUES (
								".$user_value['primary_id']."
							)")->execute();
					}
				} // foreach($user_res as $user_key => $user_value) {
			} // if(!$access_report_cron_check) {
		//////////////////////////
		// 同じになった場合 初期化
		//////////////////////////
		if($user_count == $next_count) {
			$access_report_cronres = DB::query("
				INSERT INTO access_report_cron (
					now_count
				)
				VALUES (
					0
				)")->execute();			
		}
	} // run

























}
