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
//pre_var_dump($keywords);
		if($keywords) {
			// or文でくっつけていく
	    $sql .= join(' OR ', $keywords);
		// sql文を完成させる
	    $sql = $sql.'
				ORDER BY primary_id DESC
				LIMIT 0 , 9';
//			pre_var_dump($sql);
	/*
	string(128) "SELECT * FROM article WHERE tag like '%たぐう%' AND primary_id != 2247 AND del = 0 ORDER BY primary_id DESC LIMIT 0 , 9" 
	string(71) "SELECT * FROM article WHERE ORDER BY primary_id DESC LIMIT 0 , 9" 
	
	*/
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
//		pre_var_dump($method);
//		pre_var_dump($user_data_array);
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
			'K135224.ppp.dion.ne.jp',
			'MetaURI API/2.0 +metauri.com',
			'static.138.150.243.136.clients.your-server.de',
			'static.95.154.243.136.clients.your-server.de',
			'static.102.154.243.136.clients.your-server.de',
			'ntchba022101.chba.nt.ngn.ppp.infoweb.ne.jp',
			'p14n12.trendiction.de',
			'14-133-119-115.nagoya1.commufa.jp',
			'HRDfb-01p3-103.ppp11.odn.ad.jp',
			'sp1-66-99-229.msc.spmode.ne.jp',
			'p76edd101.sigant01.ap.so-net.ne.jp',
			'i220-220-218-157.s41.a013.ap.plala.or.jp',
			'103.5.140.157',
			'202.238.51.121',
			'59.106.163.181',
			'h3-fbs01-s.eset.com',
			'h3-fbs02-v.eset.com',
			'h3-fbs03-v.eset.com',
			'121-84-111-161f1.osk3.eonet.ne.jp',
			'ShortLinkTranslate',
			'softbank126074096029.bbtec.net',
			'sp49-98-144-188.msd.spmode.ne.jp',
			'zaq3d2e6b74.zaq.ne.jp',
			'202.229.53.180',
			'pc1.dm-network-unet.ocn.ne.jp',
			'202.229.53.181',
			'p20n12.trendiction.de',
			'sp49-98-144-188.msd.spmode.ne.jp',
			'p9n2.trendiction.de',
			'59.106.163.144',
			'59.106.163.170',
			'nttkyo224226.tkyo.nt.ngn2.ppp.infoweb.ne.jp',
			'opt-203-112-63-39.static.client.pikara.ne.jp',
			'M106073129032.v4.enabler.ne.jp',
			'om126204192120.6.openmobile.ne.jp',
			'sp49-98-138-35.msd.spmode.ne.jp',
			'sp49-98-167-13.msd.spmode.ne.jp',
			'sp49-104-13-149.msf.spmode.ne.jp',
			'42-83-33-85.btvm.ne.jp',
			'ai126167157121.37.access-internet.ne.jp',
			'KD182250241006.au-net.ne.jp',
			'sp1-75-245-192.msb.spmode.ne.jp',
			'sp1-75-246-65.msb.spmode.ne.jp',
			'ae190248.dynamic.ppp.asahi-net.or.jp',
			'sp49-98-157-241.msd.spmode.ne.jp',
			'KD106161178115.au-net.ne.jp',
			'user17-net218219023.ayu.ne.jp',
			'82.251.149.210.rev.vmobile.jp',
			'sp49-98-155-54.msd.spmode.ne.jp',
			'nttkyo224226.tkyo.nt.ngn2.ppp.infoweb.ne.jp',
			'softbank060071108071.bbtec.net',
			'KD119104104080.au-net.ne.jp',
			'KD106157067061.ppp-bb.dion.ne.jp',
			'KD182251242033.au-net.ne.jp',
			'FL1-118-108-107-241.iba.mesh.ad.jp',
			'58x13x160x59.ap58.ftth.ucom.ne.jp',
			'softbank126121235034.bbtec.net',
			'PPPa2281.e27.eacc.dti.ne.jp',
			'softbank219035166204.bbtec.net',
			'softbank126150091247.bbtec.net',
			'sp1-75-248-152.msb.spmode.ne.jp',
			'pw126152215034.10.panda-world.ne.jp',
			'KD036013008070.au-net.ne.jp',
			'nttnxt2-090.246.ne.jp',
			'p62042-ipngnfx01marunouchi.tokyo.ocn.ne.jp',
			'softbank126066079080.bbtec.net',
			'p14n20.trendiction.de',
			'p10n12.trendiction.de',
			'p12n18.trendiction.de',
			'33-254.ftth.onsbrabantnet.nl',
			'port-ip-213-211-241-42.sta.reverse.mdcc-fun.de',
			'101-140-226-106f1.kyt1.eonet.ne.jp',
			'static.93.154.243.136.clients.your-server.de',
			'158.127.151.118.st.dtn.ne.jp',
			's20-02-08.opera-mini.net',
			'sp1-72-4-118.msc.spmode.ne.jp',
			'p4n19.trendiction.de',
			'203.104.134.241',
			'static.93.154.243.136.clients.your-server.de',
			'235.196.178.107.gae.googleusercontent.com',
			'122.223.66.95.ap.gmobb-fix.jp',
			'p15n15.trendiction.de',
			'219.100.139.157',
			'sp1-66-99-58.msc.spmode.ne.jp',
			'localhost',
			'sp1-72-8-91.msc.spmode.ne.jp',
			'sp49-104-45-227.msf.spmode.ne.jp',
			'li484-218.members.linode.com',
			'sp49-98-67-149.mse.spmode.ne.jp',
		); // ふるいやつ


		// アクセス禁止名
		$save_array = array(
			'bot',
			'Ruby',
			'proxy',
			'Bookmark',
			'eset.com',
			'myvps.jp',
			'dti.ne.jp',
			'odn.ad.jp',
			'zaq.ne.jp',
			'ayu.ne.jp',
			'bbtec.net',
			'softlayer',
			'amazonaws',
			'localhost',
			'topsy.com',
			'compatible',
//			'mesh.ad.jp',
			'help.yahoo',
//			'ucom.ne.jp',
			'trendmicro',
//			'commufa.jp',
			'37.59.67.46',
			'ap.dream.jp',
			'btvm.ne.jp',
//			'plala.or.jp',
			'eonet.ne.jp',
			'metauri.com',
			'eonet.ne.jp',
			'ApacheBench',
			'pikara.ne.jp',
//			'spmode.ne.jp',
			'st.dtn.ne.jp',
//			'sakura.ne.jp',
//			'so-net.ne.jp',
			'103.5.140.157',
			'infoweb.ne.jp',
			'enabler.ne.jp',
			'infoweb.ne.jp',
			'59.106.163.170',
			'59.106.163.144',
			'trendiction.de',
			'opera-mini.net',
			'trendiction.de',
			'202.229.53.181',
			'kng.mesh.ad.jp',
			'rev.home.ne.jp',
			'173.252.90.119',
			'59.106.163.181',
			'178.33.177.186',
			'149.102.105.35',
			'149.102.107.187',
			'149.102.107.179',
			'202.238.51.121',
			'202.229.53.180',
			'netvigator.com',
			'ZendHttpClient',
//			'rev.vmobile.jp',
			'trendiction.de',
			'219.100.139.157',
			'crawl.baidu.com',
//			'asahi-net.or.jp',
			'ap.gmobb-fix.jp',
			'203.104.134.241',
//			'tokyo.ocn.ne.jp',
			'HatenaScreenshot',
			'onsbrabantnet.nl',
			'panda-world.ne.jp',
			'dedicatedpanel.com',
			'members.linode.com',
			'ShortLinkTranslate',
			'facebookexternalhit',
			'customer-incero.com',
			'reverse.mdcc-fun.de',
			'rev.poneytelecom.eu',
			'nttnxt2-090.246.ne.jp',
			'access-internet.ne.jp',
			'clients.your-server.de',
			'gae.googleusercontent.com',
			'Dalvik',
			'Java',
			'113.110.252.177',
		);
