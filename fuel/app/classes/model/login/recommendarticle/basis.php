<?php 

/**
 * 注目まとめ関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Recommendarticle_Basis extends Model {
	//---------------------------------
	//注目まとめ追加するためのarray生成
	//---------------------------------
	public static function recommend_article_array_get($recommend_article_list) {
		// 改行コード\nへ変換
		$recommend_article_list = str_replace("\r\n", "\n", $recommend_article_list);
		$recommend_article_list = str_replace("\r", "\n", $recommend_article_list);
		$recommend_article_list = str_replace(" ", "\n", $recommend_article_list);
		$recommend_article_list = str_replace("　", "\n", $recommend_article_list);
		$recommend_article_list = str_replace(",", "\n", $recommend_article_list);
		$recommend_article_list = str_replace("、", "\n", $recommend_article_list);
		// 末に改行を追加
		$recommend_article_list .= "\n";
//		var_dump($recommend_article_list);
		// httpを削除
		$pattern = '/http:\/\/sharetube.jp\/article\//';
		$recommend_article_list = preg_replace($pattern, '', $recommend_article_list);
		// スラッシュを削除
		$pattern = '/\//';
		$recommend_article_list = preg_replace($pattern, '', $recommend_article_list);
		// まとめidを取得
		$pattern = '/[0-9]+\n/';
		preg_match_all($pattern, $recommend_article_list, $recommend_article_list_array);
		$recommend_article_list_array = $recommend_article_list_array[0];
		return $recommend_article_list_array;
	}
	//--------------
	//注目まとめ登録
	//--------------
	public static function recommend_article_array_register($recommend_article_list_array) {
		foreach($recommend_article_list_array as $key => $value) {
			// 重複検査
			$recommend_article_res = DB::query("
				SELECT * 
				FROM recommend_article
				WHERE article_id = '".$value."'")->cached(0)->execute();
			$res_value_check = false;
			foreach($recommend_article_res as $res_key => $res_value) {
				$res_value_check = true;
			}
			// 注目まとめ登録
			if($res_value_check == false) {
				$article_res = DB::query("
					SELECT sharetube_id
					FROM article
					WHERE primary_id = ".(int)$value."")->execute();
				foreach($article_res as $key_2 => $value_2) {
					$sharetube_id = $value_2['sharetube_id'];
				}
				DB::query("
					INSERT INTO 
					recommend_article (
						sharetube_id,
						article_id,
						del
					)
					VALUES (
						'".$sharetube_id."', 
						".(int)$value.",
						0
					)
				")->execute();
			}
		}
	}

/*
ランキングsql
SELECT sharetube_id, SUM(1) AS sum
FROM fame_article
GROUP BY sharetube_id
ORDER BY sum DESC
*/

}
