<?php 
class Model_Login_List_Edit_Basis extends Model {
	//--------------
	//記事データ取得
	//--------------
	static function article_data_get($article_id) {
		$article_data_get_res = DB::query("
			SELECT *
			FROM article
			WHERE primary_id = ".$article_id."
			AND del            = 0")->execute();
		return $article_data_get_res;
	}
	//--------
	//記事編集
	//--------
	static function article_edit($post) {
//		var_dump($post);
		// 変数群
		$sharetube_id = $_SESSION["sharetube_id"];
		$category     = $post["category"];
		$title        = $post["title"];
		$sub_text     = htmlspecialchars_decode($post["sub_text"], ENT_COMPAT);
		$contents     = htmlspecialchars_decode($post["contents"], ENT_COMPAT);
		$text         = htmlspecialchars_decode($post["text"], ENT_COMPAT);
		$tag          = $post["tag"];
		$original     = $post["original"];
		$article_id   = $post["article_id"];
		$sp_thumbnail = (int)$post["sp_thumbnail"];
		$article_type = $post["article_type"];

		// 削除array
		$del_r_array = array("'");
		// 不要文字置換
		$sub_text = str_replace($del_r_array, '"', $sub_text);
		$contents = str_replace($del_r_array, '"', $contents);
		$text     = str_replace($del_r_array, '"', $text);

		// 時間
		$now_time          = time();
		$now_date          = date('Y-m-d', $now_time);
		$create_date       = date('Y-m-d H:i:s', $now_time);
		$article_year_time = date('Y', $now_time);

		// path取得
		$res = DB::query("
			SELECT COUNT(primary_id)
			FROM ".$article_type."")->execute();
		foreach($res as $key => $value) {
			$path = (int)$value["COUNT(primary_id)"];
			$path++;
		}
		// 記事のパス
		$link = ($path);
		// カテゴリー情報取得
//		$category_info_array = Model_Info_Basis::category_info_get($category);
//		var_dump($category_info_array);

		// 記事編集
		DB::query("
		UPDATE ".$article_type."
		SET 
			category       = '".$category."', 
			title          = '".$title."', 
			sub_text       = '".$sub_text."', 
			contents       = '".$contents."', 
			text           = '".$text."', 
			tag            = '".$tag."', 
			original       = '".$original."',
			sp_thumbnail   = ".$sp_thumbnail.", 
			update_time    = '".$create_date."'
		WHERE primary_id = ".$article_id."")->execute();
	}
	//--------------
	//まとめ記事編集
	//--------------
	static function matome_article_edit($post) {
		// 変数群
		$sharetube_id    = $_SESSION["sharetube_id"];
		$article_id      = (int)$post["link"];
		$title           = $post["title"];
		$category        = $post["category"];
//		$sub_text        = htmlspecialchars_decode($post["sub_text"], ENT_COMPAT);
		$sub_text        = $post["sub_text"];
		$contents        = htmlspecialchars_decode($post["contents"], ENT_COMPAT);
		$text            = htmlspecialchars_decode($post["text"], ENT_COMPAT);
		$tag             = $post["tag"];
		$original        = $post["original"];
		$sp_thumbnail    = (int)$post["sp_thumbnail"];
		$thumbnail_image = $post["thumbnail_image"];
		$random_key      = $post["random_key"];
		$article_type    = $post["article_type"];
		// 削除array
		$del_r_array = array("'");
		// 不要文字置換
		$sub_text = str_replace($del_r_array, '"', $sub_text);
		$contents = str_replace($del_r_array, '"', $contents);
		$text     = str_replace($del_r_array, '"', $text);

		// 時間
		$now_time          = time();
		$now_date          = date('Y-m-d', $now_time);
		$create_date       = date('Y-m-d H:i:s', $now_time);
		$article_year_time = date('Y', $now_time);

		// 記事編集
		DB::query("
		UPDATE ".$article_type."
		SET 
			category        = '".$category."', 
			title           = '".$title."', 
			sub_text        = '".$sub_text."', 
			contents        = '".$contents."', 
			text            = '".$text."', 
			tag             = '".$tag."', 
			original        = '".$original."',
			thumbnail_image = '".$thumbnail_image."',
			sp_thumbnail    = ".(int)$sp_thumbnail.", 
			random_key      = '".$random_key."', 
			update_time     = '".$create_date."'
		WHERE primary_id  = ".$article_id."")->execute();
	}
}