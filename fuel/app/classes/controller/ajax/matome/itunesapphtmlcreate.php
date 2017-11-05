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
		$itunes_app_url      = $_POST['itunes_app_url'];
		$googlepalay_app_url = $_POST['googlepalay_app_url'];
		$description_check = $_POST['description_check'];
		$multi_app_check   = $_POST['multi_app_check'];

		header ("Content-Type: text/javascript; charset=utf-8");
		// iTunes_app_スクレイピング
		$itunes_app_data_array = Model_Login_Itunesappscraping_Basis::itunes_app_scraping($itunes_app_url);
		// アプリ からのスクレイピングなら
		if($multi_app_check) {
			// multi_app_html生成
			$itunes_app_html       = Model_Login_Itunesappscraping_Html::multi_app_html_create($itunes_app_data_array, $googlepalay_app_url);
			$app_html_name         = 'multi_app_html';
			$app_url_name          = 'multi_app_url';
			$app_data_array_name   = 'multi_app_data_array';
		}
			// 前の機能(使用中)
			else {
				// iTunes_app_html生成
				$itunes_app_html       = Model_Login_Itunesappscraping_Html::itunes_app_html_create($itunes_app_data_array, $description_check);
				$app_html_name         = 'itunes_app_html';
				$app_url_name          = 'itunes_app_url';
				$app_data_array_name   = 'itunes_app_data_array';
			}

		$json_data = array(
			$app_html_name       => $itunes_app_html,
			$app_url_name        => $itunes_app_url,
			$app_data_array_name => $itunes_app_data_array,
		);
		return json_encode($json_data);
	}
}