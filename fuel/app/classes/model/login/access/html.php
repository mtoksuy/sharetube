<?php 
class Model_Login_Access_Html extends Model {
	//----------------
	//アクセスHTML生成
	//----------------
	static function article_access_html_create($article_access_res) {
		// 最新記事データ取得
		$article_latest_data_array = Model_Article_Basis::article_latest_get();
		$new_article_number = (int)$article_latest_data_array["primary_id"] -20;
		$new_article_text = '';
		foreach($article_access_res as $key => $value) {
			if($new_article_number < (int)$value["primary_id"]) {
				$new_article_text = '<span style="color: red;">new</span>';
			}
				else {
					$new_article_text = '';
				}
			$article_access_html .= '<p>'.$new_article_text.' <a href="'.HTTP.'article/'.$value["article_id"].'/" target="_blank">'.$value["title"].'</a> '.$value["COUNT(access.primary_id)"].' view</p>';
		}
		return $article_access_html;
	}
}
