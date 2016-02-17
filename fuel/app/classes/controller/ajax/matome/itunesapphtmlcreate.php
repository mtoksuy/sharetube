<?php
/*
* Ajax まとめ iTunesApp_HTML生成コントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Itunesapphtmlcreate extends Controller {
	// アクション
	public function action_index() {
		// セッションスタート
		session_start();
		// 変数
		$itunes_app_url    = $_POST['itunes_app_url'];
		$description_check = $_POST['description_check'];


		header ("Content-Type: text/javascript; charset=utf-8");
		// iTunes_app_スクレイピング
		$itunes_app_data_array = Model_Login_Itunesappscraping_Basis::itunes_app_scraping($itunes_app_url);
		// iTunes_app_html生成
		$itunes_app_html       = Model_Login_Itunesappscraping_Html::itunes_app_html_create($itunes_app_data_array, $description_check);

		$json_data = array(
			'itunes_app_html'       => $itunes_app_html,
			'itunes_app_url'        => $itunes_app_url,
			'itunes_app_data_array' => $itunes_app_data_array,
		);
		return json_encode($json_data);
	}
}