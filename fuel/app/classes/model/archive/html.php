<?php
/*
* 
* 記事HTML関連クラス
* 
* 
* 
*/

class Model_Archive_Html extends Model {
	//------------------
	//アーカイブHTML生成
	//------------------
	static function archive_list_html_create($first_article_res, $last_article_res) {
		// 初めての記事データ取得
		foreach($first_article_res as $key => $value) {
			$first_article_create_time = $value["create_time"];
		}
		// 最後の記事データ取得
		foreach($last_article_res as $key => $value) {
			$last_article_create_time = $value["create_time"];
		}
		// 現在の時間取得
		$now_time = date("Y-m-d");
		$pattern  = '/ ([0-9]{2}:)([0-9]{2}:)([0-9]{2})/';
		// 置換（2014-01-09）
		$first_article_create_time_replace = preg_replace($pattern, '', $first_article_create_time);
		// 半角空白削除
		$first_article_create_time_replace = trim($first_article_create_time_replace);
		
		// 置換（2014-07-12）
		$last_article_create_time_replace = preg_replace($pattern, '', $last_article_create_time);
		// 半角空白削除
		$last_article_create_time_replace = trim($last_article_create_time_replace);
		
		
		$pattern = '/(-[0-9]{2})(-[0-9]{2}) ([0-9]{2}:)([0-9]{2}:)([0-9]{2})/';
		// 置換（年取得）
		$first_article_create_time_year_replace = preg_replace($pattern, '', $first_article_create_time);
		// 半角空白削除
		$first_article_create_time_year_replace = trim($first_article_create_time_year_replace);
		
		$pattern = '/ ([0-9]{2}:)([0-9]{2}:)([0-9]{2})/';
		// 置換（年取得）
		$first_article_create_time_month_replace = preg_replace($pattern, '', $first_article_create_time);
		// 半角空白削除
		$first_article_create_time_month_replace = trim($first_article_create_time_month_replace);
		// 後ろから三文字削除
		$user_ids = substr($first_article_create_time_month_replace, 0, -3);
		// 後ろから2文字だけ抜き取り
		$str = substr($user_ids, -2);
		//var_dump($str);
		
		// archive_start_array生成
		$archive_start_array = array('year' => (int)$first_article_create_time_year_replace, 'month' => $str);
		//var_dump($archive_start_array);
		
		// 最初と最後の記事の時間だけのunixtime取得
		$delta_unix_time = strtotime($last_article_create_time_replace) - strtotime($first_article_create_time_replace);
		// アーカイブの月分取得
		$floor_num       = ($delta_unix_time / 86400) / 30;
		$archive_int_num = floor($floor_num); // 切捨て
		$archive_li_html_array = array();
		
		// アーカイブHTML生成
		while($archive_int_num > 0) {
			if($archive_start_array["month"] == 12) {
				 $archive_start_array["year"]++;
				 $archive_start_array["month"] = 1;
			}
				else {
					$archive_start_array["month"]++;
				}
		//	var_dump( $archive_start_array);
		
		
			if($archive_start_array["month"] >= 10) {
				$month = (string)$archive_start_array["month"];
			}
				else {
					$month = "0".(string)$archive_start_array["month"];
				}
			// アーカイブ月の記事数を取得
			$archive_article_num = Model_Info_Basis::archive_article_num_get($archive_start_array["year"], $month);
			// アーカイブHTMLarray生成
			$archive_li_html_array[$archive_int_num] = 
					('<li><a href="'.Uri::base().'archive/'.$archive_start_array["year"].'/'.$archive_start_array["month"].'/">'.$archive_start_array["year"].'年'.$month.'月（'.$archive_article_num.'）</a></li>');;
			$archive_int_num--;
		} // while($archive_int_num > 0) {
			// ここでarrayを逆ソートし直す
		ksort($archive_li_html_array);
		// アーカイブHTML生成
		foreach($archive_li_html_array as $key => $value) {
			$archive_li_html .= $value;
		}
		return $archive_li_html;
	}
}