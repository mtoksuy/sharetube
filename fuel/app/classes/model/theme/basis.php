<?php 

/**
 * テーマ関連のBasisクラス
 * 
 * 
 * 
 * 
 */

class Model_Theme_Basis extends Model {
	//-----------------------
	//テーマ名でテーマres取得
	//-----------------------
	public static function tag_name_in_theme_res_get($tag) {
		$theme_res = DB::query("
			SELECT *
			FROM theme
			WHERE theme_name = '".$tag."'
			AND del = 0
			ORDER BY primary_id ASC
			LIMIT 0, 1")->execute();
		return $theme_res;
	}
	//-------------
	//テーマres取得
	//-------------
	public static function theme_res_get($method) {
		$theme_res = DB::query("
			SELECT *
			FROM theme
			WHERE primary_id = ".$method."
			AND del = 0")->execute();
		return $theme_res;
	}
	//-----------------
	//テーマ一覧res取得
	//-----------------
	public static function theme_list_res_get($theme_name, $get_number = 10, $page = 0) {
		if(!$page == 0) {
			$start_number = ($page * 10);
			$start_number = $start_number -$get_number;
		}
			else {
				$start_number = 0;
			}
		$theme_article_res = DB::query("
				SELECT *
				FROM article
				WHERE tag LIKE '%".$theme_name."%'
				AND del = 0
			ORDER BY article.primary_id DESC
			LIMIT ".$start_number.", ".$get_number."")->execute();
		return $theme_article_res;
	}
	//-----------------------
	//テーマカウント数res取得
	//-----------------------
	public static function theme_count_res_get($theme_name) {
		$theme_count_res = DB::query("
			SELECT COUNT(*)
			FROM article
			WHERE tag LIKE '%".$theme_name."%'
			AND del = 0")->execute();
		return $theme_count_res;
	}



}