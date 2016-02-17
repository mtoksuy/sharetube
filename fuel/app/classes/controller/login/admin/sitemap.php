<?php 
/**
 * Sitemapコントローラー
 * 
 * Sitemap.xmlの情報を吐き出す機能
 * 
 * 
 */

class Controller_Login_Admin_Sitemap extends Controller_Login_Template {
	// 親のbefore実行
	public function before() {
		parent::before();
	}
	// アクションインデックス
	public function action_index() {
		$login_check = Model_Login_Basis::login_check();
		// ログインチェック
		if($login_check) {
			///////////////////
			//カテゴリarray生成
			///////////////////
			$category_array = array();
			$category_res = DB::query("
				SELECT * 
					FROM category_segment
					WHERE del = 0
					ORDER BY category_segment.order ASC")->execute();
			foreach($category_res as $key => $value) {
				$category_array[$key] = HTTP.$value["category_segment"].'/';
			}
			/////////////////////
			//アーカイブarray生成
			/////////////////////
		// アーカイブデータ取得
		list($first_article_res, $last_article_res) = Model_Archive_Basis::archive_first_last_data_get();
		// アーカイブHTML生成
		$archive_li_html = Model_Archive_Html::archive_list_html_create($first_article_res, $last_article_res);
		$pattern = '/href="(.+?)"/';
		preg_match_all($pattern,$archive_li_html,$archive_list_array);
//		var_dump($archive_list_array[1]);
			////////////////////////
			//ユーザーチャンネル生成
			////////////////////////
			$user_array         = array();
			$user_channel_array = array();
			$user_res = DB::query("
				SELECT * 
					FROM user
					WHERE all_page_view > 50
					ORDER BY all_page_view DESC")->execute();
			foreach($user_res as $key => $value) {
				$user_array[$key]         = $value["sharetube_id"];
				$user_channel_array[$key] = array(HTTP.'channel/'.$value["sharetube_id"].'/');
				// Sharetubeユーザーの書いた記事数を取得
				$article_count = Model_Info_Basis::sharetube_user_article_count_get($value["sharetube_id"]);
				// ページ数取得
				$page_number = ($article_count/10);
				// 端数切り捨て
				$page_number = (int)floor($page_number);
				for($i = 1;$i <= $page_number; $i++) {
					$user_channel_array[$key][$i] = $user_channel_array[$key][0].$i.'/';
				} // for($i = 1;$i <= $page_number; $i++) {
			}

			////////////
			//まとめ生成
			////////////
			$matome_array = array();
			$article_res = DB::query("
				SELECT * 
					FROM article
					WHERE del = 0
					ORDER BY primary_id DESC")->execute();
			foreach($article_res as $key => $value) {
				$matome_array[$key] = HTTP.'article/'.$value["link"].'/';
			}
//			var_dump($matome_array);
	//////////////////
	//category_loc生成
	//////////////////
	foreach($category_array as $key => $value) {
		$category_loc .= 
'<url>
  <loc>'.$value.'</loc>
  <priority>0.3</priority>
</url>
';
	}
	/////////////////
	//archive_loc生成
	/////////////////
	foreach($archive_list_array[1] as $key => $value) {
		$archive_loc .= 
'<url>
  <loc>'.$value.'</loc>
  <priority>0.3</priority>
</url>
';
	}
	//////////////////////
	//user_channel_loc生成
	//////////////////////
	foreach($user_channel_array as $key => $value) {
		foreach($value as $key_2 => $value_2) {
		$user_channel_loc .= 
'<url>
  <loc>'.$value_2.'</loc>
  <priority>0.3</priority>
</url>
';
		}
	}
	////////////////
	//matome_loc生成
	////////////////
	foreach($matome_array as $key => $value) {
		$matome_loc .= 
'<url>
  <loc>'.$value.'</loc>
  <priority>0.3</priority>
</url>
';
	}

$sitemap_xml = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<url>
  <loc>http://sharetube.jp/</loc>
  <priority>1.0</priority>
</url>
'.$category_loc.''.$archive_loc.'<url>
  <loc>http://sharetube.jp/about/</loc>
  <priority>0.3</priority>
</url>
<url>
  <loc>http://sharetube.jp/contact/</loc>
  <priority>0.3</priority>
</url>
<url>
  <loc>http://sharetube.jp/sitemap/</loc>
  <priority>0.3</priority>
</url>
<url>
  <loc>http://sharetube.jp/signup/</loc>
  <priority>0.3</priority>
</url>
<url>
  <loc>http://sharetube.jp/curatorrecruitment/</loc>
  <priority>0.3</priority>
</url>
<url>
  <loc>http://sharetube.jp/permalink/recruitment_ads.php</loc>
  <priority>0.3</priority>
</url>
<url>
  <loc>http://sharetube.jp/authorrecruiting/</loc>
  <priority>0.3</priority>
</url>
<url>
  <loc>http://sharetube.jp/permalink/ch_thread_design_1.php</loc>
  <priority>0.3</priority>
</url>
'.$user_channel_loc.''.$matome_loc.'</urlset>';


		// 改行コードをLFに置換
//		$rss = str_replace(array("\r\n","\r"), "\n", $rss);
		// 書き直すファイルパス
		$file = PATH.'sitemap.xml';
		// ファイルのデータ取得
		// $current = file_get_contents($file);
		// rssデータをファイルに書き出す
		file_put_contents($file, $sitemap_xml);

		} // if($login_check) {
			// ログインしてなかったらトップに飛ぶ
			else {
				header('Location: '.HTTP.'');
				exit;
			}
	} // public function action_index() {
}