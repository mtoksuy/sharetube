<?php
/*
* Ajax まとめ Amazon_HTML生成コントローラー
* 
* 
* 
*/
class Controller_Ajax_Matome_Amazonhtmlcreate extends Controller {
	// アクション
	public function action_index() {
		// セッションスタート
		session_start();
		$amazon_url = $_POST['amazon_url'];
		header ("Content-Type: text/javascript; charset=utf-8");

		// amazon_data_array取得
		$amazon_data_array = Model_Login_Amazonscraping_Basis::amazon_scraping($amazon_url);
		// アマゾンHTML生成
		$amazon_html = Model_Login_Amazonscraping_Html::amazon_html_create($amazon_data_array);
		if($amazon_html) {
			$check = true;
		}
			else {
				$check = false;
			}

		// json_data
		$json_data = array(
					'amazon_html'       => $amazon_html,
					'amazon_data_array' => $amazon_data_array,
					'amazon_url'        => $amazon_url,
					'check'             => $check,
		);
		return json_encode($json_data);
	}
}