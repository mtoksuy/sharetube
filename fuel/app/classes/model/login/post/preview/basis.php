<?php 

class Model_Login_Post_Preview_Basis extends Model {
	//----------------
	//下書きの記事取得
	//----------------
	static function preview_article_get($primary_id) {
		$preview_article_res = DB::query("
			SELECT * 
			FROM draft
			WHERE primary_id = $primary_id
			LIMIT 0, 1")->execute();
		return $preview_article_res;
	}
}










