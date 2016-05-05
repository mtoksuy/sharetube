<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2013 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * Set error reporting and display errors settings.  You will want to change these when in production.
 */
error_reporting(-1);
ini_set('display_errors', 1);
		// エラー回避
		error_reporting(0);
		ini_set('display_errors', 1);

/*******
独自関数
*******/
function pre_var_dump($data = '') {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}


$okane     = 17;
$ayu       = 2.5;
$tomoko    = 1.5;
$seikatuhi = 5;
$hentai    = 6;
$biyoushitu = 1.2;
//echo $okane-$ayu-$tomoko-$seikatuhi-$hentai-$biyoushitu;




/**
 * ローカルと本番環境のpathを吸収
 */
// ローカル環境
if($_SERVER["HTTP_HOST"] == 'localhost') {
	// デフォルト変数生成
	define('HTTP', 'http://localhost/sharetube/');
	define('PATH', '/Volumes/2016_ssd_media'.$_SERVER["DOCUMENT_ROOT"].'/sharetube/');
	define('INTERNAL_PATH', str_replace('sharetube/', '', PATH).'fuelphp/sharetube/');
	define('TITLE', 'Sharetube [伝えたい情報をシェアする] キュレーションプラットフォームサービス');
	define('VINE_TITLE', 'Sharetube@Vine');
	define('META_KEYWORDS', 'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ');
	define('META_DESCRIPTION', 'シェアしたい情報を自由に組み合わせ、世界でたった一つのオリジナルページを作成・紹介できるサービス。[伝えたい情報をシェアする]ために。');
	define('VINE_META_KEYWORDS', 'Sharetube_vine');
	define('VINE_META_DESCRIPTION', '面白いVineをまとめているサイトです。');
	define('TWITTER_ID', 'ShareTube_jp');
}
	// 本番環境
	else {
		// デフォルト変数生成
		define('HTTP', 'http://'.$_SERVER["HTTP_HOST"].'/');
		define('PATH', $_SERVER["DOCUMENT_ROOT"].'/');
		define('INTERNAL_PATH', str_replace('public/', '', PATH));
		define('TITLE', 'Sharetube [伝えたい情報をシェアする]キュレーションプラットフォーム');
		define('VINE_TITLE', 'Sharetube@Vine');
		define('META_KEYWORDS', 'Sharetube,シェアチューブ,まとめ,キュレーション,キュレーター,インセンティブ');
		define('META_DESCRIPTION', 'シェアしたい情報を自由に組み合わせ、世界でたった一つのオリジナルページを作成・紹介できるサービス。[伝えたい情報をシェアする]ために。');
		define('VINE_META_KEYWORDS', 'Sharetube_vine');
		define('VINE_META_DESCRIPTION', '面白いVineをまとめているサイトです。');
		define('TWITTER_ID', 'ShareTube_jp');
	}

/*
動画を作成し、友だちや家族、世界中の人たちと共有

シェアしたい情報を自由に組み合わせ、世界でたった一つのオリジナルページを作成・紹介できるサービス。[伝えたい情報をシェアする]ために。

NAVER まとめ[情報をデザインする。キュレーションプラットフォーム]

あらゆる情報を、自由に組み合わせ、ひとつのページにまとめて保存・紹介できるサービス。誰もが[情報をデザイン]できるようにすることで、今までにない人と情報との出会いを実現します。
*/





//var_dump($_SERVER);
// wwwを消したいのだがここにこない.htacceccになっている（要研究）
if( preg_match("/^www\./", $_SERVER["HTTP_HOST"]) ) {
    $url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . preg_replace("/^www\./", "", $_SERVER["HTTP_HOST"]) . $_SERVER["REQUEST_URI"];
    header("Location: $url", true, 301);
    exit;
}
// indexでアクセスが来た場合リダイレクトする
if( preg_match("/index\.html$/", $_SERVER['REQUEST_URI']) ) {
    $url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . preg_replace("/index\.html$/", "", $_SERVER["REQUEST_URI"]);
    header("Location: $url", true, 301);
    exit;
}
// 最期に/が無い場合に付け足してリダイレクト（なお、ファイルを使う場合は改修が必要）
if(! preg_match("/\/$/", $_SERVER['REQUEST_URI']) ) {
    $url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].'/';
//		var_dump($url);
    header("Location: $url", true, 301);
    exit;
}
/*
// キャッシュを一週間に設定
$expires = (60*60*24*7);
header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
header('Cache-Control: private, max-age=' . $expires);
header('Pragma: cache');
*/



/**
 * Website document root
 */
define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);

/**
 * Path to the application directory.
 */
define('APPPATH', realpath(__DIR__.'/../fuel/app/').DIRECTORY_SEPARATOR);

/**
 * Path to the default packages directory.
 */
define('PKGPATH', realpath(__DIR__.'/../fuel/packages/').DIRECTORY_SEPARATOR);

/**
 * The path to the framework core.
 */
define('COREPATH', realpath(__DIR__.'/../fuel/core/').DIRECTORY_SEPARATOR);

// Get the start time and memory for use later
defined('FUEL_START_TIME') or define('FUEL_START_TIME', microtime(true));
defined('FUEL_START_MEM') or define('FUEL_START_MEM', memory_get_usage());

// Boot the app
require APPPATH.'bootstrap.php';

// Generate the request, execute it and send the output.
try
{
	$response = Request::forge()->execute()->response();
}
catch (HttpNotFoundException $e)
{
	\Request::reset_request(true);

	$route = array_key_exists('_404_', Router::$routes) ? Router::$routes['_404_']->translation : Config::get('routes._404_');

	if($route instanceof Closure)
	{
		$response = $route();

		if( ! $response instanceof Response)
		{
			$response = Response::forge($response);
		}
	}
	elseif ($route)
	{
		$response = Request::forge($route, false)->execute()->response();
	}
	else
	{
		throw $e;
	}
}

// Render the output
$response->body((string) $response);

// This will add the execution time and memory usage to the output.
// Comment this out if you don't use it.
if (strpos($response->body(), '{exec_time}') !== false or strpos($response->body(), '{mem_usage}') !== false)
{
	$bm = Profiler::app_total();
	$response->body(
		str_replace(
			array('{exec_time}', '{mem_usage}'),
			array(round($bm[0], 4), round($bm[1] / pow(1024, 2), 3)),
			$response->body()
		)
	);
}

$response->send(true);
