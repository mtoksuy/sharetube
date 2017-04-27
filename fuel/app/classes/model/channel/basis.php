<?php 
class Model_Channel_Basis extends Model {
	//----------------
	//リストで記事取得
	//----------------
	public static function channel_article_list_get($sharetube_id, $get_number = 10, $page = 0) {
		if(!$page == 0) {
			$start_number = ($page * 10);
			$start_number = $start_number -$get_number;
		}
			else {
				$start_number = 0;
			}
		$list_query = DB::query("
			SELECT *
			FROM article
			WHERE del = 0
			AND sharetube_id = '".$sharetube_id."'
			ORDER BY article.primary_id DESC
			LIMIT ".$start_number.", ".$get_number."")->cached(900)->execute();
		return $list_query;
	}
	//-----------------------------
	//参加しているテーマ一覧res取得
	//-----------------------------
	public static function sharetube_user_join_theme_res_get($method) {
		$res = DB::query("
			SELECT tag
			FROM article
			WHERE sharetube_id = '".$method."'
			AND del = 0
		")->execute();
foreach($res as $key => $value) {
//pre_var_dump($value);
			// テーマarray生成
			$theme_array = Model_Theme_Basis::theme_array_create($value['tag']);
//			pre_var_dump($theme_array);

}
/*
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


*/














	}
}