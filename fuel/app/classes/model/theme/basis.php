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
		$theme_punctuation_data_array = array('　', ',', '、');
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
	public static function theme_name_get($method, $cached = 900) {
		$theme_res = DB::query("
			SELECT *
			FROM theme
			WHERE primary_id = ".$method."
			AND del = 0")->cached($cached)->execute();
		foreach($theme_res as $key => $value) {
			$theme_name = $value['theme_name'];
		}
		return $theme_name;
	}
	//-----------------------
	//テーマ名でテーマres取得
	//-----------------------
	public static function tag_name_in_theme_res_get($tag, $cached = 900) {
		$theme_res = DB::query("
			SELECT *
			FROM theme
			WHERE theme_name = '".$tag."'
			AND del = 0
			ORDER BY primary_id ASC
			LIMIT 0, 1")->cached($cached)->execute();
		return $theme_res;
	}
	//-------------
	//テーマres取得
	//-------------
	public static function theme_res_get($method, $cached = 900) {
		$theme_res = DB::query("
			SELECT *
			FROM theme
			WHERE primary_id = ".$method."
			AND del = 0")->cached($cached)->execute();
		return $theme_res;
	}
	//-----------------
	//テーマ一覧res取得
	//-----------------
	public static function theme_list_res_get($theme_name, $get_number = 10, $page = 0, $cached = 900) {
		// テーマの名前でライククエリ生成
		$where_like_query = Model_Theme_Basis::theme_name_like_query_create($theme_name);
		// 
		$theme_article_data_array = array();
		$theme_article_data_array['theme_name'] = $theme_name;

		$i  = 0;
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
			ORDER BY article.primary_id DESC")->cached($cached)->execute();

		foreach($theme_article_res as $key => $value) {
			// テーマarray生成
			$theme_array = Model_Theme_Basis::theme_array_create($value['tag']);
			foreach($theme_array as $tag_array_key => $tag_array_value) {
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
				ORDER BY article.primary_id DESC")->cached($cached)->execute();
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
	public static function theme_count_res_get($theme_name, $cached = 900) {
		// テーマの名前でライククエリ生成
		$where_like_query = Model_Theme_Basis::theme_name_like_query_create($theme_name);
		$theme_count_res = DB::query("
			SELECT COUNT(*)
			FROM article
			".$where_like_query."
			AND del = 0")->cached($cached)->execute();
		return $theme_count_res;
	}
	//--------------------------
	//テーマページングデータ取得
	//--------------------------
	public static function theme_paging_data_get($theme_article_data_array, $list_num, $paging_num) {
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
	//---------------
	//テーマarray生成
	//---------------
	static function theme_array_create($theme_data) {
//pre_var_dump($theme_data);
/*
[対応区切り文字列]
全角空白
、
,
*/
//"大戦争、sekai no owari"

		// 、を全角空白に置換
		$pattern = '/、/';
		$theme_data = preg_replace($pattern, '　', $theme_data);
		// ,を全角空白に置換
		$pattern = '/,/';
		$theme_data = preg_replace($pattern, '　', $theme_data);

		// タグarray
		$theme_array = explode('　', $theme_data);
		$null_array = array();
		foreach($theme_array as $key => $value) {
			if($value) {
				$null_array[] = $value;
			}
		}
		// タグarrayを戻す
		$theme_array = $null_array;
		return $theme_array;
	}
	//-------------------
	//関連テーマarray取得
	//-------------------
	public static function theme_relation_array_get($theme_res) {
		$theme_relation_array = array();
		$theme_relation_2_array = array();
		$i = 0;
		$check = false;
		foreach($theme_res as $key => $value) {
			$theme_name = $value['theme_name'];
		}
		$theme_relation_res = DB::query("
			SELECT tag
			FROM article
			WHERE tag LIKE '%".$theme_name."%'
			AND del = 0
			ORDER BY primary_id DESC")->cached(259200)->execute();
		foreach($theme_relation_res as $theme_relation_key => $theme_relation_value) {
			// テーマarray生成
			$theme_array = Model_Theme_Basis::theme_array_create($theme_relation_value['tag']);
//			pre_var_dump($theme_array);
			foreach($theme_array as $theme_array_key => $theme_array_value) {
				$theme_relation_array[$i] = $theme_array_value;
				$i++;
				foreach($theme_relation_array as $theme_relation_key => $theme_relation_value) {
					if($theme_relation_value == $theme_array_value) {
						if($theme_relation_2_array[$theme_relation_key]['count'] == null) {
							$theme_relation_2_array[$theme_relation_key]['theme_name'] = $theme_array_value;
							$theme_relation_2_array[$theme_relation_key]['count'] = 1;
						}
							else {
								$theme_relation_2_array[$theme_relation_key]['theme_name'] = $theme_array_value;
								$theme_relation_2_array[$theme_relation_key]['count']++;
							}
						break;
					}
						else {

						}
				}
			}
		}
		foreach ($theme_relation_2_array as $key_2 => $value_2) {
		  $key_id[$key_2]    = $value_2['theme_name'];
		  $key_count[$key_2] = $value_2['count'];
		}
		$theme_relation_2_array_check = array_multisort($key_count , SORT_DESC , $theme_relation_2_array);
//pre_var_dump($theme_relation_2_array);
		if($theme_relation_2_array_check) {
			return $theme_relation_2_array;
		}
			else {
				return $theme_relation_2_array = '';
			}
	}
}