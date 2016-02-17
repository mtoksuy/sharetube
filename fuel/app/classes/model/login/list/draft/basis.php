<?php 

/**
 * リスト・下書き関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_List_Draft_Basis extends Model {
	//----------------------
	//リスト下書き記事を取得
	//----------------------
	static function draft_article_list_get() {
		$draft_article_list_get_res = DB::query("
			SELECT *
			FROM draft
			WHERE sharetube_id = '".$_SESSION["sharetube_id"]."'
			AND draft          = 1
			AND del            = 0
			ORDER BY draft.primary_id DESC
			LIMIT 0 , 500")->execute();
		return $draft_article_list_get_res;
	}
	//----------------
	//下書きデータ取得
	//----------------
	static function draft_article_data_get($article_id) {
		$article_data_get_res = DB::query("
			SELECT *
			FROM draft
			WHERE primary_id = ".$article_id."
			AND del            = 0")->execute();
		return $article_data_get_res;
	}
	//------------
	//下書きを削除
	//------------
	static function draft_article_delete($method) {
//		var_dump($method);
		DB::query("
			UPDATE draft 
			SET
				draft = 0
			WHERE primary_id = $method;")->execute();
	}
}