<?php 
// エラー回避
error_reporting('E_ALL');
ini_set('display_errors', 1);

// 時間設定
date_default_timezone_set('Asia/Tokyo');

/**
 * ローカルと本番環境のpathを吸収
 */
// ローカル環境
//if($_SERVER["HTTP_HOST"] == 'localhost') {
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
		define('HTTP', 'http://'.$_SERVER["HTTP_HOST"].'/');
		define('PATH', $_SERVER["DOCUMENT_ROOT"].'/');
		define('INTERNAL_PATH', str_replace('public/', '', PATH));
		define('TITLE', 'Sharetube - シェアしたくなるコンテンツが集まる、集まる。');
		define('META_KEYWORDS', 'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ');
		define('META_DESCRIPTION', 'Sharetubeはシェアしたくなるコンテンツが集まる場所。情報をデザインしてオリジナルのコンテンツをアップロードして身近な人やインターネットの人たちと共有しましょう。');
		define('TWITTER_ID', 'ShareTube_jp');
	}

class Model {

}
/*
use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;
*/

// 必要なクラス群を読み込み
/*
require INTERNAL_PATH.'fuel/core/classes/db.php';
require INTERNAL_PATH.'fuel/core/classes/dbutil.php';
require INTERNAL_PATH.'fuel/core/classes/database/connection.php';
require INTERNAL_PATH.'fuel/core/classes/database/mysql/connection.php';
*/

require INTERNAL_PATH.'fuel/app/classes/library/security/basis.php';
require INTERNAL_PATH.'fuel/app/classes/model/info/basis.php';
require INTERNAL_PATH.'fuel/app/classes/model/ad/html.php';
require INTERNAL_PATH.'fuel/app/classes/model/ad/basis.php';
require INTERNAL_PATH.'fuel/app/classes/model/article/basis.php';


/*******
独自関数
*******/
// プレヴァーダンプ
function pre_var_dump($data = '') {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

if($_SERVER["HTTP_HOST"] == "localhost") {
	$host_name = 'localhost';
	$user_name = 'root';
	$password  = 'root';
}
	else {
		$host_name = '157.7.134.214';
		$user_name = 'sharetube';
		$password  = 'Sm10120616';
	} 

	// データベース接続
	$link = mysql_connect($host_name, $user_name, $password);
	// 接続したら
	if($link) {
		$db_selected = mysql_select_db('fuel_sharetube', $link);
		mysql_query('SET NAMES utf8', $link);
	}


preg_match('/article\/([0-9]+)\//', $_SERVER['REQUEST_URI'], $artucle_array);
$article_id = (int)$artucle_array[1];
$method = $article_id;

// ユーザー情報取得
$user_data_array = Model_Info_Basis::user_data_get();
// 変数をエンティティ化する
$user_data_array = Library_Security_Basis::variable_security_entity($user_data_array);

			$method = 5000;
			$article_res = mysql_query("
				SELECT sharetube_id 
				FROM article 
				WHERE del = 0
				AND link = '".$method."'
				LIMIT 0, 1");
			while($row = mysql_fetch_assoc($article_res)) {
				 $sharetube_id = $row['sharetube_id'];
			}
// 一番ややこしい場所なのでまたトラブルがあるかもしれないので監視をする 2015.08.25 松岡
// アクセスDB追加 & all_page_view & pay_pv をプラス & アクセスサマリー書き込み
Model_article_basis::cron_article_access_writing_and_all_page_view_plus($method, $user_data_array, $sharetube_id);



















?>