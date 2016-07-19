<?php 

/**
 * テーマ関連のBasisクラス
 * 
 * 
 * 
 * 
 */

class Model_Theme_Basis extends Model {
	//----------------
	//テーマの名前取得
	//----------------
	public static function theme_name_get($method) {
		$theme_res = DB::query("
			SELECT *
			FROM theme
			WHERE primary_id = ".$method."
			AND del = 0")->execute();
		foreach($theme_res as $key => $value) {
			$theme_name = $value['theme_name'];
		}
		return $theme_name;
	}
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
		$theme_punctuation_data_array = array(' ', '　', ',', '、');
	foreach($theme_punctuation_data_array as $key => $value) {
		if($key == 0) { $where_query = 'WHERE'; } else {$where_query = '||'; }
		$and_query .= "".$where_query." tag LIKE '%".$value.$theme_name."%'";
		$and_query .= " || tag LIKE '%".$theme_name.$value."%'";
	}
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
				".$and_query."
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
	//--------------------------
	//テーマページングデータ取得
	//--------------------------
	public static function theme_paging_data_get($theme_res, $list_num, $paging_num) {
		foreach($theme_res as $key => $value) {
			$theme_name = $value['theme_name'];
		}
		// last_num取得
		$max_res = DB::query("
			SELECT COUNT(primary_id)
			FROM article
			WHERE tag LIKE '%".$theme_name."%'
			AND del = 0")->cached(10800)->execute();
		foreach($max_res as $key => $value) {
			$last_num = (int)$value['COUNT(primary_id)'];
		}
		// 最大ページング数取得
		$max_paging_num = (int)ceil($last_num/$list_num);
		// recommend_article_paging_data生成
		$theme_paging_data_array = array(
			'last_num'       => $last_num,
			'list_num'       => $list_num,
			'paging_num'     => $paging_num,
			'max_paging_num' => $max_paging_num,
		);
		return $theme_paging_data_array;
	}
}