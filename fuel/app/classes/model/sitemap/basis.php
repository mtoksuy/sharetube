<?php 
class Model_Sitemap_Basis extends Model {
	//----------------------
	//サイトマップリスト取得
	//----------------------
	static function sitemap_list_get() {
		// 後で使うarray
		$category_array = array();
		// カテゴリーリスト取得
		$category_list_query = DB::query("
			SELECT * 
			FROM category_segment
			WHERE del = 0
			ORDER BY category_segment.order ASC")->cached(86400)->execute();
		// カテゴリーarray生成
		foreach($category_list_query as $key => $value) {
			$category_array[$key]["category_name"]    = $value["category_name"];
			$category_array[$key]["category_segment"] = $value["category_segment"];
			$category_array[$key]["category_color"]   = $value["category_color"];
			$category_array[$key]["order"]            = $value["order"];
		}
		// カテゴリー毎の記事リストを生成
		$category_article_list_query = array();
		foreach($category_array as $key => $value) {
			$category_article_list_query[$key] = DB::query("
				SELECT *
				FROM article
				WHERE del = 0
				AND category = '".$value["category_name"]."'
				ORDER BY article.primary_id DESC")->cached(86400)->execute();
		}
		// カテゴリー毎のarray合体
		foreach($category_article_list_query as $key_1 => $value_1) {
			foreach($category_article_list_query[$key_1] as $key_2 => $value_2) {
				$category_array[$key_1][$key_2] = $value_2;
			}
		}
		// 変数の名前変更()
		$category_all_article_array = $category_array;
		return $category_all_article_array;
	}
}