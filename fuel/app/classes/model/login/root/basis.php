<?php 

/**
 * Root関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_Root_Basis extends Model {
	//--------------------
	//全ユーザの記事を取得
	//--------------------
	public static function all_article_list_get() {
		$article_list_get_res = DB::query("
			SELECT * 
			FROM article
			WHERE del            = 0
			ORDER BY article.primary_id DESC
			LIMIT 0 , 500")->execute();
		return $article_list_get_res;
	}
	//----------------------
	//全ユーザー下書きを取得
	//----------------------
	public static function all_draft_article_list_get() {
		$draft_article_list_get_res = DB::query("
			SELECT * 
			FROM draft
			WHERE del = 0
			AND draft = 1
			ORDER BY draft.primary_id DESC
			LIMIT 0 , 500")->execute();
		return $draft_article_list_get_res;
	}
}
