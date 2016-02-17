<?php 

/**
 * インフォ関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Info_Basis extends Model {
	//-----------
	//Uri情報取得
	//-----------
	public static function segment_info_get() {
		$top_judgment      = FALSE;
		$category_segment  = '';
		$category_name     = '';
		$parent_name       = '';
		$parent_segment    = '';
		$paging_segment    = 0;
		$last_segument     = '';
		$segment_error     = TRUE;
		$article_judgment  = FALSE;
		$article_url_error = FALSE;
		$title_segment     = '';

		// 現在いるファイル名を取得
		$url = $_SERVER["PHP_SELF"];
		// セグメントをarrayで並べる
		$segments_array = explode("/", $url);
		// 無駄なセグメント削除
		foreach($segments_array as $key => $value) {
			if($value == '' || $value == 'sharetube' || $value == 'index.php') {
				// 上記の値の場合削除
				unset($segments_array[$key]);
			}
		}
		// arrayを詰める
		$segments_array = array_merge($segments_array);
		// arrayの順番を逆にする
		// $segments = array_reverse($segments_array);

		// トップページ判定
		if($segments_array == array()) {
			$top_judgment = TRUE;
		}
		//---------------------
		// セグメントを走査する
		//---------------------
		foreach($segments_array as $key => $value) {
			//------------
			//記事判定取得
			//------------
			if(preg_match('/^[0-9]+$/', $value, $article_preg_array)) {
//			var_dump($article_preg_array);
//			var_dump($value);

				$query = DB::query("
					SELECT COUNT(link)
					FROM article
					WHERE link = '".$value."'
					AND del    = 0
					LIMIT 0, 1")->cached(86400)->execute();
				foreach($query as $key_1 => $value_1) {
					// 公開している記事である
					if((int)$value_1["COUNT(link)"] === 1) {
						$article_judgment  = TRUE;
						$article_url_error = TRUE;
					}
						// 公開している記事ではない
						else {
							$article_judgment  = TRUE;
							$article_url_error = FALSE;
						}
				} // foreach($query as $key_1 => $value_1) {
			} // if(preg_match('((^[0-9]{0,4})(-|_)([0-9]{0,2})(-|_)([0-9]{0,2})(-|_)(.*))', $value, $article_preg_array)) {
				//--------------
				//ページング判定
				//--------------
				else if(preg_match('/(^[0-9]+?$)/', $value, $paging_preg_array)) {
//					var_dump($paging_preg_array);
//					print "ページング";
					$paging_segment = (int)$value;
				}
					//----------------
					//記事ではない場合
					//----------------
					else {
						// セグメント情報取得
						$query_count = DB::query("
							SELECT COUNT(*)
							FROM category_segment 
							WHERE category_segment = '".$value."'")->cached(86400)->execute();
						//--------------
						//セグメント確認
						//--------------
						foreach($query_count as $key_2 => $value_2) {
							// セグメントあり
							if($value_2["COUNT(*)"]) {
								$last_segument   = $value;
							}
								// セグメントなし
								else {
									$segment_error = FALSE;
								}
						}
					} // 記事ではない場合 else {
		} // foreach($segments_array as $key => $value) {
//		var_dump($last_segument);
//		echo $last_segument;
//		echo $paging_segment;

		// セグメント情報取得
		$query = DB::query("
			SELECT * 
			FROM category_segment 
			WHERE category_segment = '".$last_segument."'")->cached(86400)->execute();
		foreach($query as $key => $value) {
//			var_dump($value);
			$category_name    = $value["category_name"];
			$category_segment = $value["category_segment"];
			$parent_name      = $value["parent_name"];
			$parent_segment   = $value["parent_segment"];
		}
//		var_dump($parent_name);
		// タイトルセグメント取得
		if($paging_segment) {
			$title_segment .= $paging_segment." | ";	
		}
		if($category_name) {
			$title_segment .= $category_name." | ";
		}
		if($parent_name) {
			$title_segment .= $parent_name." | ";
		}
//		var_dump($title_segment);


		$segment_info_get_array = array(
			'top_judgment'         => $top_judgment,      // 
			'segment'              => $category_segment,  // 
			'segment_error'        => $segment_error,     // 
			'category_name'        => $category_name,     // 
			'category_segment'     => $category_segment,  // 
			'parent_name'          => $parent_name,       // 
			'parent_segment'       => $parent_segment,    // 
			'paging_segment'       => $paging_segment,    // 
			'article_judgment'     => $article_judgment,  // 
			'article_url_error'    => $article_url_error, // 
			'title_segment'        => $title_segment,     //
		);
		return $segment_info_get_array;
	}
	//------------------------
	//ブログの公開記事の数取得
	//------------------------
	public static function article_count_get($segment_info_get_array) {
		switch($segment_info_get_array["segment"]) {
			case '':
				$and_query = '';
			break;
			default:
				// お父さん
				if(! $segment_info_get_array["parent_name"]) {
					$and_query =  "AND category = '".$segment_info_get_array["category_name"]."'";
				}
					// 子供
					else {
						$and_query =  "AND sub_category = '".$segment_info_get_array["category_name"]."'";
					}
			break;
		}
		// 記事のカウント取得
		$query = DB::query("
			SELECT COUNT(primary_id) 
			FROM press
			WHERE del = 0
			".$and_query."
			")->execute();
		foreach($query as $key => $value) {
			$article_count_number = $value["COUNT(primary_id)"];
		}
		return $article_count_number;
	}
	//----------------
	//カテゴリ情報取得
	//----------------
	public static function category_info_get($category = null) {
//		var_dump($category);
		$category_info_array = array();
		$res = DB::query("
			SELECT *
			FROM category_segment
			WHERE category_name = '".$category."'
			AND parmalink_check = 0")->cached(3600)->execute();
		foreach($res as $key => $value) {
//				var_dump($value);
			$category_info_array = $value;
		}
		return $category_info_array;		
	}
	//--------------------------------
	//セグメントからのカテゴリ情報取得
	//--------------------------------
	public static function segment_category_info_get($category_segment = null) {
//		var_dump($category_segment);
		// エラー回避
		$category_info_array = array(
			'category_segment' => '',
			'category_name'    => '',
		);
		$res = DB::query("
			SELECT *
			FROM category_segment
			WHERE category_segment = '".$category_segment."'
			AND parmalink_check = 0")->execute();
		foreach($res as $key => $value) {
//			var_dump($value);
			$category_info_array = $value;
		}
		return $category_info_array;		
	}
	//------------------
	//まとめのデータ取得
	//------------------
	public static function article_data_get($method) {
		$article_res = DB::query("
			SELECT * 
			FROM article 
			WHERE primary_id = ".$method."
			AND del = 0
			LIMIT 0, 1")->execute();
		foreach($article_res as $key => $value) {
			$article_data_array = array();
			$article_data_array['primary_id']      = $value['primary_id'];
			$article_data_array['sharetube_id']    = $value['sharetube_id'];
			$article_data_array['category']        = $value['category'];
			$article_data_array['title']           = $value['title'];
			$article_data_array['sub_text']        = $value['sub_text'];
			$article_data_array['tag']             = $value['tag'];
			$article_data_array['thumbnail_image'] = $value['thumbnail_image'];
			$article_data_array['sp_thumbnail']    = $value['sp_thumbnail'];
			$article_data_array['link']            = $value['link'];
			$article_data_array['matome_frg']      = $value['matome_frg'];
			$article_data_array['random_key']      = $value['random_key'];
			$article_data_array['del']             = $value['del'];
			$article_data_array['create_time']     = $value['create_time'];
			$article_data_array['update_time']     = $value['update_time'];
		}
		return $article_data_array;
	}
	//----------------------------
	//記事があるかどうかを検査する
	//----------------------------
	public static function is_article($method, $article_type = 'article') {
		$is_article = false;
		$res = DB::query(
			"SELECT *
				FROM ".$article_type."
				WHERE link = ".$method."
				AND del = 0")->cached(3600)->execute();
		foreach($res as $key => $value) {
//			var_dump($value);
			$is_article = true;
		}
		return $is_article;
	}
	//----------------------------------
	//下書き記事があるかどうかを検査する
	//----------------------------------
	public static function is_draft_article($method) {
		$is_article = false;
		$res = DB::query(
			"SELECT *
				FROM draft
				WHERE primary_id = ".$method."
				AND del = 0")->execute();
		foreach($res as $key => $value) {
//			var_dump($value);
			$is_article = true;
		}
		return $is_article;
	}
	//----------------
	//ユーザー情報取得
	//----------------
	static function user_data_get() {
		// エラー回避
		error_reporting(0);
		ini_set('display_errors', 1);

		$user_data_array = array();
		$httpvars = array(
		'REMOTE_ADDR'          => 'IPアドレス',
		'REMOTE_HOST'          => 'ホスト名',
		'REMOTE_PORT'          => 'ポート番号',
		'HTTP_USER_AGENT'      => 'ユーザーエージェント',
		'HTTP_REFERER'         => '参照ページアドレス',
		'HTTP_ACCEPT_LANGUAGE' => '言語',
		'HTTP_CONNECTION'      => 'コネクションヘッダ',
		);
		//REMOTE_HOSTがなければgethostbyaddrで取得
		if(!isset($_SERVER['REMOTE_HOST']) || $_SERVER['REMOTE_HOST'] == '') {
//			var_dump($_SERVER);
			$_SERVER['REMOTE_HOST'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
//			var_dump($_SERVER['REMOTE_HOST']);
			foreach($httpvars as $key => $value) {
//				var_dump($key);
//				var_dump($_SERVER[$key]);
				$user_data_array[$key] = $_SERVER[$key];
			}
//		var_dump($user_data_array);
		}
		return $user_data_array;
	}
	//-----------------------------------
	//Sharetubeのユーザーかどうかを調べる
	//-----------------------------------
	public static function is_sharetube_id($sharetube_id) {
		$is_sharetube_id = false;
		$sharetube_user_data_res = DB::query("
			SELECT *
			FROM user
			WHERE sharetube_id = '".$sharetube_id."'")->execute();
		foreach($sharetube_user_data_res as $key => $value) {
			$is_sharetube_id = true;
		}
		return $is_sharetube_id;
	}
	//-----------------------------
	//Sharetubeのユーザーデータ取得
	//-----------------------------
	static function sharetube_user_data_get($sharetube_id) {
		$sharetube_user_data_array  = array();
		$sharetube_user_data_res = DB::query("
			SELECT *
			FROM user 
			WHERE sharetube_id = '".$sharetube_id."'")->execute();
		foreach($sharetube_user_data_res as $key => $value) {
			$sharetube_user_data_array["primary_id"]          = $value["primary_id"];
			$sharetube_user_data_array["sharetube_id"]        = $value["sharetube_id"];
			$sharetube_user_data_array["name"]                = $value["name"];
			$sharetube_user_data_array["email"]               = $value["email"];
			$sharetube_user_data_array["url"]                 = $value["url"];
			$sharetube_user_data_array["management_site_url"] = $value["management_site_url"];
			$sharetube_user_data_array["profile_contents"]    = $value["profile_contents"];
			$sharetube_user_data_array["profile_icon"]        = $value["profile_icon"];
			$sharetube_user_data_array["profile_html"]        = $value["profile_html"];
			$sharetube_user_data_array["twitter_id"]          = $value["twitter_id"];
			$sharetube_user_data_array["facebook_id"]         = $value["facebook_id"];
			$sharetube_user_data_array["pay_pv"]              = (int)$value["pay_pv"];
			$sharetube_user_data_array["all_page_view"]       = (int)$value["all_page_view"];
			$sharetube_user_data_array["bank_name"]           = $value["bank_name"];
			$sharetube_user_data_array["account_holder"]      = $value["account_holder"];
			$sharetube_user_data_array["account_type"]        = $value["account_type"];
			$sharetube_user_data_array["branch_code"]         = $value["branch_code"];
			$sharetube_user_data_array["account_number"]      = $value["account_number"];
		}
		return $sharetube_user_data_array;
	}
	//-------------------------------------
	//Sharetubeユーザーの書いた記事数を取得
	//-------------------------------------
	public static function sharetube_user_article_count_get($sharetube_id) {
		$res = DB::query("
			SELECT COUNT(*)
				FROM article
				WHERE del = 0
				AND sharetube_id = '".$sharetube_id."'")->cached(3600)->execute();
		foreach($res as $key => $value) {
			$article_count = (int)$value["COUNT(*)"];
		}
		return $article_count;
	}
	//------------------------------------------
	//モバイルからのアクセスなのかどうかを調べる
	//------------------------------------------
	static function mobil_is_access_check() {
		$user_agent = $_SERVER["HTTP_USER_AGENT"];
		$user_is_mobil = ((strpos($user_agent, 'iPhone') !== false) || (strpos($user_agent, 'iPod') !== false) || (strpos($user_agent, 'iPad') !== false) || (strpos($user_agent, 'Windows Phone') !== false) || (strpos($user_agent, 'BlackBerry') !== false) || (strpos($user_agent, 'Symbian') !== false));
		if($user_is_mobil == true) {

		}
// 参考にするサイト http://www.openspc2.org/userAgent/
		return $user_is_mobil;
	}
	//------------------------------------
	//アーカイブの指定で記事があるかないか
	//------------------------------------
	static function is_archiva_article($year, $month) {
		$is_archiva_article = false;
		$month = (int)$month;
		if($month >= 10) {
			$month = (string)$month;
		}
			else {
				$month = "0".(string)$month;
			}
		$list_query = DB::query("
			SELECT *
			FROM article
			WHERE del = 0
			AND create_time > '".$year."-".$month."-01'
			AND create_time < '".$year."-".$month."-31'
			ORDER BY article.primary_id DESC")->cached(86400)->execute();
//			var_dump($list_query);
		foreach($list_query as $key => $value) {
			$is_archiva_article = true;
		}
		return $is_archiva_article;
	}
	//--------------------------
	//アーカイブ月の記事数を取得
	//--------------------------
	static function archive_article_num_get($year, $month) {
		$archive_article_num = 0;
		$list_query = DB::query("
			SELECT COUNT(*)
			FROM article
			WHERE del = 0
			AND create_time > '".$year."-".$month."-01'
			AND create_time < '".$year."-".$month."-31'
			ORDER BY article.primary_id DESC")->cached(86400)->execute();
//			var_dump($list_query);
		foreach($list_query as $key => $value) {
			$archive_article_num = $value["COUNT(*)"];
		}
		return $archive_article_num;
	}
	//-----------------------------------------------------
	//モバイル判別するPHPクラスライブラリを利用した機種判別
	//-----------------------------------------------------
	static function mobile_detect_create() {
		// モバイル判別するPHPクラスライブラリ
		require_once PATH.'assets/library/Mobile-Detect-2.8.5/'.'Mobile_Detect.php';
		$detect = new Mobile_Detect;
/*
		var_dump($detect);
		var_dump($detect->isMobile());
		var_dump($detect->isTablet());
		var_dump($detect->isiOS());
		var_dump($detect->isAndroidOS());
		var_dump($detect->is('Chrome'));
		var_dump($detect->is('iOS'));
		var_dump($detect->is('UC Browser'));
if($detect->isMobile() || $detect->isTablet()) {
    // モバイル・タブレット
}
	else {
	    // PC
	}
*/
		return $detect;
	}
	//----------------------------
	//1アクセス前のREMOTE_HOST取得
	//----------------------------
	public static function one_before_remote_host_get($method) {
		$access_res = DB::query("
			SELECT * 
			FROM access 
			WHERE article_id = ".$method."
			ORDER BY primary_id DESC 
			LIMIT 0, 1")->execute();
		foreach($access_res as $key => $value) {
			$REMOTE_HOST = $value["REMOTE_HOST"];
		}
		return $REMOTE_HOST;
	}

}