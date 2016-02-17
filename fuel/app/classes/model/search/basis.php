<?php 
class Model_Search_Basis extends Model {
	//--------------------
	//検索結果を返すクエリ
	//--------------------
	static function search_get($search) {
		$search_res = '';
//		var_dump($search);
		$search_res = DB::query("
		SELECT *
		FROM article
		WHERE title    LIKE '%".$search."%' AND   del      = 0
		OR    sub_text LIKE '%".$search."%' AND   del      = 0
		OR    text     LIKE '%".$search."%' AND   del      = 0
		OR    tag      LIKE '%".$search."%' AND   del      = 0
		ORDER BY primary_id DESC
		LIMIT 0 , 30")->cached(3600)->execute();
//		var_dump($search_res);
		return $search_res;
	}
}