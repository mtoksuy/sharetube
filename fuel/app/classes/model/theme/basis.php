<?php 

/**
 * テーマ関連のBasisクラス
 * 
 * 
 * 
 * 
 */

class Model_Theme_Basis extends Model {
	//------------------------------
	//テーマの名前でライククエリ生成
	//------------------------------
	public static function theme_name_like_query_create($theme_name) {
		// テーマ分け文字列群
		$theme_punctuation_data_array = array(' ', '　', ',', '、');
		// クエリ生成
		foreach($theme_punctuation_data_array as $key => $value) {
			if($key == 0) { $where_query = 'WHERE'; } else {$where_query = '||'; }
			$where_like_query .= "".$where_query." tag LIKE '%".$value.$theme_name."%'";
			$where_like_query .= " || tag LIKE '%".$theme_name.$value."%'";
		}
		$where_like_query = "WHERE tag LIKE '%".$theme_name."%'";
		return $where_like_query;
	}
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
		// テーマの名前でライククエリ生成
		$where_like_query = Model_Theme_Basis::theme_name_like_query_create($theme_name);
		// 
		$theme_article_data_array = array();
		$theme_article_data_array['theme_name'] = $theme_name;


		$i = 0;
		$ii = 0;
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
				".$where_like_query."
				AND del = 0
			ORDER BY article.primary_id DESC")->execute();

		foreach($theme_article_res as $key => $value) {
			list($tag_array, $tag_html) = Model_Article_Html::article_tag_html_create($value['tag']);
			foreach($tag_array as $tag_array_key => $tag_array_value) {
				if($tag_array_value == $theme_name) {
					$theme_article_data_array['theme_article'][$i] = $value['primary_id'];
					$i++;
				}
			}
		}
		// リストの数取得
		$theme_article_data_array['list_num'] = $i;
		foreach($theme_article_data_array['theme_article'] as $theme_article_data_key => $theme_article_data_value) {
			if($start_number <= $theme_article_data_key) {
				$get_number--;
				if($get_number >= 0) {
					$theme_article_data_array['get_theme_article'][$ii] = $theme_article_data_value;
					$get_article_list = $get_article_list.','.$theme_article_data_value;
					$ii++;
				}
			}
		}
		// 先頭のカンマ削除
		$get_article_list = ltrim($get_article_list, ',');
		if($get_article_list) {
			$theme_article_res = DB::query("
					SELECT *
					FROM article
					WHERE primary_id IN(".$get_article_list.")
					AND del = 0
				ORDER BY article.primary_id DESC")->execute();
		}
			else {
				$theme_article_res = '';
			}
		return array($theme_article_res ,$theme_article_data_array);
//		return array($theme_article_res);
	}
	//-----------------------
	//テーマカウント数res取得
	//-----------------------
	public static function theme_count_res_get($theme_name) {
		// テーマの名前でライククエリ生成
		$where_like_query = Model_Theme_Basis::theme_name_like_query_create($theme_name);
		$theme_count_res = DB::query("
			SELECT COUNT(*)
			FROM article
			".$where_like_query."
			AND del = 0")->execute();
		return $theme_count_res;
	}
	//--------------------------
	//テーマページングデータ取得
	//--------------------------
	public static function theme_paging_data_get($theme_article_data_array, $list_num, $paging_num) {
/*
		foreach($theme_res as $key => $value) {
			$theme_name = $value['theme_name'];
		}
		// テーマの名前でライククエリ生成
		$where_like_query = Model_Theme_Basis::theme_name_like_query_create($theme_name);

		// last_num取得
		$max_res = DB::query("
			SELECT COUNT(primary_id)
			FROM article
			".$where_like_query."
			AND del = 0")->cached(10800)->execute();
		foreach($max_res as $key => $value) {
			$last_num = (int)$value['COUNT(primary_id)'];
		}
*/
		// 最大ページング数取得
		$max_paging_num = (int)ceil($theme_article_data_array['list_num']/$list_num);
		// recommend_article_paging_data生成
		$theme_paging_data_array = array(
			'last_num'       => $theme_article_data_array['list_num'],
			'list_num'       => $list_num,
			'paging_num'     => $paging_num,
			'max_paging_num' => $max_paging_num,
		);
		return $theme_paging_data_array;
	}
}