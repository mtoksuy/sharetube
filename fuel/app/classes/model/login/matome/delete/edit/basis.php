<?php 

/**
 * 削除された記事の編集Basisクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Matome_Delete_Edit_Basis extends Model {
	//--------------------------
	//削除された記事のデータ取得
	//--------------------------
	static function delete_article_data_get($article_id) {
		$delete_article_data_get_res = DB::query("
			SELECT *
			FROM article
			WHERE primary_id = ".$article_id."
			AND del            = 1
			AND true_del       = 0")->execute();
		return $delete_article_data_get_res;
	}
}