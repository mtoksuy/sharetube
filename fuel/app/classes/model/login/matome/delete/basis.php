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
	//----------------------
	//削除した記事データ取得
	//----------------------
	static function delete_article_data_array_get($method) {
		$article_res = DB::query("
			SELECT * 
			FROM article 
			WHERE primary_id = ".(int)$method."
			AND del = 1
			LIMIT 0, 1")->execute();
		foreach($article_res as $key => $value) {
			$delete_article_data_array = array();
			$delete_article_data_array['primary_id']      = $value['primary_id'];
			$delete_article_data_array['sharetube_id']    = $value['sharetube_id'];
			$delete_article_data_array['category']        = $value['category'];
			$delete_article_data_array['title']           = $value['title'];
			$delete_article_data_array['sub_text']        = $value['sub_text'];
			$delete_article_data_array['tag']             = $value['tag'];
			$delete_article_data_array['thumbnail_image'] = $value['thumbnail_image'];
			$delete_article_data_array['sp_thumbnail']    = $value['sp_thumbnail'];
			$delete_article_data_array['link']            = $value['link'];
			$delete_article_data_array['matome_frg']      = $value['matome_frg'];
			$delete_article_data_array['random_key']      = $value['random_key'];
			$delete_article_data_array['del']             = $value['del'];
			$delete_article_data_array['true_del']        = $value['true_del'];
			$delete_article_data_array['create_time']     = $value['create_time'];
			$delete_article_data_array['update_time']     = $value['update_time'];
		}
		return $delete_article_data_array;
	}




/*
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
*/


}