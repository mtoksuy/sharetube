<?php 

/**
 * 削除リストBasis関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Matome_Delete_Basis extends Model {
	//------------------
	//削除した記事を取得
	//------------------
	static function delete_article_list_get() {
		$delete_article_list_get_res = DB::query("
			SELECT *
			FROM article
			WHERE sharetube_id = '".$_SESSION["sharetube_id"]."'
			AND del            = 1
			ORDER BY article.primary_id DESC
			LIMIT 0 , 500")->execute();
		return $delete_article_list_get_res;
	}
	//----------------
	//下書きデータ取得
	//----------------
	static function delete_article_data_get($article_id) {
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
	static function delete_article_delete($method) {
//		var_dump($method);
		DB::query("
			UPDATE draft 
			SET
				draft = 0
			WHERE primary_id = $method;")->execute();
	}
}