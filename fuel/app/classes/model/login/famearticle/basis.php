<?php 

/**
 * 殿堂まとめ関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Famearticle_Basis extends Model {
	//--------------
	//殿堂まとめ登録
	//--------------
	public static function fame_article_array_register($fame_article_list_array) {
		foreach($fame_article_list_array as $key => $value) {
			// 重複検査
			$fame_article_res = DB::query("
				SELECT * 
				FROM fame_article
				WHERE article_id = '".$value."'")->cached(0)->execute();
			$res_value_check = false;
			foreach($fame_article_res as $res_key => $res_value) {
				$res_value_check = true;
			}
			// 殿堂まとめ登録
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
					fame_article (
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
}
