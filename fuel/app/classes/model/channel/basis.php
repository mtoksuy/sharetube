<?php 
class Model_Channel_Basis extends Model {
	//----------------
	//リストで記事取得
	//----------------
	public static function channel_article_list_get($sharetube_id, $get_number = 10, $page = 0) {
		if(!$page == 0) {
			$start_number = ($page * 10);
			$start_number = $start_number -$get_number;
		}
			else {
				$start_number = 0;
			}
		$list_query = DB::query("
			SELECT *
			FROM article
			WHERE del = 0
			AND sharetube_id = '".$sharetube_id."'
			ORDER BY article.primary_id DESC
			LIMIT ".$start_number.", ".$get_number."")->cached(900)->execute();
		return $list_query;
	}
}