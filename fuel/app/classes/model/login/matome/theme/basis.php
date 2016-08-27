<?php 

/**
 * まとめ・テーマ関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Matome_Theme_Basis extends Model {
	//----------------
	//テーマエントリー
	//----------------
	static function theme_entry($article_create_data_array) {
		// テーマarray生成
		$theme_array = Model_Theme_Basis::theme_array_create($article_create_data_array['tag']);
		// 検査
		foreach($theme_array as $tag_key => $tag_value) {
			$tag_check_res = DB::query("
				SELECT *
				FROM theme
				WHERE theme_name = '".$tag_value."'
				AND del = 0")->execute();
			$theme_check = false;
			// すでにあったらtrue
			foreach($tag_check_res as $tag_check_key => $tag_check_value) {
				$theme_check = true;
			}
			// なかったらテーマ登録
			if(!$theme_check) {
				$tag_insert_res = DB::query("
					INSERT INTO
					theme (
						theme_name,
						theme_link_name,
						theme_summary
					)	
					VALUES (
						'".$tag_value."',
						'',
						''
					)
				")->execute();
				// create62Hash
				$tag_link_name = Model_Login_Twitterscraping_Basis::create62Hash($tag_insert_res[0]);
				// テーマアップデート
				DB::query("
					UPDATE theme
					SET theme_link_name = '".$tag_link_name."'
					WHERE primary_id = '".$tag_insert_res[0]."'")->execute();
			} // if(!$theme_check) {
		} // foreach($tag_array as $tag_key => $tag_value) {
	}
}
?>