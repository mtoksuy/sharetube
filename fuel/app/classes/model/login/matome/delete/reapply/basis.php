<?php 

/**
 * 削除された記事の申請Basisクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Matome_Delete_Reapply_Basis extends Model {
	//--------------------------
	//削除された記事のデータ取得
	//--------------------------
	static function delete_article_res_get($article_id) {
		$delete_article_data_get_res = DB::query("
			SELECT *
			FROM article
			WHERE primary_id = ".$article_id."
			AND del            = 1
			AND true_del       = 0")->execute();
		return $delete_article_data_get_res;
	}
	//--------------------------
	//申請されたまとめを公開する
	//--------------------------
	static function delete_article_reapply_authorization($article_create_data_array) {
		$delete_article_data_get_res = DB::query("
			UPDATE article 
				SET del = 0
				WHERE primary_id = ".(int)$article_create_data_array['link']."")->execute();
	}






}