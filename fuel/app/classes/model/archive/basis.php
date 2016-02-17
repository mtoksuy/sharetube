<?php 
class Model_Archive_Basis extends Model {
	//------------------
	//記事一覧データ取得
	//------------------
	static function archive_article_list_get($year, $month, $get_num = 10) {
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
			ORDER BY article.primary_id DESC
			LIMIT 0, ".$get_num."")->cached(86400)->execute();
//		var_dump($list_query);
		return $list_query;
	}
	//-------------------------------------
	//アーカイブファースト_ラストデータ取得
	//-------------------------------------
	static function archive_first_last_data_get() {
		// 初めての記事データ取得
		$first_article_res = DB::query("
		SELECT *
		FROM article
		WHERE del = 0
		ORDER BY article.primary_id ASC
		LIMIT 0 , 1")->cached(2592000)->execute();
		
		// 最後の記事データ取得
		$last_article_res = DB::query("
		SELECT *
		FROM article
		WHERE del = 0
		ORDER BY article.primary_id DESC
		LIMIT 0 , 1")->cached(86400)->execute();
		return array($first_article_res, $last_article_res);
	}
}