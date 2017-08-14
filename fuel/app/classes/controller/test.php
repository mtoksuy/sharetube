<?php
/*
* テストコントローラー
* 
* 
* 
* 
*/

class Controller_Test extends Controller_Test_Template {
	// ルーター
	public function router($method, $params) {
		if($method == 'index') {
			$this->action_index();
		}
			else {
				$this->action_404();
			}
	}
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	//----------
	//アクション
	//----------
	public function action_index() {



/*
namespace Fuel\Tasks;

use Fuel\Core\Cli;
use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Curl\CurlUtil;
*/

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


		$article_template = \View::forge('basic/template');
		$article_template->view_data = array(
			'title'        => TITLE,
			'meta'         => \View::forge('article/meta'),
			'external_css' => \View::forge('article/externalcss'),
			'drawer'       => \View::forge('basic/drawer'),
			'header'       => \View::forge('basic/header'),
			'mobile_ad'    => \View::forge('articlecron/mobilead'),
			'sp_thumbnail' => \View::forge('basic/spthumbnail'),
			'navigation'   => \View::forge('basic/navigation'),
			'content'      => \View::forge('article/content'),
			'sidebar'      => \View::forge('basic/sidebar'),
			'plus_add'     => \View::forge('article/plusadd'),
			'footer'       => \View::forge('basic/footer'),
			'script'       => \View::forge('article/script'),
		);


	//
	//
	//
		////////////////////////////////////////////////////////////////////
		//
		////////////////////////////////////////////////////////////////////
		////////////
		//必要な変数
		////////////
		$now_count = 0;
		$count_sum = 1;
		///////////////
		//now_count取得
		///////////////
		$result = DB::query("
			SELECT * 
			FROM article_html_cron 
			ORDER BY primary_id DESC 
			LIMIT 0, 1")->execute();
		foreach($result as $key => $value) {
			$now_count = (int)$value['now_count'];
		}
		//////////////////////////////////
		//articleの1番新しいprimary_id取得
		//////////////////////////////////
		$result = DB::query("
			SELECT * 
			FROM article
			ORDER BY primary_id DESC
			LIMIT 0, 1")->execute();
		foreach($result as $key => $value) {
			$last_primary_id = (int)$value['primary_id'];
		}
		////////////////////////////
		//$last_primary_idを越える時
		////////////////////////////
		if($last_primary_id < ($now_count+$count_sum)) {
			$count_sum = $last_primary_id - $now_count;
			$next_count = 0;
		}
			else {
				$next_count = ($now_count+$count_sum);
			}
		///////////////////
		//now_count繰り上げ
		///////////////////
		$result = DB::query("
			INSERT INTO article_html_cron (
				now_count)
			VALUES ( 
				".$next_count.")")->execute();
		/////////////////
		//article情報取得
		/////////////////
		$result = DB::query("
			SELECT * 
			FROM article
			LIMIT ".$now_count.", ".$count_sum."")->execute();
		// ここでぶん回す
		foreach($result as $key => $value) {

		}

		// 目次表示のため記事idを送る
		$article_template->view_data['header']->set('header_data',array(
			'article_id' => '5351',
		), false);











echo($article_template->render());















	}
}
