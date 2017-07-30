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

/*
// ローカル
if($_SERVER["HTTP_HOST"] == "localhost") {
	$password = 'root';
}
	// 本番
	else {
		$password = 'Sm10120616';
	}
*/
		$password = 'Sm10120616';

	// データベース接続
	$link = mysql_connect('157.7.134.214', 'sharetube', $password);

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
			pre_var_dump($row);
			$now_count = (int)$row['now_count'];
		}
		// クローズ
		mysql_close($link);	
	}
echo '終わり';
?>