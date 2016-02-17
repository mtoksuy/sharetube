<?php 
/**
 * Postコントローラー
 * 
 * 記事リストを表示する機能
 * 
 * 
 */

class Controller_Login_Admin_Analytics extends Controller_Login_Template {
	// ルーター
	public function router($method, $params) {
		$limit_number = (int)$params[0];
		$new_articles = $params[1];
		$params       = (int)$params[0];
		$article_array_data = array();

		// 全体アナリティクス表示
		if($method == 'index') {
			return $this->action_index($article_array_data);
		}
			// limit設定アナリティクス表示
			else if($method == 'limit' && preg_match('/^[0-9]+$/', $limit_number)) {
				$article_array_data["new_articles"] = $new_articles;
				$article_array_data["limit_number"] = $limit_number;
				$article_array_data["limit"]        = true;
				return $this->action_index($article_array_data);
			}
				// 個別アナリティクス表示
				else if($method == 'article' && preg_match('/^[0-9]+$/',$params)) {
					// 記事データ取得
					$article_data_get_res = Model_Login_List_Edit_Basis::article_data_get($params);
					// $article_array_data生成
					foreach($article_data_get_res as $key => $value) {
						$article_array_data["primary_id"]      = $value["primary_id"];
						$article_array_data["sharetube_id"]    = $value["sharetube_id"];
						$article_array_data["category"]        = $value["category"];
						$article_array_data["title"]           = $value["title"];
						$article_array_data["sub_text"]        = $value["sub_text"];
						$article_array_data["tag"]             = $value["tag"];
						$article_array_data["thumbnail_image"] = $value["thumbnail_image"];
						$article_array_data["random_key"]      = $value["random_key"];
						$article_array_data["edit"]            = true;
					}
					// 書いた人チェック
					if($article_array_data["sharetube_id"] == $_SESSION["sharetube_id"] || $_SESSION["sharetube_id"] == 'mtoksuy') {
						return $this->action_index($article_array_data);
					}
			}
	}




	public function action_index($article_array_data) {
//		var_dump($article_array_data);
		// ログインチェック
		$login_check = Model_Login_Basis::login_check();
		if($login_check) {
			// viewテンプレート読み込み
			$this->login_admin_template            = View::forge('login/admin/template');
			$this->login_admin_template->view_data = array(
				'title'   => 'アナリティクス｜アドミン｜ログイン|'.TITLE,
				'content' => View::forge('login/admin/analytics/analytics'),
			);



			$analytics_data_array             = array();
			$analytics_day_data_array         = array();
			$analytics_day_article_data_array = array();
			$analytics_all_pv = 0;

			// limit
			if($article_array_data["limit"] == 'limit') {
				// 指定されたaccess_summary取得
						$access_summary_res = Model_Login_Analytics_Basis::article_limit_access_summary_get($article_array_data["limit_number"], $article_array_data["new_articles"]);
						$new_articles_messege = '';
						if($article_array_data["new_articles"] == 'new_articles') {
							$new_articles_messege = '[新着記事]';
						}
						$analytics_data_array["analytics_method"] = 'index';
						$analytics_data_array["analytics_title"]  = ''.$new_articles_messege.'過去'.$article_array_data["limit_number"].'日間のデータ';
			}
				// article
				else if($article_array_data["edit"] == true) {
					// 過去30日間のaccess_summary取得
					$access_summary_res = Model_Login_Analytics_Basis::article_access_summary_get($article_array_data["primary_id"], 30);
					$analytics_data_array["analytics_method"] = 'article';
					$analytics_data_array["analytics_title"]  = '記事：'.$article_array_data["title"].' 30日間のデータ';
				}
					// index
					else {
						// 過去30日間のaccess_summary取得
						$access_summary_res = Model_Login_Analytics_Basis::access_summary_get(30);
						$analytics_data_array["analytics_method"] = 'index';
						$analytics_data_array["analytics_title"]  = '過去30日間のデータ';
					}
			// 各部分を取得
			foreach($access_summary_res as $key => $value) {
				// all_count取得
				$analytics_all_pv = ($analytics_all_pv+(int)$value["count"]);
				// 日別のPV取得
				$analytics_day_data_array[$value["day"]]["count"] = $analytics_day_data_array[$value["day"]]["count"]+(int)$value["count"];
				// 記事別のpv取得
				$analytics_day_article_data_array[$value["article_id"]]["count"] = $analytics_day_article_data_array[$value["article_id"]]["count"]+(int)$value["count"];
			}
			//asort($analytics_day_article_data_array);
			// ソート クソ便利
			arsort($analytics_day_article_data_array);
			///////////////////////////////////
			// analytics_data_arrayにデータ挿入
			///////////////////////////////////
			$analytics_data_array["all_pv"]           = $analytics_all_pv;
			$analytics_data_array["day"]              = $analytics_day_data_array;
			$analytics_data_array["article_id"]       = $analytics_day_article_data_array;
			// title取得
			foreach($analytics_data_array["article_id"] as $key =>$value) {
				$title_res = DB::query("
					SELECT title 
					FROM article 
					WHERE primary_id = ".$key."")->execute();
				foreach($title_res as $key_2 => $value) {
					$analytics_data_array["article_id"][$key]["title"] = $value["title"];
				}
			}
			// コンテンツ挿入
			$this->login_admin_template->view_data["content"]->set('content_data',array(
				'content_html'   => $analytics_html,
				'analytics_data' => $analytics_data_array,
			),false);
			return $this->login_admin_template;
		}
			// ログインしていない場合
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	}
}