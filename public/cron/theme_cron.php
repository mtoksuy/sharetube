<?php

echo '始まり';
/*******
独自関数
*******/
// プレヴァーダンプ
function pre_var_dump($data = '') {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

if($_SERVER["HTTP_HOST"] == "localhost") {
	$host_name = 'localhost';
	$user_name = 'root';
	$password  = 'root';
}
	else {
		$host_name = '157.7.134.214';
		$user_name = 'sharetube';
		$password  = 'Sm10120616';
	} 

	// データベース接続
	$link = mysql_connect($host_name, $user_name, $password);
	// 接続したら
	if($link) {
		$db_selected = mysql_select_db('fuel_sharetube', $link);
		mysql_query('SET NAMES utf8', $link);
		////////////
		//必要な変数
		////////////
		$count_sum = 100;
		///////////////
		//now_count取得
		///////////////
		$result = mysql_query('
			SELECT * 
			FROM theme_cron 
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
			INSERT INTO theme_cron (
				now_count)
			VALUES ( 
				".$next_count.")");
		////////////////////////////////////////////////////////////////////
		//theme取得してどれくらい記事があるか計算してもう一度themeに編集する
		////////////////////////////////////////////////////////////////////
		// theme500取得
		$result = mysql_query("
			SELECT * 
			FROM theme 
			ORDER BY primary_id ASC 
			LIMIT ".$now_count.", ".$count_sum."");
/*
pre_var_dump($now_count);
pre_var_dump($count_sum);
*/
		while($row = mysql_fetch_assoc($result)) {
//			pre_var_dump($row['theme_name'].'<br>-----------');
			$theme_name = $row['theme_name'];
			$result_2 = mysql_query("
					SELECT primary_id, tag
					FROM article
					WHERE tag LIKE '%".$row['theme_name']."%'
					AND del = 0
				ORDER BY article.primary_id DESC");
			$i = 0;
			while($row_2 = mysql_fetch_assoc($result_2)) {
//			= $row_2['primary_id'];
//				pre_var_dump($row_2);
				$theme_data = $row_2['tag'];
//				pre_var_dump($theme_data);
				// テーマarray生成
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
//				pre_var_dump($theme_array);
				foreach($theme_array as $tag_array_key => $tag_array_value) {
					if($tag_array_value == $theme_name) {
//						pre_var_dump($tag_array_value.'▼');
						$i++;
					}
				}
			} // while($row_2 = mysql_fetch_assoc($result_2)) {
				$article_count = $i;
/*
				pre_var_dump($article_count);
				pre_var_dump($row['primary_id']);
*/
				$result_2 = mysql_query("
					UPDATE theme 
					SET article_count = ".$article_count."
					WHERE primary_id = ".(int)$row['primary_id']."");
		} // while($row = mysql_fetch_assoc($result)) {
		// クローズ
		mysql_close($link);	
	}

echo '終わり';


?>