<?php 
class Model_Article_Basis extends Model {
	//------------------
	//記事一覧データ取得
	//------------------
	static function list_get($segment_info_get_array, $get_num = 3, $article_number = null, $article_type = 'article') {
//		var_dump($segment_info_get_array);
//		var_dump($get_num);
//		var_dump($article_number);
//		var_dump($article_type);
		$limit_num = '';
//		$get_num   = '';
		// limitクエリ
		switch($segment_info_get_array["paging_segment"]) {
			case 0:
			case 1:
				$start_num = 0;
//				$get_num = 3;
			break;
			default:
				$start_num = (($segment_info_get_array["paging_segment"] * 3) - 3);
//				$get_num = 3;
			break;
		}
		$limit_query = "LIMIT ".$start_num.", ".$get_num."";
//		var_dump($limit_query);

		// andクエリ
		switch($segment_info_get_array["segment"]) {
			case '':
				$and_query =  '';
			break;
			// カテゴリー挙動
			default:
					// カテゴリー
					$and_query = "AND category = '".$segment_info_get_array["category_name"]."'";
			break;
		}
		// andクエリ(ajax用)
		if($article_number) {
			$and_2_query = "AND primary_id < ".$article_number."";
		}
			else {
				$and_2_query = '';
			}

		$list_query = DB::query("
			SELECT *
			FROM ".$article_type."
			WHERE del = 0
			".$and_query."
			".$and_2_query."
			ORDER BY ".$article_type.".primary_id DESC
			".$limit_query."")->cached(900)->execute();
//		var_dump($list_query);
		return $list_query;
	}
	//--------------
	//記事データ取得
	//--------------
	public static function article_get($article_type, $method) {
		$article_res = DB::query("
			SELECT * 
			FROM ".$article_type." 
			WHERE del = 0
			AND link = '".$method."'
			LIMIT 0, 1")->cached(900)->execute();
			return $article_res;
	}
	//----------------------------
	//前の記事、次の記事データ取得
	//----------------------------
	public static function article_previous_next_get($article_primary_id , $article_type) {
		$query_p = DB::query("SELECT * 
									FROM ".$article_type."
									WHERE primary_id < $article_primary_id
									AND del = 0
									ORDER BY ".$article_type.".primary_id DESC
									LIMIT 0 , 1")->cached(86400)->execute();
		$query_n = DB::query("SELECT * 
									FROM ".$article_type."
									WHERE primary_id > $article_primary_id
									AND del = 0
									ORDER BY ".$article_type.".primary_id ASC
									LIMIT 0 , 1")->cached(900)->execute();
		$article_previous_next_res_array = array(
		 'previous' => $query_p,
		 'next'     => $query_n,
		 );
		return $article_previous_next_res_array;
	}
	//------------------
	//関連記事データ取得
	//------------------
	static function article_related_get($article_data_array, $article_type = 'article') {
		$related_count = 0;
//		var_dump($article_data_array["article_primary_id"]);
		// 元sql文
    $sql = 'SELECT * FROM '.$article_type.' WHERE ';
		// tagの分だけlike文を作る
    foreach ($article_data_array["tag_array"] as $key => $keyword) {
        $keywords[$key] = "tag like ".("'%".$keyword."%' AND primary_id != ".$article_data_array["article_primary_id"]." AND del = 0")."";
    }
		// or文でくっつけていく
    $sql .= join(' OR ', $keywords);

	// sql文を完成させる
    $sql = $sql.'
			ORDER BY primary_id DESC
			LIMIT 0 , 9';
//		var_dump($sql);
		// res取得
		$related_res = DB::query("".$sql."")->cached(3600)->execute();
		// sql文で取得した記事の数を取得
		foreach($related_res as $key => $value) {
			$related_count = $key;
		}
		// 奇数なら1減らす
		if(!($related_count % 2) == 0) {
			// 2015.09.27 奇数でも関連記事を表示するようにする 松岡
//			$related_count--;
		}
		return array($related_res, $related_count);
	}
	//------------------------
	//シャッフル記事データ取得
	//------------------------
	static function article_shuffle_get($article_primary_id, $article_type = 'article', $limit_num = 8) {
//		echo $limit_num;
		$shuffle_res = DB::query("
			SELECT *
			FROM article
			WHERE primary_id != $article_primary_id
			AND del           = 0
			ORDER BY RAND() LIMIT 0, $limit_num")->cached(3600)->execute();
			return $shuffle_res;
	}
	//-------------------------------------------
	//アクセスDB書き込み &  all_page_viewをプラス
	//-------------------------------------------
	static function article_access_writing_and_all_page_view_plus($method, $user_data_array, $article_res) {
//		var_dump($method);
//		var_dump($user_data_array);
		$is_access = true;
		// アクセス禁止名
		$save_array = array(
			'bot', 
			'amazonaws', 
			'trendmicro', 
			'softlayer', 
			'sakura.ne.jp',
			'rev.home.ne.jp',
			'Bookmark',
			'HatenaScreenshot',
			'help.yahoo',
			'topsy.com',
			'kng.mesh.ad.jp',
			'proxy', 
			'myvps.jp', 
			'173.252.90.119', 
			'pcd289076.netvigator.com', 
			'Ruby', 
			'dedicatedpanel.com', 
			'facebookexternalhit',
			'crawl.baidu.com',
			'customer-incero.com',
			'compatible',
			'ZendHttpClient',
			'ApacheBench',
		);
		foreach($save_array as $key => $value) {
			if(preg_match('/'.$value.'/i', $user_data_array["REMOTE_HOST"])) {
				$is_access = false;
			}
				else {
					if(preg_match('/'.$value.'/i', $user_data_array["HTTP_USER_AGENT"])) {
						$is_access = false;
					}
				}
		}
		if($is_access) {
			// 1アクセス前のREMOTE_HOST取得
			 $REMOTE_HOST = Model_Info_Basis::one_before_remote_host_get($method);
			// f5攻撃を防ぐ
			if($REMOTE_HOST != $user_data_array["REMOTE_HOST"]) {
	//			var_dump($is_access);
				// アクセス書き込み
				DB::query("
				INSERT INTO access (
					article_id ,
					REMOTE_ADDR ,
					REMOTE_HOST ,
					REMOTE_PORT ,
					HTTP_USER_AGENT ,
					HTTP_REFERER ,
					HTTP_ACCEPT_LANGUAGE ,
					HTTP_CONNECTION
				)
				VALUES (
					".$method.",
					'".$user_data_array["REMOTE_ADDR"]."',
					'".$user_data_array["REMOTE_HOST"]."',
					'".$user_data_array["REMOTE_PORT"]."',
					'".$user_data_array["HTTP_USER_AGENT"]."',
					'".$user_data_array["HTTP_REFERER"]."',
					'".$user_data_array["HTTP_ACCEPT_LANGUAGE"]."',
					'".$user_data_array["HTTP_CONNECTION"]."'
				)")->execute();

				////////////////////////////////
				//  all_page_view&pay_pvをプラス
				////////////////////////////////
				// Sharetube_id取得
				foreach($article_res as $key => $value) {
					$sharetube_id = $value["sharetube_id"];
				}
				// ユーザー情報取得
				$user_res = DB::query("
					SELECT *
					FROM user
					WHERE sharetube_id = '".$sharetube_id."'")->execute();
				// $all_page_view++
				foreach($user_res as $key => $value) {
					$primary_id    = $value["primary_id"];
					$pay_pv        = (int)$value["pay_pv"];
					$all_page_view = (int)$value["all_page_view"];
					$pay_pv++;
					$all_page_view++;
					// 更新
					DB::query("
						UPDATE
						user
						SET
						pay_pv        = ".$pay_pv.",
						all_page_view = ".$all_page_view."
						WHERE
						primary_id = ".$primary_id."")->execute();
				}
				///////////////////////////
				// アクセスサマリー書き込み
				///////////////////////////
				Model_Article_Basis::access_summary_writing($method, $article_res, $user_data_array);
			} // if(!$REMOTE_HOST  == $user_data_array["REMOTE_HOST"]) {
		} // if($is_access) {
	}
	//------------------------
	//アクセスサマリー書き込み
	//------------------------
	public static function access_summary_writing($article_id, $article_res, $user_data_array) {
		foreach($article_res as $key => $value) {
			$sharetube_id = $value["sharetube_id"];	
		}
		// 今日の日付を取得
		$now_time          = time();
		$now_date          = date('Y-m-d', $now_time);
		$create_date       = date('Y-m-d H:i:s', $now_time);
		$access_article_year_time  = (int)date('Y', $now_time);
		$access_article_month_time = (int)date('m', $now_time);
		$access_article_day_time   = (int)date('d', $now_time);
		$access_article_hour_time  = (int)date('H', $now_time);

		// access_summaryがあるかないか調べる
		$access_summary_res = DB::query("
			SELECT *
				FROM access_summary
				WHERE article_id = ".$article_id."
				AND year  = ".$access_article_year_time."
				AND month = ".$access_article_month_time."
				AND day   = ".$access_article_day_time."
				AND hour  = ".$access_article_hour_time."")->execute();

			$is_access_summary = false;
			$access_summary_array = array();
			foreach($access_summary_res as $key => $value) {
				$access_summary_array["primary_id"] = (int)$value["primary_id"];
				$access_summary_array["article_id"] = (int)$value["article_id"];
				$access_summary_array["count"]      = (int)$value["count"];
				$is_access_summary = true;
			}
			// なかったら作る
			if($is_access_summary == false) {
				DB::query("
					INSERT INTO access_summary (
						article_id,
						sharetube_id,
						year,
						month,
						day,
						hour,
						count,
						create_time,
						update_time) 
					VALUES (
					".$article_id.", 
					'".$sharetube_id."', 
					".$access_article_year_time.", 
					".$access_article_month_time.", 
					".$access_article_day_time.", 
					".$access_article_hour_time.", 
					1, 
					CURRENT_TIMESTAMP, 
					'".$create_date."');
				")->execute();
			} // if($is_access_summary == false) {
				// あったら加算してアップデート
				else {
					$access_summary_array["count"]++;
					DB::query("
						UPDATE access_summary
							SET 
								count       = ".$access_summary_array["count"].",
								update_time = '".date('Y-m-d H:i:s', time())."'
							WHERE primary_id = ".$access_summary_array["primary_id"]."")->execute();
				}
	}
	//----------------------
	//アクセスランキング取得
	//----------------------
	static function article_access_get($access_day_date = NULL, $get_num = 4) {
		// クエリが長時間になるための応急処置 2015.01.23 松岡
		// 最新記事のprimary_id取得
		$article_latest_data_array = Model_Article_Basis::article_latest_get();
		$latest_article_number = (int)$article_latest_data_array["primary_id"];
		// クエリ時間がきになるが再調整 50から200に変更 2016.01.11 松岡
		$add_and = "AND article_id > ".($latest_article_number - 200)."";

		// whereを空にする
		if($access_day_date === NULL) {
			$where = '';
		}
			// whereを準備する
			else {
				// 調整する
				$access_day_date = (int)$access_day_date;
				$access_day_date--;

				// キャッシュの値を調整
				if($access_day_date === 0) {
						$cached_time = 3600;
				}
					// 一ヶ月以上
					else if($access_day_date >= 29) {
							$cached_time = (86400 * 3);
					}
						// 一週間以上
						else if($access_day_date >= 6) {
								$cached_time = (86400);
						}
							// 想定外
							else {
								$cached_time = 86400 * 5;
							}
//				var_dump($cached_time);
				// 今日の日付を取得
				$today_date  = date('Y-m-d 23:59:59');
				// 日数分現在時刻から引く
				$access_date = date("Y-m-d H:i:s", strtotime("-".$access_day_date." day"));
				$access_date = date("Y-m-d 00:00:00", strtotime("-".$access_day_date." day"));
				$where = "WHERE create_time > '".$today_date."'
									AND   create_time < '".$access_date."'";
				$where = "WHERE create_time > '".$access_date."'
									AND   create_time < '".$today_date."'";
//				var_dump($where);
			}
/*
		前のバージョンのソースコード 2016.01.12 松岡

		$article_access_res = DB::query("
			SELECT access.article_id, COUNT(access.primary_id), article.primary_id, article.sharetube_id, article.category, article.title, article.tag, article.thumbnail_image, article.link, article.create_time
			FROM access
			LEFT JOIN article
			ON article.primary_id = access.article_id
				".$where."
			AND del = 0
			".$add_and."
			GROUP BY  article_id
			ORDER BY  COUNT(access.primary_id) DESC
			LIMIT 0 , ".$get_num."")->cached($cached_time)->execute();
*/
			// sum集計したres取得
			$access_sum_res = DB::query("
				SELECT article_id,SUM(access_summary.count)
				FROM access_summary 
					".$where."
					".$add_and."
				GROUP BY article_id
				ORDER BY SUM(access_summary.count) DESC
				LIMIT 0, ".$get_num."")->cached($cached_time)->execute();
//			var_dump($access_sum_res);
			$article_access_list = '';
			// 記事リスト作成
			foreach($access_sum_res as $key => $value) {
				$article_access_list .= $value['article_id'].',';
			}
			// 文末の,を削除
			$article_access_list = substr($article_access_list, 0, -1);
			// リストがある場合resを生成する(リストがないとエラーになるため)
			if($article_access_list) {
				// 記事リストのres取得
				$article_access_res = DB::query("
					SELECT *
					FROM article
					WHERE primary_id IN(".$article_access_list.")
					ORDER BY FIELD(primary_id,".$article_access_list.")")->cached($cached_time)->execute();
//				var_dump($article_access_res);
			}
			return $article_access_res;
	}
	//--------------------
	//最新記事のデータ取得
	//--------------------
	static function article_latest_get() {
		$article_latest_res = DB::query("SELECT *
						FROM article
						ORDER BY primary_id DESC
						LIMIT 0, 1")->execute();
		$article_latest_data_array =  array();
		foreach($article_latest_res as $key => $value) {
			$article_latest_data_array["primary_id"]      = $value["primary_id"];
			$article_latest_data_array["sharetube_id"]    = $value["sharetube_id"];
			$article_latest_data_array["category"]        = $value["category"];
			$article_latest_data_array["title"]           = $value["title"];
			$article_latest_data_array["sub_text"]        = $value["sub_text"];
			$article_latest_data_array["contents"]        = $value["contents"];
			$article_latest_data_array["text"]            = $value["text"];
			$article_latest_data_array["tag"]             = $value["tag"];
			$article_latest_data_array["original"]        = $value["original"];
			$article_latest_data_array["thumbnail_image"] = $value["thumbnail_image"];
			$article_latest_data_array["sp_thumbnail"]    = $value["sp_thumbnail"];
			$article_latest_data_array["link"]            = $value["link"];
			$article_latest_data_array["del"]             = $value["del"];
			$article_latest_data_array["create_time"]     = $value["create_time"];
			$article_latest_data_array["update_time"]     = $value["update_time"];
		}
		return $article_latest_data_array;
	}
	//----------------------
	//ピックアップデータ取得
	//----------------------
	public static function pickup_get($pickup_array) {
		foreach($pickup_array as $key => $value) {
			$pickup_res[$key] = DB::query('
				SELECT article.primary_id, article.sharetube_id, article.category, article.title, article.tag, article.thumbnail_image, article.link, article.create_time
				FROM article
				WHERE del = 0
				AND primary_id = '.$value.'')->cached(86400)->execute();
		}
		return $pickup_res;
	}
	//----------------------
	//注目まとめのリスト取得
	//----------------------
	public static function recommend_html_list_get($get_num = 10, $page_num = 1) {
		$recommend_article_array = array();
		$recommend_article_res = DB::query("
			SELECT *
			FROM recommend_article
			ORDER BY article_id DESC
			LIMIT 0, ".$get_num."")->execute();
		foreach($recommend_article_res as $key => $value) {
			$article_res = DB::query("
				SELECT primary_id, sharetube_id, category, title, sub_text, tag, thumbnail_image, sp_thumbnail, link, matome_frg, create_time, update_time
				FROM article
				WHERE primary_id = ".$value['article_id']."
				AND del = 0")->execute();
			foreach($article_res as $article_key => $article_value) {
				$recommend_article_array[$key] = $article_value;
			}
		} // foreach($recommend_article_res as $key => $value) {
		return $recommend_article_array;
	}












}