/*
// 文字列が短い順にソートを掛ける(すごい)
usort($save_array, create_function('$a,$b', 'return mb_strlen($a, "UTF-8") - mb_strlen($b, "UTF-8");'));
// 新しい順にしたいときに使用するコード
$yy = array();
foreach($save_array as $k => $v) {
	echo("'".$v."',");
	echo('<br>');
}
*/
// ローカルでテスト用
//$user_data_array["REMOTE_HOST"] = 'sp49-104-4-249.msf.spmode.ne.jp';

		foreach($save_array as $key => $value) {
			if(preg_match('/'.$value.'/i', $user_data_array["REMOTE_HOST"])) {
				$is_access = false;
				break;
			}
				else {
					if(preg_match('/'.$value.'/i', $user_data_array["HTTP_USER_AGENT"])) {
						$is_access = false;
						break;
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
	//---------------------------------
	//アクセスランキング取得 人気まとめ
	//---------------------------------
	static function article_access_get($access_day_date = NULL, $get_num = 4) {
		// クエリが長時間になるための応急処置 2015.01.23 松岡
		// 最新記事のprimary_id取得
		$article_latest_data_array = Model_Article_Basis::article_latest_get();
		// 最新記事primari_id取得
		$latest_article_number = (int)$article_latest_data_array["primary_id"];
		// クエリ時間がきになるが再調整 50から200に変更 2016.01.11 松岡
		$add_and = "AND article_id > ".($latest_article_number - 200)."";
		// 新しいadd_and作成 2016.06.24 松岡
		$recommend_article_200_res = DB::query("
			SELECT * 
			FROM recommend_article 
			WHERE del = 0
			ORDER BY article_id DESC
			LIMIT 0, 50")->cached(86400)->execute();
		foreach($recommend_article_200_res as $key => $value) {
			$add_and_2 .= ''.$value['article_id'].',';
		}
		// 初期化時のバグ回避
		if($add_and_2 == null) {
			$add_and_2 = '1,2,3,4,5,';
		}
		$add_and_2 = substr($add_and_2, 0, -1);
		$add_and_2 = 'AND article_id IN ('.$add_and_2.')';

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
					".$add_and_2."
				GROUP BY article_id
				ORDER BY SUM(access_summary.count) DESC
				LIMIT 0, ".$get_num."")->cached($cached_time)->execute();
//			pre_var_dump($access_sum_res);
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
	public static function recommend_article_list_get($get_num = 10, $page_num = 1) {
		// 取得する場所取得
		$start_list_num = ($page_num*$get_num)-$get_num;
		$recommend_article_array = array();
		$recommend_article_res = DB::query("
			SELECT *
			FROM recommend_article
			WHERE del = 0
			ORDER BY article_id DESC
			LIMIT ".$start_list_num.", ".$get_num."")->cached(10800)->execute();

		foreach($recommend_article_res as $key => $value) {
			$article_res = DB::query("
				SELECT primary_id, sharetube_id, category, title, sub_text, tag, thumbnail_image, sp_thumbnail, link, matome_frg, create_time, update_time
				FROM article
				WHERE primary_id = ".$value['article_id']."
				AND del = 0")->cached(86400)->execute();
			foreach($article_res as $article_key => $article_value) {
				$recommend_article_array[$key] = $article_value;
			}
		} // foreach($recommend_article_res as $key => $value) {
		return $recommend_article_array;
	}
	//------------------------------
	//注目まとめページングデータ取得
	//------------------------------
	public static function recommend_article_paging_data_get($list_num, $paging_num) {
		// last_num取得
		$max_res = DB::query("
			SELECT COUNT(primary_id)
			FROM recommend_article
			WHERE del = 0")->cached(10800)->execute();
		foreach($max_res as $key => $value) {
			$last_num = (int)$value['COUNT(primary_id)'];
		}
		// 最大ページング数取得
		$max_paging_num = (int)ceil($last_num/$list_num);
		// recommend_article_paging_data生成
		$recommend_article_paging_data_array = array(
			'last_num'       => $last_num,
			'list_num'       => $list_num,
			'paging_num'     => $paging_num,
			'max_paging_num' => $max_paging_num,
		);
		return $recommend_article_paging_data_array;
	}

	//----------------------
	//新着まとめのリスト取得
	//----------------------
	public static function new_article_list_get($get_num = 10, $page_num = 1) {
		// 取得する場所取得
		$start_list_num = ($page_num*$get_num)-$get_num;
		$new_article_array = array();
		$new_article_res = DB::query("
			SELECT *
			FROM article
			WHERE del = 0
			ORDER BY primary_id DESC
			LIMIT ".$start_list_num.", ".$get_num."")->cached(900)->execute();
		return $new_article_res;
	}
	//------------------------------
	//新着まとめページングデータ取得
	//------------------------------
	public static function new_article_paging_data_get($list_num, $paging_num) {
		// last_num取得
		$max_res = DB::query("
			SELECT COUNT(primary_id)
			FROM article
			WHERE del = 0")->cached(10800)->execute();
		foreach($max_res as $key => $value) {
			$last_num = (int)$value['COUNT(primary_id)'];
		}
		// 最大ページング数取得
		$max_paging_num = (int)ceil($last_num/$list_num);
		// new_article_paging_data生成
		$new_article_paging_data_array = array(
			'last_num'       => $last_num,
			'list_num'       => $list_num,
			'paging_num'     => $paging_num,
			'max_paging_num' => $max_paging_num,
		);
		return $new_article_paging_data_array;
	}
	//------------------------------
	//テーマを追ってみようデータ取得
	//------------------------------
	public static function related_theme_data_array_get($related_data_array, $cached = 900) {
		$loop_count = 3;
		$related_theme_data_array = array();

		foreach($related_data_array['tag_array'] as $key => $value) {
			if($loop_count > 0) {
				$loop_count--;
//				pre_var_dump($value);
				$theme_res = DB::query("
					SELECT *
					FROM theme 
					WHERE theme_name = '".$value."'
					AND del = 0
				")->cached(3600)->execute();
				foreach($theme_res as $theme_key => $theme_value) {
					// テーマ一覧HTML生成
					list($theme_list_html, $theme_article_data_array) = Model_Theme_Html::theme_list_html_create($theme_res, 1, 0);
//					pre_var_dump($theme_article_data_array);
					$related_theme_data_array[$key]['primary_id']   = $theme_value['primary_id'];
					$related_theme_data_array[$key]['theme_name']   = $theme_value['theme_name'];
					$related_theme_data_array[$key]['theme_summry'] = $theme_value['theme_summry'];
					$related_theme_data_array[$key]['theme_count']  = $theme_article_data_array['list_num'];
				}
			}
		}
		return $related_theme_data_array;
	}
	//----------------------------------------
	//まとめが注目まとめに入っているかチェック
	//----------------------------------------
	public static function recommend_check_get($method) {
		$recommend_check = false;

		$recommend_check_res = DB::query("
			SELECT * 
			FROM 
			recommend_article
			WHERE 
			article_id = ".$method."
			AND del = 0")->cached(0)->execute();

		foreach($recommend_check_res as $key => $value) {
			$recommend_check = true;
		}
		return $recommend_check;
	}



}