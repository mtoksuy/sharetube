<?php

//echo '始まり';
/*******
独自関数
*******/
// プレヴァーダンプ
function pre_var_dump($data = '') {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}
	$password = 'Sm10120616';

	// データベース接続
	$link = mysql_connect('localhost', 'root', $password);
	// 接続したら
	if($link) {
		$db_selected = mysql_select_db('fuel_sharetube', $link);
		mysql_query('SET NAMES utf8', $link);
		////////////
		//必要な変数
		////////////
		$count_sum = 5;
		///////////////
		//now_count取得
		///////////////
		$result = mysql_query('
			SELECT * 
			FROM theme_curator_cron 
			ORDER BY primary_id DESC 
			LIMIT 0, 1');
		while($row = mysql_fetch_assoc($result)) {
			$now_count = (int)$row['now_count'];
		}
		////////////////////////////////
		//themeの1番新しいprimary_id取得
		////////////////////////////////
		$result = mysql_query('
			SELECT * 
			FROM theme
			ORDER BY primary_id DESC
			LIMIT 0, 1');
		while($row = mysql_fetch_assoc($result)) {
			$last_primary_id = (int)$row['primary_id'];
		}
		////////////////////////////
		//$last_primary_idを越える時
		////////////////////////////
		if($last_primary_id < ($now_count+$count_sum)) {
			$count_sum = $last_primary_id - $now_count;
			$next_count = 0;
		}
			else {
				$next_count = ($now_count+$count_sum);
			}
		///////////////////
		//now_count繰り上げ
		///////////////////
		$result = mysql_query("
			INSERT INTO theme_curator_cron (
				now_count)
			VALUES ( 
				".$next_count.")");

		////////////////////////////////////////////////////////////////////
		//
		////////////////////////////////////////////////////////////////////
		// theme取得
		$result = mysql_query("
			SELECT * 
			FROM theme 
			ORDER BY primary_id ASC 
			LIMIT ".$now_count.", ".$count_sum."");

/*
// テスト用
		$result = mysql_query("
			SELECT * 
			FROM theme 
			ORDER BY primary_id ASC 
			LIMIT 0, 1");
*/

		while($row = mysql_fetch_assoc($result)) {
			//テーマのキュレーターデータarray取得
			$theme_relation_array   = array();
			$theme_relation_2_array = array();
			$theme_data_array       = array();
			$i                      = 0;
			$check                  = false;
			// 名前取得
			$theme_name = $row['theme_name'];

			// 名前挿入
			$theme_data_array['theme_name'] = $theme_name;

			// 記事からtag取得
			$theme_relation_res = mysql_query("
				SELECT primary_id, sharetube_id, tag
				FROM article
				WHERE tag LIKE '%".$theme_name."%'
				AND del = 0
				ORDER BY primary_id DESC");
			while($theme_relation_res_row = mysql_fetch_assoc($theme_relation_res)) {
				$theme_data = $theme_relation_res_row['tag'];
				//テーマarray生成
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
				foreach($theme_array as $theme_array_key => $theme_array_value) {
					if(preg_match('/^'.$theme_array_value.'\z/', $theme_name)) {
						$theme_data_array['curator_name'][$theme_relation_res_row['sharetube_id']]['article_primary_id'][] = $theme_relation_res_row['primary_id'];
					}
				}
			}


		$theme_curator_data_array = array();
		foreach($theme_data_array['curator_name'] as $theme_data_array_curator_name_key => $theme_data_array_curator_name_value) {
			foreach($theme_data_array_curator_name_value['article_primary_id'] as $theme_data_array_curator_name_value_key => $theme_data_array_curator_name_value_value) 			{
				$theme_article_sum_res = mysql_query("
					SELECT SUM(count)
					FROM access_summary
					WHERE article_id = ".(int)$theme_data_array_curator_name_value_value."");
				while($theme_article_sum_res_row = mysql_fetch_assoc($theme_article_sum_res)) {
					$theme_curator_data_array['curator'][$theme_data_array_curator_name_key]['count'] = ((int)$theme_article_sum_res_row['SUM(count)'])+$theme_curator_data_array['curator'][$theme_data_array_curator_name_key]['count'];
				}
			}
		}
		// テーマ情報挿入
		$theme_curator_data_array['theme_primary_id'] = $row['primary_id'];
		$theme_curator_data_array['theme_name']       = $row['theme_name'];
		$theme_curator_data_array['article_count']    = $row['article_count'];
		// ソート
		array_multisort($theme_curator_data_array['curator'] , SORT_DESC);
//		var_dump($theme_curator_data_array);
		// 配列を謎の形式に変換
		$theme_curator_data_array_serialize = serialize($theme_curator_data_array);
//		var_dump($theme_curator_data_array_serialize);
//		var_dump($row['primary_id']);

		// themeにキュレーターランキングを書き込み
		$theme_relation_res = mysql_query("
			UPDATE theme 
				SET curator_ranking_data = '".$theme_curator_data_array_serialize."'
				WHERE primary_id = ".(int)$row['primary_id']."");
		// 謎の変換からarray形式に戻す(超大事)
		$theme_curator_data_array = unserialize($theme_curator_data_array_serialize);
	} // while($row = mysql_fetch_assoc($result)) {
		// クローズ
		mysql_close($link);	
	}
echo '成功';
?>