<?php 

/**
 * アナリティクス関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Analytics_Basis extends Model {
	//------------------
	//access_summary取得
	//------------------
	public static function access_summary_get($day_ago_time = 30) {
		// time関連取得
		$now_time           = time();
		$one_month_ago_time = time()-($day_ago_time*24*60*60);
		$now_date           = date('Y-m-d', $now_time);
		$one_month_ago_date = date('Y-m-d', $one_month_ago_time);
		$access_summary_res = DB::query("
			SELECT *
			FROM access_summary
			WHERE sharetube_id = '".$_SESSION["sharetube_id"]."'
			AND create_time > '".$one_month_ago_date." 00:00:00'
			AND create_time < '".$now_date." 23:59:59'
			ORDER BY create_time ASC")->execute();
		return $access_summary_res;			
	}
	//------------------------
	//記事のaccess_summary取得
	//------------------------
	public static function article_access_summary_get($article_id, $day_ago_time = 30) {
		// time関連取得
		$now_time           = time();
		$one_month_ago_time = time()-($day_ago_time*24*60*60);
		$now_date           = date('Y-m-d', $now_time);
		$one_month_ago_date = date('Y-m-d', $one_month_ago_time);
		$access_summary_res = DB::query("
			SELECT *
			FROM access_summary
			WHERE article_id = '".$article_id."'
			AND create_time  > '".$one_month_ago_date." 00:00:00'
			AND create_time  < '".$now_date." 23:59:59'
			ORDER BY create_time ASC")->execute();
		return $access_summary_res;			
	}
	//------------------------
	//記事のaccess_summary取得
	//------------------------
	public static function article_limit_access_summary_get($day_ago_time = 30, $new_articles = '') {
		$limit_res = DB::query("
			SELECT * 
			FROM article
			WHERE sharetube_id = '".$_SESSION["sharetube_id"]."'
			ORDER BY primary_id DESC 
			LIMIT 10, 1")->execute();
			$limit_article_id = 0;
		foreach($limit_res as $key => $value) {
			$limit_article_id = (int)$value["primary_id"];
		}
		// 大事
		$day_ago_time--;
		// 新着分だけ取得するquery作成
		if($new_articles == 'new_articles') {
			$and_query = 'AND article_id > '.$limit_article_id.'';
		}
			else {
				$and_query = '';
			}

		// time関連取得
		$now_time           = time();
		$one_month_ago_time = time()-($day_ago_time*24*60*60);
		$now_date           = date('Y-m-d', $now_time);
		$one_month_ago_date = date('Y-m-d', $one_month_ago_time);
		$access_summary_res = DB::query("
			SELECT *
			FROM access_summary
			WHERE sharetube_id = '".$_SESSION["sharetube_id"]."'
			".$and_query."
			AND create_time  > '".$one_month_ago_date." 00:00:00'
			AND create_time  < '".$now_date." 23:59:59'
			ORDER BY create_time ASC")->execute();
		return $access_summary_res;
	}	
}
