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
		$now_count = 0;
		$count_sum = 5;
		///////////////
		//now_count取得
		///////////////
		$result = mysql_query('
			SELECT * 
			FROM article_html_cron 
			ORDER BY primary_id DESC 
			LIMIT 0, 1');
		while($row = mysql_fetch_assoc($result)) {
			$now_count = (int)$row['now_count'];
		}
		//////////////////////////////////
		//articleの1番新しいprimary_id取得
		//////////////////////////////////
		$result = mysql_query('
			SELECT * 
			FROM article
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
/*
		///////////////////
		//now_count繰り上げ
		///////////////////
		$result = mysql_query("
			INSERT INTO article_html_cron (
				now_count)
			VALUES ( 
				".$next_count.")");
*/
		////////////////////////////////////////////////////////////////////
		//
		////////////////////////////////////////////////////////////////////


pre_var_dump($now_count);
pre_var_dump($count_sum);
		// article取得
		$result = mysql_query("
			SELECT * 
			FROM article 
			ORDER BY primary_id ASC 
			LIMIT ".$now_count.", ".$count_sum."");



		while($row = mysql_fetch_assoc($result)) {
		pre_var_dump($row);
		}


/*
array(17) {
  ["primary_id"]=>
  string(3) "106"
  ["sharetube_id"]=>
  string(7) "mtoksuy"
  ["category"]=>
  string(30) "エンタメ・カルチャー"
  ["title"]=>
  string(75) "兄妹愛が綴られている感動ムービー。たった一人の妹へ"
  ["sub_text"]=>
  ["contents"]=>
  ["tag"]=>
  string(27) "兄妹　妹　愛　感動"
  ["original"]=>
  string(69) "泣ける感動ムービー 【仕打ち】 たった一人の妹へ "
  ["thumbnail_image"]=>
  string(7) "106.jpg"
  ["sp_thumbnail"]=>
  string(1) "1"
  ["link"]=>
  string(3) "106"
  ["matome_frg"]=>
  string(1) "0"
  ["random_key"]=>
  string(0) ""
  ["del"]=>
  string(1) "0"
  ["create_time"]=>
  string(19) "2014-02-25 16:23:56"
  ["update_time"]=>
  string(19) "2014-06-15 07:44:18"
}
*/

































		// クローズ
		mysql_close($link);	
	}
echo '成功';
?>