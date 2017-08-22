<?php 
	echo '<?php 
// エラー回避
error_reporting(0);
ini_set(\'display_errors\', 1);

// 時間設定
date_default_timezone_set(\'Asia/Tokyo\');


/**
 * ローカルと本番環境のpathを吸収
 */
// ローカル環境
//if($_SERVER["HTTP_HOST"] == \'localhost\') {
if(preg_match(\'/localhost/\',$_SERVER["HTTP_HOST"])) {
	// デフォルト変数生成
	define(\'HTTP\', \'http://localhost/sharetube/\');
	define(\'PATH\', \'/Volumes/2016_ssd_media\'.$_SERVER["DOCUMENT_ROOT"].\'/sharetube/\');
	define(\'INTERNAL_PATH\', str_replace(\'sharetube/\', \'\', PATH).\'fuelphp/sharetube/\');
	define(\'TITLE\', \'Sharetube - シェアしたくなるコンテンツが集まる、集まる。\');
	define(\'META_KEYWORDS\', \'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ\');
	define(\'META_DESCRIPTION\', \'Sharetubeはシェアしたくなるコンテンツが集まる場所。情報をデザインしてオリジナルのコンテンツをアップロードして身近な人やインターネットの人たちと共有しましょう。\');
	define(\'TWITTER_ID\', \'ShareTube_jp\');
}
	// 本番環境
	else {
		// デフォルト変数生成
		define(\'HTTP\', \'http://\'.$_SERVER["HTTP_HOST"].\'/\');
		define(\'PATH\', $_SERVER["DOCUMENT_ROOT"].\'/\');
		define(\'INTERNAL_PATH\', str_replace(\'public/\', \'\', PATH));
		define(\'TITLE\', \'Sharetube - シェアしたくなるコンテンツが集まる、集まる。\');
		define(\'META_KEYWORDS\', \'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ\');
		define(\'META_DESCRIPTION\', \'Sharetubeはシェアしたくなるコンテンツが集まる場所。情報をデザインしてオリジナルのコンテンツをアップロードして身近な人やインターネットの人たちと共有しましょう。\');
		define(\'TWITTER_ID\', \'ShareTube_jp\');
	}

class Model
{

}
/*
use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;
*/

// 必要なクラス群を読み込み
/*
require INTERNAL_PATH.\'fuel/core/classes/db.php\';
require INTERNAL_PATH.\'fuel/core/classes/dbutil.php\';
require INTERNAL_PATH.\'fuel/core/classes/database/connection.php\';
require INTERNAL_PATH.\'fuel/core/classes/database/mysql/connection.php\';
*/

require INTERNAL_PATH.\'fuel/app/classes/library/security/basis.php\';
require INTERNAL_PATH.\'fuel/app/classes/model/info/basis.php\';
require INTERNAL_PATH.\'fuel/app/classes/model/ad/html.php\';
require INTERNAL_PATH.\'fuel/app/classes/model/ad/basis.php\';
require INTERNAL_PATH.\'fuel/app/classes/model/article/basis.php\';




/*******
独自関数
*******/
// プレヴァーダンプ
function pre_var_dump($data = \'\') {
	echo \'<pre>\';
	var_dump($data);
	echo \'</pre>\';
}
if($_SERVER["HTTP_HOST"] == "localhost") {
	$host_name = \'localhost\';
	$user_name = \'root\';
	$password  = \'root\';
}
	else {
		$host_name = \'157.7.134.214\';
		$user_name = \'sharetube\';
		$password  = \'Sm10120616\';
	} 

	// データベース接続
	$link = mysql_connect($host_name, $user_name, $password);
	// 接続したら
	if($link) {
		$db_selected = mysql_select_db(\'fuel_sharetube\', $link);
		mysql_query(\'SET NAMES utf8\', $link);
	}


////////////////
//access周り記述
////////////////
preg_match(\'/article\/([0-9]+)\//\', $_SERVER[\'REQUEST_URI\'], $artucle_array);
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
				AND link = \'".$method."\'
				LIMIT 0, 1");
			while($row = mysql_fetch_assoc($article_res)) {
				 $sharetube_id = $row[\'sharetube_id\'];
			}
// 一番ややこしい場所なのでまたトラブルがあるかもしれないので監視をする 2015.08.25 松岡
// アクセスDB追加 & all_page_view & pay_pv をプラス & アクセスサマリー書き込み
Model_article_basis::cron_article_access_writing_and_all_page_view_plus($method, $user_data_array, $sharetube_id);








?>';
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $view_data["title"]; ?></title>
		<!-- meta -->
		<?php echo $view_data["meta"]; ?>
		<!-- icon -->
		<link rel="shortcut icon" href="<?php echo HTTP; ?>assets/img/icon/favicon_5.ico" type="image/vnd.microsoft.icon">



		<!-- rss -->
		<link rel="alternate" type="application/rss+xml" title="Sharetube RSSフィード" href="<?php echo HTTP; ?>feed.xml">
		<!-- css -->
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/common/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/matome/common.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/library/typicons.2.0.7/font/typicons.css" type="text/css">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/css/library/flickity.1.1.1/flickity.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo HTTP; ?>assets/js/library/flexslider.2/flexslider.css" type="text/css" media="screen">
		<link rel="apple-touch-icon" href="<?php echo HTTP; ?>assets/img/icon/apple_touch_icon_1.png" />
		<link rel="apple-touch-icon-precomposed" href="<?php echo HTTP; ?>assets/img/icon/apple_touch_icon_1.png" />

		<?php echo $view_data["external_css"]; ?>
	</head>
	<body>
		<!-- wrapper -->
		<div id="wrapper">
			<!-- header -->
			<?php echo $view_data["header"]; ?>
			<!-- mobile_ad -->
			<?php  echo $view_data["mobile_ad"]; ?>
			<!-- drawer -->
			<?php echo $view_data["drawer"]; ?>
			<!-- main -->
			<div class="main clearfix">
				<!-- sp_thumbnail -->
				<?php echo $view_data["sp_thumbnail"]; ?>
				<!-- navigation -->
				<?php echo $view_data["navigation"]; ?>
				<!-- main_contents -->
				<div class="main_contents clearfix">
					<?php echo $view_data["content"]; ?>
				</div>
				<!-- sidebar -->
				<div class="sidebar">
					<?php echo $view_data["sidebar"]; ?>
				</div>
			</div>
			<!-- footer -->
			<?php echo $view_data["plus_add"]; ?>
			<?php echo $view_data["footer"]; ?>
			<?php echo $view_data["script"]; ?>
		</div>
	</body>
</html>
