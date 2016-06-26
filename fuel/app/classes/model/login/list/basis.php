<?php 

/**
 * リスト関連のクラス
 * 
 * 
 * 
 * 
 */

class Model_Login_List_Basis extends Model {
	//----------------------
	//自分が書いた記事を取得
	//----------------------
	static function article_list_get() {
		$article_list_get_res = DB::query("
			SELECT *
			FROM article
			WHERE sharetube_id = '".$_SESSION["sharetube_id"]."'
			AND del            = 0
			ORDER BY article.primary_id DESC
			LIMIT 0 , 500")->execute();
		return $article_list_get_res;
	}
	//----------
	//記事を削除
	//----------
	public static function article_delete($method) {
		// まとめ削除
		$article_list_get_res = DB::query("
			UPDATE article 
			SET del = 1
			WHERE primary_id = ".$method."")->execute();
		// 注目まとめ削除
		$article_list_get_res = DB::query("
			UPDATE recommend_article 
			SET del = 1
			WHERE article_id = ".$method."")->execute();
	}
}
